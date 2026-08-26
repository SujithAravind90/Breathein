<?php

defined('ABSPATH') || exit;

/**
 * Store Book a Demo requests as an administrator-visible WordPress post type.
 */
function breathein_register_demo_requests(): void
{
    register_post_type('demo_request', [
        'labels' => [
            'name'               => __('Book a Demo Submissions', 'breathein'),
            'singular_name'      => __('Book a Demo Submission', 'breathein'),
            'menu_name'          => __('Book a Demo Submissions', 'breathein'),
            'all_items'          => __('All Submissions', 'breathein'),
            'view_item'          => __('View Submission', 'breathein'),
            'search_items'      => __('Search Submissions', 'breathein'),
            'not_found'          => __('No demo submissions found.', 'breathein'),
        ],
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_rest'        => false,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-email-alt',
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'supports'            => ['title'],
    ]);
}

add_action('init', 'breathein_register_demo_requests');

/**
 * Process the public Book a Demo form.
 */
function breathein_handle_demo_request(): void
{
    if (
        'POST' !== ($_SERVER['REQUEST_METHOD'] ?? '')
        || empty($_POST['breathein_demo_form'])
    ) {
        return;
    }

    $page = get_page_by_path('book-a-demo');
    $page_id = $page instanceof WP_Post ? $page->ID : 0;
    $redirect_url = $page_id ? get_permalink($page_id) : home_url('/book-a-demo/');

    if (
        empty($_POST['breathein_demo_nonce'])
        || !wp_verify_nonce(
            sanitize_text_field(wp_unslash($_POST['breathein_demo_nonce'])),
            'breathein_submit_demo_request'
        )
    ) {
        wp_safe_redirect(add_query_arg('demo_status', 'invalid', $redirect_url));
        exit;
    }

    // Honeypot field for simple bot protection.
    if (!empty($_POST['company_website'])) {
        wp_safe_redirect(add_query_arg('demo_status', 'success', $redirect_url));
        exit;
    }

    $full_name = sanitize_text_field(wp_unslash($_POST['full_name'] ?? ''));
    $phone = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $city = sanitize_text_field(wp_unslash($_POST['city'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $interest = sanitize_text_field(wp_unslash($_POST['interest'] ?? ''));
    $space_type = sanitize_text_field(wp_unslash($_POST['space_type'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if (
        '' === $full_name
        || '' === $phone
        || '' === $city
        || !is_email($email)
        || '' === $interest
        || '' === $space_type
    ) {
        wp_safe_redirect(add_query_arg('demo_status', 'invalid', $redirect_url));
        exit;
    }

    $interest_display = breathein_demo_option_label(
        'book_demo_interest_options',
        $interest,
        $page_id
    );
    $space_display = breathein_demo_option_label(
        'book_demo_space_options',
        $space_type,
        $page_id
    );

    $request_title = sprintf(
        '%s - %s - %s',
        $full_name,
        $city,
        wp_date('Y-m-d H:i:s')
    );

    $request_id = wp_insert_post([
        'post_type'   => 'demo_request',
        'post_status' => 'publish',
        'post_title'  => $request_title,
    ], true);

    if (is_wp_error($request_id)) {
        wp_safe_redirect(add_query_arg('demo_status', 'error', $redirect_url));
        exit;
    }

    $request_meta = [
        'demo_full_name'  => $full_name,
        'demo_phone'      => $phone,
        'demo_city'       => $city,
        'demo_email'      => $email,
        'demo_interest'   => $interest_display,
        'demo_space_type' => $space_display,
        'demo_message'    => $message,
    ];

    foreach ($request_meta as $meta_key => $meta_value) {
        update_post_meta($request_id, $meta_key, $meta_value);
    }

    $recipient = sanitize_email(get_option('admin_email'));
    $site_name = wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES);
    $subject = sprintf(
        '[%s] New Book a Demo request from %s',
        $site_name,
        $full_name
    );
    $email_message = '<div style="font-family:Arial,sans-serif;line-height:1.6;color:#222">'
        . '<h2 style="color:#156E8A">New Book a Demo request</h2>'
        . '<table style="border-collapse:collapse;width:100%;max-width:640px">'
        . breathein_demo_email_row('Full name', $full_name)
        . breathein_demo_email_row('Phone', $phone)
        . breathein_demo_email_row('City', $city)
        . breathein_demo_email_row('Email', $email)
        . breathein_demo_email_row('I would like to', $interest_display)
        . breathein_demo_email_row('Space type', $space_display)
        . breathein_demo_email_row('Additional details', $message ?: 'Not provided')
        . '</table></div>';

    $sent = is_email($recipient) && wp_mail(
        $recipient,
        $subject,
        $email_message,
        [
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: ' . $email,
        ]
    );

    update_post_meta($request_id, 'demo_email_status', $sent ? 'sent' : 'failed');
    update_post_meta($request_id, 'demo_submitted_at', current_time('mysql'));

    wp_safe_redirect(add_query_arg('demo_status', $sent ? 'success' : 'email_failed', $redirect_url));
    exit;
}

add_action('template_redirect', 'breathein_handle_demo_request', 20);

/**
 * Convert an ACF option value into the label shown to the customer.
 */
function breathein_demo_option_label(string $field_name, string $value, int $page_id): string
{
    if (function_exists('get_field') && $page_id) {
        $options = get_field($field_name, $page_id);

        if (is_array($options)) {
            foreach ($options as $option) {
                if (
                    is_array($option)
                    && isset($option['option_value'], $option['option_label'])
                    && (string) $option['option_value'] === $value
                ) {
                    return sanitize_text_field((string) $option['option_label']);
                }
            }
        }
    }

    return $value;
}

/**
 * Build one escaped HTML row for the admin email.
 */
function breathein_demo_email_row(string $label, string $value): string
{
    return sprintf(
        '<tr><td style="border:1px solid #e5e7eb;padding:8px;font-weight:700;width:35%%">%s</td><td style="border:1px solid #e5e7eb;padding:8px">%s</td></tr>',
        esc_html($label),
        nl2br(esc_html($value))
    );
}

/**
 * Add useful columns to the Book a Demo submissions table.
 */
function breathein_demo_request_columns(array $columns): array
{
    return [
        'cb'           => $columns['cb'] ?? '<input type="checkbox" />',
        'title'        => __('Submission', 'breathein'),
        'demo_email'   => __('Email', 'breathein'),
        'demo_phone'   => __('Phone', 'breathein'),
        'demo_city'    => __('City', 'breathein'),
        'demo_interest'=> __('Request type', 'breathein'),
        'demo_space'   => __('Space type', 'breathein'),
        'demo_status'  => __('Email status', 'breathein'),
        'date'         => __('Submitted', 'breathein'),
    ];
}

add_filter('manage_demo_request_posts_columns', 'breathein_demo_request_columns');

function breathein_demo_request_column_data(string $column, int $post_id): void
{
    $meta_map = [
        'demo_email'    => 'demo_email',
        'demo_phone'    => 'demo_phone',
        'demo_city'     => 'demo_city',
        'demo_interest' => 'demo_interest',
        'demo_space'    => 'demo_space_type',
        'demo_status'   => 'demo_email_status',
    ];

    if (!isset($meta_map[$column])) {
        return;
    }

    $value = (string) get_post_meta($post_id, $meta_map[$column], true);

    if ('demo_email' === $column && $value) {
        printf('<a href="mailto:%s">%s</a>', esc_attr($value), esc_html($value));
        return;
    }

    if ('demo_status' === $column) {
        $label = 'sent' === $value ? __('Sent', 'breathein') : __('Failed', 'breathein');
        echo esc_html($label);
        return;
    }

    echo esc_html($value ?: '—');
}

add_action('manage_demo_request_posts_custom_column', 'breathein_demo_request_column_data', 10, 2);

/**
 * Show all submitted fields on an individual submission screen.
 */
function breathein_demo_request_meta_box(): void
{
    add_meta_box(
        'breathein_demo_request_details',
        __('Submission Details', 'breathein'),
        'breathein_render_demo_request_meta_box',
        'demo_request',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes_demo_request', 'breathein_demo_request_meta_box');

function breathein_render_demo_request_meta_box(WP_Post $post): void
{
    $fields = [
        'demo_full_name'  => __('Full name', 'breathein'),
        'demo_phone'      => __('Phone', 'breathein'),
        'demo_city'       => __('City', 'breathein'),
        'demo_email'      => __('Email', 'breathein'),
        'demo_interest'   => __('I would like to', 'breathein'),
        'demo_space_type' => __('Space type', 'breathein'),
        'demo_message'    => __('Additional details', 'breathein'),
        'demo_email_status' => __('Email status', 'breathein'),
        'demo_submitted_at' => __('Submitted at', 'breathein'),
    ];
    ?>
    <table class="widefat striped">
        <tbody>
        <?php foreach ($fields as $key => $label) : ?>
            <tr>
                <th style="width:220px"><?php echo esc_html($label); ?></th>
                <td><?php echo nl2br(esc_html((string) get_post_meta($post->ID, $key, true) ?: '—')); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

/**
 * Keep demo submissions read-only from the normal editor.
 */
add_filter('use_block_editor_for_post_type', static function (bool $use_block_editor, string $post_type): bool {
    return 'demo_request' === $post_type ? false : $use_block_editor;
}, 10, 2);
