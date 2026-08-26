<?php

/**
 * Proceed to checkout button.
 *
 * @package Breathein
 * @version 7.0.1
 */

defined('ABSPATH') || exit;
?>

<a
    href="<?php echo esc_url(wc_get_checkout_url()); ?>"
    class="w-full bg-[#111111] dark:bg-white text-white dark:text-black p-4 flex items-center justify-center gap-3 text-[11px] font-bold uppercase tracking-[0.2em] rounded-[2px] hover:bg-black dark:hover:bg-gray-200 transition-colors">
    <?php esc_html_e('Proceed to Checkout', 'breathein'); ?>
    <span class="mb-[2px] text-lg leading-none" aria-hidden="true">&rarr;</span>
</a>