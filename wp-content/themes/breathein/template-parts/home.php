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
    <?php
    $resolve_home_image = static function ($image, $fallback_alt = '') {
        $data = [
            'url' => '',
            'alt' => $fallback_alt,
        ];

        if (is_array($image)) {
            $data['url'] = !empty($image['url']) ? $image['url'] : '';
            $data['alt'] = !empty($image['alt']) ? $image['alt'] : $fallback_alt;

            if (empty($data['url']) && !empty($image['ID'])) {
                $data['url'] = wp_get_attachment_image_url((int) $image['ID'], 'full');
            }
        } elseif (is_numeric($image)) {
            $data['url'] = wp_get_attachment_image_url((int) $image, 'full');
            $data['alt'] = get_post_meta((int) $image, '_wp_attachment_image_alt', true) ?: $fallback_alt;
        } elseif (is_string($image)) {
            $data['url'] = $image;
        }

        return $data;
    };

    $banner_image_data = $resolve_home_image(get_field('banner_image'), 'Air purifier in a bedroom setup');
    $mobile_banner_image_data = $resolve_home_image(get_field('banner_mobile_image'), $banner_image_data['alt']);
    $banner_image_url = $banner_image_data['url'] ?: get_template_directory_uri() . '/assets/images/air-pro.png';
    $mobile_banner_image_url = $mobile_banner_image_data['url'] ?: $banner_image_url;
    $banner_image_alt = $banner_image_data['alt'] ?: 'Air purifier in a bedroom setup';

    $banner_top_text = get_field('banner_top_text') ?: 'The Right Air<span class="hidden lg:inline text-gray-400">&middot; Made for India</span>';
    $banner_main_text = get_field('banner_main_text') ?: 'Clean air is not a luxury.<br class="hidden lg:block" />It\'s a<span class="text-[#156E8A] font-bold"> necessity.</span>';
    $banner_desc_text = get_field('banner_desc_text') ?: 'Sophisticated Japanese air-purification technology, thoughtfully designed for Indian homes. Starting at &#8377;9,999.';

    $explore_collections_cta = get_field('explore_collections_cta');
    $collection_page = get_page_by_path('collection');
    $explore_url = is_array($explore_collections_cta) && !empty($explore_collections_cta['url'])
        ? $explore_collections_cta['url']
        : ($collection_page ? get_permalink($collection_page) : home_url('/collection/'));
    $explore_title = is_array($explore_collections_cta) && !empty($explore_collections_cta['title'])
        ? $explore_collections_cta['title']
        : 'Explore Collection';
    $explore_target = is_array($explore_collections_cta) && !empty($explore_collections_cta['target'])
        ? $explore_collections_cta['target']
        : '_self';

    $banner_find_my_purifier_cta = get_field('banner_find_my_purifier_cta');
    $find_purifier_page = get_page_by_path('find-my-purifier');
    $find_purifier_url = is_array($banner_find_my_purifier_cta) && !empty($banner_find_my_purifier_cta['url'])
        ? $banner_find_my_purifier_cta['url']
        : ($find_purifier_page ? get_permalink($find_purifier_page) : home_url('/find-my-purifier/'));
    $find_purifier_title = is_array($banner_find_my_purifier_cta) && !empty($banner_find_my_purifier_cta['title'])
        ? $banner_find_my_purifier_cta['title']
        : 'Find My Purifier';
    $find_purifier_target = is_array($banner_find_my_purifier_cta) && !empty($banner_find_my_purifier_cta['target'])
        ? $banner_find_my_purifier_cta['target']
        : '_self';
    ?>
    <section class="w-full relative bg-white border-b border-gray-100">
        <div class="swiper heroSwiper w-full min-h-[100dvh] lg:min-h-[600px]">
            <div class="swiper-wrapper w-full h-full">
                <div class="swiper-slide w-full h-full">
                    <div class="grid grid-cols-1 lg:grid-cols-2 w-full h-screen">
                        <!-- Visual column: top on mobile, right on desktop. -->
                        <div
                            class="relative w-full min-h-[118px] md:min-h-[350px] lg:h-full lg:min-h-full order-1 lg:order-2 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <picture class="absolute inset-0 w-full h-full z-0">
                                <source media="(max-width: 1023px)"
                                    srcset="<?php echo esc_url($mobile_banner_image_url); ?>">
                                <img src="<?php echo esc_url($banner_image_url); ?>"
                                    alt="<?php echo esc_attr($banner_image_alt); ?>"
                                    class="w-full h-full object-cover object-center slide-product opacity-0 transition-all duration-1000 ease-out delay-200" />
                            </picture>
                        </div>

                        <!-- Text column: bottom on mobile, left on desktop. -->
                        <div
                            class="bg-white text-gray-900 flex flex-col justify-center px-6 py-5 md:py-10 lg:px-16 lg:pl-[10%] lg:pr-16 relative order-2 lg:order-1">
                            <div
                                class="slide-content w-full opacity-0 translate-y-8 transition-all duration-700 ease-out delay-300 max-w-xl mx-auto lg:mx-0">
                                <div class="flex items-center gap-3 lg:gap-4 mb-4 lg:mb-6">
                                    <div class="hidden lg:block w-8 h-[1px] bg-gray-300"></div>
                                    <span class="text-[11px] tracking-[0.2em] uppercase text-[#156E8A] font-bold">
                                        <span class="lg:hidden">Breathe In &mdash; </span>
                                        <?php echo wp_kses_post($banner_top_text); ?>
                                    </span>
                                </div>

                                <h1
                                    class="text-[32px] sm:text-4xl lg:text-6xl xl:text-7xl font-light tracking-tight leading-[1.15] lg:leading-[1.1] mb-4 lg:mb-6">
                                    <?php echo wp_kses_post($banner_main_text); ?>
                                </h1>

                                <p
                                    class="text-gray-500 text-[15px] lg:text-[15px] leading-relaxed mb-8 lg:mb-10 font-light lg:pr-10">
                                    <?php echo wp_kses_post($banner_desc_text); ?>
                                </p>

                                <!-- Kept dynamic for future mobile variants; hidden as in the supplied design. -->
                                <div
                                    class="hidden w-full bg-[#F2F6F8] rounded-2xl py-10 flex justify-center items-center mb-8">
                                    <img src="<?php echo esc_url($banner_image_url); ?>"
                                        alt="<?php echo esc_attr($banner_image_alt); ?>"
                                        class="h-[200px] object-contain drop-shadow-md" />
                                </div>

                                <div
                                    class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3 lg:gap-8 w-full">
                                    <a href="<?php echo esc_url($explore_url); ?>"
                                        target="<?php echo esc_attr($explore_target); ?>"
                                        class="bg-[#111111] text-white text-[12px] tracking-[0.15em] font-bold uppercase px-6 lg:px-8 py-5 lg:py-4 hover:bg-[#156E8A] transition-colors flex items-center justify-between lg:justify-center gap-3 rounded-xl w-full lg:w-auto">
                                        <span><?php echo esc_html($explore_title); ?></span>
                                        <span aria-hidden="true">&rarr;</span>
                                    </a>

                                    <a href="<?php echo esc_url($find_purifier_url); ?>"
                                        target="<?php echo esc_attr($find_purifier_target); ?>"
                                        class="bg-[#FAFCFD] border border-gray-100 lg:bg-transparent lg:border-0 lg:border-b lg:border-gray-900 text-gray-900 text-[12px] tracking-[0.15em] font-bold uppercase px-6 lg:px-0 py-5 lg:py-1 hover:text-[#156E8A] hover:border-[#156E8A] transition-colors flex items-center justify-between lg:justify-center gap-3 rounded-xl lg:rounded-none w-full lg:w-auto">
                                        <span><?php echo esc_html($find_purifier_title); ?></span>
                                        <span class="lg:hidden text-gray-400 font-light"
                                            aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>

                                <div class="flex lg:hidden items-center gap-4 opacity-40 w-full mt-6">
                                    <div class="w-8 h-[1px] bg-gray-400"></div>
                                    <span class="text-[8px] tracking-[0.2em] uppercase text-gray-500 font-bold">Scroll
                                        to explore</span>
                                </div>
                            </div>

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
    <?php
    $problem_bg_image = function_exists('get_field') ? get_field('problem_bg_image') : null;
    $problem_bg_url = '';
    if (is_array($problem_bg_image) && !empty($problem_bg_image['url'])) {
        $problem_bg_url = $problem_bg_image['url'];
    } elseif (is_string($problem_bg_image) && !empty($problem_bg_image)) {
        $problem_bg_url = $problem_bg_image;
    } else {
        $problem_bg_url = content_url('/uploads/2026/08/section-invisible-bg.png');
    }

    $problem_eyebrow = function_exists('get_field') && get_field('problem_header_1')
        ? get_field('problem_header_1')
        : 'THE AIR INSIDE YOUR HOME';

    $problem_heading_1 = function_exists('get_field') && get_field('problem_heading_1')
        ? get_field('problem_heading_1')
        : 'Every breath carries';

    $problem_heading_highlight = function_exists('get_field') && get_field('problem_heading_highlight')
        ? get_field('problem_heading_highlight')
        : (function_exists('get_field') && get_field('problem_header_2') ? get_field('problem_header_2') : 'invisible pollutants.');

    $problem_desc = function_exists('get_field') && get_field('problem_desc')
        ? get_field('problem_desc')
        : 'What you can\'t see may affect sleep, comfort and everyday well being.';

    $find_purifier_cta = function_exists('get_field') ? get_field('banner_find_my_purifier_cta') : null;
    $find_purifier_page = get_page_by_path('find-my-purifier');
    $find_purifier_url = is_array($find_purifier_cta) && !empty($find_purifier_cta['url'])
        ? $find_purifier_cta['url']
        : ($find_purifier_page ? get_permalink($find_purifier_page) : home_url('/find-my-purifier/'));
    $find_purifier_title = is_array($find_purifier_cta) && !empty($find_purifier_cta['title'])
        ? $find_purifier_cta['title']
        : 'FIND MY PURIFIER';

    $whatsapp_button = function_exists('get_field') ? get_field('whatsapp_talk_expert', 'option') : null;
    $whatsapp_url = is_array($whatsapp_button) && !empty($whatsapp_button['url'])
        ? $whatsapp_button['url']
        : (function_exists('get_field') && get_field('whatsapp_url', 'option') ? get_field('whatsapp_url', 'option') : 'https://wa.me/919076636639');
    ?>
    <section
        class="w-full bg-[#030608] text-white py-16 md:py-24 lg:py-28 px-6 md:px-12 lg:px-20 relative overflow-hidden bg-cover bg-right md:bg-center bg-no-repeat min-h-[620px] lg:min-h-[740px] flex items-center"
        style="background-image: url('<?php echo esc_url($problem_bg_url); ?>');">

        <!-- Subtle dark gradient on mobile for readability -->
        <div
            class="absolute inset-0 bg-gradient-to-r from-[#030608] via-[#030608]/85 to-transparent pointer-events-none lg:opacity-75">
        </div>

        <div class="max-w-7xl mx-auto relative z-10 w-full">
            <div class="max-w-xl lg:max-w-2xl text-left">
                <!-- Eyebrow -->
                <div class="mb-4 scroll-reveal opacity-0 translate-y-4 transition-all duration-700 ease-out">
                    <span
                        class="text-[11px] md:text-[12px] tracking-[0.25em] uppercase text-[#209EC7] font-semibold block">
                        <?php echo esc_html($problem_eyebrow); ?>
                    </span>
                </div>

                <!-- Headline -->
                <h2
                    class="text-[32px] sm:text-[44px] md:text-[50px] lg:text-[56px] xl:text-[62px] font-normal tracking-tight mb-4 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-100 leading-[1.15] text-white">
                    <?php echo wp_kses_post($problem_heading_highlight); ?>
                </h2>

                <!-- Subtext -->
                <p
                    class="text-gray-300 md:text-gray-400 text-xs sm:text-[14px] font-light leading-relaxed mb-8 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-200">
                    <?php echo esc_html($problem_desc); ?>
                </p>

                <!-- Divider Line -->
                <div
                    class="w-full h-px bg-white/10 mb-8 sm:mb-10 scroll-reveal opacity-0 transition-all duration-700 delay-300">
                </div>

                <!-- Stats Grid: 3 columns clean left aligned -->
                <div
                    class="grid grid-cols-3 gap-4 sm:gap-8 mb-10 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-400">
                    <!-- Stat 1 -->
                    <div class="flex flex-col">
                        <span
                            class="text-[#209EC7] text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-light tracking-tight leading-none mb-3">
                            14/20
                        </span>
                        <span
                            class="text-gray-400 text-[9px] sm:text-[11px] tracking-[0.12em] uppercase font-normal leading-snug">
                            Of the world's most polluted cities are in India
                        </span>
                    </div>

                    <!-- Stat 2 -->
                    <div class="flex flex-col">
                        <span
                            class="text-[#209EC7] text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-light tracking-tight leading-none mb-3">
                            2&ndash;5&times;
                        </span>
                        <span
                            class="text-gray-400 text-[9px] sm:text-[11px] tracking-[0.12em] uppercase font-normal leading-snug">
                            More polluted indoors than outside
                        </span>
                    </div>

                    <!-- Stat 3 -->
                    <div class="flex flex-col">
                        <span
                            class="text-[#209EC7] text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-light tracking-tight leading-none mb-3">
                            5&ndash;7 yrs
                        </span>
                        <span
                            class="text-gray-400 text-[9px] sm:text-[11px] tracking-[0.12em] uppercase font-normal leading-snug">
                            Of life lost to sustained air-pollution exposure
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="flex flex-wrap items-center gap-6 sm:gap-8 scroll-reveal opacity-0 transition-all duration-700 ease-out delay-500">
                    <a href="<?php echo esc_url($find_purifier_url); ?>"
                        class="inline-flex items-center gap-3 bg-[#156E8A] hover:bg-[#1B84A5] text-white text-[11px] sm:text-[12px] font-bold uppercase tracking-[0.15em] px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-[#156E8A]/25">
                        <span><?php echo esc_html($find_purifier_title); ?></span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>

                    <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center text-white hover:text-[#209EC7] text-[11px] sm:text-[12px] font-bold uppercase tracking-[0.15em] border-b border-gray-600 hover:border-[#209EC7] pb-1 transition-colors">
                        <span><?php esc_html_e('TALK TO EXPERT', 'breathein'); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================================== -->
    <!-- SECTION: OUR PARTNERS                      -->
    <!-- ========================================== -->
    <!-- Removed borders on mobile (md:border-t md:border-b), tightened padding -->
    <section class="w-full py-4 md:py-8">
        <div
            class="max-w-6xl mx-auto px-6 overflow-x-auto no-scrollbar scroll-reveal opacity-0 transition-all duration-700 ease-out">
            <!-- Single Unified Container -->
            <!-- flex-wrap forces the 100% width text to push the logos to the next line on mobile -->
            <div
                class="flex flex-wrap md:flex-nowrap items-center justify-between md:justify-center gap-y-6 md:gap-8 min-w-full md:min-w-max mx-auto py-2">
                <!-- Static heading -->
                <span
                    class="w-full md:w-auto text-left md:text-center text-[12px] md:text-xl lg:text-2xl uppercase md:normal-case tracking-[0.2em] md:tracking-wide font-bold md:font-light shrink-0 leading-none">
                    Our Partners
                </span>

                <?php if (have_rows('other_partners')): ?>
                    <?php while (have_rows('other_partners')):
                        the_row(); ?>
                        <?php $partner_image = get_sub_field('brand_image_png'); ?>
                        <?php if ($partner_image): ?>
                            <!-- <div
                                class="hidden md:block w-[1px] h-6 bg-gray-700 shrink-0"></div> -->
                            <img src="<?php echo esc_url($partner_image['url']); ?>"
                                alt="<?php echo esc_attr($partner_image['alt'] ?? 'Partner logo'); ?>"
                                class="h-5 md:h-8 w-auto opacity-80 md:opacity-70 hover:opacity-100 transition-opacity duration-300 shrink-0 object-contain">

                        <?php endif; ?>

                    <?php endwhile; ?>

                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php
    $business_eyebrow = get_field('business_eyebrow') ?: 'For Business';
    $business_heading = get_field('business_heading') ?: 'Purifying offices, clinics &';
    $business_heading_highlight = get_field('business_heading_highlight') ?: 'hotels.';
    $business_description = get_field('business_description') ?: 'Bulk pricing and dedicated support';
    $business_watermark = get_field('business_watermark') ?: 'B';
    $business_cta = get_field('business_cta');
    $business_demo_page = get_page_by_path('book-a-demo', OBJECT, 'page');
    $business_cta_url = is_array($business_cta) && !empty($business_cta['url'])
        ? $business_cta['url']
        : ($business_demo_page ? get_permalink($business_demo_page) : home_url('/book-a-demo/'));
    $business_cta_title = is_array($business_cta) && !empty($business_cta['title'])
        ? $business_cta['title']
        : 'Talk to Sales';
    $business_cta_target = is_array($business_cta) && !empty($business_cta['target'])
        ? $business_cta['target']
        : '_self';
    ?>
    <!-- ========================================== -->
    <!-- SECTION: FOR BUSINESS                      -->
    <!-- ========================================== -->
    <section
        class="w-full relative overflow-hidden flex flex-col items-center justify-center min-h-[50vh] bg-[#FAFCFD] py-16 md:py-20 px-6 md:px-16 lg:px-24">
        <span
            class="text-[11px] text-left md:text-center uppercase tracking-[0.25em] text-[#4A99B2] md:text-[#156E8A] font-bold mb-6 md:mb-8 block w-full">
            <?php echo esc_html($business_eyebrow); ?>
        </span>

        <div class="hidden md:flex absolute inset-0 items-center justify-center pointer-events-none select-none z-0">
            <span
                class="text-[400px] lg:text-[600px] font-bold text-gray-900 opacity-[0.02] leading-none transform absolute bottom-[-100px]"><?php echo esc_html($business_watermark); ?></span>
        </div>

        <div
            class="relative z-10 max-w-5xl mx-auto md:text-center scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out w-full">
            <h2
                class="text-[34px] md:text-5xl lg:text-7xl font-light tracking-tight text-gray-900 leading-[1.2] md:leading-[1.1] mb-6 md:mb-8">
                <?php echo esc_html($business_heading); ?>
                <span
                    class="text-[#156E8A] font-normal md:font-medium"><?php echo esc_html($business_heading_highlight); ?></span>
            </h2>

            <p
                class="text-gray-300 md:text-gray-500 text-[15px] md:text-base font-light leading-relaxed max-w-2xl mx-auto mb-10 md:mb-14 px-2 md:px-0">
                <?php echo esc_html($business_description); ?>
            </p>

            <div
                class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12 w-full md:max-w-[280px] mx-auto md:max-w-none">
                <a href="<?php echo esc_url($business_cta_url); ?>"
                    target="<?php echo esc_attr($business_cta_target); ?>"
                    class="bg-[#111111] text-white text-[12px] tracking-[0.15em] font-bold uppercase px-8 py-4 md:py-5 hover:bg-gray-100 md:hover:bg-[#156E8A] transition-colors flex items-center justify-between md:justify-center gap-3 rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.2)] md:shadow-xl md:shadow-gray-200 w-full md:w-auto">
                    <span><?php echo esc_html($business_cta_title); ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <?php
    $matcher_products = function_exists('breathein_get_matcher_products')
        ? breathein_get_matcher_products()
        : [];

    $matcher_slider_min = 100;
    $matcher_slider_max = 1500;
    $matcher_slider_value = 600;

    if ($matcher_products) {
        $largest_match = $matcher_products[count($matcher_products) - 1];
        $matcher_slider_max = max(
            $matcher_slider_min,
            (int) $largest_match['coverage']
        );
        $matcher_slider_value = min(
            $matcher_slider_value,
            $matcher_slider_max
        );
    }

    $initial_match = function_exists('breathein_find_matcher_product')
        ? breathein_find_matcher_product(
            $matcher_products,
            $matcher_slider_value
        )
        : null;

    $initial_product_id = $initial_match
        ? (int) $initial_match['product']->get_id()
        : 0;
    ?>

    <!-- ========================================== -->
    <!-- SECTION 5: FIND YOUR MATCH                 -->
    <!-- ========================================== -->
    <section id="find-your-match" data-product-matcher
        class="w-full bg-white relative py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
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
                            <label for="roomAreaSlider"
                                class="text-[12px] uppercase tracking-widest text-gray-400 font-bold">
                                Room Area
                            </label>
                            <span class="text-2xl font-light text-gray-900">
                                <output id="roomAreaValue" for="roomAreaSlider">
                                    <?php echo esc_html(number_format_i18n($matcher_slider_value)); ?>
                                </output>
                                <span class="text-sm text-gray-400">sq ft</span>
                            </span>
                        </div>

                        <p id="matcherSliderHelp" class="sr-only">
                            <?php esc_html_e(
                                'Choose your room area. The recommended purifier updates automatically.',
                                'breathein'
                            ); ?>
                        </p>
                        <p id="matcherStatus" class="sr-only" aria-live="polite" aria-atomic="true"></p>

                        <div class="relative w-full h-8 flex items-center">
                            <input type="range" id="roomAreaSlider"
                                min="<?php echo esc_attr((string) $matcher_slider_min); ?>"
                                max="<?php echo esc_attr((string) $matcher_slider_max); ?>" step="10"
                                value="<?php echo esc_attr((string) $matcher_slider_value); ?>"
                                aria-describedby="matcherSliderHelp matcherStatus"
                                class="w-full custom-slider focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brandTeal"
                                <?php disabled(!$matcher_products); ?> />
                        </div>
                    </div>
                </div>

                <div class="scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-200">
                    <?php if ($matcher_products): ?>
                        <?php foreach ($matcher_products as $match): ?>
                            <?php
                            $matched_product = $match['product'];
                            $matched_product_id = (int) $matched_product->get_id();
                            $matched_product_name = $matched_product->get_name();
                            $matched_product_summary = wp_trim_words(
                                wp_strip_all_tags(
                                    (string) (
                                        $matched_product->get_short_description()
                                        ?: $matched_product->get_description()
                                    )
                                ),
                                28,
                                '…'
                            );
                            $matched_product_image_id = (int) $matched_product->get_image_id();
                            $matched_product_price = $matched_product->get_price_html();
                            $is_initial_match = $matched_product_id === $initial_product_id;
                            ?>
                            <article data-matcher-product data-coverage="<?php echo esc_attr((string) $match['coverage']); ?>"
                                data-product-id="<?php echo esc_attr((string) $matched_product_id); ?>"
                                data-product-name="<?php echo esc_attr($matched_product_name); ?>"
                                class="bg-[#F7F9FA] border border-gray-200 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col h-full<?php echo $is_initial_match ? '' : ' hidden'; ?>"
                                <?php if (!$is_initial_match): ?> hidden aria-hidden="true" <?php endif; ?>>
                                <div class="p-6 md:p-8 border-b border-[#DCE4E7] bg-[#F7F9FA] z-10 relative">
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="w-2 h-2 rounded-full bg-[#75C282]"></span>
                                        <span class="text-[12px] uppercase tracking-[0.15em] font-bold text-[#75C282]">Your
                                            Match</span>
                                    </div>
                                    <h3 class="text-4xl font-light text-gray-900 mb-2">
                                        <?php echo esc_html($matched_product_name); ?>
                                    </h3>
                                    <p class="text-sm text-gray-500 font-light">
                                        <?php
                                        echo $matched_product_summary !== ''
                                            ? esc_html($matched_product_summary)
                                            : esc_html__(
                                                'View this purifier for complete product details.',
                                                'breathein'
                                            );
                                        ?>
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

                                    <?php
                                    $matcher_image_attributes = [
                                        'class' => 'h-[200px] max-w-[70%] w-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500 relative z-10',
                                        'loading' => 'lazy',
                                        'decoding' => 'async',
                                    ];

                                    if ($matched_product_image_id) {
                                        echo wp_get_attachment_image(
                                            $matched_product_image_id,
                                            'woocommerce_single',
                                            false,
                                            $matcher_image_attributes
                                        );
                                    } elseif (function_exists('wc_placeholder_img')) {
                                        echo wc_placeholder_img(
                                            'woocommerce_single',
                                            $matcher_image_attributes
                                        );
                                    }
                                    ?>
                                </div>

                                <div
                                    class="grid grid-cols-3 divide-x divide-gray-200 border-t border-b border-gray-200 bg-[#F7F9FA]">
                                    <div class="flex flex-col items-center justify-center text-center p-3 md:p-6 h-full">
                                        <span class="text-[14px] font-medium text-gray-900 mb-2">
                                            <?php
                                            echo esc_html(
                                                sprintf(
                                                    __('%s sq ft', 'breathein'),
                                                    number_format_i18n((int) $match['coverage'])
                                                )
                                            );
                                            ?>
                                        </span>
                                        <span
                                            class="text-[11px] uppercase tracking-[0.15em] text-[#A3A3A3] font-bold">Coverage</span>
                                    </div>
                                    <div class="flex flex-col items-center justify-center text-center p-3 md:p-6 h-full">
                                        <span class="text-[14px] font-medium text-gray-900 mb-2">
                                            <?php
                                            echo $match['ideal_for'] !== ''
                                                ? esc_html($match['ideal_for'])
                                                : '&mdash;';
                                            ?>
                                        </span>
                                        <span class="text-[11px] uppercase tracking-[0.15em] text-[#A3A3A3] font-bold">Ideal
                                            For</span>
                                    </div>
                                    <div class="flex flex-col items-center justify-center text-center p-3 md:p-6 h-full">
                                        <span class="text-[14px] font-medium text-gray-900 mb-2">
                                            <?php
                                            echo $match['filtration'] !== ''
                                                ? esc_html($match['filtration'])
                                                : '&mdash;';
                                            ?>
                                        </span>
                                        <span
                                            class="text-[11px] uppercase tracking-[0.15em] text-[#A3A3A3] font-bold">Filtration</span>
                                    </div>
                                </div>

                                <div class="p-6 md:p-8 flex items-center justify-between mt-auto bg-white">
                                    <div class="flex flex-col">
                                        <span class="text-[12px] text-gray-400 font-light mb-1">
                                            <?php esc_html_e('Price', 'breathein'); ?>
                                        </span>
                                        <span class="text-2xl font-medium text-gray-900 tracking-tight">
                                            <?php
                                            echo $matched_product_price !== ''
                                                ? wp_kses_post($matched_product_price)
                                                : esc_html__('Contact for price', 'breathein');
                                            ?>
                                        </span>
                                    </div>
                                    <a href="<?php echo esc_url($matched_product->get_permalink()); ?>"
                                        class="bg-[#111111] text-white text-[12px] tracking-[0.15em] font-bold uppercase px-6 py-4 hover:bg-brandTeal transition-colors flex items-center gap-3 rounded-xl shadow-md">
                                        <span>
                                            <?php
                                            echo esc_html(
                                                sprintf(
                                                    __('View %s', 'breathein'),
                                                    $matched_product_name
                                                )
                                            );
                                            ?>
                                        </span>
                                        <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div
                            class="bg-[#F7F9FA] border border-gray-200 rounded-xl p-8 md:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-center min-h-[420px]">
                            <span class="text-[11px] uppercase tracking-[0.15em] font-bold text-brandTeal mb-4">
                                <?php esc_html_e('Find Your Match', 'breathein'); ?>
                            </span>
                            <h3 class="text-2xl md:text-3xl font-light text-gray-900 mb-4">
                                <?php esc_html_e('No matcher products are configured yet.', 'breathein'); ?>
                            </h3>
                            <p class="text-sm text-gray-500 font-light leading-relaxed">
                                <?php
                                echo (
                                    current_user_can('manage_woocommerce')
                                    || current_user_can('activate_plugins')
                                )
                                    ? esc_html__(
                                        'Install or activate WooCommerce, publish a product, and add its Matcher coverage value in Product data → General.',
                                        'breathein'
                                    )
                                    : esc_html__(
                                        'Our purifier recommendations will be available soon.',
                                        'breathein'
                                    );
                                ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($matcher_products): ?>
                <?php
                $matcher_form_status = isset($_GET['matcher_status'])
                    && is_string($_GET['matcher_status'])
                    ? sanitize_key(wp_unslash($_GET['matcher_status']))
                    : '';
                $matcher_form_messages = [
                    'success' => __(
                        'Thank you. Your recommendation request was sent successfully.',
                        'breathein'
                    ),
                    'invalid' => __(
                        'Please enter a valid email and phone number, then try again.',
                        'breathein'
                    ),
                    'rate_limited' => __(
                        'Your request was already sent. Please wait a minute before trying again.',
                        'breathein'
                    ),
                    'mail_error' => __(
                        'We could not send your request right now. Please try again shortly.',
                        'breathein'
                    ),
                ];
                $matcher_form_message = $matcher_form_messages[$matcher_form_status] ?? '';
                $matcher_form_succeeded = $matcher_form_status === 'success';
                $matcher_form_role = $matcher_form_succeeded
                    ? 'status'
                    : 'alert';
                $matcher_form_classes = $matcher_form_succeeded
                    ? 'border-green-200 bg-green-50 text-green-800'
                    : 'border-red-200 bg-red-50 text-red-800';
                ?>
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

                    <?php if ($matcher_form_message !== ''): ?>
                        <div role="<?php echo esc_attr($matcher_form_role); ?>"
                            class="mb-5 rounded-xl border px-4 py-3 text-sm <?php echo esc_attr($matcher_form_classes); ?>">
                            <?php echo esc_html($matcher_form_message); ?>
                        </div>
                    <?php endif; ?>

                    <form data-matcher-lead-form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post"
                        accept-charset="UTF-8" class="flex flex-col md:flex-row gap-4 w-full items-stretch">
                        <input type="hidden" name="action" value="breathein_matcher_lead" />
                        <?php
                        wp_nonce_field(
                            'breathein_matcher_lead_submit',
                            'breathein_matcher_nonce',
                            false
                        );
                        ?>
                        <input type="hidden" id="matcherProductId" name="matched_product_id"
                            value="<?php echo esc_attr((string) $initial_product_id); ?>" />
                        <input type="hidden" id="matcherRoomArea" name="room_area_sq_ft"
                            value="<?php echo esc_attr((string) $matcher_slider_value); ?>" />

                        <div class="hidden" aria-hidden="true">
                            <label for="matcherCompanyWebsite">
                                <?php esc_html_e('Company website', 'breathein'); ?>
                            </label>
                            <input id="matcherCompanyWebsite" name="company_website" type="text" tabindex="-1"
                                autocomplete="off" />
                        </div>

                        <label for="matcherEmail" class="sr-only">
                            <?php esc_html_e('Email address', 'breathein'); ?>
                        </label>
                        <input id="matcherEmail" name="email" type="email" autocomplete="email" maxlength="254"
                            placeholder="Email address" required
                            class="flex-1 px-5 py-3.5 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-brandTeal focus:ring-1 focus:ring-brandTeal transition-all placeholder:text-gray-400 shadow-sm" />

                        <label for="matcherPhone" class="sr-only">
                            <?php esc_html_e('Phone number', 'breathein'); ?>
                        </label>
                        <input id="matcherPhone" name="phone" type="tel" autocomplete="tel" inputmode="tel" minlength="7"
                            maxlength="25" placeholder="Phone (+91)" required
                            class="flex-1 px-5 py-3.5 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-brandTeal focus:ring-1 focus:ring-brandTeal transition-all placeholder:text-gray-400 shadow-sm" />

                        <button type="submit"
                            class="bg-[#111111] text-white text-[12px] tracking-widest font-bold uppercase px-8 py-3.5 hover:bg-brandTeal transition-colors rounded-xl shrink-0 shadow-sm">
                            Send My Match
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php get_template_part('template-parts/home-collection'); ?>

    <?php
    $cam_page_id = (int) get_option('page_on_front');

    if (!$cam_page_id) {
        $cam_page_id = get_queried_object_id();
    }

    $cam_header = function_exists('get_field')
        ? get_field('cam_header', $cam_page_id)
        : '';
    $cam_desc = function_exists('get_field')
        ? get_field('cam_desc', $cam_page_id)
        : '';
    ?>

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
                <?php echo wp_kses_post((string) $cam_header); ?>
            </h2>

            <!-- Subtext -->
            <p
                class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
                <?php echo wp_kses_post((string) $cam_desc); ?>
            </p>
        </div>

        <!-- ========================================================= -->
        <!-- UNIFIED SWIPER / GRID STRUCTURE                           -->
        <!-- ========================================================= -->
        <div
            class="swiper benefitsSwiper max-w-[1400px] mx-auto pb-12 md:pb-0 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100 relative overflow-visible md:overflow-hidden">
            <!-- Wrapper: Flex for Swiper on Mobile, Grid on Desktop -->
            <?php if (function_exists('have_rows') && have_rows('cam_repeater', $cam_page_id)): ?>

                <div class="swiper-wrapper md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-1.5 items-stretch">

                    <?php
                    $card_index = 0;

                    while (have_rows('cam_repeater', $cam_page_id)):
                        the_row();

                        // These names match the ACF subfield names configured on the front page.
                        $card_image = get_sub_field('cam_repeter_');
                        $card_head = get_sub_field('cam_repeater_');
                        $card_desc = get_sub_field('cam_repeater_desc');

                        $card_image_id = is_array($card_image)
                            ? absint($card_image['ID'] ?? $card_image['id'] ?? 0)
                            : absint($card_image);
                        $card_image_url = is_array($card_image)
                            ? ($card_image['url'] ?? '')
                            : (is_string($card_image) && !$card_image_id ? $card_image : '');
                        $card_image_alt = is_array($card_image) && !empty($card_image['alt'])
                            ? $card_image['alt']
                            : $card_head;
                        ?>

                        <div class="swiper-slide h-auto">
                            <div
                                class="relative w-full h-full aspect-[4/5] lg:aspect-[3/4] group overflow-hidden rounded-xl md:rounded-none">

                                <?php if ($card_image_id): ?>
                                    <?php
                                    echo wp_get_attachment_image(
                                        $card_image_id,
                                        'large',
                                        false,
                                        [
                                            'alt' => $card_image_alt,
                                            'class' => 'absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700',
                                            'loading' => 'lazy',
                                            'decoding' => 'async',
                                            'sizes' => '(min-width: 1024px) 25vw, (min-width: 768px) 50vw, 85vw',
                                        ]
                                    );
                                    ?>
                                <?php elseif ($card_image_url): ?>
                                    <img src="<?php echo esc_url($card_image_url); ?>"
                                        alt="<?php echo esc_attr($card_image_alt); ?>" loading="lazy" decoding="async"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                <?php endif; ?>

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#090D10] via-[#090D10]/50 to-transparent opacity-90">
                                </div>

                                <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end text-left">

                                    <div class="text-brandTeal mb-4">

                                        <?php if ($card_index === 0): ?>

                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M14 4C9 4 6 8 6 12C6 17.5 14 28 14 28C14 28 22 17.5 22 12C22 8 19 4 14 4Z"
                                                    stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />

                                                <path
                                                    d="M14 15C15.6569 15 17 13.6569 17 12C17 10.3431 15.6569 9 14 9C12.3431 9 11 10.3431 11 12C11 13.6569 12.3431 15 14 15Z"
                                                    stroke="currentColor" stroke-width="1.2" />
                                            </svg>

                                        <?php elseif ($card_index === 1): ?>

                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>

                                        <?php elseif ($card_index === 2): ?>

                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path
                                                    d="M14.0002 5C9.0002 5 6.0002 9 7.0002 13C8.0002 18 14.0002 24 14.0002 24C14.0002 24 20.0002 18 21.0002 13C22.0002 9 19.0002 5 14.0002 5Z"
                                                    stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                        <?php else: ?>

                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M5 8H23M5 14H23M5 20H17" stroke="currentColor" stroke-width="1.2"
                                                    stroke-linecap="round" />
                                            </svg>

                                        <?php endif; ?>

                                    </div>

                                    <?php if ($card_head): ?>
                                        <h3 class="text-white text-xl md:text-2xl font-light mb-2.5">
                                            <?php echo esc_html($card_head); ?>
                                        </h3>
                                    <?php endif; ?>

                                    <?php if ($card_desc): ?>
                                        <p
                                            class="text-gray-300 text-[11px] md:text-xs font-light leading-relaxed opacity-90 md:opacity-80">
                                            <?php echo wp_kses_post((string) $card_desc); ?>
                                        </p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                        <?php $card_index++; ?>

                    <?php endwhile; ?>

                </div>

            <?php endif; ?>

            <!-- Swiper Pagination (Mobile Only) -->
            <div class="swiper-pagination md:hidden !bottom-0"></div>
        </div>
    </section>

    <?php
    $inside_unit_page_id = (int) get_option('page_on_front');

    if (!$inside_unit_page_id) {
        $inside_unit_page_id = get_queried_object_id();
    }

    $inside_unit_eyebrow = '';
    $inside_unit_heading = '';
    $inside_unit_description = '';
    $inside_unit_stages = [];
    $inside_unit_authority = [];

    if (function_exists('get_field')) {
        $inside_unit_eyebrow = (string) get_field('inside_unit_eyebrow', $inside_unit_page_id);
        $inside_unit_heading = (string) get_field('inside_unit_heading', $inside_unit_page_id);
        $inside_unit_description = (string) get_field('inside_unit_description', $inside_unit_page_id);
        $inside_unit_stages = get_field('inside_unit_stages', $inside_unit_page_id);
        $inside_unit_authority = get_field('inside_unit_authority', $inside_unit_page_id);
    }

    if (!is_array($inside_unit_stages)) {
        $inside_unit_stages = [];
    }

    if (!is_array($inside_unit_authority)) {
        $inside_unit_authority = [];
    }

    $inside_unit_badge_value = (string) (
        $inside_unit_authority['inside_unit_badge_value'] ?? ''
    );
    $inside_unit_badge_label = (string) (
        $inside_unit_authority['inside_unit_badge_label'] ?? ''
    );
    $inside_unit_authority_heading = (string) (
        $inside_unit_authority['inside_unit_authority_heading'] ?? ''
    );
    $inside_unit_authority_description = (string) (
        $inside_unit_authority['inside_unit_authority_description'] ?? ''
    );

    $inside_unit_has_content = $inside_unit_eyebrow
        || $inside_unit_heading
        || $inside_unit_description
        || $inside_unit_stages
        || $inside_unit_authority;
    ?>

    <!-- ========================================== -->
    <!-- SECTION 8: TECHNOLOGY & FILTRATION         -->
    <!-- ========================================== -->
    <?php if ($inside_unit_has_content): ?>
        <section class="w-full bg-[#FAFCFD] py-16 md:py-32 px-6 md:px-16 lg:px-24">
            <!-- Header Section (Responsive Alignment) -->
            <div
                class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <!-- Eyebrow -->
                <?php if ($inside_unit_eyebrow): ?>
                    <span
                        class="text-[11px] md:text-[8px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                        <?php echo esc_html($inside_unit_eyebrow); ?>
                    </span>
                <?php endif; ?>

                <!-- Headline -->
                <?php if ($inside_unit_heading): ?>
                    <h2
                        class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                        <?php echo esc_html($inside_unit_heading); ?>
                    </h2>
                <?php endif; ?>

                <!-- Subtext -->
                <?php if ($inside_unit_description): ?>
                    <p
                        class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
                        <?php echo esc_html($inside_unit_description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ($inside_unit_stages): ?>
                <!-- Mobile: Transparent background, divided list. Desktop: White card, shadow, side-by-side grid -->
                <div
                    class="max-w-6xl mx-auto bg-transparent md:bg-white border-0 md:border md:border-gray-100 md:shadow-[0_4px_20px_rgb(0,0,0,0.02)] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y divide-gray-200/80 md:divide-y-0 md:divide-x md:divide-gray-100 mb-12 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
                    <?php
                    $inside_unit_stage_classes = [
                        'py-6 md:p-10 flex flex-col h-full lg:border-b-0 border-gray-100 md:border-b',
                        'py-6 md:p-10 flex flex-col h-full lg:border-b-0 border-gray-100 md:border-b',
                        'py-6 md:p-10 flex flex-col h-full lg:border-t-0 lg:border-b-0 border-gray-100 border-t',
                        'py-6 md:p-10 flex flex-col h-full lg:border-t-0 border-gray-100 border-t',
                    ];

                    foreach (array_values($inside_unit_stages) as $stage_index => $stage):
                        if (!is_array($stage)) {
                            continue;
                        }

                        $stage_icon = sanitize_key(
                            (string) ($stage['inside_unit_stage_icon'] ?? '')
                        );
                        $stage_title = (string) (
                            $stage['inside_unit_stage_title'] ?? ''
                        );
                        $stage_description = (string) (
                            $stage['inside_unit_stage_description'] ?? ''
                        );
                        $stage_class = $inside_unit_stage_classes[$stage_index]
                            ?? 'py-6 md:p-10 flex flex-col h-full border-gray-100';
                        ?>
                        <div class="<?php echo esc_attr($stage_class); ?>">
                            <div class="flex items-start md:block mb-1.5 md:mb-4">
                                <span
                                    class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">
                                    <?php echo esc_html(sprintf('%02d', $stage_index + 1)); ?>
                                </span>

                                <?php if ('capture' === $stage_icon): ?>
                                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                        <path d="M8 14H36M12 22H32M16 30H28" stroke="#141414" stroke-width="1.4"
                                            stroke-linecap="round" />
                                    </svg>
                                <?php elseif ('filter' === $stage_icon): ?>
                                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
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
                                <?php elseif ('neutralise' === $stage_icon): ?>
                                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                        <path d="M22 8V16M16 11L20 15M28 11L24 15M12 22H8M22 36V28M32 22H36M16 33L20 29M28 33L24 29"
                                            stroke="#141414" stroke-width="1.4" stroke-linecap="round" />
                                        <path
                                            d="M22 27C24.7614 27 27 24.7614 27 22C27 19.2386 24.7614 17 22 17C19.2386 17 17 19.2386 17 22C17 24.7614 19.2386 27 22 27Z"
                                            stroke="#141414" stroke-width="1.4" />
                                    </svg>
                                <?php elseif ('monitor' === $stage_icon): ?>
                                    <svg class="hidden md:block mb-4" width="44" height="44" viewBox="0 0 44 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                        <path
                                            d="M22 34C28.6274 34 34 28.6274 34 22C34 15.3726 28.6274 10 22 10C15.3726 10 10 15.3726 10 22C10 28.6274 15.3726 34 22 34Z"
                                            stroke="#141414" stroke-width="1.4" />
                                        <path d="M22 14V22L27 25" stroke="#141414" stroke-width="1.4" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                <?php endif; ?>

                                <?php if ($stage_title): ?>
                                    <h3 class="text-[17px] font-normal text-gray-900">
                                        <?php echo esc_html($stage_title); ?>
                                    </h3>
                                <?php endif; ?>
                            </div>

                            <?php if ($stage_description): ?>
                                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                                    <?php echo esc_html($stage_description); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Medical Grade Authority Banner -->
            <?php if ($inside_unit_authority): ?>
                <div
                    class="max-w-6xl mx-auto bg-[#0C1216] text-white p-8 md:p-16 lg:px-20 flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200 mt-16 md:mt-0">
                    <!-- Desktop Circular Badge (Hidden on Mobile) -->
                    <?php if ($inside_unit_badge_value || $inside_unit_badge_label): ?>
                        <div
                            class="hidden md:flex flex-shrink-0 w-[120px] h-[120px] rounded-full border border-gray-700/60 flex-col items-center justify-center text-center shadow-inner">
                            <?php if ($inside_unit_badge_value): ?>
                                <span class="text-3xl font-light text-[#156E8A] mb-1">
                                    <?php echo esc_html($inside_unit_badge_value); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($inside_unit_badge_label): ?>
                                <span class="text-[6px] uppercase tracking-[0.25em] text-gray-400 font-bold leading-tight">
                                    <?php echo nl2br(esc_html($inside_unit_badge_label)); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Banner Content -->
                    <!-- Mobile: Flex to place badge left of the text group. Desktop: Block layout -->
                    <div class="text-left md:pr-[20%] w-full flex items-start md:block gap-4">
                        <!-- Mobile-Only Square Tag (Hidden on Desktop) -->
                        <?php if ($inside_unit_badge_value): ?>
                            <div
                                class="md:hidden bg-[#0A1F26] text-[#156E8A] font-semibold px-2.5 py-1 text-[11px] tracking-wider rounded-xl shrink-0 mt-0.5">
                                <?php echo esc_html($inside_unit_badge_value); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Text Group: Headline and Paragraph are grouped so they align perfectly -->
                        <div>
                            <?php if ($inside_unit_authority_heading): ?>
                                <h4
                                    class="text-[17px] md:text-2xl font-light tracking-wide leading-snug md:leading-normal mb-3 md:mb-5">
                                    <?php echo esc_html($inside_unit_authority_heading); ?>
                                </h4>
                            <?php endif; ?>

                            <?php if ($inside_unit_authority_description): ?>
                                <p class="text-[15px] text-gray-400 font-light leading-relaxed max-w-3xl pr-2 md:pr-0">
                                    <?php echo esc_html($inside_unit_authority_description); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <?php
    $breathe_app_page_id = (int) get_option('page_on_front');

    if (!$breathe_app_page_id) {
        $breathe_app_page_id = get_queried_object_id();
    }

    $breathe_app_eyebrow = '';
    $breathe_app_heading_intro = '';
    $breathe_app_heading_before = '';
    $breathe_app_heading_after = '';
    $breathe_app_description = '';
    $breathe_app_mobile_image_id = 0;
    $breathe_app_desktop_image_id = 0;
    $breathe_app_features = [];
    $breathe_app_download_links = [];

    if (function_exists('get_field')) {
        $breathe_app_eyebrow = (string) get_field(
            'breathe_app_eyebrow',
            $breathe_app_page_id
        );
        $breathe_app_heading_intro = (string) get_field(
            'breathe_app_heading_intro',
            $breathe_app_page_id
        );
        $breathe_app_heading_before = (string) get_field(
            'breathe_app_heading_before_break',
            $breathe_app_page_id
        );
        $breathe_app_heading_after = (string) get_field(
            'breathe_app_heading_after_break',
            $breathe_app_page_id
        );
        $breathe_app_description = (string) get_field(
            'breathe_app_description',
            $breathe_app_page_id
        );
        $breathe_app_mobile_image_id = absint(
            get_field('breathe_app_mobile_image', $breathe_app_page_id)
        );
        $breathe_app_desktop_image_id = absint(
            get_field('breathe_app_desktop_image', $breathe_app_page_id)
        );
        $breathe_app_features = get_field(
            'breathe_app_features',
            $breathe_app_page_id
        );
        $breathe_app_download_links = get_field(
            'breathe_app_download_links',
            $breathe_app_page_id
        );
    }

    if (!is_array($breathe_app_features)) {
        $breathe_app_features = [];
    }

    if (!is_array($breathe_app_download_links)) {
        $breathe_app_download_links = [];
    }

    $breathe_app_apple_link = $breathe_app_download_links['breathe_app_apple_link']
        ?? [];
    $breathe_app_google_link = $breathe_app_download_links['breathe_app_google_link']
        ?? [];

    if (!is_array($breathe_app_apple_link)) {
        $breathe_app_apple_link = [];
    }

    if (!is_array($breathe_app_google_link)) {
        $breathe_app_google_link = [];
    }

    $breathe_app_has_content = $breathe_app_eyebrow
        || $breathe_app_heading_intro
        || $breathe_app_heading_before
        || $breathe_app_heading_after
        || $breathe_app_description
        || $breathe_app_mobile_image_id
        || $breathe_app_desktop_image_id
        || $breathe_app_features;
    ?>

    <!-- ========================================== -->
    <!-- SECTION 9: APP INTEGRATION                 -->
    <!-- ========================================== -->
    <?php if ($breathe_app_has_content): ?>
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
                    <?php if ($breathe_app_eyebrow): ?>
                        <span class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                            <?php echo esc_html($breathe_app_eyebrow); ?>
                        </span>
                    <?php endif; ?>

                    <!-- Headline -->
                    <!-- Responsive Text: White on mobile, Dark on desktop -->
                    <?php if (
                        $breathe_app_heading_intro
                        || $breathe_app_heading_before
                        || $breathe_app_heading_after
                    ): ?>
                        <h2
                            class="text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-white md:text-gray-900 leading-[1.1] mb-6">
                            <?php if ($breathe_app_heading_intro): ?>
                                <?php echo esc_html($breathe_app_heading_intro); ?>
                            <?php endif; ?>

                            <?php if ($breathe_app_heading_before || $breathe_app_heading_after): ?>
                                <span class="text-[#156E8A] font-bold">
                                    <?php echo esc_html($breathe_app_heading_before); ?>
                                    <?php if ($breathe_app_heading_after): ?>
                                        <br class="hidden md:block" />
                                        <?php echo esc_html($breathe_app_heading_after); ?>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </h2>
                    <?php endif; ?>

                    <!-- Subtext -->
                    <?php if ($breathe_app_description): ?>
                        <p class="text-gray-400 md:text-gray-500 text-sm font-light leading-relaxed mb-4 md:mb-10 max-w-lg">
                            <?php echo esc_html($breathe_app_description); ?>
                        </p>
                    <?php endif; ?>
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

                    <?php
                    $breathe_app_base_image_id = $breathe_app_mobile_image_id
                        ?: $breathe_app_desktop_image_id;
                    $breathe_app_large_image_id = $breathe_app_desktop_image_id
                        ?: $breathe_app_base_image_id;
                    $breathe_app_desktop_src = $breathe_app_large_image_id
                        ? wp_get_attachment_image_src($breathe_app_large_image_id, 'large')
                        : false;
                    $breathe_app_desktop_srcset = $breathe_app_large_image_id
                        ? wp_get_attachment_image_srcset($breathe_app_large_image_id, 'large')
                        : false;
                    ?>

                    <?php if ($breathe_app_base_image_id): ?>
                        <picture class="relative z-10 block w-full">
                            <?php if (
                                $breathe_app_desktop_image_id
                                && $breathe_app_desktop_image_id !== $breathe_app_base_image_id
                                && $breathe_app_desktop_src
                            ): ?>
                                <source media="(min-width: 768px)" srcset="<?php echo esc_attr(
                                    $breathe_app_desktop_srcset ?: $breathe_app_desktop_src[0]
                                ); ?>" sizes="450px"
                                    width="<?php echo esc_attr((string) $breathe_app_desktop_src[1]); ?>"
                                    height="<?php echo esc_attr((string) $breathe_app_desktop_src[2]); ?>" />
                            <?php endif; ?>

                            <?php
                            echo wp_get_attachment_image(
                                $breathe_app_base_image_id,
                                'large',
                                false,
                                [
                                    'class' => 'w-full max-w-[320px] md:max-w-[450px] h-auto object-contain mx-auto animate-float',
                                    'loading' => 'lazy',
                                    'decoding' => 'async',
                                    'sizes' => '(min-width: 768px) 450px, 320px',
                                ]
                            );
                            ?>
                        </picture>
                    <?php endif; ?>
                </div>

                <!-- ========================================== -->
                <!-- 3. Features & Buttons (Bottom Mobile / Bottom-Left Desktop) -->
                <!-- ========================================== -->
                <div
                    class="order-3 lg:col-start-1 lg:row-start-2 w-full flex flex-col scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-100">
                    <!-- Feature List -->
                    <div
                        class="flex flex-col border-t border-gray-800/80 md:border-t-0 divide-y divide-gray-800/80 md:divide-gray-100 mb-10 md:mb-12">
                        <?php foreach (array_values($breathe_app_features) as $app_feature): ?>
                            <?php
                            if (!is_array($app_feature)) {
                                continue;
                            }

                            $app_feature_icon = sanitize_key(
                                (string) ($app_feature['breathe_app_feature_icon'] ?? '')
                            );
                            $app_feature_title = (string) (
                                $app_feature['breathe_app_feature_title'] ?? ''
                            );
                            $app_feature_description = (string) (
                                $app_feature['breathe_app_feature_description'] ?? ''
                            );

                            if (!$app_feature_title && !$app_feature_description) {
                                continue;
                            }
                            ?>
                            <div class="py-5 flex items-start gap-4 md:gap-5">
                                <div class="mt-0.5 text-[#156E8A] bg-[#111A20] md:bg-sky-50 p-2.5 md:p-2 rounded-full">
                                    <?php if ('air_quality' === $app_feature_icon): ?>
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                            <path
                                                d="M10 17.5C14.1421 17.5 17.5 14.1421 17.5 10C17.5 5.85786 14.1421 2.5 10 2.5C5.85786 2.5 2.5 5.85786 2.5 10C2.5 14.1421 5.85786 17.5 10 17.5Z"
                                                stroke="#156E8A" stroke-width="1.3" />
                                            <path d="M10 6V10L12.6 11.6" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    <?php elseif ('remote_control' === $app_feature_icon): ?>
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                            <path
                                                d="M14.5 2.5H5.5C4.39543 2.5 3.5 3.39543 3.5 4.5V15.5C3.5 16.6046 4.39543 17.5 5.5 17.5H14.5C15.6046 17.5 16.5 16.6046 16.5 15.5V4.5C16.5 3.39543 15.6046 2.5 14.5 2.5Z"
                                                stroke="#156E8A" stroke-width="1.3" />
                                            <path d="M8 14.5H12" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" />
                                        </svg>
                                    <?php elseif ('schedules' === $app_feature_icon): ?>
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                            <path
                                                d="M10 2.5V5.5M10 14.5V17.5M17.5 10H14.5M5.5 10H2.5M15 5L12.9 7.1M7.1 12.9L5 15M15 15L12.9 12.9M7.1 7.1L5 5"
                                                stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" />
                                            <path
                                                d="M10 13C11.6569 13 13 11.6569 13 10C13 8.34315 11.6569 7 10 7C8.34315 7 7 8.34315 7 10C7 11.6569 8.34315 13 10 13Z"
                                                stroke="#156E8A" stroke-width="1.3" />
                                        </svg>
                                    <?php elseif ('filter_care' === $app_feature_icon): ?>
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                            <path d="M10 2.5L4 5V9.2C4 12.9 6.5 16.3 10 17.5C13.5 16.3 16 12.9 16 9.2V5L10 2.5Z"
                                                stroke="#156E8A" stroke-width="1.3" stroke-linejoin="round" />
                                            <path d="M7.5 10L9.3 11.8L13 8" stroke="#156E8A" stroke-width="1.3"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <?php if ($app_feature_title): ?>
                                        <h4 class="text-[15px] text-gray-100 md:text-gray-900 font-medium mb-1">
                                            <?php echo esc_html($app_feature_title); ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if ($app_feature_description): ?>
                                        <p class="text-[11px] text-gray-400 md:text-gray-500 font-light leading-relaxed">
                                            <?php echo esc_html($app_feature_description); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- App Store Buttons -->
                    <?php
                    $breathe_app_button_class = 'flex items-center justify-center md:justify-start gap-2.5 md:gap-3 px-3 md:px-5 py-3 md:py-2.5 border border-gray-800 md:border-gray-200 hover:border-gray-500 md:hover:border-gray-300 md:hover:bg-gray-50 transition-all rounded-xl group text-white md:text-[#141414]';

                    $breathe_app_apple_url = (string) (
                        $breathe_app_apple_link['url'] ?? ''
                    );
                    $breathe_app_apple_title = (string) (
                        $breathe_app_apple_link['title'] ?? 'App Store'
                    );
                    $breathe_app_apple_target = '_blank' === (
                        $breathe_app_apple_link['target'] ?? ''
                    ) ? '_blank' : '';

                    $breathe_app_google_url = (string) (
                        $breathe_app_google_link['url'] ?? ''
                    );
                    $breathe_app_google_title = (string) (
                        $breathe_app_google_link['title'] ?? 'Google Play'
                    );
                    $breathe_app_google_target = '_blank' === (
                        $breathe_app_google_link['target'] ?? ''
                    ) ? '_blank' : '';
                    ?>
                    <div class="grid grid-cols-2 md:flex md:flex-wrap items-center gap-3 md:gap-4">
                        <!-- Apple App Store -->
                        <?php if ($breathe_app_apple_url): ?>
                            <a href="<?php echo esc_url($breathe_app_apple_url); ?>"
                                class="<?php echo esc_attr($breathe_app_button_class); ?>" <?php if ($breathe_app_apple_target): ?> target="_blank" rel="noopener noreferrer" <?php endif; ?>>
                            <?php else: ?>
                                <span class="<?php echo esc_attr($breathe_app_button_class); ?>" aria-disabled="true">
                                <?php endif; ?>
                                <!-- fill="currentColor" allows the SVG to flip between white on mobile and dark on desktop -->
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path
                                        d="M15.6292 11.4953C15.6109 9.47859 17.2793 8.50693 17.3526 8.46109C16.4176 7.08609 14.9601 6.90276 14.4376 6.88443C13.2001 6.75609 12.0176 7.61776 11.3851 7.61776C10.7526 7.61776 9.79008 6.90276 8.76342 6.92109C7.41592 6.93943 6.16925 7.70943 5.47258 8.91943C4.07008 11.3578 5.11508 14.9694 6.48092 16.9494C7.15008 17.9211 7.94758 19.0119 8.99258 18.9753C10.0009 18.9386 10.3859 18.3244 11.6051 18.3244C12.8243 18.3244 13.1726 18.9753 14.2359 18.9569C15.3176 18.9386 16.0051 17.9669 16.6651 16.9861C17.4351 15.8586 17.7467 14.7678 17.7651 14.7128C17.7376 14.7036 15.6659 13.9061 15.6476 11.5136L15.6292 11.4953ZM13.6401 5.46359C14.1901 4.79443 14.5659 3.86859 14.4651 2.93359C13.6676 2.97026 12.6959 3.46526 12.1184 4.13443C11.6051 4.72109 11.1559 5.66526 11.2751 6.56359C12.1642 6.63693 13.0809 6.11443 13.6401 5.46359Z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span
                                        class="text-[6px] md:text-[7px] uppercase tracking-widest text-gray-500 font-bold leading-none mb-1">Download
                                        on the</span>
                                    <span class="text-xs md:text-sm font-medium leading-none">
                                        <?php echo esc_html($breathe_app_apple_title ?: 'App Store'); ?>
                                    </span>
                                </div>
                                <?php if ($breathe_app_apple_url): ?>
                            </a>
                        <?php else: ?>
                            </span>
                        <?php endif; ?>

                        <!-- Google Play Store -->
                        <?php if ($breathe_app_google_url): ?>
                            <a href="<?php echo esc_url($breathe_app_google_url); ?>"
                                class="<?php echo esc_attr($breathe_app_button_class); ?>" <?php if ($breathe_app_google_target): ?> target="_blank" rel="noopener noreferrer" <?php endif; ?>>
                            <?php else: ?>
                                <span class="<?php echo esc_attr($breathe_app_button_class); ?>" aria-disabled="true">
                                <?php endif; ?>
                                <!-- fill="currentColor" applied -->
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path
                                        d="M3.30042 2.20013C3.05292 2.4568 2.90625 2.86013 2.90625 3.37346V18.6268C2.90625 19.1401 3.05292 19.5435 3.30042 19.8001L3.35542 19.846L11.9171 11.0643V10.936L3.35542 2.1543L3.30042 2.20013ZM14.9421 14.0893L12.1004 11.2476V11.1193L14.9421 8.27763L15.0063 8.3143L18.3704 10.2301C19.3329 10.7801 19.3329 11.6693 18.3704 12.2193L15.0063 14.1351L14.9421 14.181V14.0893ZM14.6029 14.4285L11.6971 11.4585L3.30042 19.846C3.62125 20.1851 4.14375 20.2218 4.73958 19.8918L14.6029 14.4285ZM14.6029 8.48846L4.73958 3.02513C4.14375 2.69513 3.62125 2.7318 3.30042 3.07096L11.6971 11.4585L14.6029 8.48846Z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span
                                        class="text-[6px] md:text-[7px] uppercase tracking-widest text-gray-500 font-bold leading-none mb-1">Get
                                        it on</span>
                                    <span class="text-xs md:text-sm font-medium leading-none">
                                        <?php echo esc_html($breathe_app_google_title ?: 'Google Play'); ?>
                                    </span>
                                </div>
                                <?php if ($breathe_app_google_url): ?>
                            </a>
                        <?php else: ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- ========================================== -->
    <!-- SECTION 10: SIDE-BY-SIDE COMPARISON        -->
    <!-- ========================================== -->
    <?php
    $comparison_page_id = (int) get_option('page_on_front');

    if (!$comparison_page_id) {
        $comparison_page_id = get_queried_object_id();
    }

    $comparison_eyebrow = '';
    $comparison_heading = '';
    $comparison_description = '';
    $comparison_models = [];

    if (function_exists('get_field')) {
        $comparison_eyebrow = (string) get_field(
            'comparison_eyebrow',
            $comparison_page_id
        );
        $comparison_heading = (string) get_field(
            'comparison_heading',
            $comparison_page_id
        );
        $comparison_description = (string) get_field(
            'comparison_description',
            $comparison_page_id
        );
        $comparison_models = get_field(
            'comparison_models',
            $comparison_page_id
        );
    }

    if (!is_array($comparison_models)) {
        $comparison_models = [];
    }

    $comparison_models = array_values(
        array_filter($comparison_models, 'is_array')
    );
    $comparison_models = array_slice($comparison_models, 0, 4);

    $comparison_highlight_index = null;

    foreach ($comparison_models as $model_index => $comparison_model) {
        if (
            null === $comparison_highlight_index
            && !empty($comparison_model['comparison_highlighted'])
        ) {
            $comparison_highlight_index = $model_index;
        }
    }

    $comparison_rows = [
        [
            'label' => 'Coverage Area',
            'key' => 'comparison_coverage_area',
            'type' => 'text',
        ],
        [
            'label' => 'Ideal Space',
            'key' => 'comparison_ideal_space',
            'type' => 'text',
        ],
        [
            'label' => 'Smart Features',
            'key' => 'comparison_smart_features',
            'type' => 'text',
        ],
        [
            'label' => 'Filter Life',
            'key' => 'comparison_filter_life',
            'type' => 'text',
        ],
        [
            'label' => 'Noise Level',
            'key' => 'comparison_noise_level',
            'type' => 'text',
        ],
        [
            'label' => 'Warranty',
            'key' => 'comparison_warranty',
            'type' => 'text',
        ],
        [
            'label' => 'HEPA H13',
            'key' => 'comparison_hepa_h13',
            'type' => 'boolean',
        ],
        [
            'label' => 'Active Carbon',
            'key' => 'comparison_active_carbon',
            'type' => 'boolean',
        ],
        [
            'label' => 'PM2.5 Sensor',
            'key' => 'comparison_pm25_sensor',
            'type' => 'boolean',
        ],
    ];

    $comparison_has_content = function_exists('wc_get_product')
        && 4 === count($comparison_models)
        && (
            $comparison_eyebrow
            || $comparison_heading
            || $comparison_description
        );
    ?>

    <?php if ($comparison_has_content): ?>
        <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24">
            <!-- Header Section (Responsive Alignment) -->
            <div
                class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <?php if ($comparison_eyebrow): ?>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                        <?php echo esc_html($comparison_eyebrow); ?>
                    </span>
                <?php endif; ?>

                <?php if ($comparison_heading): ?>
                    <h2
                        class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                        <?php echo esc_html($comparison_heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($comparison_description): ?>
                    <p class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto">
                        <?php echo esc_html($comparison_description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Comparison Table Wrapper -->
            <div class="max-w-6xl mx-auto scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100 pb-8">
                <div class="overflow-x-auto md:overflow-visible no-scrollbar rounded-xl border border-gray-200 bg-white shadow-sm relative"
                    aria-label="<?php esc_attr_e('Product comparison', 'breathein'); ?>">
                    <!-- The four-model ACF limit preserves this responsive grid contract. -->
                    <div
                        class="grid grid-cols-[120px_repeat(4,minmax(140px,1fr))] md:grid-cols-5 min-w-[700px] md:min-w-full">
                        <div
                            class="p-5 md:p-8 sticky left-0 bg-white z-20 flex items-end text-[11px] uppercase tracking-[0.2em] text-gray-400 font-bold border-b border-gray-100">
                            <?php esc_html_e('Feature', 'breathein'); ?>
                        </div>

                        <?php foreach ($comparison_models as $model_index => $comparison_model): ?>
                            <?php
                            $product_value = $comparison_model['comparison_product'] ?? 0;
                            $product_id = is_object($product_value)
                                ? (int) $product_value->ID
                                : absint($product_value);
                            $comparison_product = $product_id
                                ? wc_get_product($product_id)
                                : false;
                            $is_highlighted = $model_index === $comparison_highlight_index;
                            $comparison_badge = (string) (
                                $comparison_model['comparison_badge'] ?? ''
                            );

                            $header_class = 'p-5 md:p-8 flex flex-col items-center justify-center text-center border-b border-gray-100';
                            $title_class = 'text-base md:text-xl font-medium md:font-normal text-gray-900 mb-1 md:mb-2';

                            if ($is_highlighted) {
                                $header_class .= ' bg-[#EDF3F6] relative';
                                $title_class .= ' mt-4 md:mt-0';
                            }
                            ?>
                            <div class="<?php echo esc_attr($header_class); ?>">
                                <?php if ($is_highlighted && $comparison_badge): ?>
                                    <div
                                        class="absolute top-0 right-0 md:-top-3 md:left-1/2 md:-translate-x-1/2 bg-[#156E8A] text-white text-[7px] md:text-[8px] uppercase tracking-widest font-bold px-3 py-1.5 md:whitespace-nowrap z-10 rounded-bl-md md:rounded-none">
                                        <?php echo esc_html($comparison_badge); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($comparison_product): ?>
                                    <h3 class="<?php echo esc_attr($title_class); ?>">
                                        <?php echo esc_html($comparison_product->get_name()); ?>
                                    </h3>

                                    <?php if ($comparison_product->get_price_html()): ?>
                                        <span class="text-[11px] md:text-sm text-gray-400 md:text-[#156E8A] font-light">
                                            <?php esc_html_e('From', 'breathein'); ?>
                                            <?php echo wp_kses_post($comparison_product->get_price_html()); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <?php foreach ($comparison_rows as $row_index => $comparison_row): ?>
                            <?php
                            $is_last_row = $row_index === count($comparison_rows) - 1;
                            $row_border = $is_last_row
                                ? ''
                                : 'border-b border-gray-100 ';
                            ?>
                            <div class="<?php echo esc_attr(
                                $row_border
                                . 'p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none'
                            ); ?>">
                                <?php echo esc_html($comparison_row['label']); ?>
                            </div>

                            <?php foreach ($comparison_models as $model_index => $comparison_model): ?>
                                <?php
                                $is_highlighted = $model_index === $comparison_highlight_index;
                                $comparison_value = $comparison_model[$comparison_row['key']]
                                    ?? '';
                                ?>

                                <?php if ('boolean' === $comparison_row['type']): ?>
                                    <?php
                                    $boolean_class = $row_border
                                        . 'p-4 md:p-6 flex items-center justify-center';

                                    if ($is_highlighted) {
                                        $boolean_class .= ' bg-[#EDF3F6]';
                                    }

                                    $boolean_class .= $comparison_value
                                        ? ' text-[#156E8A]'
                                        : ' text-gray-300 font-light';
                                    ?>
                                    <div class="<?php echo esc_attr($boolean_class); ?>">
                                        <?php if ($comparison_value): ?>
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                aria-hidden="true" focusable="false">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                                </path>
                                            </svg>
                                            <span class="sr-only">
                                                <?php esc_html_e('Yes', 'breathein'); ?>
                                            </span>
                                        <?php else: ?>
                                            <span aria-hidden="true">&mdash;</span>
                                            <span class="sr-only">
                                                <?php esc_html_e('No', 'breathein'); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <?php
                                    $value_class = $row_border
                                        . 'p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 ';

                                    $value_class .= $is_highlighted
                                        ? 'bg-[#EDF3F6] text-right md:text-center'
                                        : 'text-center';
                                    ?>
                                    <div class="<?php echo esc_attr($value_class); ?>">
                                        <?php echo esc_html((string) $comparison_value); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- ========================================== -->
    <!-- SECTION 11: CASE STUDIES (Zig-Zag Grid)    -->
    <!-- ========================================== -->
    <?php
    $case_studies_page_id = (int) get_option('page_on_front');

    if (!$case_studies_page_id) {
        $case_studies_page_id = get_queried_object_id();
    }

    $case_studies_eyebrow = '';
    $case_studies_heading = '';
    $case_studies_description = '';
    $case_studies = [];

    if (function_exists('get_field')) {
        $case_studies_eyebrow = (string) get_field(
            'case_studies_eyebrow',
            $case_studies_page_id
        );
        $case_studies_heading = (string) get_field(
            'case_studies_heading',
            $case_studies_page_id
        );
        $case_studies_description = (string) get_field(
            'case_studies_description',
            $case_studies_page_id
        );
        $case_studies = get_field(
            'case_studies',
            $case_studies_page_id
        );
    }

    if (!is_array($case_studies)) {
        $case_studies = [];
    }

    $case_studies = array_values(array_filter($case_studies, 'is_array'));

    $case_studies_has_content = $case_studies
        && (
            $case_studies_eyebrow
            || $case_studies_heading
            || $case_studies_description
        );
    ?>

    <?php if ($case_studies_has_content): ?>
        <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
            <!-- Header Section (Responsive Alignment) -->
            <div
                class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-20 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <?php if ($case_studies_eyebrow): ?>
                    <span
                        class="text-[11px] md:text-[12px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                        <?php echo esc_html($case_studies_eyebrow); ?>
                    </span>
                <?php endif; ?>

                <?php if ($case_studies_heading): ?>
                    <h2
                        class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                        <?php echo esc_html($case_studies_heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($case_studies_description): ?>
                    <p
                        class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
                        <?php echo esc_html($case_studies_description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Mobile carousel / desktop checkerboard -->
            <div
                class="max-w-6xl mx-auto bg-transparent md:bg-white md:border md:border-gray-100 md:shadow-[0_4px_30px_rgb(0,0,0,0.03)] relative">
                <div class="swiper caseStudiesSwiper pb-12 md:pb-0 overflow-visible md:overflow-hidden w-full">
                    <div class="swiper-wrapper md:!flex md:!flex-col md:!transform-none md:!w-full md:!h-auto">
                        <?php foreach ($case_studies as $case_index => $case_study): ?>
                            <?php
                            $image_value = $case_study['case_study_image'] ?? 0;
                            $image_id = is_array($image_value)
                                ? absint($image_value['ID'] ?? $image_value['id'] ?? 0)
                                : absint($image_value);
                            $location = (string) (
                                $case_study['case_study_location'] ?? ''
                            );
                            $quote = (string) (
                                $case_study['case_study_quote'] ?? ''
                            );
                            $customer_name = (string) (
                                $case_study['case_study_customer_name'] ?? ''
                            );
                            $customer_role = (string) (
                                $case_study['case_study_customer_role'] ?? ''
                            );
                            $installation_details = (string) (
                                $case_study['case_study_installation_details'] ?? ''
                            );
                            $results = $case_study['case_study_results'] ?? [];

                            if (!is_array($results)) {
                                $results = [];
                            }

                            $results = array_slice(
                                array_values(array_filter($results, 'is_array')),
                                0,
                                2
                            );

                            $is_reversed = 1 === ($case_index % 2);
                            $card_class = 'grid grid-cols-1 md:grid-cols-2 h-full bg-white border border-gray-200 md:border-0 rounded-xl md:rounded-none overflow-hidden';

                            if ($case_index > 0) {
                                $card_class .= ' md:border-t border-gray-100';
                            }

                            $image_class = 'relative w-full h-[240px] sm:h-[300px] md:h-auto md:min-h-[400px] order-1';
                            $content_class = 'p-6 md:p-16 flex flex-col justify-center order-2';

                            if ($is_reversed) {
                                $image_class .= ' md:order-2';
                                $content_class .= ' md:order-1';
                            }
                            ?>
                            <div class="swiper-slide h-auto md:!h-auto md:!w-full">
                                <article class="<?php echo esc_attr($card_class); ?>">
                                    <div class="<?php echo esc_attr($image_class); ?>">
                                        <?php if ($image_id): ?>
                                            <?php
                                            echo wp_get_attachment_image(
                                                $image_id,
                                                'large',
                                                false,
                                                [
                                                    'class' => 'absolute inset-0 w-full h-full object-cover',
                                                    'loading' => 'lazy',
                                                    'decoding' => 'async',
                                                    'sizes' => '(min-width: 768px) 50vw, 100vw',
                                                ]
                                            );
                                            ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="<?php echo esc_attr($content_class); ?>">
                                        <?php if ($location): ?>
                                            <span
                                                class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                                                <?php echo esc_html($location); ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($quote): ?>
                                            <blockquote
                                                class="m-0 text-[17px] md:text-xl lg:text-[25px] font-medium md:font-light text-gray-900 leading-snug mb-4 md:mb-6">
                                                &ldquo;<?php echo esc_html($quote); ?>&rdquo;
                                            </blockquote>
                                        <?php endif; ?>

                                        <?php if (
                                            $customer_name
                                            || $customer_role
                                            || $installation_details
                                        ): ?>
                                            <p
                                                class="text-[11px] md:text-[12px] text-gray-400 font-light mb-8 md:mb-10 lg:uppercase tracking-wide">
                                                <?php echo esc_html($customer_name); ?>
                                                <?php if ($customer_role): ?>
                                                    <?php echo esc_html(', ' . $customer_role); ?>
                                                <?php endif; ?>
                                                <?php if ($installation_details): ?>
                                                    &mdash;
                                                    <?php echo esc_html($installation_details); ?>
                                                <?php endif; ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ($results): ?>
                                            <div class="grid grid-cols-2 gap-3 md:gap-4">
                                                <?php foreach ($results as $result): ?>
                                                    <?php
                                                    $result_label = (string) (
                                                        $result['case_study_result_label'] ?? ''
                                                    );
                                                    $result_value = (string) (
                                                        $result['case_study_result_value'] ?? ''
                                                    );
                                                    ?>
                                                    <div
                                                        class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                                                        <?php if ($result_label): ?>
                                                            <span
                                                                class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">
                                                                <?php echo esc_html($result_label); ?>
                                                            </span>
                                                        <?php endif; ?>

                                                        <?php if ($result_value): ?>
                                                            <span class="text-xl md:text-2xl font-normal text-gray-900">
                                                                <?php echo esc_html($result_value); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Swiper Pagination (Mobile Only) -->
                    <div class="swiper-pagination md:hidden !bottom-0"></div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- SECTION 12: TRUST & CERTIFICATIONS         -->
    <!-- ========================================== -->
    <?php
    $trust_certifications_page_id = (int) get_option('page_on_front');

    if (!$trust_certifications_page_id) {
        $trust_certifications_page_id = get_queried_object_id();
    }

    $trust_certifications_eyebrow = '';
    $trust_certifications_heading_line_one = '';
    $trust_certifications_heading_line_two = '';
    $trust_certifications_heading_highlight = '';
    $trust_certifications_description = '';
    $trust_certification_cards = [];
    $trust_certification_logos = [];

    if (function_exists('get_field')) {
        $trust_certifications_eyebrow = (string) get_field(
            'trust_certifications_eyebrow',
            $trust_certifications_page_id
        );
        $trust_certifications_heading_line_one = (string) get_field(
            'trust_certifications_heading_line_one',
            $trust_certifications_page_id
        );
        $trust_certifications_heading_line_two = (string) get_field(
            'trust_certifications_heading_line_two',
            $trust_certifications_page_id
        );
        $trust_certifications_heading_highlight = (string) get_field(
            'trust_certifications_heading_highlight',
            $trust_certifications_page_id
        );
        $trust_certifications_description = (string) get_field(
            'trust_certifications_description',
            $trust_certifications_page_id
        );
        $trust_certification_cards = get_field(
            'trust_certification_cards',
            $trust_certifications_page_id
        );
        $trust_certification_logos = get_field(
            'trust_certification_logos',
            $trust_certifications_page_id
        );
    }

    if (!is_array($trust_certification_cards)) {
        $trust_certification_cards = [];
    }

    $trust_certification_cards = array_values(
        array_filter(
            $trust_certification_cards,
            static function ($card): bool {
                return is_array($card)
                    && (
                        !empty($card['trust_card_title'])
                        || !empty($card['trust_card_description'])
                    );
            }
        )
    );
    $trust_certification_cards = array_slice($trust_certification_cards, 0, 4);

    if (!is_array($trust_certification_logos)) {
        $trust_certification_logos = [];
    }

    $trust_certification_logo_ids = [];

    foreach ($trust_certification_logos as $trust_certification_logo) {
        if (is_array($trust_certification_logo)) {
            $trust_certification_logo_id = (int) (
                $trust_certification_logo['ID']
                ?? $trust_certification_logo['id']
                ?? 0
            );
        } else {
            $trust_certification_logo_id = (int) $trust_certification_logo;
        }

        if ($trust_certification_logo_id) {
            $trust_certification_logo_ids[] = $trust_certification_logo_id;
        }
    }

    $trust_certification_icons = [
        'certified' => <<<'SVG'
<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <path d="M11 2L18 5V10C18 14.2 15 17.8 11 19C7 17.8 4 14.2 4 10V5L11 2Z" stroke="#156E8A" stroke-width="1.3" stroke-linejoin="round" />
    <path d="M8 11L10 13L14 8.5" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
</svg>
SVG,
        'technology' => <<<'SVG'
<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <path d="M11 19.5C15.6944 19.5 19.5 15.6944 19.5 11C19.5 6.30558 15.6944 2.5 11 2.5C6.30558 2.5 2.5 6.30558 2.5 11C2.5 15.6944 6.30558 19.5 11 19.5Z" stroke="#156E8A" stroke-width="1.3" />
    <path d="M11 6V11L14 13" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
</svg>
SVG,
        'filtration' => <<<'SVG'
<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <path d="M3 9.5H19M5.5 13.5H16.5M8 17.5H14M11 3V9" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" />
</svg>
SVG,
        'support' => <<<'SVG'
<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <path d="M11 2.5C9.88376 2.5 8.77846 2.71986 7.74719 3.14702C6.71592 3.57419 5.77889 4.20029 4.98959 4.98959C4.20029 5.77889 3.57419 6.71592 3.14702 7.74719C2.71986 8.77846 2.5 9.88376 2.5 11C2.5 12.1162 2.71986 13.2215 3.14702 14.2528C3.57419 15.2841 4.20029 16.2211 4.98959 17.0104C5.77889 17.7997 6.71592 18.4258 7.74719 18.853C8.77846 19.2801 9.88376 19.5 11 19.5C13.2543 19.5 15.4163 18.6045 17.0104 17.0104C18.6045 15.4163 19.5 13.2543 19.5 11C19.5 8.74566 18.6045 6.58365 17.0104 4.98959C15.4163 3.39553 13.2543 2.5 11 2.5Z" stroke="#156E8A" stroke-width="1.3" />
    <path d="M7.5 11H14.5M11 7.5V14.5" stroke="#156E8A" stroke-width="1.3" stroke-linecap="round" />
</svg>
SVG,
    ];

    $trust_certifications_has_heading = $trust_certifications_heading_line_one
        || $trust_certifications_heading_line_two
        || $trust_certifications_heading_highlight;
    $trust_certifications_has_content = $trust_certification_cards
        && (
            $trust_certifications_eyebrow
            || $trust_certifications_has_heading
            || $trust_certifications_description
        );
    ?>

    <?php if ($trust_certifications_has_content): ?>
        <section class="w-full bg-[#FAFCFD] py-16 md:py-20 px-6 md:px-16 lg:px-24">
            <!-- Header Section (Responsive Alignment) -->
            <div
                class="max-w-4xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <?php if ($trust_certifications_eyebrow): ?>
                    <!-- Eyebrow with decorative lines (Lines hidden on mobile) -->
                    <div class="flex items-center justify-start md:justify-center gap-4 mb-4 md:mb-6">
                        <div class="hidden md:block w-8 h-[1px] bg-gray-300"></div>
                        <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold">
                            <?php echo esc_html($trust_certifications_eyebrow); ?>
                        </span>
                        <div class="hidden md:block w-8 h-[1px] bg-gray-300"></div>
                    </div>
                <?php endif; ?>

                <?php if ($trust_certifications_has_heading): ?>
                    <!-- Headline -->
                    <h2
                        class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                        <?php if ($trust_certifications_heading_line_one): ?>
                            <?php echo esc_html($trust_certifications_heading_line_one); ?>
                        <?php endif; ?>
                        <?php if ($trust_certifications_heading_line_two): ?>
                            <?php if ($trust_certifications_heading_line_one): ?>
                                <br class="hidden md:block" />
                            <?php endif; ?>
                            <?php echo esc_html($trust_certifications_heading_line_two); ?>
                        <?php endif; ?>
                        <?php if ($trust_certifications_heading_highlight): ?>
                            <span class="text-[#156E8A] font-medium">
                                <?php echo esc_html($trust_certifications_heading_highlight); ?>
                            </span>
                        <?php endif; ?>
                    </h2>
                <?php endif; ?>

                <?php if ($trust_certifications_description): ?>
                    <!-- Subtext -->
                    <p
                        class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
                        <?php echo esc_html($trust_certifications_description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- 4-Column Feature Grid (Stacking on mobile, side-by-side flex inside cards) -->
            <div
                class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8 mb-16 md:mb-20 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
                <!-- Card 1: Certified Performance -->
                <?php $trust_card = $trust_certification_cards[0] ?? null; ?>
                <?php if (is_array($trust_card)): ?>
                    <div
                        class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 rounded-xl md:rounded-none">
                        <!-- Card Header: Flex Row on Mobile, Flex Col on Desktop -->
                        <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                            <!-- Icon -->
                            <div
                                class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                                <?php
                                $trust_card_icon = (string) ($trust_card['trust_card_icon'] ?? 'certified');
                                echo $trust_certification_icons[$trust_card_icon]
                                    ?? $trust_certification_icons['certified'];
                                ?>
                            </div>
                            <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                                <?php echo esc_html((string) ($trust_card['trust_card_title'] ?? '')); ?>
                            </h3>
                        </div>

                        <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                            <?php echo esc_html((string) ($trust_card['trust_card_description'] ?? '')); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Card 2: Japanese Technology -->
                <?php $trust_card = $trust_certification_cards[1] ?? null; ?>
                <?php if (is_array($trust_card)): ?>
                    <div
                        class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 delay-75 rounded-xl md:rounded-none">
                        <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                            <div
                                class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                                <?php
                                $trust_card_icon = (string) ($trust_card['trust_card_icon'] ?? 'technology');
                                echo $trust_certification_icons[$trust_card_icon]
                                    ?? $trust_certification_icons['technology'];
                                ?>
                            </div>
                            <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                                <?php echo esc_html((string) ($trust_card['trust_card_title'] ?? '')); ?>
                            </h3>
                        </div>
                        <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                            <?php echo esc_html((string) ($trust_card['trust_card_description'] ?? '')); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Card 3: HEPA H13 Filtration -->
                <?php $trust_card = $trust_certification_cards[2] ?? null; ?>
                <?php if (is_array($trust_card)): ?>
                    <div
                        class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 delay-150 rounded-xl md:rounded-none">
                        <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                            <div
                                class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                                <?php
                                $trust_card_icon = (string) ($trust_card['trust_card_icon'] ?? 'filtration');
                                echo $trust_certification_icons[$trust_card_icon]
                                    ?? $trust_certification_icons['filtration'];
                                ?>
                            </div>
                            <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                                <?php echo esc_html((string) ($trust_card['trust_card_title'] ?? '')); ?>
                            </h3>
                        </div>
                        <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                            <?php echo esc_html((string) ($trust_card['trust_card_description'] ?? '')); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Card 4: Service & Support -->
                <?php $trust_card = $trust_certification_cards[3] ?? null; ?>
                <?php if (is_array($trust_card)): ?>
                    <div
                        class="bg-white p-6 md:p-10 shadow-sm md:shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300 delay-200 rounded-xl md:rounded-none">
                        <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-0 mb-3 md:mb-0">
                            <div
                                class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-[#156E8A] shrink-0 md:mb-8">
                                <?php
                                $trust_card_icon = (string) ($trust_card['trust_card_icon'] ?? 'support');
                                echo $trust_certification_icons[$trust_card_icon]
                                    ?? $trust_certification_icons['support'];
                                ?>
                            </div>
                            <h3 class="text-[17px] md:text-base text-gray-900 font-normal md:font-medium md:mb-4">
                                <?php echo esc_html((string) ($trust_card['trust_card_title'] ?? '')); ?>
                            </h3>
                        </div>
                        <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed pr-2 md:pr-0">
                            <?php echo esc_html((string) ($trust_card['trust_card_description'] ?? '')); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($trust_certification_logo_ids): ?>
                <!-- Certifications Strip -->
                <!-- Removed borders on mobile -->
                <div
                    class="max-w-7xl mx-auto md:border-t md:border-b border-[#DCE4E7] py-6 md:py-10 px-0 md:px-6 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200">
                    <div class="flex flex-wrap items-center justify-center gap-8 md:gap-10 lg:gap-12">
                        <?php foreach ($trust_certification_logo_ids as $trust_certification_logo_id): ?>
                            <?php
                            echo wp_get_attachment_image(
                                $trust_certification_logo_id,
                                'full',
                                false,
                                [
                                    'class' => 'h-8 md:h-10 w-auto object-contain md:grayscale hover:grayscale-0 transition-all',
                                    'loading' => 'lazy',
                                    'decoding' => 'async',
                                    'sizes' => '(min-width: 768px) 160px, 120px',
                                ]
                            );
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- SECTION 13: THE OWNERSHIP EXPERIENCE       -->
    <!-- ========================================== -->
    <?php
    $ownership_experience_page_id = (int) get_option('page_on_front');

    if (!$ownership_experience_page_id) {
        $ownership_experience_page_id = get_queried_object_id();
    }

    $ownership_experience_eyebrow = '';
    $ownership_experience_heading = '';
    $ownership_experience_description = '';
    $ownership_experience_items = [];

    if (function_exists('get_field')) {
        $ownership_experience_eyebrow = (string) get_field(
            'ownership_experience_eyebrow',
            $ownership_experience_page_id
        );
        $ownership_experience_heading = (string) get_field(
            'ownership_experience_heading',
            $ownership_experience_page_id
        );
        $ownership_experience_description = (string) get_field(
            'ownership_experience_description',
            $ownership_experience_page_id
        );
        $ownership_experience_items = get_field(
            'ownership_experience_items',
            $ownership_experience_page_id
        );
    }

    if (!is_array($ownership_experience_items)) {
        $ownership_experience_items = [];
    }

    $ownership_experience_items = array_values(
        array_filter(
            $ownership_experience_items,
            static function ($item): bool {
                return is_array($item)
                    && (
                        !empty($item['ownership_experience_item_title'])
                        || !empty($item['ownership_experience_item_description'])
                    );
            }
        )
    );
    $ownership_experience_items = array_slice($ownership_experience_items, 0, 5);

    $ownership_experience_icon_paths = [
        'setup' => 'M5 13l4 4L19 7',
        'assistance' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'priority' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
        'parts' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        'warranty' => 'M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01',
    ];

    $ownership_experience_has_content = $ownership_experience_items
        && (
            $ownership_experience_eyebrow
            || $ownership_experience_heading
            || $ownership_experience_description
        );
    ?>

    <?php if ($ownership_experience_has_content): ?>
        <!-- Responsive Background: Light on Mobile, Dark on Desktop -->
        <section class="w-full bg-[#FAFCFD] md:bg-[#0B1115] py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
            <!-- Header Section (Responsive Alignment & Colors) -->
            <div
                class="max-w-4xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                <?php if ($ownership_experience_eyebrow): ?>
                    <!-- Eyebrow -->
                    <span
                        class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] md:text-[#4A99B2] font-bold mb-4 md:mb-6 block">
                        <?php echo esc_html($ownership_experience_eyebrow); ?>
                    </span>
                <?php endif; ?>

                <?php if ($ownership_experience_heading): ?>
                    <!-- Headline -->
                    <h2
                        class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 md:text-white leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
                        <?php echo esc_html($ownership_experience_heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($ownership_experience_description): ?>
                    <!-- Subtext -->
                    <p
                        class="text-gray-500 md:text-gray-400 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
                        <?php echo esc_html($ownership_experience_description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Carousel/Grid Wrapper -->
            <div
                class="swiper ownershipSwiper max-w-[1400px] mx-auto md:border md:border-gray-800/60 pb-12 md:pb-0 overflow-visible md:overflow-hidden w-full scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
                <!-- Swiper Wrapper overrides Swiper's horizontal flex on desktop to use CSS Grid -->
                <!-- md:!divide-y lg:!divide-y-0 perfectly matches your original border logic -->
                <div
                    class="swiper-wrapper md:!grid md:!grid-cols-3 lg:!grid-cols-5 md:!divide-x md:!divide-y lg:!divide-y-0 md:!divide-gray-800/60 md:!transform-none md:!w-full md:!h-auto">
                    <?php foreach ($ownership_experience_items as $ownership_item_index => $ownership_item): ?>
                        <?php
                        $ownership_item_icon = (string) (
                            $ownership_item['ownership_experience_item_icon']
                            ?? 'setup'
                        );
                        $ownership_item_icon_path = $ownership_experience_icon_paths[$ownership_item_icon]
                            ?? $ownership_experience_icon_paths['setup'];
                        ?>
                        <!-- ================= OWNERSHIP BENEFIT ================= -->
                        <!-- md:!w-auto md:!m-0 strips Swiper's inline width/margin so the grid works perfectly -->
                        <div class="swiper-slide h-auto md:!w-auto md:!m-0">
                            <div
                                class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
                                <span
                                    class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6"><?php echo esc_html(sprintf('%02d', $ownership_item_index + 1)); ?></span>

                                <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                                    <div
                                        class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                                        <svg class="w-6 h-6 stroke-[1.5px]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="<?php echo esc_attr($ownership_item_icon_path); ?>" />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                                        <?php echo esc_html((string) ($ownership_item['ownership_experience_item_title'] ?? '')); ?>
                                    </h3>
                                </div>

                                <p
                                    class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                                    <?php echo esc_html((string) ($ownership_item['ownership_experience_item_description'] ?? '')); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- Swiper Pagination (Mobile Only) -->
                <div class="swiper-pagination md:hidden !bottom-0"></div>
            </div>
        </section>
    <?php endif; ?>
    <!-- ========================================== -->
    <!-- SECTION 14: BROCHURE & DOWNLOAD            -->
    <!-- ========================================== -->
    <?php
    $brochure_download_page_id = (int) get_option('page_on_front');

    if (!$brochure_download_page_id) {
        $brochure_download_page_id = get_queried_object_id();
    }

    $brochure_download_eyebrow = '';
    $brochure_download_heading_line_one = '';
    $brochure_download_heading_line_two = '';
    $brochure_download_description = '';
    $brochure_download_stats = [];
    $brochure_download_file = 0;
    $brochure_download_button_label = '';
    $brochure_download_demo_link = [];
    $brochure_download_preview_image = 0;

    if (function_exists('get_field')) {
        $brochure_download_eyebrow = (string) get_field(
            'brochure_download_eyebrow',
            $brochure_download_page_id
        );
        $brochure_download_heading_line_one = (string) get_field(
            'brochure_download_heading_line_one',
            $brochure_download_page_id
        );
        $brochure_download_heading_line_two = (string) get_field(
            'brochure_download_heading_line_two',
            $brochure_download_page_id
        );
        $brochure_download_description = (string) get_field(
            'brochure_download_description',
            $brochure_download_page_id
        );
        $brochure_download_stats = get_field(
            'brochure_download_stats',
            $brochure_download_page_id
        );
        $brochure_download_file = get_field(
            'brochure_download_file',
            $brochure_download_page_id
        );
        $brochure_download_button_label = (string) get_field(
            'brochure_download_button_label',
            $brochure_download_page_id
        );
        $brochure_download_demo_link = get_field(
            'brochure_download_demo_link',
            $brochure_download_page_id
        );
        $brochure_download_preview_image = get_field(
            'brochure_download_preview_image',
            $brochure_download_page_id
        );
    }

    if (!is_array($brochure_download_stats)) {
        $brochure_download_stats = [];
    }

    $brochure_download_stats = array_values(
        array_filter(
            $brochure_download_stats,
            static function ($stat): bool {
                return is_array($stat)
                    && (
                        !empty($stat['brochure_download_stat_value'])
                        || !empty($stat['brochure_download_stat_label'])
                    );
            }
        )
    );
    $brochure_download_stats = array_slice($brochure_download_stats, 0, 3);

    if (is_array($brochure_download_file)) {
        $brochure_download_file_id = (int) (
            $brochure_download_file['ID']
            ?? $brochure_download_file['id']
            ?? 0
        );
    } else {
        $brochure_download_file_id = (int) $brochure_download_file;
    }

    $brochure_download_url = $brochure_download_file_id
        ? (string) wp_get_attachment_url($brochure_download_file_id)
        : '#';

    if (!is_array($brochure_download_demo_link)) {
        $brochure_download_demo_link = [];
    }

    $brochure_download_demo_title = (string) (
        $brochure_download_demo_link['title']
        ?? ''
    );
    $brochure_download_demo_url = (string) (
        $brochure_download_demo_link['url']
        ?? ''
    );
    $brochure_download_demo_target = '_blank' === (
        $brochure_download_demo_link['target']
        ?? ''
    ) ? '_blank' : '';

    if (is_array($brochure_download_preview_image)) {
        $brochure_download_preview_image_id = (int) (
            $brochure_download_preview_image['ID']
            ?? $brochure_download_preview_image['id']
            ?? 0
        );
    } else {
        $brochure_download_preview_image_id = (int) $brochure_download_preview_image;
    }

    $brochure_download_has_heading = $brochure_download_heading_line_one
        || $brochure_download_heading_line_two;
    $brochure_download_has_actions = $brochure_download_button_label
        || ($brochure_download_demo_title && $brochure_download_demo_url);
    $brochure_download_has_content = (
        $brochure_download_eyebrow
        || $brochure_download_has_heading
        || $brochure_download_description
    ) && (
        $brochure_download_stats
        || $brochure_download_has_actions
        || $brochure_download_preview_image_id
    );
    ?>

    <?php if ($brochure_download_has_content): ?>
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
                    <?php if ($brochure_download_eyebrow): ?>
                        <!-- Eyebrow -->
                        <div class="flex items-center gap-4 mb-5 md:mb-6">
                            <div class="w-8 h-[1px] bg-[#156E8A]"></div>
                            <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold">
                                <?php echo esc_html($brochure_download_eyebrow); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ($brochure_download_has_heading): ?>
                        <!-- Headline -->
                        <h2
                            class="text-[32px] md:text-5xl lg:text-[44px] font-light tracking-tight text-white leading-[1.15] md:leading-[1.2] mb-5 md:mb-6">
                            <?php if ($brochure_download_heading_line_one): ?>
                                <?php echo esc_html($brochure_download_heading_line_one); ?>
                            <?php endif; ?>
                            <?php if ($brochure_download_heading_line_two): ?>
                                <?php if ($brochure_download_heading_line_one): ?>
                                    <br class="hidden md:block" />
                                <?php endif; ?>
                                <?php echo esc_html($brochure_download_heading_line_two); ?>
                            <?php endif; ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($brochure_download_description): ?>
                        <!-- Subtext -->
                        <p class="text-gray-400 text-[12px] md:text-[15px] font-light leading-relaxed mb-8 md:mb-12 max-w-lg">
                            <?php echo esc_html($brochure_download_description); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($brochure_download_stats): ?>
                        <!-- Divider -->
                        <div class="w-full h-[1px] bg-gray-800/80 mb-8 md:mb-10"></div>

                        <!-- Stats Row -->
                        <div class="grid grid-cols-3 gap-4 md:gap-8 mb-10 md:mb-12">
                            <?php foreach ($brochure_download_stats as $brochure_download_stat): ?>
                                <div class="flex flex-col gap-1.5 md:gap-2">
                                    <span class="text-xl md:text-2xl font-semibold text-white tracking-tight">
                                        <?php echo esc_html((string) ($brochure_download_stat['brochure_download_stat_value'] ?? '')); ?>
                                    </span>
                                    <span class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-500 font-medium">
                                        <?php echo esc_html((string) ($brochure_download_stat['brochure_download_stat_label'] ?? '')); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($brochure_download_has_actions): ?>
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 md:gap-6">
                            <?php if ($brochure_download_button_label): ?>
                                <!-- Primary Button (Solid) -->
                                <a href="<?php echo esc_url($brochure_download_url); ?>" <?php echo $brochure_download_file_id ? 'download' : ''; ?>
                                    class="flex items-center justify-center gap-3 bg-[#156E8A] hover:bg-[#11576E] text-white text-[12px] md:text-[13px] uppercase tracking-[0.15em] font-bold px-6 md:px-8 py-4 md:py-3.5 rounded-xl transition-colors w-full sm:w-auto">
                                    <span><?php echo esc_html($brochure_download_button_label); ?></span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($brochure_download_demo_title && $brochure_download_demo_url): ?>
                                <!-- Secondary Button (Text on Mobile, Ghost on Desktop) -->
                                <a href="<?php echo esc_url($brochure_download_demo_url); ?>" <?php if ($brochure_download_demo_target): ?> target="_blank" rel="noopener noreferrer" <?php endif; ?>
                                    class="flex items-center justify-start sm:justify-center bg-transparent text-white md:border md:border-gray-600 hover:md:border-gray-400 text-[12px] md:text-[13px] uppercase tracking-[0.15em] font-bold px-2 md:px-8 py-3 md:py-3.5 rounded-xl transition-colors w-full sm:w-auto">
                                    <?php echo esc_html($brochure_download_demo_title); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($brochure_download_preview_image_id): ?>
                    <!-- Right Column: Full Brochure Preview Image -->
                    <div
                        class="hidden lg:flex justify-center md:justify-end scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-200">
                        <?php
                        echo wp_get_attachment_image(
                            $brochure_download_preview_image_id,
                            'full',
                            false,
                            [
                                'class' => 'w-full max-w-[380px] h-auto object-contain shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-[#16252C] hover:-translate-y-2 transition-transform duration-500',
                                'loading' => 'lazy',
                                'decoding' => 'async',
                                'sizes' => '(min-width: 1024px) 380px, 0px',
                            ]
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- SECTION 15: WHY CHOOSE BREATHE IN          -->
    <!-- ========================================== -->
    <?php
    $why_choose_page_id = (int) get_option('page_on_front');

    if (!$why_choose_page_id) {
        $why_choose_page_id = get_queried_object_id();
    }

    $why_choose_eyebrow = '';
    $why_choose_heading = '';
    $why_choose_heading_highlight = '';
    $why_choose_description = '';
    $why_choose_features = [];
    $why_choose_stats = [];
    $why_choose_cta = [];

    if (function_exists('get_field')) {
        $why_choose_eyebrow = (string) get_field(
            'why_choose_eyebrow',
            $why_choose_page_id
        );
        $why_choose_heading = (string) get_field(
            'why_choose_heading',
            $why_choose_page_id
        );
        $why_choose_heading_highlight = (string) get_field(
            'why_choose_heading_highlight',
            $why_choose_page_id
        );
        $why_choose_description = (string) get_field(
            'why_choose_description',
            $why_choose_page_id
        );
        $why_choose_features = get_field(
            'why_choose_features',
            $why_choose_page_id
        );
        $why_choose_stats = get_field(
            'why_choose_stats',
            $why_choose_page_id
        );
        $why_choose_cta = get_field(
            'why_choose_cta',
            $why_choose_page_id
        );
    }

    if (!is_array($why_choose_features)) {
        $why_choose_features = [];
    }

    $why_choose_features = array_values(
        array_filter(
            $why_choose_features,
            static function ($feature): bool {
                return is_array($feature)
                    && (
                        !empty($feature['why_choose_item_title'])
                        || !empty($feature['why_choose_item_description'])
                    );
            }
        )
    );
    $why_choose_features = array_slice($why_choose_features, 0, 6);

    if (!is_array($why_choose_stats)) {
        $why_choose_stats = [];
    }

    $why_choose_stats = array_values(
        array_filter(
            $why_choose_stats,
            static function ($stat): bool {
                return is_array($stat)
                    && (
                        !empty($stat['why_choose_stat_value'])
                        || !empty($stat['why_choose_stat_label'])
                    );
            }
        )
    );
    $why_choose_stats = array_slice($why_choose_stats, 0, 4);

    if (!is_array($why_choose_cta)) {
        $why_choose_cta = [];
    }

    $why_choose_cta_title = (string) ($why_choose_cta['title'] ?? '');
    $why_choose_cta_url = (string) ($why_choose_cta['url'] ?? '');
    $why_choose_cta_target = '_blank' === ($why_choose_cta['target'] ?? '')
        ? '_blank'
        : '';

    if (!$why_choose_cta_url && function_exists('wc_get_page_permalink')) {
        $why_choose_shop_url = (string) wc_get_page_permalink('shop');

        if ($why_choose_shop_url) {
            $why_choose_cta_url = $why_choose_shop_url;
            $why_choose_cta_title = $why_choose_cta_title ?: 'Explore All Models';
        }
    }

    $why_choose_icons = [
        'certification' => [
            'width' => '12',
            'height' => '15',
            'view_box' => '0 0 12 15',
            'paths' => [
                'M11.1306 7.79864C11.1306 11.1312 8.79785 12.7974 6.0252 13.7639C5.88001 13.8131 5.7223 13.8107 5.57864 13.7572C2.79932 12.7974 0.466553 11.1312 0.466553 7.79864V3.13311C0.466553 2.95635 0.536774 2.78682 0.661767 2.66182C0.786761 2.53683 0.956289 2.46661 1.13306 2.46661C2.46607 2.46661 4.13233 1.6668 5.29204 0.653718C5.43324 0.53308 5.61287 0.466797 5.79859 0.466797C5.9843 0.466797 6.16393 0.53308 6.30513 0.653718C7.47151 1.67347 9.13111 2.46661 10.4641 2.46661C10.6409 2.46661 10.8104 2.53683 10.9354 2.66182C11.0604 2.78682 11.1306 2.95635 11.1306 3.13311V7.79864Z',
            ],
        ],
        'filtration' => [
            'width' => '13',
            'height' => '15',
            'view_box' => '0 0 13 15',
            'paths' => [
                'M1.13533 8.46658C1.0092 8.46701 0.885545 8.43165 0.778719 8.36459C0.671893 8.29754 0.586286 8.20155 0.531844 8.08778C0.477401 7.97401 0.456357 7.84712 0.471158 7.72187C0.485959 7.59661 0.535996 7.47813 0.615457 7.38018L7.21385 0.581838C7.26334 0.524707 7.33079 0.486099 7.40512 0.472354C7.47945 0.458608 7.55625 0.470541 7.6229 0.506193C7.68956 0.541845 7.74211 0.599099 7.77194 0.668556C7.80176 0.738013 7.80709 0.815547 7.78704 0.88843L6.50735 4.90079C6.46962 5.00178 6.45695 5.11041 6.47042 5.21738C6.4839 5.32434 6.52312 5.42644 6.58473 5.51492C6.64633 5.6034 6.72848 5.67561 6.82413 5.72536C6.91977 5.77511 7.02606 5.80092 7.13387 5.80057H11.7994C11.9255 5.80014 12.0492 5.8355 12.156 5.90256C12.2628 5.96961 12.3484 6.0656 12.4029 6.17937C12.4573 6.29314 12.4784 6.42002 12.4636 6.54528C12.4488 6.67053 12.3987 6.78902 12.3193 6.88697L5.72088 13.6853C5.67138 13.7424 5.60393 13.781 5.5296 13.7948C5.45527 13.8085 5.37848 13.7966 5.31182 13.761C5.24517 13.7253 5.19262 13.668 5.16279 13.5986C5.13296 13.5291 5.12764 13.4516 5.14769 13.3787L6.42737 9.36636C6.46511 9.26537 6.47778 9.15673 6.4643 9.04977C6.45083 8.9428 6.4116 8.8407 6.35 8.75223C6.28839 8.66375 6.20624 8.59154 6.1106 8.54179C6.01496 8.49204 5.90867 8.46623 5.80086 8.46658H1.13533Z',
            ],
        ],
        'sleep' => [
            'width' => '14',
            'height' => '14',
            'view_box' => '0 0 14 14',
            'paths' => [
                'M6.46507 12.4639C5.29473 12.4674 4.1658 12.031 3.30219 11.2411C2.43858 10.4513 1.90336 9.36566 1.8027 8.19965C1.70204 7.03364 2.04328 5.87239 2.75874 4.9462C3.47421 4.02001 4.51163 3.39655 5.66527 3.19946C9.46434 2.46631 10.4641 2.11973 11.7971 0.466797C12.4636 1.79981 13.1301 3.25278 13.1301 5.79883C13.1301 9.4646 9.94422 12.4639 6.46507 12.4639Z',
                'M0.466553 13.1304C0.466553 11.1309 1.69959 9.55791 3.85239 9.13135C5.46533 8.81143 7.13159 7.79834 7.7981 7.13184',
            ],
        ],
        'india' => [
            'width' => '9',
            'height' => '15',
            'view_box' => '0 0 9 15',
            'paths' => [
                'M6.78301 7.72461L7.79276 13.4072C7.80407 13.4741 7.79468 13.5429 7.76585 13.6043C7.73702 13.6658 7.69012 13.7169 7.63142 13.751C7.57273 13.7851 7.50503 13.8004 7.43739 13.7949C7.36974 13.7895 7.30538 13.7635 7.25289 13.7205L4.86681 11.9296C4.75162 11.8435 4.61169 11.797 4.46791 11.797C4.32412 11.797 4.18419 11.8435 4.069 11.9296L1.67892 13.7198C1.62648 13.7628 1.56219 13.7887 1.49463 13.7942C1.42707 13.7996 1.35945 13.7843 1.30079 13.7504C1.24213 13.7164 1.19522 13.6654 1.16633 13.6041C1.13743 13.5428 1.12791 13.4741 1.13905 13.4072L2.14814 7.72461',
                'M4.46558 8.46485C6.67418 8.46485 8.4646 6.67442 8.4646 4.46582C8.4646 2.25722 6.67418 0.466797 4.46558 0.466797C2.25698 0.466797 0.466553 2.25722 0.466553 4.46582C0.466553 6.67442 2.25698 8.46485 4.46558 8.46485Z',
            ],
        ],
        'sensing' => [
            'width' => '15',
            'height' => '15',
            'view_box' => '0 0 15 15',
            'paths' => [
                'M7.13159 13.7969C10.8126 13.7969 13.7966 10.8128 13.7966 7.13184C13.7966 3.45084 10.8126 0.466797 7.13159 0.466797C3.45059 0.466797 0.466553 3.45084 0.466553 7.13184C0.466553 10.8128 3.45059 13.7969 7.13159 13.7969Z',
                'M7.13159 3.13281V7.13184L9.79761 8.46485',
            ],
        ],
        'service' => [
            'width' => '15',
            'height' => '13',
            'view_box' => '0 0 15 13',
            'paths' => [
                'M11.7971 7.79834C12.7902 6.82525 13.7966 5.65886 13.7966 4.13257C13.7966 3.16035 13.4104 2.22794 12.723 1.54048C12.0355 0.853011 11.1031 0.466797 10.1309 0.466797C8.95782 0.466797 8.13135 0.800049 7.13159 1.79981C6.13184 0.800049 5.30537 0.466797 4.13233 0.466797C3.1601 0.466797 2.2277 0.853011 1.54023 1.54048C0.852767 2.22794 0.466553 3.16035 0.466553 4.13257C0.466553 5.66553 1.46631 6.83191 2.46607 7.79834L7.13159 12.4639L11.7971 7.79834Z',
                'M7.13164 1.7998L5.15879 3.77266C5.02337 3.90709 4.91589 4.067 4.84255 4.24316C4.76921 4.41932 4.73145 4.60825 4.73145 4.79907C4.73145 4.98989 4.76921 5.17882 4.84255 5.35499C4.91589 5.53115 5.02337 5.69105 5.15879 5.82549C5.70533 6.37202 6.57845 6.39202 7.1583 5.87214L8.53797 4.60579C8.88379 4.29199 9.33403 4.11817 9.80099 4.11817C10.268 4.11817 10.7182 4.29199 11.064 4.60579L13.0369 6.37869',
                'M11.1306 8.46484L9.79761 7.13184',
                'M9.1311 10.4639L7.7981 9.13086',
            ],
        ],
    ];

    $why_choose_has_heading = $why_choose_heading
        || $why_choose_heading_highlight;
    $why_choose_has_content = $why_choose_features
        && (
            $why_choose_eyebrow
            || $why_choose_has_heading
            || $why_choose_description
        );
    $why_choose_has_footer = $why_choose_stats
        || ($why_choose_cta_title && $why_choose_cta_url);
    ?>

    <?php if ($why_choose_has_content): ?>
        <section class="w-full bg-[#0000000A] dark:bg-black py-16 md:py-24 px-6 md:px-16 lg:px-24 overflow-hidden">
            <div class="max-w-[1400px] mx-auto">
                <!-- Header Section -->
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 md:gap-12 mb-10 md:mb-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
                    <!-- Left: Eyebrow & Headline -->
                    <div class="max-w-xl">
                        <?php if ($why_choose_eyebrow): ?>
                            <div class="flex items-center gap-3 mb-4 md:mb-6">
                                <div class="w-8 h-[1px] bg-[#156E8A]"></div>
                                <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold">
                                    <?php echo esc_html($why_choose_eyebrow); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        <?php if ($why_choose_has_heading): ?>
                            <h2
                                class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 dark:text-white leading-[1.15] md:leading-[1.2]">
                                <?php if ($why_choose_heading): ?>
                                    <?php echo esc_html($why_choose_heading); ?>
                                <?php endif; ?>
                                <?php if ($why_choose_heading_highlight): ?>
                                    <?php if ($why_choose_heading): ?>
                                        <br class="hidden md:block" />
                                    <?php endif; ?>
                                    <span class="text-[#156E8A]">
                                        <?php echo esc_html($why_choose_heading_highlight); ?>
                                    </span>
                                <?php endif; ?>
                            </h2>
                        <?php endif; ?>
                    </div>
                    <!-- Right: Subtext -->
                    <?php if ($why_choose_description): ?>
                        <p
                            class="text-gray-500 dark:text-gray-400 text-[15px] md:text-[14px] font-light leading-relaxed max-w-md md:text-right">
                            <?php echo esc_html($why_choose_description); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div
                    class="swiper whyChooseSwiper pb-12 md:pb-0 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
                    <!-- 
              THE FIX: 
              Using md:gap-[1px] and md:bg-gray-200 to automatically generate perfect inner borders on desktop! 
            -->
                    <div
                        class="swiper-wrapper md:!grid md:!grid-cols-3 md:gap-[1px] md:bg-gray-200 dark:md:bg-gray-800 md:border md:border-gray-200 dark:md:border-gray-800 md:!transform-none md:!w-full md:!h-auto">
                        <?php foreach ($why_choose_features as $why_choose_feature_index => $why_choose_feature): ?>
                            <?php
                            $why_choose_icon_key = (string) (
                                $why_choose_feature['why_choose_item_icon']
                                ?? 'certification'
                            );
                            $why_choose_icon = $why_choose_icons[$why_choose_icon_key]
                                ?? $why_choose_icons['certification'];
                            ?>
                            <!-- Why Choose Feature -->
                            <!-- md:border-none is used because the grid gap provides the borders on desktop -->
                            <div
                                class="swiper-slide md:!w-auto md:!m-0 h-auto bg-white dark:bg-[#111a20] p-6 md:p-8 lg:p-10 border border-gray-200 dark:border-gray-800 md:border-none shadow-sm md:shadow-none rounded-[4px] md:rounded-none flex flex-col">
                                <div class="flex justify-between items-start mb-8 md:mb-12">
                                    <span
                                        class="text-[12px] text-[#156E8A] font-medium tracking-widest"><?php echo esc_html(sprintf('%02d', $why_choose_feature_index + 1)); ?></span>
                                    <div
                                        class="w-8 h-8 rounded border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400">
                                        <svg width="<?php echo esc_attr((string) $why_choose_icon['width']); ?>"
                                            height="<?php echo esc_attr((string) $why_choose_icon['height']); ?>"
                                            viewBox="<?php echo esc_attr((string) $why_choose_icon['view_box']); ?>" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                            <?php foreach ($why_choose_icon['paths'] as $why_choose_icon_path): ?>
                                                <path d="<?php echo esc_attr($why_choose_icon_path); ?>" stroke="currentColor"
                                                    stroke-width="0.933106" stroke-linecap="round" stroke-linejoin="round" />
                                            <?php endforeach; ?>
                                        </svg>
                                    </div>
                                </div>
                                <h3
                                    class="text-base md:text-[17px] text-gray-900 dark:text-white font-medium md:font-normal mb-3">
                                    <?php echo esc_html((string) ($why_choose_feature['why_choose_item_title'] ?? '')); ?>
                                </h3>
                                <p
                                    class="text-[13px] md:text-[13px] lg:text-xs text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                                    <?php echo esc_html((string) ($why_choose_feature['why_choose_item_description'] ?? '')); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- Swiper Pagination (Mobile Only) -->
                    <div class="swiper-pagination md:hidden !bottom-0"></div>
                </div>

                <?php if ($why_choose_has_footer): ?>
                    <!-- Footer Stats & CTA -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-start md:items-center mt-12 md:mt-16 pt-8 md:pt-10 border-t border-gray-200/80 dark:border-gray-800 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200">
                        <?php if ($why_choose_stats): ?>
                            <!-- Stats Grid -->
                            <div
                                class="grid grid-cols-2 md:flex gap-y-8 gap-x-6 md:gap-12 lg:gap-16 w-full md:w-auto mb-10 md:mb-0">
                                <?php foreach ($why_choose_stats as $why_choose_stat): ?>
                                    <div class="flex flex-col gap-1">
                                        <span class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                                            <?php echo esc_html((string) ($why_choose_stat['why_choose_stat_value'] ?? '')); ?>
                                        </span>
                                        <span class="text-[8px] md:text-[13px] uppercase tracking-widest text-gray-400 font-medium">
                                            <?php echo esc_html((string) ($why_choose_stat['why_choose_stat_label'] ?? '')); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($why_choose_cta_title && $why_choose_cta_url): ?>
                            <!-- CTA Button -->
                            <a href="<?php echo esc_url($why_choose_cta_url); ?>" <?php if ($why_choose_cta_target): ?>
                                    target="_blank" rel="noopener noreferrer" <?php endif; ?>
                                class="flex items-center justify-center gap-3 bg-[#156E8A] hover:bg-[#11576E] text-white text-[12px] md:text-[13px] uppercase tracking-[0.15em] font-bold px-8 py-4 md:py-3.5 rounded-xl transition-colors w-full md:w-auto shrink-0">
                                <span><?php echo esc_html($why_choose_cta_title); ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- SECTION 16: FINAL CTA (Begin Here)         -->
    <!-- ========================================== -->
    <?php
    $final_cta_page_id = (int) get_option('page_on_front');

    if (!$final_cta_page_id) {
        $final_cta_page_id = get_queried_object_id();
    }

    $final_cta_mobile_background = 0;
    $final_cta_eyebrow = '';
    $final_cta_heading_opening = '';
    $final_cta_heading_middle = '';
    $final_cta_heading_connector = '';
    $final_cta_heading_highlight = '';
    $final_cta_description_line_one = '';
    $final_cta_description_line_two = '';
    $final_cta_starting_price_prefix = '';
    $final_cta_primary_link = [];
    $final_cta_secondary_link = [];

    if (function_exists('get_field')) {
        $final_cta_mobile_background = get_field(
            'final_cta_mobile_background',
            $final_cta_page_id
        );
        $final_cta_eyebrow = (string) get_field(
            'final_cta_eyebrow',
            $final_cta_page_id
        );
        $final_cta_heading_opening = (string) get_field(
            'final_cta_heading_opening',
            $final_cta_page_id
        );
        $final_cta_heading_middle = (string) get_field(
            'final_cta_heading_middle',
            $final_cta_page_id
        );
        $final_cta_heading_connector = (string) get_field(
            'final_cta_heading_connector',
            $final_cta_page_id
        );
        $final_cta_heading_highlight = (string) get_field(
            'final_cta_heading_highlight',
            $final_cta_page_id
        );
        $final_cta_description_line_one = (string) get_field(
            'final_cta_description_line_one',
            $final_cta_page_id
        );
        $final_cta_description_line_two = (string) get_field(
            'final_cta_description_line_two',
            $final_cta_page_id
        );
        $final_cta_starting_price_prefix = (string) get_field(
            'final_cta_starting_price_prefix',
            $final_cta_page_id
        );
        $final_cta_primary_link = get_field(
            'final_cta_primary_link',
            $final_cta_page_id
        );
        $final_cta_secondary_link = get_field(
            'final_cta_secondary_link',
            $final_cta_page_id
        );
    }

    if (is_array($final_cta_mobile_background)) {
        $final_cta_mobile_background_id = (int) (
            $final_cta_mobile_background['ID']
            ?? $final_cta_mobile_background['id']
            ?? 0
        );
    } else {
        $final_cta_mobile_background_id = (int) $final_cta_mobile_background;
    }

    if (!is_array($final_cta_primary_link)) {
        $final_cta_primary_link = [];
    }

    $final_cta_primary_title = (string) (
        $final_cta_primary_link['title']
        ?? ''
    );
    $final_cta_primary_url = (string) (
        $final_cta_primary_link['url']
        ?? ''
    );
    $final_cta_primary_target = '_blank' === (
        $final_cta_primary_link['target']
        ?? ''
    ) ? '_blank' : '';

    if (!$final_cta_primary_url && function_exists('wc_get_page_permalink')) {
        $final_cta_shop_url = (string) wc_get_page_permalink('shop');

        if ($final_cta_shop_url) {
            $final_cta_primary_url = $final_cta_shop_url;
            $final_cta_primary_title = $final_cta_primary_title
                ?: 'Explore Collection';
        }
    }

    if (!is_array($final_cta_secondary_link)) {
        $final_cta_secondary_link = [];
    }

    $final_cta_secondary_title = (string) (
        $final_cta_secondary_link['title']
        ?? ''
    );
    $final_cta_secondary_url = (string) (
        $final_cta_secondary_link['url']
        ?? ''
    );
    $final_cta_secondary_target = '_blank' === (
        $final_cta_secondary_link['target']
        ?? ''
    ) ? '_blank' : '';

    if (!$final_cta_secondary_url) {
        $final_cta_secondary_url = home_url('/#find-your-match');
        $final_cta_secondary_title = $final_cta_secondary_title
            ?: 'Find My Purifier';
    }

    $final_cta_lowest_price = null;

    if (
        function_exists('wc_get_products')
        && function_exists('wc_get_price_to_display')
        && function_exists('wc_price')
    ) {
        $final_cta_products = wc_get_products([
            'status' => 'publish',
            'limit' => -1,
            'return' => 'objects',
        ]);

        foreach ($final_cta_products as $final_cta_product) {
            if (
                !is_a($final_cta_product, 'WC_Product')
                || !$final_cta_product->is_visible()
                || '' === $final_cta_product->get_price()
            ) {
                continue;
            }

            $final_cta_product_price = (float) wc_get_price_to_display(
                $final_cta_product
            );

            if ($final_cta_product_price <= 0) {
                continue;
            }

            if (
                null === $final_cta_lowest_price
                || $final_cta_product_price < $final_cta_lowest_price
            ) {
                $final_cta_lowest_price = $final_cta_product_price;
            }
        }
    }

    $final_cta_formatted_price = '';

    if (null !== $final_cta_lowest_price) {
        $final_cta_formatted_price = html_entity_decode(
            wp_strip_all_tags(
                wc_price(
                    $final_cta_lowest_price,
                    ['decimals' => 2]
                )
            ),
            ENT_QUOTES | ENT_HTML5,
            get_bloginfo('charset') ?: 'UTF-8'
        );
    }

    $final_cta_has_heading = $final_cta_heading_opening
        || $final_cta_heading_middle
        || $final_cta_heading_connector
        || $final_cta_heading_highlight;
    $final_cta_has_description = $final_cta_description_line_one
        || $final_cta_description_line_two
        || ($final_cta_starting_price_prefix && $final_cta_formatted_price);
    $final_cta_has_actions = (
        $final_cta_primary_title
        && $final_cta_primary_url
    ) || (
        $final_cta_secondary_title
        && $final_cta_secondary_url
    );
    $final_cta_has_content = $final_cta_has_heading
        && (
            $final_cta_eyebrow
            || $final_cta_has_description
            || $final_cta_has_actions
        );
    ?>

    <?php if ($final_cta_has_content): ?>
        <section
            class="w-full relative overflow-hidden flex flex-col items-center justify-center min-h-[70vh] bg-[#FAFCFD] py-16 md:py-20 px-6 md:px-16 lg:px-24">
            <!-- Mobile-Only Background Image & Dark Overlay -->
            <div class="absolute inset-0 md:hidden z-0">
                <?php if ($final_cta_mobile_background_id): ?>
                    <?php
                    echo wp_get_attachment_image(
                        $final_cta_mobile_background_id,
                        'full',
                        false,
                        [
                            'class' => 'w-full h-full object-cover object-center',
                            'alt' => '',
                            'aria-hidden' => 'true',
                            'loading' => 'lazy',
                            'decoding' => 'async',
                            'sizes' => '(max-width: 767px) 100vw, 0px',
                        ]
                    );
                    ?>
                <?php endif; ?>
                <!-- Heavy dark overlay to ensure text legibility -->
                <div class="absolute inset-0 bg-[#0A1216]/90"></div>
            </div>

            <!-- Giant Background Watermark ('B') -->
            <!-- Hidden on mobile to keep the dark theme clean, visible on desktop -->
            <div class="hidden md:flex absolute inset-0 items-center justify-center pointer-events-none select-none z-0"
                aria-hidden="true">
                <span
                    class="text-[400px] lg:text-[600px] font-bold text-gray-900 opacity-[0.02] leading-none transform absolute bottom-[-100px]">B</span>
            </div>

            <!-- Content Container -->
            <div
                class="relative z-10 max-w-5xl mx-auto text-center scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out w-full">
                <?php if ($final_cta_eyebrow): ?>
                    <!-- Eyebrow -->
                    <span
                        class="text-[11px] uppercase tracking-[0.25em] text-[#4A99B2] md:text-[#156E8A] font-bold mb-6 md:mb-8 block">
                        <?php echo esc_html($final_cta_eyebrow); ?>
                    </span>
                <?php endif; ?>

                <?php if ($final_cta_has_heading): ?>
                    <!-- Headline -->
                    <!-- Mobile: White text. Desktop: Dark text with blue highlight -->
                    <h2
                        class="text-[34px] md:text-5xl lg:text-7xl font-light tracking-tight text-white md:text-gray-900 leading-[1.2] md:leading-[1.1] mb-6 md:mb-8">
                        <?php if ($final_cta_heading_opening): ?>
                            <?php echo esc_html($final_cta_heading_opening); ?>
                        <?php endif; ?>
                        <?php if ($final_cta_heading_middle): ?>
                            <?php if ($final_cta_heading_opening): ?><br class="md:hidden" /><?php endif; ?>
                            <?php echo esc_html($final_cta_heading_middle); ?>
                        <?php endif; ?>
                        <?php if ($final_cta_heading_connector || $final_cta_heading_highlight): ?>
                            <?php if ($final_cta_heading_opening || $final_cta_heading_middle): ?><br
                                    class="hidden md:block" /><?php endif; ?>
                            <?php if ($final_cta_heading_connector): ?>
                                <?php echo esc_html($final_cta_heading_connector); ?>
                            <?php endif; ?>
                            <?php if ($final_cta_heading_highlight): ?>
                                <span
                                    class="text-white md:text-[#156E8A] font-normal md:font-medium"><?php echo esc_html($final_cta_heading_highlight); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </h2>
                <?php endif; ?>

                <?php if ($final_cta_has_description): ?>
                    <!-- Subtext -->
                    <p
                        class="text-gray-300 md:text-gray-500 text-[15px] md:text-base font-light leading-relaxed max-w-2xl mx-auto mb-10 md:mb-14 px-2 md:px-0">
                        <?php if ($final_cta_description_line_one): ?>
                            <?php echo esc_html($final_cta_description_line_one); ?>
                        <?php endif; ?>
                        <?php if ($final_cta_description_line_two): ?>
                            <?php if ($final_cta_description_line_one): ?><br class="hidden md:block" /><?php endif; ?>
                            <?php echo esc_html($final_cta_description_line_two); ?>
                        <?php endif; ?>
                        <?php if ($final_cta_starting_price_prefix && $final_cta_formatted_price): ?>
                            <?php if ($final_cta_description_line_one || $final_cta_description_line_two): ?><br
                                    class="hidden md:block" /><?php endif; ?>
                            <?php echo esc_html($final_cta_starting_price_prefix . ' ' . $final_cta_formatted_price . '.'); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>

                <?php if ($final_cta_has_actions): ?>
                    <!-- CTA Buttons -->
                    <!-- Mobile: Stacked vertically. Desktop: Side-by-side -->
                    <div
                        class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12 w-full max-w-[280px] mx-auto md:max-w-none">
                        <?php if ($final_cta_primary_title && $final_cta_primary_url): ?>
                            <!-- Primary Solid Button -->
                            <!-- Mobile: White BG, Dark Text. Desktop: Dark BG, White Text -->
                            <a href="<?php echo esc_url($final_cta_primary_url); ?>" <?php if ($final_cta_primary_target): ?>
                                    target="_blank" rel="noopener noreferrer" <?php endif; ?>
                                class="bg-white md:bg-[#111111] text-gray-900 md:text-white text-[11px] md:text-[12px] tracking-[0.15em] font-bold uppercase px-8 py-4 md:py-5 hover:bg-gray-100 md:hover:bg-[#156E8A] transition-colors flex items-center justify-center gap-3 rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.2)] md:shadow-xl md:shadow-gray-200 w-full md:w-auto">
                                <span><?php echo esc_html($final_cta_primary_title); ?></span>
                                <!-- Sleek SVG Arrow -->
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if ($final_cta_secondary_title && $final_cta_secondary_url): ?>
                            <!-- Secondary Ghost/Underline Button -->
                            <!-- Mobile: Light gray text, tight border. Desktop: Dark text -->
                            <a href="<?php echo esc_url($final_cta_secondary_url); ?>" <?php if ($final_cta_secondary_target): ?>
                                    target="_blank" rel="noopener noreferrer" <?php endif; ?>
                                class="text-gray-300 md:text-gray-900 text-[11px] md:text-[12px] tracking-[0.15em] font-bold uppercase border-b border-gray-600 md:border-gray-300 pb-1.5 md:py-5 hover:border-white md:hover:border-[#156E8A] hover:text-white md:hover:text-[#156E8A] transition-colors mt-2 md:mt-0 w-full md:w-auto text-center md:text-left">
                                <?php echo esc_html($final_cta_secondary_title); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>