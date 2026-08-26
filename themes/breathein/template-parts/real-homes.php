<?php
/**
 * Template Name: Real Homes Page
 */

get_header(); 
?>

<main class="real-homes-page">

  <!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED VIA TEMPLATE PART) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <!-- ========================================== -->
  <!-- 2. STATS / METRICS BANNER                  -->
  <!-- ========================================== -->
  <section class="w-full bg-white border-y border-gray-200/60">
    <?php if (have_rows('stats_banner')) : ?>
      <div class="flex flex-row md:grid md:grid-cols-4 items-center lg:min-w-0 py-4 lg:py-0 divide-x divide-gray-200/60 lg:px-0">
        <?php while (have_rows('stats_banner')) : the_row(); 
          $val      = get_sub_field('value');
          $has_star = get_sub_field('has_star');
          $label    = get_sub_field('label');
        ?>
          <div class="flex flex-col items-center justify-center text-center px-6 lg:px-0 lg:py-16 w-[160px] lg:w-auto">
            <h3 class="flex items-center text-3xl lg:text-6xl font-light text-gray-900 lg:text-[#156E8A] mb-1 lg:mb-4 tracking-tight">
              <?php echo esc_html($val); ?>
              <?php if ($has_star) : ?>
                <svg class="w-5 h-5 lg:w-10 lg:h-10 ml-1.5 pb-0.5 lg:pb-1 text-gray-900 lg:text-[#156E8A]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
              <?php endif; ?>
            </h3>
            <span class="text-[11px] lg:text-[12px] uppercase tracking-[0.1em] lg:tracking-[0.2em] text-gray-400 font-medium">
              <?php echo esc_html($label); ?>
            </span>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- ========================================== -->
  <!-- 3. CASE STUDIES CHECKERBOARD GRID          -->
  <!-- ========================================== -->
  <section class="w-full bg-[#FAFCFD] py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
    <!-- Section Header -->
    <div class="max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-20 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
      <span class="text-[11px] md:text-[12px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
        <?php echo esc_html(get_field('cases_eyebrow') ?: 'As Lived In'); ?>
      </span>
      <h2 class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
        <?php echo esc_html(get_field('cases_headline') ?: 'Homes that breathe differently.'); ?>
      </h2>
      <p class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto pr-4 md:pr-0">
        <?php echo esc_html(get_field('cases_subtext')); ?>
      </p>
    </div>

    <!-- Carousel/Checkerboard Wrapper -->
    <div class="max-w-6xl mx-auto bg-transparent md:bg-white md:border md:border-gray-100 md:shadow-[0_4px_30px_rgb(0,0,0,0.03)] relative">
      <div class="swiper caseStudiesSwiper pb-12 md:pb-0 overflow-visible md:overflow-hidden w-full">
        <div class="swiper-wrapper md:!flex md:!flex-col md:!transform-none md:!w-full md:!h-auto">
          
          <?php if (have_rows('case_studies')) : 
            $case_idx = 0;
            while (have_rows('case_studies')) : the_row(); 
              $case_idx++;
              $is_even = ($case_idx % 2 === 0);
              $img     = get_sub_field('image');
          ?>
            <div class="swiper-slide h-auto md:!h-auto">
              <div class="grid grid-cols-1 md:grid-cols-2 h-full bg-white border border-gray-200 md:border-0 <?php echo ($case_idx > 1) ? 'md:border-t border-gray-100' : ''; ?> rounded-xl md:rounded-none overflow-hidden">
                
                <!-- Image Column (Alternates side on desktop) -->
                <div class="relative w-full h-[240px] sm:h-[300px] md:h-auto md:min-h-[400px] order-1 <?php echo $is_even ? 'md:order-2' : ''; ?>">
                  <?php if ($img) : ?>
                    <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="absolute inset-0 w-full h-full object-cover" />
                  <?php endif; ?>
                </div>

                <!-- Text Content -->
                <div class="p-6 md:p-16 flex flex-col justify-center order-2 <?php echo $is_even ? 'md:order-1' : ''; ?>">
                  <span class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
                    <?php echo esc_html(get_sub_field('location')); ?>
                  </span>

                  <h3 class="text-[17px] md:text-xl lg:text-[25px] font-medium md:font-light text-gray-900 leading-snug mb-4 md:mb-6">
                    "<?php echo esc_html(get_sub_field('quote')); ?>"
                  </h3>

                  <p class="text-[11px] md:text-[12px] text-gray-400 font-light mb-8 md:mb-10 lg:uppercase tracking-wide">
                    <?php echo esc_html(get_sub_field('author')); ?>
                  </p>

                  <!-- Stats Grid -->
                  <div class="grid grid-cols-2 gap-3 md:gap-4">
                    <div class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                      <span class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">
                        <?php echo esc_html(get_sub_field('stat1_label')); ?>
                      </span>
                      <span class="text-xl md:text-2xl font-normal text-gray-900">
                        <?php echo esc_html(get_sub_field('stat1_val')); ?>
                      </span>
                    </div>
                    <div class="bg-[#F8FAFC] border-l-[2px] border-[#156E8A] p-4 flex flex-col justify-center">
                      <span class="text-[7px] md:text-[8px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-1">
                        <?php echo esc_html(get_sub_field('stat2_label')); ?>
                      </span>
                      <span class="text-xl md:text-2xl font-normal text-gray-900">
                        <?php echo esc_html(get_sub_field('stat2_val')); ?>
                      </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          <?php endwhile; endif; ?>

        </div>
        <div class="swiper-pagination md:hidden !bottom-0"></div>
      </div>
    </div>
  </section>

  <!-- ========================================== -->
  <!-- 4. OWNERSHIP EXPERIENCE GRID               -->
  <!-- ========================================== -->
  <section class="w-full bg-[#FAFCFD] md:bg-[#0B1115] py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
    <!-- Header Section -->
    <div class="max-w-4xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-24 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
      <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] md:text-[#4A99B2] font-bold mb-4 md:mb-6 block">
        <?php echo esc_html(get_field('experience_eyebrow') ?: 'The Breathe In Experience'); ?>
      </span>
      <h2 class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 md:text-white leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
        <?php echo esc_html(get_field('experience_headline') ?: 'Ownership as it should be.'); ?>
      </h2>
      <p class="text-gray-500 md:text-gray-400 text-[12px] md:text-[15px] font-light leading-relaxed max-w-2xl mx-0 md:mx-auto pr-4 md:pr-0">
        <?php echo esc_html(get_field('experience_subtext')); ?>
      </p>
    </div>

    <!-- Carousel/Grid Wrapper -->
    <div class="swiper ownershipSwiper max-w-[1400px] mx-auto md:border md:border-gray-800/60 pb-12 md:pb-0 overflow-visible md:overflow-hidden w-full scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100">
      <div class="swiper-wrapper md:!grid md:!grid-cols-3 lg:!grid-cols-5 md:!divide-x md:!divide-y lg:!divide-y-0 md:!divide-gray-800/60 md:!transform-none md:!w-full md:!h-auto">
        
        <?php if (have_rows('ownership_pillars')) : 
          while (have_rows('ownership_pillars')) : the_row(); 
            $num      = get_sub_field('number');
            $p_title  = get_sub_field('title');
            $p_desc   = get_sub_field('description');
            $p_svg    = get_sub_field('icon_svg');
        ?>
          <div class="swiper-slide h-auto md:!w-auto md:!m-0">
            <div class="p-6 md:p-10 flex flex-col h-full bg-white md:bg-[#0B1115] shadow-sm md:shadow-none rounded-xl md:rounded-none hover:md:bg-[#0F171C] transition-colors duration-300">
              <span class="hidden md:block text-[11px] text-[#4A99B2] font-medium tracking-widest mb-6">
                <?php echo esc_html($num); ?>
              </span>

              <div class="flex items-center md:items-start md:flex-col mb-3 md:mb-0">
                <div class="w-12 h-12 md:w-auto md:h-auto rounded-full md:rounded-none bg-[#EDF3F6] md:bg-transparent flex items-center justify-center shrink-0 mr-4 md:mr-0 md:mb-8 text-[#156E8A] md:text-[#4A99B2]">
                  <?php if ($p_svg) : ?>
                    <div class="w-6 h-6 flex items-center justify-center">
                      <?php echo $p_svg; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <h3 class="text-[17px] md:text-lg font-medium md:font-normal text-gray-900 md:text-white mb-0 md:mb-4">
                  <?php echo esc_html($p_title); ?>
                </h3>
              </div>

              <p class="text-[15px] md:text-xs text-gray-500 md:text-gray-400 font-light leading-relaxed pr-2 md:pr-0">
                <?php echo esc_html($p_desc); ?>
              </p>
            </div>
          </div>
        <?php endwhile; endif; ?>

      </div>
      <div class="swiper-pagination md:hidden !bottom-0"></div>
    </div>
  </section>

  <!-- ========================================== -->
  <!-- 5. DARK CTA SECTION (REUSED VIA TEMPLATE PART) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php get_footer(); ?>