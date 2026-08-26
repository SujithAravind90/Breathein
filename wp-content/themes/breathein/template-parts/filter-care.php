<?php

/**
 * Template Name: Filter Care Page
 */

defined('ABSPATH') || exit;

$filter_care_page_id = get_queried_object_id();

$filter_care_get_field = static function (string $name, $fallback = '') use ($filter_care_page_id) {
    if (!function_exists('get_field')) {
        return $fallback;
    }

    $value = get_field($name, $filter_care_page_id);

    return $value !== null && $value !== '' && $value !== false
        ? $value
        : $fallback;
};

$filter_care_hero_breadcrumb = (string) $filter_care_get_field(
    'filter_care_hero_breadcrumb',
    'Filter Care'
);
$filter_care_hero_eyebrow = (string) $filter_care_get_field(
    'filter_care_hero_eyebrow',
    'Filter Care & Maintenance'
);
$filter_care_hero_title_lead = (string) $filter_care_get_field(
    'filter_care_hero_title_lead',
    'Clean air'
);
$filter_care_hero_title_highlight = (string) $filter_care_get_field(
    'filter_care_hero_title_highlight',
    'kept simple.'
);
$filter_care_hero_description = (string) $filter_care_get_field(
    'filter_care_hero_description',
    'No guesswork, no surprises. Your purifier tells you exactly when a filter needs attention — and genuine replacements are always a tap away.'
);

$filter_care_maintenance_eyebrow = (string) $filter_care_get_field(
    'filter_care_maintenance_eyebrow',
    'Three Steps'
);
$filter_care_maintenance_heading_lead = (string) $filter_care_get_field(
    'filter_care_maintenance_heading_lead',
    'Maintenance that takes'
);
$filter_care_maintenance_heading_highlight = (string) $filter_care_get_field(
    'filter_care_maintenance_heading_highlight',
    'minutes.'
);
$filter_care_maintenance_steps = $filter_care_get_field(
    'filter_care_maintenance_steps',
    [
        [
            'step_label'  => 'Step 01',
            'title'       => 'Get the alert',
            'description' => "A Filter Replacement Alert appears on the unit's LED display and in the Smart Life app the moment a filter nears the end of its life.",
        ],
        [
            'step_label'  => 'Step 02',
            'title'       => 'Order genuine filters',
            'description' => 'Tap to reorder the exact filter for your model. Genuine Breathe In filters keep your HEPA H13 performance certified.',
        ],
        [
            'step_label'  => 'Step 03',
            'title'       => 'Swap in seconds',
            'description' => 'Slide out the old filter, slide in the new one, and reset the reminder. No tools, no service visit required.',
        ],
    ]
);

$filter_care_filter_life_heading = (string) $filter_care_get_field(
    'filter_care_filter_life_heading',
    'Filter life & replacement'
);
$filter_care_filter_life_description = (string) $filter_care_get_field(
    'filter_care_filter_life_description',
    'Indicative figures — actual life depends on usage and local air quality.'
);
$filter_care_filter_products = $filter_care_get_field(
    'filter_care_filter_products',
    []
);
$filter_care_filter_note = (string) $filter_care_get_field(
    'filter_care_filter_note',
    'Figures shown are indicative. Replace filter life and prices with official values.'
);
$filter_care_subscription_heading_lead = (string) $filter_care_get_field(
    'filter_care_subscription_heading_lead',
    'Never think about it again with a'
);
$filter_care_subscription_heading_highlight = (string) $filter_care_get_field(
    'filter_care_subscription_heading_highlight',
    'filter subscription.'
);
$filter_care_subscription_description = (string) $filter_care_get_field(
    'filter_care_subscription_description',
    "Opt in and we'll ship the right replacement filter to your door, automatically, before yours expires. Cancel anytime."
);
$filter_care_subscription_link = $filter_care_get_field(
    'filter_care_subscription_link',
    [
        'title'  => 'Set Up Reminders',
        'url'    => home_url('/support/'),
        'target' => '_self',
    ]
);

if (!is_array($filter_care_maintenance_steps)) {
    $filter_care_maintenance_steps = [];
}

if (!is_array($filter_care_filter_products)) {
    $filter_care_filter_products = [];
}

$filter_care_image_url = static function ($image): string {
    if (is_array($image)) {
        return (string) ($image['url'] ?? '');
    }

    if (is_numeric($image)) {
        return (string) wp_get_attachment_image_url((int) $image, 'full');
    }

    return is_string($image) ? $image : '';
};

$filter_care_image_alt = static function ($image, string $fallback): string {
    if (is_array($image) && !empty($image['alt'])) {
        return (string) $image['alt'];
    }

    $image_id = is_array($image)
        ? (int) ($image['ID'] ?? 0)
        : (is_numeric($image) ? (int) $image : 0);

    if ($image_id) {
        $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

        if ($alt) {
            return (string) $alt;
        }
    }

    return $fallback;
};

$filter_care_subscription_url = is_array($filter_care_subscription_link)
    ? (string) ($filter_care_subscription_link['url'] ?? '')
    : '';
$filter_care_subscription_target = is_array($filter_care_subscription_link)
    ? (string) ($filter_care_subscription_link['target'] ?? '_self')
    : '_self';
$filter_care_subscription_label = is_array($filter_care_subscription_link)
    ? (string) ($filter_care_subscription_link['title'] ?? 'Set Up Reminders')
    : 'Set Up Reminders';

$filter_care_subscription_url = $filter_care_subscription_url ?: home_url('/support/');

$filter_care_collection_page = get_page_by_path('collection');
$filter_care_collection_url = $filter_care_collection_page instanceof WP_Post
    ? get_permalink($filter_care_collection_page)
    : home_url('/collection/');

$filter_care_technology_page = get_page_by_path('technology');
$filter_care_technology_url = $filter_care_technology_page instanceof WP_Post
    ? get_permalink($filter_care_technology_page)
    : home_url('/technology/');

get_header();
?>

<main class="bg-[#F7F9FA]">
    <div class="pointer-events-none absolute inset-0 hidden md:block" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

    <section class="relative flex items-center overflow-hidden px-6 md:px-10 lg:px-16">
        <div class="relative z-10 mx-auto w-full max-w-[1200px] pt-10 lg:pt-20">
            <div class="max-w-2xl">
                <nav class="mb-5 uppercase tracking-[.25em] text-[12px] text-gray-400" aria-label="Breadcrumb">
                    <?php esc_html_e('HOME', 'breathein'); ?>
                    <span class="px-2 text-gray-300">/</span>
                    <?php echo esc_html($filter_care_hero_breadcrumb); ?>
                </nav>

                <div class="mb-6 flex items-center gap-4">
                    <div class="h-px w-8 bg-[#156E8A]"></div>
                    <p class="text-[11px] font-bold uppercase tracking-[.25em] text-[#156E8A]">
                        <?php echo esc_html($filter_care_hero_eyebrow); ?>
                    </p>
                </div>

                <h1 class="mb-5 text-3xl font-light leading-tight tracking-tight text-gray-900 md:text-6xl lg:text-[80px]">
                    <?php echo esc_html($filter_care_hero_title_lead); ?>
                    <span class="font-medium text-[#156E8A]"><?php echo esc_html($filter_care_hero_title_highlight); ?></span>
                </h1>

                <p class="max-w-xl text-sm font-light leading-relaxed text-gray-500 md:text-base">
                    <?php echo esc_html($filter_care_hero_description); ?>
                </p>
            </div>
        </div>
    </section>

    <section class="w-full px-0 py-0 font-sans transition-colors duration-300 md:px-10 lg:px-16 lg:py-24">
        <div class="mx-auto flex max-w-[1200px] flex-col gap-10 px-6 py-10 md:px-0 md:py-0 lg:gap-20">
            <div>
                <div class="m-auto mb-12 max-w-2xl text-left lg:mb-16">
                    <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-[#156E8A]">
                        <?php echo esc_html($filter_care_maintenance_eyebrow); ?>
                    </p>
                    <h2 class="text-3xl font-light tracking-tight md:text-4xl lg:text-5xl">
                        <span class="text-gray-500 dark:text-gray-400"><?php echo esc_html($filter_care_maintenance_heading_lead); ?></span>
                        <span class="font-medium text-[#156E8A] dark:text-[#2094B6]"><?php echo esc_html($filter_care_maintenance_heading_highlight); ?></span>
                    </h2>
                </div>

                <?php if ($filter_care_maintenance_steps) : ?>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:gap-8">
                        <?php foreach ($filter_care_maintenance_steps as $step) : ?>
                            <?php if (!is_array($step)) {
                                continue;
                            } ?>
                            <article class="flex flex-col rounded-[4px] border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-[#111a20] lg:p-8 lg:shadow-none">
                                <span class="mb-4 text-[14px] font-medium tracking-wide text-[#156E8A] dark:text-[#2094B6]">
                                    <?php echo esc_html((string) ($step['step_label'] ?? '')); ?>
                                </span>
                                <h3 class="mb-3 text-[18px] font-normal text-gray-900 dark:text-white">
                                    <?php echo esc_html((string) ($step['title'] ?? '')); ?>
                                </h3>
                                <p class="text-[13px] font-light leading-relaxed text-gray-500 dark:text-gray-400">
                                    <?php echo esc_html((string) ($step['description'] ?? '')); ?>
                                </p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mx-auto w-full max-w-[1200px]">
                <div class="mb-10 text-left lg:mb-12">
                    <h2 class="mb-3 text-3xl font-light tracking-tight text-gray-900 dark:text-white md:text-4xl">
                        <?php echo esc_html($filter_care_filter_life_heading); ?>
                    </h2>
                    <p class="text-[13px] font-light text-gray-500 dark:text-gray-400">
                        <?php echo esc_html($filter_care_filter_life_description); ?>
                    </p>
                </div>

                <?php if ($filter_care_filter_products) : ?>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8">

        <?php foreach ($filter_care_filter_products as $filter) : ?>

            <?php
            if (!is_array($filter)) {
                continue;
            }

            $filter_name      = (string) ($filter['name'] ?? '');
            $filter_image     = $filter['image'] ?? null;
            $filter_image_url = $filter_care_image_url($filter_image);

            // Get product link from ACF repeater sub-field.
            $filter_url = (string) ($filter['product_link'] ?? '');
            ?>

            <a
                href="<?php echo esc_url($filter_url); ?>"
                class="block"
            >
                <article class="flex flex-col rounded-[4px] border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-[#111a20] lg:p-10 lg:shadow-none">

                    <h3 class="mb-8 text-center text-[22px] font-normal text-gray-900 dark:text-white">
                        <?php echo esc_html($filter_name); ?>
                    </h3>

                    <div class="mb-10 flex h-[180px] w-full items-center justify-center">
                        <?php if ($filter_image_url) : ?>
                            <img
                                src="<?php echo esc_url($filter_image_url); ?>"
                                alt="<?php echo esc_attr(
                                    $filter_care_image_alt(
                                        $filter_image,
                                        $filter_name . ' Filter'
                                    )
                                ); ?>"
                                class="h-full object-contain"
                                loading="lazy"
                            >
                        <?php endif; ?>
                    </div>

                    <div class="flex w-full flex-col">

                        <div class="border-t border-gray-100 py-4 dark:border-gray-800">
                            <p class="mb-1.5 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400">
                                <?php esc_html_e('Filter Type', 'breathein'); ?>
                            </p>

                            <p class="text-[13px] font-light text-gray-900 dark:text-gray-300">
                                <?php echo esc_html(
                                    (string) ($filter['filter_type'] ?? '')
                                ); ?>
                            </p>
                        </div>

                        <div class="border-t border-gray-100 py-4 dark:border-gray-800">
                            <p class="mb-1.5 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400">
                                <?php esc_html_e('Typical Filter Life', 'breathein'); ?>
                            </p>

                            <p class="text-[13px] font-light text-gray-900 dark:text-gray-300">
                                <?php echo esc_html(
                                    (string) ($filter['filter_life'] ?? '')
                                ); ?>
                            </p>
                        </div>

                        <div class="border-t border-gray-100 pb-2 pt-4 dark:border-gray-800">
                            <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400">
                                <?php esc_html_e('Replacement Price', 'breathein'); ?>
                            </p>

                            <div class="inline-flex items-center justify-center rounded-[2px] border border-dashed border-[#8E989E] bg-gray-50 px-3 py-1 dark:border-gray-600 dark:bg-[#0D1418]">

                                <span class="text-[13px] font-medium text-gray-800 dark:text-gray-200">
                                    <?php echo esc_html(
                                        (string) ($filter['replacement_price'] ?? '')
                                    ); ?>
                                </span>

                            </div>
                        </div>

                    </div>

                </article>
            </a>

        <?php endforeach; ?>

    </div>
<?php endif; ?>

                <?php if ($filter_care_filter_note) : ?>
                    <div class="mb-10 mt-2">
                        <p class="text-[10px] font-medium tracking-wide text-[#156E8A] dark:text-[#2094B6]">
                            <?php echo esc_html($filter_care_filter_note); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <section class="mx-auto max-w-[1300px] bg-[#0D1418] px-6 py-10 md:px-10 lg:px-16 lg:py-24">
                <div class="flex flex-col items-start justify-between gap-10 md:flex-row md:items-center lg:gap-16">
                    <div class="max-w-2xl">
                        <h2 class="mb-4 text-3xl font-light leading-[1.25] tracking-tight text-white md:text-4xl lg:text-[42px]">
                            <?php echo esc_html($filter_care_subscription_heading_lead); ?><br class="hidden md:block">
                            <span class="font-medium text-[#156E8A]"><?php echo esc_html($filter_care_subscription_heading_highlight); ?></span>
                        </h2>
                        <p class="max-w-xl text-[14px] font-light leading-relaxed text-gray-400 md:text-[15px]">
                            <?php echo esc_html($filter_care_subscription_description); ?>
                        </p>
                    </div>

                    <a
                        href="<?php echo esc_url($filter_care_subscription_url); ?>"
                        <?php if ($filter_care_subscription_target === '_blank') : ?>target="_blank" rel="noopener noreferrer" <?php endif; ?>
                        class="flex w-full shrink-0 items-center justify-center gap-3 rounded-[2px] bg-white px-8 py-4 text-[11px] font-bold uppercase tracking-[0.2em] text-black transition-colors hover:bg-gray-100 md:w-auto lg:py-5">
                        <?php echo esc_html($filter_care_subscription_label); ?>
                        <span class="mb-[2px] text-lg leading-none" aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </section>
        </div>
    </section>

    <section class="flex w-full flex-col items-center justify-center bg-[#0B1115] px-6 py-10 text-center md:py-20">
        <h2 class="mb-6 text-4xl font-light tracking-tight text-white md:mb-8 md:text-5xl lg:text-[56px]">
            Genuine filters. <span class="text-[#156E8A]">Verified performance.</span>
        </h2>
        <p class="mx-auto mb-12 max-w-2xl text-[12px] font-light leading-relaxed text-gray-400 md:text-[15px]">
            Every Breathe In filter is tested to keep your purifier capturing 99.97% of<br class="hidden md:block"> PM2.5 — exactly as it did on day one.
        </p>
        <div class="flex w-full max-w-md flex-row items-center justify-center gap-6 sm:max-w-none sm:gap-10">
            <a
                href="<?php echo esc_url($filter_care_collection_url); ?>"
                class="flex w-full items-center justify-center gap-3 rounded-xl bg-white px-4 py-4 text-[12px] font-bold uppercase tracking-[0.2em] text-[#0B1115] transition-colors hover:bg-gray-200 sm:w-auto md:py-4 md:text-[13px]">
                <span><?php esc_html_e('Shop the Collection', 'breathein'); ?></span>
                <span aria-hidden="true">&rarr;</span>
            </a>
            <a
                href="<?php echo esc_url($filter_care_technology_url); ?>"
                class="mt-2 w-full text-center text-[12px] font-bold uppercase tracking-[0.2em] text-white transition-colors hover:text-[#156E8A] sm:mt-0 sm:w-auto md:text-[13px]">
                <?php esc_html_e('How Purification Works', 'breathein'); ?>
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?>