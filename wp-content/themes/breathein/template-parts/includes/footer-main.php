<?php

/**
 * Dynamic main site footer.
 *
 * Footer navigation is managed from Appearance > Menus > Manage Locations.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

$theme_uri = get_template_directory_uri();
$home_url = home_url('/');

$custom_logo_id = get_theme_mod('custom_logo');

if ($custom_logo_id) {
    $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
    $logo_alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);

    if (!$logo_alt) {
        $logo_alt = get_bloginfo('name');
    }
} else {
    $logo_url = $theme_uri . '/assets/images/logo.png';
    $logo_alt = get_bloginfo('name');
}

$collection_page = get_page_by_path('products');
$shop_url = $collection_page instanceof WP_Post
    ? get_permalink($collection_page)
    : home_url('/products/');

$brochure_url = apply_filters(
    'breathein_brochure_url',
    home_url('/brochure/')
);

$footer_fallbacks = [
    'footer_1' => [
        ['label' => __('Air Pro', 'breathein'), 'url' => home_url('/air-pro/')],
        ['label' => __('Air Pro 1', 'breathein'), 'url' => home_url('/air-pro-1/')],
        ['label' => __('Air Pro 2', 'breathein'), 'url' => home_url('/air-pro-2/')],
        ['label' => __('Air Pro Max', 'breathein'), 'url' => home_url('/air-pro-max/')],
    ],
    'footer_2' => [
        ['label' => __('Technology', 'breathein'), 'url' => home_url('/technology/')],
        ['label' => __('The App', 'breathein'), 'url' => home_url('/app/')],
        ['label' => __('Compare Models', 'breathein'), 'url' => home_url('/compare/')],
        ['label' => __('Filter Care', 'breathein'), 'url' => home_url('/filter-care/')],
        [
            'label' => __('Corporate Solutions', 'breathein'),
            'url' => home_url('/corporate-solutions/'),
            'class' => 'footer-desktop-only',
        ],
    ],
    'footer_3' => [
        [
            'label' => __('Book a Demo', 'breathein'),
            'url' => home_url('/book-a-demo/'),
            'class' => 'footer-desktop-only',
        ],
        [
            'label' => __('Case Studies', 'breathein'),
            'url' => home_url('/case-studies/'),
            'class' => 'footer-desktop-only',
        ],
        ['label' => __('FAQ', 'breathein'), 'url' => home_url('/faq/')],
        ['label' => __('Support', 'breathein'), 'url' => home_url('/support/')],
        ['label' => __('Contact', 'breathein'), 'url' => home_url('/contact/')],
        [
            'label' => __('WhatsApp', 'breathein'),
            'url' => 'https://wa.me/919076636639',
            'class' => 'footer-mobile-only',
        ],
    ],
    'footer_4' => [
        ['label' => '+91 90766 36639', 'url' => 'tel:+919076636639'],
        [
            'label' => __('WhatsApp Support', 'breathein'),
            'url' => 'https://wa.me/919076636639',
        ],
        [
            'label' => 'enquiries@breathein.co.in',
            'url' => 'mailto:enquiries@breathein.co.in',
        ],
        ['label' => 'www.breathein.co.in', 'url' => $home_url],
        [
            'label' => __('Whitefield, Bengaluru', 'breathein'),
            'url' => home_url('/contact/'),
        ],
    ],
    'footer_bottom' => [
        ['label' => __('Privacy Policy', 'breathein'), 'url' => home_url('/privacy-policy/')],
        ['label' => __('Terms of Use', 'breathein'), 'url' => home_url('/terms-of-use/')],
        ['label' => __('Cookie Policy', 'breathein'), 'url' => home_url('/cookie-policy/')],
    ],
];

/**
 * Render an assigned footer menu, falling back to the supplied design links
 * while an empty location is being populated in the dashboard.
 */
$render_footer_menu = static function ($location, $fallback_items, $menu_class) {
    $locations = get_nav_menu_locations();
    $menu_id = isset($locations[$location]) ? (int) $locations[$location] : 0;
    $items = $menu_id ? wp_get_nav_menu_items($menu_id) : [];

    if ($menu_id && !empty($items)) {
        wp_nav_menu([
            'theme_location' => $location,
            'container' => false,
            'menu_class' => $menu_class,
            'fallback_cb' => false,
            'depth' => 1,
        ]);
        return;
    }

    echo '<ul class="' . esc_attr($menu_class) . '">';

    foreach ($fallback_items as $item) {
        $item_class = isset($item['class']) ? $item['class'] : '';

        echo '<li class="' . esc_attr($item_class) . '">';
        echo '<a href="' . esc_url($item['url']) . '">';
        echo esc_html($item['label']);
        echo '</a>';
        echo '</li>';
    }

    echo '</ul>';
};
?>

<!-- ========================================== -->
<!-- SECTION 17: FOOTER                         -->
<!-- ========================================== -->
<footer class="site-footer w-full bg-[#0B1115] px-6 pt-16 pb-8 md:px-16 md:pt-24 lg:px-24">
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-10 flex flex-col justify-between gap-12 lg:mb-20 lg:flex-row lg:gap-8">
            <div class="flex flex-col lg:w-5/12">
                <a href="<?php echo esc_url($home_url); ?>" class="mb-6 self-start"
                    aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>"
                        class="h-9 w-auto object-contain object-left md:h-10" width="180" height="40">
                </a>

                <p class="mb-8 max-w-sm text-[15px] font-light leading-[1.8] text-gray-400 md:text-[14px]">
                    <span class="hidden md:inline">
                        <?php esc_html_e('Clean air isn’t a luxury, it’s a necessity', 'breathein'); ?><br>
                        <?php esc_html_e('Sophisticated Japanese air-purification', 'breathein'); ?><br>
                        <?php esc_html_e('technology, at honest prices. The right air, for', 'breathein'); ?><br>
                        <?php esc_html_e('every Indian home.', 'breathein'); ?>
                    </span>
                    <span class="md:hidden">
                        <?php
                        esc_html_e(
                            'Clean air isn’t a luxury, it’s a necessity. Sophisticated Japanese air-purification technology, at honest prices.',
                            'breathein'
                        );
                        ?>
                    </span>
                </p>

                <div class="flex w-full max-w-[400px] flex-row items-center gap-3 md:gap-4">
                    <a href="<?php echo esc_url($shop_url); ?>"
                        class="flex flex-1 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-[#156E8A] px-2 py-4 text-[11px] font-bold uppercase tracking-[0.15em] text-white transition-colors hover:bg-[#11576E] md:text-[13px]">
                        <span><?php esc_html_e('Shop Now', 'breathein'); ?></span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>

                    <a href="<?php echo esc_url($brochure_url); ?>"
                        class="flex flex-1 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-[#156E8A] bg-[#156E8A] px-2 py-4 text-[11px] font-bold uppercase tracking-[0.15em] text-white transition-colors hover:bg-[#11576E] md:bg-transparent md:text-[13px] md:hover:bg-[#156E8A]">
                        <span><?php esc_html_e('Download Brochure', 'breathein'); ?></span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="mt-2 mb-2 h-px w-full bg-gray-800/80 lg:hidden"></div>

            <div class="grid grid-cols-3 gap-4 lg:w-7/12 lg:grid-cols-4 lg:gap-8">
                <div class="breathein-footer-nav flex flex-col">
                    <h2 class="mb-6 text-[11px] font-medium uppercase tracking-[0.2em] text-gray-500 md:text-[12px]">
                        <?php esc_html_e('Collection', 'breathein'); ?>
                    </h2>
                    <?php
                    $render_footer_menu(
                        'footer_1',
                        $footer_fallbacks['footer_1'],
                        'breathein-footer-menu'
                    );
                    ?>
                </div>

                <div class="breathein-footer-nav flex flex-col">
                    <h2 class="mb-6 text-[11px] font-medium uppercase tracking-[0.2em] text-gray-500 md:text-[12px]">
                        <?php esc_html_e('Explore', 'breathein'); ?>
                    </h2>
                    <?php
                    $render_footer_menu(
                        'footer_2',
                        $footer_fallbacks['footer_2'],
                        'breathein-footer-menu'
                    );
                    ?>
                </div>

                <div class="breathein-footer-nav flex flex-col">
                    <h2 class="mb-6 text-[11px] font-medium uppercase tracking-[0.2em] text-gray-500 lg:hidden">
                        <?php esc_html_e('Support', 'breathein'); ?>
                    </h2>
                    <div class="hidden h-[34px] lg:block"></div>
                    <?php
                    $render_footer_menu(
                        'footer_3',
                        $footer_fallbacks['footer_3'],
                        'breathein-footer-menu'
                    );
                    ?>
                </div>

                <div class="breathein-footer-nav hidden flex-col lg:flex">
                    <h2 class="mb-6 text-[12px] font-medium uppercase tracking-[0.2em] text-gray-500">
                        <?php esc_html_e('Contact', 'breathein'); ?>
                    </h2>
                    <?php
                    $render_footer_menu(
                        'footer_4',
                        $footer_fallbacks['footer_4'],
                        'breathein-footer-menu'
                    );
                    ?>
                </div>
            </div>
        </div>

        <div class="mb-6 h-px w-full bg-gray-800/80 lg:mb-8"></div>

        <div class="flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
            <nav class="breathein-footer-nav breathein-footer-legal lg:order-2"
                aria-label="<?php esc_attr_e('Legal navigation', 'breathein'); ?>">
                <?php
                $render_footer_menu(
                    'footer_bottom',
                    $footer_fallbacks['footer_bottom'],
                    'breathein-footer-bottom-menu'
                );
                ?>
            </nav>

            <p class="text-[11px] font-light text-gray-500 lg:order-1 md:text-[13px]">
                &copy; <?php echo esc_html(wp_date('Y')); ?>
                <?php echo esc_html(get_bloginfo('name')); ?>
                &mdash; <?php esc_html_e('The Right Air. All rights reserved. Made in India.', 'breathein'); ?>
            </p>
        </div>
    </div>
</footer>