<?php
/**
 * Template Name: Case Studies Listing
 */

get_header(); 
?>

<main class="case-studies-page bg-[#FAFCFD] relative">

  <!-- Soft Radial Glow Background -->
  <div class="hidden md:block absolute inset-0 pointer-events-none" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

  <!-- ========================================== -->
  <!-- 1. HERO SECTION                            -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <!-- ========================================== -->
  <!-- 2. CASE STUDIES GRID SECTION               -->
  <!-- ========================================== -->
  <section class="max-w-[1400px] mx-auto px-6 md:px-10 lg:px-16 py-16 lg:py-24 font-sans relative z-10">

        <!-- Section Header (Optional, adjust as needed) -->
        <div class="mb-10 lg:mb-12">
            <h2 class="text-3xl md:text-4xl font-light text-gray-900 dark:text-white tracking-tight">
                Case <span class="font-medium text-[#156E8A]">Studies</span>
            </h2>
        </div>

      <?php 
        $args = array(
          'post_type'      => 'case_study',
          'posts_per_page' => -1,
          'post_status'    => 'publish'
        );
        $case_query = new WP_Query($args);
      ?>

      <?php if ($case_query->have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
          
          <?php while ($case_query->have_posts()) : $case_query->the_post(); 
            $cat_tag    = get_field('category_tag') ?: 'Residential · Mumbai';
            $short_desc = get_field('short_description') ?: (has_excerpt() ? get_the_excerpt() : '');
            $s1_val     = get_field('stat1_value') ?: '94%';
            $s1_lbl     = get_field('stat1_label') ?: 'PM2.5 Drop';
            $s2_val     = get_field('stat2_value') ?: '2';
            $s2_lbl     = get_field('stat2_label') ?: 'AirPro 2 Units';

            // Dynamic Image Logic: ACF field -> Featured Image -> Fallback
            $acf_img = get_field('case_study_image');
            if (is_array($acf_img) && !empty($acf_img['url'])) {
                $img_url = $acf_img['url'];
            } elseif (is_numeric($acf_img)) {
                $img_url = wp_get_attachment_image_url($acf_img, 'large');
            } elseif (is_string($acf_img) && !empty($acf_img)) {
                $img_url = $acf_img;
            } elseif (has_post_thumbnail()) {
                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            } else {
                $img_url = get_template_directory_uri() . '/assets/images/case-study-1.png';
            }
          ?>

            <!-- Case Study Card -->
            <a href="<?php the_permalink(); ?>" class="flex flex-col bg-white border border-gray-200 hover:border-[#156E8A] transition-all duration-300 group cursor-pointer h-auto rounded-[4px] overflow-hidden shadow-sm hover:shadow-md">
                <div class="relative w-full h-[220px] md:h-[240px] bg-gray-100 overflow-hidden shrink-0">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute top-0 left-0 bg-white/95 backdrop-blur-sm px-4 py-2 text-[9px] text-[#156E8A] font-bold uppercase tracking-[0.2em]">
                        <?php echo esc_html($cat_tag); ?>
                    </div>
                </div>

                <div class="p-5 md:p-6 flex flex-col flex-1">
                    <p class="text-[11px] text-gray-500 mb-2 font-medium uppercase tracking-wider">
                      <?php echo esc_html($cat_tag); ?>
                    </p>
                    <h3 class="text-[19px] lg:text-[21px] text-gray-900 font-normal mb-3 leading-snug tracking-tight group-hover:text-[#156E8A] transition-colors">
                      <?php the_title(); ?>
                    </h3>
                    
                    <?php if ($short_desc) : ?>
                      <p class="text-[13px] text-gray-500 font-light leading-relaxed mb-6">
                        <?php echo esc_html($short_desc); ?>
                      </p>
                    <?php endif; ?>

                    <div class="border-t border-gray-100 pt-5 mt-auto">
                        <div class="flex gap-8 mb-5">
                            <div class="flex flex-col">
                                <span class="text-xl text-gray-900 font-medium mb-0.5"><?php echo esc_html($s1_val); ?></span>
                                <span class="text-[9px] uppercase tracking-[0.15em] text-gray-400 font-bold"><?php echo esc_html($s1_lbl); ?></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xl text-gray-900 font-medium mb-0.5"><?php echo esc_html($s2_val); ?></span>
                                <span class="text-[9px] uppercase tracking-[0.15em] text-gray-400 font-bold"><?php echo esc_html($s2_lbl); ?></span>
                            </div>
                        </div>
                        <div class="text-[10px] text-[#156E8A] font-bold uppercase tracking-[0.15em] flex items-center gap-2 group-hover:gap-3 transition-all">
                            Read the story <span class="text-sm leading-none">&rarr;</span>
                        </div>
                    </div>
                </div>
            </a>

          <?php endwhile; wp_reset_postdata(); ?>

        </div>
      <?php else : ?>
        <div class="border-2 border-dashed border-gray-200 rounded-[6px] p-12 text-center">
          <h3 class="text-lg font-medium text-gray-900 mb-2">No Case Studies Published Yet</h3>
          <p class="text-gray-500 text-sm mb-6">Go to your WordPress Admin dashboard and add your first case study post.</p>
          <a href="<?php echo esc_url(admin_url('post-new.php?post_type=case_study')); ?>" class="inline-flex bg-[#156E8A] text-white px-6 py-3 rounded-[2px] text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-[#115a72] transition-colors">
            + Add New Case Study
          </a>
        </div>
      <?php endif; ?>

  </section>

  <!-- ========================================== -->
  <!-- 3. DARK CTA SECTION                        -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php get_footer(); ?>