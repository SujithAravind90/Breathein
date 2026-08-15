<?php

/**
 * Main site header.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

/**
 * Registered WordPress menu locations.
 */
$menu_locations = get_nav_menu_locations();

$primary_menu_id = isset($menu_locations['primary-menu'])
    ? (int) $menu_locations['primary-menu']
    : 0;

$theme_uri = get_template_directory_uri();

/**
 * Resolve a WordPress page URL from a page slug.
 */
$get_page_url = static function (string $slug): string {
    $page = get_page_by_path($slug);

    if ($page instanceof WP_Post) {
        return get_permalink($page);
    }

    return home_url('/' . trim($slug, '/') . '/');
};

/**
 * Header URLs.
 */
$home_url        = home_url('/');
$purifier_finder = $get_page_url('find-my-purifier');
$support_url     = $get_page_url('support');

/**
 * WooCommerce URLs.
 */
$cart_url = function_exists('wc_get_cart_url')
    ? wc_get_cart_url()
    : $get_page_url('cart');

$account_url = function_exists('wc_get_page_permalink')
    ? wc_get_page_permalink('myaccount')
    : wp_login_url();

/**
 * WooCommerce cart count.
 */
$cart_count = 0;

if (
    function_exists('WC')
    && WC()->cart
) {
    $cart_count = WC()->cart->get_cart_contents_count();
}

/**
 * Theme logo.
 */
$custom_logo_id = get_theme_mod('custom_logo');

if ($custom_logo_id) {
    $logo_url = wp_get_attachment_image_url(
        $custom_logo_id,
        'full'
    );

    $logo_alt = get_post_meta(
        $custom_logo_id,
        '_wp_attachment_image_alt',
        true
    );

    if (!$logo_alt) {
        $logo_alt = get_bloginfo('name');
    }
} else {
    $logo_url = $theme_uri . '/assets/images/logo.png';
    $logo_alt = get_bloginfo('name');
}

/**
 * Fallback menu.
 *
 * This menu is displayed only when no WordPress menu has
 * been assigned from Appearance > Menus.
 */
$fallback_menu = [
    [
        'label' => __('COLLECTION', 'breathein'),
        'url'   => $get_page_url('collection'),
    ],
    [
        'label' => __('TECHNOLOGY', 'breathein'),
        'url'   => $get_page_url('technology'),
    ],
    [
        'label' => __('APP', 'breathein'),
        'url'   => $get_page_url('app'),
    ],
    [
        'label' => __('REAL HOMES', 'breathein'),
        'url'   => $get_page_url('real-homes'),
    ],
    [
        'label' => __('COMPARE', 'breathein'),
        'url'   => $get_page_url('compare'),
    ],
];

/**
 * Temporary AQI ticker data.
 *
 * This can later be replaced with:
 * - ACF Options Page
 * - External AQI API
 * - WordPress custom post type
 */
$aqi_locations = [
    [
        'city'        => 'Delhi',
        'value'       => '392',
        'status'      => 'Hazardous',
        'badge_class' => 'bg-badgeHazardous',
    ],
    [
        'city'        => 'Ghaziabad',
        'value'       => '358',
        'status'      => 'Hazardous',
        'badge_class' => 'bg-badgeHazardous',
    ],
    [
        'city'        => 'Noida',
        'value'       => '311',
        'status'      => 'Hazardous',
        'badge_class' => 'bg-badgeHazardous',
    ],
    [
        'city'        => 'Patna',
        'value'       => '286',
        'status'      => 'Very Unhealthy',
        'badge_class' => 'bg-badgeVeryUnhealthy',
    ],
    [
        'city'        => 'Lucknow',
        'value'       => '242',
        'status'      => 'Very Unhealthy',
        'badge_class' => 'bg-badgeVeryUnhealthy',
    ],
    [
        'city'        => 'Kolkata',
        'value'       => '198',
        'status'      => 'Unhealthy',
        'badge_class' => 'bg-badgeUnhealthy',
    ],
    [
        'city'        => 'Mumbai',
        'value'       => '164',
        'status'      => 'Unhealthy',
        'badge_class' => 'bg-badgeUnhealthy',
    ],
];
?>

<!-- ========================================== -->
<!-- FULL-SCREEN MOBILE NAVIGATION OVERLAY      -->
<!-- ========================================== -->

<aside
    id="mobileNavOverlay"
    class="fixed inset-0 z-[60] hidden flex-col overflow-y-auto bg-tickerDark text-white opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
    aria-hidden="true">
    <div
        class="flex items-center justify-between border-b border-white/10 px-6 py-5">
        <a
            href="<?php echo esc_url($home_url); ?>"
            aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img
                src="<?php echo esc_url($logo_url); ?>"
                alt="<?php echo esc_attr($logo_alt); ?>"
                class="h-8 w-auto brightness-0 invert"
                width="180"
                height="40">
        </a>

        <button
            id="closeMobileNav"
            type="button"
            class="rounded-full border border-white/20 p-2 text-white transition-colors hover:border-brandTeal hover:text-brandTeal"
            aria-label="<?php esc_attr_e('Close menu', 'breathein'); ?>">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-7 w-7"
                aria-hidden="true">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav
        class="flex flex-1 items-center justify-center px-6 py-10"
        aria-label="<?php esc_attr_e('Mobile navigation', 'breathein'); ?>">
        <?php if ($primary_menu_id) : ?>
            <?php
            /**
             * Reuse the primary menu without its theme location so Max Mega
             * Menu transforms only the desktop navigation instance.
             */
            wp_nav_menu([
                'menu'           => $primary_menu_id,
                'theme_location' => '',
                'container'      => false,
                'menu_class'     => 'breathein-mobile-menu',
                'menu_id'        => 'breathein-mobile-menu',
                'fallback_cb'    => false,
                'depth'          => 3,
            ]);
            ?>
        <?php else : ?>
            <ul
                id="breathein-mobile-menu"
                class="breathein-mobile-menu">
                <?php foreach ($fallback_menu as $menu_item) : ?>
                    <li class="menu-item">
                        <a href="<?php echo esc_url($menu_item['url']); ?>">
                            <?php echo esc_html($menu_item['label']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </nav>

    <div
        class="flex items-center justify-center gap-6 border-t border-white/10 px-6 py-6 text-sm text-gray-400">
        <a
            href="<?php echo esc_url($account_url); ?>"
            class="transition-colors hover:text-white">
            <?php esc_html_e('My Account', 'breathein'); ?>
        </a>
        <a
            href="<?php echo esc_url($support_url); ?>"
            class="transition-colors hover:text-white">
            <?php esc_html_e('Support', 'breathein'); ?>
        </a>
    </div>
</aside>

<!-- ========================================== -->
<!-- SMART STICKY HEADER                        -->
<!-- ========================================== -->

<div
    id="smart-header"
    class="sticky top-0 z-50 flex w-full translate-y-0 flex-col shadow-sm transition-transform duration-300 ease-in-out">
    <!-- ====================================== -->
    <!-- AQI TICKER                             -->
    <!-- ====================================== -->

    <div
        class="animate-fade-in-down flex w-full items-center overflow-hidden bg-tickerDark text-[11px] font-medium tracking-wider text-white"
        style="animation-delay: 100ms">
        <div
            class="relative z-10 flex shrink-0 items-center gap-2 bg-tickerDark px-4 py-3 font-bold md:bg-brandTeal md:px-6">
            <span
                class="h-2.5 w-2.5 animate-pulse rounded-full bg-brandTeal md:bg-white"
                aria-hidden="true"></span>

            <?php esc_html_e('INDIA AQI TODAY', 'breathein'); ?>
        </div>

        <div
            class="relative z-10 h-6 w-px shrink-0 bg-gray-800"
            aria-hidden="true"></div>

        <div
            class="relative flex flex-1 overflow-hidden bg-tickerDark">
            <div
                class="animate-marquee flex items-center whitespace-nowrap pl-6">
                <?php
                /**
                 * Duplicate the list twice to create a seamless marquee.
                 */
                for (
                    $ticker_loop = 0;
                    $ticker_loop < 2;
                    $ticker_loop++
                ) :
                ?>

                    <div class="flex items-center gap-6 pr-6">

                        <?php
                        foreach (
                            $aqi_locations as $index => $location
                        ) :
                        ?>

                            <div class="flex items-center gap-2">

                                <span
                                    class="font-semibold text-gray-200">
                                    <?php
                                    echo esc_html(
                                        $location['city']
                                    );
                                    ?>
                                </span>

                                <span
                                    class="<?php echo esc_attr($location['badge_class']); ?> rounded-sm px-2 py-0.5 text-[12px] font-bold text-white">
                                    <?php
                                    echo esc_html(
                                        $location['value']
                                    );
                                    ?>
                                </span>

                                <span
                                    class="text-[12px] text-textMuted">
                                    <?php
                                    echo esc_html(
                                        $location['status']
                                    );
                                    ?>
                                </span>
                            </div>

                            <?php
                            if (
                                $index
                                < count($aqi_locations) - 1
                            ) :
                            ?>
                                <span
                                    class="text-gray-700"
                                    aria-hidden="true">
                                    |
                                </span>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <span
                            class="text-gray-700"
                            aria-hidden="true">
                            |
                        </span>
                    </div>

                <?php endfor; ?>
            </div>
        </div>

        <div
            class="relative z-10 hidden shrink-0 bg-tickerDark px-6 py-3 font-medium text-gray-300 shadow-[-10px_0_15px_-3px_rgba(13,20,24,1)] lg:block">
            <?php esc_html_e('Indoors is often', 'breathein'); ?>

            <span class="font-bold text-sky-400">
                <?php esc_html_e('5x worse', 'breathein'); ?>
            </span>

            &middot;

            <a
                href="<?php echo esc_url($purifier_finder); ?>"
                class="inline-flex items-center gap-1 text-white hover:underline">
                <?php esc_html_e('CHECK YOURS', 'breathein'); ?>

                <span aria-hidden="true">
                    &darr;
                </span>
            </a>
        </div>
    </div>

    <!-- ====================================== -->
    <!-- MAIN HEADER                            -->
    <!-- ====================================== -->

    <header
        class="site-header animate-fade-in-down flex w-full items-center justify-between border-b border-gray-100 bg-[#FAFCFD] px-4 py-3 md:px-8 md:py-4"
        style="animation-delay: 200ms">
        <!-- Logo -->
        <div class="flex shrink-0 items-center">

            <a
                href="<?php echo esc_url($home_url); ?>"
                class="block h-7 w-auto md:h-10"
                aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <img
                    src="<?php echo esc_url($logo_url); ?>"
                    alt="<?php echo esc_attr($logo_alt); ?>"
                    class="h-7 w-auto object-contain md:h-10"
                    width="180"
                    height="40">
            </a>
        </div>

        <!-- ================================== -->
        <!-- DESKTOP MAX MEGA MENU              -->
        <!-- ================================== -->
        <nav
            class="breathein-desktop-navigation hidden flex-1 items-center justify-center px-8 lg:flex"
            aria-label="<?php esc_attr_e('Primary navigation', 'breathein'); ?>">
            <?php if (has_nav_menu('primary-menu')) : ?>

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'breathein-primary-menu',
                    'menu_id'        => 'breathein-primary-menu',
                    'fallback_cb'    => false,
                    'depth'          => 0,
                ]);
                ?>

            <?php else : ?>

                <ul class="breathein-primary-menu">
                    <?php foreach ($fallback_menu as $menu_item) : ?>
                        <li class="menu-item">
                            <a href="<?php echo esc_url($menu_item['url']); ?>">
                                <?php echo esc_html($menu_item['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php endif; ?>
        </nav>

        <!-- ================================== -->
        <!-- HEADER ACTIONS                     -->
        <!-- ================================== -->

        <div
            class="flex shrink-0 items-center gap-3 md:gap-5">
            <?php
            $cart_link = function_exists('get_field')
                ? get_field('cart', 'option')
                : [];
            $cart_link_url = is_array($cart_link)
                ? (string) ($cart_link['url'] ?? '')
                : '';
            $cart_link_target = is_array($cart_link)
                && '_blank' === ($cart_link['target'] ?? '')
                ? '_blank'
                : '_self';

            if ($cart_link_url === '' || $cart_link_url === '#') {
                $cart_link_url = $cart_url;
                $cart_link_target = '_self';
            }
            ?>
            <!-- WooCommerce Cart -->
            <a
                id="cartBtn"
                href="<?php echo esc_url($cart_link_url); ?>"
                target="<?php echo esc_attr($cart_link_target); ?>"
                <?php if ('_blank' === $cart_link_target) : ?>
                    rel="noopener noreferrer"
                <?php endif; ?>
                class="relative flex items-center justify-center p-1.5 text-gray-900 transition-colors hover:text-brandTeal"
                aria-label="<?php esc_attr_e('View shopping cart', 'breathein'); ?>">
                <svg
                    width="22"
                    height="22"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true">
                    <circle
                        cx="9"
                        cy="21"
                        r="1.5"></circle>

                    <circle
                        cx="20"
                        cy="21"
                        r="1.5"></circle>

                    <path
                        d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>

                <span
                    class="breathein-cart-count absolute -right-1.5 -top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full border border-white bg-brandTeal px-1 text-[10px] font-bold leading-none text-white"
                    aria-label="<?php
                                echo esc_attr(
                                    sprintf(
                                        _n(
                                            '%d item in cart',
                                            '%d items in cart',
                                            $cart_count,
                                            'breathein'
                                        ),
                                        $cart_count
                                    )
                                );
                                ?>">
                    <?php
                    echo esc_html(
                        (string) $cart_count
                    );
                    ?>
                </span>
            </a>

            <!-- WooCommerce Account -->
            <a
                id="accountBtn"
                href="<?php echo esc_url($account_url); ?>"
                class="flex items-center justify-center p-1.5 text-gray-900 transition-colors hover:text-brandTeal"
                aria-label="<?php echo esc_attr(function_exists('breathein_customer_is_logged_in') && breathein_customer_is_logged_in() ? __('Open my account dashboard', 'breathein') : __('Sign in to my account', 'breathein')); ?>">
                <svg
                    width="22"
                    height="22"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="12" cy="8" r="3.5"></circle>
                    <path d="M4.5 21c.7-3.5 3.3-5.5 7.5-5.5s6.8 2 7.5 5.5"></path>
                </svg>
            </a>

            <!-- Purifier Finder CTA -->
            <?php
            $button = get_field('find_my_purifier', 'option');
            $url    = $button['url'] ?? $purifier_finder;
            $title  = $button['title'] ?? 'FIND MY PURIFIER';
            $target = $button['target'] ?? '_self';
            ?>
            <a
                href="<?php echo esc_url($url); ?>"
                target="<?php echo esc_attr($target); ?>"
                class="border border-black px-3 py-2 text-[10px] font-bold uppercase tracking-widest transition-all duration-200 hover:bg-black hover:text-white sm:text-[11px] md:px-6 md:py-2.5 md:text-[13px]">
                <span class="hidden sm:inline">
                    <?php echo esc_html($title); ?>
                </span>

                <?php
                $purifier_mobile_title = function_exists('get_field')
                    ? get_field('find_my_purifier_mobile_text', 'option')
                    : '';

                $purifier_mobile_title = $purifier_mobile_title ?: __('FIND', 'breathein');
                ?>

                <span class="sm:hidden">
                    <?php echo esc_html($purifier_mobile_title); ?>
                </span>
            </a>

            <!-- Dark Mode Toggle -->
            <button
                id="themeToggle"
                type="button"
                class="hidden items-center gap-1.5 rounded-full border border-gray-200 px-4 py-2 transition-colors hover:border-black lg:flex"
                aria-label="<?php esc_attr_e('Toggle dark mode', 'breathein'); ?>"
                aria-pressed="false">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-3.5 w-3.5"
                    aria-hidden="true">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>

                <span
                    class="text-[12px] font-bold tracking-widest">
                    <?php esc_html_e('DARK', 'breathein'); ?>
                </span>
            </button>

            <!-- Mobile Menu Button -->
            <button
                id="openMobileNav"
                type="button"
                class="p-1 lg:hidden"
                aria-label="<?php esc_attr_e('Open menu', 'breathein'); ?>"
                aria-controls="mobileNavOverlay"
                aria-expanded="false">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-7 w-7 text-gray-900"
                    aria-hidden="true">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>
</div>
