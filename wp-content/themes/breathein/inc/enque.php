<?php

defined('ABSPATH') || exit;

/**
 * Enqueue Breathein frontend assets.
 */
function breathein_enqueue_assets(): void
{
    $theme_path = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_enqueue_script(
        'breathein-tailwind-play',
        'https://cdn.tailwindcss.com',
        [],
        null,
        false
    );

    $tailwind_config_path = $theme_path . '/tailwind.config.js';

    if (file_exists($tailwind_config_path)) {
        wp_enqueue_script(
            'breathein-tailwind-config',
            $theme_uri . '/tailwind.config.js',
            ['breathein-tailwind-play'],
            filemtime($tailwind_config_path),
            false
        );
    }

    wp_enqueue_style(
        'breathein-swiper-style',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11'
    );

    wp_enqueue_script(
        'breathein-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11',
        true
    );

    /*
     * WordPress root theme stylesheet.
     *
     * Path: /breathein/style.css
     */
    $theme_style_path = $theme_path . '/style.css';

    if (file_exists($theme_style_path)) {
        wp_enqueue_style(
            'breathein-theme-style',
            get_stylesheet_uri(),
            [],
            filemtime($theme_style_path)
        );
    }

    /*
     * Compiled theme stylesheet.
     *
     * Path: /breathein/assets/css/style.css
     */
    $tailwind_style_path = $theme_path . '/assets/css/style.css';

    if (file_exists($tailwind_style_path)) {
        wp_enqueue_style(
            'breathein-tailwind-style',
            $theme_uri . '/assets/css/style.css',
            ['breathein-theme-style'],
            filemtime($tailwind_style_path)
        );
    }

    $navigation_style_path = $theme_path . '/assets/css/navigation.css';

    if (file_exists($navigation_style_path)) {
        wp_enqueue_style(
            'breathein-navigation-style',
            $theme_uri . '/assets/css/navigation.css',
            ['breathein-tailwind-style'],
            filemtime($navigation_style_path)
        );
    }

    $footer_style_path = $theme_path . '/assets/css/footer.css';

    if (file_exists($footer_style_path)) {
        wp_enqueue_style(
            'breathein-footer-style',
            $theme_uri . '/assets/css/footer.css',
            ['breathein-navigation-style'],
            filemtime($footer_style_path)
        );
    }

    /*
     * Main frontend JavaScript.
     *
     * Path: /breathein/assets/js/main.js
     */
    $main_script_path = $theme_path . '/assets/js/main.js';

    if (file_exists($main_script_path)) {
        wp_enqueue_script(
            'breathein-main-script',
            $theme_uri . '/assets/js/main.js',
            ['jquery', 'breathein-swiper'],
            filemtime($main_script_path),
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
    }

    if (function_exists('is_account_page') && is_account_page()) {
        $account_style_path = $theme_path . '/assets/css/account.css';

        if (file_exists($account_style_path)) {
            wp_enqueue_style(
                'breathein-account-style',
                $theme_uri . '/assets/css/account.css',
                ['breathein-tailwind-style', 'breathein-footer-style'],
                filemtime($account_style_path)
            );
        }

        $account_script_path = $theme_path . '/assets/js/account.js';

        if (file_exists($account_script_path)) {
            wp_enqueue_script(
                'breathein-account-script',
                $theme_uri . '/assets/js/account.js',
                [],
                filemtime($account_script_path),
                [
                    'strategy'  => 'defer',
                    'in_footer' => true,
                ]
            );
        }
    }

    if (function_exists('is_product') && is_product()) {
        $product_style_path = $theme_path . '/assets/css/product.css';

        if (file_exists($product_style_path)) {
            wp_enqueue_style(
                'breathein-product-style',
                $theme_uri . '/assets/css/product.css',
                ['breathein-footer-style'],
                filemtime($product_style_path)
            );
        }

        $product_script_path = $theme_path . '/assets/js/product.js';

        if (file_exists($product_script_path)) {
            wp_enqueue_script(
                'breathein-product-script',
                $theme_uri . '/assets/js/product.js',
                ['jquery', 'breathein-swiper'],
                filemtime($product_script_path),
                [
                    'strategy'  => 'defer',
                    'in_footer' => true,
                ]
            );
        }
    }

    if (function_exists('is_cart') && is_cart()) {
        $cart_style_path = $theme_path . '/assets/css/cart.css';

        if (file_exists($cart_style_path)) {
            wp_enqueue_style(
                'breathein-cart-style',
                $theme_uri . '/assets/css/cart.css',
                ['breathein-tailwind-style'],
                filemtime($cart_style_path)
            );
        }

        $cart_script_path = $theme_path . '/assets/js/cart.js';

        if (file_exists($cart_script_path)) {
            wp_enqueue_script(
                'breathein-cart-script',
                $theme_uri . '/assets/js/cart.js',
                ['jquery', 'wc-cart'],
                filemtime($cart_script_path),
                [
                    'strategy'  => 'defer',
                    'in_footer' => true,
                ]
            );
        }
    }

    if (function_exists('is_checkout') && is_checkout()) {
        $checkout_style_path = $theme_path . '/assets/css/checkout.css';

        if (file_exists($checkout_style_path)) {
            wp_enqueue_style(
                'breathein-checkout-style',
                $theme_uri . '/assets/css/checkout.css',
                ['breathein-tailwind-style'],
                filemtime($checkout_style_path)
            );
        }

        $is_order_received = function_exists('is_order_received_page')
            && is_order_received_page();
        $checkout_script_path = $theme_path . '/assets/js/checkout.js';

        if (
            !$is_order_received
            && file_exists($checkout_script_path)
        ) {
            wp_enqueue_script(
                'breathein-checkout-script',
                $theme_uri . '/assets/js/checkout.js',
                ['jquery', 'wc-checkout'],
                filemtime($checkout_script_path),
                [
                    'strategy'  => 'defer',
                    'in_footer' => true,
                ]
            );
        }
    }
}

add_action('wp_enqueue_scripts', 'breathein_enqueue_assets');
