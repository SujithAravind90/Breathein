<?php

defined('ABSPATH') || exit;

/**
 * Add a payment-method column to both HPOS and legacy order lists.
 *
 * @param array<string, string> $columns Existing order columns.
 * @return array<string, string>
 */
function breathein_add_order_payment_column(array $columns): array
{
    $result = [];
    $inserted = false;

    foreach ($columns as $key => $label) {
        $result[$key] = $label;

        if ('order_status' === $key) {
            $result['breathein_payment_method'] = __('Payment', 'breathein');
            $inserted = true;
        }
    }

    if (!$inserted) {
        $result['breathein_payment_method'] = __('Payment', 'breathein');
    }

    return $result;
}

add_filter(
    'woocommerce_shop_order_list_table_columns',
    'breathein_add_order_payment_column'
);
add_filter(
    'manage_edit-shop_order_columns',
    'breathein_add_order_payment_column'
);

/**
 * Describe the collection state of a Cash on Delivery order.
 *
 * @return array{label: string, modifier: string}
 */
function breathein_get_cod_collection_state(WC_Order $order): array
{
    if ($order->has_status(['cancelled', 'failed', 'refunded'])) {
        return [
            'label'    => __('No collection', 'breathein'),
            'modifier' => 'terminal',
        ];
    }

    if ($order->get_date_paid()) {
        return [
            'label'    => __('Marked paid', 'breathein'),
            'modifier' => 'paid',
        ];
    }

    return [
        'label'    => __('Payment due', 'breathein'),
        'modifier' => 'due',
    ];
}

/**
 * Render the shared payment-column content.
 */
function breathein_render_order_payment_value(?WC_Order $order): void
{
    if (!$order) {
        echo '&mdash;';
        return;
    }

    if ('cod' !== $order->get_payment_method('edit')) {
        $payment_title = $order->get_payment_method_title('edit');
        echo $payment_title ? esc_html($payment_title) : '&mdash;';
        return;
    }

    $state = breathein_get_cod_collection_state($order);
    ?>
    <span class="breathein-payment-badge breathein-payment-badge--cod">
        <?php esc_html_e('COD', 'breathein'); ?>
    </span>
    <span class="breathein-payment-state breathein-payment-state--<?php echo esc_attr($state['modifier']); ?>">
        <?php echo esc_html($state['label']); ?>
    </span>
    <?php
}

/**
 * Render the payment column on the HPOS order list.
 */
function breathein_render_hpos_order_payment_column(
    string $column_name,
    WC_Order $order
): void {
    if ('breathein_payment_method' !== $column_name) {
        return;
    }

    breathein_render_order_payment_value($order);
}

add_action(
    'woocommerce_shop_order_list_table_custom_column',
    'breathein_render_hpos_order_payment_column',
    10,
    2
);

/**
 * Render the payment column on the legacy order list.
 */
function breathein_render_legacy_order_payment_column(
    string $column_name,
    int $post_id
): void {
    if ('breathein_payment_method' !== $column_name) {
        return;
    }

    $order = wc_get_order($post_id);
    breathein_render_order_payment_value(
        $order instanceof WC_Order ? $order : null
    );
}

add_action(
    'manage_shop_order_posts_custom_column',
    'breathein_render_legacy_order_payment_column',
    10,
    2
);

/**
 * Show a clear collection warning on Cash on Delivery order screens.
 */
function breathein_render_cod_admin_order_notice($order): void
{
    if (
        !$order instanceof WC_Order
        || 'cod' !== $order->get_payment_method('edit')
    ) {
        return;
    }

    $state = breathein_get_cod_collection_state($order);

    if ('terminal' === $state['modifier']) {
        $message = __('This Cash on Delivery order is closed. No payment should be collected.', 'breathein');
    } elseif ('paid' === $state['modifier']) {
        $message = __('This Cash on Delivery order has been marked as paid.', 'breathein');
    } else {
        $amount = wc_price(
            $order->get_total('edit'),
            ['currency' => $order->get_currency('edit')]
        );
        $message = sprintf(
            /* translators: %s: formatted order total */
            __('No online payment was captured. Collect %s from the customer at delivery.', 'breathein'),
            $amount
        );
    }
    ?>
    <div class="breathein-cod-order-notice breathein-cod-order-notice--<?php echo esc_attr($state['modifier']); ?>">
        <strong><?php esc_html_e('Cash on Delivery', 'breathein'); ?></strong>
        <span><?php echo wp_kses_post($message); ?></span>
    </div>
    <?php
}

add_action(
    'woocommerce_admin_order_data_after_order_details',
    'breathein_render_cod_admin_order_notice'
);

/**
 * Load the small COD badge stylesheet only in WooCommerce order screens.
 */
function breathein_enqueue_order_admin_assets(): void
{
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if (
        !$screen
        || !in_array(
            $screen->id,
            ['woocommerce_page_wc-orders', 'edit-shop_order', 'shop_order'],
            true
        )
    ) {
        return;
    }

    $style_path = get_template_directory() . '/assets/css/admin-orders.css';

    if (!file_exists($style_path)) {
        return;
    }

    wp_enqueue_style(
        'breathein-admin-orders',
        get_template_directory_uri() . '/assets/css/admin-orders.css',
        [],
        filemtime($style_path)
    );
}

add_action('admin_enqueue_scripts', 'breathein_enqueue_order_admin_assets');
