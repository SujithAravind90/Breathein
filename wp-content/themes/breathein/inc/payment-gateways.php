<?php

defined('ABSPATH') || exit;

/**
 * Determine whether Razorpay has a complete API credential pair.
 *
 * Razorpay infers Test or Live mode from the Key ID prefix. The secret is
 * deliberately never copied into theme code, browser JavaScript, or logs.
 */
function breathein_razorpay_is_configured(): bool
{
    $settings = (array) get_option('woocommerce_razorpay_settings', []);
    $key_id = trim((string) ($settings['key_id'] ?? ''));
    $key_secret = trim((string) ($settings['key_secret'] ?? ''));

    return preg_match('/^rzp_(?:test|live)_[A-Za-z0-9]+$/', $key_id) === 1
        && $key_secret !== '';
}

/**
 * Never expose an enabled-but-unconfigured Razorpay gateway at checkout.
 *
 * The official plugin defaults to enabled before keys are entered. Removing
 * an incomplete gateway here prevents customers from creating an order that
 * cannot reach Razorpay.
 *
 * @param array<string, WC_Payment_Gateway> $gateways Available gateways.
 * @return array<string, WC_Payment_Gateway>
 */
function breathein_filter_incomplete_razorpay_gateway(array $gateways): array
{
    if (
        isset($gateways['razorpay'])
        && !breathein_razorpay_is_configured()
    ) {
        unset($gateways['razorpay']);
    }

    return $gateways;
}

add_filter(
    'woocommerce_available_payment_gateways',
    'breathein_filter_incomplete_razorpay_gateway',
    20
);

/**
 * Make the official Razorpay secret field an obscured, non-autofilled input.
 *
 * @param mixed $fields Razorpay settings fields passed by reference.
 */
function breathein_secure_razorpay_admin_fields(&$fields): void
{
    if (!is_array($fields) || !isset($fields['key_secret'])) {
        return;
    }

    $fields['key_secret']['type'] = 'password';
    $fields['key_secret']['custom_attributes'] = [
        'autocomplete' => 'new-password',
        'spellcheck'   => 'false',
    ];
}

add_action(
    'setup_extra_setting_fields',
    'breathein_secure_razorpay_admin_fields',
    20
);

/**
 * Explain why Razorpay remains hidden until credentials are present.
 */
function breathein_razorpay_configuration_notice(): void
{
    if (!current_user_can('manage_woocommerce')) {
        return;
    }

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if (!$screen || $screen->id !== 'woocommerce_page_wc-settings') {
        return;
    }

    $tab = isset($_GET['tab']) ? sanitize_key(wp_unslash($_GET['tab'])) : '';
    $section = isset($_GET['section'])
        ? sanitize_key(wp_unslash($_GET['section']))
        : '';

    if ($tab !== 'checkout' || $section !== 'razorpay') {
        return;
    }

    if (breathein_razorpay_is_configured()) {
        return;
    }

    echo '<div class="notice notice-warning"><p>';
    echo esc_html__(
        'Razorpay is installed but is hidden from checkout until a complete Test or Live Key ID and Key Secret are saved.',
        'breathein'
    );
    echo '</p></div>';
}

add_action('admin_notices', 'breathein_razorpay_configuration_notice');

/**
 * Keep new Cash on Delivery orders on hold until payment is collected.
 *
 * WooCommerce creates the order and redirects to the confirmation page as
 * usual. The on-hold status makes it clear that no online payment was taken.
 *
 * @param mixed $status Default COD order status.
 * @param mixed $order  Order being processed.
 */
function breathein_cod_pending_order_status($status, $order): string
{
    if ($order instanceof WC_Order && (float) $order->get_total() > 0) {
        return 'on-hold';
    }

    return (string) $status;
}

add_filter(
    'woocommerce_cod_process_payment_order_status',
    'breathein_cod_pending_order_status',
    10,
    2
);

/**
 * Keep the order-received message accurate for Cash on Delivery orders.
 *
 * The installed Razorpay gateway replaces this text globally, including for
 * orders that did not use Razorpay. Running after that filter prevents a COD
 * customer from being told that an online payment was captured.
 *
 * @param mixed $message Current order-received message.
 * @param mixed $order   Order shown on the confirmation page.
 */
function breathein_cod_order_received_message($message, $order): string
{
    if (
        $order instanceof WC_Order
        && 'cod' === $order->get_payment_method('edit')
    ) {
        return __(
            'Your Cash on Delivery order has been placed. No online payment was taken; please pay when your order is delivered.',
            'breathein'
        );
    }

    return (string) $message;
}

add_filter(
    'woocommerce_thankyou_order_received_text',
    'breathein_cod_order_received_message',
    100,
    2
);
