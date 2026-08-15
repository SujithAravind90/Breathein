<?php

/**
 * Checkout shipping and order-notes form.
 *
 * @package Breathein
 * @version 3.6.0
 *
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-shipping-fields breathein-checkout-supplement">
    <?php if (true === WC()->cart->needs_shipping_address()) : ?>
        <h3 id="ship-to-different-address">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input
                    id="ship-to-different-address-checkbox"
                    class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                    <?php
                    checked(
                        apply_filters(
                            'woocommerce_ship_to_different_address_checked',
                            'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0
                        ),
                        1
                    );
                    ?>
                    type="checkbox"
                    name="ship_to_different_address"
                    value="1">
                <span><?php esc_html_e('Deliver to a different address', 'breathein'); ?></span>
            </label>
        </h3>

        <div class="shipping_address">
            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

            <div class="woocommerce-shipping-fields__field-wrapper breathein-checkout-fields">
                <?php
                foreach ($checkout->get_checkout_fields('shipping') as $key => $field) {
                    woocommerce_form_field(
                        $key,
                        $field,
                        $checkout->get_value($key)
                    );
                }
                ?>
            </div>

            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
        </div>
    <?php endif; ?>
</div>

<div class="woocommerce-additional-fields breathein-checkout-supplement">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php
    if (
        apply_filters(
            'woocommerce_enable_order_notes_field',
            'yes' === get_option('woocommerce_enable_order_comments', 'yes')
        )
    ) :
        ?>
        <h3>
            <?php esc_html_e('Order notes', 'breathein'); ?>
            <span><?php esc_html_e('(optional)', 'breathein'); ?></span>
        </h3>

        <div class="woocommerce-additional-fields__field-wrapper breathein-checkout-fields">
            <?php
            foreach ($checkout->get_checkout_fields('order') as $key => $field) {
                woocommerce_form_field(
                    $key,
                    $field,
                    $checkout->get_value($key)
                );
            }
            ?>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>
