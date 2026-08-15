<?php

/**
 * Checkout payment methods.
 *
 * Payment gateways stay in the left-hand Payment step. Terms, the secure
 * submit button, and the checkout nonce are rendered by review-order.php in
 * the right-hand summary card.
 *
 * @package Breathein
 * @version 10.9.0
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment">
    <?php if (WC()->cart && WC()->cart->needs_payment()) : ?>
        <ul
            class="wc_payment_methods payment_methods methods"
            aria-label="<?php esc_attr_e('Payment methods', 'woocommerce'); ?>">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template(
                        'checkout/payment-method.php',
                        ['gateway' => $gateway]
                    );
                }
            } else {
                echo '<li class="breathein-no-payment-methods">';
                wc_print_notice(
                    apply_filters(
                        'woocommerce_no_available_payment_methods_message',
                        WC()->customer->get_billing_country()
                            ? esc_html__(
                                'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.',
                                'woocommerce'
                            )
                            : esc_html__(
                                'Please fill in your details above to see available payment methods.',
                                'woocommerce'
                            )
                    ),
                    'notice'
                );
                echo '</li>';
            }
            ?>
        </ul>

        <?php if (!empty($available_gateways)) : ?>
            <p class="breathein-payment-security-note">
                <?php
                esc_html_e(
                    'Your payment details are processed securely by the selected payment provider.',
                    'breathein'
                );
                ?>
            </p>
        <?php endif; ?>
    <?php else : ?>
        <p class="breathein-no-payment-required">
            <?php esc_html_e('No payment is required for this order.', 'woocommerce'); ?>
        </p>
    <?php endif; ?>
</div>

<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
