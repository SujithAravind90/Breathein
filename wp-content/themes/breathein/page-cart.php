<?php

/**
 * Template Name: Breathe In Cart
 * Template Post Type: page
 *
 * WooCommerce cart page using the theme's default header and footer.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

add_filter(
    'body_class',
    static function (array $classes): array {
        return array_merge(
            $classes,
            [
                'breathein-cart-page',
                'min-h-screen',
                'bg-[#FAFCFD]',
                'dark:bg-[#0D1418]',
            ]
        );
    }
);

get_header();
?>

<main id="primary" class="relative min-h-screen overflow-hidden">
    <!-- Soft Right-Side Radial Glow Effect -->
    <div
        class="pointer-events-none fixed right-0 top-0 -z-10 hidden h-screen w-[500px] lg:block"
        aria-hidden="true"
        style="background: radial-gradient(ellipse 100% 60% at 100% 50%, rgba(21, 110, 138, 0.1) 0%, rgba(255, 255, 255, 0) 100%);">
    </div>

    <!-- Cart Hero -->
    <section class="relative flex items-center overflow-hidden">
        <div
            class="pointer-events-none absolute inset-0 hidden md:block"
            aria-hidden="true"
            style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);">
        </div>

        <div class="relative z-10 mx-auto w-full max-w-[1200px] px-6 pt-10 md:px-10 lg:px-20 lg:pt-20">
            <div class="max-w-2xl">
                <nav
                    class="mb-5 text-[12px] uppercase tracking-[.25em] text-gray-400"
                    aria-label="<?php esc_attr_e('Breadcrumb', 'breathein'); ?>">
                    <a
                        href="<?php echo esc_url(home_url('/')); ?>"
                        class="transition-colors hover:text-[#156E8A]">
                        <?php esc_html_e('Home', 'breathein'); ?>
                    </a>
                    <span class="px-2 text-gray-300" aria-hidden="true">/</span>
                    <span aria-current="page"><?php esc_html_e('Cart', 'breathein'); ?></span>
                </nav>

                <div class="mb-6 flex items-center gap-4">
                    <div class="h-px w-8 bg-[#156E8A]" aria-hidden="true"></div>
                    <p class="text-[11px] font-bold uppercase tracking-[.25em] text-[#156E8A]">
                        <?php esc_html_e('Your Cart', 'breathein'); ?>
                    </p>
                </div>

                <h1 class="mb-5 text-3xl font-light leading-tight tracking-tight text-gray-900 dark:text-white md:text-6xl lg:text-[80px]">
                    <?php esc_html_e('Review your', 'breathein'); ?>
                    <span class="font-medium text-[#156E8A]"><?php esc_html_e('order.', 'breathein'); ?></span>
                </h1>
            </div>
        </div>
    </section>

    <?php
    if (shortcode_exists('woocommerce_cart')) {
        echo do_shortcode('[woocommerce_cart]');
    } else {
        ?>
        <section class="relative mx-auto w-full max-w-[1200px] px-6 py-10 md:px-10 lg:px-20 lg:py-20">
            <div class="border border-gray-200 bg-white p-8 text-center dark:border-gray-800 dark:bg-tickerDark">
                <p class="text-base text-gray-600 dark:text-gray-300">
                    <?php esc_html_e('The cart is temporarily unavailable.', 'breathein'); ?>
                </p>
            </div>
        </section>
        <?php
    }
    ?>
</main>

<?php get_footer(); ?>
