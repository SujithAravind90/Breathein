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

/**
 * Remove the unused WooCommerce Downloads area from the customer account.
 */
add_filter('woocommerce_account_menu_items', static function (array $items): array {
    unset($items['downloads']);

    return $items;
}, 20);

add_action('template_redirect', static function (): void {
    if (
        function_exists('is_account_page')
        && is_account_page()
        && function_exists('is_wc_endpoint_url')
        && is_wc_endpoint_url('downloads')
    ) {
        wp_safe_redirect(wc_get_page_permalink('myaccount'));
        exit;
    }
});

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enque.php';
require_once get_template_directory() . '/inc/product-matcher.php';
require_once get_template_directory() . '/inc/cart.php';
require_once get_template_directory() . '/inc/payment-gateways.php';
require_once get_template_directory() . '/inc/order-admin.php';
require_once get_template_directory() . '/inc/collection.php';
require_once get_template_directory() . '/inc/product-detail.php';

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

// custom breadcrumbs
function render_custom_breadcrumbs() {
    global $post;

    // Do not run on home page
    if (is_front_page()) return;

    echo '<nav class="uppercase tracking-[.25em] text-[12px] text-gray-400 mb-5 flex items-center gap-2 flex-wrap">';
    
    // Home Link
    echo '<a href="' . home_url() . '" class="hover:text-[#156E8A] transition-colors">HOME</a>';

    if (is_page()) {
        // If the page has parent pages (e.g., Services -> Air Purifiers)
        if ($post->post_parent) {
            $ancestors = array_reverse(get_post_ancestors($post->ID));
            foreach ($ancestors as $ancestor) {
                echo '<span class="text-gray-300 px-1">/</span>';
                echo '<a href="' . get_permalink($ancestor) . '" class="hover:text-[#156E8A] transition-colors">' . get_the_title($ancestor) . '</a>';
            }
        }
        // Current Page Title
        echo '<span class="text-gray-300 px-1">/</span>';
        echo '<span class="text-gray-600 font-medium">' . get_the_title() . '</span>';

    } elseif (is_single()) {
        // For Blog Posts / Custom Post Types
        $category = get_the_category();
        if (!empty($category)) {
            echo '<span class="text-gray-300 px-1">/</span>';
            echo '<a href="' . get_category_link($category[0]->term_id) . '" class="hover:text-[#156E8A] transition-colors">' . strtoupper($category[0]->name) . '</a>';
        }
        echo '<span class="text-gray-300 px-1">/</span>';
        echo '<span class="text-gray-600 font-medium">' . get_the_title() . '</span>';

    } elseif (is_category() || is_archive()) {
        echo '<span class="text-gray-300 px-1">/</span>';
        echo '<span class="text-gray-600 font-medium">' . single_term_title('', false) . '</span>';
    }

    echo '</nav>';
}

// Register B2B Leads post type in Admin Sidebar
function register_b2b_leads_cpt() {
    register_post_type('b2b_lead', array(
        'labels' => array(
            'name'          => 'B2B Leads',
            'singular_name' => 'B2B Lead',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-id-alt',
        'supports'     => array('title', 'custom-fields'),
    ));
}
add_action('init', 'register_b2b_leads_cpt');

// 1. Add Meta Box to B2B Lead Edit Screen
function b2b_lead_register_meta_boxes() {
    add_meta_box(
        'b2b_lead_details',
        'Lead Submission Details',
        'b2b_lead_display_meta_box',
        'b2b_lead',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'b2b_lead_register_meta_boxes');

// 2. Render the Lead Details in a clean Admin Table
function b2b_lead_display_meta_box($post) {
    $company = get_post_meta($post->ID, '_company', true);
    $contact = get_post_meta($post->ID, '_contact', true);
    $phone   = get_post_meta($post->ID, '_phone', true);
    $email   = get_post_meta($post->ID, '_email', true);
    $space   = get_post_meta($post->ID, '_space', true);
    $units   = get_post_meta($post->ID, '_units', true);
    $area    = get_post_meta($post->ID, '_area', true);
    ?>
    <style>
        .b2b-lead-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .b2b-lead-table th, .b2b-lead-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .b2b-lead-table th { width: 220px; font-weight: 600; color: #374151; background-color: #f9fafb; }
        .b2b-lead-table td { color: #111827; }
        .b2b-lead-table a { color: #156E8A; text-decoration: none; font-weight: 500; }
        .b2b-lead-table a:hover { text-decoration: underline; }
    </style>

    <table class="b2b-lead-table">
        <tr>
            <th>Company / Organisation</th>
            <td><strong><?php echo esc_html($company ?: '—'); ?></strong></td>
        </tr>
        <tr>
            <th>Contact Person</th>
            <td><?php echo esc_html($contact ?: '—'); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>
                <?php if ($phone) : ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                <?php else : ?>—<?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Work Email</th>
            <td>
                <?php if ($email) : ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                <?php else : ?>—<?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Space Type</th>
            <td><?php echo esc_html($space ?: '—'); ?></td>
        </tr>
        <tr>
            <th>Approx. Units Needed</th>
            <td><?php echo esc_html($units ?: '—'); ?></td>
        </tr>
        <tr>
            <th>Total Area</th>
            <td><?php echo esc_html($area ?: '—'); ?></td>
        </tr>
    </table>
    <?php
}

// 3. Add Custom Columns to the "All B2B Leads" Admin Table
function b2b_lead_custom_columns($columns) {
    $new_columns = array(
        'cb'       => $columns['cb'],
        'title'    => 'Lead Title',
        'company'  => 'Company',
        'contact'  => 'Contact Person',
        'phone'    => 'Phone',
        'email'    => 'Email',
        'units'    => 'Units',
        'date'     => 'Date Received'
    );
    return $new_columns;
}
add_filter('manage_b2b_lead_posts_columns', 'b2b_lead_custom_columns');

// 4. Populate Custom Columns with Data
function b2b_lead_custom_column_data($column, $post_id) {
    switch ($column) {
        case 'company':
            echo esc_html(get_post_meta($post_id, '_company', true) ?: '—');
            break;
        case 'contact':
            echo esc_html(get_post_meta($post_id, '_contact', true) ?: '—');
            break;
        case 'phone':
            $phone = get_post_meta($post_id, '_phone', true);
            echo $phone ? '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>' : '—';
            break;
        case 'email':
            $email = get_post_meta($post_id, '_email', true);
            echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
            break;
        case 'units':
            echo esc_html(get_post_meta($post_id, '_units', true) ?: '—');
            break;
    }
}
add_action('manage_b2b_lead_posts_custom_column', 'b2b_lead_custom_column_data', 10, 2);


/**
 * Register Custom Post Type: Case Studies
 */
function breathein_register_case_studies_cpt() {
    $labels = array(
        'name'               => 'Case Studies',
        'singular_name'      => 'Case Study',
        'menu_name'          => 'Case Studies',
        'add_new'            => 'Add New Case Study',
        'add_new_item'       => 'Add New Case Study',
        'edit_item'          => 'Edit Case Study',
        'new_item'           => 'New Case Study',
        'view_item'          => 'View Case Study',
        'search_items'       => 'Search Case Studies',
        'not_found'          => 'No Case Studies found',
        'not_found_in_trash' => 'No Case Studies found in Trash',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => false, // Set to false so your custom Page (/case-studies/) handles the archive
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'case-studies', 'with_front' => false), // Changed 'case-study' to 'case-studies'
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('case_study', $args);
}
add_action('init', 'breathein_register_case_studies_cpt');

/**
 * Refresh the CPT permalink rules once after changing the Case Study slug.
 * Without this, existing rewrite rules can continue sending single posts to
 * the fallback index template or return a 404 until Permalinks are saved.
 */
function breathein_refresh_case_study_rewrites(): void
{
    if ('2' === get_option('breathein_case_study_rewrite_version')) {
        return;
    }

    flush_rewrite_rules(false);
    update_option('breathein_case_study_rewrite_version', '2', false);
}

add_action('init', 'breathein_refresh_case_study_rewrites', 20);
