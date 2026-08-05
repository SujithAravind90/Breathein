<?php
/*
Template Name: home-page
*/
get_header();
?>

<!-- Dynamic Target Container for upcoming Homepage Sections -->
<main class="homepage-wrapper">
    <!-- ========================================== -->
    <!-- HERO SECTION                               -->
    <!-- ========================================== -->
    <section class="w-full relative bg-white border-b border-gray-100">
        <div class="swiper heroSwiper w-full min-h-[100dvh] lg:min-h-[600px]">
            <div class="swiper-wrapper w-full h-full">
                <div class="swiper-slide w-full h-full">
                    <div class="grid grid-cols-1 lg:grid-cols-2 w-full h-full">
                        <!-- ============================================== -->
                        <!-- 1. VISUAL COLUMN (Top Mobile, Right Desktop)   -->
                        <!-- ============================================== -->

                        <div
                            class="relative w-full min-h-[350px] lg:h-full lg:min-h-full order-1 lg:order-2 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <?php
                            $banner_image = get_field('banner_image');
                            if ($banner_image) {
                            ?>
                                <!-- Background Image (Bedroom) -->
                                <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>"
                                    class="absolute inset-0 w-full h-full object-cover object-center slide-product opacity-0 transition-all duration-1000 ease-out delay-200" />
                            <?php } ?>
                            <!-- Gradient Overlay 1 -->
                            <div class="absolute inset-0 z-10 pointer-events-none hidden lg:block" style="
                      background: linear-gradient(
                        180deg,
                        rgba(0, 0, 0, 0) 0%,
                        rgba(0, 0, 0, 0) 3.83%,
                        rgba(255, 255, 255, 0.28) 3.83%,
                        rgba(255, 255, 255, 0.28) 4%
                      );
                    "></div>

                            <!-- Gradient Overlay 2 -->
                            <div class="absolute inset-0 z-10 pointer-events-none hidden lg:block" style="
                      background: linear-gradient(
                        164.38deg,
                        rgba(168, 218, 242, 0.32) 0%,
                        rgba(21, 110, 138, 0.14) 45%,
                        rgba(247, 249, 250, 0.5) 100%
                      );
                    "></div>

                            <!-- Desktop Product Overlay (Hidden on Mobile) -->
                            <?php
                            $air_pro_image = get_field('air_pro_image');
                            if ($air_pro_image) {
                            ?>
                                <img src="<?php echo $air_pro_image['url']; ?>" alt="<?php echo $air_pro_image['alt']; ?>"
                                    class="relative z-20 ml-[50%] md:ml-[0] mt-[40%] md:mt-[32%] h-[100px] md:h-[60%] max-h-[700px] w-auto object-contain drop-shadow-2xl slide-product opacity-0 translate-y-12 transition-all duration-1000 ease-out delay-500" />
                            <?php } ?>
                            <!-- Floating AQI Badge -->
                            <div
                                class="absolute bottom-6 left-6 lg:bottom-28 lg:left-12 xl:left-28 bg-white/95 backdrop-blur-md px-4 py-3 shadow-[0_8px_30px_rgb(0,0,0,0.08)] flex items-center gap-3 z-30 slide-product opacity-0 translate-y-4 transition-all duration-700 delay-700">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#39B54A]"></span>
                                <div class="flex flex-col text-left">
                                    <span
                                        class="text-[7px] uppercase tracking-[0.15em] text-gray-400 font-bold leading-none mb-0.5">Indoor
                                        Air Quality</span>
                                    <span
                                        class="text-sm font-medium text-gray-900 leading-none"><?php echo the_field('indoor_air_quality'); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- 2. TEXT COLUMN (Bottom Mobile, Left Desktop)   -->
                        <!-- ============================================== -->
                        <div
                            class="bg-white text-gray-900 flex flex-col justify-center px-6 py-10 lg:px-16 lg:pl-[10%] lg:pr-16 relative order-2 lg:order-1">
                            <div
                                class="slide-content w-full opacity-0 translate-y-8 transition-all duration-700 ease-out delay-300 max-w-xl mx-auto lg:mx-0">

                                <!-- Responsive Eyebrow -->
                                <div class="flex items-center gap-3 lg:gap-4 mb-4 lg:mb-6">
                                    <div class="hidden lg:block w-8 h-[1px] bg-gray-300"></div>
                                    <span class="text-[11px] tracking-[0.2em] uppercase text-[#156E8A] font-bold">
                                        <span class="lg:hidden">Breathe In &mdash; </span>
                                        <?php echo the_field('banner_top_text'); ?>
                                    </span>
                                </div>

                                <!-- Responsive Headline -->
                                <h1
                                    class="text-[32px] sm:text-4xl lg:text-6xl xl:text-7xl font-light tracking-tight leading-[1.15] lg:leading-[1.1] mb-4 lg:mb-6">
                                    <?php echo the_field('banner_main_text'); ?>
                                </h1>

                                <!-- Subtext -->
                                <p
                                    class="text-gray-500 text-[15px] lg:text-[15px] leading-relaxed mb-8 lg:mb-10 font-light lg:pr-10">
                                    <?php echo the_field('banner_desc_text'); ?>
                                </p>

                                <!-- Mobile-Only Product Box (Hidden on Desktop) -->
                                <div
                                    class="hidden w-full bg-[#F2F6F8] rounded-2xl py-10 flex justify-center items-center mb-8">
                                    <img src="./assets/images/air-pro.png" alt="Air Pro"
                                        class="h-[200px] object-contain drop-shadow-md" />
                                </div>

                                <!-- Responsive Action Buttons -->
                                <div
                                    class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3 lg:gap-8 w-full">
                                    <!-- Primary Button -->
                                    <?php
                                    $explore_collections_cta = get_field('explore_collections_cta');
                                    if (
                                        is_array($explore_collections_cta) &&
                                        !empty($explore_collections_cta['url'])
                                    ):
                                        $cta_url = $explore_collections_cta['url'];
                                        $cta_title = $explore_collections_cta['title'] ?? 'Explore Collections';
                                        $cta_target = $explore_collections_cta['target'] ?? '_self';
                                    ?>
                                        <a href="<?php echo esc_url($cta_url); ?>"
                                            target="<?php echo esc_attr($cta_target); ?>"
                                            class="bg-[#111111] text-white text-[12px] tracking-[0.15em] font-bold uppercase px-6 lg:px-8 py-5 lg:py-4 hover:bg-[#156E8A] transition-colors flex items-center justify-between lg:justify-center gap-3 rounded-sm w-full lg:w-auto">
                                            <span><?php echo esc_html($cta_title); ?></span>
                                            <span aria-hidden="true">&rarr;</span>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Secondary Button -->
                                    <?php
                                    $banner_find_my_purifier_cta = get_field(
                                        'banner_find_my_purifier_cta'
                                    );
                                    if (
                                        is_array($banner_find_my_purifier_cta) &&
                                        !empty($banner_find_my_purifier_cta['url'])
                                    ):
                                        $cta_url = $banner_find_my_purifier_cta['url'];
                                        $cta_title = $banner_find_my_purifier_cta['title']
                                            ?? 'Find My Purifier';
                                        $cta_target = $banner_find_my_purifier_cta['target']
                                            ?? '_self';
                                    ?>
                                        <a href="<?php echo esc_url($cta_url); ?>"
                                            target="<?php echo esc_attr($cta_target); ?>"
                                            class="bg-[#FAFCFD] border border-gray-100 lg:bg-transparent lg:border-0 lg:border-b lg:border-gray-900 text-gray-900 text-[12px] tracking-[0.15em] font-bold uppercase px-6 lg:px-0 py-5 lg:py-1 hover:text-[#156E8A] hover:border-[#156E8A] transition-colors flex items-center justify-between lg:justify-center gap-3 rounded-sm lg:rounded-none w-full lg:w-auto">
                                            <span>
                                                <?php echo esc_html($cta_title); ?>
                                            </span>
                                            <span class="lg:hidden text-gray-400 font-light" aria-hidden="true">
                                                &rarr;
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Mobile Scroll Indicator -->
                                <div class="flex lg:hidden items-center gap-4 opacity-40 w-full mt-6">
                                    <div class="w-8 h-[1px] bg-gray-400"></div>
                                    <span class="text-[8px] tracking-[0.2em] uppercase text-gray-500 font-bold">
                                        Scroll to explore</span>
                                </div>
                            </div>

                            <!-- Desktop Scroll Indicator -->
                            <div
                                class="hidden lg:flex absolute bottom-8 left-[10%] items-center gap-4 opacity-40 slide-content opacity-0 transition-all duration-700 delay-500">
                                <div class="w-8 h-[1px] bg-gray-400"></div>
                                <span class="text-[8px] tracking-[0.2em] uppercase text-gray-500 font-bold">Scroll to
                                    explore</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination hidden lg:block"></div>
        </div>
    </section>

    <!-- home page second slider -->
    <div class="w-full bg-tickerDark text-gray-300 py-4 border-t border-b border-gray-800 overflow-hidden relative">
        <div class="flex whitespace-nowrap animate-marquee">
            <div class="flex items-center gap-12 px-6">
                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">99.97% PM2.5 Capture</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">HEPA H13 Filtration</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">Japanese Technology</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">Internationally Certified</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">Starting at ₹9,999</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>
            </div>

            <div class="flex items-center gap-12 px-6">
                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">99.97% PM2.5 Capture</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">HEPA H13 Filtration</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">Japanese Technology</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">Internationally Certified</span>
                </div>
                <div class="w-[1px] h-4 bg-gray-700"></div>

                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-brandTeal"></span>
                    <span class="text-[12px] tracking-widest font-bold uppercase">Starting at ₹9,999</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================== -->
    <!-- SECTION: THE INVISIBLE PROBLEM & PARTNERS  -->
    <!-- ========================================== -->
    <section
        class="w-full bg-[#030608] text-white py-10 md:py-20 px-6 md:px-16 lg:px-24 relative overflow-hidden flex flex-col items-center">
        <!-- Background Floating Tags -->
        <div class="absolute inset-0 pointer-events-none opacity-20 select-none overflow-hidden">
            <span class="float-slow absolute top-[20%] left-[15%] text-[11px] tracking-widest text-gray-500">DUST</span>
            <span class="float-slow absolute top-[30%] right-[20%] text-[11px] tracking-widest text-gray-500"
                style="animation-delay: -2s">PM 10</span>
            <span class="float-slow absolute top-[45%] left-[25%] text-[11px] tracking-widest text-gray-500"
                style="animation-delay: -4s">VOCS</span>
            <span class="float-slow absolute bottom-[35%] right-[25%] text-[11px] tracking-widest text-gray-500"
                style="animation-delay: -1s">NO2</span>
            <span class="float-slow absolute bottom-[25%] left-[30%] text-[11px] tracking-widest text-gray-500"
                style="animation-delay: -3s">PM 2.5</span>
            <span class="float-slow absolute bottom-[20%] right-[15%] text-[11px] tracking-widest text-gray-500"
                style="animation-delay: -5s">DANDER</span>
            <span class="float-slow absolute bottom-[40%] left-[45%] text-[11px] tracking-widest text-gray-500"
                style="animation-delay: -2.5s">POLLEN</span>
        </div>

        <div class="max-w-5xl mx-auto text-center relative z-10 w-full">
            <!-- Eyebrow -->
            <div class="mb-4 scroll-reveal opacity-0 translate-y-4 transition-all duration-700 ease-out">
                <span class="text-[11px] md:text-[12px] tracking-[0.3em] uppercase text-brandTeal font-bold">
                    <?php echo the_field('problem_header_1'); ?></span>
            </div>

            <!-- Headline -->
            <h2
                class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light tracking-tight mb-6 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-100 leading-[1.2]">
                <?php echo the_field('problem_header_2'); ?>
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-400 text-xs md:text-[15px] font-light leading-relaxed max-w-2xl mx-auto mb-12 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-200">
                <?php echo the_field('problem_desc'); ?>
            </p>

            <!-- Pollutants Tags List -->
            <?php if (have_rows('invisible_problem_repeater')) : ?>
                <div
                    class="flex flex-wrap justify-center gap-2.5 md:gap-4 max-w-3xl mx-auto mb-16 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-300">
                    <?php while (have_rows('invisible_problem_repeater')) : the_row(); ?>

                        <?php $title = get_sub_field('title'); ?>

                        <?php if ($title) : ?>
                            <div
                                class="border border-gray-800 px-4 py-2 text-[11px] md:text-[12px] tracking-widest uppercase text-gray-400 hover:text-white hover:border-brandTeal transition-colors cursor-default">
                                <?php echo esc_html($title); ?>
                            </div>
                        <?php endif; ?>

                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <!-- Divider Line -->
            <div
                class="w-full h-[1px] bg-gradient-to-r from-transparent via-gray-800 to-transparent mb-16 scroll-reveal opacity-0 transition-all duration-700 delay-500">
            </div>

            <!-- Stats Grid: 2x2 on mobile matching design_392ba0, 3-column or row layout on desktop -->
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 text-left w-full mb-5 md:mb-20">
                <!-- Card 1 -->
                <div
                    class="bg-[#080C0F] border border-gray-800/80 p-6 md:p-8 flex flex-col justify-between scroll-reveal opacity-0 transition-all duration-700 ease-out delay-400 min-h-[160px] md:min-h-[200px]">
                    <span class="text-brandTeal text-3xl sm:text-4xl md:text-5xl font-light tracking-tight">14/20</span>
                    <span
                        class="text-gray-400 text-[11px] md:text-[13px] tracking-[0.15em] uppercase font-light leading-relaxed mt-4">
                        Of the world's most polluted cities are in India
                    </span>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-[#080C0F] border border-gray-800/80 p-6 md:p-8 flex flex-col justify-between scroll-reveal opacity-0 transition-all duration-700 ease-out delay-500 min-h-[160px] md:min-h-[200px]">
                    <span
                        class="text-brandTeal text-3xl sm:text-4xl md:text-5xl font-light tracking-tight">2&ndash;5&times;</span>
                    <span
                        class="text-gray-400 text-[11px] md:text-[13px] tracking-[0.15em] uppercase font-light leading-relaxed mt-4">
                        More polluted indoors than outside
                    </span>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-[#080C0F] border border-gray-800/80 p-6 md:p-8 flex flex-col justify-between col-span-2 lg:col-span-1 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-600 min-h-[160px] md:min-h-[200px]">
                    <span class="text-brandTeal text-3xl sm:text-4xl md:text-5xl font-light tracking-tight">5&ndash;7
                        yrs</span>
                    <span
                        class="text-gray-400 text-[11px] md:text-[13px] tracking-[0.15em] uppercase font-light leading-relaxed mt-4">
                        Of life lost to sustained air-pollution exposure
                    </span>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION: OUR PARTNERS                      -->
    <!-- ========================================== -->
    <!-- Removed borders on mobile (md:border-t md:border-b), tightened padding -->
    <section class="w-full bg-[#030608] md:bg-tickerDark md:border-t md:border-b border-gray-800/60 py-4 md:py-8">
        <div
            class="max-w-6xl mx-auto px-6 overflow-x-auto no-scrollbar scroll-reveal opacity-0 transition-all duration-700 ease-out">
            <!-- Single Unified Container -->
            <!-- flex-wrap forces the 100% width text to push the logos to the next line on mobile -->
            <div
                class="flex flex-wrap md:flex-nowrap items-center justify-between md:justify-center gap-y-6 md:gap-8 min-w-full md:min-w-max mx-auto py-2">
                <!-- Static heading -->
                <span
                    class="w-full md:w-auto text-left md:text-center text-gray-500 md:text-white text-[12px] md:text-xl lg:text-2xl uppercase md:normal-case tracking-[0.2em] md:tracking-wide font-bold md:font-light shrink-0 leading-none">
                    Our Partners
                </span>

                <?php if (have_rows('other_partners')) : ?>
                    <?php while (have_rows('other_partners')) : the_row(); ?>
                        <?php $partner_image = get_sub_field('brand_image_png'); ?>
                        <?php if ($partner_image) : ?>
                            <div
                                class="hidden md:block w-[1px] h-6 bg-gray-700 shrink-0"></div>
                            <img
                                src="<?php echo esc_url($partner_image['url']); ?>"
                                alt="<?php echo esc_attr($partner_image['alt'] ?? 'Partner logo'); ?>"
                                class="h-5 md:h-8 w-auto opacity-80 md:opacity-70 hover:opacity-100 transition-opacity duration-300 shrink-0 object-contain">

                        <?php endif; ?>

                    <?php endwhile; ?>

                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: FIND YOUR MATCH                 -->
    <!-- ========================================== -->
    <section class="w-full bg-white relative py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
        <div
            class="absolute top-0 left-0 w-[30%] h-[30%] bg-brandTeal/10 rounded-full blur-[120px] -translate-x-1/3 -translate-y-1/3 pointer-events-none">
        </div>

        <div class="max-w-6xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-24 mb-16">
                <div
                    class="flex flex-col justify-center scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="hidden md:block w-8 h-[1px] bg-brandTeal"></div>
                        <span
                            class="text-[11px] tracking-[0.2em] uppercase text-brandTeal md:text-gray-500 font-bold">Find
                            Your Match in 10 Seconds</span>
                    </div>

                    <h2 class="text-[26px] md:text-5xl font-light tracking-tight leading-[1.1] mb-6 text-gray-900">
                        How big is the room you want to
                        <span class="text-gray-900 md:text-brandTeal font-medium">protect?</span>
                    </h2>

                    <p class="text-gray-500 text-sm md:text-base leading-relaxed mb-12 font-light max-w-md">
                        No forms. No guesswork. Tell us the space and we'll match you to
                        the exact purifier built for it — instantly.
                    </p>

                    <div class="w-full max-w-md p-3 border">
                        <div class="flex justify-between items-end mb-4">
                            <span class="text-xs font-bold uppercase tracking-widest text-gray-800">Select By
                                Area</span>
                        </div>

                        <div class="flex justify-between items-end mb-2">
                            <span class="text-[12px] uppercase tracking-widest text-gray-400 font-bold">Room Area</span>
                            <span class="text-2xl font-light text-gray-900"><span id="roomAreaValue">600</span>
                                <span class="text-sm text-gray-400">sq ft</span></span>
                        </div>

                        <div class="relative w-full h-8 flex items-center">
                            <input type="range" id="roomAreaSlider" min="100" max="1500" step="50" value="600"
                                class="w-full custom-slider outline-none" />
                        </div>
                    </div>
                </div>

                <div class="scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-200">
                    <div
                        class="bg-[#F7F9FA] border border-gray-200 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col h-full">
                        <div class="p-6 md:p-8 border-b border-#DCE4E7 bg-[#F7F9FA] z-10 relative">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-2 h-2 rounded-full bg-[#75C282]"></span>
                                <span class="text-[12px] uppercase tracking-[0.15em] font-bold text-[#75C282]">Your
                                    Match</span>
                            </div>
                            <h3 class="text-4xl font-light text-gray-900 mb-2">
                                Air Pro 2
                            </h3>
                            <p class="text-sm text-gray-500 font-light">
                                7-in-1 filtration with built-in humidification for large
                                living spaces.
                            </p>
                        </div>

                        <div class="relative w-full h-[254px] flex items-center justify-center overflow-hidden" style="
                    background: radial-gradient(
                      70.71% 84.85% at 50% 60%,
                      rgba(168, 218, 242, 0.28) 0%,
                      rgba(168, 218, 242, 0) 70%
                    );
                  ">
                            <div
                                class="absolute w-[225px] h-[225px] rounded-full border border-dashed border-[#156E8A]/30">
                            </div>

                            <img src="./assets/images/air-pro.png" alt="Air Pro 2"
                                class="h-[200px] w-[130px] object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500 relative z-10" />
                        </div>

                        <div
                            class="grid grid-cols-3 divide-x divide-gray-200 border-t border-b border-gray-200 bg-[#F7F9FA]">
                            <div class="flex flex-col items-center justify-center text-center p-3 md:p-6 h-full">
                                <span class="text-[14px] font-medium text-gray-900 mb-2">860 sq ft</span>
                                <span
                                    class="text-[11px] uppercase tracking-[0.15em] text-[#A3A3A3] font-bold">Coverage</span>
                            </div>
                            <div class="flex flex-col items-center justify-center text-center p-3 md:p-6 h-full">
                                <span class="text-[14px] font-medium text-gray-900 mb-2">Large Living</span>
                                <span class="text-[11px] uppercase tracking-[0.15em] text-[#A3A3A3] font-bold">Ideal
                                    For</span>
                            </div>
                            <div class="flex flex-col items-center justify-center text-center p-3 md:p-6 h-full">
                                <span class="text-[14px] font-medium text-gray-900 mb-2">HEPA H13</span>
                                <span
                                    class="text-[11px] uppercase tracking-[0.15em] text-[#A3A3A3] font-bold">Filtration</span>
                            </div>
                        </div>

                        <div class="p-6 md:p-8 flex items-center justify-between mt-auto bg-white">
                            <div class="flex flex-col">
                                <span class="text-[12px] text-gray-400 font-light mb-1">Starting from</span>
                                <span class="text-2xl font-medium text-gray-900 tracking-tight">₹24,999</span>
                            </div>
                            <a href="#"
                                class="bg-[#111111] text-white text-[12px] tracking-[0.15em] font-bold uppercase px-6 py-4 hover:bg-brandTeal transition-colors flex items-center gap-3 rounded-sm shadow-md">
                                View Air Pro 2 <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="w-full bg-[#EEF2F5] border border-gray-200/60 rounded-xl p-8 md:p-10 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-400">
                <div class="mb-6">
                    <h4 class="text-base font-medium text-gray-900 mb-1">
                        Lock in your match — and get a free air check.
                    </h4>
                    <p class="text-xs text-gray-500 font-light">
                        We'll send your recommendation and arrange a complimentary
                        in-home air-quality assessment. No obligation.
                    </p>
                </div>

                <form class="flex flex-col md:flex-row gap-4 w-full items-stretch">
                    <input type="email" placeholder="Email address" required
                        class="flex-1 px-5 py-3.5 text-xs bg-white border border-gray-200 rounded-sm focus:outline-none focus:border-brandTeal focus:ring-1 focus:ring-brandTeal transition-all placeholder:text-gray-400 shadow-sm" />

                    <input type="tel" placeholder="Phone (+91)" required
                        class="flex-1 px-5 py-3.5 text-xs bg-white border border-gray-200 rounded-sm focus:outline-none focus:border-brandTeal focus:ring-1 focus:ring-brandTeal transition-all placeholder:text-gray-400 shadow-sm" />

                    <button type="submit"
                        class="bg-[#111111] text-white text-[12px] tracking-widest font-bold uppercase px-8 py-3.5 hover:bg-brandTeal transition-colors rounded-sm shrink-0 shadow-sm">
                        Send My Match
                    </button>
                </form>
            </div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION 6: THE COLLECTIONS                 -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24">
        <div class="max-w-7xl mx-auto">
            <div
                class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-10 md:mb-24 gap-6 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.2em] text-brandTeal font-bold mb-6 block">The
                        Collection</span>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-gray-900 leading-[1.1]">
                        Curated for <br class="hidden md:block" />
                        every space.
                    </h2>
                </div>

                <p class="text-gray-500 text-sm font-light text-left md:text-right max-w-sm leading-relaxed lg:pb-2">
                    Four precisely crafted models. Each designed for a specific space
                    and purpose - chosen not for a
                    <br />
                    shelf, but for a home.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 items-start">
                <div
                    class="bg-white flex flex-col shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100/50 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100 group">
                    <div class="relative w-full aspect-[4/3] md:aspect-[4/5] bg-gray-100 overflow-hidden">
                        <img src="./assets/images/air-pro.jpg" alt="Air Pro in Bedroom"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[8.5px] font-bold uppercase tracking-widest text-brandTeal">
                            For Bedrooms
                        </div>
                    </div>

                    <div class="p-6 md:p-8 flex flex-col flex-grow">
                        <span class="text-[11px] uppercase tracking-widest text-brandTeal font-bold mb-3">I &mdash; Air
                            Pro</span>
                        <h3 class="text-2xl font-light text-gray-900 mb-3">Air Pro</h3>
                        <p class="text-[15px] text-gray-500 font-light mb-8 leading-relaxed">
                            Compact double-sided suction for bedrooms & personal spaces.
                        </p>

                        <div class="mt-auto">
                            <div class="w-full h-[1px] bg-[#DCE4E7] mb-5"></div>

                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 mb-0.5">
                                        430 sq ft
                                    </div>
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold">
                                        Coverage Area
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold mb-0.5">
                                        Starting From
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₹9,999
                                    </div>
                                </div>
                            </div>

                            <a href="#"
                                class="flex lg:inline-flex items-center justify-between lg:justify-start gap-3 lg:gap-1.5 w-full lg:w-auto px-6 py-5 lg:p-0 bg-[#111111] lg:bg-transparent text-white lg:text-brandTeal text-[12px] lg:text-[11px] tracking-[0.15em] lg:tracking-widest font-bold uppercase rounded-sm lg:rounded-none hover:bg-[#156E8A] lg:hover:bg-transparent lg:hover:text-gray-900 transition-colors">
                                <span>Explore<span class="lg:hidden"> Collection</span></span>
                                <span class="lg:text-[13px]">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white flex flex-col shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100/50 lg:mt-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200 group">
                    <div class="relative w-full aspect-[4/3] md:aspect-[4/5] bg-gray-100 overflow-hidden">
                        <img src="./assets/images/air-pro-1.jpg" alt="Air Pro 1 in Living Room"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute top-4 left-4 bg-brandTeal px-3 py-1.5 text-[8.5px] font-bold uppercase tracking-widest text-white">
                            Most Chosen
                        </div>
                    </div>

                    <div class="p-6 md:p-8 flex flex-col flex-grow">
                        <span class="text-[11px] uppercase tracking-widest text-brandTeal font-bold mb-3">II &mdash; Air
                            Pro 1</span>
                        <h3 class="text-2xl font-light text-gray-900 mb-3">
                            Air Pro 1
                        </h3>
                        <p class="text-[15px] text-gray-500 font-light mb-8 leading-relaxed">
                            AI-Intelligent 4-stage purification for medium to large rooms.
                        </p>

                        <div class="mt-auto">
                            <div class="w-full h-[1px] bg-[#DCE4E7] mb-5"></div>

                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 mb-0.5">
                                        590 sq ft
                                    </div>
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold">
                                        Coverage Area
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold mb-0.5">
                                        Starting From
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₹19,999
                                    </div>
                                </div>
                            </div>

                            <a href="#"
                                class="flex lg:inline-flex items-center justify-between lg:justify-start gap-3 lg:gap-1.5 w-full lg:w-auto px-6 py-5 lg:p-0 bg-[#111111] lg:bg-transparent text-white lg:text-brandTeal text-[12px] lg:text-[11px] tracking-[0.15em] lg:tracking-widest font-bold uppercase rounded-sm lg:rounded-none hover:bg-[#156E8A] lg:hover:bg-transparent lg:hover:text-gray-900 transition-colors">
                                <span>Explore<span class="lg:hidden"> Collection</span></span>
                                <span class="lg:text-[13px]">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white flex flex-col shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100/50 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-300 group">
                    <div class="relative w-full aspect-[4/3] md:aspect-[4/5] bg-gray-100 overflow-hidden">
                        <img src="./assets/images/air-pro-2.jpg" alt="Air Pro 2 in Open Space"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[8.5px] font-bold uppercase tracking-widest text-brandTeal">
                            Open Spaces
                        </div>
                    </div>

                    <div class="p-6 md:p-8 flex flex-col flex-grow">
                        <span class="text-[11px] uppercase tracking-widest text-brandTeal font-bold mb-3">III &mdash;
                            Air Pro 2</span>
                        <h3 class="text-2xl font-light text-gray-900 mb-3">
                            Air Pro 2
                        </h3>
                        <p class="text-[15px] text-gray-500 font-light mb-8 leading-relaxed">
                            7-in-1 filtration with built-in humidification for large
                            spaces.
                        </p>

                        <div class="mt-auto">
                            <div class="w-full h-[1px] bg-[#DCE4E7] mb-5"></div>

                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 mb-0.5">
                                        860 sq ft
                                    </div>
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold">
                                        Coverage Area
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold mb-0.5">
                                        Starting From
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₹24,999
                                    </div>
                                </div>
                            </div>

                            <a href="#"
                                class="flex lg:inline-flex items-center justify-between lg:justify-start gap-3 lg:gap-1.5 w-full lg:w-auto px-6 py-5 lg:p-0 bg-[#111111] lg:bg-transparent text-white lg:text-brandTeal text-[12px] lg:text-[11px] tracking-[0.15em] lg:tracking-widest font-bold uppercase rounded-sm lg:rounded-none hover:bg-[#156E8A] lg:hover:bg-transparent lg:hover:text-gray-900 transition-colors">
                                <span>Explore<span class="lg:hidden"> Collection</span></span>
                                <span class="lg:text-[13px]">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white flex flex-col shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100/50 lg:mt-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-400 group">
                    <div class="relative w-full aspect-[4/3] md:aspect-[4/5] bg-gray-100 overflow-hidden">
                        <img src="./assets/images/air-pro-max.jpg" alt="Air Pro Max on Entire Floor"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[8.5px] font-bold uppercase tracking-widest text-brandTeal">
                            Entire Floors
                        </div>
                        <div
                            class="absolute bottom-0 right-0 bg-[#0D1418] px-4 py-2.5 text-[8px] font-bold uppercase tracking-widest text-white">
                            Coming Soon
                        </div>
                    </div>

                    <div class="p-6 md:p-8 flex flex-col flex-grow">
                        <span class="text-[11px] uppercase tracking-widest text-brandTeal font-bold mb-3">IV &mdash; Air
                            Pro Max</span>
                        <h3 class="text-2xl font-light text-gray-900 mb-3">
                            Air Pro Max
                        </h3>
                        <p class="text-[15px] text-gray-500 font-light mb-8 leading-relaxed">
                            Industrial 6-fold purification for large homes & commercial
                            use.
                        </p>

                        <div class="mt-auto">
                            <div class="w-full h-[1px] bg-[#DCE4E7] mb-5"></div>

                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 mb-0.5">
                                        1,600 sq ft
                                    </div>
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold">
                                        Coverage Area
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[8px] uppercase tracking-widest text-gray-400 font-bold mb-0.5">
                                        Starting From
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₹34,999
                                    </div>
                                </div>
                            </div>

                            <a href="#"
                                class="flex lg:inline-flex items-center justify-between lg:justify-start gap-3 lg:gap-1.5 w-full lg:w-auto px-6 py-5 lg:p-0 bg-[#111111] lg:bg-transparent text-white lg:text-brandTeal text-[12px] lg:text-[11px] tracking-[0.15em] lg:tracking-widest font-bold uppercase rounded-sm lg:rounded-none hover:bg-[#156E8A] lg:hover:bg-transparent lg:hover:text-gray-900 transition-colors">
                                <span>Explore<span class="lg:hidden"> Collection</span></span>
                                <span class="lg:text-[13px]">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 7: BENEFITS GRID                   -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] md:bg-white py-16 md:py-32 px-6 md:px-16 lg:px-24 overflow-hidden">
        <!-- Header Section -->
        <div
            class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <!-- Eyebrow -->
            <span class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                Why Clean Air Matters
            </span>

            <!-- Headline -->
            <h2
                class="text-[32px] md:text-4xl lg:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                The life you deserve starts with <br class="hidden md:block" />
                the air you breathe.
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
                Clean air is not a feature. It is a foundation for everything that
                matters &mdash; sleep, health, focus, and family.
            </p>
        </div>

        <!-- ========================================================= -->
        <!-- UNIFIED SWIPER / GRID STRUCTURE                           -->
        <!-- ========================================================= -->
        <div
            class="swiper benefitsSwiper max-w-[1400px] mx-auto pb-12 md:pb-0 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100 relative overflow-visible md:overflow-hidden">
            <!-- Wrapper: Flex for Swiper on Mobile, Grid on Desktop -->
            <div class="swiper-wrapper md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-1.5 items-stretch">
                <!-- CARD 1: Deeper Sleep -->
                <div class="swiper-slide h-auto">
                    <div
                        class="relative w-full h-full aspect-[4/5] lg:aspect-[3/4] group overflow-hidden rounded-md md:rounded-none">
                        <img src="./assets/images/benefit-sleep.png" alt="Deeper Sleep"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#090D10] via-[#090D10]/50 to-transparent opacity-90">
                        </div>

                        <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end text-left">
                            <div class="text-brandTeal mb-4">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_181_5271)">
                                        <path
                                            d="M14 4C9 4 6 8 6 12C6 17.5 14 28 14 28C14 28 22 17.5 22 12C22 8 19 4 14 4Z"
                                            stroke="#156E8A" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M14 15C14.7956 15 15.5587 14.6839 16.1213 14.1213C16.6839 13.5587 17 12.7956 17 12C17 11.2044 16.6839 10.4413 16.1213 9.87868C15.5587 9.31607 14.7956 9 14 9C13.2044 9 12.4413 9.31607 11.8787 9.87868C11.3161 10.4413 11 11.2044 11 12C11 12.7956 11.3161 13.5587 11.8787 14.1213C12.4413 14.6839 13.2044 15 14 15Z"
                                            stroke="#156E8A" stroke-width="1.2" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_181_5271">
                                            <rect width="28" height="28" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="text-white text-xl md:text-2xl font-light mb-2.5">
                                Deeper Sleep
                            </h3>
                            <p
                                class="text-gray-300 text-[11px] md:text-xs font-light leading-relaxed opacity-90 md:opacity-80">
                                Filtered, clean air at night allows your body to rest fully.
                                Waking rested isn't luck &mdash; it's environment.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Protect Your Children -->
                <div class="swiper-slide h-auto">
                    <div
                        class="relative w-full h-full aspect-[4/5] lg:aspect-[3/4] group overflow-hidden rounded-md md:rounded-none">
                        <img src="./assets/images/benefit-children.png" alt="Protect Your Children"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#090D10] via-[#090D10]/50 to-transparent opacity-90">
                        </div>

                        <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end text-left">
                            <div class="text-brandTeal mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-white text-xl md:text-2xl font-light mb-2.5">
                                Protect Your Children
                            </h3>
                            <p
                                class="text-gray-300 text-[11px] md:text-xs font-light leading-relaxed opacity-90 md:opacity-80">
                                Young lungs are more vulnerable. Give them the cleanest air
                                in every room they grow, play, and sleep.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: Allergy Relief -->
                <div class="swiper-slide h-auto">
                    <div
                        class="relative w-full h-full aspect-[4/5] lg:aspect-[3/4] group overflow-hidden rounded-md md:rounded-none">
                        <img src="./assets/images/benefit-allergy.png" alt="Allergy Relief"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#090D10] via-[#090D10]/50 to-transparent opacity-90">
                        </div>

                        <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end text-left">
                            <div class="text-brandTeal mb-4">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.0002 5C9.0002 5 6.0002 9 7.0002 13C8.0002 18 14.0002 24 14.0002 24C14.0002 24 20.0002 18 21.0002 13C22.0002 9 19.0002 5 14.0002 5Z"
                                        stroke="#156E8A" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h3 class="text-white text-xl md:text-2xl font-light mb-2.5">
                                Allergy Relief
                            </h3>
                            <p
                                class="text-gray-300 text-[11px] md:text-xs font-light leading-relaxed opacity-90 md:opacity-80">
                                HEPA H13 captures pollen, dust mites, pet dander, and mould
                                spores before they reach you &mdash; or your family.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: Healthier Workspaces -->
                <div class="swiper-slide h-auto">
                    <div
                        class="relative w-full h-full aspect-[4/5] lg:aspect-[3/4] group overflow-hidden rounded-md md:rounded-none">
                        <img src="./assets/images/benefit-workspace.png" alt="Healthier Workspaces"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#090D10] via-[#090D10]/50 to-transparent opacity-90">
                        </div>

                        <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end text-left">
                            <div class="text-brandTeal mb-4">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 8H23M5 14H23M5 20H17" stroke="#156E8A" stroke-width="1.2"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <h3 class="text-white text-xl md:text-2xl font-light mb-2.5">
                                Healthier Workspaces
                            </h3>
                            <p
                                class="text-gray-300 text-[11px] md:text-xs font-light leading-relaxed opacity-90 md:opacity-80">
                                Cleaner air at your desk or home office means sharper focus,
                                fewer headaches, and sustained energy through the day.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Swiper Pagination (Mobile Only) -->
            <div class="swiper-pagination md:hidden !bottom-0"></div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION 8: TECHNOLOGY & FILTRATION         -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] py-16 md:py-32 px-6 md:px-16 lg:px-24">
        <!-- Header Section (Responsive Alignment) -->
        <div
            class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <!-- Eyebrow -->
            <span
                class="text-[11px] md:text-[8px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                Inside Every Unit
            </span>

            <!-- Headline -->
            <h2
                class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                BreathePure&trade; Technology
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
                A four-stage air intelligence system, engineered to eliminate what
                you cannot see. No gimmicks. No compromises.
            </p>
        </div>

        <!-- 4-Stage Technology Grid/List -->
        <!-- Mobile: Transparent background, divided list. Desktop: White card, shadow, side-by-side grid -->
        <div
            class="max-w-6xl mx-auto bg-transparent md:bg-white border-0 md:border md:border-gray-100 md:shadow-[0_4px_20px_rgb(0,0,0,0.02)] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y divide-gray-200/80 md:divide-y-0 md:divide-x md:divide-gray-100 mb-12 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
            <!-- Stage 01: Capture -->
            <div class="py-6 md:p-10 flex flex-col h-full lg:border-b-0 border-gray-100 md:border-b">
                <!-- Header Row: Flex on mobile to align number/title, Block on desktop -->
                <div class="flex items-start md:block mb-1.5 md:mb-4">
                    <span
                        class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">01</span>

                    <!-- Simple Intake SVG Icon (Hidden on Mobile) -->
                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 14H36M12 22H32M16 30H28" stroke="#141414" stroke-width="1.4"
                            stroke-linecap="round" />
                    </svg>

                    <h3 class="text-[17px] font-normal text-gray-900">Capture</h3>
                </div>

                <!-- Description: Indented on mobile to align with title, standard on desktop -->
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                    A 360&deg; air intake draws the full room volume through the unit
                    up to 5 times per hour, leaving no corner untouched.
                </p>
            </div>

            <!-- Stage 02: Filter -->
            <div class="py-6 md:p-10 flex flex-col h-full lg:border-b-0 border-gray-100 md:border-b">
                <div class="flex items-start md:block mb-1.5 md:mb-4">
                    <span
                        class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">02</span>

                    <!-- Simple Filter Layers SVG Icon (Hidden on Mobile) -->
                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M34 10H10C8.89543 10 8 10.8954 8 12V13C8 14.1046 8.89543 15 10 15H34C35.1046 15 36 14.1046 36 13V12C36 10.8954 35.1046 10 34 10Z"
                            stroke="#141414" stroke-width="1.4" />
                        <path
                            d="M34 19H10C8.89543 19 8 19.8954 8 21V22C8 23.1046 8.89543 24 10 24H34C35.1046 24 36 23.1046 36 22V21C36 19.8954 35.1046 19 34 19Z"
                            stroke="#141414" stroke-width="1.4" />
                        <path
                            d="M34 28H10C8.89543 28 8 28.8954 8 30V31C8 32.1046 8.89543 33 10 33H34C35.1046 33 36 32.1046 36 31V30C36 28.8954 35.1046 28 34 28Z"
                            stroke="#141414" stroke-width="1.4" />
                    </svg>

                    <h3 class="text-[17px] font-normal text-gray-900">Filter</h3>
                </div>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                    True HEPA H13 filtration captures 99.97% of particles as small as
                    0.3 microns &mdash; including PM2.5, pollen, and bacteria.
                </p>
            </div>

            <!-- Stage 03: Neutralise -->
            <div class="py-6 md:p-10 flex flex-col h-full lg:border-t-0 lg:border-b-0 border-gray-100 border-t">
                <div class="flex items-start md:block mb-1.5 md:mb-4">
                    <span
                        class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">03</span>

                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 8V16M16 11L20 15M28 11L24 15M12 22H8M22 36V28M32 22H36M16 33L20 29M28 33L24 29"
                            stroke="#141414" stroke-width="1.4" stroke-linecap="round" />
                        <path
                            d="M22 27C24.7614 27 27 24.7614 27 22C27 19.2386 24.7614 17 22 17C19.2386 17 17 19.2386 17 22C17 24.7614 19.2386 27 22 27Z"
                            stroke="#141414" stroke-width="1.4" />
                    </svg>

                    <h3 class="text-[17px] font-normal text-gray-900">Neutralise</h3>
                </div>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                    An activated carbon layer absorbs VOCs, cooking odours, smoke, and
                    formaldehyde. What passes through is chemically neutral.
                </p>
            </div>

            <!-- Stage 04: Monitor -->
            <div class="py-6 md:p-10 flex flex-col h-full lg:border-t-0 border-gray-100 border-t">
                <div class="flex items-start md:block mb-1.5 md:mb-4">
                    <span
                        class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">04</span>

                    <!-- Simple Sensor/Clock SVG Icon (Hidden on Mobile) -->
                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22 34C28.6274 34 34 28.6274 34 22C34 15.3726 28.6274 10 22 10C15.3726 10 10 15.3726 10 22C10 28.6274 15.3726 34 22 34Z"
                            stroke="#141414" stroke-width="1.4" />
                        <path d="M22 14V22L27 25" stroke="#141414" stroke-width="1.4" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                    <h3 class="text-[17px] font-normal text-gray-900">Monitor</h3>
                </div>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                    Real-time laser sensors track PM2.5, CO&sub2;, humidity, and
                    temperature &mdash; displayed instantly on the unit and the app.
                </p>
            </div>
        </div>

        <!-- Medical Grade Authority Banner -->
        <div
            class="max-w-6xl mx-auto bg-[#0C1216] text-white p-8 md:p-16 lg:px-20 flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200 mt-16 md:mt-0">
            <!-- Desktop Circular Badge (Hidden on Mobile) -->
            <div
                class="hidden md:flex flex-shrink-0 w-[120px] h-[120px] rounded-full border border-gray-700/60 flex-col items-center justify-center text-center shadow-inner">
                <span class="text-3xl font-light text-[#156E8A] mb-1">H13</span>
                <span class="text-[6px] uppercase tracking-[0.25em] text-gray-400 font-bold leading-tight">
                    True Hepa<br />Certified
                </span>
            </div>

            <!-- Banner Content -->
            <!-- Mobile: Flex to place badge left of the text group. Desktop: Block layout -->
            <div class="text-left md:pr-[20%] w-full flex items-start md:block gap-4">
                <!-- Mobile-Only Square Tag (Hidden on Desktop) -->
                <div
                    class="md:hidden bg-[#0A1F26] text-[#156E8A] font-semibold px-2.5 py-1 text-[11px] tracking-wider rounded-sm shrink-0 mt-0.5">
                    H13
                </div>

                <!-- Text Group: Headline and Paragraph are grouped so they align perfectly -->
                <div>
                    <h4
                        class="text-[17px] md:text-2xl font-light tracking-wide leading-snug md:leading-normal mb-3 md:mb-5">
                        Medical-Grade Filtration, In Your Living Room
                    </h4>

                    <p class="text-[15px] text-gray-400 font-light leading-relaxed max-w-3xl pr-2 md:pr-0">
                        HEPA H13 is the same standard used in hospital operating
                        theatres and pharmaceutical cleanrooms. Breathe In brings this
                        standard into your home without compromise &mdash; removing
                        particles invisible to the human eye, every hour, every day.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION 9: APP INTEGRATION                 -->
    <!-- ========================================== -->
    <section class="w-full bg-[#0A1014] md:bg-white py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
        <!-- Grid Layout allows reordering. Mobile: 1 column. Desktop: 2 columns, 2 rows -->
        <div
            class="max-w-7xl mx-auto flex flex-col lg:grid lg:grid-cols-2 lg:grid-rows-[auto_1fr] gap-x-16 lg:gap-x-24 lg:gap-y-2 items-start lg:items-center">
            <!-- ========================================== -->
            <!-- 1. Text Group (Top Mobile / Top-Left Desktop) -->
            <!-- ========================================== -->
            <div
                class="order-1 lg:col-start-1 lg:row-start-1 w-full flex flex-col scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <!-- Eyebrow -->
                <span class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                    Breathe In App
                </span>

                <!-- Headline -->
                <!-- Responsive Text: White on mobile, Dark on desktop -->
                <h2
                    class="text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-white md:text-gray-900 leading-[1.1] mb-6">
                    Your air,
                    <span class="text-[#156E8A] font-bold">in your <br class="hidden md:block" />
                        hands.</span>
                </h2>

                <!-- Subtext -->
                <p class="text-gray-400 md:text-gray-500 text-sm font-light leading-relaxed mb-4 md:mb-10 max-w-lg">
                    Monitor and control every purifier in your home from one calm,
                    considered app. See what you're breathing in real time, adjust
                    from anywhere, and let it look after the rest.
                </p>
            </div>

            <!-- ========================================== -->
            <!-- 2. Image (Middle Mobile / Right Desktop)   -->
            <!-- ========================================== -->
            <div
                class="order-2 lg:col-start-2 lg:row-start-1 lg:row-span-2 relative w-full flex justify-center scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-200">
                <!-- Soft background glow behind the phone -->
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] md:w-[300px] h-[250px] md:h-[300px] bg-brandTeal/10 md:bg-brandTeal/5 rounded-full blur-[60px] pointer-events-none">
                </div>

                <!-- Mobile Image -->
                <img src="./assets/images/app-mockup-mobile.png" alt="Breathe In App Mobile"
                    class="block md:hidden w-full max-w-[320px] h-auto object-contain relative z-10 animate-float" />

                <!-- Desktop Image -->
                <img src="./assets/images/app-mockup.png" alt="Breathe In App Interface"
                    class="hidden md:block w-full max-w-[450px] h-auto object-contain relative z-10 animate-float" />
            </div>

            <!-- ========================================== -->
            <!-- 3. Features & Buttons (Bottom Mobile / Bottom-Left Desktop) -->
            <!-- ========================================== -->
            <div
                class="order-3 lg:col-start-1 lg:row-start-2 w-full flex flex-col scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-100">
                <!-- Feature List -->
                <div
                    class="flex flex-col border-t border-gray-800/80 md:border-t-0 divide-y divide-gray-800/80 md:divide-gray-100 mb-10 md:mb-12">
                    <!-- Feature 1 -->
                    <div class="py-5 flex items-start gap-4 md:gap-5">
                        <div class="mt-0.5 text-[#156E8A] bg-[#111A20] md:bg-sky-50 p-2.5 md:p-2 rounded-full">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 17.5C14.1421 17.5 17.5 14.1421 17.5 10C17.5 5.85786 14.1421 2.5 10 2.5C5.85786 2.5 2.5 5.85786 2.5 10C2.5 14.1421 5.85786 17.5 10 17.5Z"
                                    stroke="#156E8A" stroke-width="1.3" />
                                <path d="M10 6V10L12.6 11.6" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[15px] text-gray-100 md:text-gray-900 font-medium mb-1">
                                Live Air Quality
                            </h4>
                            <p class="text-[11px] text-gray-400 md:text-gray-500 font-light leading-relaxed">
                                Real-time PM2.5, AQI, and filter status for every room,
                                updated by the second.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="py-5 flex items-start gap-4 md:gap-5">
                        <div class="mt-0.5 text-[#156E8A] bg-[#111A20] md:bg-sky-50 p-2.5 md:p-2 rounded-full">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.5 2.5H5.5C4.39543 2.5 3.5 3.39543 3.5 4.5V15.5C3.5 16.6046 4.39543 17.5 5.5 17.5H14.5C15.6046 17.5 16.5 16.6046 16.5 15.5V4.5C16.5 3.39543 15.6046 2.5 14.5 2.5Z"
                                    stroke="#156E8A" stroke-width="1.3" />
                                <path d="M8 14.5H12" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[15px] text-gray-100 md:text-gray-900 font-medium mb-1">
                                Control From Anywhere
                            </h4>
                            <p class="text-[11px] text-gray-400 md:text-gray-500 font-light leading-relaxed">
                                Switch modes, set fan speed, or start purifying before you
                                walk through the door.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="py-5 flex items-start gap-4 md:gap-5">
                        <div class="mt-0.5 text-[#156E8A] bg-[#111A20] md:bg-sky-50 p-2.5 md:p-2 rounded-full">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2.5V5.5M10 14.5V17.5M17.5 10H14.5M5.5 10H2.5M15 5L12.9 7.1M7.1 12.9L5 15M15 15L12.9 12.9M7.1 7.1L5 5"
                                    stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" />
                                <path
                                    d="M10 13C11.6569 13 13 11.6569 13 10C13 8.34315 11.6569 7 10 7C8.34315 7 7 8.34315 7 10C7 11.6569 8.34315 13 10 13Z"
                                    stroke="#156E8A" stroke-width="1.3" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[15px] text-gray-100 md:text-gray-900 font-medium mb-1">
                                Schedules & Sleep Mode
                            </h4>
                            <p class="text-[11px] text-gray-400 md:text-gray-500 font-light leading-relaxed">
                                Automate quiet nights and active days. Your home breathes on
                                its own rhythm.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="py-5 flex items-start gap-4 md:gap-5">
                        <div class="mt-0.5 text-[#156E8A] bg-[#111A20] md:bg-sky-50 p-2.5 md:p-2 rounded-full">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2.5L4 5V9.2C4 12.9 6.5 16.3 10 17.5C13.5 16.3 16 12.9 16 9.2V5L10 2.5Z"
                                    stroke="#156E8A" stroke-width="1.3" stroke-linejoin="round" />
                                <path d="M7.5 10L9.3 11.8L13 8" stroke="#156E8A" stroke-width="1.3"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[15px] text-gray-100 md:text-gray-900 font-medium mb-1">
                                Filter Care Reminders
                            </h4>
                            <p class="text-[11px] text-gray-400 md:text-gray-500 font-light leading-relaxed">
                                Know exactly when to replace a filter &mdash; and reorder
                                genuine parts in a tap.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- App Store Buttons -->
                <div class="grid grid-cols-2 md:flex md:flex-wrap items-center gap-3 md:gap-4">
                    <!-- Apple App Store -->
                    <a href="#"
                        class="flex items-center justify-center md:justify-start gap-2.5 md:gap-3 px-3 md:px-5 py-3 md:py-2.5 border border-gray-800 md:border-gray-200 hover:border-gray-500 md:hover:border-gray-300 md:hover:bg-gray-50 transition-all rounded-sm group text-white md:text-[#141414]">
                        <!-- fill="currentColor" allows the SVG to flip between white on mobile and dark on desktop -->
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.6292 11.4953C15.6109 9.47859 17.2793 8.50693 17.3526 8.46109C16.4176 7.08609 14.9601 6.90276 14.4376 6.88443C13.2001 6.75609 12.0176 7.61776 11.3851 7.61776C10.7526 7.61776 9.79008 6.90276 8.76342 6.92109C7.41592 6.93943 6.16925 7.70943 5.47258 8.91943C4.07008 11.3578 5.11508 14.9694 6.48092 16.9494C7.15008 17.9211 7.94758 19.0119 8.99258 18.9753C10.0009 18.9386 10.3859 18.3244 11.6051 18.3244C12.8243 18.3244 13.1726 18.9753 14.2359 18.9569C15.3176 18.9386 16.0051 17.9669 16.6651 16.9861C17.4351 15.8586 17.7467 14.7678 17.7651 14.7128C17.7376 14.7036 15.6659 13.9061 15.6476 11.5136L15.6292 11.4953ZM13.6401 5.46359C14.1901 4.79443 14.5659 3.86859 14.4651 2.93359C13.6676 2.97026 12.6959 3.46526 12.1184 4.13443C11.6051 4.72109 11.1559 5.66526 11.2751 6.56359C12.1642 6.63693 13.0809 6.11443 13.6401 5.46359Z" />
                        </svg>
                        <div class="flex flex-col">
                            <span
                                class="text-[6px] md:text-[7px] uppercase tracking-widest text-gray-500 font-bold leading-none mb-1">Download
                                on the</span>
                            <span class="text-xs md:text-sm font-medium leading-none">App Store</span>
                        </div>
                    </a>

                    <!-- Google Play Store -->
                    <a href="#"
                        class="flex items-center justify-center md:justify-start gap-2.5 md:gap-3 px-3 md:px-5 py-3 md:py-2.5 border border-gray-800 md:border-gray-200 hover:border-gray-500 md:hover:border-gray-300 md:hover:bg-gray-50 transition-all rounded-sm group text-white md:text-[#141414]">
                        <!-- fill="currentColor" applied -->
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.30042 2.20013C3.05292 2.4568 2.90625 2.86013 2.90625 3.37346V18.6268C2.90625 19.1401 3.05292 19.5435 3.30042 19.8001L3.35542 19.846L11.9171 11.0643V10.936L3.35542 2.1543L3.30042 2.20013ZM14.9421 14.0893L12.1004 11.2476V11.1193L14.9421 8.27763L15.0063 8.3143L18.3704 10.2301C19.3329 10.7801 19.3329 11.6693 18.3704 12.2193L15.0063 14.1351L14.9421 14.181V14.0893ZM14.6029 14.4285L11.6971 11.4585L3.30042 19.846C3.62125 20.1851 4.14375 20.2218 4.73958 19.8918L14.6029 14.4285ZM14.6029 8.48846L4.73958 3.02513C4.14375 2.69513 3.62125 2.7318 3.30042 3.07096L11.6971 11.4585L14.6029 8.48846Z" />
                        </svg>
                        <div class="flex flex-col">
                            <span
                                class="text-[6px] md:text-[7px] uppercase tracking-widest text-gray-500 font-bold leading-none mb-1">Get
                                it on</span>
                            <span class="text-xs md:text-sm font-medium leading-none">Google Play</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION 10: SIDE-BY-SIDE COMPARISON        -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24">
        <!-- Header Section (Responsive Alignment) -->
        <div
            class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <!-- Eyebrow -->
            <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                Side by Side
            </span>

            <!-- Headline -->
            <h2
                class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                Find your perfect model.
            </h2>

            <!-- Subtext -->
            <p class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto">
                Every home is different. Every Breathe In model is designed to match
                yours precisely.
            </p>
        </div>

        <!-- Comparison Table Wrapper -->
        <!-- Added rounded corners, border, and horizontal scroll for mobile -->
        <div class="max-w-6xl mx-auto scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100 pb-8">
            <div
                class="overflow-x-auto md:overflow-visible no-scrollbar rounded-xl border border-gray-200 bg-white shadow-sm relative">
                <!-- CSS Grid for the Table -->
                <!-- Mobile: Fixed 120px first column, auto-sizing for the rest. Desktop: 5 equal columns -->
                <div
                    class="grid grid-cols-[120px_repeat(4,minmax(140px,1fr))] md:grid-cols-5 min-w-[700px] md:min-w-full">
                    <!-- ================= ROW 1: HEADERS ================= -->

                    <!-- Col 1: Label Space (Sticky on mobile) -->
                    <div
                        class="p-5 md:p-8 sticky left-0 bg-white z-20 flex items-end text-[11px] uppercase tracking-[0.2em] text-gray-400 font-bold border-b border-gray-100">
                        Feature
                    </div>

                    <!-- Col 2: Air Pro -->
                    <div
                        class="p-5 md:p-8 flex flex-col items-center justify-center text-center border-b border-gray-100">
                        <h3 class="text-base md:text-xl font-medium md:font-normal text-gray-900 mb-1 md:mb-2">
                            Air Pro
                        </h3>
                        <span class="text-[11px] md:text-sm text-gray-400 md:text-[#156E8A] font-light">From
                            ₹24,990</span>
                    </div>

                    <!-- Col 3: Air Pro 1 (HIGHLIGHTED COLUMN) -->
                    <div
                        class="p-5 md:p-8 flex flex-col items-center justify-center text-center bg-[#EDF3F6] relative border-b border-gray-100">
                        <!-- Badge -->
                        <div
                            class="absolute top-0 right-0 md:-top-3 md:left-1/2 md:-translate-x-1/2 bg-[#156E8A] text-white text-[7px] md:text-[8px] uppercase tracking-widest font-bold px-3 py-1.5 md:whitespace-nowrap z-10 rounded-bl-md md:rounded-none">
                            Most Chosen
                        </div>
                        <h3
                            class="text-base md:text-xl font-medium md:font-normal text-gray-900 mb-1 md:mb-2 mt-4 md:mt-0">
                            Air Pro 1
                        </h3>
                        <span class="text-[11px] md:text-sm text-gray-400 md:text-[#156E8A] font-light">From
                            ₹44,990</span>
                    </div>

                    <!-- Col 4: Air Pro 2 -->
                    <div
                        class="p-5 md:p-8 flex flex-col items-center justify-center text-center border-b border-gray-100">
                        <h3 class="text-base md:text-xl font-medium md:font-normal text-gray-900 mb-1 md:mb-2">
                            Air Pro 2
                        </h3>
                        <span class="text-[11px] md:text-sm text-gray-400 md:text-[#156E8A] font-light">From
                            ₹74,990</span>
                    </div>

                    <!-- Col 5: Air Pro Max -->
                    <div
                        class="p-5 md:p-8 flex flex-col items-center justify-center text-center border-b border-gray-100">
                        <h3 class="text-base md:text-xl font-medium md:font-normal text-gray-900 mb-1 md:mb-2">
                            Air Pro Max
                        </h3>
                        <span class="text-[11px] md:text-sm text-gray-400 md:text-[#156E8A] font-light">From
                            ₹1,24,990</span>
                    </div>

                    <!-- ================= ROW 2: COVERAGE AREA ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Coverage Area
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Up to 400 sq ft
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 bg-[#EDF3F6] text-right md:text-center">
                        Up to 650 sq ft
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Up to 900 sq ft
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Up to 1,200 sq ft
                    </div>

                    <!-- ================= ROW 3: IDEAL SPACE ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Ideal Space
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Studio / Bedroom
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 bg-[#EDF3F6] text-right md:text-center">
                        Living Room
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Open Plan Living
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Entire Floor
                    </div>

                    <!-- ================= ROW 4: SMART FEATURES ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Smart Features
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Air Quality Display
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 bg-[#EDF3F6] text-right md:text-center">
                        App + Voice Control
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Full Smart Home
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        Professional Suite
                    </div>

                    <!-- ================= ROW 5: FILTER LIFE ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Filter Life
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        8 months
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 bg-[#EDF3F6] text-right md:text-center">
                        10 months
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        12 months
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        12 months
                    </div>

                    <!-- ================= ROW 6: NOISE LEVEL ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Noise Level
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        22 &ndash; 45 dB
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 bg-[#EDF3F6] text-right md:text-center">
                        20 &ndash; 42 dB
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        18 &ndash; 40 dB
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        18 &ndash; 38 dB
                    </div>

                    <!-- ================= ROW 7: WARRANTY ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Warranty
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        1 Year
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 bg-[#EDF3F6] text-right md:text-center">
                        2 Years
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        2 Years
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center">
                        3 Years
                    </div>

                    <!-- ================= ROW 8: HEPA H13 (Booleans) ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        HEPA H13
                    </div>
                    <div class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A] bg-[#EDF3F6]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <!-- ================= ROW 9: ACTIVE CARBON ================= -->
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        Active Carbon
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-gray-300 font-light">
                        &mdash;
                    </div>
                    <div
                        class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A] bg-[#EDF3F6]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="border-b border-gray-100 p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <!-- ================= ROW 10: PM2.5 SENSOR ================= -->
                    <div
                        class="p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
                        PM2.5 Sensor
                    </div>
                    <div class="p-4 md:p-6 flex items-center justify-center text-gray-300 font-light">
                        &mdash;
                    </div>
                    <div class="p-4 md:p-6 flex items-center justify-center text-[#156E8A] bg-[#EDF3F6]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 md:p-6 flex items-center justify-center text-[#156E8A]">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION 11: CASE STUDIES (Zig-Zag Grid)    -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
        <!-- Header Section (Responsive Alignment) -->
        <div
            class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-20 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <!-- Eyebrow -->
            <span
                class="text-[11px] md:text-[12px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                As Lived In
            </span>

            <!-- Headline -->
            <h2
                class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                Homes that breathe differently.
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
                Real installations. Real results. Measured improvements in the homes
                of those who chose to live better.
            </p>
        </div>

        <!-- Carousel/Checkerboard Wrapper -->
        <!-- Mobile: Transparent wrapper for Swiper. Desktop: White box with shadow for the whole grid -->
        <div
            class="max-w-6xl mx-auto bg-transparent md:bg-white md:border md:border-gray-100 md:shadow-[0_4px_30px_rgb(0,0,0,0.03)] relative">
            <!-- Swiper Container -->
            <div class="swiper caseStudiesSwiper pb-12 md:pb-0 overflow-visible md:overflow-hidden w-full">
                <!-- Swiper Wrapper overrides Swiper's horizontal flex on desktop -->
                <div class="swiper-wrapper md:!flex md:!flex-col md:!transform-none md:!w-full md:!h-auto">
                    <!-- ================= SLIDE / ROW 1 ================= -->
                    <div class="swiper-slide h-auto md:!h-auto">
                        <!-- Card Styling on Mobile, Grid Row on Desktop -->
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 h-full bg-white border border-gray-200 md:border-0 rounded-xl md:rounded-none overflow-hidden">
                            <!-- Image (Always top on mobile, left on desktop) -->
                            <div class="relative w-full h-[240px] sm:h-[300px] md:h-auto md:min-h-[400px] order-1">
                                <img src="./assets/images/case-study-1.png" alt="South Mumbai Penthouse"
                                    class="absolute inset-0 w-full h-full object-cover" />
                            </div>

                            <!-- Text Content -->
                            <div class="p-6 md:p-16 flex flex-col justify-center order-2">
                                <span
                                    class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                                    South Mumbai Penthouse
                                </span>

                                <h3
                                    class="text-[17px] md:text-xl lg:text-[25px] font-medium md:font-light text-gray-900 leading-snug mb-4 md:mb-6">
                                    "I didn't realise how much better sleep could feel until
                                    my daughter stopped waking up with a blocked nose every
                                    morning."
                                </h3>

                                <p
                                    class="text-[11px] md:text-[12px] text-gray-400 font-light mb-8 md:mb-10 lg:uppercase tracking-wide">
                                    Priya Mehta, Homeowner &mdash; 3,420 sq ft residence, Air
                                    Pro Max model
                                </p>

                                <!-- Stats Grid -->
                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    <div
                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                        <span
                                            class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">PM2.5
                                            Reduction</span>
                                        <span class="text-xl md:text-2xl font-normal text-gray-900">94%</span>
                                    </div>
                                    <div
                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                        <span
                                            class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">Sleep
                                            Quality Score</span>
                                        <span class="text-xl md:text-2xl font-normal text-gray-900">+38%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= SLIDE / ROW 2 ================= -->
                    <div class="swiper-slide h-auto md:!h-auto">
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 h-full bg-white border border-gray-200 md:border-0 md:border-t border-gray-100 rounded-xl md:rounded-none overflow-hidden">
                            <!-- Image (Top on mobile, Right on desktop) -->
                            <!-- order-1 on mobile, md:order-2 shifts it to the right on desktop -->
                            <div
                                class="relative w-full h-[240px] sm:h-[300px] md:h-auto md:min-h-[400px] order-1 md:order-2">
                                <img src="./assets/images/case-study-2.png" alt="Whitefield Villa"
                                    class="absolute inset-0 w-full h-full object-cover" />
                            </div>

                            <!-- Text Content (Bottom on mobile, Left on desktop) -->
                            <div class="p-6 md:p-16 flex flex-col justify-center order-2 md:order-1">
                                <span
                                    class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                                    Whitefield Villa, Bengaluru
                                </span>

                                <h3
                                    class="text-[17px] md:text-xl lg:text-[25px] font-medium md:font-light text-gray-900 leading-snug mb-4 md:mb-6">
                                    "As a cardiologist, I was already aware of what indoor
                                    pollution does. Now my home reflects those values."
                                </h3>

                                <p
                                    class="text-[11px] md:text-[12px] text-gray-400 font-light mb-8 md:mb-10 lg:uppercase tracking-wide">
                                    Dr. Ananya Krishnan &mdash; 5,000 sq ft villa, 2&times;
                                    Air Pro 2 models
                                </p>

                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    <div
                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                        <span
                                            class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">VOC
                                            Removal</span>
                                        <span class="text-xl md:text-2xl font-normal text-gray-900">99%</span>
                                    </div>
                                    <div
                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                        <span
                                            class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">Allergy
                                            Incidents</span>
                                        <span class="text-xl md:text-2xl font-normal text-gray-900">&minus;81%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= SLIDE / ROW 3 ================= -->
                    <div class="swiper-slide h-auto md:!h-auto">
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 h-full bg-white border border-gray-200 md:border-0 md:border-t border-gray-100 rounded-xl md:rounded-none overflow-hidden">
                            <!-- Image (Always top on mobile, left on desktop) -->
                            <div class="relative w-full h-[240px] sm:h-[300px] md:h-auto md:min-h-[400px] order-1">
                                <img src="./assets/images/case-study-3.png" alt="Aerocity Residence"
                                    class="absolute inset-0 w-full h-full object-cover" />
                            </div>

                            <!-- Text Content -->
                            <div class="p-6 md:p-16 flex flex-col justify-center order-2">
                                <span
                                    class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                                    Aerocity Residence, New Delhi
                                </span>

                                <h3
                                    class="text-[17px] md:text-xl lg:text-[25px] font-medium md:font-light text-gray-900 leading-snug mb-4 md:mb-6">
                                    "Our senior team noticed the difference within two days.
                                    The air feels lighter. Focus is tangibly sharper."
                                </h3>

                                <p
                                    class="text-[11px] md:text-[12px] text-gray-400 font-light mb-8 md:mb-10 lg:uppercase tracking-wide">
                                    Vikram Anand, Facilities Director &mdash; 8,000 sq ft
                                    workspace, Air Pro 1 models
                                </p>

                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    <div
                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                        <span
                                            class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">Dust
                                            Reduction</span>
                                        <span class="text-xl md:text-2xl font-normal text-gray-900">97%</span>
                                    </div>
                                    <div
                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                        <span
                                            class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">Team
                                            Focus Rating</span>
                                        <span class="text-xl md:text-2xl font-normal text-gray-900">+29%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Swiper Pagination (Mobile Only) -->
                <div class="swiper-pagination md:hidden !bottom-0"></div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 12: TRUST & CERTIFICATIONS         -->
    <!-- ========================================== -->
    <section class="w-full bg-[#FAFCFD] py-16 md:py-20 px-6 md:px-16 lg:px-24">
        <!-- Header Section (Responsive Alignment) -->
        <div
            class="max-w-4xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <!-- Eyebrow with decorative lines (Lines hidden on mobile) -->
            <div class="flex items-center justify-start md:justify-center gap-4 mb-4 md:mb-6">
                <div class="hidden md:block w-8 h-[1px] bg-gray-300"></div>
                <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold">
                    Why Trust Breathe In
                </span>
                <div class="hidden md:block w-8 h-[1px] bg-gray-300"></div>
            </div>

            <!-- Headline -->
            <h2
                class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                We don't just claim to purify <br class="hidden md:block" />
                your air &mdash;
                <span class="text-[#156E8A] font-medium">we prove it.</span>
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
                Every Breathe In product undergoes rigorous third-party testing and
                certification to international standards. Because your family's
                health deserves nothing less than verified excellence.
            </p>
        </div>

        <!-- 4-Column Feature Grid (Stacking on mobile, side-by-side flex inside cards) -->
        <div
            class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8 mb-16 md:mb-20 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
            <!-- Card 1: Certified Performance -->
            <div
                class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 rounded-md md:rounded-none">
                <!-- Card Header: Flex Row on Mobile, Flex Col on Desktop -->
                <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                    <!-- Icon -->
                    <div
                        class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 2L18 5V10C18 14.2 15 17.8 11 19C7 17.8 4 14.2 4 10V5L11 2Z" stroke="#156E8A"
                                stroke-width="1.3" stroke-linejoin="round" />
                            <path d="M8 11L10 13L14 8.5" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                        Certified Performance
                    </h3>
                </div>

                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                    Internationally certified to capture 99.97% of PM2.5 and harmful
                    airborne particles &mdash; with up to 99.99% virus removal on Air
                    Pro Max.
                </p>
            </div>

            <!-- Card 2: Japanese Technology -->
            <div
                class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 delay-75 rounded-md md:rounded-none">
                <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                    <div
                        class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 19.5C15.6944 19.5 19.5 15.6944 19.5 11C19.5 6.30558 15.6944 2.5 11 2.5C6.30558 2.5 2.5 6.30558 2.5 11C2.5 15.6944 6.30558 19.5 11 19.5Z"
                                stroke="#156E8A" stroke-width="1.3" />
                            <path d="M11 6V11L14 13" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                        Japanese Technology
                    </h3>
                </div>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                    Sophisticated Japanese air-purification engineering, delivered
                    through thoughtfully designed products at honest, accessible
                    prices.
                </p>
            </div>

            <!-- Card 3: HEPA H13 Filtration -->
            <div
                class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 delay-150 rounded-md md:rounded-none">
                <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                    <div
                        class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.5H19M5.5 13.5H16.5M8 17.5H14M11 3V9" stroke="#156E8A" stroke-width="1.3"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                        HEPA H13 Filtration
                    </h3>
                </div>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                    True HEPA H13 &mdash; the standard of hospital operating theatres
                    &mdash; across the entire range, paired with activated carbon and
                    reactive-oxygen modules.
                </p>
            </div>

            <!-- Card 4: Service & Support -->
            <div
                class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 delay-200 rounded-md md:rounded-none">
                <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                    <div
                        class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 2.5C9.88376 2.5 8.77846 2.71986 7.74719 3.14702C6.71592 3.57419 5.77889 4.20029 4.98959 4.98959C4.20029 5.77889 3.57419 6.71592 3.14702 7.74719C2.71986 8.77846 2.5 9.88376 2.5 11C2.5 12.1162 2.71986 13.2215 3.14702 14.2528C3.57419 15.2841 4.20029 16.2211 4.98959 17.0104C5.77889 17.7997 6.71592 18.4258 7.74719 18.853C8.77846 19.2801 9.88376 19.5 11 19.5C13.2543 19.5 15.4163 18.6045 17.0104 17.0104C18.6045 15.4163 19.5 13.2543 19.5 11C19.5 8.74566 18.6045 6.58365 17.0104 4.98959C15.4163 3.39553 13.2543 2.5 11 2.5Z"
                                stroke="#156E8A" stroke-width="1.3" />
                            <path d="M7.5 11H14.5M11 7.5V14.5" stroke="#156E8A" stroke-width="1.3"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                        Service & Support
                    </h3>
                </div>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                    Real people, six days a week, in English, Hindi and Kannada.
                    Filter-replacement alerts, WhatsApp troubleshooting and on-call
                    guidance.
                </p>
            </div>
        </div>

        <!-- Certifications Strip -->
        <!-- Removed borders on mobile -->
        <div
            class="max-w-7xl mx-auto md:border-t md:border-b border-[#DCE4E7] py-6 md:py-10 px-0 md:px-6 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200">
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-10 lg:gap-12">
                <img src="./assets/images/cert-logo-1.png" alt="Certification 1"
                    class="h-8 md:h-10 w-auto object-contain md:grayscale hover:grayscale-0 transition-all" />
                <img src="./assets/images/cert-logo-2.png" alt="Certification 2"
                    class="h-8 md:h-10 w-auto object-contain md:grayscale hover:grayscale-0 transition-all" />
                <img src="./assets/images/cert-logo-3.png" alt="AHAM Verifide"
                    class="h-8 md:h-10 w-auto object-contain md:grayscale hover:grayscale-0 transition-all" />
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 13: THE OWNERSHIP EXPERIENCE       -->
    <!-- ========================================== -->
    <!-- Responsive Background: Light on Mobile, Dark on Desktop -->
    <section class="w-full bg-[#FAFCFD] md:bg-[#0B1115] py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
        <!-- Header Section (Responsive Alignment & Colors) -->
        <div
            class="max-w-4xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
            <!-- Eyebrow -->
            <span
                class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] md:text-[#4A99B2] font-bold mb-4 md:mb-6 block">
                The Breathe In Experience
            </span>

            <!-- Headline -->
            <h2
                class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 md:text-white leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                Ownership as it should be.
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-500 md:text-gray-400 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
                Acquiring a Breathe In is the beginning of a relationship, not a
                transaction.
            </p>
        </div>

        <!-- Carousel/Grid Wrapper -->
        <div
            class="swiper ownershipSwiper max-w-[1400px] mx-auto md:border md:border-gray-800/60 pb-12 md:pb-0 overflow-visible md:overflow-hidden w-full scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
            <!-- Swiper Wrapper overrides Swiper's horizontal flex on desktop to use CSS Grid -->
            <!-- md:!divide-y lg:!divide-y-0 perfectly matches your original border logic -->
            <div
                class="swiper-wrapper md:!grid md:!grid-cols-3 lg:!grid-cols-5 md:!divide-x md:!divide-y lg:!divide-y-0 md:!divide-gray-800/60 md:!transform-none md:!w-full md:!h-auto">
                <!-- ================= COLUMN 01 ================= -->
                <!-- md:!w-auto md:!m-0 strips Swiper's inline width/margin so the grid works perfectly -->
                <div class="swiper-slide h-auto md:!w-auto md:!m-0">
                    <div
                        class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
                        <span
                            class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6">01</span>

                        <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                            <div
                                class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                                <svg class="w-6 h-6 stroke-[1.5px]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                                White Glove Setup
                            </h3>
                        </div>

                        <p
                            class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                            A certified air specialist visits your home, positions your
                            unit for maximum coverage, and configures it to your
                            lifestyle.
                        </p>
                    </div>
                </div>

                <!-- ================= COLUMN 02 ================= -->
                <div class="swiper-slide h-auto md:!w-auto md:!m-0">
                    <div
                        class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
                        <span
                            class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6">02</span>

                        <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                            <div
                                class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                                <svg class="w-6 h-6 stroke-[1.5px]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                                Filter Assistance
                            </h3>
                        </div>

                        <p
                            class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                            We track your filter life remotely and deliver genuine
                            replacements to your door before you ever need to think about
                            it.
                        </p>
                    </div>
                </div>

                <!-- ================= COLUMN 03 ================= -->
                <div class="swiper-slide h-auto md:!w-auto md:!m-0">
                    <div
                        class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
                        <span
                            class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6">03</span>

                        <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                            <div
                                class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                                <svg class="w-6 h-6 stroke-[1.5px]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                                Priority Support
                            </h3>
                        </div>

                        <p
                            class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                            A dedicated air wellness advisor, available by call or
                            message. Your questions answered within the hour, always.
                        </p>
                    </div>
                </div>

                <!-- ================= COLUMN 04 ================= -->
                <div class="swiper-slide h-auto md:!w-auto md:!m-0">
                    <div
                        class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
                        <span
                            class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6">04</span>

                        <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                            <div
                                class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                                <svg class="w-6 h-6 stroke-[1.5px]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                                Genuine Parts
                            </h3>
                        </div>

                        <p
                            class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                            Only certified Breathe In HEPA H13 filters will ever enter
                            your unit. No substitutions. No compromise on what you
                            breathe.
                        </p>
                    </div>
                </div>

                <!-- ================= COLUMN 05 ================= -->
                <div class="swiper-slide h-auto md:!w-auto md:!m-0">
                    <div
                        class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
                        <span
                            class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6">05</span>

                        <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                            <div
                                class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                                <svg class="w-6 h-6 stroke-[1.5px]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                </svg>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                                Extended Warranty
                            </h3>
                        </div>

                        <p
                            class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                            Up to three years of complete coverage &mdash; parts, labour,
                            and remote diagnostics &mdash; at no additional charge on
                            select models.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Swiper Pagination (Mobile Only) -->
            <div class="swiper-pagination md:hidden !bottom-0"></div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION 14: BROCHURE & DOWNLOAD            -->
    <!-- ========================================== -->
    <section class="relative w-full bg-[#0A1318] py-16 md:py-28 px-6 md:px-16 lg:px-24 overflow-hidden">
        <!-- Custom Radial Background Glow (Positioned at 85% right, perfectly behind the brochure) -->
        <div class="absolute inset-0 pointer-events-none" style="
            background: radial-gradient(
              70% 80% at 85% 50%,
              rgba(21, 110, 138, 0.14) 0%,
              rgba(0, 0, 0, 0) 70%
            );
          "></div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center relative z-10">
            <!-- Left Column: Content & CTA -->
            <div class="flex flex-col scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <!-- Eyebrow -->
                <div class="flex items-center gap-4 mb-5 md:mb-6">
                    <div class="w-8 h-[1px] bg-[#156E8A]"></div>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold">
                        Free Download
                    </span>
                </div>

                <!-- Headline -->
                <h2
                    class="text-[32px] md:text-5xl lg:text-[44px] font-light tracking-tight text-white leading-[1.15] md:leading-[1.2] mb-5 md:mb-6">
                    Everything you need <br class="hidden md:block" />
                    to make the right choice.
                </h2>

                <!-- Subtext -->
                <p class="text-gray-400 text-[12px] md:text-[15px] font-light leading-relaxed mb-8 md:mb-12 max-w-lg">
                    Our product brochure covers every model &mdash; CADR ratings, room
                    coverage, filter specs, certifications, and pricing.
                    Printed-quality detail, instantly in your inbox.
                </p>

                <!-- Divider -->
                <div class="w-full h-[1px] bg-gray-800/80 mb-8 md:mb-10"></div>

                <!-- Stats Row -->
                <div class="grid grid-cols-3 gap-4 md:gap-8 mb-10 md:mb-12">
                    <!-- Stat 1 -->
                    <div class="flex flex-col gap-1.5 md:gap-2">
                        <span class="text-xl md:text-2xl font-semibold text-white tracking-tight">28 pages</span>
                        <span
                            class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-500 font-medium">Detailed
                            Coverage</span>
                    </div>
                    <!-- Stat 2 -->
                    <div class="flex flex-col gap-1.5 md:gap-2">
                        <span class="text-xl md:text-2xl font-semibold text-white tracking-tight">6 models</span>
                        <span class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-500 font-medium">Full
                            Lineup</span>
                    </div>
                    <!-- Stat 3 -->
                    <div class="flex flex-col gap-1.5 md:gap-2">
                        <span class="text-xl md:text-2xl font-semibold text-white tracking-tight">PDF</span>
                        <span
                            class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-500 font-medium">Instant
                            Download</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 md:gap-6">
                    <!-- Primary Button (Solid) -->
                    <a href="#"
                        class="flex items-center justify-center gap-3 bg-[#156E8A] hover:bg-[#11576E] text-white text-[12px] md:text-[13px] uppercase tracking-[0.15em] font-bold px-6 md:px-8 py-4 md:py-3.5 rounded-sm transition-colors w-full sm:w-auto">
                        <span>Download Brochure</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>

                    <!-- Secondary Button (Text on Mobile, Ghost on Desktop) -->
                    <a href="#"
                        class="flex items-center justify-start sm:justify-center bg-transparent text-white md:border md:border-gray-600 hover:md:border-gray-400 text-[12px] md:text-[13px] uppercase tracking-[0.15em] font-bold px-2 md:px-8 py-3 md:py-3.5 rounded-sm transition-colors w-full sm:w-auto">
                        Request a Demo
                    </a>
                </div>
            </div>

            <!-- Right Column: Full Brochure Preview Image -->
            <div
                class="hidden lg:flex justify-center md:justify-end scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-200">
                <img src="./assets/images/brochure-preview.png" alt="Breathe In Product Catalog"
                    class="w-full max-w-[380px] h-auto object-contain shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-[#16252C] hover:-translate-y-2 transition-transform duration-500" />
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 15: WHY CHOOSE BREATHE IN          -->
    <!-- ========================================== -->
    <section class="w-full bg-[#0000000A] dark:bg-black py-16 md:py-24 px-6 md:px-16 lg:px-24 overflow-hidden">
        <div class="max-w-[1400px] mx-auto">
            <!-- Header Section -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 md:gap-12 mb-10 md:mb-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <!-- Left: Eyebrow & Headline -->
                <div class="max-w-xl">
                    <div class="flex items-center gap-3 mb-4 md:mb-6">
                        <div class="w-8 h-[1px] bg-[#156E8A]"></div>
                        <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold">
                            Why Choose Breathe In
                        </span>
                    </div>
                    <h2
                        class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 dark:text-white leading-[1.15] md:leading-[1.2]">
                        The right air deserves <br class="hidden md:block" />
                        <span class="text-[#156E8A]">the right choice.</span>
                    </h2>
                </div>
                <!-- Right: Subtext -->
                <p
                    class="text-gray-500 dark:text-gray-400 text-[15px] md:text-[14px] font-light leading-relaxed max-w-md md:text-right">
                    Not all purifiers are built equal. Breathe In is designed for
                    Indian homes, tested to Indian conditions, and backed by a team
                    that lives and breathes clean air.
                </p>
            </div>

            <div
                class="swiper whyChooseSwiper pb-12 md:pb-0 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
                <!-- 
              THE FIX: 
              Using md:gap-[1px] and md:bg-gray-200 to automatically generate perfect inner borders on desktop! 
            -->
                <div
                    class="swiper-wrapper md:!grid md:!grid-cols-3 md:gap-[1px] md:bg-gray-200 dark:md:bg-gray-800 md:border md:border-gray-200 dark:md:border-gray-800 md:!transform-none md:!w-full md:!h-auto">
                    <!-- Feature 01 -->
                    <!-- md:border-none is used because the grid gap provides the borders on desktop -->
                    <div
                        class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                        <div class="flex justify-between items-start mb-8 md:mb-12">
                            <span class="text-[12px] text-[#156E8A] font-medium tracking-widest">01</span>
                            <div
                                class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                <svg width="12" height="15" viewBox="0 0 12 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.1306 7.79864C11.1306 11.1312 8.79785 12.7974 6.0252 13.7639C5.88001 13.8131 5.7223 13.8107 5.57864 13.7572C2.79932 12.7974 0.466553 11.1312 0.466553 7.79864V3.13311C0.466553 2.95635 0.536774 2.78682 0.661767 2.66182C0.786761 2.53683 0.956289 2.46661 1.13306 2.46661C2.46607 2.46661 4.13233 1.6668 5.29204 0.653718C5.43324 0.53308 5.61287 0.466797 5.79859 0.466797C5.9843 0.466797 6.16393 0.53308 6.30513 0.653718C7.47151 1.67347 9.13111 2.46661 10.4641 2.46661C10.6409 2.46661 10.8104 2.53683 10.9354 2.66182C11.0604 2.78682 11.1306 2.95635 11.1306 3.13311V7.79864Z"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                            NABL-Certified Performance
                        </h3>
                        <p
                            class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                            Every unit is independently tested and certified by
                            NABL-accredited laboratories. The numbers on the box match
                            what happens in your home.
                        </p>
                    </div>

                    <!-- Feature 02 -->
                    <div
                        class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                        <div class="flex justify-between items-start mb-8 md:mb-12">
                            <span class="text-[12px] text-[#156E8A] font-medium tracking-widest">02</span>
                            <div
                                class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                <svg width="13" height="15" viewBox="0 0 13 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.13533 8.46658C1.0092 8.46701 0.885545 8.43165 0.778719 8.36459C0.671893 8.29754 0.586286 8.20155 0.531844 8.08778C0.477401 7.97401 0.456357 7.84712 0.471158 7.72187C0.485959 7.59661 0.535996 7.47813 0.615457 7.38018L7.21385 0.581838C7.26334 0.524707 7.33079 0.486099 7.40512 0.472354C7.47945 0.458608 7.55625 0.470541 7.6229 0.506193C7.68956 0.541845 7.74211 0.599099 7.77194 0.668556C7.80176 0.738013 7.80709 0.815547 7.78704 0.88843L6.50735 4.90079C6.46962 5.00178 6.45695 5.11041 6.47042 5.21738C6.4839 5.32434 6.52312 5.42644 6.58473 5.51492C6.64633 5.6034 6.72848 5.67561 6.82413 5.72536C6.91977 5.77511 7.02606 5.80092 7.13387 5.80057H11.7994C11.9255 5.80014 12.0492 5.8355 12.156 5.90256C12.2628 5.96961 12.3484 6.0656 12.4029 6.17937C12.4573 6.29314 12.4784 6.42002 12.4636 6.54528C12.4488 6.67053 12.3987 6.78902 12.3193 6.88697L5.72088 13.6853C5.67138 13.7424 5.60393 13.781 5.5296 13.7948C5.45527 13.8085 5.37848 13.7966 5.31182 13.761C5.24517 13.7253 5.19262 13.668 5.16279 13.5986C5.13296 13.5291 5.12764 13.4516 5.14769 13.3787L6.42737 9.36636C6.46511 9.26537 6.47778 9.15673 6.4643 9.04977C6.45083 8.9428 6.4116 8.8407 6.35 8.75223C6.28839 8.66375 6.20624 8.59154 6.1106 8.54179C6.01496 8.49204 5.90867 8.46623 5.80086 8.46658H1.13533Z"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                            BreatheCore&trade; 7-Stage Filtration
                        </h3>
                        <p
                            class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                            Our proprietary stack &mdash; pre-filter, H13 HEPA, activated
                            carbon, UV-C, and ioniser &mdash; removes 99.97% of particles
                            down to 0.3 microns.
                        </p>
                    </div>

                    <!-- Feature 03 -->
                    <div
                        class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                        <div class="flex justify-between items-start mb-8 md:mb-12">
                            <span class="text-[12px] text-[#156E8A] font-medium tracking-widest">03</span>
                            <div
                                class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.46507 12.4639C5.29473 12.4674 4.1658 12.031 3.30219 11.2411C2.43858 10.4513 1.90336 9.36566 1.8027 8.19965C1.70204 7.03364 2.04328 5.87239 2.75874 4.9462C3.47421 4.02001 4.51163 3.39655 5.66527 3.19946C9.46434 2.46631 10.4641 2.11973 11.7971 0.466797C12.4636 1.79981 13.1301 3.25278 13.1301 5.79883C13.1301 9.4646 9.94422 12.4639 6.46507 12.4639Z"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M0.466553 13.1304C0.466553 11.1309 1.69959 9.55791 3.85239 9.13135C5.46533 8.81143 7.13159 7.79834 7.7981 7.13184"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                            28 dB Sleep Mode
                        </h3>
                        <p
                            class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                            Quieter than a library whisper. Sleep mode runs at just 28 dB
                            so clean air never costs you rest.
                        </p>
                    </div>

                    <!-- Feature 04 -->
                    <div
                        class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                        <div class="flex justify-between items-start mb-8 md:mb-12">
                            <span class="text-[12px] text-[#156E8A] font-medium tracking-widest">04</span>
                            <div
                                class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                <svg width="9" height="15" viewBox="0 0 9 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.78301 7.72461L7.79276 13.4072C7.80407 13.4741 7.79468 13.5429 7.76585 13.6043C7.73702 13.6658 7.69012 13.7169 7.63142 13.751C7.57273 13.7851 7.50503 13.8004 7.43739 13.7949C7.36974 13.7895 7.30538 13.7635 7.25289 13.7205L4.86681 11.9296C4.75162 11.8435 4.61169 11.797 4.46791 11.797C4.32412 11.797 4.18419 11.8435 4.069 11.9296L1.67892 13.7198C1.62648 13.7628 1.56219 13.7887 1.49463 13.7942C1.42707 13.7996 1.35945 13.7843 1.30079 13.7504C1.24213 13.7164 1.19522 13.6654 1.16633 13.6041C1.13743 13.5428 1.12791 13.4741 1.13905 13.4072L2.14814 7.72461"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M4.46558 8.46485C6.67418 8.46485 8.4646 6.67442 8.4646 4.46582C8.4646 2.25722 6.67418 0.466797 4.46558 0.466797C2.25698 0.466797 0.466553 2.25722 0.466553 4.46582C0.466553 6.67442 2.25698 8.46485 4.46558 8.46485Z"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                            Built for Indian Conditions
                        </h3>
                        <p
                            class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                            Engineered for Indian pollution profiles &mdash; peak PM2.5,
                            high humidity, dust, and VOC-heavy kitchens &mdash; not
                            re-badged imports.
                        </p>
                    </div>

                    <!-- Feature 05 -->
                    <div
                        class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                        <div class="flex justify-between items-start mb-8 md:mb-12">
                            <span class="text-[12px] text-[#156E8A] font-medium tracking-widest">05</span>
                            <div
                                class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.13159 13.7969C10.8126 13.7969 13.7966 10.8128 13.7966 7.13184C13.7966 3.45084 10.8126 0.466797 7.13159 0.466797C3.45059 0.466797 0.466553 3.45084 0.466553 7.13184C0.466553 10.8128 3.45059 13.7969 7.13159 13.7969Z"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M7.13159 3.13281V7.13184L9.79761 8.46485" stroke="currentColor"
                                        stroke-width="0.933106" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                            Real-Time Auto-Sensing
                        </h3>
                        <p
                            class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                            Onboard PM2.5 and VOC sensors read the room every 2 seconds.
                            Fan speed adjusts automatically. No app required.
                        </p>
                    </div>

                    <!-- Feature 06 -->
                    <div
                        class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                        <div class="flex justify-between items-start mb-8 md:mb-12">
                            <span class="text-[12px] text-[#156E8A] font-medium tracking-widest">06</span>
                            <div
                                class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                <svg width="15" height="13" viewBox="0 0 15 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.7971 7.79834C12.7902 6.82525 13.7966 5.65886 13.7966 4.13257C13.7966 3.16035 13.4104 2.22794 12.723 1.54048C12.0355 0.853011 11.1031 0.466797 10.1309 0.466797C8.95782 0.466797 8.13135 0.800049 7.13159 1.79981C6.13184 0.800049 5.30537 0.466797 4.13233 0.466797C3.1601 0.466797 2.2277 0.853011 1.54023 1.54048C0.852767 2.22794 0.466553 3.16035 0.466553 4.13257C0.466553 5.66553 1.46631 6.83191 2.46607 7.79834L7.13159 12.4639L11.7971 7.79834Z"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7.13164 1.7998L5.15879 3.77266C5.02337 3.90709 4.91589 4.067 4.84255 4.24316C4.76921 4.41932 4.73145 4.60825 4.73145 4.79907C4.73145 4.98989 4.76921 5.17882 4.84255 5.35499C4.91589 5.53115 5.02337 5.69105 5.15879 5.82549C5.70533 6.37202 6.57845 6.39202 7.1583 5.87214L8.53797 4.60579C8.88379 4.29199 9.33403 4.11817 9.80099 4.11817C10.268 4.11817 10.7182 4.29199 11.064 4.60579L13.0369 6.37869"
                                        stroke="currentColor" stroke-width="0.933106" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M11.1306 8.46484L9.79761 7.13184" stroke="currentColor"
                                        stroke-width="0.933106" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.1311 10.4639L7.7981 9.13086" stroke="currentColor"
                                        stroke-width="0.933106" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                            5-Year Warranty & Service
                        </h3>
                        <p
                            class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                            Industry-leading coverage with doorstep filter replacement,
                            annual health checks, and a dedicated concierge line.
                        </p>
                    </div>
                </div>

                <!-- Swiper Pagination (Mobile Only) -->
                <div class="swiper-pagination md:hidden !bottom-0"></div>
            </div>

            <!-- Footer Stats & CTA -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center mt-12 md:mt-16 pt-8 md:pt-10 border-t border-gray-200/80 dark:border-gray-800 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200">
                <!-- Stats Grid -->
                <div
                    class="grid grid-cols-2 md:flex gap-y-8 gap-x-6 md:gap-12 lg:gap-16 w-full md:w-auto mb-10 md:mb-0">
                    <div class="flex flex-col gap-1">
                        <span
                            class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">99.97%</span>
                        <span
                            class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-400 font-medium">Particle
                            Capture</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">28
                            dB</span>
                        <span class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-400 font-medium">Min.
                            Noise Level</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">5
                            Years</span>
                        <span
                            class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-400 font-medium">Warranty</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span
                            class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">50,000+</span>
                        <span
                            class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-400 font-medium">Homes
                            Purified</span>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="#"
                    class="flex items-center justify-center gap-3 bg-[#156E8A] hover:bg-[#11576E] text-white text-[12px] md:text-[13px] uppercase tracking-[0.15em] font-bold px-8 py-4 md:py-3.5 rounded-sm transition-colors w-full md:w-auto shrink-0">
                    <span>Explore All Models</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 16: FINAL CTA (Begin Here)         -->
    <!-- ========================================== -->
    <section
        class="w-full relative overflow-hidden flex flex-col items-center justify-center min-h-[70vh] bg-[#FAFCFD] py-16 md:py-20 px-6 md:px-16 lg:px-24">
        <!-- Mobile-Only Background Image & Dark Overlay -->
        <div class="absolute inset-0 md:hidden z-0">
            <!-- Reusing an existing interior image to match the mockup's aesthetic -->
            <img src="./assets/images/case-study-1.png" alt="Interior Background"
                class="w-full h-full object-cover object-center" />
            <!-- Heavy dark overlay to ensure text legibility -->
            <div class="absolute inset-0 bg-[#0A1216]/90"></div>
        </div>

        <!-- Giant Background Watermark ('B') -->
        <!-- Hidden on mobile to keep the dark theme clean, visible on desktop -->
        <div class="hidden md:flex absolute inset-0 items-center justify-center pointer-events-none select-none z-0">
            <span
                class="text-[400px] lg:text-[600px] font-bold text-gray-900 opacity-[0.02] leading-none transform absolute bottom-[-100px]">B</span>
        </div>

        <!-- Content Container -->
        <div
            class="relative z-10 max-w-5xl mx-auto text-center scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out w-full">
            <!-- Eyebrow -->
            <span
                class="text-[11px] uppercase tracking-[0.25em] text-[#4A99B2] md:text-[#156E8A] font-bold mb-6 md:mb-8 block">
                Begin Here
            </span>

            <!-- Headline -->
            <!-- Mobile: White text. Desktop: Dark text with blue highlight -->
            <h2
                class="text-[34px] md:text-5xl lg:text-7xl font-light tracking-tight text-white md:text-gray-900 leading-[1.2] md:leading-[1.1] mb-6 md:mb-8">
                Every breath your family <br class="md:hidden" />
                takes deserves <br class="hidden md:block" />
                the
                <span class="text-white md:text-[#156E8A] font-normal md:font-medium">right air.</span>
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-300 md:text-gray-500 text-[15px] md:text-base font-light leading-relaxed max-w-2xl mx-auto mb-10 md:mb-14 px-2 md:px-0">
                Protecting your home shouldn't be complicated or expensive.<br class="hidden md:block" />
                Find the right model for your space, or talk to an air-care expert
                <br class="hidden md:block" />
                &mdash; starting at ₹9,999.00.
            </p>

            <!-- CTA Buttons -->
            <!-- Mobile: Stacked vertically. Desktop: Side-by-side -->
            <div
                class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12 w-full max-w-[280px] mx-auto md:max-w-none">
                <!-- Primary Solid Button -->
                <!-- Mobile: White BG, Dark Text. Desktop: Dark BG, White Text -->
                <a href="#"
                    class="bg-white md:bg-[#111111] text-gray-900 md:text-white text-[11px] md:text-[12px] tracking-[0.15em] font-bold uppercase px-8 py-4 md:py-5 hover:bg-gray-100 md:hover:bg-[#156E8A] transition-colors flex items-center justify-center gap-3 rounded-sm shadow-[0_10px_30px_rgba(0,0,0,0.2)] md:shadow-xl md:shadow-gray-200 w-full md:w-auto">
                    <span>Explore Collection</span>
                    <!-- Sleek SVG Arrow -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>

                <!-- Secondary Ghost/Underline Button -->
                <!-- Mobile: Light gray text, tight border. Desktop: Dark text -->
                <a href="./find-my-purifier.html"
                    class="text-gray-300 md:text-gray-900 text-[11px] md:text-[12px] tracking-[0.15em] font-bold uppercase border-b border-gray-600 md:border-gray-300 pb-1.5 md:py-5 hover:border-white md:hover:border-[#156E8A] hover:text-white md:hover:text-[#156E8A] transition-colors mt-2 md:mt-0 w-full md:w-auto text-center md:text-left">
                    Find My Purifier
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>