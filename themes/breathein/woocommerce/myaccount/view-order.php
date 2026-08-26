<?php
/**
 * Breathein single order view.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
$status_name = wc_get_order_status_name($order->get_status());
?>

<div class="breathein-account-order-view flex flex-col gap-6 lg:gap-8">
    <div class="flex flex-col gap-3">
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="text-[#156E8A] dark:text-[#2094B6] text-[12px] font-medium hover:underline">&larr; <?php esc_html_e('Back to My Orders', 'breathein'); ?></a>
        <div>
            <div class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-bold mb-2"><?php esc_html_e('Order Details', 'breathein'); ?></div>
            <h2 class="text-2xl lg:text-3xl font-light tracking-tight"><?php echo esc_html(sprintf(__('Order #%s', 'breathein'), $order->get_order_number())); ?></h2>
        </div>
    </div>

    <div class="border border-gray-200 dark:border-gray-800 p-5 lg:p-6 text-sm text-gray-500">
        <?php
        echo wp_kses_post(
            apply_filters(
                'woocommerce_order_details_status',
                sprintf(
                    /* translators: 1: order number 2: order date 3: order status */
                    esc_html__('Placed on %1$s and currently %2$s.', 'breathein'),
                    '<strong class="text-gray-900 dark:text-white">' . esc_html(wc_format_datetime($order->get_date_created())) . '</strong>',
                    '<strong class="text-[#156E8A]">' . esc_html($status_name) . '</strong>'
                ),
                $order
            )
        );
        ?>
    </div>

    <?php if ($notes) : ?>
        <section class="border border-gray-200 dark:border-gray-800 p-5 lg:p-6">
            <h3 class="text-[15px] lg:text-[16px] font-medium mb-4"><?php esc_html_e('Order Updates', 'breathein'); ?></h3>
            <ol class="woocommerce-OrderUpdates commentlist notes flex flex-col gap-4">
                <?php foreach ($notes as $note) : ?>
                    <li class="woocommerce-OrderUpdate comment note text-sm text-gray-500">
                        <p class="woocommerce-OrderUpdate-meta meta text-xs text-gray-400 mb-1"><?php echo esc_html(date_i18n(esc_html__('l jS \o\f F Y, h:ia', 'woocommerce'), strtotime($note->comment_date))); ?></p>
                        <div class="woocommerce-OrderUpdate-description description"><?php echo wp_kses_post(wpautop(wptexturize($note->comment_content))); ?></div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>
    <?php endif; ?>

    <div class="breathein-order-details-table border border-gray-200 dark:border-gray-800 p-5 lg:p-6">
        <?php do_action('woocommerce_view_order', $order_id); ?>
    </div>
</div>
