<?php

/**
 * Checkout billing information form.
 *
 * The standard WooCommerce fields are grouped into the Contact and Delivery
 * steps from the supplied design without changing their names or validation.
 *
 * @package Breathein
 * @version 3.6.0
 *
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;

$billing_fields = $checkout->get_checkout_fields('billing');
$contact_keys = [
    'billing_first_name',
    'billing_last_name',
    'billing_email',
    'billing_phone',
];
$contact_fields = [];
$delivery_fields = [];
$address_heading = (WC()->cart && WC()->cart->needs_shipping())
    ? __('Delivery Address', 'breathein')
    : __('Billing Address', 'breathein');

foreach ($billing_fields as $key => $field) {
    if (in_array($key, $contact_keys, true)) {
        $contact_fields[$key] = $field;
    } else {
        $delivery_fields[$key] = $field;
    }
}

$placeholders = [
    'billing_first_name' => __('First name', 'breathein'),
    'billing_last_name'  => __('Last name', 'breathein'),
    'billing_email'      => __('you@email.com', 'breathein'),
    'billing_phone'      => __('+91', 'breathein'),
    'billing_address_1'  => __('House number, street and area', 'breathein'),
    'billing_address_2'  => __('Nearby landmark or apartment', 'breathein'),
    'billing_city'       => __('City', 'breathein'),
    'billing_postcode'   => __('PIN code', 'breathein'),
];

$render_fields = static function (
    array $fields
) use (
    $checkout,
    $placeholders
): void {
    foreach ($fields as $key => $field) {
        if (isset($placeholders[$key])) {
            $field['placeholder'] = $placeholders[$key];
        }

        if ('billing_address_2' === $key) {
            $field['label'] = !empty($field['required'])
                ? __('Landmark / Apartment', 'breathein')
                : __('Landmark / Apartment (optional)', 'breathein');
            $field['label_class'] = [];
        }

        woocommerce_form_field(
            $key,
            $field,
            $checkout->get_value($key)
        );
    }
};
?>

<div class="woocommerce-billing-fields">
    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper">
        <section class="breathein-checkout-step breathein-checkout-contact-step">
            <div class="breathein-checkout-step__heading">
                <span class="breathein-checkout-step__number" aria-hidden="true">1</span>
                <h2><?php esc_html_e('Contact', 'breathein'); ?></h2>
            </div>

            <div class="breathein-checkout-step__body">
                <div class="breathein-checkout-fields">
                    <?php $render_fields($contact_fields); ?>
                </div>
            </div>
        </section>

        <section class="breathein-checkout-step breathein-checkout-delivery-step">
            <div class="breathein-checkout-step__heading">
                <span class="breathein-checkout-step__number" aria-hidden="true">2</span>
                <h2><?php echo esc_html($address_heading); ?></h2>
            </div>

            <div class="breathein-checkout-step__body">
                <div class="breathein-checkout-fields">
                    <?php $render_fields($delivery_fields); ?>
                </div>
            </div>
        </section>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields breathein-checkout-supplement">
        <?php if (!$checkout->is_registration_required()) : ?>
            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input
                        class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                        id="createaccount"
                        <?php
                        checked(
                            true === $checkout->get_value('createaccount')
                            || true === apply_filters(
                                'woocommerce_create_account_default_checked',
                                false
                            ),
                            true
                        );
                        ?>
                        type="checkbox"
                        name="createaccount"
                        value="1">
                    <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
                </label>
            </p>
        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>
            <div class="create-account breathein-checkout-fields">
                <?php
                foreach ($checkout->get_checkout_fields('account') as $key => $field) {
                    woocommerce_form_field(
                        $key,
                        $field,
                        $checkout->get_value($key)
                    );
                }
                ?>
            </div>
        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
