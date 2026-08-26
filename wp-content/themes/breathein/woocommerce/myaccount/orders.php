<?php
/**
 * Breathein My Orders page.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

$customer_orders = wc_get_orders([
    'customer_id' => get_current_user_id(),
    'limit' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'return' => 'objects',
]);

$customer_orders = is_array($customer_orders) ? $customer_orders : [];
$has_orders = !empty($customer_orders);
$has_other_status = false;

$status_data = static function (string $status) use (&$has_other_status): array {
    $status = sanitize_key($status);

    if ('completed' === $status) {
        return [
            'filter' => 'delivered',
            'label' => __('Delivered', 'breathein'),
            'class' => 'bg-[#E8F5E9] dark:bg-[#064E3B] text-[#10B981] dark:text-[#34D399]',
        ];
    }

    if (in_array($status, ['processing', 'pending', 'on-hold'], true)) {
        return [
            'filter' => 'processing',
            'label' => wc_get_order_status_name($status),
            'class' => 'bg-[#E0F2FE] dark:bg-[#075985] text-[#0284C7] dark:text-[#38BDF8]',
        ];
    }

    $has_other_status = true;

    return [
        'filter' => 'other',
        'label' => wc_get_order_status_name($status),
        'class' => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300',
    ];
};

$product_meta = static function ($product): string {
    if (!$product || !method_exists($product, 'get_attribute_summary')) {
        return '';
    }

    return trim((string) $product->get_attribute_summary());
};

$orders_with_status = [];

foreach ($customer_orders as $order) {
    $items = $order->get_items();
    $first_item = $items ? reset($items) : false;
    $product = $first_item ? $first_item->get_product() : false;

    $orders_with_status[] = [
        'order' => $order,
        'status' => $status_data($order->get_status()),
        'item' => $first_item,
        'product' => $product,
        'product_meta' => $product_meta($product),
    ];
}

do_action('woocommerce_before_account_orders', $has_orders);
?>

<div class="breathein-account-orders flex flex-col w-full">
    <h2 class="hidden lg:block text-[20px] font-medium tracking-tight mb-[12px]">
        <?php esc_html_e('My Orders', 'breathein'); ?></h2>

    <?php if ($has_orders): ?>
        <div class="flex items-center gap-2 mb-6 lg:mb-8 overflow-x-auto breathein-account-nav-scroll" role="group"
            aria-label="<?php esc_attr_e('Filter orders', 'breathein'); ?>">
            <button type="button" data-order-filter="all" aria-pressed="true"
                class="order-filter-btn active bg-[#156E8A] dark:bg-[#2094B6] text-white border border-[#156E8A] px-4 md:px-5 py-2 md:py-2.5 text-[10px] md:text-[11px] font-bold uppercase tracking-wider shrink-0 transition-colors"><span
                    class="md:hidden"><?php esc_html_e('All', 'breathein'); ?></span><span
                    class="hidden md:inline"><?php esc_html_e('All Orders', 'breathein'); ?></span></button>
            <button type="button" data-order-filter="delivered" aria-pressed="false"
                class="order-filter-btn bg-white dark:bg-[#111a20] text-gray-400 border border-gray-200 dark:border-gray-700 hover:text-gray-900 dark:hover:text-white px-4 md:px-5 py-2 md:py-2.5 text-[10px] md:text-[11px] font-bold uppercase tracking-wider shrink-0 transition-colors"><?php esc_html_e('Delivered', 'breathein'); ?></button>
            <button type="button" data-order-filter="processing" aria-pressed="false"
                class="order-filter-btn bg-white dark:bg-[#111a20] text-gray-400 border border-gray-200 dark:border-gray-700 hover:text-gray-900 dark:hover:text-white px-4 md:px-5 py-2 md:py-2.5 text-[10px] md:text-[11px] font-bold uppercase tracking-wider shrink-0 transition-colors"><?php esc_html_e('Processing', 'breathein'); ?></button>
            <?php if ($has_other_status): ?>
                <button type="button" data-order-filter="other" aria-pressed="false"
                    class="order-filter-btn bg-white dark:bg-[#111a20] text-gray-400 border border-gray-200 dark:border-gray-700 hover:text-gray-900 dark:hover:text-white px-4 md:px-5 py-2 md:py-2.5 text-[10px] md:text-[11px] font-bold uppercase tracking-wider shrink-0 transition-colors"><?php esc_html_e('Other', 'breathein'); ?></button>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-4 lg:gap-0 lg:border lg:border-gray-200 lg:dark:border-gray-800">
            <div
                class="hidden lg:grid grid-cols-12 items-center px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-[#F9FAFB] dark:bg-[#0c1318]">
                <div class="col-span-4 text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                    <?php esc_html_e('Product', 'breathein'); ?></div>
                <div class="col-span-3 text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                    <?php esc_html_e('Order ID', 'breathein'); ?></div>
                <div class="col-span-2 text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                    <?php esc_html_e('Status', 'breathein'); ?></div>
                <div class="col-span-3 text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                    <?php esc_html_e('Amount', 'breathein'); ?></div>
            </div>

            <?php foreach ($orders_with_status as $order_data): ?>
                <?php
                $order = $order_data['order'];
                $status = $order_data['status'];
                $first_item = $order_data['item'];
                $product = $order_data['product'];
                $product_subtitle = $order_data['product_meta'];
                $product_name = $first_item ? $first_item->get_name() : __('Order items', 'breathein');
                $product_image = $product
                    ? $product->get_image('thumbnail', ['class' => 'w-10 h-10 object-contain'])
                    : wc_placeholder_img('thumbnail', ['class' => 'w-10 h-10 object-contain']);
                $order_date = $order->get_date_created() ? wc_format_datetime($order->get_date_created()) : '';
                $item_count = max(0, $order->get_item_count() - $order->get_item_count_refunded());
                ?>
                <div data-order-status="<?php echo esc_attr($status['filter']); ?>"
                    class="order-item flex flex-col lg:grid lg:grid-cols-12 lg:items-center bg-white dark:bg-[#0a0f12] border border-gray-200 dark:border-gray-800 lg:border-0 lg:border-b lg:border-gray-200 lg:dark:border-gray-800 p-0 lg:px-6 lg:py-5 lg:last:border-b-0 rounded-[2px] lg:rounded-none w-full">
                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>"
                        class="flex items-center gap-4 lg:col-span-4 w-full pl-4 pt-4 lg:p-0 hover:opacity-80 transition-opacity">
                        <div
                            class="w-12 h-12 bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0 overflow-hidden">
                            <?php echo wp_kses_post($product_image); ?></div>
                        <div class="flex flex-col min-w-0">
                            <div class="text-[14px] lg:text-[15px] font-medium text-gray-900 dark:text-white truncate">
                                <?php echo esc_html($product_name); ?></div>
                            <div class="text-[12px] lg:text-[13px] text-gray-400 font-light truncate">
                                <?php echo esc_html($product_subtitle ?: __('Breathe In product', 'breathein')); ?><span
                                    class="hidden lg:inline">&middot; <?php echo esc_html($order_date); ?></span></div>
                        </div>
                    </a>

                    <div
                        class="flex items-end justify-between w-full lg:hidden pt-4 mt-4 border-t border-gray-200 dark:border-gray-800/50 p-4">
                        <div class="flex flex-col gap-1">
                            <div class="text-[12px] text-gray-400 font-light"><?php echo esc_html($order_date); ?></div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest">
                                <?php echo esc_html(sprintf(__('Order #%s', 'breathein'), $order->get_order_number())); ?></div>
                        </div>
                        <div class="flex items-center gap-3"><span
                                class="<?php echo esc_attr($status['class']); ?> text-[9px] font-bold uppercase tracking-[0.1em] px-2 py-1 rounded-sm"><?php echo esc_html($status['label']); ?></span><span
                                class="text-[14px] font-medium"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                        </div>
                    </div>

                    <div class="hidden lg:block lg:col-span-3 text-[13px] text-gray-400 font-light">
                        <?php echo esc_html('#' . $order->get_order_number()); ?>        <?php if ($item_count > 1): ?><span
                                class="block text-[11px] mt-1"><?php echo esc_html(sprintf(_n('%s item', '%s items', $item_count, 'breathein'), number_format_i18n($item_count))); ?></span><?php endif; ?>
                    </div>
                    <div class="hidden lg:block lg:col-span-2"><span
                            class="<?php echo esc_attr($status['class']); ?> text-[9px] font-bold uppercase tracking-[0.1em] px-2.5 py-1.5 rounded-sm"><?php echo esc_html($status['label']); ?></span>
                    </div>
                    <div class="hidden lg:flex lg:col-span-3 items-center justify-between gap-4"><span
                            class="text-[15px] font-medium text-gray-900 dark:text-white"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span><a
                            href="<?php echo esc_url($order->get_view_order_url()); ?>"
                            class="text-[#156E8A] dark:text-[#2094B6] text-[13px] font-medium hover:underline"><?php esc_html_e('Details', 'breathein'); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div data-order-filter-empty class="hidden p-8 text-center text-sm text-gray-500">
                <?php esc_html_e('No orders match this filter.', 'breathein'); ?></div>
        </div>
    <?php else: ?>
        <div class="border border-gray-200 dark:border-gray-800 p-8 lg:p-12 text-center">
            <p class="text-sm text-gray-500 mb-5"><?php esc_html_e('You have not placed any orders yet.', 'breathein'); ?>
            </p>
            <?php $collection_page = get_page_by_path('products');
            $collection_url = $collection_page ? get_permalink($collection_page) : apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop')); ?>
            <a href="<?php echo esc_url($collection_url); ?>"
                class="inline-flex items-center justify-center bg-[#156E8A] text-white px-5 py-3 text-[10px] font-bold uppercase tracking-[0.2em] rounded-sm hover:bg-[#115a72] transition-colors"><?php esc_html_e('Explore Collection', 'breathein'); ?></a>
        </div>
    <?php endif; ?>
</div>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>