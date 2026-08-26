<?php
/**
 * Template Name: Single Case Study Template
 * Template Post Type: case_study
 */

get_header();

while (have_posts()) : the_post();
  $cat_tag     = get_field('category_tag') ?: 'Residential · Mumbai';
  $s1_val      = get_field('stat1_value') ?: '94%';
  $s1_lbl      = get_field('stat1_label') ?: 'PM2.5 drop';
  $s2_val      = get_field('stat2_value') ?: '2';
  $s2_lbl      = get_field('stat2_label') ?: 'Air Pro 2 units';
  $s3_val      = get_field('stat3_value') ?: '8hrs';
  $s3_lbl      = get_field('stat3_label') ?: 'To stable AQI';
  $challenge   = get_field('challenge_text');
  $solution    = get_field('solution_text');
  $result      = get_field('result_text');
  $quote       = get_field('quote_text');
  $author      = get_field('quote_author');
  $model_name  = get_field('model_used_name') ?: 'Air Pro 2';
  $model_link  = get_field('model_used_link');

  // Dynamic Hero Image Logic: ACF field -> Featured Image -> Fallback
  $acf_hero_img = get_field('case_study_image');
  if (is_array($acf_hero_img) && !empty($acf_hero_img['url'])) {
      $hero_bg_url = $acf_hero_img['url'];
  } elseif (is_numeric($acf_hero_img)) {
      $hero_bg_url = wp_get_attachment_image_url($acf_hero_img, 'full');
  } elseif (is_string($acf_hero_img) && !empty($acf_hero_img)) {
      $hero_bg_url = $acf_hero_img;
  } elseif (has_post_thumbnail()) {
      $hero_bg_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  } else {
      $hero_bg_url = get_template_directory_uri() . '/assets/images/case-study-details-1.png';
  }
?>

<main class="single-case-study-page bg-[#FAFCFD]">

    <!-- 1. DYNAMIC HERO SECTION -->
    <section class="relative w-full h-[40vh] min-h-[350px] lg:h-[50vh] lg:min-h-[450px] flex items-center font-sans">
        <div class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo esc_url($hero_bg_url); ?>');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/40 to-transparent"></div>
        <div class="absolute inset-0 bg-black/30 md:hidden"></div> 

        <div class="relative z-10 w-full max-w-[1300px] mx-auto px-6 md:px-10 lg:px-16 pt-12 md:pt-0">
            <div class="max-w-3xl">
                <div class="inline-flex items-center bg-[#156E8A] text-white px-3 py-1.5 mb-6 lg:mb-8 text-[10px] md:text-[11px] font-bold uppercase tracking-[0.15em] rounded-xl">
                    <?php echo esc_html($cat_tag); ?>
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-[60px] font-light text-white leading-[1.2] lg:leading-[1.15] tracking-tight">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>
    </section>

    <!-- 2. ARTICLE BODY -->
    <section class="w-full bg-white py-10 md:py-20 px-6 font-sans">
        <div class="max-w-[1400px] mx-auto mb-10 md:mb-16">
            <nav class="text-[11px] text-gray-500 font-medium uppercase tracking-[0.15em]">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-gray-900 transition-colors">Home</a>
                <span class="mx-2">/</span>
                <a href="<?php echo esc_url(home_url('/case-studies')); ?>" class="hover:text-gray-900 transition-colors">Case Studies</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900"><?php the_title(); ?></span>
            </nav>
        </div>

        <!-- Big 3 Stats -->
        <div class="max-w-[800px] mx-auto mb-10 md:mb-20">
            <div class="flex flex-row border border-gray-200 divide-x divide-gray-200">
                <div class="flex-1 flex flex-col items-center justify-center py-5 md:py-12">
                    <span class="text-[20px] md:text-[40px] text-[#156E8A] font-light tracking-tight mb-2"><?php echo esc_html($s1_val); ?></span>
                    <span class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold"><?php echo esc_html($s1_lbl); ?></span>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center py-5 md:py-12">
                    <span class="text-[20px] md:text-[40px] text-[#156E8A] font-light tracking-tight mb-2"><?php echo esc_html($s2_val); ?></span>
                    <span class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold"><?php echo esc_html($s2_lbl); ?></span>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center py-5 md:py-12">
                    <span class="text-[20px] md:text-[40px] text-[#156E8A] font-light tracking-tight mb-2"><?php echo esc_html($s3_val); ?></span>
                    <span class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold"><?php echo esc_html($s3_lbl); ?></span>
                </div>
            </div>
        </div>

        <!-- Narrative Content -->
        <div class="max-w-[700px] mx-auto space-y-12 md:space-y-16">
            <?php if ($challenge) : ?>
              <div>
                  <h2 class="text-2xl md:text-[30px] font-light text-gray-900 mb-4 md:mb-6">The challenge</h2>
                  <p class="text-[14px] md:text-[15px] text-gray-600 font-light leading-relaxed">
                      <?php echo nl2br(esc_html($challenge)); ?>
                  </p>
              </div>
            <?php endif; ?>

            <?php if ($solution) : ?>
              <div>
                  <h2 class="text-2xl md:text-[30px] font-light text-gray-900 mb-4 md:mb-6">The solution</h2>
                  <p class="text-[14px] md:text-[15px] text-gray-600 font-light leading-relaxed">
                      <?php echo nl2br(esc_html($solution)); ?>
                  </p>
              </div>
            <?php endif; ?>

            <?php if ($result) : ?>
              <div>
                  <h2 class="text-2xl md:text-[30px] font-light text-gray-900 mb-4 md:mb-6">The result</h2>
                  <p class="text-[14px] md:text-[15px] text-gray-600 font-light leading-relaxed mb-10">
                      <?php echo nl2br(esc_html($result)); ?>
                  </p>
                  
                  <?php if ($quote) : ?>
                    <blockquote class="border-l-[3px] border-[#156E8A] pl-6 py-2">
                        <p class="text-lg md:text-[20px] text-gray-800 font-light italic leading-relaxed mb-4">
                            "<?php echo esc_html($quote); ?>"
                        </p>
                        <?php if ($author) : ?>
                          <footer class="text-[11px] text-gray-500 font-medium">
                              <?php echo esc_html($author); ?>
                          </footer>
                        <?php endif; ?>
                    </blockquote>
                  <?php endif; ?>
              </div>
            <?php endif; ?>

            <!-- Model Box -->
            <div class="mt-16 md:mt-24 border border-gray-200 rounded-[4px] p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-1">Model used</span>
                    <h4 class="text-xl md:text-2xl font-light text-gray-900"><?php echo esc_html($model_name); ?></h4>
                </div>
                
                <?php 
                  $m_url    = is_array($model_link) ? ($model_link['url'] ?? '#') : (!empty($model_link) ? $model_link : '#');
                  $m_target = (is_array($model_link) && !empty($model_link['target'])) ? esc_attr($model_link['target']) : '_self';
                ?>
                <a href="<?php echo esc_url($m_url); ?>" target="<?php echo $m_target; ?>" class="w-full md:w-auto bg-[#111111] hover:bg-black text-white px-8 py-4 rounded-[2px] text-[11px] font-bold uppercase tracking-[0.2em] flex items-center justify-center gap-3 transition-colors">
                    <span>View <?php echo esc_html($model_name); ?></span> <span class="text-lg leading-none mb-[2px]">&rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 3. MORE STORIES (DYNAMIC IMAGES) -->
    <?php 
      $current_id = get_the_ID();
      $more_args = array(
        'post_type'      => 'case_study',
        'posts_per_page' => 2,
        'post__not_in'   => array($current_id),
        'post_status'    => 'publish'
      );
      $more_query = new WP_Query($more_args);
    ?>

    <?php if ($more_query->have_posts()) : ?>
      <section class="w-full bg-white dark:bg-[#050505] py-16 md:py-24 px-6 font-sans border-t border-gray-100 dark:border-gray-900">
          <div class="max-w-[1300px] mx-auto">
              <div class="flex items-center gap-4 mb-8 md:mb-10">
                  <div class="w-8 h-[1px] bg-[#156E8A]"></div>
                  <h3 class="text-[10px] md:text-[11px] uppercase tracking-[0.2em] text-[#156E8A] font-bold">
                      More stories
                  </h3>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                  <?php while ($more_query->have_posts()) : $more_query->the_post(); 
                    $m_cat_tag = get_field('category_tag') ?: 'Healthcare';
                    
                    // Dynamic image for related posts
                    $m_acf_img = get_field('case_study_image');
                    if (is_array($m_acf_img) && !empty($m_acf_img['url'])) {
                        $m_img_url = $m_acf_img['url'];
                    } elseif (has_post_thumbnail()) {
                        $m_img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    } else {
                        $m_img_url = get_template_directory_uri() . '/assets/images/story-healthcare.png';
                    }
                  ?>
                    <a href="<?php the_permalink(); ?>" class="group flex flex-col bg-white dark:bg-tickerDark rounded-[6px] overflow-hidden border border-gray-200 dark:border-gray-800 hover:border-[#156E8A] dark:hover:border-[#156E8A] transition-colors shadow-sm lg:shadow-none hover:shadow-md dark:hover:shadow-none cursor-pointer">
                        <div class="relative w-full h-[200px] md:h-[220px] bg-gray-100 dark:bg-gray-900 overflow-hidden shrink-0">
                            <img src="<?php echo esc_url($m_img_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute top-4 left-4 bg-white/95 dark:bg-tickerDark/95 backdrop-blur-sm px-3 py-1.5 text-[9px] text-[#156E8A] dark:text-brandTeal font-bold uppercase tracking-[0.15em] rounded-[2px] shadow-sm">
                                <?php echo esc_html($m_cat_tag); ?>
                            </div>
                        </div>

                        <div class="p-6 md:p-8 flex flex-col flex-1">
                            <h4 class="text-[17px] md:text-[18px] text-gray-900 dark:text-white font-normal mb-8 leading-snug">
                                <?php the_title(); ?>
                            </h4>
                            <div class="mt-auto text-[11px] text-[#156E8A] dark:text-brandTeal font-bold uppercase tracking-[0.15em] flex items-center gap-2 group-hover:gap-3 transition-all">
                                Read <span class="text-sm leading-none mb-[2px]">&rarr;</span>
                            </div>
                        </div>
                    </a>
                  <?php endwhile; wp_reset_postdata(); ?>
              </div>
          </div>
      </section>
    <?php endif; ?>

    <!-- 4. DARK CTA SECTION -->
    <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php 
endwhile;
get_footer(); 
?>