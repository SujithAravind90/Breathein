<?php

/**
 * Template Name: Breathe In Checkout
 * Template Post Type: page
 *
 * WooCommerce checkout page using the theme's default header and footer.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

$is_order_received = function_exists('is_order_received_page')
    && is_order_received_page();
$breadcrumb_label = $is_order_received
    ? __('Order received', 'breathein')
    : __('Checkout', 'breathein');
$eyebrow = $is_order_received
    ? __('Order Confirmed', 'breathein')
    : __('Secure Checkout', 'breathein');
$headline_lead = $is_order_received
    ? __('Thank you for your', 'breathein')
    : __('Almost', 'breathein');
$headline_accent = $is_order_received
    ? __('order.', 'breathein')
    : __('there.', 'breathein');

add_filter(
    'body_class',
    static function (array $classes): array {
        return array_merge(
            $classes,
            [
                'breathein-checkout-page',
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
    <div
        class="pointer-events-none fixed right-0 top-0 -z-10 hidden h-screen w-[500px] lg:block"
        aria-hidden="true"
        style="background: radial-gradient(ellipse 100% 60% at 100% 50%, rgba(21, 110, 138, 0.1) 0%, rgba(255, 255, 255, 0) 100%);">
    </div>

    <section class="relative flex items-center overflow-hidden">
        <div
            class="pointer-events-none absolute inset-0 hidden md:block"
            aria-hidden="true"
            style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);">
        </div>

        <div class="relative z-10 mx-auto w-full max-w-[1200px] px-6 pt-10 md:px-10 lg:px-20 lg:pt-20">
            <div class="max-w-3xl">
                <nav
                    class="mb-5 text-[12px] uppercase tracking-[.25em] text-gray-400"
                    aria-label="<?php esc_attr_e('Breadcrumb', 'breathein'); ?>">
                    <a
                        href="<?php echo esc_url(home_url('/')); ?>"
                        class="transition-colors hover:text-[#156E8A]">
                        <?php esc_html_e('Home', 'breathein'); ?>
                    </a>
                    <span class="px-2 text-gray-300" aria-hidden="true">/</span>
                    <?php if (!$is_order_received && function_exists('wc_get_cart_url')) : ?>
                        <a
                            href="<?php echo esc_url(wc_get_cart_url()); ?>"
                            class="transition-colors hover:text-[#156E8A]">
                            <?php esc_html_e('Cart', 'breathein'); ?>
                        </a>
                        <span class="px-2 text-gray-300" aria-hidden="true">/</span>
                    <?php endif; ?>
                    <span aria-current="page"><?php echo esc_html($breadcrumb_label); ?></span>
                </nav>

                <div class="mb-6 flex items-center gap-4">
                    <div class="h-px w-8 bg-[#156E8A]" aria-hidden="true"></div>
                    <p class="text-[11px] font-bold uppercase tracking-[.25em] text-[#156E8A]">
                        <?php echo esc_html($eyebrow); ?>
                    </p>
                </div>

                <h1 class="mb-5 text-3xl font-light leading-tight tracking-tight text-gray-900 dark:text-white md:text-6xl lg:text-[80px]">
                    <?php echo esc_html($headline_lead); ?>
                    <span class="font-medium text-[#156E8A]"><?php echo esc_html($headline_accent); ?></span>
                </h1>
            </div>
        </div>
    </section>

    <section class="breathein-checkout-content relative z-10">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_content();
            }
        }
        ?>
    </section>
</main>

<?php get_footer(); ?>
