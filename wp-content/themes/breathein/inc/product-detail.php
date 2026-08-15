<?php

defined('ABSPATH') || exit;

/**
 * Product-detail fields that are not part of WooCommerce's standard product
 * record. The group is attached to products so the page can be edited from
 * Products > Edit Product in the WordPress dashboard.
 */
function breathein_product_detail_field_group(): array
{
    return [
        'key'      => 'group_breathein_product_detail',
        'title'    => __('Product Detail Page', 'breathein'),
        'fields'   => [
            [
                'key'           => 'field_breathein_product_model',
                'label'         => __('Model label', 'breathein'),
                'name'          => 'breathein_product_model',
                'type'          => 'text',
                'instructions'  => __('Shown beside the product name in the eyebrow line.', 'breathein'),
                'default_value' => '',
            ],
            [
                'key'           => 'field_breathein_product_feature_eyebrow',
                'label'         => __('Features eyebrow', 'breathein'),
                'name'          => 'breathein_product_feature_eyebrow',
                'type'          => 'text',
                'default_value' => 'What makes it special',
            ],
            [
                'key'           => 'field_breathein_product_feature_heading_lead',
                'label'         => __('Features heading lead', 'breathein'),
                'name'          => 'breathein_product_feature_heading_lead',
                'type'          => 'text',
                'default_value' => 'Engineered around',
            ],
            [
                'key'           => 'field_breathein_product_feature_heading_highlight',
                'label'         => __('Features heading highlighted text', 'breathein'),
                'name'          => 'breathein_product_feature_heading_highlight',
                'type'          => 'text',
                'default_value' => 'your space',
            ],
            [
                'key'           => 'field_breathein_product_feature_heading_trail',
                'label'         => __('Features heading trailing text', 'breathein'),
                'name'          => 'breathein_product_feature_heading_trail',
                'type'          => 'text',
                'default_value' => 'living.',
            ],
            [
                'key'          => 'field_breathein_product_specs',
                'label'        => __('Product specifications', 'breathein'),
                'name'         => 'breathein_product_specs',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => __('Add specification', 'breathein'),
                'sub_fields'  => [
                    [
                        'key'   => 'field_breathein_product_spec_value',
                        'label' => __('Value', 'breathein'),
                        'name'  => 'value',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_breathein_product_spec_label',
                        'label' => __('Label', 'breathein'),
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'          => 'field_breathein_product_features',
                'label'        => __('Feature cards', 'breathein'),
                'name'         => 'breathein_product_features',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => __('Add feature', 'breathein'),
                'sub_fields'  => [
                    [
                        'key'           => 'field_breathein_product_feature_icon',
                        'label'         => __('Icon', 'breathein'),
                        'name'          => 'icon',
                        'type'          => 'select',
                        'choices'       => [
                            'clock'   => __('Clock', 'breathein'),
                            'display' => __('Display', 'breathein'),
                            'shield'  => __('Shield', 'breathein'),
                        ],
                        'default_value' => 'clock',
                    ],
                    [
                        'key'   => 'field_breathein_product_feature_title',
                        'label' => __('Title', 'breathein'),
                        'name'  => 'title',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_breathein_product_feature_description',
                        'label' => __('Description', 'breathein'),
                        'name'  => 'description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                ],
            ],
            [
                'key'          => 'field_breathein_product_trust_points',
                'label'        => __('Trust points', 'breathein'),
                'name'         => 'breathein_product_trust_points',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => __('Add trust point', 'breathein'),
                'sub_fields'  => [
                    [
                        'key'   => 'field_breathein_product_trust_point',
                        'label' => __('Text', 'breathein'),
                        'name'  => 'text',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'          => 'field_breathein_product_brochure',
                'label'        => __('Product brochure', 'breathein'),
                'name'         => 'breathein_product_brochure',
                'type'         => 'link',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'product',
                ],
            ],
        ],
        'position'            => 'normal',
        'style'               => 'default',
        'label_placement'     => 'top',
        'instruction_placement' => 'label',
        'active'              => true,
        'show_in_rest'        => false,
    ];
}

function breathein_register_product_detail_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(breathein_product_detail_field_group());
}

add_action('acf/init', 'breathein_register_product_detail_fields');

function breathein_product_detail_field_group_exists(): bool
{
    $groups = get_posts([
        'post_type'      => 'acf-field-group',
        'post_status'    => ['publish', 'acf-disabled'],
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'name'           => 'group_breathein_product_detail',
    ]);

    return !empty($groups);
}

/**
 * Persist the group once so it is visible and editable under ACF > Field
 * Groups. Existing dashboard changes are never overwritten.
 */
function breathein_persist_product_detail_field_group(): void
{
    if (
        !is_admin()
        || !current_user_can('manage_options')
        || !function_exists('acf_import_field_group')
        || breathein_product_detail_field_group_exists()
    ) {
        return;
    }

    $field_group = function_exists('acf_get_field_group')
        ? acf_get_field_group('group_breathein_product_detail')
        : false;

    if (!is_array($field_group) || empty($field_group['fields'])) {
        return;
    }

    acf_import_field_group($field_group);
}

add_action('admin_init', 'breathein_persist_product_detail_field_group', 5);

/**
 * Supply the content from the supplied design for Air Pro and sensible
 * dynamic fallbacks for other products. Dashboard values take precedence.
 */
function breathein_product_detail_defaults(WC_Product $product): array
{
    $coverage = (string) $product->get_meta(
        defined('BREATHEIN_MATCHER_COVERAGE')
            ? BREATHEIN_MATCHER_COVERAGE
            : '_breathein_matcher_coverage',
        true
    );
    $filtration = (string) $product->get_meta(
        defined('BREATHEIN_MATCHER_FILTER')
            ? BREATHEIN_MATCHER_FILTER
            : '_breathein_matcher_filtration',
        true
    );
    $ideal_for = (string) $product->get_meta(
        defined('BREATHEIN_MATCHER_IDEAL')
            ? BREATHEIN_MATCHER_IDEAL
            : '_breathein_matcher_ideal_for',
        true
    );

    $defaults = [
        'breathein_product_model'                  => $product->get_sku(),
        'breathein_product_feature_eyebrow'       => __('What makes it special', 'breathein'),
        'breathein_product_feature_heading_lead'  => __('Engineered around', 'breathein'),
        'breathein_product_feature_heading_highlight' => $ideal_for ?: __('your space', 'breathein'),
        'breathein_product_feature_heading_trail'  => __('living.', 'breathein'),
        'breathein_product_specs'                  => array_values(array_filter([
            $coverage !== '' ? [
                'value' => $coverage . ' sq ft',
                'label' => __('Coverage', 'breathein'),
            ] : null,
            $filtration !== '' ? [
                'value' => $filtration,
                'label' => __('Filtration', 'breathein'),
            ] : null,
            $ideal_for !== '' ? [
                'value' => $ideal_for,
                'label' => __('Ideal for', 'breathein'),
            ] : null,
            $product->get_sku() !== '' ? [
                'value' => $product->get_sku(),
                'label' => __('SKU', 'breathein'),
            ] : null,
        ])),
        'breathein_product_features'              => [
            [
                'icon'        => 'clock',
                'title'       => __('Designed for everyday air', 'breathein'),
                'description' => $product->get_short_description()
                    ? wp_strip_all_tags($product->get_short_description())
                    : __('Quiet, considered performance for the rooms where you spend your time.', 'breathein'),
            ],
            [
                'icon'        => 'display',
                'title'       => __('Simple air-quality care', 'breathein'),
                'description' => $filtration ?: __('Clear product information and dependable filtration for daily use.', 'breathein'),
            ],
            [
                'icon'        => 'shield',
                'title'       => __('Built around your space', 'breathein'),
                'description' => $ideal_for ?: __('A focused purifier format that fits naturally into the home.', 'breathein'),
            ],
        ],
        'breathein_product_trust_points'          => array_values(array_filter([
            $filtration !== ''
                ? ['text' => sprintf(__('Filtration: %s', 'breathein'), $filtration)]
                : null,
            $ideal_for !== ''
                ? ['text' => sprintf(__('Ideal for: %s', 'breathein'), $ideal_for)]
                : null,
            $product->get_sku() !== ''
                ? ['text' => sprintf(__('Product code: %s', 'breathein'), $product->get_sku())]
                : null,
        ])),
        'breathein_product_brochure'              => [],
    ];

    if ($product->get_slug() === 'air-pro') {
        $defaults['breathein_product_model'] = 'Model P280W';
        $defaults['breathein_product_specs'] = [
            ['value' => '35–40 m²', 'label' => __('Coverage', 'breathein')],
            ['value' => '325 m³/h', 'label' => __('CADR', 'breathein')],
            ['value' => '3-Stage', 'label' => __('Filtration', 'breathein')],
            ['value' => '4.8 kg', 'label' => __('Weight', 'breathein')],
        ];
        $defaults['breathein_product_features'] = [
            [
                'icon'        => 'clock',
                'title'       => __('Double-Sided Suction', 'breathein'),
                'description' => __('Twin draws pull in from both sides for noticeably faster cleaning.', 'breathein'),
            ],
            [
                'icon'        => 'display',
                'title'       => __('Real-Time AQI Display', 'breathein'),
                'description' => __('See air quality live on the thin LED display, updated every second.', 'breathein'),
            ],
            [
                'icon'        => 'shield',
                'title'       => __('Double Deodorisation', 'breathein'),
                'description' => __('Twice the carbon in the media stage for cooking smells and smoke.', 'breathein'),
            ],
        ];
        $defaults['breathein_product_feature_heading_highlight'] = 'bedrooms';
        $defaults['breathein_product_trust_points'] = [
            ['text' => __('Internationally certified — HEPA H13, captures 99.97% of PM2.5', 'breathein')],
            ['text' => __('Filter replacement alerts & easy reorder', 'breathein')],
            ['text' => __('Ideal for: Bedrooms & compact spaces', 'breathein')],
        ];
    }

    return $defaults;
}

/**
 * Seed only empty product fields. This makes the supplied Air Pro content
 * available in the dashboard while preserving any existing edits.
 */
function breathein_seed_product_detail_fields(): void
{
    if (
        !is_admin()
        || !current_user_can('manage_options')
        || !function_exists('update_field')
        || get_option('breathein_product_detail_seeded_v1')
        || !function_exists('wc_get_products')
    ) {
        return;
    }

    $products = wc_get_products([
        'status' => ['publish', 'draft', 'pending', 'private'],
        'limit'  => -1,
        'return' => 'objects',
    ]);

    foreach ((array) $products as $product) {
        if (!$product instanceof WC_Product) {
            continue;
        }

        $defaults = breathein_product_detail_defaults($product);

        foreach ($defaults as $field_name => $default_value) {
            if (
                $default_value === ''
                || $default_value === []
                || get_field($field_name, $product->get_id())
            ) {
                continue;
            }

            update_field($field_name, $default_value, $product->get_id());
        }
    }

    update_option('breathein_product_detail_seeded_v1', 1, false);
}

add_action('admin_init', 'breathein_seed_product_detail_fields', 10);

/**
 * The supplied design includes a Buy Now action. Keep it tied to the real
 * WooCommerce cart flow and redirect only that action to checkout.
 */
function breathein_product_buy_now_redirect(string $url): string
{
    if (
        isset($_POST['breathein_buy_now'])
        && function_exists('wc_get_checkout_url')
    ) {
        return wc_get_checkout_url();
    }

    return $url;
}

add_filter('woocommerce_add_to_cart_redirect', 'breathein_product_buy_now_redirect');
