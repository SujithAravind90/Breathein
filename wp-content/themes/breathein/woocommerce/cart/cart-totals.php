<?php

/**
 * Cart totals
 *
 * @package Breathein
 * @version 2.3.6
 */

defined('ABSPATH') || exit;

if (!WC()->cart->needs_shipping()) {
    $delivery_message = __('No delivery required', 'breathein');
} elseif (
    WC()->cart->show_shipping()
    && (float) WC()->cart->get_shipping_total() <= 0
) {
    $delivery_message = __('Free delivery', 'breathein');
} else {
    $delivery_message = __('Delivery calculated at checkout', 'breathein');
}
?>

<div
    class="cart_totals <?php echo WC()->customer->has_calculated_shipping() ? 'calculated_shipping' : ''; ?>"
    aria-live="polite">
    <?php do_action('woocommerce_before_cart_totals'); ?>

    <div class="rounded-[2px] border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-tickerDark md:p-8 lg:shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
        <h2 class="mb-8 text-2xl font-normal text-gray-900 dark:text-white">
            <?php esc_html_e('Order Summary', 'breathein'); ?>
        </h2>

        <div class="mb-6 flex flex-col gap-4">
            <div class="cart-subtotal flex items-center justify-between text-[13px] md:text-[14px]">
                <span class="text-gray-500 dark:text-gray-400">
                    <?php esc_html_e('Subtotal', 'woocommerce'); ?>
                </span>
                <span class="text-gray-900 dark:text-gray-300">
                    <?php wc_cart_totals_subtotal_html(); ?>
                </span>
            </div>

            <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                <div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> flex items-start justify-between gap-4 text-[13px] md:text-[14px]">
                    <span class="text-gray-500 dark:text-gray-400">
                        <?php echo wp_kses_post(wc_cart_totals_coupon_label($coupon, false)); ?>
                    </span>
                    <span class="text-right text-[#2C7A53] dark:text-[#4ADE80]">
                        <?php wc_cart_totals_coupon_html($coupon); ?>
                    </span>
                </div>
            <?php endforeach; ?>

            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                <?php do_action('woocommerce_cart_totals_before_shipping'); ?>

                <div class="breathein-cart-shipping">
                    <table class="w-full">
                        <tbody>
                            <?php wc_cart_totals_shipping_html(); ?>
                        </tbody>
                    </table>
                </div>

                <?php do_action('woocommerce_cart_totals_after_shipping'); ?>
            <?php else : ?>
                <div class="shipping flex items-center justify-between gap-4 text-[13px] md:text-[14px]">
                    <span class="text-gray-500 dark:text-gray-400">
                        <?php esc_html_e('Shipping', 'woocommerce'); ?>
                    </span>
                    <span class="text-right text-gray-900 dark:text-gray-300">
                        <?php
                        if (WC()->cart->needs_shipping()) {
                            esc_html_e('Calculated at checkout', 'woocommerce');
                        } else {
                            esc_html_e('Not required', 'woocommerce');
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php foreach (WC()->cart->get_fees() as $fee) : ?>
                <div class="fee flex items-center justify-between gap-4 text-[13px] md:text-[14px]">
                    <span class="text-gray-500 dark:text-gray-400">
                        <?php echo esc_html($fee->name); ?>
                    </span>
                    <span class="text-gray-900 dark:text-gray-300">
                        <?php wc_cart_totals_fee_html($fee); ?>
                    </span>
                </div>
            <?php endforeach; ?>

            <?php
            if (
                wc_tax_enabled()
                && !WC()->cart->display_prices_including_tax()
            ) {
                if ('itemized' === get_option('woocommerce_tax_total_display')) {
                    foreach (WC()->cart->get_tax_totals() as $tax) {
                        ?>
                        <div class="tax-rate flex items-center justify-between gap-4 text-[13px] md:text-[14px]">
                            <span class="text-gray-500 dark:text-gray-400">
                                <?php echo esc_html($tax->label); ?>
                            </span>
                            <span class="text-gray-900 dark:text-gray-300">
                                <?php echo wp_kses_post($tax->formatted_amount); ?>
                            </span>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="tax-total flex items-center justify-between gap-4 text-[13px] md:text-[14px]">
                        <span class="text-gray-500 dark:text-gray-400">
                            <?php echo esc_html(WC()->countries->tax_or_vat()); ?>
                        </span>
                        <span class="text-gray-900 dark:text-gray-300">
                            <?php wc_cart_totals_taxes_total_html(); ?>
                        </span>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <?php if (wc_coupons_enabled()) : ?>
            <form
                class="coupon mb-8 flex gap-2"
                action="<?php echo esc_url(wc_get_cart_url()); ?>"
                method="post">
                <label class="screen-reader-text" for="coupon_code">
                    <?php esc_html_e('Coupon:', 'woocommerce'); ?>
                </label>
                <input
                    type="text"
                    name="coupon_code"
                    class="input-text min-w-0 flex-1 rounded-[2px] border border-gray-200 bg-[#F9FAFB] px-4 py-3 text-[13px] text-gray-900 outline-none transition-colors focus:border-[#156E8A] dark:border-gray-700 dark:bg-[#111a20] dark:text-white"
                    id="coupon_code"
                    value=""
                    placeholder="<?php esc_attr_e('Promo code', 'breathein'); ?>"
                    autocomplete="off">
                <button
                    type="submit"
                    class="button rounded-[2px] border border-black bg-white px-6 py-3 text-[11px] font-bold tracking-wider text-gray-900 transition-colors hover:bg-gray-50 dark:border-white dark:bg-tickerDark dark:text-white dark:hover:bg-gray-800"
                    name="apply_coupon"
                    value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">
                    <?php esc_html_e('Apply', 'breathein'); ?>
                </button>

                <?php do_action('woocommerce_cart_coupon'); ?>
                <input
                    type="hidden"
                    name="woocommerce-cart-nonce"
                    id="woocommerce-cart-coupon-nonce"
                    value="<?php echo esc_attr(wp_create_nonce('woocommerce-cart')); ?>">
            </form>
        <?php endif; ?>

        <div class="mb-6 h-px w-full bg-gray-200 dark:bg-gray-800"></div>

        <?php do_action('woocommerce_cart_totals_before_order_total'); ?>

        <div class="order-total mb-8 flex items-end justify-between gap-4">
            <span class="text-lg font-medium text-gray-900 dark:text-white">
                <?php esc_html_e('Total', 'woocommerce'); ?>
            </span>
            <span class="breathein-cart-order-total text-right text-2xl font-medium tracking-tight text-gray-900 dark:text-white">
                <?php wc_cart_totals_order_total_html(); ?>
            </span>
        </div>

        <?php do_action('woocommerce_cart_totals_after_order_total'); ?>

        <div class="wc-proceed-to-checkout">
            <?php do_action('woocommerce_proceed_to_checkout'); ?>
        </div>

        <p class="mt-6 text-center text-[10px] tracking-wide text-gray-400 md:text-[11px]">
            <?php echo esc_html($delivery_message); ?>
            &middot;
            <?php esc_html_e('Genuine warranty', 'breathein'); ?>
            &middot;
            <?php esc_html_e('Secure checkout', 'breathein'); ?>
        </p>
    </div>

    <?php do_action('woocommerce_after_cart_totals'); ?>
</div>
