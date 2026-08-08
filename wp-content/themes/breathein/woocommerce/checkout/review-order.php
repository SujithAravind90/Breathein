<?php

/**
 * Checkout order summary.
 *
 * @package Breathein
 * @version 11.0.0
 */

defined('ABSPATH') || exit;

if (WC()->cart->needs_payment()) {
    $summary_gateways = WC()->payment_gateways()
        ->get_available_payment_gateways();
    WC()->payment_gateways()->set_current_gateway($summary_gateways);
}

$order_button_text = apply_filters(
    'woocommerce_order_button_text',
    __('Place order', 'woocommerce')
);

if (!WC()->cart->needs_shipping()) {
    $delivery_message = __('No delivery required', 'breathein');
} elseif (WC()->cart->show_shipping()) {
    $delivery_message = __('Delivery selected', 'breathein');
} else {
    $delivery_message = __('Delivery calculated at checkout', 'breathein');
}
?>

<div class="woocommerce-checkout-review-order-table breathein-order-summary-card">
    <h2><?php esc_html_e('Order Summary', 'breathein'); ?></h2>

    <table class="shop_table breathein-checkout-summary-table">
        <caption class="screen-reader-text">
            <?php esc_html_e('Products and order totals', 'breathein'); ?>
        </caption>
        <thead class="screen-reader-text">
            <tr>
                <th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="product-total"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            do_action('woocommerce_review_order_before_cart_contents');

            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters(
                    'woocommerce_cart_item_product',
                    $cart_item['data'],
                    $cart_item,
                    $cart_item_key
                );
                $visible = apply_filters(
                    'woocommerce_checkout_cart_item_visible',
                    true,
                    $cart_item,
                    $cart_item_key
                );

                if (
                    $_product instanceof WC_Product
                    && $_product->exists()
                    && $cart_item['quantity'] > 0
                    && $visible
                ) :
                    ?>
                    <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                        <td class="product-name">
                            <?php
                            echo wp_kses_post(
                                apply_filters(
                                    'woocommerce_cart_item_name',
                                    $_product->get_name(),
                                    $cart_item,
                                    $cart_item_key
                                )
                            );
                            echo apply_filters(
                                'woocommerce_checkout_cart_item_quantity',
                                ' <strong class="product-quantity">'
                                    . sprintf('&times;&nbsp;%s', $cart_item['quantity'])
                                    . '</strong>',
                                $cart_item,
                                $cart_item_key
                            ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            ?>
                        </td>
                        <td class="product-total">
                            <?php
                            echo apply_filters(
                                'woocommerce_cart_item_subtotal',
                                WC()->cart->get_product_subtotal(
                                    $_product,
                                    $cart_item['quantity']
                                ),
                                $cart_item,
                                $cart_item_key
                            ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            ?>
                        </td>
                    </tr>
                    <?php
                endif;
            }

            do_action('woocommerce_review_order_after_cart_contents');
            ?>
        </tbody>

        <tfoot>
            <tr class="cart-subtotal">
                <th><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
                <td><?php wc_cart_totals_subtotal_html(); ?></td>
            </tr>

            <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                    <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
                    <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                <?php do_action('woocommerce_review_order_before_shipping'); ?>
                <?php wc_cart_totals_shipping_html(); ?>
                <?php do_action('woocommerce_review_order_after_shipping'); ?>
            <?php elseif (WC()->cart->needs_shipping()) : ?>
                <tr class="woocommerce-shipping-totals shipping">
                    <th><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
                    <td><?php esc_html_e('Calculated after entering your address', 'breathein'); ?></td>
                </tr>
            <?php else : ?>
                <tr class="woocommerce-shipping-totals shipping">
                    <th><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
                    <td><?php esc_html_e('Not required', 'breathein'); ?></td>
                </tr>
            <?php endif; ?>

            <?php foreach (WC()->cart->get_fees() as $fee) : ?>
                <tr class="fee">
                    <th><?php echo esc_html($fee->name); ?></th>
                    <td><?php wc_cart_totals_fee_html($fee); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php
            if (
                wc_tax_enabled()
                && !WC()->cart->display_prices_including_tax()
            ) :
                ?>
                <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
                    <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                        <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                            <th><?php echo esc_html($tax->label); ?></th>
                            <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="tax-total">
                        <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
                        <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php do_action('woocommerce_review_order_before_order_total'); ?>

            <tr class="order-total">
                <th><?php esc_html_e('Total', 'woocommerce'); ?></th>
                <td><?php wc_cart_totals_order_total_html(); ?></td>
            </tr>

            <?php do_action('woocommerce_review_order_after_order_total'); ?>
        </tfoot>
    </table>

    <div class="form-row place-order">
        <noscript>
            <?php
            printf(
                esc_html__(
                    'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.',
                    'woocommerce'
                ),
                '<em>',
                '</em>'
            );
            ?>
            <br>
            <button
                type="submit"
                class="button alt"
                name="woocommerce_checkout_update_totals"
                value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>">
                <?php esc_html_e('Update totals', 'woocommerce'); ?>
            </button>
        </noscript>

        <?php wc_get_template('checkout/terms.php'); ?>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <?php
        echo apply_filters(
            'woocommerce_order_button_html',
            '<button type="submit" class="button alt'
                . esc_attr(
                    wc_wp_theme_get_element_class_name('button')
                        ? ' ' . wc_wp_theme_get_element_class_name('button')
                        : ''
                )
                . '" name="woocommerce_checkout_place_order" id="place_order" value="'
                . esc_attr($order_button_text)
                . '" data-value="'
                . esc_attr($order_button_text)
                . '">'
                . esc_html($order_button_text)
                . '</button>'
        ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php
        wp_nonce_field(
            'woocommerce-process_checkout',
            'woocommerce-process-checkout-nonce'
        );
        ?>

        <p class="breathein-checkout-trust">
            <svg
                aria-hidden="true"
                viewBox="0 0 20 20"
                focusable="false">
                <path
                    fill="currentColor"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z">
                </path>
            </svg>
            <span>
                <?php esc_html_e('Secure checkout', 'breathein'); ?>
                &middot;
                <?php esc_html_e('Genuine warranty', 'breathein'); ?>
                &middot;
                <?php echo esc_html($delivery_message); ?>
            </span>
        </p>
    </div>
</div>
