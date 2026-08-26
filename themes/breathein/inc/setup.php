<?php

function breathein_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 360,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary-menu' => __('Primary Menu', 'breathein'),

        // Footer Columns
        'footer_1' => __('Footer Column 1', 'breathein'),
        'footer_2' => __('Footer Column 2', 'breathein'),
        'footer_3' => __('Footer Column 3', 'breathein'),
        'footer_4' => __('Footer Column 4', 'breathein'),

        // Bottom Links
        'footer_bottom' => __('Footer Bottom Links', 'breathein')
    ]);
}

add_action('after_setup_theme', 'breathein_theme_setup');
