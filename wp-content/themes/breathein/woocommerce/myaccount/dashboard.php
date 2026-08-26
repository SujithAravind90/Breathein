<?php
/**
 * Breathein account overview.
 *
 * The visual structure mirrors the supplied account design while all values
 * are read from the current WooCommerce customer and their orders.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();
$user = isset($current_user) && $current_user instanceof WP_User
    ? $current_user
    : wp_get_current_user();

$all_orders = function_exists('wc_get_orders')
    ? wc_get_orders([
        'customer_id' => $customer_id,
        'limit' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'objects',
    ])
    : [];

$all_orders = is_array($all_orders) ? $all_orders : [];
$total_spent = 0.0;
$excluded_statuses = ['cancelled', 'failed', 'refunded'];

foreach ($all_orders as $customer_order) {
    if (!$customer_order instanceof WC_Order) {
        continue;
    }

    if (!in_array($customer_order->get_status(), $excluded_statuses, true)) {
        $total_spent += (float) $customer_order->get_total();
    }
}

$recent_orders = array_slice($all_orders, 0, 3);
$member_since = !empty($user->user_registered)
    ? wp_date('M Y', strtotime($user->user_registered))
    : '';
$loyalty_points = get_user_meta($customer_id, 'breathein_loyalty_points', true);
$loyalty_points = '' !== (string) $loyalty_points ? absint($loyalty_points) : null;
$orders_url = wc_get_account_endpoint_url('orders');
$addresses_url = wc_get_account_endpoint_url('edit-address');
$collection_page = get_page_by_path('products');
$collection_url = $collection_page
    ? get_permalink($collection_page)
    : apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('products'));

$billing_address = function_exists('wc_get_account_formatted_address')
    ? wc_get_account_formatted_address('billing')
    : '';

$device_name = trim((string) get_user_meta($customer_id, 'breathein_device_name', true));
$device_aqi = trim((string) get_user_meta($customer_id, 'breathein_device_aqi', true));
$device_filter = trim((string) get_user_meta($customer_id, 'breathein_device_filter_life', true));
$device_connected = '' !== $device_name || '' !== $device_aqi || '' !== $device_filter;
$support_page = get_page_by_path('support');
$support_url = $support_page ? get_permalink($support_page) : wc_get_account_endpoint_url('edit-account');

$status_classes = static function (string $status): string {
    $classes = [
        'completed' => 'bg-[#E8F5E9] dark:bg-[#064E3B] text-[#10B981] dark:text-[#34D399]',
        'processing' => 'bg-[#E0F2FE] dark:bg-[#075985] text-[#0284C7] dark:text-[#38BDF8]',
        'on-hold' => 'bg-[#FEF3C7] dark:bg-[#78350F] text-[#D97706] dark:text-[#FBBF24]',
        'pending' => 'bg-[#FEF3C7] dark:bg-[#78350F] text-[#D97706] dark:text-[#FBBF24]',
        'cancelled' => 'bg-[#FEE2E2] dark:bg-[#7F1D1D] text-[#DC2626] dark:text-[#FCA5A5]',
        'failed' => 'bg-[#FEE2E2] dark:bg-[#7F1D1D] text-[#DC2626] dark:text-[#FCA5A5]',
        'refunded' => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300',
    ];

    return $classes[$status] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300';
};
?>

<div class="breathein-account-overview flex flex-col gap-6 lg:gap-8">
    <h2 class="hidden lg:block text-[20px] font-medium tracking-tight mb-[-12px]">
        <?php esc_html_e('Overview', 'breathein'); ?>
    </h2>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="border border-gray-200 dark:border-gray-800 p-5 md:p-6 flex flex-col justify-between">
            <div class="text-[10px] text-gray-400 uppercase tracking-[0.15em] font-bold mb-3 md:mb-4">
                <span class="md:hidden"><?php esc_html_e('Orders', 'breathein'); ?></span>
                <span class="hidden md:inline"><?php esc_html_e('Total Orders', 'breathein'); ?></span>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-medium mb-1 md:mb-2 tracking-tight">
                    <?php echo esc_html(count($all_orders)); ?>
                </div>
                <div class="text-[12px] text-gray-400 font-light">
                    <span class="md:hidden"><?php esc_html_e('all time', 'breathein'); ?></span>
                    <span class="hidden md:inline"><?php esc_html_e('across all time', 'breathein'); ?></span>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 dark:border-gray-800 p-5 md:p-6 flex flex-col justify-between">
            <div class="text-[10px] text-gray-400 uppercase tracking-[0.15em] font-bold mb-3 md:mb-4">
                <span class="md:hidden"><?php esc_html_e('Spent', 'breathein'); ?></span>
                <span class="hidden md:inline"><?php esc_html_e('Total Spent', 'breathein'); ?></span>
            </div>
            <div>
                <div class="text-2xl md:text-4xl font-medium mb-1 md:mb-2 tracking-tight whitespace-nowrap">
                    <?php echo wp_kses_post(wc_price($total_spent)); ?>
                </div>
                <div class="text-[12px] text-gray-400 font-light">
                    <span class="md:hidden"><?php esc_html_e('lifetime', 'breathein'); ?></span>
                    <span class="hidden md:inline"><?php esc_html_e('lifetime spend', 'breathein'); ?></span>
                </div>
            </div>
        </div>

        <div
            class="col-span-2 lg:col-span-1 border border-gray-200 dark:border-gray-800 p-5 md:p-6 flex flex-col justify-between">
            <div class="text-[10px] text-gray-400 uppercase tracking-[0.15em] font-bold mb-3 md:mb-4">
                <?php echo $loyalty_points !== null ? esc_html__('Loyalty Points', 'breathein') : esc_html__('Member Since', 'breathein'); ?>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-medium mb-1 md:mb-2 tracking-tight">
                    <?php if ($loyalty_points !== null): ?>
                        <?php echo esc_html(number_format_i18n($loyalty_points)); ?> <span
                            class="text-lg md:text-2xl"><?php esc_html_e('pts', 'breathein'); ?></span>
                    <?php else: ?>
                        <?php echo esc_html($member_since ?: '—'); ?>
                    <?php endif; ?>
                </div>
                <div class="text-[12px] text-gray-400 font-light">
                    <?php if ($loyalty_points !== null): ?>
                        <?php echo esc_html(sprintf(__('approx. %s off next order', 'breathein'), wp_strip_all_tags(wc_price($loyalty_points / 10)))); ?>
                    <?php else: ?>
                        <?php esc_html_e('your Breathe In membership', 'breathein'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <section class="border border-gray-200 dark:border-gray-800 flex flex-col" aria-labelledby="recent-orders-heading">
        <div class="flex items-center justify-between p-5 lg:p-6 border-b border-gray-100 dark:border-gray-900">
            <h3 id="recent-orders-heading" class="text-[15px] lg:text-[16px] font-medium">
                <?php esc_html_e('Recent Orders', 'breathein'); ?>
            </h3>
            <a href="<?php echo esc_url($orders_url); ?>"
                class="text-[#156E8A] dark:text-[#2094B6] text-[12px] font-medium flex items-center gap-1 hover:underline"><?php esc_html_e('View All', 'breathein'); ?>
                &gt;</a>
        </div>

        <?php if ($recent_orders): ?>
            <?php foreach ($recent_orders as $order): ?>
                <?php
                $items = $order->get_items();
                $first_item = $items ? reset($items) : false;
                $product = $first_item ? $first_item->get_product() : false;
                $product_name = $first_item ? $first_item->get_name() : __('Order items', 'breathein');
                $product_image = $product ? $product->get_image('thumbnail', ['class' => 'w-10 h-10 object-contain']) : wc_placeholder_img('thumbnail', ['class' => 'w-10 h-10 object-contain']);
                $order_status = $order->get_status();
                $order_date = $order->get_date_created() ? wc_format_datetime($order->get_date_created()) : '';
                $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                ?>
                <a href="<?php echo esc_url($order->get_view_order_url()); ?>"
                    class="p-5 lg:p-6 border-b border-gray-100 dark:border-gray-900 last:border-b-0 flex items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                    <div class="flex items-start lg:items-center gap-4 lg:gap-5 min-w-0 flex-1">
                        <div
                            class="w-12 h-12 bg-[#F9FAFB] dark:bg-[#0c1318] border border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0 overflow-hidden">
                            <?php echo wp_kses_post($product_image); ?>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="text-[14px] lg:text-[15px] font-medium mb-0.5 truncate">
                                <?php echo esc_html($product_name); ?>
                            </div>
                            <div class="text-[12px] text-gray-400 font-light lg:hidden mb-2">
                                <?php echo esc_html($order_date); ?>         <?php if ($item_count > 1): ?> ·
                                    <?php echo esc_html(sprintf(_n('%s item', '%s items', $item_count, 'breathein'), number_format_i18n($item_count))); ?>
                                <?php endif; ?>
                            </div>
                            <div class="text-[12px] text-gray-400 font-light hidden lg:block">
                                <?php echo esc_html($order_date); ?>         <?php if ($item_count > 1): ?> ·
                                    <?php echo esc_html(sprintf(_n('%s item', '%s items', $item_count, 'breathein'), number_format_i18n($item_count))); ?>
                                <?php endif; ?>
                            </div>
                            <span
                                class="lg:hidden <?php echo esc_attr($status_classes($order_status)); ?> text-[9px] font-bold uppercase tracking-[0.1em] px-2 py-1 w-max rounded-sm"><?php echo esc_html(wc_get_order_status_name($order_status)); ?></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-6 shrink-0">
                        <span
                            class="hidden lg:inline <?php echo esc_attr($status_classes($order_status)); ?> text-[9px] font-bold uppercase tracking-[0.1em] px-2.5 py-1 rounded-sm"><?php echo esc_html(wc_get_order_status_name($order_status)); ?></span>
                        <span
                            class="text-[14px] font-medium"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-8 text-center">
                <p class="text-sm text-gray-500 mb-4"><?php esc_html_e('You have not placed an order yet.', 'breathein'); ?>
                </p>
                <a href="<?php echo esc_url($collection_url); ?>"
                    class="inline-flex items-center justify-center bg-[#156E8A] text-white px-5 py-3 text-[10px] font-bold uppercase tracking-[0.2em] rounded-sm hover:bg-[#115a72] transition-colors"><?php esc_html_e('Explore Collection', 'breathein'); ?></a>
            </div>
        <?php endif; ?>
    </section>

    <section class="border border-gray-200 dark:border-gray-800 flex flex-col"
        aria-labelledby="saved-addresses-heading">
        <div class="flex items-center justify-between p-5 lg:p-6 border-b border-gray-100 dark:border-gray-900">
            <h3 id="saved-addresses-heading" class="text-[15px] lg:text-[16px] font-medium"><span
                    class="lg:hidden"><?php esc_html_e('Default Address', 'breathein'); ?></span><span
                    class="hidden lg:inline"><?php esc_html_e('Saved Addresses', 'breathein'); ?></span></h3>
            <a href="<?php echo esc_url($addresses_url); ?>"
                class="text-[#156E8A] dark:text-[#2094B6] text-[12px] font-medium flex items-center gap-1 hover:underline"><?php esc_html_e('Manage', 'breathein'); ?>
                &gt;</a>
        </div>
        <div class="p-5 lg:p-6 flex items-start gap-4 lg:gap-5">
            <div class="w-10 h-10 bg-[#F9FAFB] dark:bg-[#0c1318] border border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0 text-[#156E8A] dark:text-[#2094B6]"
                aria-hidden="true"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg></div>
            <div class="flex flex-col min-w-0">
                <?php if ($billing_address): ?>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="text-[14px] lg:text-[15px] font-medium">
                            <?php esc_html_e('Billing Address', 'breathein'); ?>
                        </div><span
                            class="hidden lg:block bg-[#E0F2FE] dark:bg-[#075985] text-[#0284C7] dark:text-[#38BDF8] text-[8px] font-bold uppercase tracking-[0.1em] px-1.5 py-0.5 rounded-sm"><?php esc_html_e('Default', 'breathein'); ?></span>
                    </div>
                    <div class="breathein-account-address text-[13px] text-gray-400 font-light leading-relaxed">
                        <?php echo wp_kses_post($billing_address); ?>
                    </div>
                <?php else: ?>
                    <div class="text-[14px] lg:text-[15px] font-medium mb-1">
                        <?php esc_html_e('No billing address saved', 'breathein'); ?>
                    </div>
                    <div class="text-[13px] text-gray-400 font-light leading-relaxed">
                        <?php esc_html_e('Add an address to speed up your next checkout.', 'breathein'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section
        class="border border-[#156E8A] dark:border-[#2094B6] bg-[#FAFCFD] dark:bg-[#080d10] flex flex-col md:flex-row items-start md:items-center p-5 lg:p-6 gap-5 justify-between"
        aria-labelledby="device-status-heading">
        <div class="flex flex-row items-center gap-4 lg:gap-5 w-full md:w-auto">
            <div class="w-12 h-12 bg-[#156E8A] dark:bg-[#2094B6] text-white flex items-center justify-center shrink-0"
                aria-hidden="true"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path d="M3 12h5l2-6 4 12 2-6h5" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg></div>
            <div class="flex flex-col">
                <?php if ($device_connected): ?>
                    <div id="device-status-heading"
                        class="text-[14px] lg:text-[15px] font-medium mb-0.5 text-gray-900 dark:text-white">
                        <?php echo esc_html($device_name ?: __('Your Breathe In purifier is connected', 'breathein')); ?>
                    </div>
                    <div class="text-[12px] text-gray-500 dark:text-gray-400 font-light hidden lg:block">
                        <?php esc_html_e('Connected', 'breathein'); ?>     <?php if ($device_aqi): ?> ·
                            <?php echo esc_html(sprintf(__('AQI Indoor: %s', 'breathein'), $device_aqi)); ?>     <?php endif; ?>
                        <?php if ($device_filter): ?>
                            ·
                            <?php echo esc_html(sprintf(__('Filter life: %s', 'breathein'), $device_filter)); ?>     <?php endif; ?>
                    </div>
                    <div class="text-[12px] text-gray-400 font-light lg:hidden">
                        <?php echo esc_html($device_aqi ? sprintf(__('Indoor AQI: %s', 'breathein'), $device_aqi) : __('Connected device', 'breathein')); ?>
                        <?php if ($device_filter): ?>
                            · <?php echo esc_html(sprintf(__('Filter: %s', 'breathein'), $device_filter)); ?><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div id="device-status-heading"
                        class="text-[14px] lg:text-[15px] font-medium mb-0.5 text-gray-900 dark:text-white">
                        <?php esc_html_e('Connect your Breathe In purifier', 'breathein'); ?>
                    </div>
                    <div class="text-[12px] text-gray-500 dark:text-gray-400 font-light">
                        <?php esc_html_e('Device status will appear here after your purifier is connected.', 'breathein'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php echo esc_url($support_url); ?>"
            class="w-full md:w-auto bg-[#156E8A] text-white px-5 py-3 md:py-2.5 text-[10px] font-bold uppercase tracking-[0.2em] flex items-center justify-center gap-2 hover:bg-[#115a72] transition-colors shrink-0 rounded-sm"><?php echo esc_html($device_connected ? __('Open App', 'breathein') : __('Get Support', 'breathein')); ?>
            &rarr;</a>
    </section>
</div>

<?php
do_action('woocommerce_account_dashboard');
do_action('woocommerce_before_my_account');
do_action('woocommerce_after_my_account');
