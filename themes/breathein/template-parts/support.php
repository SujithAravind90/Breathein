<?php
/**
 * Template Name: Support Page 
 */

get_header(); 
?>

<main class="support-page bg-[#F7F9FA] relative">

  <!-- Soft Radial Glow (Top Right) -->
  <div class="hidden md:block absolute inset-0 pointer-events-none" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

  <!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED FROM TEMPLATE-PARTS) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <!-- ========================================== -->
  <!-- 2. QUICK HELP SECTION                      -->
  <!-- ========================================== -->
  <section class="max-w-[1300px] mx-auto px-6 md:px-10 lg:px-20 pt-10 lg:pt-20 w-full relative z-10">
      
      <!-- Section Header -->
      <div class="mb-10 lg:mb-16">
          <div class="flex items-center gap-4 mb-4">
              <div class="w-8 h-px bg-[#156E8A]"></div>
              <p class="uppercase tracking-[0.2em] text-[10px] text-[#156E8A] font-bold">
                  <?php echo esc_html(get_field('quick_help_eyebrow') ?: 'Quick Help'); ?>
              </p>
          </div>
          <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 dark:text-white tracking-tight">
              <?php echo esc_html(get_field('quick_help_headline') ?: 'What can we help with?'); ?>
          </h2>
      </div>

      <!-- Help Cards Grid -->
      <?php if (have_rows('quick_help_cards')) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php while (have_rows('quick_help_cards')) : the_row(); 
              $card_title = get_sub_field('title');
              $card_desc  = get_sub_field('description');
              $card_link  = get_sub_field('link');
              $card_svg   = get_sub_field('icon_svg');

              $url    = $card_link ? esc_url($card_link['url']) : '#';
              $target = ($card_link && !empty($card_link['target'])) ? esc_attr($card_link['target']) : '_self';
              $label  = $card_link ? esc_html($card_link['title']) : 'Learn More';
            ?>
              <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="group flex flex-col bg-white dark:bg-tickerDark border border-gray-200 dark:border-gray-800 rounded-[8px] p-5 lg:p-10 hover:border-[#156E8A] dark:hover:border-[#156E8A] transition-colors shadow-sm lg:shadow-none hover:shadow-md dark:hover:shadow-none">
                  
                  <!-- Icon Container -->
                  <div class="w-14 h-14 rounded-full bg-[#F0F5F7] dark:bg-[#111a20] flex items-center justify-center mb-4 text-gray-900 dark:text-gray-200 transition-colors group-hover:bg-[#E5F0F4] dark:group-hover:bg-gray-800 shrink-0">
                      <?php if ($card_svg) : ?>
                        <div class="w-[22px] h-[22px] flex items-center justify-center">
                          <?php echo $card_svg; ?>
                        </div>
                      <?php endif; ?>
                  </div>

                  <!-- Content -->
                  <h3 class="text-[18px] md:text-[20px] text-gray-900 dark:text-white font-normal mb-3 tracking-tight">
                      <?php echo esc_html($card_title); ?>
                  </h3>
                  <p class="text-[14px] text-gray-500 dark:text-gray-400 font-light leading-relaxed mb-4 flex-1">
                      <?php echo esc_html($card_desc); ?>
                  </p>

                  <!-- Link Indicator -->
                  <div class="flex items-center gap-2 text-[11px] text-[#156E8A] dark:text-brandTeal font-bold uppercase tracking-[0.15em] group-hover:gap-3 transition-all">
                      <?php echo $label; ?> <span class="text-sm leading-none mb-[2px]">&rarr;</span>
                  </div>
              </a>
            <?php endwhile; ?>
        </div>
      <?php endif; ?>

  </section>

  <!-- ========================================== -->
  <!-- 3. TALK TO US / CONTACT SUPPORT SECTION    -->
  <!-- ========================================== -->
  <section class="max-w-[1300px] mx-auto px-6 md:px-10 lg:px-20 pt-10 lg:pt-20 py-10 lg:py-20 relative z-10">
      
      <!-- Section Header -->
      <div class="mb-12 lg:mb-16">
          <div class="flex items-center gap-4 mb-4">
              <div class="w-8 h-px bg-[#156E8A]"></div>
              <p class="uppercase tracking-[0.2em] text-[10px] text-[#156E8A] font-bold">
                  <?php echo esc_html(get_field('talk_eyebrow') ?: 'Talk To Us'); ?>
              </p>
          </div>
          <h2 class="text-3xl md:text-4xl lg:text-[42px] font-light text-gray-900 dark:text-white tracking-tight mb-4 leading-tight">
              <?php echo esc_html(get_field('talk_headline') ?: 'Reach our care team directly'); ?>
          </h2>
          <p class="text-[15px] text-gray-500 dark:text-gray-400 font-light">
              <?php echo esc_html(get_field('talk_subtitle') ?: 'Available Monday to Saturday, 10:00 AM – 6:00 PM IST.'); ?>
          </p>
      </div>

      <!-- Contact Cards Grid -->
      <?php if (have_rows('contact_cards')) : ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <?php while (have_rows('contact_cards')) : the_row(); 
              $c_title   = get_sub_field('title');
              $c_desc    = get_sub_field('description');
              $c_text    = get_sub_field('link_text');
              $c_url     = get_sub_field('link_url');
              $c_subtext = get_sub_field('subtext');
              $c_svg     = get_sub_field('icon_svg');

              $is_external = (strpos($c_url, 'http') === 0);
            ?>
              <div class="flex flex-col items-center text-center bg-white dark:bg-tickerDark border border-gray-200 dark:border-gray-800 rounded-[8px] p-8 hover:border-[#156E8A] dark:hover:border-[#156E8A] transition-colors shadow-sm lg:shadow-none hover:shadow-md dark:hover:shadow-none group">
                  
                  <!-- Icon -->
                  <div class="w-[60px] h-[60px] rounded-full bg-[#F0F5F7] dark:bg-[#111a20] flex items-center justify-center mb-8 text-gray-900 dark:text-gray-200 transition-colors group-hover:bg-[#E5F0F4] dark:group-hover:bg-gray-800 shrink-0">
                      <?php if ($c_svg) : ?>
                        <div class="w-6 h-6 flex items-center justify-center">
                          <?php echo $c_svg; ?>
                        </div>
                      <?php endif; ?>
                  </div>

                  <!-- Title & Description -->
                  <h3 class="text-[18px] md:text-[20px] text-gray-900 dark:text-white font-normal mb-3 tracking-tight">
                    <?php echo esc_html($c_title); ?>
                  </h3>
                  <p class="text-[14px] text-gray-500 dark:text-gray-400 font-light leading-relaxed mb-4 flex-1">
                    <?php echo esc_html($c_desc); ?>
                  </p>

                  <!-- Contact Link -->
                  <a href="<?php echo esc_url($c_url); ?>" <?php echo $is_external ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="text-[16px] text-[#156E8A] dark:text-brandTeal font-medium mb-2 hover:opacity-80 transition-opacity">
                      <?php echo esc_html($c_text); ?>
                  </a>

                  <!-- Subtext / Hours -->
                  <span class="text-[11px] text-gray-400 font-light">
                    <?php echo esc_html($c_subtext); ?>
                  </span>
              </div>
            <?php endwhile; ?>
        </div>
      <?php endif; ?>

  </section>

  <!-- ========================================== -->
  <!-- 4. DARK CTA SECTION (REUSED FROM TEMPLATE-PARTS) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php get_footer(); ?>