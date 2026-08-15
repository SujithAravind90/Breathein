<?php

defined('ABSPATH') || exit;

$collection_products = function_exists('breathein_get_collection_products')
    ? breathein_get_collection_products()
    : [];
$collection_product_count = count($collection_products);
?>

<!-- ========================================== -->
<!-- SECTION 6: THE COLLECTIONS                 -->
<!-- ========================================== -->
<section id="the-collection" class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24">
    <div class="max-w-7xl mx-auto">
        <div
            class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-10 md:mb-24 gap-6 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <div>
                <span class="text-[11px] uppercase tracking-[0.2em] text-brandTeal font-bold mb-6 block">
                    <?php esc_html_e('The Collection', 'breathein'); ?>
                </span>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-gray-900 leading-[1.1]">
                    <?php esc_html_e('Curated for', 'breathein'); ?>
                    <br class="hidden md:block" />
                    <?php esc_html_e('every space.', 'breathein'); ?>
                </h2>
            </div>

            <p class="text-gray-500 text-sm font-light text-left md:text-right max-w-sm leading-relaxed lg:pb-2">
                <?php
                if ($collection_product_count > 0) {
                    echo esc_html(
                        sprintf(
                            _n(
                                '%s precisely crafted model. Designed for a specific space and purpose.',
                                '%s precisely crafted models. Each designed for a specific space and purpose.',
                                $collection_product_count,
                                'breathein'
                            ),
                            number_format_i18n($collection_product_count)
                        )
                    );
                } else {
                    esc_html_e(
                        'Precisely crafted air purifiers for every kind of space.',
                        'breathein'
                    );
                }
                ?>
            </p>
        </div>

        <?php if ($collection_products) : ?>
            <?php
            $collection_numerals = ['I', 'II', 'III', 'IV'];
            $collection_delays = [
                'delay-100',
                'delay-200',
                'delay-300',
                'delay-400',
            ];
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 items-start">
                <?php foreach ($collection_products as $collection_index => $collection_product) : ?>
                    <?php
                    $collection_product_id = (int) $collection_product->get_id();
                    $collection_product_name = $collection_product->get_name();
                    $collection_gallery_ids = $collection_product->get_gallery_image_ids();
                    $collection_image_id = !empty($collection_gallery_ids)
                        ? (int) $collection_gallery_ids[0]
                        : (int) $collection_product->get_image_id();
                    $collection_coverage = absint(
                        $collection_product->get_meta(
                            BREATHEIN_MATCHER_COVERAGE,
                            true
                        )
                    );
                    $collection_ideal_for = sanitize_text_field(
                        (string) $collection_product->get_meta(
                            BREATHEIN_MATCHER_IDEAL,
                            true
                        )
                    );
                    $collection_summary = wp_trim_words(
                        wp_strip_all_tags(
                            (string) (
                                $collection_product->get_short_description()
                                ?: $collection_product->get_description()
                            )
                        ),
                        22,
                        '…'
                    );
                    $collection_price = $collection_product->get_price_html();
                    $collection_model_number = $collection_numerals[
                        $collection_index
                    ] ?? number_format_i18n($collection_index + 1);
                    $collection_delay = $collection_delays[
                        min($collection_index, count($collection_delays) - 1)
                    ];
                    $collection_card_classes = implode(
                        ' ',
                        array_filter([
                            'bg-white flex flex-col shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100/50 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 group',
                            $collection_index % 2 === 1 ? 'lg:mt-16' : '',
                            $collection_delay,
                        ])
                    );
                    ?>
                    <article
                        data-collection-product-id="<?php echo esc_attr((string) $collection_product_id); ?>"
                        class="<?php echo esc_attr($collection_card_classes); ?>">
                        <div class="relative w-full aspect-[4/3] md:aspect-[4/5] bg-gray-100 overflow-hidden">
                            <a
                                href="<?php echo esc_url($collection_product->get_permalink()); ?>"
                                class="block w-full h-full"
                                aria-label="<?php echo esc_attr(sprintf(__('View %s', 'breathein'), $collection_product_name)); ?>">
                                <?php
                                $collection_image_attributes = [
                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700',
                                    'loading' => 'lazy',
                                    'decoding' => 'async',
                                ];

                                if ($collection_image_id) {
                                    echo wp_get_attachment_image(
                                        $collection_image_id,
                                        'large',
                                        false,
                                        $collection_image_attributes
                                    );
                                } elseif (function_exists('wc_placeholder_img')) {
                                    echo wc_placeholder_img(
                                        'woocommerce_single',
                                        $collection_image_attributes
                                    );
                                }
                                ?>
                            </a>

                            <?php if ($collection_ideal_for !== '') : ?>
                                <div
                                    class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[8.5px] font-bold uppercase tracking-widest text-brandTeal">
                                    <?php echo esc_html($collection_ideal_for); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6 md:p-8 flex flex-col flex-grow">
                            <span class="text-[11px] uppercase tracking-widest text-brandTeal font-bold mb-3">
                                <?php echo esc_html($collection_model_number); ?> &mdash;
                                <?php echo esc_html($collection_product_name); ?>
                            </span>
                            <h3 class="text-2xl font-light text-gray-900 mb-3">
                                <a
                                    href="<?php echo esc_url($collection_product->get_permalink()); ?>"
                                    class="hover:text-brandTeal transition-colors">
                                    <?php echo esc_html($collection_product_name); ?>
                                </a>
                            </h3>
                            <p class="text-[15px] text-gray-500 font-light mb-8 leading-relaxed">
                                <?php
                                echo $collection_summary !== ''
                                    ? esc_html($collection_summary)
                                    : esc_html__(
                                        'Discover cleaner air designed for your space.',
                                        'breathein'
                                    );
                                ?>
                            </p>

                            <div class="mt-auto">
                                <div class="w-full h-[1px] bg-[#DCE4E7] mb-5"></div>

                                <div class="flex justify-between items-end mb-6 gap-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 mb-0.5">
                                            <?php
                                            echo $collection_coverage > 0
                                                ? esc_html(
                                                    sprintf(
                                                        __('%s sq ft', 'breathein'),
                                                        number_format_i18n(
                                                            $collection_coverage
                                                        )
                                                    )
                                                )
                                                : esc_html__('See details', 'breathein');
                                            ?>
                                        </div>
                                        <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold">
                                            <?php esc_html_e('Coverage Area', 'breathein'); ?>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold mb-0.5">
                                            <?php esc_html_e('Starting From', 'breathein'); ?>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php
                                            echo $collection_price !== ''
                                                ? wp_kses_post($collection_price)
                                                : esc_html__(
                                                    'Contact for price',
                                                    'breathein'
                                                );
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <a
                                    href="<?php echo esc_url($collection_product->get_permalink()); ?>"
                                    class="flex lg:inline-flex items-center justify-between lg:justify-start gap-3 lg:gap-1.5 w-full lg:w-auto px-6 py-5 lg:p-0 bg-[#111111] lg:bg-transparent text-white lg:text-brandTeal text-[12px] lg:text-[11px] tracking-[0.15em] lg:tracking-widest font-bold uppercase rounded-sm lg:rounded-none hover:bg-[#156E8A] lg:hover:bg-transparent lg:hover:text-gray-900 transition-colors">
                                    <span>
                                        <?php esc_html_e('Explore', 'breathein'); ?>
                                        <span class="lg:hidden">
                                            <?php esc_html_e('Product', 'breathein'); ?>
                                        </span>
                                    </span>
                                    <span class="lg:text-[13px]" aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-500">
                <?php esc_html_e('The product collection will be available soon.', 'breathein'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
