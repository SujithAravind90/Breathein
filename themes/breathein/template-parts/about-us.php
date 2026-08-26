<?php
/**
 * Template Name: About-us Page
 */

get_header();

$about_page_id = get_queried_object_id();

$about_field = static function (string $field_name, $default = '') use ($about_page_id) {
    if (function_exists('get_field')) {
        $value = get_field($field_name, $about_page_id);

        if ($value !== null && $value !== '' && $value !== false) {
            return $value;
        }
    }

    return $default;
};

$about_quote_text = (string) $about_field(
    'about_quote_text',
    'We started with a simple belief — the air inside your home deserves the same attention as the food you eat and the water you drink.'
);
$about_quote_attribution = (string) $about_field('about_quote_attribution', 'The Breathe In Team');

$about_technology_heading = (string) $about_field('about_technology_heading', 'BreathePure™ Technology');
$about_technology_description = (string) $about_field(
    'about_technology_description',
    'A multi-stage purification system that captures fine particles, reduces everyday odours and intelligently responds to changing air quality.'
);
$about_technology_stages = $about_field('about_technology_stages', []);

if (!is_array($about_technology_stages) || empty($about_technology_stages)) {
    $about_technology_stages = [
        [
            'stage_number'      => '01',
            'stage_icon'        => 'capture',
            'stage_title'       => 'Built for Real Homes',
            'stage_description' => 'Every product is designed with Indian homes and families in mind — real pollution, real comfort, real needs.',
        ],
        [
            'stage_number'      => '02',
            'stage_icon'        => 'filter',
            'stage_title'       => 'Clean Air Mission',
            'stage_description' => 'We believe clean indoor air should be accessible, not a luxury. Our mission is to make premium purification affordable.',
        ],
        [
            'stage_number'      => '03',
            'stage_icon'        => 'neutralise',
            'stage_title'       => 'Designed for Global Markets',
            'stage_description' => 'Engineered for Indian conditions, built to global standards. Breathe In products are designed for export markets too.',
        ],
        [
            'stage_number'      => '04',
            'stage_icon'        => 'monitor',
            'stage_title'       => 'Support & Service',
            'stage_description' => 'From purchase to long-term use, our team is available to guide, support, and service every Breathe In product.',
        ],
    ];
}

$about_stage_icons = [
    'capture' => '<svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 14H36M12 22H32M16 30H28" stroke="#141414" stroke-width="1.4" stroke-linecap="round" /></svg>',
    'filter' => '<svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M34 10H10C8.89543 10 8 10.8954 8 12V13C8 14.1046 8.89543 15 10 15H34C35.1046 15 36 14.1046 36 13V12C36 10.8954 35.1046 10 34 10Z" stroke="#141414" stroke-width="1.4" /><path d="M34 19H10C8.89543 19 8 19.8954 8 21V22C8 23.1046 8.89543 24 10 24H34C35.1046 24 36 24 36 22V21C36 19.8954 35.1046 19 34 19Z" stroke="#141414" stroke-width="1.4" /><path d="M34 28H10C8.89543 28 8 28.8954 8 30V31C8 32.1046 8.89543 33 10 33H34C35.1046 33 36 33 36 31V30C36 28.8954 35.1046 28 34 28Z" stroke="#141414" stroke-width="1.4" /></svg>',
    'neutralise' => '<svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 8V16M16 11L20 15M28 11L24 15M12 22H8M22 36V28M32 22H36M16 33L20 29M28 33L24 29" stroke="#141414" stroke-width="1.4" stroke-linecap="round" /><path d="M22 27C24.7614 27 27 24.7614 27 22C27 19.2386 24.7614 17 22 17C19.2386 17 17 19.2386 17 22C17 24.7614 19.2386 27 22 27Z" stroke="#141414" stroke-width="1.4" /></svg>',
    'monitor' => '<svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 34C28.6274 34 34 28.6274 34 22C34 15.3726 28.6274 10 22 10C15.3726 10 10 15.3726 10 22C10 28.6274 15.3726 34 22 34Z" stroke="#141414" stroke-width="1.4" /><path d="M22 14V22L27 25" stroke="#141414" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" /></svg>',
];
?>

<main class="bg-[#FAFCFD]">
    <!-- ========================================== -->
    <!-- 1. HERO SECTION (REUSED VIA TEMPLATE PART) -->
    <!-- ========================================== -->
    <?php get_template_part('template-parts/hero-section'); ?>

    <!-- ========================================== -->
    <!-- ABOUT US - QUOTE SECTION                   -->
    <!-- ========================================== -->
    <section class="max-w-[1320px] mx-auto bg-white dark:bg-[#050505] py-10 md:py-20 lg:py-32 px-6 md:px-10 lg:px-16 transition-colors duration-300">
        <div>
            <blockquote class="max-w-[850px]">
                <p class="text-[20px] md:text-[25px] lg:text-[33px] font-light text-gray-900 dark:text-white leading-[1.3] tracking-tight mb-6 md:mb-8">
                    &ldquo;<?php echo esc_html($about_quote_text); ?>&rdquo;
                </p>

                <footer class="text-[14px] md:text-[15px] text-gray-500 dark:text-gray-400 font-light tracking-wide">
                    &mdash; <?php echo esc_html($about_quote_attribution); ?>
                </footer>
            </blockquote>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- TECHNOLOGY & FILTRATION                    -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24">
        <div class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <h2 class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                <?php echo esc_html($about_technology_heading); ?>
            </h2>

            <p class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
                <?php echo nl2br(esc_html($about_technology_description)); ?>
            </p>
        </div>

        <div class="max-w-6xl mx-auto bg-transparent md:bg-white border-0 md:border md:border-gray-100 md:shadow-[0_4px_20px_rgb(0,0,0,0.02)] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y divide-gray-200/80 md:divide-y-0 md:divide-x md:divide-gray-100 mb-12 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
            <?php foreach ($about_technology_stages as $stage_index => $stage) :
                $stage_number = !empty($stage['stage_number'])
                    ? (string) $stage['stage_number']
                    : sprintf('%02d', $stage_index + 1);
                $stage_icon = !empty($stage['stage_icon']) ? (string) $stage['stage_icon'] : 'capture';
                $stage_title = !empty($stage['stage_title']) ? (string) $stage['stage_title'] : '';
                $stage_description = !empty($stage['stage_description']) ? (string) $stage['stage_description'] : '';
                $stage_card_classes = $stage_index < 2
                    ? 'py-6 md:p-10 flex flex-col h-full lg:border-b-0 border-gray-100 md:border-b'
                    : 'py-6 md:p-10 flex flex-col h-full lg:border-t-0 lg:border-b-0 border-gray-100 border-t';
            ?>
                <div class="<?php echo esc_attr($stage_card_classes); ?>">
                    <div class="flex items-start md:block mb-1.5 md:mb-4">
                        <span class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">
                            <?php echo esc_html($stage_number); ?>
                        </span>

                        <?php echo $about_stage_icons[$stage_icon] ?? $about_stage_icons['capture']; ?>

                        <h3 class="text-[17px] font-normal text-gray-900">
                            <?php echo esc_html($stage_title); ?>
                        </h3>
                    </div>

                    <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                        <?php echo nl2br(esc_html($stage_description)); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php get_template_part('template-parts/cta-section'); ?>
</main>

<?php get_footer(); ?>
