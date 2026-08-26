<?php
/**
 * Template Part: Reusable Dark CTA Section
 */
$target_id = get_the_ID();

// If on a single case study post, find the main Case Studies listing page ID
if (is_singular('case_study')) {
    // 1. Try finding by template name
    $case_study_pages = get_posts(array(
        'post_type'      => 'page',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-case-studies.php',
        'posts_per_page' => 1,
        'post_status'    => 'publish'
    ));

    if (!empty($case_study_pages)) {
        $target_id = $case_study_pages[0]->ID;
    } else {
        // 2. Fallback: Try finding by page slug 'case-studies'
        $slug_page = get_page_by_path('case-studies');
        if ($slug_page) {
            $target_id = $slug_page->ID;
        }
    }
}

// Fetch ACF fields using $target_id (no hardcoded defaults)
$cta_headline = get_field('cta_headline', $target_id);
$cta_subtext  = get_field('cta_subtext', $target_id);
$p_btn        = get_field('primary_button', $target_id);
$s_btn        = get_field('secondary_button', $target_id);
?>

<section class="w-full bg-[#0B1115] py-10 md:py-20 px-6 flex flex-col items-center justify-center text-center">
  <?php if ($cta_headline) : ?>
    <h2 class="text-4xl md:text-5xl lg:text-[56px] font-light text-white mb-6 md:mb-8 tracking-tight">
      <?php echo wp_kses($cta_headline, array('span' => array('class' => array()))); ?>
    </h2>
  <?php endif; ?>

  <?php if ($cta_subtext) : ?>
    <p class="text-gray-400 font-light text-[12px] md:text-[15px] max-w-2xl mx-auto mb-12 leading-relaxed">
      <?php echo esc_html($cta_subtext); ?>
    </p>
  <?php endif; ?>

  <?php if ($p_btn || $s_btn) : ?>
    <div class="flex flex-row items-center justify-center gap-6 sm:gap-10 w-full max-w-md sm:max-w-none">
      
      <!-- Primary Button -->
      <?php if ($p_btn) : ?>
        <a href="<?php echo esc_url($p_btn['url']); ?>" target="<?php echo esc_attr(!empty($p_btn['target']) ? $p_btn['target'] : '_self'); ?>" class="bg-white text-[#0B1115] px-4 py-4 md:py-4 uppercase text-[12px] md:text-[13px] tracking-[0.2em] font-bold flex items-center justify-center gap-3 hover:bg-gray-200 transition-colors rounded-xl w-full sm:w-auto">
          <span><?php echo esc_html($p_btn['title']); ?></span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
      <?php endif; ?>

      <!-- Secondary Button -->
      <?php if ($s_btn) : ?>
        <a href="<?php echo esc_url($s_btn['url']); ?>" target="<?php echo esc_attr(!empty($s_btn['target']) ? $s_btn['target'] : '_self'); ?>" class="text-white border-b border-gray-700 pb-1 uppercase text-[12px] md:text-[13px] tracking-[0.2em] font-bold hover:text-[#156E8A] hover:border-[#156E8A] transition-colors w-full sm:w-auto text-center mt-2 sm:mt-0">
          <?php echo esc_html($s_btn['title']); ?>
        </a>
      <?php endif; ?>

    </div>
  <?php endif; ?>
</section>