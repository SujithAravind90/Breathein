<?php
/**
 * Template Name: App Page 
 */

get_header(); 
?>

<main class="app-page">

  <!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED VIA TEMPLATE PART) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>
  <!-- ========================================== -->
  <!-- 2. APP SHOWCASE SECTION                    -->
  <!-- ========================================== -->
  <section class="w-full bg-[#0A1014] md:bg-white py-10 md:py-20 px-6 md:px-16 lg:px-24 overflow-hidden">
    <div class="max-w-7xl mx-auto flex flex-col lg:grid lg:grid-cols-2 lg:grid-rows-[auto_1fr] gap-x-16 lg:gap-x-24 lg:gap-y-2 items-start lg:items-center">
      
      <!-- Text Group -->
      <div class="order-1 lg:col-start-1 lg:row-start-1 w-full flex flex-col scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
        <span class="text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
          <?php echo esc_html(get_field('app_eyebrow') ?: 'Breathe In App'); ?>
        </span>

        <h2 class="text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-white md:text-gray-900 leading-[1.1] mb-6">
          <?php echo wp_kses(get_field('app_headline') ?: 'Your air, <span class="text-[#156E8A] font-bold">in your <br class="hidden md:block" /> hands.</span>', array('span' => array('class' => array()), 'br' => array('class' => array()))); ?>
        </h2>

        <p class="text-gray-400 md:text-gray-500 text-sm font-light leading-relaxed mb-4 md:mb-10 max-w-lg">
          <?php echo esc_html(get_field('app_subtext')); ?>
        </p>
      </div>

      <!-- Mockup Images -->
      <?php 
        $img_mobile  = get_field('app_mockup_mobile');
        $img_desktop = get_field('app_mockup_desktop');
      ?>
      <div class="order-2 lg:col-start-2 lg:row-start-1 lg:row-span-2 relative w-full flex justify-center scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-200">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] md:w-[300px] h-[250px] md:h-[300px] bg-[#156E8A]/10 md:bg-[#156E8A]/5 rounded-full blur-[60px] pointer-events-none"></div>

        <!-- Mobile Mockup -->
        <?php if ($img_mobile) : ?>
          <img src="<?php echo esc_url($img_mobile['url']); ?>" alt="<?php echo esc_attr($img_mobile['alt']); ?>" class="block md:hidden w-full max-w-[320px] h-auto object-contain relative z-10 animate-float" />
        <?php else : ?>
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/app-mockup-mobile.png'); ?>" alt="Breathe In App Mobile" class="block md:hidden w-full max-w-[320px] h-auto object-contain relative z-10 animate-float" />
        <?php endif; ?>

        <!-- Desktop Mockup -->
        <?php if ($img_desktop) : ?>
          <img src="<?php echo esc_url($img_desktop['url']); ?>" alt="<?php echo esc_attr($img_desktop['alt']); ?>" class="hidden md:block w-full max-w-[450px] h-auto object-contain relative z-10 animate-float" />
        <?php else : ?>
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/app-mockup.png'); ?>" alt="Breathe In App Interface" class="hidden md:block w-full max-w-[450px] h-auto object-contain relative z-10 animate-float" />
        <?php endif; ?>
      </div>

      <!-- Features & App Store Badges -->
      <div class="order-3 lg:col-start-1 lg:row-start-2 w-full flex flex-col scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out delay-100">
        
        <!-- Features List -->
        <?php if (have_rows('app_features')) : ?>
          <div class="flex flex-col border-t border-gray-800/80 md:border-t-0 divide-y divide-gray-800/80 md:divide-gray-100 mb-10 md:mb-12">
            <?php while (have_rows('app_features')) : the_row(); 
              $svg_icon = get_sub_field('icon_svg');
            ?>
              <div class="py-5 flex items-start gap-4 md:gap-5">
                <div class="mt-0.5 text-[#156E8A] bg-[#111A20] md:bg-sky-50 p-2.5 md:p-2 rounded-full shrink-0">
                  <?php if ($svg_icon) : ?>
                    <div class="w-[18px] h-[18px] flex items-center justify-center">
                      <?php echo $svg_icon; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div>
                  <h4 class="text-[15px] text-gray-100 md:text-gray-900 font-medium mb-1">
                    <?php echo esc_html(get_sub_field('title')); ?>
                  </h4>
                  <p class="text-[11px] text-gray-400 md:text-gray-500 font-light leading-relaxed">
                    <?php echo esc_html(get_sub_field('description')); ?>
                  </p>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

        <!-- App Store Download Buttons -->
        <?php 
          $ios_url     = get_field('app_store_ios_url') ?: '#';
          $android_url = get_field('app_store_android_url') ?: '#';
        ?>
        <div class="grid grid-cols-2 md:flex md:flex-wrap items-center gap-3 md:gap-4">
          <!-- iOS Button -->
          <a href="<?php echo esc_url($ios_url); ?>" class="flex items-center justify-center md:justify-start gap-2.5 md:gap-3 px-3 md:px-5 py-3 md:py-2.5 border border-gray-800 md:border-gray-200 hover:border-gray-500 md:hover:border-gray-300 md:hover:bg-gray-50 transition-all rounded-xl group text-white md:text-[#141414]">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor"><path d="M15.6292 11.4953C15.6109 9.47859 17.2793 8.50693 17.3526 8.46109C16.4176 7.08609 14.9601 6.90276 14.4376 6.88443C13.2001 6.75609 12.0176 7.61776 11.3851 7.61776C10.7526 7.61776 9.79008 6.90276 8.76342 6.92109C7.41592 6.93943 6.16925 7.70943 5.47258 8.91943C4.07008 11.3578 5.11508 14.9694 6.48092 16.9494C7.15008 17.9211 7.94758 19.0119 8.99258 18.9753C10.0009 18.9386 10.3859 18.3244 11.6051 18.3244C12.8243 18.3244 13.1726 18.9753 14.2359 18.9569C15.3176 18.9386 16.0051 17.9669 16.6651 16.9861C17.4351 15.8586 17.7467 14.7678 17.7651 14.7128C17.7376 14.7036 15.6659 13.9061 15.6476 11.5136L15.6292 11.4953ZM13.6401 5.46359C14.1901 4.79443 14.5659 3.86859 14.4651 2.93359C13.6676 2.97026 12.6959 3.46526 12.1184 4.13443C11.6051 4.72109 11.1559 5.66526 11.2751 6.56359C12.1642 6.63693 13.0809 6.11443 13.6401 5.46359Z"/></svg>
            <div class="flex flex-col">
              <span class="text-[6px] md:text-[7px] uppercase tracking-widest text-gray-500 font-bold leading-none mb-1">Download on the</span>
              <span class="text-xs md:text-sm font-medium leading-none">App Store</span>
            </div>
          </a>

          <!-- Android Button -->
          <a href="<?php echo esc_url($android_url); ?>" class="flex items-center justify-center md:justify-start gap-2.5 md:gap-3 px-3 md:px-5 py-3 md:py-2.5 border border-gray-800 md:border-gray-200 hover:border-gray-500 md:hover:border-gray-300 md:hover:bg-gray-50 transition-all rounded-xl group text-white md:text-[#141414]">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor"><path d="M3.30042 2.20013C3.05292 2.4568 2.90625 2.86013 2.90625 3.37346V18.6268C2.90625 19.1401 3.05292 19.5435 3.30042 19.8001L3.35542 19.846L11.9171 11.0643V10.936L3.35542 2.1543L3.30042 2.20013ZM14.9421 14.0893L12.1004 11.2476V11.1193L14.9421 8.27763L15.0063 8.3143L18.3704 10.2301C19.3329 10.7801 19.3329 11.6693 18.3704 12.2193L15.0063 14.1351L14.9421 14.181V14.0893ZM14.6029 14.4285L11.6971 11.4585L3.30042 19.846C3.62125 20.1851 4.14375 20.2218 4.73958 19.8918L14.6029 14.4285ZM14.6029 8.48846L4.73958 3.02513C4.14375 2.69513 3.62125 2.7318 3.30042 3.07096L11.6971 11.4585L14.6029 8.48846Z"/></svg>
            <div class="flex flex-col">
              <span class="text-[6px] md:text-[7px] uppercase tracking-widest text-gray-500 font-bold leading-none mb-1">Get it on</span>
              <span class="text-xs md:text-sm font-medium leading-none">Google Play</span>
            </div>
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================== -->
  <!-- 3. SETUP INSTRUCTIONS SECTION              -->
  <!-- ========================================== -->
  <section class="w-full bg-[#0B1115] py-10 lg:py-20 px-6 md:px-10 lg:px-20">
    <div class="max-w-[1400px] mx-auto">
      
      <!-- Header Area -->
      <div class="text-left lg:text-center max-w-3xl mx-auto mb-12 lg:mb-20">
        <span class="text-[11px] md:text-[12px] uppercase tracking-[0.2em] md:tracking-[0.25em] text-[#156E8A] font-bold mb-4 block">
          <?php echo esc_html(get_field('setup_eyebrow') ?: 'Set up in a minute'); ?>
        </span>

        <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-6 tracking-tight">
          <?php echo wp_kses(get_field('setup_headline') ?: 'Connected before your <span class="text-[#156E8A]">first <br class="hidden lg:block" /> breath.</span>', array('span' => array('class' => array()), 'br' => array('class' => array()))); ?>
        </h2>

        <?php if (get_field('setup_subtext_mobile')) : ?>
          <p class="text-gray-400 font-light text-[15px] md:text-sm leading-relaxed lg:hidden">
            <?php echo esc_html(get_field('setup_subtext_mobile')); ?>
          </p>
        <?php endif; ?>

        <?php if (get_field('setup_subtext_desktop')) : ?>
          <p class="text-gray-400 font-light text-base leading-relaxed hidden lg:block">
            <?php echo esc_html(get_field('setup_subtext_desktop')); ?>
          </p>
        <?php endif; ?>
      </div>

      <!-- Steps Grid Repeater -->
      <?php if (have_rows('setup_steps')) : ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">
          <?php while (have_rows('setup_steps')) : the_row(); ?>
            <div class="flex flex-col lg:justify-between gap-4 lg:gap-0 lg:min-h-[280px] p-6 lg:p-12 border border-gray-800 lg:border-none bg-transparent lg:bg-white rounded-xl lg:rounded-none">
              <span class="text-[11px] lg:text-[15px] tracking-[0.2em] lg:tracking-normal font-bold text-[#156E8A] uppercase lg:normal-case">
                <?php echo esc_html(get_sub_field('step_label')); ?>
              </span>
              <p class="text-gray-400 lg:text-gray-500 text-[15px] md:text-sm font-light leading-relaxed">
                <?php echo esc_html(get_sub_field('step_desc')); ?>
              </p>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ========================================== -->
  <!-- 4. DARK CTA SECTION                        -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php get_footer(); ?>