<?php

/**
 * Template Name: Collection Page
 *
 * The Collection page is managed from the Collection Page ACF panel. The
 * fallback data keeps the page usable if ACF is temporarily unavailable.
 */

defined('ABSPATH') || exit;

$page_id = get_queried_object_id();
$defaults = breathein_collection_defaults();

$hero_defaults = $defaults['hero'];
$hero = [
    'breadcrumb'      => breathein_collection_field(
        'collection_hero_breadcrumb',
        $hero_defaults['breadcrumb'],
        $page_id
    ),
    'eyebrow'         => breathein_collection_field(
        'collection_hero_eyebrow',
        $hero_defaults['eyebrow'],
        $page_id
    ),
    'title_lead'      => breathein_collection_field(
        'collection_hero_title_lead',
        $hero_defaults['title_lead'],
        $page_id
    ),
    'title_highlight' => breathein_collection_field(
        'collection_hero_title_highlight',
        $hero_defaults['title_highlight'],
        $page_id
    ),
    'description'     => breathein_collection_field(
        'collection_hero_description',
        $hero_defaults['description'],
        $page_id
    ),
];

$models_value = breathein_collection_field(
    'collection_models',
    $defaults['models'],
    $page_id
);
$models_value = is_array($models_value) ? $models_value : [];
$models = [];

foreach ($models_value as $index => $model_value) {
    if (!is_array($model_value)) {
        continue;
    }

    $model_defaults = $defaults['models'][$index]
        ?? $defaults['models'][count($defaults['models']) - 1];
    $model = array_merge($model_defaults, $model_value);

    $specs = isset($model_value['specs']) && is_array($model_value['specs'])
        ? $model_value['specs']
        : $model_defaults['specs'];
    $model['specs'] = array_values(
        array_filter(
            array_slice($specs, 0, 3),
            static fn($spec): bool => is_array($spec)
        )
    );

    $models[] = $model;
}

if (!$models) {
    $models = $defaults['models'];
}

$cta_defaults = $defaults['cta'];
$cta = [
    'title_lead'      => breathein_collection_field(
        'collection_cta_title_lead',
        $cta_defaults['title_lead'],
        $page_id
    ),
    'title_highlight' => breathein_collection_field(
        'collection_cta_title_highlight',
        $cta_defaults['title_highlight'],
        $page_id
    ),
    'description'     => breathein_collection_field(
        'collection_cta_description',
        $cta_defaults['description'],
        $page_id
    ),
    'primary_link'    => breathein_collection_field(
        'collection_cta_primary_link',
        $cta_defaults['primary_link'],
        $page_id
    ),
    'secondary_link'  => breathein_collection_field(
        'collection_cta_secondary_link',
        $cta_defaults['secondary_link'],
        $page_id
    ),
];

$collection_shop_url = function_exists('wc_get_page_permalink')
    ? wc_get_page_permalink('shop')
    : home_url('/shop/');

get_header();
?>
<main>
    <!-- ========================================== -->
    <!-- COLLECTION HERO SECTION                    -->
    <!-- ========================================== -->
    <section class="relative flex items-center overflow-hidden bg-[#FAFCFD]">
        <div
            class="absolute inset-0 hidden pointer-events-none md:block"
            aria-hidden="true"
            style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);">
        </div>

        <div class="relative z-10 mx-auto w-full max-w-[1400px] px-6 py-10 md:px-10 lg:px-20 lg:py-20">
            <div class="max-w-2xl">
                <nav
                    class="mb-5 text-[12px] uppercase tracking-[.25em] text-gray-400"
                    aria-label="<?php esc_attr_e('Breadcrumb', 'breathein'); ?>">
                    <a
                        href="<?php echo esc_url(home_url('/')); ?>"
                        class="transition-colors hover:text-[#156E8A]">
                        <?php esc_html_e('HOME', 'breathein'); ?>
                    </a>
                    <span class="px-2 text-gray-300" aria-hidden="true">/</span>
                    <span aria-current="page"><?php echo esc_html($hero['breadcrumb']); ?></span>
                </nav>

                <div class="mb-6 flex items-center gap-4">
                    <div class="h-px w-8 bg-[#156E8A]" aria-hidden="true"></div>
                    <p class="text-[11px] font-bold uppercase tracking-[.25em] text-[#156E8A]">
                        <?php echo esc_html($hero['eyebrow']); ?>
                    </p>
                </div>

                <h1 class="mb-5 text-5xl font-light leading-tight tracking-tight text-gray-900 md:text-6xl lg:text-[80px]">
                    <?php echo esc_html($hero['title_lead']); ?>
                    <span class="font-medium text-[#156E8A]">
                        <?php echo esc_html($hero['title_highlight']); ?>
                    </span>
                </h1>

                <p class="max-w-xl text-sm font-light leading-relaxed text-gray-500 md:text-base">
                    <?php echo wp_kses_post($hero['description']); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- COLLECTION GRID (ZIG-ZAG)                  -->
    <!-- ========================================== -->
    <section class="mx-auto max-w-[1400px] px-6 pb-10 md:px-10 lg:px-20">
        <?php foreach ($models as $model_index => $model) : ?>
            <?php
            $is_image_left = ($model['image_position'] ?? 'left') !== 'right';
            $image_order_class = $is_image_left
                ? ''
                : 'order-1 lg:order-2';
            $content_order_class = $is_image_left
                ? ''
                : 'order-2 lg:order-1';
            $model_defaults = $defaults['models'][$model_index]
                ?? $defaults['models'][count($defaults['models']) - 1];
            $desktop_image = breathein_collection_image_url(
                $model['desktop_image'] ?? '',
                $model_defaults['desktop_image']
            );
            $mobile_image = breathein_collection_image_url(
                $model['mobile_image'] ?? '',
                $model_defaults['mobile_image']
            );
            $image_alt = (string) ($model['image_alt'] ?? $model['title'] ?? '');
            $action_link = breathein_collection_link(
                $model['action_link'] ?? [],
                $collection_shop_url,
                __('Add to Compare', 'breathein')
            );
            $technology_link = breathein_collection_link(
                $model['technology_link'] ?? [],
                home_url('/technology/'),
                __('The Technology', 'breathein')
            );
            $model_specs = is_array($model['specs'] ?? null)
                ? $model['specs']
                : [];
            ?>
            <div class="mb-6 grid grid-cols-1 border-b border-gray-200/60 lg:mb-0 lg:grid-cols-2 lg:border-b-0">
                <div class="relative h-[250px] <?php echo esc_attr($image_order_class); ?> md:h-[400px] lg:min-h-[500px] lg:h-auto xl:min-h-[600px]">
                    <?php if (!empty($model['badge'])) : ?>
                        <div class="absolute left-0 top-6 z-10 bg-[#156E8A] px-4 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-sm">
                            <?php echo esc_html($model['badge']); ?>
                        </div>
                    <?php endif; ?>
                    <picture>
                        <source media="(min-width: 1024px)" srcset="<?php echo esc_url($desktop_image); ?>" />
                        <img
                            src="<?php echo esc_url($mobile_image); ?>"
                            alt="<?php echo esc_attr($image_alt); ?>"
                            class="absolute inset-0 h-full w-full object-cover"
                            loading="<?php echo $model_index === 0 ? 'eager' : 'lazy'; ?>"
                            decoding="async" />
                    </picture>
                </div>

                <div class="flex flex-col justify-center bg-white px-4 py-5 <?php echo esc_attr($content_order_class); ?> lg:p-10 xl:p-20">
                    <?php if (!empty($model['eyebrow'])) : ?>
                        <p class="mb-4 text-[8px] font-bold uppercase tracking-[.25em] text-[#156E8A] md:text-[13px] lg:mb-6">
                            <?php echo esc_html($model['eyebrow']); ?>
                        </p>
                    <?php endif; ?>

                    <h2 class="mb-4 text-4xl font-light text-gray-900 md:text-5xl lg:mb-6">
                        <?php echo esc_html($model['title']); ?>
                    </h2>

                    <p class="mb-5 max-w-md text-[13px] font-light leading-relaxed text-gray-600 lg:mb-12 lg:text-gray-500">
                        <?php echo wp_kses_post($model['description']); ?>
                    </p>

                    <!-- Mobile-only technology link. -->
                    <div class="mb-5 inline-block self-start border-b border-gray-200 pb-4 pr-0 lg:hidden">
                        <a
                            href="<?php echo esc_url($technology_link['url']); ?>"
                            <?php if ($technology_link['target'] === '_blank') : ?>
                                target="_blank" rel="noopener noreferrer"
                            <?php endif; ?>
                            class="inline-flex items-center gap-3 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 transition-colors hover:text-[#156E8A]">
                            <?php echo esc_html($technology_link['title']); ?>
                            <span class="mb-[2px] text-base leading-none" aria-hidden="true">&rarr;</span>
                        </a>
                    </div>

                    <?php if ($model_specs) : ?>
                        <div class="mb-6 grid w-full grid-cols-3 gap-2 md:gap-4 lg:mb-12 lg:gap-6">
                            <?php foreach ($model_specs as $spec) : ?>
                                <?php
                                if (!is_array($spec)) {
                                    continue;
                                }
                                $spec_label = (string) ($spec['label'] ?? '');
                                $spec_value = (string) ($spec['value'] ?? '');
                                ?>
                                <div class="flex flex-col gap-1 bg-[#F8FAFC] p-2 sm:p-3 md:gap-1.5 lg:bg-transparent lg:p-0">
                                    <span class="order-1 text-[8px] font-medium uppercase tracking-[0.1em] text-gray-400 lg:order-2 lg:font-bold lg:tracking-[0.15em]">
                                        <?php echo esc_html($spec_label); ?>
                                    </span>
                                    <h3 class="order-2 truncate text-[14px] font-normal tracking-tight text-gray-900 sm:text-[17px] lg:order-1 lg:text-xl xl:text-2xl">
                                        <?php echo esc_html($spec_value); ?>
                                    </h3>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mt-auto flex flex-row items-end justify-between lg:flex-col lg:items-start lg:gap-10">
                        <div class="flex flex-col gap-1 lg:flex-row lg:items-baseline lg:gap-3">
                            <span class="text-[8px] font-bold uppercase tracking-[0.15em] text-gray-400 lg:text-[12px] lg:normal-case lg:tracking-normal lg:font-light lg:text-gray-500">
                                <?php echo esc_html($model['price_label']); ?>
                            </span>
                            <span class="text-xl font-light leading-none tracking-tight text-gray-900 lg:text-3xl">
                                <?php echo esc_html($model['price']); ?>
                            </span>
                        </div>

                        <div class="flex items-center gap-6 md:gap-8">
                            <a
                                href="<?php echo esc_url($action_link['url']); ?>"
                                <?php if ($action_link['target'] === '_blank') : ?>
                                    target="_blank" rel="noopener noreferrer"
                                <?php endif; ?>
                                class="flex shrink-0 items-center gap-3 rounded-xl bg-[#111111] px-3 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-white transition-colors hover:bg-[#156E8A] lg:px-8">
                                <span class="hidden lg:inline"><?php echo esc_html($action_link['title']); ?></span>
                                <span class="lg:hidden"><?php echo esc_html($model['mobile_action_label']); ?></span>
                                <span class="mb-[2px] text-base leading-none" aria-hidden="true">&rarr;</span>
                            </a>

                            <a
                                href="<?php echo esc_url($technology_link['url']); ?>"
                                <?php if ($technology_link['target'] === '_blank') : ?>
                                    target="_blank" rel="noopener noreferrer"
                                <?php endif; ?>
                                class="hidden border-b border-gray-300 pb-1 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 transition-colors hover:border-[#156E8A] hover:text-[#156E8A] lg:inline-flex">
                                <?php echo esc_html($technology_link['title']); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- ========================================== -->
    <!-- DARK CTA SECTION: EXPLORE / COMPARE        -->
    <!-- ========================================== -->
    <?php
    $primary_link = breathein_collection_link(
        $cta['primary_link'],
        home_url('/find-my-purifier/'),
        __('Find My Purifier', 'breathein')
    );
    $secondary_link = breathein_collection_link(
        $cta['secondary_link'],
        home_url('/app/'),
        __('See the App', 'breathein')
    );
    ?>
    <section class="flex w-full flex-col items-center justify-center bg-[#0B1115] px-6 py-10 text-center md:py-20">
        <h2 class="mb-6 text-4xl font-light tracking-tight text-white md:mb-8 md:text-5xl lg:text-[56px]">
            <?php echo esc_html($cta['title_lead']); ?>
            <span class="text-[#156E8A]"><?php echo esc_html($cta['title_highlight']); ?></span>
        </h2>

        <p class="mx-auto mb-12 max-w-2xl text-[12px] font-light leading-relaxed text-gray-400 md:text-[15px]">
            <?php echo wp_kses_post($cta['description']); ?>
        </p>

        <div class="flex w-full max-w-md flex-row items-center justify-center gap-6 sm:max-w-none sm:gap-10">
            <a
                href="<?php echo esc_url($primary_link['url']); ?>"
                <?php if ($primary_link['target'] === '_blank') : ?>
                    target="_blank" rel="noopener noreferrer"
                <?php endif; ?>
                class="flex w-full items-center justify-center gap-3 rounded-xl bg-white px-4 py-4 text-[12px] font-bold uppercase tracking-[0.2em] text-[#0B1115] transition-colors hover:bg-gray-200 md:py-4 md:text-[13px] sm:w-auto">
                <span><?php echo esc_html($primary_link['title']); ?></span>
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>

            <a
                href="<?php echo esc_url($secondary_link['url']); ?>"
                <?php if ($secondary_link['target'] === '_blank') : ?>
                    target="_blank" rel="noopener noreferrer"
                <?php endif; ?>
                class="mt-2 w-full border-b border-gray-700 pb-1 text-center text-[12px] font-bold uppercase tracking-[0.2em] text-white transition-colors hover:border-[#156E8A] hover:text-[#156E8A] sm:mt-0 sm:w-auto md:text-[13px]">
                <?php echo esc_html($secondary_link['title']); ?>
            </a>
        </div>
    </section>
</main>
<?php get_footer(); ?>
