<?php

/**
 * Checkout form.
 *
 * Core checkout callbacks are captured at their original action priorities,
 * then placed into the supplied two-column design. This preserves hook
 * execution order while keeping payment methods left and the summary right.
 *
 * @package Breathein
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (
    !$checkout->is_registration_enabled()
    && $checkout->is_registration_required()
    && !is_user_logged_in()
) {
    echo esc_html(
        apply_filters(
            'woocommerce_checkout_must_be_logged_in_message',
            __('You must be logged in to checkout.', 'woocommerce')
        )
    );
    return;
}
?>

<form
    name="checkout"
    method="post"
    class="checkout woocommerce-checkout"
    action="<?php echo esc_url(wc_get_checkout_url()); ?>"
    enctype="multipart/form-data"
    aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">

    <?php
    $has_checkout_fields = (bool) $checkout->get_checkout_fields();

    ob_start();

    if ($has_checkout_fields) {
        do_action('woocommerce_checkout_before_customer_details');
        ?>
        <div class="col2-set" id="customer_details">
            <div class="col-1">
                <?php do_action('woocommerce_checkout_billing'); ?>
            </div>

            <div class="col-2">
                <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>
        </div>
        <?php
        do_action('woocommerce_checkout_after_customer_details');
    }

    $customer_details_html = ob_get_clean();

    ob_start();
    do_action('woocommerce_checkout_before_order_review_heading');
    $before_review_heading_html = ob_get_clean();

    ob_start();
    do_action('woocommerce_checkout_before_order_review');
    $before_order_review_html = ob_get_clean();

    /*
     * Retain the standard woocommerce_checkout_order_review action and all
     * third-party callback priorities. Only core callback output is captured
     * into separate variables for the design-specific columns.
     */
    $order_review_html = '';
    $payment_html = '';
    $order_review_priority = has_action(
        'woocommerce_checkout_order_review',
        'woocommerce_order_review'
    );
    $payment_priority = has_action(
        'woocommerce_checkout_order_review',
        'woocommerce_checkout_payment'
    );
    $capture_order_review = static function () use (
        &$order_review_html
    ): void {
        ob_start();
        woocommerce_order_review();
        $order_review_html = ob_get_clean();
    };
    $capture_payment = static function () use (
        &$payment_html
    ): void {
        ob_start();
        woocommerce_checkout_payment();
        $payment_html = ob_get_clean();
    };

    if (false !== $order_review_priority) {
        remove_action(
            'woocommerce_checkout_order_review',
            'woocommerce_order_review',
            $order_review_priority
        );
        add_action(
            'woocommerce_checkout_order_review',
            $capture_order_review,
            $order_review_priority
        );
    }

    if (false !== $payment_priority) {
        remove_action(
            'woocommerce_checkout_order_review',
            'woocommerce_checkout_payment',
            $payment_priority
        );
        add_action(
            'woocommerce_checkout_order_review',
            $capture_payment,
            $payment_priority
        );
    }

    ob_start();
    do_action('woocommerce_checkout_order_review');
    $checkout_extension_output = ob_get_clean();

    if (false !== $order_review_priority) {
        remove_action(
            'woocommerce_checkout_order_review',
            $capture_order_review,
            $order_review_priority
        );
        add_action(
            'woocommerce_checkout_order_review',
            'woocommerce_order_review',
            $order_review_priority
        );
    }

    if (false !== $payment_priority) {
        remove_action(
            'woocommerce_checkout_order_review',
            $capture_payment,
            $payment_priority
        );
        add_action(
            'woocommerce_checkout_order_review',
            'woocommerce_checkout_payment',
            $payment_priority
        );
    }

    ob_start();
    do_action('woocommerce_checkout_after_order_review');
    $after_order_review_html = ob_get_clean();
    ?>

    <div class="breathein-checkout-layout">
        <div class="breathein-checkout-main">
            <?php echo $customer_details_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php echo $before_review_heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

            <h2 id="order_review_heading" class="screen-reader-text">
                <?php esc_html_e('Order summary', 'woocommerce'); ?>
            </h2>

            <section class="breathein-checkout-step breathein-checkout-payment-step">
                <div class="breathein-checkout-step__heading">
                    <span class="breathein-checkout-step__number" aria-hidden="true">3</span>
                    <h2><?php esc_html_e('Payment', 'breathein'); ?></h2>
                </div>

                <div class="breathein-checkout-step__body">
                    <?php echo $payment_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </section>
        </div>

        <aside class="breathein-checkout-summary-wrap">
            <?php echo $before_order_review_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php echo $order_review_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                <?php if ('' !== trim($checkout_extension_output)) : ?>
                    <div class="breathein-checkout-review-extensions">
                        <?php echo $checkout_extension_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php echo $after_order_review_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </aside>
    </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
