<?php
/**
 * Plugin Name: Breathein Customer Authentication
 * Description: Separate customer login sessions and customer records for the Breathein website account area.
 * Version: 1.2.0
 * Author: Breathein
 * Requires PHP: 7.4
 *
 * @package BreatheinCustomerAuth
 */

defined('ABSPATH') || exit;

const BREATHEIN_CUSTOMER_AUTH_VERSION = '1.2.0';
const BREATHEIN_CUSTOMER_SESSION_COOKIE = 'breathein_customer_session';

/**
 * Customer and session table names.
 */
function breathein_customer_table(): string
{
    global $wpdb;

    return $wpdb->prefix . 'breathein_customers';
}

function breathein_customer_sessions_table(): string
{
    global $wpdb;

    return $wpdb->prefix . 'breathein_customer_sessions';
}

/**
 * Create the dedicated customer tables.
 */
function breathein_customer_install(): void
{
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();
    $customers_table = breathein_customer_table();
    $sessions_table = breathein_customer_sessions_table();

    $customers_sql = "CREATE TABLE {$customers_table} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        wp_user_id bigint(20) unsigned NOT NULL DEFAULT 0,
        first_name varchar(100) NOT NULL DEFAULT '',
        last_name varchar(100) NOT NULL DEFAULT '',
        email varchar(190) NOT NULL,
        phone varchar(40) NOT NULL DEFAULT '',
        date_of_birth date NULL,
        password_hash varchar(255) NOT NULL,
        password_changed_at datetime NULL,
        order_updates tinyint(1) NOT NULL DEFAULT 1,
        promotions tinyint(1) NOT NULL DEFAULT 0,
        air_quality_alerts tinyint(1) NOT NULL DEFAULT 1,
        status varchar(20) NOT NULL DEFAULT 'active',
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        last_login_at datetime NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY email (email),
        UNIQUE KEY wp_user_id (wp_user_id),
        KEY status (status)
    ) {$charset_collate};";

    $sessions_sql = "CREATE TABLE {$sessions_table} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        customer_id bigint(20) unsigned NOT NULL,
        token_hash char(64) NOT NULL,
        expires_at datetime NOT NULL,
        created_at datetime NOT NULL,
        last_seen_at datetime NOT NULL,
        ip_address varchar(45) NOT NULL DEFAULT '',
        user_agent text NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY token_hash (token_hash),
        KEY customer_id (customer_id),
        KEY expires_at (expires_at)
    ) {$charset_collate};";

    dbDelta($customers_sql);
    dbDelta($sessions_sql);

    update_option('breathein_customer_auth_version', BREATHEIN_CUSTOMER_AUTH_VERSION, false);
    breathein_customer_migrate_existing_customers();
}

register_activation_hook(__FILE__, 'breathein_customer_install');

add_action('init', static function (): void {
    if (BREATHEIN_CUSTOMER_AUTH_VERSION !== get_option('breathein_customer_auth_version')) {
        breathein_customer_install();
    }
}, 0);

/**
 * Import existing WooCommerce customer-role users into the dedicated table.
 * Their existing WordPress password hash is retained as a migration fallback.
 */
function breathein_customer_migrate_existing_customers(): void
{
    global $wpdb;

    $customers_table = breathein_customer_table();
    $customer_users = get_users([
        'role'   => 'customer',
        'fields' => 'all',
        'number' => -1,
    ]);

    foreach ($customer_users as $user) {
        $email = strtolower(sanitize_email($user->user_email));

        if (!$email || !$user->ID || !$user->user_pass) {
            continue;
        }

        $already_imported = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT id FROM {$customers_table} WHERE email = %s OR wp_user_id = %d LIMIT 1",
                $email,
                (int) $user->ID
            )
        );

        if ($already_imported) {
            continue;
        }

        $now = current_time('mysql', true);
        $wpdb->insert(
            $customers_table,
            [
                'wp_user_id'   => (int) $user->ID,
                'first_name'   => sanitize_text_field($user->first_name),
                'last_name'    => sanitize_text_field($user->last_name),
                'email'        => $email,
                'password_hash' => $user->user_pass,
                'status'       => 'active',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            ['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
        );
    }
}

/**
 * Return the current customer row for the custom session cookie.
 */
function breathein_customer_current(): ?object
{
    static $loaded = false;
    static $customer = null;
    global $wpdb;

    if ($loaded) {
        return $customer;
    }

    $loaded = true;
    $token = isset($_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE])
        ? sanitize_text_field(wp_unslash($_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE]))
        : '';

    if (!$token || !preg_match('/^[a-f0-9]{64}$/', $token)) {
        return null;
    }

    $now = gmdate('Y-m-d H:i:s');
    $token_hash = hash('sha256', $token);
    $sessions_table = breathein_customer_sessions_table();
    $customers_table = breathein_customer_table();

    $customer = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT c.* FROM {$customers_table} c INNER JOIN {$sessions_table} s ON s.customer_id = c.id WHERE s.token_hash = %s AND s.expires_at > %s AND c.status = 'active' LIMIT 1",
            $token_hash,
            $now
        )
    );

    if (!$customer) {
        breathein_customer_clear_cookie();
        return null;
    }

    $wpdb->update(
        $sessions_table,
        ['last_seen_at' => $now],
        ['token_hash' => $token_hash],
        ['%s'],
        ['%s']
    );

    return $customer;
}

/**
 * Return the address type currently marked as the dashboard default.
 * WooCommerce stores billing and shipping independently; this preference is
 * used by the customer dashboard to show one of them as the default card.
 */
function breathein_customer_default_address_type(?int $user_id = null): string
{
    $user_id = $user_id ?: get_current_user_id();

    if (!$user_id) {
        return '';
    }

    $type = sanitize_key((string) get_user_meta($user_id, 'breathein_default_address_type', true));

    $customer = class_exists('WC_Customer')
        ? new WC_Customer($user_id)
        : null;

    if (in_array($type, ['billing', 'shipping'], true)) {
        $method = 'get_' . $type . '_address_1';

        if (!$customer || (method_exists($customer, $method) && trim((string) $customer->{$method}()))) {
            return $type;
        }
    }

    if ($customer) {
        if (trim((string) $customer->get_billing_address_1())) {
            return 'billing';
        }

        if (trim((string) $customer->get_shipping_address_1())) {
            return 'shipping';
        }
    }

    return '';
}

/**
 * Keep WooCommerce's session customer in sync with the database customer.
 * The session customer can otherwise continue displaying the old address
 * after the edit form has saved the new user meta values.
 */
function breathein_customer_sync_wc_session(int $user_id): void
{
    if (
        !function_exists('WC')
        || !WC()->customer instanceof WC_Customer
        || $user_id !== get_current_user_id()
    ) {
        return;
    }

    $database_customer = new WC_Customer($user_id);
    $session_props = [];

    foreach (['billing', 'shipping'] as $type) {
        foreach (['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone', 'email'] as $field) {
            $method = 'get_' . $type . '_' . $field;

            if (method_exists($database_customer, $method)) {
                $session_props[$type . '_' . $field] = $database_customer->{$method}('edit');
            }
        }
    }

    if ($session_props) {
        WC()->customer->set_props($session_props);
        WC()->customer->save();
    }
}

/**
 * Preserve the updated address in WooCommerce's current session after the
 * native billing/shipping edit form saves the database values.
 */
add_action('woocommerce_customer_save_address', static function (int $user_id, string $address_type): void {
    breathein_customer_sync_wc_session($user_id);

    if (!breathein_customer_default_address_type($user_id)) {
        $customer = new WC_Customer($user_id);

        if (trim((string) $customer->{'get_' . $address_type . '_address_1'}())) {
            update_user_meta($user_id, 'breathein_default_address_type', $address_type);
        }
    }
}, 20, 2);

/**
 * Handle dashboard Set Default and Remove actions.
 */
function breathein_customer_process_address_action(): void
{
    if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'] ?? '')) {
        return;
    }

    $action = isset($_POST['breathein_address_action'])
        ? sanitize_key(wp_unslash($_POST['breathein_address_action']))
        : '';
    $address_type = isset($_POST['breathein_address_type'])
        ? sanitize_key(wp_unslash($_POST['breathein_address_type']))
        : '';

    if (!in_array($action, ['set_default', 'remove'], true) || !in_array($address_type, ['billing', 'shipping'], true)) {
        return;
    }

    $nonce = isset($_POST['breathein_address_nonce'])
        ? sanitize_text_field(wp_unslash($_POST['breathein_address_nonce']))
        : '';

    if (!wp_verify_nonce($nonce, 'breathein_address_action')) {
        wc_add_notice(__('Your address action has expired. Please try again.', 'breathein'), 'error');
        return;
    }

    $user_id = get_current_user_id();

    if (!$user_id || !class_exists('WC_Customer')) {
        return;
    }

    $customer = new WC_Customer($user_id);
    $address_method = 'get_' . $address_type . '_address_1';
    $has_address = method_exists($customer, $address_method)
        && trim((string) $customer->{$address_method}());

    if ('set_default' === $action) {
        if (!$has_address) {
            wc_add_notice(__('Add this address before setting it as default.', 'breathein'), 'error');
        } else {
            update_user_meta($user_id, 'breathein_default_address_type', $address_type);
            wc_add_notice(__('Default address updated.', 'breathein'), 'success');
        }
    } else {
        $props = [];

        foreach (['company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone'] as $field) {
            $props[$address_type . '_' . $field] = '';
        }

        $customer->set_props($props);
        $customer->save();
        breathein_customer_sync_wc_session($user_id);

        if (breathein_customer_default_address_type() === $address_type) {
            $other_type = 'billing' === $address_type ? 'shipping' : 'billing';
            $other_method = 'get_' . $other_type . '_address_1';
            $other_has_address = trim((string) $customer->{$other_method}());

            if ($other_has_address) {
                update_user_meta($user_id, 'breathein_default_address_type', $other_type);
            } else {
                delete_user_meta($user_id, 'breathein_default_address_type');
            }
        }

        wc_add_notice(__('Address removed.', 'breathein'), 'success');
    }

    wp_safe_redirect(wc_get_endpoint_url('edit-address', '', wc_get_page_permalink('myaccount')));
    exit;
}

add_action('template_redirect', 'breathein_customer_process_address_action', 20);

/**
 * Hydrate the WooCommerce-compatible shadow user only on frontend requests.
 * The WordPress admin request keeps using its normal WordPress session.
 */
add_action('init', static function (): void {
    /*
     * WooCommerce's frontend ?wc-ajax=... requests define DOING_AJAX, but
     * they still need the customer identity that was used to render the
     * checkout page. Skipping all AJAX requests makes the checkout nonce
     * invalid because the request falls back to a guest user.
     *
     * Keep the normal WordPress admin (including admin-ajax.php) isolated;
     * frontend WooCommerce AJAX requests are allowed to use the shadow user
     * for this request only. No WordPress admin login cookie is created.
     */
    if (is_admin()) {
        return;
    }

    $customer = breathein_customer_current();

    if (!$customer || empty($customer->wp_user_id)) {
        return;
    }

    $shadow_user = get_user_by('id', (int) $customer->wp_user_id);

    if (!$shadow_user || user_can($shadow_user, 'manage_options')) {
        return;
    }

    wp_set_current_user((int) $shadow_user->ID);
}, 1);

/**
 * Never display the WordPress admin bar for a custom-session customer.
 */
add_filter('show_admin_bar', static function (bool $show): bool {
    return breathein_customer_current() ? false : $show;
});

function breathein_customer_is_logged_in(): bool
{
    return (bool) breathein_customer_current();
}

/**
 * Customer session helpers.
 */
function breathein_customer_cookie_args(int $expires): array
{
    return [
        'expires'  => $expires,
        'path'     => defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/',
        'domain'   => defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '',
        'secure'   => is_ssl(),
        'httponly' => true,
        'samesite' => 'Lax',
    ];
}

function breathein_customer_set_session(int $customer_id, bool $remember = true): bool
{
    global $wpdb;

    try {
        $token = bin2hex(random_bytes(32));
    } catch (Throwable $exception) {
        return false;
    }

    $now = time();
    $expires = $now + ($remember ? MONTH_IN_SECONDS : 2 * HOUR_IN_SECONDS);
    $now_mysql = gmdate('Y-m-d H:i:s', $now);
    $expires_mysql = gmdate('Y-m-d H:i:s', $expires);

    $inserted = $wpdb->insert(
        breathein_customer_sessions_table(),
        [
            'customer_id' => $customer_id,
            'token_hash'  => hash('sha256', $token),
            'expires_at'  => $expires_mysql,
            'created_at'  => $now_mysql,
            'last_seen_at' => $now_mysql,
            'ip_address'  => sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? '')),
            'user_agent'  => sanitize_textarea_field(wp_unslash($_SERVER['HTTP_USER_AGENT'] ?? '')),
        ],
        ['%d', '%s', '%s', '%s', '%s', '%s', '%s']
    );

    if (!$inserted) {
        return false;
    }

    setcookie(
        BREATHEIN_CUSTOMER_SESSION_COOKIE,
        $token,
        breathein_customer_cookie_args($expires)
    );
    $_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE] = $token;

    return true;
}

function breathein_customer_clear_cookie(): void
{
    if (isset($_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE])) {
        setcookie(
            BREATHEIN_CUSTOMER_SESSION_COOKIE,
            '',
            breathein_customer_cookie_args(time() - HOUR_IN_SECONDS)
        );
        unset($_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE]);
    }
}

function breathein_customer_destroy_session(): void
{
    global $wpdb;

    $token = isset($_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE])
        ? sanitize_text_field(wp_unslash($_COOKIE[BREATHEIN_CUSTOMER_SESSION_COOKIE]))
        : '';

    if ($token) {
        $wpdb->delete(
            breathein_customer_sessions_table(),
            ['token_hash' => hash('sha256', $token)],
            ['%s']
        );
    }

    breathein_customer_clear_cookie();
}

function breathein_customer_logout_url(): string
{
    $url = function_exists('wc_get_page_permalink')
        ? wc_get_page_permalink('myaccount')
        : home_url('/my-account/');

    return wp_nonce_url(
        add_query_arg('breathein_customer_logout', '1', $url),
        'breathein_customer_logout'
    );
}

add_action('wp_loaded', static function (): void {
    if (!isset($_GET['breathein_customer_logout'])) {
        return;
    }

    $nonce = isset($_GET['_wpnonce'])
        ? sanitize_text_field(wp_unslash($_GET['_wpnonce']))
        : '';

    if (!wp_verify_nonce($nonce, 'breathein_customer_logout')) {
        wp_die(esc_html__('The logout link has expired. Please try again.', 'breathein'));
    }

    breathein_customer_destroy_session();
    wp_safe_redirect(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'));
    exit;
});

/**
 * Authentication form processing.
 */
function breathein_customer_notice(string $message, string $type = 'error'): void
{
    $GLOBALS['breathein_customer_auth_notice'] = [
        'message' => $message,
        'type'    => $type,
    ];
}

function breathein_customer_admin_user($user): bool
{
    if (!$user instanceof WP_User || !$user->exists()) {
        return false;
    }

    return user_can($user, 'manage_options') || user_can($user, 'edit_users');
}

function breathein_customer_process_auth(): void
{
    if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'] ?? '')) {
        return;
    }

    $action = isset($_POST['breathein_customer_action'])
        ? sanitize_key(wp_unslash($_POST['breathein_customer_action']))
        : '';

    if (!in_array($action, ['login', 'register'], true)) {
        return;
    }

    $nonce = isset($_POST['breathein_customer_nonce'])
        ? sanitize_text_field(wp_unslash($_POST['breathein_customer_nonce']))
        : '';

    if (!wp_verify_nonce($nonce, 'breathein_customer_' . $action)) {
        breathein_customer_notice(__('Your session expired. Please try again.', 'breathein'));
        return;
    }

    if ('login' === $action) {
        breathein_customer_process_login();
        return;
    }

    breathein_customer_process_registration();
}

add_action('wp_loaded', 'breathein_customer_process_auth', 20);

/* Keep profile fields in the shadow WooCommerce user and the separate
 * customer record aligned when a customer edits their account details. */
add_action('woocommerce_save_account_details', static function (int $user_id): void {
    global $wpdb;

    $customer = breathein_customer_current();

    if (!$customer || (int) $customer->wp_user_id !== $user_id) {
        return;
    }

    $user = get_user_by('id', $user_id);

    if (!$user) {
        return;
    }

    $wpdb->update(
        breathein_customer_table(),
        [
            'first_name'    => sanitize_text_field($user->first_name),
            'last_name'     => sanitize_text_field($user->last_name),
            'email'         => strtolower(sanitize_email($user->user_email)),
            'updated_at'    => gmdate('Y-m-d H:i:s'),
        ],
        ['id' => (int) $customer->id],
        ['%s', '%s', '%s', '%s'],
        ['%d']
    );
});

/**
 * Return the customer dashboard settings endpoint.
 */
function breathein_customer_settings_url(): string
{
    return function_exists('wc_get_endpoint_url')
        ? wc_get_endpoint_url('edit-account', '', wc_get_page_permalink('myaccount'))
        : home_url('/my-account/edit-account/');
}

/**
 * Add a settings notice through WooCommerce's account notice system.
 */
function breathein_customer_settings_notice(string $message, string $type = 'error'): void
{
    if (function_exists('wc_add_notice')) {
        wc_add_notice($message, $type);
        return;
    }

    breathein_customer_notice($message, $type);
}

/**
 * Remove WooCommerce records owned by a customer before deleting the linked
 * WordPress shadow user. This is intentionally a permanent deletion because
 * the Settings page promises that account data can be deleted by the user.
 */
function breathein_customer_delete_owned_records(int $user_id, string $email): bool
{
    global $wpdb;

    try {
        if (function_exists('wc_get_orders') && function_exists('wc_get_order')) {
            $order_ids = [];

            foreach (
                [
                    ['customer_id' => $user_id],
                    ['billing_email' => $email],
                ] as $query
            ) {
                $query['limit'] = -1;
                $query['return'] = 'ids';

                foreach ((array) wc_get_orders($query) as $order_id) {
                    $order_ids[(int) $order_id] = true;
                }
            }

            foreach (array_keys($order_ids) as $order_id) {
                $order = wc_get_order($order_id);

                if ($order && !$order->delete(true)) {
                    return false;
                }
            }
        }

        if (class_exists('WC_Payment_Tokens')) {
            foreach (WC_Payment_Tokens::get_tokens(['user_id' => $user_id]) as $token) {
                WC_Payment_Tokens::delete($token->get_id());
            }
        }

        if (class_exists('WC_Data_Store')) {
            $download_data_store = WC_Data_Store::load('customer-download');

            if (is_object($download_data_store)) {
                $download_data_store->delete_by_user_id($user_id);
                $download_data_store->delete_by_user_email($email);
            }
        }

        if (function_exists('wp_delete_comment')) {
            $comment_ids = $wpdb->get_col(
                $wpdb->prepare(
                    "SELECT comment_ID FROM {$wpdb->comments} WHERE user_id = %d",
                    $user_id
                )
            );

            foreach ($comment_ids as $comment_id) {
                wp_delete_comment((int) $comment_id, true);
            }
        }
    } catch (Throwable $exception) {
        return false;
    }

    return true;
}

/**
 * Process the customer dashboard Settings page.
 *
 * Profile and preference data is stored in the dedicated customer table.
 * The linked WooCommerce shadow user is updated only to keep checkout and
 * address fields working; it is never used as the customer login account.
 */
function breathein_customer_process_settings(): void
{
    if (
        is_admin()
        || 'POST' !== strtoupper($_SERVER['REQUEST_METHOD'] ?? '')
        || !isset($_POST['breathein_settings_action'])
    ) {
        return;
    }

    $action = sanitize_key(wp_unslash($_POST['breathein_settings_action']));

    if (!in_array($action, ['profile', 'password', 'notification', 'delete'], true)) {
        return;
    }

    $customer = breathein_customer_current();

    if (!$customer || empty($customer->wp_user_id)) {
        return;
    }

    $nonce = isset($_POST['breathein_settings_nonce'])
        ? sanitize_text_field(wp_unslash($_POST['breathein_settings_nonce']))
        : '';

    if (!wp_verify_nonce($nonce, 'breathein_settings')) {
        breathein_customer_settings_notice(__('Your settings session has expired. Please try again.', 'breathein'));
        return;
    }

    global $wpdb;

    $user_id = (int) $customer->wp_user_id;
    $user = get_user_by('id', $user_id);

    if (!$user || breathein_customer_admin_user($user)) {
        return;
    }

    if ('profile' === $action) {
        $first_name = sanitize_text_field(wp_unslash($_POST['breathein_settings_first_name'] ?? ''));
        $last_name = sanitize_text_field(wp_unslash($_POST['breathein_settings_last_name'] ?? ''));
        $email = strtolower(sanitize_email(wp_unslash($_POST['breathein_settings_email'] ?? '')));
        $phone = sanitize_text_field(wp_unslash($_POST['breathein_settings_phone'] ?? ''));
        $date_of_birth = sanitize_text_field(wp_unslash($_POST['breathein_settings_date_of_birth'] ?? ''));

        if (!$first_name || !$email || !is_email($email)) {
            breathein_customer_settings_notice(__('Enter your first name and a valid email address.', 'breathein'));
            return;
        }

        $date_of_birth_value = null;

        if ($date_of_birth) {
            $date = DateTime::createFromFormat('!Y-m-d', $date_of_birth);

            if (!$date || $date->format('Y-m-d') !== $date_of_birth || $date > new DateTime('today')) {
                breathein_customer_settings_notice(__('Enter a valid date of birth.', 'breathein'));
                return;
            }

            $date_of_birth_value = $date_of_birth;
        }

        $existing_customer_id = $wpdb->get_var(
            $wpdb->prepare(
                'SELECT id FROM ' . breathein_customer_table() . ' WHERE email = %s AND id != %d LIMIT 1',
                $email,
                (int) $customer->id
            )
        );

        $existing_user = get_user_by('email', $email);

        if ($existing_customer_id || ($existing_user && (int) $existing_user->ID !== $user_id)) {
            breathein_customer_settings_notice(__('That email address is already in use.', 'breathein'));
            return;
        }

        $updated_user_id = wp_update_user([
            'ID'           => $user_id,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => trim($first_name . ' ' . $last_name),
            'user_email'   => $email,
        ]);

        if (is_wp_error($updated_user_id)) {
            breathein_customer_settings_notice($updated_user_id->get_error_message());
            return;
        }

        $updated = $wpdb->update(
            breathein_customer_table(),
            [
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'email'         => $email,
                'phone'         => $phone,
                'date_of_birth' => $date_of_birth_value,
                'updated_at'    => gmdate('Y-m-d H:i:s'),
            ],
            ['id' => (int) $customer->id],
            ['%s', '%s', '%s', '%s', '%s', '%s'],
            ['%d']
        );

        if (false === $updated) {
            breathein_customer_settings_notice(__('Your profile could not be saved. Please try again.', 'breathein'));
            return;
        }

        if (class_exists('WC_Customer')) {
            $woocommerce_customer = new WC_Customer($user_id);
            $woocommerce_customer->set_props([
                'billing_first_name' => $first_name,
                'billing_last_name'  => $last_name,
                'billing_email'      => $email,
                'billing_phone'      => $phone,
                'shipping_first_name' => $first_name,
                'shipping_last_name'  => $last_name,
            ]);
            $woocommerce_customer->save();
            breathein_customer_sync_wc_session($user_id);
        }

        breathein_customer_settings_notice(__('Personal information updated.', 'breathein'), 'success');
        wp_safe_redirect(breathein_customer_settings_url());
        exit;
    }

    if ('password' === $action) {
        $current_password = (string) wp_unslash($_POST['breathein_settings_current_password'] ?? '');
        $new_password = (string) wp_unslash($_POST['breathein_settings_new_password'] ?? '');
        $confirm_password = (string) wp_unslash($_POST['breathein_settings_confirm_password'] ?? '');
        $valid_current_password = wp_check_password($current_password, (string) $customer->password_hash, $user_id);

        if (!$valid_current_password) {
            $valid_current_password = wp_check_password($current_password, (string) $user->user_pass, $user_id);
        }

        if (!$valid_current_password) {
            breathein_customer_settings_notice(__('Your current password is incorrect.', 'breathein'));
            return;
        }

        if (strlen($new_password) < 8 || $new_password !== $confirm_password) {
            breathein_customer_settings_notice(__('New passwords must match and contain at least 8 characters.', 'breathein'));
            return;
        }

        $updated = $wpdb->update(
            breathein_customer_table(),
            [
                'password_hash'       => wp_hash_password($new_password),
                'password_changed_at' => gmdate('Y-m-d H:i:s'),
                'updated_at'          => gmdate('Y-m-d H:i:s'),
            ],
            ['id' => (int) $customer->id],
            ['%s', '%s', '%s'],
            ['%d']
        );

        if (false === $updated) {
            breathein_customer_settings_notice(__('Your password could not be changed. Please try again.', 'breathein'));
            return;
        }

        wp_set_password($new_password, $user_id);
        breathein_customer_settings_notice(__('Password changed successfully.', 'breathein'), 'success');
        wp_safe_redirect(breathein_customer_settings_url());
        exit;
    }

    if ('notification' === $action) {
        $preference = sanitize_key(wp_unslash($_POST['breathein_settings_preference'] ?? ''));
        $allowed_preferences = ['order_updates', 'promotions', 'air_quality_alerts'];

        if (!in_array($preference, $allowed_preferences, true)) {
            return;
        }

        $value = !empty($_POST['breathein_settings_value']) ? 1 : 0;
        $updated = $wpdb->update(
            breathein_customer_table(),
            [$preference => $value, 'updated_at' => gmdate('Y-m-d H:i:s')],
            ['id' => (int) $customer->id],
            ['%d', '%s'],
            ['%d']
        );

        if (false === $updated) {
            breathein_customer_settings_notice(__('That notification preference could not be saved.', 'breathein'));
            return;
        }

        breathein_customer_settings_notice(__('Notification preference updated.', 'breathein'), 'success');
        wp_safe_redirect(breathein_customer_settings_url());
        exit;
    }

    $delete_password = (string) wp_unslash($_POST['breathein_delete_password'] ?? '');
    $valid_delete_password = wp_check_password($delete_password, (string) $customer->password_hash, $user_id);

    if (!$valid_delete_password) {
        $valid_delete_password = wp_check_password($delete_password, (string) $user->user_pass, $user_id);
    }

    if (!$valid_delete_password) {
        breathein_customer_settings_notice(__('Enter your current password to delete your account.', 'breathein'));
        return;
    }

    if (!breathein_customer_delete_owned_records($user_id, (string) $customer->email)) {
        breathein_customer_settings_notice(__('Some customer records could not be deleted. Your account was kept active. Please contact support.', 'breathein'));
        return;
    }

    $wpdb->delete(
        breathein_customer_sessions_table(),
        ['customer_id' => (int) $customer->id],
        ['%d']
    );

    $wpdb->delete(
        $wpdb->prefix . 'woocommerce_sessions',
        ['session_key' => (string) $user_id],
        ['%s']
    );

    require_once ABSPATH . 'wp-admin/includes/user.php';

    if ($user_id && function_exists('wp_delete_user')) {
        wp_delete_user($user_id);
    }

    $wpdb->delete(
        $wpdb->prefix . 'wc_customer_lookup',
        ['user_id' => $user_id],
        ['%d']
    );

    $wpdb->delete(
        breathein_customer_table(),
        ['id' => (int) $customer->id],
        ['%d']
    );

    breathein_customer_clear_cookie();
    wp_set_current_user(0);
    wp_safe_redirect(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'));
    exit;
}

add_action('template_redirect', 'breathein_customer_process_settings', 20);

function breathein_customer_process_login(): void
{
    global $wpdb;

    $email = strtolower(sanitize_email(wp_unslash($_POST['breathein_customer_email'] ?? '')));
    $password = (string) wp_unslash($_POST['breathein_customer_password'] ?? '');
    $remember = !empty($_POST['breathein_customer_remember']);

    if (!$email || !$password) {
        breathein_customer_notice(__('Enter your email and password.', 'breathein'));
        return;
    }

    $customer = $wpdb->get_row(
        $wpdb->prepare(
            'SELECT * FROM ' . breathein_customer_table() . ' WHERE email = %s AND status = %s LIMIT 1',
            $email,
            'active'
        )
    );

    if (!$customer) {
        breathein_customer_notice(__('Those details do not match a customer account.', 'breathein'));
        return;
    }

    $shadow_user = !empty($customer->wp_user_id)
        ? get_user_by('id', (int) $customer->wp_user_id)
        : null;

    if (breathein_customer_admin_user($shadow_user)) {
        breathein_customer_notice(__('Administrator accounts must use the WordPress admin login.', 'breathein'));
        return;
    }

    $valid_password = wp_check_password($password, $customer->password_hash, (int) $customer->wp_user_id);

    /* Allow imported customers to authenticate against their old WordPress hash once. */
    if (!$valid_password && $shadow_user) {
        $valid_password = wp_check_password($password, $shadow_user->user_pass, (int) $shadow_user->ID);

        if ($valid_password) {
            $wpdb->update(
                breathein_customer_table(),
                ['password_hash' => $shadow_user->user_pass, 'updated_at' => gmdate('Y-m-d H:i:s')],
                ['id' => (int) $customer->id],
                ['%s', '%s'],
                ['%d']
            );
        }
    }

    if (!$valid_password || !breathein_customer_set_session((int) $customer->id, $remember)) {
        breathein_customer_notice(__('Those details do not match a customer account.', 'breathein'));
        return;
    }

    $wpdb->update(
        breathein_customer_table(),
        ['last_login_at' => gmdate('Y-m-d H:i:s'), 'updated_at' => gmdate('Y-m-d H:i:s')],
        ['id' => (int) $customer->id],
        ['%s', '%s'],
        ['%d']
    );

    wp_safe_redirect(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'));
    exit;
}

function breathein_customer_process_registration(): void
{
    global $wpdb;

    $first_name = sanitize_text_field(wp_unslash($_POST['breathein_customer_first_name'] ?? ''));
    $last_name = sanitize_text_field(wp_unslash($_POST['breathein_customer_last_name'] ?? ''));
    $email = strtolower(sanitize_email(wp_unslash($_POST['breathein_customer_email'] ?? '')));
    $phone = sanitize_text_field(wp_unslash($_POST['breathein_customer_phone'] ?? ''));
    $password = (string) wp_unslash($_POST['breathein_customer_password'] ?? '');
    $password_confirm = (string) wp_unslash($_POST['breathein_customer_password_confirm'] ?? '');

    if (!$first_name || !$email || !is_email($email)) {
        breathein_customer_notice(__('Please enter your name and a valid email address.', 'breathein'));
        return;
    }

    if (strlen($password) < 8 || $password !== $password_confirm) {
        breathein_customer_notice(__('Passwords must match and contain at least 8 characters.', 'breathein'));
        return;
    }

    $existing_customer = $wpdb->get_var(
        $wpdb->prepare(
            'SELECT id FROM ' . breathein_customer_table() . ' WHERE email = %s LIMIT 1',
            $email
        )
    );

    if ($existing_customer) {
        breathein_customer_notice(__('An account already exists for this email. Please sign in.', 'breathein'));
        return;
    }

    $existing_wp_user = get_user_by('email', $email);

    if (breathein_customer_admin_user($existing_wp_user)) {
        breathein_customer_notice(__('Administrator accounts cannot be used as website customer accounts.', 'breathein'));
        return;
    }

    $wp_user_id = $existing_wp_user ? (int) $existing_wp_user->ID : 0;

    if ($existing_wp_user && !in_array('customer', (array) $existing_wp_user->roles, true)) {
        breathein_customer_notice(__('This email is already assigned to another WordPress user.', 'breathein'));
        return;
    }

    if (!$wp_user_id) {
        $username = sanitize_user(str_replace('@', '.', $email), true);
        $base_username = $username;
        $suffix = 1;

        while (username_exists($username)) {
            $username = $base_username . $suffix;
            $suffix++;
        }

        $wp_user_id = wp_insert_user([
            'user_login'   => $username,
            /* The shadow WooCommerce user is not the customer login account. */
            'user_pass'    => wp_generate_password(48, true, true),
            'user_email'   => $email,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => trim($first_name . ' ' . $last_name),
            'role'         => get_role('customer') ? 'customer' : 'subscriber',
        ]);

        if (is_wp_error($wp_user_id)) {
            breathein_customer_notice($wp_user_id->get_error_message());
            return;
        }
    }

    $now = gmdate('Y-m-d H:i:s');
    $inserted = $wpdb->insert(
        breathein_customer_table(),
        [
            'wp_user_id'    => (int) $wp_user_id,
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => $email,
            'phone'         => $phone,
            'password_hash' => wp_hash_password($password),
            'password_changed_at' => $now,
            'status'        => 'active',
            'created_at'    => $now,
            'updated_at'    => $now,
        ],
        ['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
    );

    if (!$inserted || !breathein_customer_set_session((int) $wpdb->insert_id, true)) {
        breathein_customer_notice(__('The account could not be created. Please try again.', 'breathein'));
        return;
    }

    wp_safe_redirect(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'));
    exit;
}

/**
 * Render the customer login/register form in place of WooCommerce's default
 * WordPress login form. This also prevents WordPress-admin users from using
 * the customer login unless they have a dedicated customer record.
 */
function breathein_customer_render_auth_form(): string
{
    $register_mode = isset($_GET['register']) || ('register' === ($_POST['breathein_customer_action'] ?? ''));
    $notice = $GLOBALS['breathein_customer_auth_notice'] ?? null;
    $account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
    $field = static function (string $key): string {
        return isset($_POST[$key]) ? (string) wp_unslash($_POST[$key]) : '';
    };

    ob_start();
    ?>
    <div class="breathein-customer-auth w-full max-w-[1200px] mx-auto px-6 py-12 lg:py-20">
        <div class="grid lg:grid-cols-[minmax(0,1fr)_460px] gap-10 lg:gap-20 items-center">
            <div class="hidden lg:block">
                <div class="flex items-center gap-4 mb-6"><div class="w-8 h-px bg-[#156E8A]"></div><span class="uppercase tracking-[0.25em] text-[11px] text-[#156E8A] font-bold"><?php esc_html_e('Breathe In Account', 'breathein'); ?></span></div>
                <h1 class="text-5xl xl:text-7xl font-light leading-tight tracking-tight text-gray-900 mb-6"><?php esc_html_e('The right air,', 'breathein'); ?><br><span class="text-[#156E8A] font-medium"><?php esc_html_e('always within reach.', 'breathein'); ?></span></h1>
                <p class="max-w-lg text-gray-500 text-base leading-relaxed font-light"><?php esc_html_e('Manage your orders, saved addresses and purifier support from one simple account.', 'breathein'); ?></p>
            </div>

            <div class="border border-gray-200 bg-white p-6 md:p-8 lg:p-10 shadow-sm">
                <div class="flex border-b border-gray-200 mb-8" role="tablist" aria-label="<?php esc_attr_e('Customer account forms', 'breathein'); ?>">
                    <a href="<?php echo esc_url(remove_query_arg('register', $account_url)); ?>" class="flex-1 pb-4 text-center text-[11px] font-bold uppercase tracking-[0.16em] <?php echo $register_mode ? 'text-gray-400' : 'text-[#156E8A] border-b-2 border-[#156E8A]'; ?>"><?php esc_html_e('Sign In', 'breathein'); ?></a>
                    <a href="<?php echo esc_url(add_query_arg('register', '1', $account_url)); ?>" class="flex-1 pb-4 text-center text-[11px] font-bold uppercase tracking-[0.16em] <?php echo $register_mode ? 'text-[#156E8A] border-b-2 border-[#156E8A]' : 'text-gray-400'; ?>"><?php esc_html_e('Create Account', 'breathein'); ?></a>
                </div>

                <?php if ($notice) : ?>
                    <div class="mb-6 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert"><?php echo esc_html($notice['message']); ?></div>
                <?php endif; ?>

                <?php if ($register_mode) : ?>
                    <h2 class="text-2xl font-light tracking-tight mb-2"><?php esc_html_e('Create your account', 'breathein'); ?></h2>
                    <p class="text-sm text-gray-500 font-light mb-7"><?php esc_html_e('Save your details and follow every order in one place.', 'breathein'); ?></p>
                    <form method="post" action="<?php echo esc_url(add_query_arg('register', '1', $account_url)); ?>" class="breathein-customer-auth-form">
                        <input type="hidden" name="breathein_customer_action" value="register">
                        <?php wp_nonce_field('breathein_customer_register', 'breathein_customer_nonce'); ?>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <p class="form-row"><label for="breathein_customer_first_name"><?php esc_html_e('First name', 'breathein'); ?></label><input id="breathein_customer_first_name" name="breathein_customer_first_name" type="text" value="<?php echo esc_attr($field('breathein_customer_first_name')); ?>" required></p>
                            <p class="form-row"><label for="breathein_customer_last_name"><?php esc_html_e('Last name', 'breathein'); ?></label><input id="breathein_customer_last_name" name="breathein_customer_last_name" type="text" value="<?php echo esc_attr($field('breathein_customer_last_name')); ?>"></p>
                        </div>
                        <p class="form-row"><label for="breathein_customer_email"><?php esc_html_e('Email address', 'breathein'); ?></label><input id="breathein_customer_email" name="breathein_customer_email" type="email" value="<?php echo esc_attr($field('breathein_customer_email')); ?>" required></p>
                        <p class="form-row"><label for="breathein_customer_phone"><?php esc_html_e('Phone number', 'breathein'); ?></label><input id="breathein_customer_phone" name="breathein_customer_phone" type="tel" value="<?php echo esc_attr($field('breathein_customer_phone')); ?>"></p>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <p class="form-row"><label for="breathein_customer_password"><?php esc_html_e('Password', 'breathein'); ?></label><input id="breathein_customer_password" name="breathein_customer_password" type="password" minlength="8" required></p>
                            <p class="form-row"><label for="breathein_customer_password_confirm"><?php esc_html_e('Confirm password', 'breathein'); ?></label><input id="breathein_customer_password_confirm" name="breathein_customer_password_confirm" type="password" minlength="8" required></p>
                        </div>
                        <button type="submit" class="w-full bg-[#156E8A] text-white px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] rounded-sm hover:bg-[#115a72] transition-colors"><?php esc_html_e('Create Account', 'breathein'); ?></button>
                    </form>
                <?php else : ?>
                    <h2 class="text-2xl font-light tracking-tight mb-2"><?php esc_html_e('Welcome back', 'breathein'); ?></h2>
                    <p class="text-sm text-gray-500 font-light mb-7"><?php esc_html_e('Sign in to view your orders and account dashboard.', 'breathein'); ?></p>
                    <form method="post" action="<?php echo esc_url($account_url); ?>" class="breathein-customer-auth-form">
                        <input type="hidden" name="breathein_customer_action" value="login">
                        <?php wp_nonce_field('breathein_customer_login', 'breathein_customer_nonce'); ?>
                        <p class="form-row"><label for="breathein_customer_email"><?php esc_html_e('Email address', 'breathein'); ?></label><input id="breathein_customer_email" name="breathein_customer_email" type="email" value="<?php echo esc_attr($field('breathein_customer_email')); ?>" autocomplete="email" required></p>
                        <p class="form-row"><label for="breathein_customer_password"><?php esc_html_e('Password', 'breathein'); ?></label><input id="breathein_customer_password" name="breathein_customer_password" type="password" autocomplete="current-password" required></p>
                        <div class="flex items-center justify-between gap-4 mb-6"><label class="flex items-center gap-2 text-xs text-gray-500 normal-case tracking-normal font-normal"><input type="checkbox" name="breathein_customer_remember" value="1"> <?php esc_html_e('Remember me', 'breathein'); ?></label><span class="text-xs text-gray-400"><?php esc_html_e('Need help? Contact support.', 'breathein'); ?></span></div>
                        <button type="submit" class="w-full bg-[#156E8A] text-white px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] rounded-sm hover:bg-[#115a72] transition-colors"><?php esc_html_e('Sign In', 'breathein'); ?></button>
                    </form>
                    <p class="text-center text-xs text-gray-400 mt-6"><?php esc_html_e('New to Breathe In?', 'breathein'); ?> <a href="<?php echo esc_url(add_query_arg('register', '1', $account_url)); ?>" class="text-[#156E8A] font-medium hover:underline"><?php esc_html_e('Create an account', 'breathein'); ?></a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php

    return (string) ob_get_clean();
}

add_filter('pre_do_shortcode_tag', static function ($return, string $tag) {
    if ('woocommerce_my_account' !== $tag || breathein_customer_is_logged_in()) {
        return $return;
    }

    return breathein_customer_render_auth_form();
}, 10, 2);

/**
 * Simple read-only customer list for WordPress administrators.
 */
add_action('admin_menu', static function (): void {
    add_users_page(
        __('Website Customers', 'breathein'),
        __('Website Customers', 'breathein'),
        'list_users',
        'breathein-customers',
        'breathein_customer_admin_page'
    );
});

function breathein_customer_admin_page(): void
{
    if (!current_user_can('list_users')) {
        wp_die(esc_html__('You do not have permission to view customers.', 'breathein'));
    }

    global $wpdb;
    $customers = $wpdb->get_results('SELECT id, first_name, last_name, email, phone, status, created_at, last_login_at FROM ' . breathein_customer_table() . ' ORDER BY created_at DESC');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Website Customers', 'breathein'); ?></h1>
        <p><?php esc_html_e('These accounts use the separate Breathe In customer login. WordPress administrator accounts are not included.', 'breathein'); ?></p>
        <table class="widefat striped">
            <thead><tr><th><?php esc_html_e('Name', 'breathein'); ?></th><th><?php esc_html_e('Email', 'breathein'); ?></th><th><?php esc_html_e('Phone', 'breathein'); ?></th><th><?php esc_html_e('Status', 'breathein'); ?></th><th><?php esc_html_e('Created', 'breathein'); ?></th><th><?php esc_html_e('Last login', 'breathein'); ?></th></tr></thead>
            <tbody>
            <?php if ($customers) : foreach ($customers as $customer) : ?>
                <tr>
                    <td><?php echo esc_html(trim($customer->first_name . ' ' . $customer->last_name) ?: '—'); ?></td>
                    <td><a href="mailto:<?php echo esc_attr($customer->email); ?>"><?php echo esc_html($customer->email); ?></a></td>
                    <td><?php echo esc_html($customer->phone ?: '—'); ?></td>
                    <td><?php echo esc_html(ucfirst($customer->status)); ?></td>
                    <td><?php echo esc_html($customer->created_at); ?></td>
                    <td><?php echo esc_html($customer->last_login_at ?: '—'); ?></td>
                </tr>
            <?php endforeach; else : ?>
                <tr><td colspan="6"><?php esc_html_e('No website customers found.', 'breathein'); ?></td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
