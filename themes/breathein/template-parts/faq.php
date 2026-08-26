<?php
/**
 * Template Name: FAQ Page 
 */

get_header(); 

// Fetch topics and FAQ items safely
$topics = get_field('faq_topics');
$faq_items = get_field('faq_items');
?>

<main class="faq-page bg-[#FAFCFD]">

  <!-- Soft Radial Glow (Top Right) -->
  <div class="hidden md:block absolute inset-0 pointer-events-none" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

  <!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED VIA TEMPLATE PART) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <!-- ========================================== -->
  <!-- 2. FAQ INTERACTIVE SECTION                 -->
  <!-- ========================================== -->
  <section class="w-full bg-white dark:bg-[#050505] py-8 lg:py-24 px-6 md:px-10 lg:px-16 font-sans transition-colors duration-300 relative z-10">

    <!-- ========================================== -->
    <!-- MOBILE / TABLET HORIZONTAL TABS (DYNAMIC)  -->
    <!-- ========================================== -->
    <div class="lg:hidden w-full overflow-x-auto border-b border-gray-200 dark:border-gray-800 px-0 md:-mx-10 md:px-10 mb-8 sticky top-0 bg-white/95 dark:bg-[#050505]/95 backdrop-blur-sm z-20 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
      <div class="flex flex-row w-max gap-2" id="faq-mobile-tabs">
        <button type="button" data-filter="all" class="mob-filter-btn faq-filter-btn border-b-2 border-[#156E8A] dark:border-[#2094B6] text-[#156E8A] dark:text-[#2094B6] px-4 py-4 text-[12px] font-bold uppercase tracking-[0.15em] shrink-0 transition-colors whitespace-nowrap -mb-px">
          All
        </button>

        <?php if (is_array($topics) && !empty($topics)) : 
          foreach ($topics as $t) : 
            $t_name = $t['topic_name'];
            $t_slug = !empty($t['topic_slug']) ? sanitize_title($t['topic_slug']) : sanitize_title($t_name);
        ?>
          <button type="button" data-filter="<?php echo esc_attr($t_slug); ?>" class="mob-filter-btn faq-filter-btn border-b-2 border-transparent text-gray-500 hover:text-gray-900 dark:hover:text-white px-3 py-4 text-[12px] font-bold uppercase tracking-[0.15em] shrink-0 transition-colors whitespace-nowrap -mb-px">
            <?php echo esc_html($t_name); ?>
          </button>
        <?php endforeach; endif; ?>
      </div>
    </div>

    <div class="max-w-[1200px] mx-auto flex flex-col lg:flex-row gap-16 lg:gap-24 items-start">

      <!-- ========================================== -->
      <!-- DESKTOP LEFT SIDEBAR (DYNAMIC)             -->
      <!-- ========================================== -->
      <div class="hidden lg:block w-full lg:w-[28%] lg:sticky lg:top-32 shrink-0">
        <div class="mb-12">
          <h4 class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-4">Browse by Topic</h4>
          <nav class="flex flex-col border-t border-gray-100 dark:border-gray-900" id="faq-desktop-tabs">
            <button type="button" data-filter="all" class="desk-filter-btn faq-filter-btn text-left py-4 border-b border-gray-100 dark:border-gray-900 text-[13px] font-medium text-[#156E8A] dark:text-[#2094B6] transition-colors">
              All
            </button>

            <?php if (is_array($topics) && !empty($topics)) : 
              foreach ($topics as $t) : 
                $t_name = $t['topic_name'];
                $t_slug = !empty($t['topic_slug']) ? sanitize_title($t['topic_slug']) : sanitize_title($t_name);
            ?>
              <button type="button" data-filter="<?php echo esc_attr($t_slug); ?>" class="desk-filter-btn faq-filter-btn text-left py-4 border-b border-gray-100 dark:border-gray-900 text-[13px] font-medium text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                <?php echo esc_html($t_name); ?>
              </button>
            <?php endforeach; endif; ?>
          </nav>
        </div>

        <!-- Support CTA Block (Desktop Only) -->
        <div>
          <h4 class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-2">Still have questions?</h4>
          <p class="text-[12px] text-gray-500 font-light mb-6">Our team responds in minutes via WhatsApp.</p>

          <a href="https://wa.me/919076636639" target="_blank" rel="noopener noreferrer" class="w-full bg-[#156E8A] text-white px-5 py-4 rounded-[2px] text-[10px] font-bold uppercase tracking-[0.2em] flex items-center justify-between hover:bg-[#115a72] transition-colors mb-3">
            <span>WhatsApp Us</span>
            <span class="text-sm leading-none">&rarr;</span>
          </a>

          <a href="mailto:enquiries@breathein.co.in" class="w-full bg-white dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white px-5 py-4 rounded-[2px] text-[10px] font-bold uppercase tracking-[0.2em] flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
            <span>Email Support</span>
            <span class="text-sm leading-none">&rarr;</span>
          </a>
        </div>
      </div>

      <!-- ========================================== -->
      <!-- RIGHT COLUMN: DYNAMIC FAQ ACCORDIONS       -->
      <!-- ========================================== -->
      <div class="w-full lg:w-[72%] flex flex-col border-t border-gray-100 dark:border-gray-900" id="faq-list">

        <?php if (is_array($faq_items) && !empty($faq_items)) : 
          foreach ($faq_items as $item) : 
            $cat_slug = sanitize_title($item['category_slug']);
            $question = $item['question'];
            $answer   = $item['answer'];
        ?>
          <div class="faq-item group border-b border-gray-100 dark:border-gray-900" data-category="<?php echo esc_attr($cat_slug); ?>">
            <button type="button" class="faq-toggle-btn w-full flex items-center py-5 md:py-6 text-left cursor-pointer select-none">
              <div class="w-8 h-8 rounded-full bg-[#F0F5F7] dark:bg-[#0c1318] flex items-center justify-center shrink-0 mr-5 text-[#156E8A] dark:text-[#2094B6] transition-transform duration-300 icon-container">
                <svg class="w-4 h-4 transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                </svg>
              </div>
              <span class="text-[14px] md:text-[15px] text-gray-900 dark:text-gray-200 group-hover:text-[#156E8A] dark:group-hover:text-[#2094B6] transition-colors pointer-events-none font-medium">
                <?php echo esc_html($question); ?>
              </span>
            </button>
            <div class="faq-content hidden pb-6 pl-13 md:pl-[52px]">
              <p class="text-[13px] md:text-[14px] text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                <?php echo nl2br(esc_html($answer)); ?>
              </p>
            </div>
          </div>
        <?php 
          endforeach;
        else : 
        ?>
          <div class="py-12 text-center text-gray-400 text-sm">
            No FAQ entries found. Add your questions under WP Admin &gt; Edit Page &gt; FAQ Specifics.
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>

  <!-- ========================================== -->
  <!-- 3. DARK CTA SECTION (REUSED VIA TEMPLATE)  -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<!-- ========================================== -->
<!-- BULLETPROOF ACCORDION & FILTER LOGIC       -->
<!-- ========================================== -->
<script>
(function() {
  function initFAQLogic() {
    const faqContainer = document.getElementById('faq-list');
    if (!faqContainer) return;

    // 1. Accordion Toggle via Container Event Delegation
    faqContainer.addEventListener('click', function(e) {
      const btn = e.target.closest('.faq-toggle-btn');
      if (!btn) return;

      e.preventDefault();
      const parent = btn.closest('.faq-item');
      if (!parent) return;

      const content = parent.querySelector('.faq-content');
      const icon = btn.querySelector('.icon-container svg');
      const isCurrentlyHidden = content.classList.contains('hidden');

      // Close all accordions
      faqContainer.querySelectorAll('.faq-content').forEach(function(c) {
        c.classList.add('hidden');
      });
      faqContainer.querySelectorAll('.icon-container svg').forEach(function(i) {
        i.classList.remove('rotate-180');
      });

      // If clicked one was closed, open it
      if (isCurrentlyHidden) {
        content.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
      }
    });

    // 2. Category Tab Filtering
    const allFilterBtns = document.querySelectorAll('.faq-filter-btn');
    const faqItems = faqContainer.querySelectorAll('.faq-item');

    allFilterBtns.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const selectedFilter = (this.getAttribute('data-filter') || 'all').toLowerCase().trim();

        // Update Desktop UI Classes
        document.querySelectorAll('#faq-desktop-tabs .faq-filter-btn').forEach(function(dBtn) {
          const dFilter = (dBtn.getAttribute('data-filter') || '').toLowerCase().trim();
          if (dFilter === selectedFilter) {
            dBtn.className = 'desk-filter-btn faq-filter-btn text-left py-4 border-b border-gray-100 dark:border-gray-900 text-[13px] font-medium text-[#156E8A] dark:text-[#2094B6] transition-colors';
          } else {
            dBtn.className = 'desk-filter-btn faq-filter-btn text-left py-4 border-b border-gray-100 dark:border-gray-900 text-[13px] font-medium text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors';
          }
        });

        // Update Mobile UI Classes
        document.querySelectorAll('#faq-mobile-tabs .faq-filter-btn').forEach(function(mBtn) {
          const mFilter = (mBtn.getAttribute('data-filter') || '').toLowerCase().trim();
          if (mFilter === selectedFilter) {
            mBtn.className = 'mob-filter-btn faq-filter-btn border-b-2 border-[#156E8A] dark:border-[#2094B6] text-[#156E8A] dark:text-[#2094B6] px-4 py-4 text-[12px] font-bold uppercase tracking-[0.15em] shrink-0 transition-colors whitespace-nowrap -mb-px';
          } else {
            mBtn.className = 'mob-filter-btn faq-filter-btn border-b-2 border-transparent text-gray-500 hover:text-gray-900 dark:hover:text-white px-3 py-4 text-[12px] font-bold uppercase tracking-[0.15em] shrink-0 transition-colors whitespace-nowrap -mb-px';
          }
        });

        // Toggle Visibility of Matching FAQ Items
        faqItems.forEach(function(item) {
          const itemCategory = (item.getAttribute('data-category') || '').toLowerCase().trim();
          if (selectedFilter === 'all' || itemCategory === selectedFilter) {
            item.style.display = 'block';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFAQLogic);
  } else {
    initFAQLogic();
  }
})();
</script>

<?php get_footer(); ?>