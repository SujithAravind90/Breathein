<?php
/**
 * Template Name: Technology Page
 */

get_header(); 
?>

<main class="technology-page">

<!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED VIA TEMPLATE PART) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <!-- ========================================== -->
  <!-- FEATURE BREAKDOWN (DYNAMIC ACF REPEATER)   -->
  <!-- ========================================== -->
  <section class="w-full py-10 md:py-20 px-6 md:px-10 lg:px-20 bg-[#FAFCFD]">
    <div class="max-w-[1400px] mx-auto flex flex-col gap-5 lg:gap-20">
      
      <?php if (have_rows('breathe_features')) : 
        $index = 0;
        while (have_rows('breathe_features')) : the_row();
          $index++;
          $is_even = ($index % 2 === 0);
          $img = get_sub_field('feature_image');
      ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-10 items-center md:border-b md:border-gray-200/60 md:pb-10 lg:pb-20 bg-white md:bg-transparent">
          
          <!-- Image Column -->
          <div class="relative rounded-sm overflow-hidden h-[215px] md:h-[350px] lg:h-[450px] <?php echo $is_even ? 'order-1' : 'order-1 lg:order-2'; ?>">
            <?php if ($img): ?>
              <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="absolute inset-0 w-full h-full object-cover" />
            <?php endif; ?>

            <?php if (get_sub_field('badge_value')) : ?>
              <div class="absolute bottom-6 right-6 md:right-auto md:left-6 bg-white/95 backdrop-blur-md px-5 py-3 shadow-md rounded-sm border border-gray-100 flex flex-col">
                <span class="text-xl md:text-2xl font-light text-gray-900 tracking-tight leading-none mb-1">
                  <?php echo esc_html(get_sub_field('badge_value')); ?>
                </span>
                <span class="text-[8px] uppercase tracking-[0.2em] text-gray-400 font-bold">
                  <?php echo esc_html(get_sub_field('badge_label')); ?>
                </span>
              </div>
            <?php endif; ?>
          </div>

          <!-- Text Content -->
          <div class="flex flex-col justify-center order-2 <?php echo $is_even ? '' : 'lg:order-1'; ?> p-5">
            <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 block">
              <?php echo esc_html(get_sub_field('feature_tag') ?: 'BREATHEPURE™ SYSTEM'); ?>
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 tracking-tight mb-6">
              <?php echo get_sub_field('feature_title'); ?>
            </h2>
            <p class="text-gray-500 font-light text-[15px] md:text-sm leading-relaxed mb-8">
              <?php echo esc_html(get_sub_field('feature_description')); ?>
            </p>

            <?php if (have_rows('feature_bullets')) : ?>
              <ul class="flex flex-col gap-3.5">
                <?php while (have_rows('feature_bullets')) : the_row(); ?>
                  <li class="flex items-center gap-3 text-gray-700 text-[15px] md:text-sm font-light">
                    <span class="w-4 h-4 rounded-full bg-sky-50 text-[#156E8A] flex items-center justify-center text-[12px] shrink-0 font-bold">&check;</span>
                    <?php echo esc_html(get_sub_field('bullet_text')); ?>
                  </li>
                <?php endwhile; ?>
              </ul>
            <?php endif; ?>
          </div>

        </div>
      <?php endwhile; endif; ?>

    </div>
  </section>

  <!-- ========================================== -->
  <!-- 4-STAGE GRID SYSTEM                       -->
  <!-- ========================================== -->
  <section class="w-full bg-[#FAFCFD] py-10 md:py-32 px-6 md:px-10 lg:px-20">
    <?php 
        // Fetch ACF field values with fallback defaults
        $stages_eyebrow  = get_field('stages_eyebrow') ?: 'Inside Every Unit';
        $stages_headline = get_field('stages_headline') ?: 'BreathePure™ Technology';
        $stages_subtext  = get_field('stages_subtext')  ?: 'A four-stage air intelligence system, engineered to eliminate what you cannot see. No gimmicks. No compromises.';
    ?>

    <div class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
    
        <!-- Eyebrow -->
        <?php if ($stages_eyebrow) : ?>
            <span class="text-[11px] md:text-[8px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
            <?php echo esc_html($stages_eyebrow); ?>
            </span>
        <?php endif; ?>

        <!-- Headline -->
        <?php if ($stages_headline) : ?>
            <h2 class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
            <?php echo esc_html($stages_headline); ?>
            </h2>
        <?php endif; ?>

        <!-- Subtext -->
        <?php if ($stages_subtext) : ?>
            <p class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
            <?php echo esc_html($stages_subtext); ?>
            </p>
        <?php endif; ?>

    </div>

     <!-- 4-Stage Technology Grid/List -->
    <?php if (have_rows('tech_stages')) : ?>
        <div class="max-w-6xl mx-auto bg-transparent md:bg-white border-0 md:border md:border-gray-100 md:shadow-[0_4px_20px_rgb(0,0,0,0.02)] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y divide-gray-200/80 md:divide-y-0 md:divide-x md:divide-gray-100 mb-12">
        
            <?php while (have_rows('tech_stages')) : the_row(); 
            $number      = get_sub_field('stage_number');
            $title       = get_sub_field('stage_title');
            $description = get_sub_field('stage_description');
            $icon_svg    = get_sub_field('stage_icon_svg');
            $icon_image  = get_sub_field('stage_icon_image'); // ACF Image field
            ?>
            <div class="py-6 md:p-10 flex flex-col h-full lg:border-b-0 border-gray-100 md:border-b">
                
                <!-- Header Row: Flex on mobile to align number/title, Block on desktop -->
                <div class="flex items-start md:block mb-1.5 md:mb-4">
                
                <?php if ($number) : ?>
                    <span class="text-[15px] md:text-[12px] text-[#156E8A] font-medium tracking-widest w-10 shrink-0 md:w-auto md:mb-5 block mt-0.5 md:mt-0">
                    <?php echo esc_html($number); ?>
                    </span>
                <?php endif; ?>

                <!-- Dynamic Icon: Priority given to raw SVG, falls back to Image Array -->
                <?php if ($icon_svg) : ?>
                    <div class="hidden md:block mb-4 w-[44px] h-[44px] shrink-0">
                    <?php echo $icon_svg; // Raw SVG code output ?>
                    </div>
                <?php elseif ($icon_image) : ?>
                    <img 
                    src="<?php echo esc_url($icon_image['url']); ?>" 
                    alt="<?php echo esc_attr($icon_image['alt'] ?: $title); ?>" 
                    class="hidden md:block mb-4 w-[44px] h-[44px] object-contain shrink-0" 
                    />
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h3 class="text-[17px] font-normal text-gray-900">
                    <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>

                </div>

                <!-- Description -->
                <?php if ($description) : ?>
                <p class="text-[15px] md:text-xs text-gray-500 font-light leading-relaxed ml-10 md:ml-0 pr-4 md:pr-0">
                    <?php echo esc_html($description); ?>
                </p>
                <?php endif; ?>

            </div>
            <?php endwhile; ?>

        </div>
    <?php endif; ?>

    <!-- Medical Grade Authority Banner -->
    <?php 
        // Fetch ACF field values with fallback defaults
        $banner_badge_title    = get_field('banner_badge_title') ?: 'H13';
        $banner_badge_subtitle = get_field('banner_badge_subtitle') ?: "True Hepa\nCertified";
        $banner_headline       = get_field('banner_headline') ?: 'Medical-Grade Filtration, In Your Living Room';
        $banner_text           = get_field('banner_text') ?: 'HEPA H13 is the same standard used in hospital operating theatres and pharmaceutical cleanrooms. Breathe In brings this standard into your home without compromise — removing particles invisible to the human eye, every hour, every day.';
    ?>

    <div class="max-w-6xl mx-auto bg-[#0C1216] text-white p-8 md:p-16 lg:px-20 flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-200 mt-16 md:mt-0">
    
        <!-- Desktop Circular Badge (Hidden on Mobile) -->
        <div class="hidden md:flex flex-shrink-0 w-[120px] h-[120px] rounded-full border border-gray-700/60 flex-col items-center justify-center text-center shadow-inner">
            <?php if ($banner_badge_title) : ?>
            <span class="text-3xl font-light text-[#156E8A] mb-1">
                <?php echo nl2br(esc_html($banner_badge_title)); ?>
            </span>
            <?php endif; ?>

            <?php if ($banner_badge_subtitle) : ?>
            <span class="text-[6px] uppercase tracking-[0.25em] text-gray-400 font-bold leading-tight">
                <?php echo nl2br(esc_html($banner_badge_subtitle)); ?>
            </span>
            <?php endif; ?>
        </div>

        <!-- Banner Content -->
        <!-- Mobile: Flex to place badge left of the text group. Desktop: Block layout -->
        <div class="text-left md:pr-[20%] w-full flex items-start md:block gap-4">
            
            <!-- Mobile-Only Square Tag (Hidden on Desktop) -->
            <?php if ($banner_badge_title) : ?>
            <div class="md:hidden bg-[#0A1F26] text-[#156E8A] font-semibold px-2.5 py-1 text-[11px] tracking-wider rounded-sm shrink-0 mt-0.5">
                <?php echo nl2br(esc_html($banner_badge_title)); ?>
            </div>
            <?php endif; ?>

            <!-- Text Group: Headline and Paragraph -->
            <div>
            <?php if ($banner_headline) : ?>
                <h4 class="text-[17px] md:text-2xl font-light tracking-wide leading-snug md:leading-normal mb-3 md:mb-5">
                <?php echo esc_html($banner_headline); ?>
                </h4>
            <?php endif; ?>

            <?php if ($banner_text) : ?>
                <p class="text-[15px] text-gray-400 font-light leading-relaxed max-w-3xl pr-2 md:pr-0">
                <?php echo esc_html($banner_text); ?>
                </p>
            <?php endif; ?>
            </div>

        </div>
    </div>

  </section>

  <!-- DARK CTA SECTION: EXPLORE / COMPARE -->


    <?php get_template_part('template-parts/cta-section'); ?>




</main>

<?php get_footer(); ?>