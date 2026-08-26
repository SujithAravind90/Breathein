<?php

defined('ABSPATH') || exit;

const BREATHEIN_MATCHER_COVERAGE = '_breathein_matcher_coverage';
const BREATHEIN_MATCHER_IDEAL    = '_breathein_matcher_ideal_for';
const BREATHEIN_MATCHER_FILTER   = '_breathein_matcher_filtration';

/**
 * Add homepage matcher fields to WooCommerce's General product panel.
 */
function breathein_render_product_matcher_fields(): void
{
    global $product_object;

    if (
        !class_exists('WC_Product')
        || !$product_object instanceof WC_Product
        || !function_exists('woocommerce_wp_text_input')
    ) {
        return;
    }

    echo '<div class=options_group>';

    woocommerce_wp_text_input([
        'id'                => BREATHEIN_MATCHER_COVERAGE,
        'value'             => $product_object->get_meta(
            BREATHEIN_MATCHER_COVERAGE,
            true,
            'edit'
        ),
        'label'             => __('Matcher coverage (sq ft)', 'breathein'),
        'description'       => __(
            'Maximum recommended room area. Leave blank to exclude this product from Find Your Match.',
            'breathein'
        ),
        'desc_tip'          => true,
        'type'              => 'number',
        'custom_attributes' => [
            'min'  => '1',
            'step' => '1',
        ],
    ]);

    woocommerce_wp_text_input([
        'id'          => BREATHEIN_MATCHER_IDEAL,
        'value'       => $product_object->get_meta(
            BREATHEIN_MATCHER_IDEAL,
            true,
            'edit'
        ),
        'label'       => __('Matcher ideal for', 'breathein'),
        'placeholder' => __('Large living rooms', 'breathein'),
        'description' => __(
            'Short room label displayed in the homepage result card.',
            'breathein'
        ),
        'desc_tip'    => true,
    ]);

    woocommerce_wp_text_input([
        'id'          => BREATHEIN_MATCHER_FILTER,
        'value'       => $product_object->get_meta(
            BREATHEIN_MATCHER_FILTER,
            true,
            'edit'
        ),
        'label'       => __('Matcher filtration', 'breathein'),
        'placeholder' => __('HEPA H13', 'breathein'),
        'description' => __(
            'Short filtration label displayed in the homepage result card.',
            'breathein'
        ),
        'desc_tip'    => true,
    ]);

    echo '</div>';
}

add_action(
    'woocommerce_product_options_general_product_data',
    'breathein_render_product_matcher_fields'
);

/**
 * Save the homepage matcher product fields.
 *
 * @param mixed $product WooCommerce product object.
 */
function breathein_save_product_matcher_fields($product): void
{
    if (
        !class_exists('WC_Product')
        || !$product instanceof WC_Product
        || !current_user_can('edit_post', $product->get_id())
    ) {
        return;
    }

    $coverage = isset($_POST[BREATHEIN_MATCHER_COVERAGE])
        ? absint(wp_unslash($_POST[BREATHEIN_MATCHER_COVERAGE]))
        : 0;

    if ($coverage > 0) {
        $product->update_meta_data(
            BREATHEIN_MATCHER_COVERAGE,
            $coverage
        );
    } else {
        $product->delete_meta_data(BREATHEIN_MATCHER_COVERAGE);
    }

    foreach (
        [BREATHEIN_MATCHER_IDEAL, BREATHEIN_MATCHER_FILTER]
        as $field_key
    ) {
        $value = isset($_POST[$field_key])
            ? sanitize_text_field(wp_unslash($_POST[$field_key]))
            : '';

        if ($value !== '') {
            $product->update_meta_data($field_key, $value);
        } else {
            $product->delete_meta_data($field_key);
        }
    }
}

add_action(
    'woocommerce_admin_process_product_object',
    'breathein_save_product_matcher_fields'
);

/**
 * Get all published products available to the homepage collection.
 *
 * @return array<int, WC_Product>
 */
function breathein_get_collection_products(): array
{
    if (!function_exists('wc_get_products')) {
        return [];
    }

    $products = wc_get_products([
        'status'  => 'publish',
        'limit'   => -1,
        'return'  => 'objects',
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    ]);

    if (!is_array($products)) {
        return [];
    }

    $products = array_values(
        array_filter(
            $products,
            static function ($product): bool {
                return $product instanceof WC_Product
                    && $product->is_visible();
            }
        )
    );

    /**
     * Filter products displayed in the homepage collection.
     *
     * @param array<int, WC_Product> $products Collection products.
     */
    return (array) apply_filters(
        'breathein_collection_products',
        $products
    );
}

/**
 * Get published, visible, in-stock products configured for the matcher.
 *
 * Products are sorted by coverage so the smallest suitable purifier can be
 * selected for the requested room size.
 *
 * @return array<int, array<string, mixed>>
 */
function breathein_get_matcher_products(): array
{
    if (!function_exists('wc_get_products')) {
        return [];
    }

    $products = wc_get_products([
        'status'  => 'publish',
        'limit'   => -1,
        'return'  => 'objects',
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    ]);

    if (!is_array($products)) {
        return [];
    }

    $matches = [];

    foreach ($products as $product) {
        if (
            !class_exists('WC_Product')
            || !$product instanceof WC_Product
            || !$product->is_visible()
            || !$product->is_in_stock()
        ) {
            continue;
        }

        $coverage = absint(
            $product->get_meta(BREATHEIN_MATCHER_COVERAGE, true)
        );

        if ($coverage < 1) {
            continue;
        }

        $matches[] = [
            'product'    => $product,
            'coverage'   => $coverage,
            'ideal_for'  => sanitize_text_field(
                (string) $product->get_meta(
                    BREATHEIN_MATCHER_IDEAL,
                    true
                )
            ),
            'filtration' => sanitize_text_field(
                (string) $product->get_meta(
                    BREATHEIN_MATCHER_FILTER,
                    true
                )
            ),
        ];
    }

    usort(
        $matches,
        static function (array $first, array $second): int {
            $coverage_order = $first['coverage'] <=> $second['coverage'];

            if ($coverage_order !== 0) {
                return $coverage_order;
            }

            return $first['product']->get_id()
                <=> $second['product']->get_id();
        }
    );

    /**
     * Filter products available to the homepage matcher.
     *
     * @param array<int, array<string, mixed>> $matches Matcher products.
     */
    return (array) apply_filters(
        'breathein_matcher_products',
        $matches
    );
}

/**
 * Find the smallest configured product that covers the requested room area.
 *
 * @param array<int, array<string, mixed>> $matches Matcher products.
 * @param int                              $area    Requested room area.
 * @return array<string, mixed>|null
 */
function breathein_find_matcher_product(array $matches, int $area)
{
    if (!$matches) {
        return null;
    }

    foreach ($matches as $match) {
        if ((int) $match['coverage'] >= $area) {
            return $match;
        }
    }

    return $matches[count($matches) - 1];
}

/**
 * Redirect a matcher lead submission back to its homepage section.
 */
function breathein_matcher_lead_redirect(string $status): void
{
    $redirect_url = add_query_arg(
        'matcher_status',
        sanitize_key($status),
        home_url('/')
    );

    wp_safe_redirect($redirect_url . '#find-your-match');
    exit;
}

/**
 * Read a scalar value from the matcher form request.
 */
function breathein_matcher_post_value(string $key): string
{
    if (!isset($_POST[$key]) || !is_string($_POST[$key])) {
        return '';
    }

    return wp_unslash($_POST[$key]);
}

/**
 * Process the homepage product matcher lead form.
 */
function breathein_handle_matcher_lead(): void
{
    if (
        !isset($_SERVER['REQUEST_METHOD'])
        || strtoupper((string) $_SERVER['REQUEST_METHOD']) !== 'POST'
    ) {
        breathein_matcher_lead_redirect('invalid');
    }

    $nonce = sanitize_text_field(
        breathein_matcher_post_value('breathein_matcher_nonce')
    );

    if (
        $nonce === ''
        || !wp_verify_nonce($nonce, 'breathein_matcher_lead_submit')
    ) {
        breathein_matcher_lead_redirect('invalid');
    }

    // Silently accept honeypot submissions so bots get no useful feedback.
    if (breathein_matcher_post_value('company_website') !== '') {
        breathein_matcher_lead_redirect('success');
    }

    $email = sanitize_email(breathein_matcher_post_value('email'));
    $phone = sanitize_text_field(
        breathein_matcher_post_value('phone')
    );
    $phone = (string) preg_replace('/[^0-9+()\-\s]/', '', $phone);

    $product_id = absint(
        breathein_matcher_post_value('matched_product_id')
    );
    $room_area = absint(
        breathein_matcher_post_value('room_area_sq_ft')
    );
    $phone_digits = (string) preg_replace('/\D/', '', $phone);

    if (
        !is_email($email)
        || strlen($email) > 254
        || strlen($phone_digits) < 7
        || strlen($phone_digits) > 15
        || $product_id < 1
        || $room_area < 1
        || $room_area > 100000
        || !function_exists('wc_get_product')
    ) {
        breathein_matcher_lead_redirect('invalid');
    }

    $product = wc_get_product($product_id);

    if (
        !$product instanceof WC_Product
        || $product->get_status() !== 'publish'
        || absint(
            $product->get_meta(BREATHEIN_MATCHER_COVERAGE, true)
        ) < 1
    ) {
        breathein_matcher_lead_redirect('invalid');
    }

    $remote_address = isset($_SERVER['REMOTE_ADDR'])
        && is_string($_SERVER['REMOTE_ADDR'])
        ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']))
        : '';
    $rate_limit_hash = hash_hmac(
        'sha256',
        strtolower($email) . '|' . $remote_address,
        wp_salt('nonce')
    );
    $rate_limit_key = 'breathein_matcher_' . substr(
        $rate_limit_hash,
        0,
        40
    );

    if (get_transient($rate_limit_key)) {
        breathein_matcher_lead_redirect('rate_limited');
    }

    set_transient($rate_limit_key, 1, MINUTE_IN_SECONDS);

    $recipient = sanitize_email(
        (string) apply_filters(
            'breathein_matcher_lead_recipient',
            get_option('admin_email')
        )
    );

    if (!is_email($recipient)) {
        delete_transient($rate_limit_key);
        breathein_matcher_lead_redirect('mail_error');
    }

    $site_name = sanitize_text_field(
        wp_specialchars_decode(
            get_bloginfo('name'),
            ENT_QUOTES
        )
    );
    $product_name = sanitize_text_field($product->get_name());
    $product_coverage = absint(
        $product->get_meta(BREATHEIN_MATCHER_COVERAGE, true)
    );
    $subject = sprintf(
        '[%s] New product match enquiry: %s',
        $site_name,
        $product_name
    );
    $message = implode(
        PHP_EOL,
        [
            'A customer submitted the Find Your Match form.',
            '',
            'Customer email: ' . $email,
            'Phone: ' . $phone,
            'Room area: ' . number_format_i18n($room_area) . ' sq ft',
            'Recommended product: ' . $product_name,
            'Product coverage: ' . number_format_i18n(
                $product_coverage
            ) . ' sq ft',
            'Product URL: ' . $product->get_permalink(),
            'Submitted: ' . wp_date('F j, Y g:i a T'),
        ]
    );
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email,
    ];

    $sent = wp_mail($recipient, $subject, $message, $headers);

    if (!$sent) {
        delete_transient($rate_limit_key);
        error_log(
            sprintf(
                'Breathein matcher lead email failed for product %d.',
                $product_id
            )
        );
        breathein_matcher_lead_redirect('mail_error');
    }

    /**
     * Fires after a homepage matcher enquiry is emailed successfully.
     *
     * @param int    $product_id Matched WooCommerce product ID.
     * @param string $email      Customer email address.
     * @param string $phone      Customer phone number.
     * @param int    $room_area  Requested room area in square feet.
     */
    do_action(
        'breathein_matcher_lead_sent',
        $product_id,
        $email,
        $phone,
        $room_area
    );

    breathein_matcher_lead_redirect('success');
}

add_action(
    'admin_post_nopriv_breathein_matcher_lead',
    'breathein_handle_matcher_lead'
);
add_action(
    'admin_post_breathein_matcher_lead',
    'breathein_handle_matcher_lead'
);
