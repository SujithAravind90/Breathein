<?php

defined('ABSPATH') || exit;

/**
 * Configure the theme features used by WordPress and WooCommerce.
 */
function breathein_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support(
        'html5',
        [
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );
}

add_action('after_setup_theme', 'breathein_setup');

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enque.php';
require_once get_template_directory() . '/inc/product-matcher.php';

/**
 * Register ACF Theme Settings page.
 */
function breathein_register_theme_settings_page(): void
{
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => __('Breathein Theme Settings', 'breathein'),
        'menu_title' => __('Theme Settings', 'breathein'),
        'menu_slug'  => 'breathein-theme-settings',
        'capability' => 'manage_options',
        'redirect'   => false,
        'position'   => 30,
        'icon_url'   => 'dashicons-admin-customizer',
        'autoload'   => true,
    ]);
}

add_action(
    'acf/init',
    'breathein_register_theme_settings_page'
);
