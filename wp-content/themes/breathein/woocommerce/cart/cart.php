<?php

/**
 * Cart Page
 *
 * @package Breathein
 * @version 11.0.0
 */

defined('ABSPATH') || exit;

$cart_product_specs = static function (WC_Product $product): string {
    $metadata_product = $product;

    if ($product->is_type('variation') && $product->get_parent_id()) {
        $parent_product = wc_get_product($product->get_parent_id());

        if ($parent_product instanceof WC_Product) {
            $metadata_product = $parent_product;
        }
    }

    $sku = (string) $product->get_sku();

    if ($sku === '' && $metadata_product !== $product) {
        $sku = (string) $metadata_product->get_sku();
    }

    $coverage = absint(
        $product->get_meta('_breathein_matcher_coverage')
    );

    if (!$coverage && $metadata_product !== $product) {
        $coverage = absint(
            $metadata_product->get_meta('_breathein_matcher_coverage')
        );
    }

    $filtration = sanitize_text_field(
        (string) $product->get_meta('_breathein_matcher_filtration')
    );

    if ($filtration === '' && $metadata_product !== $product) {
        $filtration = sanitize_text_field(
            (string) $metadata_product->get_meta(
                '_breathein_matcher_filtration'
            )
        );
    }

    if ($filtration === '') {
        $filtration = sanitize_text_field(
            (string) $metadata_product->get_attribute('pa_filtration')
        );
    }

    $parts = [];

    if ($sku !== '') {
        $parts[] = sprintf(
            esc_html__('Model %s', 'breathein'),
            esc_html($sku)
        );
    }

    if ($coverage > 0) {
        $coverage_square_metres = max(
            1,
            (int) (round(($coverage * 0.092903) / 5) * 5)
        );
        $parts[] = sprintf(
            esc_html__('Up to %s m', 'breathein'),
            esc_html(number_format_i18n($coverage_square_metres))
        ) . '&sup2;';
    }

    if ($filtration !== '') {
        $parts[] = esc_html($filtration);
    }

    return implode(' &middot; ', $parts);
};
?>

<section class="relative mx-auto w-full max-w-[1200px] px-6 py-10 md:px-10 lg:px-20 lg:py-20">
    <div
        class="breathein-cart-notices mb-8"
        aria-live="polite">
        <?php do_action('woocommerce_before_cart'); ?>
    </div>

    <div class="flex flex-col items-start gap-12 lg:flex-row lg:gap-16">
        <form
            class="woocommerce-cart-form w-full lg:w-[60%] xl:w-[65%]"
            action="<?php echo esc_url(wc_get_cart_url()); ?>"
            method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <div class="woocommerce-cart-form__contents flex flex-col gap-8">
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters(
                        'woocommerce_cart_item_product',
                        $cart_item['data'],
                        $cart_item,
                        $cart_item_key
                    );
                    $product_id = apply_filters(
                        'woocommerce_cart_item_product_id',
                        $cart_item['product_id'],
                        $cart_item,
                        $cart_item_key
                    );
                    $is_visible = apply_filters(
                        'woocommerce_cart_item_visible',
                        true,
                        $cart_item,
                        $cart_item_key
                    );

                    if (
                        !$_product instanceof WC_Product
                        || !$_product->exists()
                        || $cart_item['quantity'] <= 0
                        || !$is_visible
                    ) {
                        continue;
                    }

                    $product_name = apply_filters(
                        'woocommerce_cart_item_name',
                        $_product->get_name(),
                        $cart_item,
                        $cart_item_key
                    );
                    $product_permalink = apply_filters(
                        'woocommerce_cart_item_permalink',
                        $_product->is_visible()
                            ? $_product->get_permalink($cart_item)
                            : '',
                        $cart_item,
                        $cart_item_key
                    );
                    $cart_item_classes = apply_filters(
                        'woocommerce_cart_item_class',
                        'cart_item',
                        $cart_item,
                        $cart_item_key
                    );
                    $product_specs = $cart_product_specs($_product);
                    $thumbnail = apply_filters(
                        'woocommerce_cart_item_thumbnail',
                        $_product->get_image(
                            'woocommerce_thumbnail',
                            [
                                'class'    => 'h-full w-full object-contain',
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                                'alt'      => wp_strip_all_tags($product_name),
                            ]
                        ),
                        $cart_item,
                        $cart_item_key
                    );
                    ?>

                    <div
                        class="woocommerce-cart-form__cart-item <?php echo esc_attr($cart_item_classes); ?> flex items-start gap-6 border-b border-gray-200 pb-8 dark:border-gray-800 md:items-center">
                        <div
                            class="product-thumbnail relative flex h-28 w-24 shrink-0 items-center justify-center overflow-hidden rounded-[4px] border border-gray-200 bg-white p-2 dark:border-gray-800 dark:bg-tickerDark md:h-36 md:w-32">
                            <?php if ($product_permalink) : ?>
                                <a
                                    href="<?php echo esc_url($product_permalink); ?>"
                                    class="flex h-full w-full items-center justify-center"
                                    aria-label="<?php echo esc_attr(sprintf(__('View %s', 'breathein'), wp_strip_all_tags($product_name))); ?>">
                                    <?php echo wp_kses_post($thumbnail); ?>
                                </a>
                            <?php else : ?>
                                <?php echo wp_kses_post($thumbnail); ?>
                            <?php endif; ?>
                        </div>

                        <div class="flex w-full flex-col justify-between gap-4 md:flex-row md:items-center md:gap-6">
                            <div class="flex flex-col gap-4">
                                <div class="product-name">
                                    <h2 class="mb-1 text-xl font-normal text-gray-900 dark:text-white md:mb-2 md:text-2xl">
                                        <?php if ($product_permalink) : ?>
                                            <a
                                                href="<?php echo esc_url($product_permalink); ?>"
                                                class="transition-colors hover:text-[#156E8A]">
                                                <?php echo wp_kses_post($product_name); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo wp_kses_post($product_name); ?>
                                        <?php endif; ?>
                                    </h2>

                                    <?php if ($product_specs !== '') : ?>
                                        <p class="text-[11px] font-light tracking-wide text-gray-400 md:text-[12px]">
                                            <?php echo wp_kses_post($product_specs); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php
                                    do_action(
                                        'woocommerce_after_cart_item_name',
                                        $cart_item,
                                        $cart_item_key
                                    );

                                    $formatted_item_data = wc_get_formatted_cart_item_data(
                                        $cart_item
                                    );

                                    if ($formatted_item_data) :
                                        ?>
                                        <div class="breathein-cart-item-data mt-2 text-[11px] text-gray-400">
                                            <?php echo wp_kses_post($formatted_item_data); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    if (
                                        $_product->backorders_require_notification()
                                        && $_product->is_on_backorder(
                                            $cart_item['quantity']
                                        )
                                    ) :
                                        ?>
                                        <p class="backorder_notification mt-2 text-[11px] text-amber-700">
                                            <?php
                                            echo wp_kses_post(
                                                apply_filters(
                                                    'woocommerce_cart_item_backorder_notification',
                                                    __('Available on backorder', 'woocommerce'),
                                                    $product_id
                                                )
                                            );
                                            ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <?php
                                if ($_product->is_sold_individually()) {
                                    $minimum_quantity = 1;
                                    $maximum_quantity = 1;
                                } else {
                                    $minimum_quantity = 0;
                                    $maximum_quantity = $_product->get_max_purchase_quantity();
                                }

                                $quantity_input = woocommerce_quantity_input(
                                    [
                                        'input_id'    => 'quantity_' . sanitize_key($cart_item_key),
                                        'input_name'  => "cart[{$cart_item_key}][qty]",
                                        'input_value' => $cart_item['quantity'],
                                        'max_value'   => $maximum_quantity,
                                        'min_value'   => $minimum_quantity,
                                        'product_name' => wp_strip_all_tags($product_name),
                                        'classes'     => [
                                            'input-text',
                                            'qty',
                                            'text',
                                            'breathein-cart-qty-input',
                                        ],
                                    ],
                                    $_product,
                                    false
                                );

                                ob_start();
                                ?>
                                <div
                                    class="breathein-cart-quantity product-quantity flex h-10 w-[100px] items-center rounded-[2px] border border-gray-200 dark:border-gray-700"
                                    data-breathein-quantity>
                                    <button
                                        type="button"
                                        class="flex h-full flex-1 items-center justify-center text-gray-500 transition-colors hover:text-gray-900 disabled:cursor-not-allowed disabled:opacity-30 dark:hover:text-white"
                                        data-breathein-quantity-change="-1"
                                        aria-label="<?php echo esc_attr(sprintf(__('Decrease %s quantity', 'breathein'), wp_strip_all_tags($product_name))); ?>"
                                        <?php disabled($_product->is_sold_individually()); ?>>
                                        <span aria-hidden="true">&minus;</span>
                                    </button>

                                    <?php if ($_product->is_sold_individually()) : ?>
                                        <span class="flex h-full w-10 items-center justify-center border-x border-gray-200 text-center text-[13px] font-medium text-gray-900 dark:border-gray-700 dark:text-white">
                                            <?php echo esc_html((string) $cart_item['quantity']); ?>
                                        </span>
                                        <span class="hidden">
                                            <?php echo $quantity_input; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </span>
                                    <?php else : ?>
                                        <?php echo $quantity_input; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    <?php endif; ?>

                                    <button
                                        type="button"
                                        class="flex h-full flex-1 items-center justify-center text-gray-500 transition-colors hover:text-gray-900 disabled:cursor-not-allowed disabled:opacity-30 dark:hover:text-white"
                                        data-breathein-quantity-change="1"
                                        aria-label="<?php echo esc_attr(sprintf(__('Increase %s quantity', 'breathein'), wp_strip_all_tags($product_name))); ?>"
                                        <?php disabled($_product->is_sold_individually()); ?>>
                                        <span aria-hidden="true">&plus;</span>
                                    </button>
                                </div>
                                <?php
                                $quantity_control = ob_get_clean();

                                echo apply_filters(
                                    'woocommerce_cart_item_quantity',
                                    $quantity_control,
                                    $cart_item_key,
                                    $cart_item
                                ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            </div>

                            <div class="product-remove mt-2 flex w-full flex-row items-center justify-between md:mt-0 md:w-auto md:flex-col md:items-end md:justify-center">
                                <span class="product-subtotal text-xl font-normal tracking-tight text-gray-900 dark:text-white md:mb-3 md:text-2xl">
                                    <?php
                                    echo apply_filters(
                                        'woocommerce_cart_item_subtotal',
                                        WC()->cart->get_product_subtotal(
                                            $_product,
                                            $cart_item['quantity']
                                        ),
                                        $cart_item,
                                        $cart_item_key
                                    ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    ?>
                                </span>

                                <?php
                                $remove_link = sprintf(
                                    '<a role="button" href="%1$s" class="remove text-[11px] text-gray-400 underline transition-colors hover:text-gray-900 dark:hover:text-white" aria-label="%2$s" data-product_id="%3$s" data-product_sku="%4$s">%5$s</a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    esc_attr(
                                        sprintf(
                                            __('Remove %s from cart', 'woocommerce'),
                                            wp_strip_all_tags($product_name)
                                        )
                                    ),
                                    esc_attr((string) $product_id),
                                    esc_attr($_product->get_sku()),
                                    esc_html__('Remove', 'breathein')
                                );

                                echo apply_filters(
                                    'woocommerce_cart_item_remove_link',
                                    $remove_link,
                                    $cart_item_key
                                ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php do_action('woocommerce_cart_contents'); ?>

                <button
                    type="submit"
                    class="sr-only"
                    name="update_cart"
                    value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
                    <?php esc_html_e('Update cart', 'woocommerce'); ?>
                </button>

                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                <?php do_action('woocommerce_after_cart_contents'); ?>
            </div>

            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>

        <?php do_action('woocommerce_before_cart_collaterals'); ?>

        <div class="w-full md:min-w-[400px] lg:sticky lg:top-24 lg:w-[40%] xl:w-[35%]">
            <?php woocommerce_cart_totals(); ?>
        </div>
    </div>
</section>

<?php do_action('woocommerce_after_cart'); ?>
