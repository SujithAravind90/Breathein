<?php

defined('ABSPATH') || exit;

global $product;

if (!$product instanceof WC_Product && function_exists('wc_get_product')) {
    $product = wc_get_product(get_the_ID());
}

get_header();

if (!$product instanceof WC_Product) :
    ?>
    <main class="mx-auto max-w-[1300px] px-6 py-20 md:px-10 lg:px-16">
        <p class="text-center text-gray-500">
            <?php esc_html_e('This product could not be found.', 'breathein'); ?>
        </p>
    </main>
    <?php
    get_footer();
    return;
endif;

$product_id = $product->get_id();
$product_name = $product->get_name();
$products_page = get_page_by_path('products', OBJECT, 'page');
$shop_url = $products_page
    ? get_permalink($products_page)
    : home_url('/products/');

$defaults = function_exists('breathein_product_detail_defaults')
    ? breathein_product_detail_defaults($product)
    : [];

$product_field = static function (string $name, $fallback = '') use ($product_id, $defaults) {
    $value = function_exists('get_field')
        ? get_field($name, $product_id)
        : null;

    if ($value !== null && $value !== '' && $value !== false) {
        return $value;
    }

    return array_key_exists($name, $defaults) ? $defaults[$name] : $fallback;
};

$stars = static function (float $rating, string $size = 'w-3.5 h-3.5'): string {
    $rounded = max(0, min(5, (int) round($rating)));
    $output = '<span class="breathein-stars" aria-label="' . esc_attr(
        sprintf(__('%s out of 5 stars', 'breathein'), number_format($rating, 1))
    ) . '">';

    for ($index = 1; $index <= 5; $index++) {
        $class = $index <= $rounded ? 'text-[#156E8A]' : 'text-gray-200';
        $output .= '<span class="' . esc_attr($size . ' ' . $class) . '" aria-hidden="true">★</span>';
    }

    return $output . '</span>';
};

$feature_icon = static function (string $icon): string {
    if ($icon === 'display') {
        return '<svg width="21" height="21" viewBox="0 0 21 21" fill="none" aria-hidden="true"><rect x="3.8" y="2.9" width="13.4" height="15.2" rx="1.9" stroke="currentColor" stroke-width="1.3"/><path d="M8.6 15.3h3.8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>';
    }

    if ($icon === 'shield') {
        return '<svg width="21" height="21" viewBox="0 0 21 21" fill="none" aria-hidden="true"><path d="m10.5 2.9 5.7 2.9v4.7c0 3.3-2.4 6.2-5.7 7.2-3.3-1-5.7-3.9-5.7-7.2V5.8l5.7-2.9Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><path d="m7.6 10.5 1.9 1.9 3.9-4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    }

    return '<svg width="21" height="21" viewBox="0 0 21 21" fill="none" aria-hidden="true"><circle cx="10.5" cy="10.5" r="7.6" stroke="currentColor" stroke-width="1.3"/><path d="M10.5 6.7v3.8l2.4 1.4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>';
};

$main_image_id = (int) $product->get_image_id();
$image_ids = array_values(array_unique(array_filter(array_merge(
    $main_image_id ? [$main_image_id] : [],
    (array) $product->get_gallery_image_ids()
))));

$images = [];

foreach ($image_ids as $image_id) {
    $image_url = wp_get_attachment_image_url($image_id, 'full');

    if (!$image_url) {
        continue;
    }

    $thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail') ?: $image_url;
    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

    $images[] = [
        'url'       => $image_url,
        'thumbnail' => $thumbnail_url,
        'alt'       => $alt ?: $product_name,
    ];
}

if (!$images && function_exists('wc_placeholder_img_src')) {
    $placeholder = wc_placeholder_img_src('full');
    $images[] = [
        'url'       => $placeholder,
        'thumbnail' => $placeholder,
        'alt'       => __('Product image placeholder', 'breathein'),
    ];
}

$short_description = $product->get_short_description();

if (!$short_description) {
    $short_description = wp_trim_words($product->get_description(), 55);
}

$specs = $product_field('breathein_product_specs', []);
$specs = is_array($specs) ? array_values(array_filter($specs, static function ($spec): bool {
    return is_array($spec)
        && ((string) ($spec['value'] ?? '') !== '' || (string) ($spec['label'] ?? '') !== '');
})) : [];

$features = $product_field('breathein_product_features', []);
$features = is_array($features) ? array_values(array_filter($features, static function ($feature): bool {
    return is_array($feature) && (string) ($feature['title'] ?? '') !== '';
})) : [];

$trust_points = $product_field('breathein_product_trust_points', []);
$trust_points = is_array($trust_points) ? array_values(array_filter($trust_points, static function ($point): bool {
    return is_array($point) && (string) ($point['text'] ?? '') !== '';
})) : [];

$model_label = (string) $product_field('breathein_product_model', '');
$feature_eyebrow = (string) $product_field(
    'breathein_product_feature_eyebrow',
    __('What makes it special', 'breathein')
);
$feature_heading_lead = (string) $product_field(
    'breathein_product_feature_heading_lead',
    __('Engineered around', 'breathein')
);
$feature_heading_highlight = (string) $product_field(
    'breathein_product_feature_heading_highlight',
    __('your space', 'breathein')
);
$feature_heading_trail = (string) $product_field(
    'breathein_product_feature_heading_trail',
    __('living.', 'breathein')
);

$average_rating = (float) $product->get_average_rating();
$review_count = (int) $product->get_review_count();
$regular_price = (float) $product->get_regular_price();
$sale_price = (float) $product->get_sale_price();
$discount = $regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price
    ? (int) round((($regular_price - $sale_price) / $regular_price) * 100)
    : 0;

$min_quantity = max(1, (int) $product->get_min_purchase_quantity());
$max_quantity = (int) $product->get_max_purchase_quantity();
$quantity_step = 1;

$related_products = [];
$related_ids = function_exists('wc_get_related_products')
    ? wc_get_related_products($product_id, 3)
    : [];

if (function_exists('wc_get_products')) {
    if (count($related_ids) < 3) {
        $related_ids = array_merge(
            $related_ids,
            wc_get_products([
                'status'  => 'publish',
                'limit'   => 3 - count($related_ids),
                'exclude' => array_merge([$product_id], $related_ids),
                'return'  => 'ids',
                'orderby' => 'menu_order',
                'order'   => 'ASC',
            ])
        );
    }

    foreach (array_values(array_unique(array_filter($related_ids))) as $related_id) {
        $related_product = wc_get_product($related_id);

        if ($related_product instanceof WC_Product && $related_product->is_visible()) {
            $related_products[] = $related_product;
        }

        if (count($related_products) >= 3) {
            break;
        }
    }
}

$reviews = get_comments([
    'post_id' => $product_id,
    'status'  => 'approve',
    'type'    => 'review',
    'number'  => 12,
    'orderby' => 'comment_date_gmt',
    'order'   => 'DESC',
]);
?>

<main class="breathein-product-page mx-auto max-w-[1300px] px-6 py-8 md:px-10 lg:px-16 lg:py-16">
    <nav class="mb-8 flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 lg:mb-12" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="transition-colors hover:text-gray-900">
            <?php esc_html_e('Home', 'breathein'); ?>
        </a>
        <span>/</span>
        <a href="<?php echo esc_url($shop_url); ?>" class="transition-colors hover:text-gray-900">
            <?php esc_html_e('Collection', 'breathein'); ?>
        </a>
        <span>/</span>
        <span class="text-gray-800"><?php echo esc_html($product_name); ?></span>
    </nav>

    <section class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-20">
        <div class="flex w-full flex-col bg-[#F4F9FA] pb-8 pt-4 md:bg-transparent md:pb-0 md:pt-0">
            <div class="swiper breathein-product-main-swiper mb-0 aspect-[4/5] w-full overflow-hidden border-0 bg-gradient-to-b from-transparent to-[#EAF4F7] md:mb-6 md:aspect-square md:rounded-[20px] md:border md:border-gray-200 md:from-white md:to-[#F4F9FA]">
                <div class="swiper-wrapper">
                    <?php foreach ($images as $image) : ?>
                        <div class="swiper-slide flex items-center justify-center p-10 lg:p-16">
                            <img
                                src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>"
                                class="h-full w-full object-contain drop-shadow-[0_10px_20px_rgba(0,0,0,0.05)] md:drop-shadow-none"
                                loading="eager">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="relative z-10 mx-6 mt-4 flex justify-center bg-white px-6 py-5 shadow-sm md:mx-0 md:mt-0 md:bg-transparent md:p-0 md:shadow-none">
                <div class="swiper breathein-product-thumb-swiper w-full max-w-[240px] overflow-visible md:max-w-none md:overflow-hidden">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $image) : ?>
                            <div class="swiper-slide flex aspect-square h-16 w-16 cursor-pointer items-center justify-center rounded-sm border border-gray-200 bg-gradient-to-b from-white to-[#F4F9FA] p-2 transition-all [&.swiper-slide-thumb-active]:border-[#156E8A] md:h-auto md:w-full md:rounded-[14px] md:border-2">
                                <img
                                    src="<?php echo esc_url($image['thumbnail']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>"
                                    class="pointer-events-none h-full w-full object-contain"
                                    loading="lazy">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-center">
            <p class="mb-3 text-[11px] font-bold uppercase tracking-[0.2em] text-[#156E8A]">
                <?php echo esc_html($product_name); ?><?php if ($model_label !== '') : ?> &middot; <?php echo esc_html($model_label); ?><?php endif; ?>
            </p>

            <h1 class="mb-3 text-4xl font-light leading-tight text-gray-900 lg:text-[44px]">
                <?php echo esc_html($product_name); ?>
            </h1>

            <div class="mb-6 flex items-center gap-2">
                <?php echo $stars($average_rating); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <span class="text-[13px] text-gray-400">
                    <?php if ($review_count > 0) : ?>
                        <?php echo esc_html(number_format_i18n($average_rating, 1)); ?> &middot; <?php echo esc_html(number_format_i18n($review_count)); ?> <?php esc_html_e('reviews', 'breathein'); ?>
                    <?php else : ?>
                        <?php esc_html_e('No reviews yet', 'breathein'); ?>
                    <?php endif; ?>
                </span>
            </div>

            <?php if ($short_description) : ?>
                <div class="mb-8 max-w-[90%] text-[12px] leading-[1.8] text-gray-500 md:text-[15px]">
                    <?php echo wp_kses_post(wpautop($short_description)); ?>
                </div>
            <?php endif; ?>

            <div class="mb-8 flex flex-col">
                <div class="breathein-product-price flex items-center gap-3">
                    <?php echo wp_kses_post($product->get_price_html()); ?>
                    <?php if ($discount > 0) : ?>
                        <span class="rounded-[2px] bg-[#E7F5ED] px-2 py-0.5 text-[11px] font-bold uppercase tracking-widest text-[#2C7A53]">
                            <?php echo esc_html($discount . '% ' . __('off', 'breathein')); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($specs) : ?>
                <div class="mb-8 grid w-full max-w-lg grid-cols-2 rounded-[2px] border border-gray-100">
                    <?php foreach ($specs as $index => $spec) : ?>
                        <div class="flex flex-col gap-0.5 border-gray-100 p-4 <?php echo $index < 2 ? 'border-b ' : ''; ?><?php echo $index % 2 === 0 ? 'border-r ' : ''; ?>">
                            <span class="text-[15px] font-medium text-gray-900"><?php echo esc_html((string) ($spec['value'] ?? '')); ?></span>
                            <span class="text-[13px] text-gray-400"><?php echo esc_html((string) ($spec['label'] ?? '')); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($product->is_purchasable() && $product->is_in_stock() && $product->is_type('simple')) : ?>
                <form class="cart breathein-product-cart mb-8 flex w-full max-w-lg flex-col items-start gap-6 lg:flex-row lg:items-center" action="<?php echo esc_url($product->get_permalink()); ?>" method="post" enctype="multipart/form-data">
                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                    <div class="flex shrink-0 items-center gap-4" data-breathein-quantity>
                        <span class="text-[13px] font-medium text-gray-500"><?php esc_html_e('Quantity', 'breathein'); ?></span>
                        <div class="flex h-11 w-24 items-center rounded-[2px] border border-gray-200">
                            <button type="button" class="flex h-full flex-1 items-center justify-center text-gray-500 transition-colors hover:text-gray-900" data-breathein-quantity-change="-1" aria-label="<?php esc_attr_e('Decrease quantity', 'breathein'); ?>">&minus;</button>
                            <input
                                type="number"
                                name="quantity"
                                value="<?php echo esc_attr($min_quantity); ?>"
                                min="<?php echo esc_attr($min_quantity); ?>"
                                <?php if ($max_quantity > 0) : ?>max="<?php echo esc_attr($max_quantity); ?>"<?php endif; ?>
                                step="<?php echo esc_attr($quantity_step); ?>"
                                class="w-8 appearance-none bg-transparent text-center text-[15px] font-medium text-gray-900 outline-none"
                                aria-label="<?php esc_attr_e('Product quantity', 'breathein'); ?>">
                            <button type="button" class="flex h-full flex-1 items-center justify-center text-gray-500 transition-colors hover:text-gray-900" data-breathein-quantity-change="1" aria-label="<?php esc_attr_e('Increase quantity', 'breathein'); ?>">&plus;</button>
                        </div>
                    </div>

                    <div class="flex w-full flex-1 items-center gap-3 lg:w-auto">
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>">
                        <button type="submit" class="flex h-11 flex-1 items-center justify-center gap-2 rounded-[2px] border border-black bg-white px-4 text-[13px] font-bold tracking-[0.1em] text-gray-900 transition-colors hover:bg-gray-50">
                            <?php esc_html_e('Add to Cart', 'breathein'); ?>
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                        <button type="submit" name="breathein_buy_now" value="1" class="flex h-11 flex-1 items-center justify-center rounded-[2px] bg-[#111111] px-4 text-[13px] font-bold tracking-[0.1em] text-white transition-colors hover:bg-black">
                            <?php esc_html_e('Buy Now', 'breathein'); ?>
                        </button>
                    </div>
                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </form>
            <?php elseif (!$product->is_in_stock()) : ?>
                <p class="mb-8 max-w-lg border border-gray-200 px-4 py-3 text-sm text-gray-500">
                    <?php esc_html_e('This product is currently out of stock.', 'breathein'); ?>
                </p>
            <?php else : ?>
                <div class="breathein-product-native-cart mb-8 max-w-lg">
                    <?php do_action('woocommerce_' . $product->get_type() . '_add_to_cart'); ?>
                </div>
            <?php endif; ?>

            <?php if ($trust_points) : ?>
                <div class="flex max-w-lg flex-col gap-3 border-t border-gray-100 pt-6">
                    <?php foreach ($trust_points as $trust_point) : ?>
                        <div class="flex items-center gap-3 text-gray-500">
                            <svg class="h-4 w-4 shrink-0 text-[#156E8A]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span class="text-[13px] leading-snug"><?php echo esc_html((string) ($trust_point['text'] ?? '')); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="my-10 h-px w-full bg-gray-100 lg:my-20"></div>

    <?php if ($features) : ?>
        <section class="mb-10 lg:mb-24">
            <div class="-mx-6 bg-[#FAFCFD] px-6 py-12 lg:mx-0 lg:bg-transparent lg:px-0 lg:py-0">
                <div class="mb-8 lg:mb-12">
                    <div class="mb-3 flex items-center gap-4 lg:mb-4">
                        <div class="hidden h-px w-8 bg-[#156E8A] lg:block"></div>
                        <p class="text-[13px] font-bold uppercase tracking-[0.2em] text-[#156E8A]">
                            <?php echo esc_html($feature_eyebrow); ?>
                        </p>
                    </div>
                    <h2 class="text-3xl font-light tracking-tight text-gray-900 md:text-4xl">
                        <?php echo esc_html($feature_heading_lead); ?>
                        <span class="font-medium text-[#156E8A]"><?php echo esc_html($feature_heading_highlight); ?></span>
                        <?php echo esc_html($feature_heading_trail); ?>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:gap-6">
                    <?php foreach ($features as $feature) : ?>
                        <article class="flex flex-row items-start gap-4 rounded-[2px] border border-gray-100 bg-white p-5 shadow-sm md:bg-transparent lg:flex-col lg:gap-6 lg:p-8 lg:shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
                            <div class="flex h-[52px] w-[52px] shrink-0 items-center justify-center bg-[#F0F5F7] text-gray-800 lg:h-8 lg:w-8 lg:rounded-full lg:border lg:border-gray-100 lg:bg-gray-50 lg:text-gray-500">
                                <?php echo $feature_icon((string) ($feature['icon'] ?? 'clock')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <div class="mt-0.5 flex flex-col lg:mt-0">
                                <h3 class="mb-1 text-[14px] font-medium text-gray-900 lg:mb-3 lg:text-[15px]">
                                    <?php echo esc_html((string) ($feature['title'] ?? '')); ?>
                                </h3>
                                <p class="text-[11px] leading-relaxed text-gray-500 lg:text-[13px] lg:leading-[1.7]">
                                    <?php echo esc_html((string) ($feature['description'] ?? '')); ?>
                                </p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($related_products) : ?>
        <div class="my-10 h-px w-full bg-gray-100 lg:my-20"></div>
        <section class="pb-12">
            <div class="mb-6 px-6 lg:mb-10 lg:px-0">
                <p class="text-[13px] font-bold uppercase tracking-[0.25em] text-gray-400 lg:hidden">
                    <?php esc_html_e('You might also consider', 'breathein'); ?>
                </p>
                <div class="hidden items-center gap-4 lg:flex">
                    <div class="h-px w-8 bg-[#156E8A]"></div>
                    <p class="text-[13px] font-bold uppercase tracking-[0.2em] text-[#156E8A]">
                        <?php esc_html_e('You might also consider', 'breathein'); ?>
                    </p>
                </div>
            </div>

            <div class="hide-scrollbar ml-6 flex snap-x snap-mandatory gap-3 overflow-x-auto px-6 lg:mx-0 lg:grid lg:grid-cols-3 lg:gap-6 lg:overflow-visible lg:px-0">
                <?php foreach ($related_products as $related_product) : ?>
                    <a href="<?php echo esc_url($related_product->get_permalink()); ?>" class="group flex w-[290px] shrink-0 snap-start flex-row items-center rounded-[2px] border border-gray-100 bg-white p-4 transition-all hover:border-[#156E8A] lg:w-auto lg:flex-col lg:items-start lg:rounded-[10px] lg:border-gray-200/80 lg:p-8">
                        <div class="flex h-24 w-20 shrink-0 items-center justify-center lg:mb-8 lg:h-52 lg:w-full">
                            <?php
                            $related_image_id = (int) $related_product->get_image_id();
                            $related_image_url = $related_image_id
                                ? wp_get_attachment_image_url($related_image_id, 'medium')
                                : (function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src('medium') : '');
                            ?>
                            <?php if ($related_image_url) : ?>
                                <img src="<?php echo esc_url($related_image_url); ?>" alt="<?php echo esc_attr($related_product->get_name()); ?>" class="max-h-full max-w-full object-contain" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="flex w-full flex-col pl-4 lg:pl-0">
                            <div class="flex items-center justify-between lg:block">
                                <h3 class="text-[15px] font-normal text-gray-900 lg:mb-2 lg:text-[16px]">
                                    <?php echo esc_html($related_product->get_name()); ?>
                                </h3>
                                <span class="flex items-center gap-1 text-[11px] font-medium text-[#156E8A] lg:hidden">
                                    <?php esc_html_e('View', 'breathein'); ?> <span aria-hidden="true">&rarr;</span>
                                </span>
                            </div>
                            <span class="text-[15px] font-light text-gray-500 lg:mb-6">
                                <?php echo wp_kses_post($related_product->get_price_html()); ?>
                            </span>
                            <span class="hidden items-center gap-2 text-[13px] font-bold uppercase tracking-[0.2em] text-[#156E8A] transition-all group-hover:gap-3 lg:flex">
                                <?php esc_html_e('View', 'breathein'); ?> <span aria-hidden="true">&rarr;</span>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <div class="my-10 h-px w-full bg-gray-100 lg:my-20"></div>

    <section class="pb-16 lg:pb-24">
        <div class="mb-10 lg:mb-12">
            <div class="mb-4 flex items-center gap-4">
                <div class="h-px w-8 bg-[#156E8A]"></div>
                <p class="text-[13px] font-bold uppercase tracking-[0.2em] text-[#156E8A]">
                    <?php esc_html_e('Customer Reviews', 'breathein'); ?>
                </p>
            </div>
            <h2 class="text-3xl font-light tracking-tight text-gray-900 md:text-4xl">
                <?php esc_html_e('What buyers are', 'breathein'); ?>
                <span class="font-medium text-[#156E8A]"><?php esc_html_e('saying', 'breathein'); ?></span>
            </h2>
        </div>

        <?php if ($reviews) : ?>
            <div class="swiper reviewsSwiper w-full overflow-hidden">
                <div class="swiper-wrapper items-stretch lg:grid lg:grid-cols-3 lg:gap-6">
                    <?php foreach ($reviews as $review) : ?>
                        <?php $review_rating = (float) get_comment_meta($review->comment_ID, 'rating', true); ?>
                        <article class="swiper-slide !flex !h-auto !w-[85%] flex-col rounded-[4px] border border-gray-100 bg-white p-6 shadow-[0_2px_10px_rgba(0,0,0,0.01)] md:!w-[350px] lg:!w-full lg:p-8">
                            <div class="mb-4 flex items-start justify-between">
                                <div class="flex flex-col">
                                    <div class="mb-1 flex items-center gap-2">
                                        <h3 class="text-[15px] font-medium text-gray-900"><?php echo esc_html(get_comment_author($review)); ?></h3>
                                        <span class="rounded-[2px] bg-[#EAF4F7] px-1.5 py-0.5 text-[8px] font-bold uppercase tracking-wider text-[#156E8A]">
                                            <?php esc_html_e('Verified', 'breathein'); ?>
                                        </span>
                                    </div>
                                    <time class="text-[11px] text-gray-400" datetime="<?php echo esc_attr(get_comment_date('c', $review)); ?>">
                                        <?php echo esc_html(get_comment_date('F Y', $review)); ?>
                                    </time>
                                </div>
                                <?php echo $stars($review_rating); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <div class="text-[12px] leading-relaxed text-gray-500 md:text-[15px]">
                                <?php echo wp_kses_post(wpautop(get_comment_text($review))); ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="reviews-pagination swiper-pagination relative !bottom-0 mt-6 flex items-center justify-center lg:!hidden"></div>
            </div>
        <?php else : ?>
            <div class="border border-gray-100 bg-[#FAFCFD] px-6 py-8 text-sm text-gray-500">
                <?php esc_html_e('No reviews yet. Be the first to share your experience with this product.', 'breathein'); ?>
            </div>
        <?php endif; ?>

        <?php if (comments_open($product_id)) : ?>
            <div class="my-8 h-px w-full bg-gray-100 lg:my-10"></div>
            <div class="breathein-review-form w-full max-w-[750px] rounded-[4px] border border-gray-100 bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] md:p-10 lg:p-12">
                <?php
                comment_form([
                    'title_reply'          => __('Write a Review', 'breathein'),
                    'label_submit'         => __('Submit Review', 'breathein'),
                    'comment_notes_before' => '',
                    'comment_notes_after'  => '',
                    'class_form'           => 'breathein-review-comment-form',
                    'class_submit'         => 'breathein-review-submit',
                    'fields'               => [
                        'author' => '<p class="comment-form-author"><label for="author">' . esc_html__('Your Name', 'breathein') . '</label><input id="author" name="author" type="text" value="" size="30" required /></p>',
                        'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'breathein') . '</label><input id="email" name="email" type="email" value="" size="30" required /></p>',
                    ],
                    'comment_field'        => '<p class="comment-form-rating"><label for="rating">' . esc_html__('Your Rating', 'breathein') . '</label><select name="rating" id="rating" required><option value="">' . esc_html__('Select a rating', 'breathein') . '</option><option value="5">5 — ' . esc_html__('Excellent', 'breathein') . '</option><option value="4">4 — ' . esc_html__('Very good', 'breathein') . '</option><option value="3">3 — ' . esc_html__('Good', 'breathein') . '</option><option value="2">2 — ' . esc_html__('Fair', 'breathein') . '</option><option value="1">1 — ' . esc_html__('Poor', 'breathein') . '</option></select></p><p class="comment-form-comment"><label for="comment">' . esc_html__('Your Review', 'breathein') . '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
                ], $product_id);
                ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
