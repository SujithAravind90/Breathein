<?php

defined('ABSPATH') || exit;

/**
 * Refresh the header cart count after WooCommerce AJAX add-to-cart actions.
 *
 * @param array<string, string> $fragments Existing fragments.
 * @return array<string, string>
 */
function breathein_cart_count_fragment(array $fragments): array
{
    if (!function_exists('WC') || !WC()->cart) {
        return $fragments;
    }

    $cart_count = WC()->cart->get_cart_contents_count();
    $label = sprintf(
        _n(
            '%d item in cart',
            '%d items in cart',
            $cart_count,
            'breathein'
        ),
        $cart_count
    );

    $fragments['.breathein-cart-count'] = sprintf(
        '<span class="breathein-cart-count absolute -right-1.5 -top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full border border-white bg-brandTeal px-1 text-[10px] font-bold leading-none text-white" aria-label="%1$s">%2$s</span>',
        esc_attr($label),
        esc_html((string) $cart_count)
    );

    return $fragments;
}

add_filter(
    'woocommerce_add_to_cart_fragments',
    'breathein_cart_count_fragment'
);
