<?php //Start building your awesome child theme functions

add_action('wp_enqueue_scripts', 'miniture_enqueue_styles', 100);
function miniture_enqueue_styles()
{
    wp_enqueue_style('miniture-child-styles',  get_stylesheet_directory_uri() . '/style.css', array('nova-miniture-styles'), wp_get_theme()->get('Version'));
}

add_action('woocommerce_single_product_summary', function () {
    echo '<p style="color:red;">TEST TEXT</p>';
}, 25);
