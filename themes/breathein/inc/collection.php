<?php

defined('ABSPATH') || exit;

/**
 * Return the default Collection page content.
 *
 * The defaults keep the page visually complete before the fields are filled
 * and are also used by the one-time content seeder below.
 *
 * @return array<string, mixed>
 */
function breathein_collection_defaults(): array
{
    $image_uri = get_template_directory_uri() . '/assets/images/';
    $shop_url = function_exists('wc_get_page_permalink')
        ? wc_get_page_permalink('shop')
        : home_url('/shop/');
    $technology_url = home_url('/technology/');

    return [
        'hero' => [
            'breadcrumb'       => __('COLLECTION', 'breathein'),
            'eyebrow'          => __('Four Models · One Standard', 'breathein'),
            'title_lead'       => __('The', 'breathein'),
            'title_highlight'  => __('Collection.', 'breathein'),
            'description'      => __(
                'Not a catalogue — a curated set of four. Each Breathe In model is sized for a specific kind of space, so the only choice you make is where it lives.',
                'breathein'
            ),
        ],
        'models' => [
            [
                'badge'          => '',
                'eyebrow'        => __('Air Pro · Model P280W', 'breathein'),
                'title'          => __('Air Pro', 'breathein'),
                'description'    => __(
                    'Compact protection for bedrooms and personal spaces. Double-sided suction cleans the air faster, with 3-stage filtration and double deodorisation. Designed for pet parents as well.',
                    'breathein'
                ),
                'desktop_image'  => $image_uri . 'air-pro-room.jpg',
                'mobile_image'   => $image_uri . 'air-pro-room-mobile.jpg',
                'image_alt'      => __('Air Pro', 'breathein'),
                'image_position' => 'left',
                'specs'          => [
                    ['label' => __('Coverage', 'breathein'), 'value' => '35 - 40 m²'],
                    ['label' => __('CADR', 'breathein'), 'value' => '325 m³/h'],
                    ['label' => __('Filtration', 'breathein'), 'value' => __('3-Stage', 'breathein')],
                ],
                'price_label'    => __('Starting from', 'breathein'),
                'price'          => '₹24,990',
                'mobile_action_label' => __('Add to Cart', 'breathein'),
                'action_link'    => [
                    'url'    => $shop_url,
                    'title'  => __('Add to Compare', 'breathein'),
                    'target' => '_self',
                ],
                'technology_link' => [
                    'url'    => $technology_url,
                    'title'  => __('The Technology', 'breathein'),
                    'target' => '_self',
                ],
            ],
            [
                'badge'          => '',
                'eyebrow'        => __('Air Pro 1 · Model C06 · Most Chosen', 'breathein'),
                'title'          => __('Air Pro 1', 'breathein'),
                'description'    => __(
                    'AI-intelligent 4-stage purification for medium to large rooms. LED touchscreen, mobile app control, and a reactive oxygen module for deeper cleaning.',
                    'breathein'
                ),
                'desktop_image'  => $image_uri . 'air-pro1-room.jpg',
                'mobile_image'   => $image_uri . 'air-pro1-room-mobile.jpg',
                'image_alt'      => __('Air Pro 1', 'breathein'),
                'image_position' => 'right',
                'specs'          => [
                    ['label' => __('Coverage', 'breathein'), 'value' => '50 - 55 m²'],
                    ['label' => __('CADR', 'breathein'), 'value' => '400 m³/h'],
                    ['label' => __('Filtration', 'breathein'), 'value' => __('4-Stage', 'breathein')],
                ],
                'price_label'    => __('Starting from', 'breathein'),
                'price'          => '₹44,990',
                'mobile_action_label' => __('Add to Cart', 'breathein'),
                'action_link'    => [
                    'url'    => $shop_url,
                    'title'  => __('Add to Compare', 'breathein'),
                    'target' => '_self',
                ],
                'technology_link' => [
                    'url'    => $technology_url,
                    'title'  => __('The Technology', 'breathein'),
                    'target' => '_self',
                ],
            ],
            [
                'badge'          => __('Bestseller', 'breathein'),
                'eyebrow'        => __('Air Pro 2 · Model C06 · Most Chosen', 'breathein'),
                'title'          => __('Air Pro 2', 'breathein'),
                'description'    => __(
                    'AI-intelligent 4-stage purification for medium to large rooms. LED touchscreen, mobile app control and a reactive oxygen module for deeper cleaning.',
                    'breathein'
                ),
                'desktop_image'  => $image_uri . 'air-pro2-room.jpg',
                'mobile_image'   => $image_uri . 'air-pro2-room-mobile.jpg',
                'image_alt'      => __('Air Pro 2', 'breathein'),
                'image_position' => 'left',
                'specs'          => [
                    ['label' => __('Coverage', 'breathein'), 'value' => '75 - 80 m²'],
                    ['label' => __('CADR', 'breathein'), 'value' => '400 m³/h'],
                    ['label' => __('Filtration', 'breathein'), 'value' => __('4-Stage', 'breathein')],
                ],
                'price_label'    => __('Starting from', 'breathein'),
                'price'          => '₹24,999.00',
                'mobile_action_label' => __('Add to Cart', 'breathein'),
                'action_link'    => [
                    'url'    => $shop_url,
                    'title'  => __('Add to Compare', 'breathein'),
                    'target' => '_self',
                ],
                'technology_link' => [
                    'url'    => $technology_url,
                    'title'  => __('The Technology', 'breathein'),
                    'target' => '_self',
                ],
            ],
            [
                'badge'          => '',
                'eyebrow'        => __('Air Pro Max · Ultimate Protection', 'breathein'),
                'title'          => __('Air Pro Max', 'breathein'),
                'description'    => __(
                    'Maximum capacity for expansive living spaces. Features dual HEPA filters, comprehensive smart home integration, and the highest CADR rating in its class.',
                    'breathein'
                ),
                'desktop_image'  => $image_uri . 'air-pro-max-room.jpg',
                'mobile_image'   => $image_uri . 'air-pro-max-room-mobile.jpg',
                'image_alt'      => __('Air Pro Max', 'breathein'),
                'image_position' => 'right',
                'specs'          => [
                    ['label' => __('Coverage', 'breathein'), 'value' => '90 - 100 m²'],
                    ['label' => __('CADR', 'breathein'), 'value' => '600 m³/h'],
                    ['label' => __('Filtration', 'breathein'), 'value' => __('5-Stage', 'breathein')],
                ],
                'price_label'    => __('Starting from', 'breathein'),
                'price'          => '₹34,999.00',
                'mobile_action_label' => __('Add to Cart', 'breathein'),
                'action_link'    => [
                    'url'    => $shop_url,
                    'title'  => __('Add to Compare', 'breathein'),
                    'target' => '_self',
                ],
                'technology_link' => [
                    'url'    => $technology_url,
                    'title'  => __('The Technology', 'breathein'),
                    'target' => '_self',
                ],
            ],
        ],
        'cta' => [
            'title_lead'      => __('Not sure which one', 'breathein'),
            'title_highlight' => __('fits?', 'breathein'),
            'description'     => __(
                "Tell us your room and we'll point you to the right model in seconds.",
                'breathein'
            ),
            'primary_link'    => [
                'url'    => home_url('/find-my-purifier/'),
                'title'  => __('Find My Purifier', 'breathein'),
                'target' => '_self',
            ],
            'secondary_link'  => [
                'url'    => home_url('/app/'),
                'title'  => __('See the App', 'breathein'),
                'target' => '_self',
            ],
        ],
    ];
}

/**
 * Read an ACF field and fall back only when it is genuinely empty.
 *
 * @param mixed  $fallback Fallback value.
 * @param int    $post_id  Page ID.
 * @return mixed
 */
function breathein_collection_field(string $name, $fallback, int $post_id = 0)
{
    if (!function_exists('get_field')) {
        return $fallback;
    }

    $value = get_field($name, $post_id ?: false);

    if ($value === null || $value === '' || $value === []) {
        return $fallback;
    }

    return $value;
}

/**
 * Resolve an ACF image value regardless of its configured return format.
 */
function breathein_collection_image_url($value, string $fallback = ''): string
{
    if (is_array($value)) {
        $value = $value['url'] ?? $value['ID'] ?? $value['id'] ?? '';
    }

    if (is_numeric($value) && function_exists('wp_get_attachment_image_url')) {
        $attachment_url = wp_get_attachment_image_url((int) $value, 'full');

        if ($attachment_url) {
            return (string) $attachment_url;
        }
    }

    if (is_string($value) && $value !== '') {
        return $value;
    }

    return $fallback;
}

/**
 * Normalize an ACF link field to the values needed by the template.
 *
 * @param mixed  $value    ACF link value.
 * @param string $url      Fallback URL.
 * @param string $title    Fallback title.
 * @return array{url: string, title: string, target: string}
 */
function breathein_collection_link($value, string $url = '', string $title = ''): array
{
    if (!is_array($value)) {
        $value = [];
    }

    $value_url = (string) ($value['url'] ?? '');
    $value_title = (string) ($value['title'] ?? '');

    return [
        'url'    => $value_url !== '' ? $value_url : $url,
        'title'  => $value_title !== '' ? $value_title : $title,
        'target' => (string) ($value['target'] ?? '_self'),
    ];
}

/**
 * Register the Collection Page ACF field group locally.
 *
 * Registering the group in code makes it available on a fresh deployment and
 * avoids requiring an ACF JSON import after the theme is installed.
 */
function breathein_register_collection_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_breathein_collection_page',
        'title'    => __('Collection Page', 'breathein'),
        'fields'   => [
            [
                'key'   => 'field_collection_hero_tab',
                'label' => __('Hero Section', 'breathein'),
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_collection_hero_breadcrumb',
                'label'         => __('Breadcrumb label', 'breathein'),
                'name'          => 'collection_hero_breadcrumb',
                'type'          => 'text',
                'default_value' => 'COLLECTION',
            ],
            [
                'key'           => 'field_collection_hero_eyebrow',
                'label'         => __('Eyebrow', 'breathein'),
                'name'          => 'collection_hero_eyebrow',
                'type'          => 'text',
                'default_value' => 'Four Models · One Standard',
            ],
            [
                'key'           => 'field_collection_hero_title_lead',
                'label'         => __('Heading lead', 'breathein'),
                'name'          => 'collection_hero_title_lead',
                'type'          => 'text',
                'default_value' => 'The',
            ],
            [
                'key'           => 'field_collection_hero_title_highlight',
                'label'         => __('Heading highlighted text', 'breathein'),
                'name'          => 'collection_hero_title_highlight',
                'type'          => 'text',
                'default_value' => 'Collection.',
            ],
            [
                'key'           => 'field_collection_hero_description',
                'label'         => __('Description', 'breathein'),
                'name'          => 'collection_hero_description',
                'type'          => 'textarea',
                'rows'          => 3,
                'new_lines'     => 'br',
                'default_value' => 'Not a catalogue — a curated set of four. Each Breathe In model is sized for a specific kind of space, so the only choice you make is where it lives.',
            ],
            [
                'key'   => 'field_collection_models_tab',
                'label' => __('Collection Models', 'breathein'),
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_collection_models',
                'label'        => __('Models', 'breathein'),
                'name'         => 'collection_models',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => __('Add model', 'breathein'),
                'min'          => 1,
                'sub_fields'   => [
                    [
                        'key'           => 'field_collection_model_badge',
                        'label'         => __('Badge', 'breathein'),
                        'name'          => 'badge',
                        'type'          => 'text',
                        'instructions' => __('Optional badge shown over the image, for example “Bestseller”.', 'breathein'),
                    ],
                    [
                        'key'  => 'field_collection_model_eyebrow',
                        'label' => __('Eyebrow', 'breathein'),
                        'name' => 'eyebrow',
                        'type' => 'text',
                    ],
                    [
                        'key'  => 'field_collection_model_title',
                        'label' => __('Model name', 'breathein'),
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'key'       => 'field_collection_model_description',
                        'label'     => __('Description', 'breathein'),
                        'name'      => 'description',
                        'type'      => 'textarea',
                        'rows'      => 4,
                        'new_lines' => 'br',
                    ],
                    [
                        'key'           => 'field_collection_model_desktop_image',
                        'label'         => __('Desktop image', 'breathein'),
                        'name'          => 'desktop_image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                        'library'       => 'all',
                    ],
                    [
                        'key'           => 'field_collection_model_mobile_image',
                        'label'         => __('Mobile image', 'breathein'),
                        'name'          => 'mobile_image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                        'library'       => 'all',
                    ],
                    [
                        'key'           => 'field_collection_model_image_alt',
                        'label'         => __('Image alt text', 'breathein'),
                        'name'          => 'image_alt',
                        'type'          => 'text',
                        'instructions' => __('Describe the image for visitors using screen readers.', 'breathein'),
                    ],
                    [
                        'key'           => 'field_collection_model_image_position',
                        'label'         => __('Image position on desktop', 'breathein'),
                        'name'          => 'image_position',
                        'type'          => 'select',
                        'choices'       => [
                            'left'  => __('Image left / text right', 'breathein'),
                            'right' => __('Text left / image right', 'breathein'),
                        ],
                        'default_value' => 'left',
                        'return_format' => 'value',
                    ],
                    [
                        'key'          => 'field_collection_model_specs',
                        'label'        => __('Specifications', 'breathein'),
                        'name'         => 'specs',
                        'type'         => 'repeater',
                        'layout'       => 'table',
                        'button_label' => __('Add specification', 'breathein'),
                        'min'          => 1,
                        'max'          => 3,
                        'sub_fields'  => [
                            [
                                'key'  => 'field_collection_model_spec_label',
                                'label' => __('Label', 'breathein'),
                                'name' => 'label',
                                'type' => 'text',
                            ],
                            [
                                'key'  => 'field_collection_model_spec_value',
                                'label' => __('Value', 'breathein'),
                                'name' => 'value',
                                'type' => 'text',
                            ],
                        ],
                    ],
                    [
                        'key'           => 'field_collection_model_price_label',
                        'label'         => __('Price label', 'breathein'),
                        'name'          => 'price_label',
                        'type'          => 'text',
                        'default_value' => 'Starting from',
                    ],
                    [
                        'key'   => 'field_collection_model_price',
                        'label' => __('Price', 'breathein'),
                        'name'  => 'price',
                        'type'  => 'text',
                    ],
                    [
                        'key'           => 'field_collection_model_mobile_action_label',
                        'label'         => __('Mobile action label', 'breathein'),
                        'name'          => 'mobile_action_label',
                        'type'          => 'text',
                        'default_value' => 'Add to Cart',
                    ],
                    [
                        'key'           => 'field_collection_model_action_link',
                        'label'         => __('Primary action link', 'breathein'),
                        'name'          => 'action_link',
                        'type'          => 'link',
                        'return_format' => 'array',
                    ],
                    [
                        'key'           => 'field_collection_model_technology_link',
                        'label'         => __('Technology link', 'breathein'),
                        'name'          => 'technology_link',
                        'type'          => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],
            [
                'key'   => 'field_collection_cta_tab',
                'label' => __('Bottom CTA', 'breathein'),
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_collection_cta_title_lead',
                'label'         => __('Heading lead', 'breathein'),
                'name'          => 'collection_cta_title_lead',
                'type'          => 'text',
                'default_value' => 'Not sure which one',
            ],
            [
                'key'           => 'field_collection_cta_title_highlight',
                'label'         => __('Heading highlighted text', 'breathein'),
                'name'          => 'collection_cta_title_highlight',
                'type'          => 'text',
                'default_value' => 'fits?',
            ],
            [
                'key'           => 'field_collection_cta_description',
                'label'         => __('Description', 'breathein'),
                'name'          => 'collection_cta_description',
                'type'          => 'textarea',
                'rows'          => 3,
                'new_lines'     => 'br',
                'default_value' => "Tell us your room and we'll point you to the right model in seconds.",
            ],
            [
                'key'           => 'field_collection_cta_primary_link',
                'label'         => __('Primary button', 'breathein'),
                'name'          => 'collection_cta_primary_link',
                'type'          => 'link',
                'return_format' => 'array',
            ],
            [
                'key'           => 'field_collection_cta_secondary_link',
                'label'         => __('Secondary button', 'breathein'),
                'name'          => 'collection_cta_secondary_link',
                'type'          => 'link',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'template-parts/collection.php',
                ],
            ],
        ],
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active'     => true,
        'show_in_rest' => false,
    ]);
}

add_action('acf/init', 'breathein_register_collection_fields');

/**
 * Check whether the dashboard-editable version of the field group exists.
 */
function breathein_collection_field_group_exists_in_database(): bool
{
    $groups = get_posts([
        'post_type'      => 'acf-field-group',
        'post_status'    => ['publish', 'acf-disabled'],
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'name'           => 'group_breathein_collection_page',
    ]);

    return !empty($groups);
}

/**
 * Persist the local group once so it appears under ACF → Field Groups.
 *
 * The import is intentionally one-way: after the group exists in the
 * database, dashboard edits remain authoritative and are never overwritten by
 * the theme on later requests.
 */
function breathein_persist_collection_field_group(): void
{
    if (
        !is_admin()
        || !current_user_can('manage_options')
        || !function_exists('acf_import_field_group')
        || breathein_collection_field_group_exists_in_database()
    ) {
        return;
    }

    $field_group = function_exists('acf_get_field_group')
        ? acf_get_field_group('group_breathein_collection_page')
        : false;

    if (!is_array($field_group) || empty($field_group['fields'])) {
        return;
    }

    acf_import_field_group($field_group);
}

add_action('admin_init', 'breathein_persist_collection_field_group', 5);

/**
 * Find the Collection page without assuming a particular page ID.
 */
function breathein_get_collection_page(): ?WP_Post
{
    $pages = get_pages([
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'meta_key'    => '_wp_page_template',
        'meta_value'  => 'template-parts/collection.php',
        'number'      => 1,
    ]);

    if (!empty($pages) && $pages[0] instanceof WP_Post) {
        return $pages[0];
    }

    $collection_page = get_page_by_path('collection');

    return $collection_page instanceof WP_Post ? $collection_page : null;
}

/**
 * Seed the initial content into empty Collection page fields once.
 *
 * This preserves existing editor content and gives the page its complete
 * supplied design immediately after the page/template is available.
 */
function breathein_seed_collection_page_content(): void
{
    if (
        !is_admin()
        || !current_user_can('manage_options')
        || !function_exists('update_field')
        || get_option('breathein_collection_seeded_v1')
    ) {
        return;
    }

    $page = breathein_get_collection_page();

    if (!$page) {
        $page_id = wp_insert_post(
            [
                'post_title'  => __('Collection', 'breathein'),
                'post_name'   => 'collection',
                'post_status' => 'publish',
                'post_type'   => 'page',
                'post_content' => '',
            ],
            true
        );

        if (is_wp_error($page_id) || !$page_id) {
            return;
        }

        update_post_meta(
            (int) $page_id,
            '_wp_page_template',
            'template-parts/collection.php'
        );
        $page = get_post((int) $page_id);
    }

    if (!$page instanceof WP_Post) {
        return;
    }

    $defaults = breathein_collection_defaults();
    $fields = [
        'field_collection_hero_breadcrumb'      => $defaults['hero']['breadcrumb'],
        'field_collection_hero_eyebrow'         => $defaults['hero']['eyebrow'],
        'field_collection_hero_title_lead'      => $defaults['hero']['title_lead'],
        'field_collection_hero_title_highlight' => $defaults['hero']['title_highlight'],
        'field_collection_hero_description'     => $defaults['hero']['description'],
        'field_collection_models'               => $defaults['models'],
        'field_collection_cta_title_lead'       => $defaults['cta']['title_lead'],
        'field_collection_cta_title_highlight'  => $defaults['cta']['title_highlight'],
        'field_collection_cta_description'      => $defaults['cta']['description'],
        'field_collection_cta_primary_link'     => $defaults['cta']['primary_link'],
        'field_collection_cta_secondary_link'   => $defaults['cta']['secondary_link'],
    ];

    foreach ($fields as $field_key => $value) {
        $field_name = preg_replace('/^field_collection_/', 'collection_', $field_key);

        if (!is_string($field_name)) {
            continue;
        }

        $existing = get_field($field_name, $page->ID);

        if ($existing !== null && $existing !== '' && $existing !== []) {
            continue;
        }

        update_field($field_key, $value, $page->ID);
    }

    update_option('breathein_collection_seeded_v1', gmdate('c'), false);
}

add_action('admin_init', 'breathein_seed_collection_page_content');

/**
 * Create an attachment for a tracked theme image when the Collection page
 * needs an initial image value. ACF image fields store attachment IDs even
 * when their return format is configured as a URL.
 */
function breathein_collection_asset_attachment_id(string $asset_name, string $title): int
{
    $existing = get_posts([
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_key'       => '_breathein_collection_asset',
        'meta_value'     => $asset_name,
    ]);

    if (!empty($existing)) {
        return (int) $existing[0];
    }

    $source = get_template_directory() . '/assets/images/' . $asset_name;

    if (!file_exists($source)) {
        return 0;
    }

    $upload = wp_upload_dir();
    $directory = trailingslashit($upload['basedir']) . 'breathein-collection';
    $url_base = trailingslashit($upload['baseurl']) . 'breathein-collection';

    if (!wp_mkdir_p($directory)) {
        return 0;
    }

    $filename = wp_unique_filename($directory, basename($source));
    $destination = trailingslashit($directory) . $filename;

    if (!copy($source, $destination)) {
        return 0;
    }

    $file_type = wp_check_filetype($filename, null);
    $attachment_id = wp_insert_attachment(
        [
            'post_mime_type' => $file_type['type'] ?? 'image/jpeg',
            'post_title'     => $title,
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => trailingslashit($url_base) . $filename,
        ],
        $destination
    );

    if (is_wp_error($attachment_id) || !$attachment_id) {
        return 0;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';

    $metadata = wp_generate_attachment_metadata(
        (int) $attachment_id,
        $destination
    );

    if (is_array($metadata)) {
        wp_update_attachment_metadata((int) $attachment_id, $metadata);
    }

    update_post_meta(
        (int) $attachment_id,
        '_breathein_collection_asset',
        $asset_name
    );

    return (int) $attachment_id;
}

/**
 * Populate empty Collection image fields with attachments from the theme.
 *
 * Existing image selections are left untouched. This migration is separate
 * from the text seeder so it can repair a page that was already initialized.
 */
function breathein_seed_collection_images(): void
{
    if (
        !is_admin()
        || !current_user_can('manage_options')
        || !function_exists('get_field')
        || !function_exists('update_field')
        || get_option('breathein_collection_images_seeded_v1')
    ) {
        return;
    }

    $page = breathein_get_collection_page();

    if (!$page) {
        return;
    }

    $models = get_field('collection_models', $page->ID);

    if (!is_array($models)) {
        return;
    }

    $defaults = breathein_collection_defaults();
    $changed = false;

    foreach ($models as $index => &$model) {
        if (!is_array($model)) {
            continue;
        }

        $default_model = $defaults['models'][$index]
            ?? $defaults['models'][count($defaults['models']) - 1];

        foreach (['desktop_image', 'mobile_image'] as $image_key) {
            if (!empty($model[$image_key])) {
                continue;
            }

            $asset_url = (string) ($default_model[$image_key] ?? '');
            $asset_name = basename((string) wp_parse_url($asset_url, PHP_URL_PATH));

            if ($asset_name === '') {
                continue;
            }

            $attachment_id = breathein_collection_asset_attachment_id(
                $asset_name,
                (string) ($model['title'] ?? $asset_name)
            );

            if ($attachment_id) {
                $model[$image_key] = $attachment_id;
                $changed = true;
            }
        }
    }
    unset($model);

    if ($changed) {
        update_field('field_collection_models', $models, $page->ID);
    }

    $has_images = true;

    foreach ($models as $model) {
        if (
            !is_array($model)
            || empty($model['desktop_image'])
            || empty($model['mobile_image'])
        ) {
            $has_images = false;
            break;
        }
    }

    if ($has_images) {
        update_option('breathein_collection_images_seeded_v1', gmdate('c'), false);
    }
}

add_action('admin_init', 'breathein_seed_collection_images');
