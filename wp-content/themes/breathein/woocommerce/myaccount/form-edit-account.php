<?php
/**
 * Breathein customer Settings page.
 *
 * The account shell supplies the header, navigation and footer. This file
 * supplies only the Settings content and keeps all values dynamic.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

$customer = function_exists('breathein_customer_current')
    ? breathein_customer_current()
    : null;
$user_id = get_current_user_id();
$user = $user_id ? get_user_by('id', $user_id) : null;

if (!$user) {
    return;
}

$settings_url = function_exists('breathein_customer_settings_url')
    ? breathein_customer_settings_url()
    : wc_get_endpoint_url('edit-account', '', wc_get_page_permalink('myaccount'));

$first_name = $customer && isset($customer->first_name)
    ? (string) $customer->first_name
    : (string) $user->first_name;
$last_name = $customer && isset($customer->last_name)
    ? (string) $customer->last_name
    : (string) $user->last_name;
$email = $customer && isset($customer->email)
    ? (string) $customer->email
    : (string) $user->user_email;
$phone = $customer && isset($customer->phone)
    ? (string) $customer->phone
    : '';
$date_of_birth = $customer && isset($customer->date_of_birth)
    ? (string) $customer->date_of_birth
    : '';

if (!$phone && class_exists('WC_Customer')) {
    $phone = (string) (new WC_Customer($user_id))->get_billing_phone('view');
}

$notification_preferences = [
    'order_updates'     => !isset($customer->order_updates) || (bool) $customer->order_updates,
    'promotions'        => isset($customer->promotions) && (bool) $customer->promotions,
    'air_quality_alerts' => !isset($customer->air_quality_alerts) || (bool) $customer->air_quality_alerts,
];

$password_changed_at = $customer && isset($customer->password_changed_at)
    ? (string) $customer->password_changed_at
    : '';
$password_status = $password_changed_at
    ? sprintf(
        /* translators: %s: elapsed time since the password was changed. */
        __('Last changed %s ago', 'breathein'),
        human_time_diff(strtotime($password_changed_at), current_time('timestamp', true))
    )
    : __('Password change date unavailable', 'breathein');

$date_of_birth_label = $date_of_birth
    ? wp_date('j F Y', strtotime($date_of_birth))
    : __('Not added', 'breathein');

$profile_editing = 'profile' === sanitize_key(wp_unslash($_GET['breathein_settings_edit'] ?? ''))
    || 'profile' === sanitize_key(wp_unslash($_POST['breathein_settings_action'] ?? ''));
$password_editing = 'password' === sanitize_key(wp_unslash($_GET['breathein_settings_edit'] ?? ''))
    || 'password' === sanitize_key(wp_unslash($_POST['breathein_settings_action'] ?? ''));
$delete_editing = 'delete' === sanitize_key(wp_unslash($_GET['breathein_settings_edit'] ?? ''))
    || 'delete' === sanitize_key(wp_unslash($_POST['breathein_settings_action'] ?? ''));

$profile_value = static function (string $key, string $fallback): string {
    return isset($_POST[$key])
        ? (string) wp_unslash($_POST[$key])
        : $fallback;
};

$render_notification = static function (string $preference, string $label, string $description, bool $enabled, string $border_class = ''): void {
    $next_value = $enabled ? '0' : '1';
    ?>
    <form method="post" class="p-5 lg:p-6 <?php echo esc_attr($border_class); ?> flex items-center justify-between">
        <input type="hidden" name="breathein_settings_action" value="notification">
        <input type="hidden" name="breathein_settings_preference" value="<?php echo esc_attr($preference); ?>">
        <input type="hidden" name="breathein_settings_value" value="<?php echo esc_attr($next_value); ?>">
        <?php wp_nonce_field('breathein_settings', 'breathein_settings_nonce'); ?>
        <div class="flex flex-col pr-4">
            <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200 mb-1">
                <?php echo esc_html($label); ?>
            </div>
            <div class="text-[12px] lg:text-[13px] text-gray-400 font-light">
                <?php echo esc_html($description); ?>
            </div>
        </div>
        <button type="submit" class="w-11 h-6 <?php echo $enabled ? 'bg-[#156E8A] dark:bg-[#2094B6]' : 'bg-gray-200 dark:bg-gray-700'; ?> rounded-full relative transition-colors duration-200 focus:outline-none shrink-0" aria-pressed="<?php echo $enabled ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr(sprintf(__('Toggle %s', 'breathein'), $label)); ?>">
            <span class="absolute <?php echo $enabled ? 'right-0.5' : 'left-0.5'; ?> top-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200"></span>
        </button>
    </form>
    <?php
};
?>

<main class="flex flex-col gap-4 lg:gap-6 w-full breathein-account-settings">
    <h2 class="hidden lg:block text-[20px] font-medium tracking-tight mb-[12px]">
        <?php esc_html_e('Account Settings', 'breathein'); ?>
    </h2>

    <section class="bg-white dark:bg-[#0a0f12] border border-gray-200 dark:border-gray-800 rounded-[2px] flex flex-col transition-colors duration-300">
        <div class="flex items-center justify-between p-5 lg:p-6 border-b border-gray-100 dark:border-gray-900">
            <h3 class="text-[16px] lg:text-[18px] font-medium text-gray-900 dark:text-white">
                <?php esc_html_e('Personal Information', 'breathein'); ?>
            </h3>
            <a href="<?php echo esc_url(add_query_arg('breathein_settings_edit', 'profile', $settings_url)); ?>" data-settings-toggle="profile" data-settings-target="breathein-settings-profile-form" class="text-[#156E8A] dark:text-[#2094B6] text-[13px] font-medium flex items-center gap-1.5 hover:underline">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                <?php esc_html_e('Edit', 'breathein'); ?>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-12 lg:gap-y-8 lg:p-8">
            <div class="p-5 lg:p-0 border-b border-gray-100 dark:border-gray-800 lg:border-none">
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-1.5"><?php esc_html_e('Full Name', 'breathein'); ?></div>
                <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200"><?php echo esc_html(trim($first_name . ' ' . $last_name)); ?></div>
            </div>
            <div class="p-5 lg:p-0 border-b border-gray-100 dark:border-gray-800 lg:border-none">
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-1.5"><?php esc_html_e('Email Address', 'breathein'); ?></div>
                <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200 break-all"><?php echo esc_html($email); ?></div>
            </div>
            <div class="p-5 lg:p-0 border-b border-gray-100 dark:border-gray-800 lg:border-none">
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-1.5"><?php esc_html_e('Phone Number', 'breathein'); ?></div>
                <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200"><?php echo esc_html($phone ?: __('Not added', 'breathein')); ?></div>
            </div>
            <div class="p-5 lg:p-0">
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-1.5"><?php esc_html_e('Date of Birth', 'breathein'); ?></div>
                <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200"><?php echo esc_html($date_of_birth_label); ?></div>
            </div>
        </div>

        <form id="breathein-settings-profile-form" method="post" action="<?php echo esc_url($settings_url); ?>" class="<?php echo $profile_editing ? '' : 'hidden'; ?> border-t border-gray-100 dark:border-gray-900 p-5 lg:p-8">
            <input type="hidden" name="breathein_settings_action" value="profile">
            <?php wp_nonce_field('breathein_settings', 'breathein_settings_nonce'); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('First Name', 'breathein'); ?>
                    <input type="text" name="breathein_settings_first_name" value="<?php echo esc_attr($profile_value('breathein_settings_first_name', $first_name)); ?>" autocomplete="given-name" required class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('Last Name', 'breathein'); ?>
                    <input type="text" name="breathein_settings_last_name" value="<?php echo esc_attr($profile_value('breathein_settings_last_name', $last_name)); ?>" autocomplete="family-name" class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('Email Address', 'breathein'); ?>
                    <input type="email" name="breathein_settings_email" value="<?php echo esc_attr($profile_value('breathein_settings_email', $email)); ?>" autocomplete="email" required class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('Phone Number', 'breathein'); ?>
                    <input type="tel" name="breathein_settings_phone" value="<?php echo esc_attr($profile_value('breathein_settings_phone', $phone)); ?>" autocomplete="tel" class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('Date of Birth', 'breathein'); ?>
                    <input type="date" name="breathein_settings_date_of_birth" value="<?php echo esc_attr($profile_value('breathein_settings_date_of_birth', $date_of_birth)); ?>" class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="bg-[#156E8A] text-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.15em] rounded-sm hover:bg-[#115a72] transition-colors"><?php esc_html_e('Save Changes', 'breathein'); ?></button>
                <a href="<?php echo esc_url($settings_url); ?>" data-settings-cancel="profile" class="border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-5 py-3 text-[11px] font-bold uppercase tracking-[0.15em] rounded-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"><?php esc_html_e('Cancel', 'breathein'); ?></a>
            </div>
        </form>
    </section>

    <section class="bg-white dark:bg-[#0a0f12] border border-gray-200 dark:border-gray-800 rounded-[2px] flex flex-col transition-colors duration-300">
        <div class="p-5 lg:p-6 border-b border-gray-100 dark:border-gray-900">
            <h3 class="text-[16px] lg:text-[18px] font-medium text-gray-900 dark:text-white"><?php esc_html_e('Security', 'breathein'); ?></h3>
        </div>
        <div class="p-5 lg:p-6 flex items-center justify-between gap-4">
            <div class="flex flex-col">
                <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200 mb-1"><?php esc_html_e('Password', 'breathein'); ?></div>
                <div class="text-[12px] lg:text-[13px] text-gray-400 font-light"><?php echo esc_html($password_status); ?></div>
            </div>
            <a href="<?php echo esc_url(add_query_arg('breathein_settings_edit', 'password', $settings_url)); ?>" data-settings-toggle="password" data-settings-target="breathein-settings-password-form" class="border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white px-4 md:px-5 py-2 md:py-2.5 text-[12px] md:text-[13px] font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors rounded-[2px] shrink-0"><?php esc_html_e('Change Password', 'breathein'); ?></a>
        </div>
        <form id="breathein-settings-password-form" method="post" action="<?php echo esc_url($settings_url); ?>" class="<?php echo $password_editing ? '' : 'hidden'; ?> border-t border-gray-100 dark:border-gray-900 p-5 lg:p-8">
            <input type="hidden" name="breathein_settings_action" value="password">
            <?php wp_nonce_field('breathein_settings', 'breathein_settings_nonce'); ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('Current Password', 'breathein'); ?>
                    <input type="password" name="breathein_settings_current_password" autocomplete="current-password" required class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('New Password', 'breathein'); ?>
                    <input type="password" name="breathein_settings_new_password" autocomplete="new-password" minlength="8" required class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
                <label class="flex flex-col gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                    <?php esc_html_e('Confirm Password', 'breathein'); ?>
                    <input type="password" name="breathein_settings_confirm_password" autocomplete="new-password" minlength="8" required class="w-full border border-gray-200 dark:border-gray-700 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#156E8A] focus:outline-none">
                </label>
            </div>
            <button type="submit" class="mt-6 bg-[#156E8A] text-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.15em] rounded-sm hover:bg-[#115a72] transition-colors"><?php esc_html_e('Update Password', 'breathein'); ?></button>
        </form>
    </section>

    <section class="bg-white dark:bg-[#0a0f12] border border-gray-200 dark:border-gray-800 rounded-[2px] flex flex-col transition-colors duration-300">
        <div class="p-5 lg:p-6 border-b border-gray-100 dark:border-gray-900">
            <h3 class="text-[16px] lg:text-[18px] font-medium text-gray-900 dark:text-white"><?php esc_html_e('Notifications', 'breathein'); ?></h3>
        </div>
        <div class="flex flex-col">
            <?php $render_notification('order_updates', __('Order updates', 'breathein'), __('Shipping, delivery, and order status', 'breathein'), $notification_preferences['order_updates'], 'border-b border-gray-100 dark:border-gray-900'); ?>
            <?php $render_notification('promotions', __('Promotions & offers', 'breathein'), __('Deals, new products, and seasonal sales', 'breathein'), $notification_preferences['promotions'], 'border-b border-gray-100 dark:border-gray-900'); ?>
            <?php $render_notification('air_quality_alerts', __('Air quality alerts', 'breathein'), __('Notifications when AQI spikes in your area', 'breathein'), $notification_preferences['air_quality_alerts']); ?>
        </div>
    </section>

    <section class="bg-white dark:bg-[#0a0f12] border border-red-200 dark:border-red-900/40 border-l-[3px] border-l-[#EF4444] rounded-[2px] flex flex-col transition-colors duration-300">
        <div class="flex items-center justify-between gap-4 p-5 lg:p-6">
            <div class="flex flex-col pr-4">
                <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-gray-200 mb-1"><?php esc_html_e('Delete Account', 'breathein'); ?></div>
                <div class="text-[12px] lg:text-[13px] text-gray-400 font-light"><?php esc_html_e('Permanently delete your account and all associated data.', 'breathein'); ?></div>
            </div>
            <a href="<?php echo esc_url(add_query_arg('breathein_settings_edit', 'delete', $settings_url)); ?>" data-settings-toggle="delete" data-settings-target="breathein-settings-delete-form" class="border border-[#EF4444]/40 text-[#EF4444] px-4 md:px-6 py-2 md:py-2.5 text-[12px] md:text-[13px] font-medium hover:bg-[#EF4444] hover:text-white transition-colors rounded-[2px] shrink-0"><?php esc_html_e('Delete Account', 'breathein'); ?></a>
        </div>
        <form id="breathein-settings-delete-form" method="post" action="<?php echo esc_url($settings_url); ?>" class="<?php echo $delete_editing ? '' : 'hidden'; ?> border-t border-red-100 dark:border-red-900/40 p-5 lg:p-6">
            <input type="hidden" name="breathein_settings_action" value="delete">
            <?php wp_nonce_field('breathein_settings', 'breathein_settings_nonce'); ?>
            <label class="block max-w-md text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">
                <?php esc_html_e('Current Password', 'breathein'); ?>
                <input type="password" name="breathein_delete_password" autocomplete="current-password" required class="mt-2 w-full border border-red-200 dark:border-red-900/50 bg-transparent px-4 py-3 text-sm font-normal normal-case tracking-normal text-gray-900 dark:text-white focus:border-[#EF4444] focus:outline-none">
            </label>
            <p class="mt-3 text-[12px] text-red-500"><?php esc_html_e('This action cannot be undone.', 'breathein'); ?></p>
            <div class="flex items-center gap-3 mt-5">
                <button type="submit" class="border border-[#EF4444] bg-[#EF4444] text-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.15em] rounded-sm hover:bg-red-700 transition-colors" onclick="return window.confirm('<?php echo esc_js(__('Delete your account permanently?', 'breathein')); ?>');"><?php esc_html_e('Confirm Delete', 'breathein'); ?></button>
                <a href="<?php echo esc_url($settings_url); ?>" class="border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-5 py-3 text-[11px] font-bold uppercase tracking-[0.15em] rounded-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"><?php esc_html_e('Cancel', 'breathein'); ?></a>
            </div>
        </form>
    </section>
</main>
