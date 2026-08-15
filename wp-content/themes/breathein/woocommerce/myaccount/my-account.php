<?php
/**
 * Breathein My Account shell.
 *
 * The page keeps the account design in the theme while WooCommerce continues
 * to provide the endpoint content (orders, addresses, settings, etc.).
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

/* Keep WooCommerce's normal login screen for logged-out visitors. */
if (!is_user_logged_in()) {
    if (function_exists('breathein_customer_render_auth_form')) {
        echo breathein_customer_render_auth_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return;
    }

    do_action('woocommerce_before_customer_login_form');
    wc_get_template('myaccount/form-login.php');
    do_action('woocommerce_after_customer_login_form');
    return;
}

$user = isset($current_user) && $current_user instanceof WP_User
    ? $current_user
    : wp_get_current_user();

$first_name = trim((string) $user->first_name);
$last_name = trim((string) $user->last_name);
$full_name = trim($first_name . ' ' . $last_name);

if (!$full_name) {
    $full_name = (string) $user->display_name;
}

if (!$full_name) {
    $full_name = (string) $user->user_login;
}

$name_parts = preg_split('/\s+/', trim($full_name));
$initials = '';

if (!empty($name_parts[0])) {
    $initials .= strtoupper(substr($name_parts[0], 0, 1));
}

if (count($name_parts) > 1 && !empty($name_parts[count($name_parts) - 1])) {
    $initials .= strtoupper(substr($name_parts[count($name_parts) - 1], 0, 1));
}

$initials = $initials ?: 'BI';
$member_since = !empty($user->user_registered)
    ? wp_date('M Y', strtotime($user->user_registered))
    : '';
$account_items = function_exists('wc_get_account_menu_items')
    ? wc_get_account_menu_items()
    : [];
$current_endpoint = function_exists('WC') && WC()->query
    ? WC()->query->get_current_endpoint()
    : '';

/* Map WooCommerce endpoints to the labels used by the supplied design. */
$account_labels = [
    'dashboard'       => __('Overview', 'breathein'),
    'orders'          => __('My Orders', 'breathein'),
    'edit-address'    => __('Addresses', 'breathein'),
    'edit-account'    => __('Settings', 'breathein'),
    'customer-logout' => __('Log Out', 'breathein'),
];

$account_icon = static function (string $endpoint): string {
    $icons = [
        'dashboard' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.6"/></svg>',
        'orders' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 4 6-2 6 2v16l-6 2-6-2V4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M6 4 12 6l6-2M12 6v16M9 10h6M9 14h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
        'edit-address' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 10.5c0 6.3-8 11-8 11s-8-4.7-8-11a8 8 0 1 1 16 0Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="10.5" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg>',
        'edit-account' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M5 20c.7-3.1 3.2-5 7-5s6.3 1.9 7 5M19 4v4M17 6h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
        'payment-methods' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M3 9h18M7 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
        'customer-logout' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h4M14 16l4-4-4-4M18 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    ];

    return $icons[$endpoint] ?? $icons['dashboard'];
};

$is_endpoint_active = static function (string $endpoint, string $current_endpoint): bool {
    if ('dashboard' === $endpoint) {
        return empty($current_endpoint);
    }

    if ('orders' === $endpoint) {
        return in_array($current_endpoint, ['orders', 'view-order'], true);
    }

    return $endpoint === $current_endpoint;
};

$render_nav = static function (bool $mobile = false) use ($account_items, $account_labels, $account_icon, $current_endpoint, $is_endpoint_active): void {
    $items = array_filter(
        $account_items,
        static fn($label, $endpoint): bool => !in_array($endpoint, ['customer-logout', 'downloads'], true),
        ARRAY_FILTER_USE_BOTH
    );

    foreach ($items as $endpoint => $label) {
        $endpoint = (string) $endpoint;
        $is_active = $is_endpoint_active($endpoint, (string) $current_endpoint);
        $display_label = $account_labels[$endpoint] ?? $label;
        $url = wc_get_account_endpoint_url('dashboard' === $endpoint ? '' : $endpoint);

        if ($mobile) {
            $classes = $is_active
                ? 'text-[#156E8A] dark:text-[#2094B6] border-b-2 border-[#156E8A] dark:border-[#2094B6]'
                : 'text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white';

            printf(
                '<a href="%1$s" class="breathein-account-mobile-tab %2$s px-3 pb-3 whitespace-nowrap transition-colors">%3$s</a>',
                esc_url($url),
                esc_attr($classes),
                esc_html($display_label)
            );
            continue;
        }

        $classes = $is_active
            ? 'bg-[#156E8A0F] dark:bg-[#0c1318] border-l-2 border-[#156E8A] dark:border-[#2094B6] text-[#156E8A] dark:text-[#2094B6]'
            : 'text-gray-600 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900';

        printf(
            '<a href="%1$s" class="breathein-account-nav-link %2$s flex items-center justify-between p-4 text-[14px] transition-colors"><span class="flex items-center gap-3">%3$s<span>%4$s</span></span><span class="breathein-account-nav-arrow" aria-hidden="true">›</span></a>',
            esc_url($url),
            esc_attr($classes),
            $account_icon($endpoint),
            esc_html($display_label)
        );
    }
};

$render_profile = static function (bool $mobile = false) use ($initials, $full_name, $user, $member_since): void {
    $wrapper_classes = $mobile
        ? 'flex flex-col items-center text-center w-full my-8'
        : 'border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center text-center mb-6';
    $avatar_classes = $mobile
        ? 'w-20 h-20 text-2xl mb-4'
        : 'w-[72px] h-[72px] text-xl mb-4';
    $name_classes = $mobile ? 'text-xl mb-1' : 'text-[17px] mb-1';
    $email_classes = $mobile ? 'text-[13px] mb-4' : 'text-[13px] mb-5';

    echo '<div class="' . esc_attr($wrapper_classes) . '">';
    echo '<div class="' . esc_attr($avatar_classes) . ' rounded-full bg-[#156E8A] text-white flex items-center justify-center font-bold">' . esc_html($initials) . '</div>';
    echo '<h2 class="' . esc_attr($name_classes) . ' font-medium">' . esc_html($full_name) . '</h2>';
    echo '<p class="' . esc_attr($email_classes) . ' text-gray-400 font-light break-all">' . esc_html($user->user_email) . '</p>';

    if ($member_since) {
        echo '<div class="bg-[#F0F5F7] dark:bg-[#0c1318] text-[#156E8A] dark:text-[#2094B6] px-3 py-1.5 text-[9px] font-bold uppercase tracking-[0.15em]">';
        echo esc_html(sprintf(__('Member since %s', 'breathein'), $member_since));
        echo '</div>';
    }

    echo '</div>';
};
?>

<div class="breathein-account-page w-full min-h-screen bg-white dark:bg-[#050505] text-gray-900 dark:text-white font-sans flex flex-col transition-colors duration-300">
    <div class="hidden lg:block max-w-[1200px] mx-auto w-full px-6 pt-10 pb-6 md:pb-10">
        <div class="text-[11px] text-gray-500 font-medium uppercase tracking-widest mb-6">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-gray-900 dark:hover:text-white transition-colors"><?php esc_html_e('Home', 'breathein'); ?></a>
            <span class="mx-2">&gt;</span>
            <span class="text-gray-900 dark:text-white"><?php esc_html_e('Account', 'breathein'); ?></span>
        </div>
        <div class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-bold mb-2"><?php esc_html_e('Account Overview', 'breathein'); ?></div>
        <h1 class="text-4xl md:text-5xl font-light tracking-tight">
            <?php esc_html_e('Hello,', 'breathein'); ?> <span class="text-[#156E8A] dark:text-[#2094B6] font-medium"><?php echo esc_html($first_name ?: $full_name); ?>.</span>
        </h1>
    </div>

    <div class="lg:hidden w-full flex flex-col items-center mb-8">
        <?php $render_profile(true); ?>
        <nav class="w-full border-b border-gray-200 dark:border-gray-800" aria-label="<?php esc_attr_e('Account navigation', 'breathein'); ?>">
            <div class="breathein-account-nav-scroll flex gap-3 overflow-x-auto text-[14px] font-medium px-3">
                <?php $render_nav(true); ?>
            </div>
        </nav>
        <?php if (isset($account_items['customer-logout'])) : ?>
            <a href="<?php echo esc_url(function_exists('breathein_customer_logout_url') ? breathein_customer_logout_url() : wc_logout_url()); ?>" class="mt-4 text-[12px] text-gray-400 hover:text-[#156E8A] transition-colors"><?php esc_html_e('Log Out', 'breathein'); ?></a>
        <?php endif; ?>
    </div>

    <div class="max-w-[1200px] mx-auto w-full px-6 flex flex-col lg:flex-row gap-10 lg:gap-12 pb-24 flex-1">
        <aside class="hidden lg:flex flex-col w-[260px] xl:w-[280px] shrink-0">
            <?php $render_profile(); ?>

            <nav class="border border-gray-200 dark:border-gray-800 flex flex-col mb-6" aria-label="<?php esc_attr_e('Account navigation', 'breathein'); ?>">
                <?php $render_nav(); ?>
            </nav>

            <?php if (isset($account_items['customer-logout'])) : ?>
                <?php $logout_url = function_exists('breathein_customer_logout_url') ? breathein_customer_logout_url() : wc_logout_url(); ?>
                <a href="<?php echo esc_url($logout_url); ?>" class="breathein-account-logout border border-gray-200 dark:border-gray-800 flex items-center gap-3 p-4 text-gray-600 dark:text-gray-400 text-[14px] hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                    <span class="breathein-account-nav-icon" aria-hidden="true"><?php echo $account_icon('customer-logout'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <?php echo esc_html($account_labels['customer-logout']); ?>
                </a>
            <?php endif; ?>
        </aside>

        <div class="flex-1 min-w-0">
            <div class="woocommerce-MyAccount-content breathein-account-content">
                <?php do_action('woocommerce_account_content'); ?>
            </div>
        </div>
    </div>
</div>
