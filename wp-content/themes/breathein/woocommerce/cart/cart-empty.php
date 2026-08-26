<?php

/**
 * Empty cart page.
 *
 * @package Breathein
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

$collection_page = get_page_by_path('collection');

$shop_url = $collection_page instanceof WP_Post
    ? get_permalink($collection_page)
    : (wc_get_page_id('shop') > 0
        ? wc_get_page_permalink('shop')
        : home_url('/'));
?>

<section class="relative mx-auto w-full max-w-[1200px] px-6 py-10 md:px-10 lg:px-20 lg:py-20">
    <div
        class="mx-auto max-w-2xl rounded-[2px] border border-gray-200 bg-white px-6 py-14 text-center shadow-sm dark:border-gray-800 dark:bg-tickerDark md:px-10 md:py-20">
        <?php do_action('woocommerce_cart_is_empty'); ?>

        <p class="mx-auto mt-4 max-w-md text-[14px] font-light leading-relaxed text-gray-500 dark:text-gray-400">
            <?php esc_html_e('Explore the collection and add the right purifier for your space.', 'breathein'); ?>
        </p>

        <!-- <a
            href="<?php echo esc_url($shop_url); ?>"
            class="button wc-backward mx-auto mt-8 inline-flex items-center justify-center gap-3 rounded-[2px] bg-[#111111] px-8 py-4 text-[11px] font-bold uppercase tracking-[0.2em] text-white transition-colors hover:bg-[#156E8A] dark:bg-white dark:text-black dark:hover:bg-gray-200">
            <?php
            echo esc_html(
                apply_filters(
                    'woocommerce_return_to_shop_text',
                    __('Explore Collection', 'breathein')
                )
            );
            ?>
            <span class="text-lg leading-none" aria-hidden="true">&rarr;</span>
        </a> -->
    </div>
</section>