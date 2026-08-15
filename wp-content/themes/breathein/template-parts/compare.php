<?php
/**
 * Template Name: Compare Page 
 */

get_header(); 
?>

<main class="compare-page bg-[#F7F9FA]">

  <!-- Soft Radial Glow (Top Right) -->
  <div class="hidden md:block absolute inset-0 pointer-events-none" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

  <!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED FROM TEMPLATE-PARTS) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <?php 
    $models = get_field('compare_models');
  $rows   = get_field('compare_rows');

  // Safely check if $models is an array before counting
  $model_count = is_array($models) ? count($models) : 4;
  ?>

  <!-- ========================================== -->
  <!-- 2. MOBILE ONLY: MODEL COMPARISON SELECTOR  -->
  <!-- ========================================== -->
  <?php if (!empty($models)) : ?>
    <section class="block lg:hidden w-full bg-white px-6 py-6 border-b border-gray-100 relative z-10">
      <h4 class="text-[11px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-4">
        Select 2 models to compare
      </h4>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 w-full">
        <?php foreach ($models as $idx => $m) : 
          $is_selected = ($idx < 2); // First 2 selected by default
        ?>
          <div class="flex flex-col p-3 border <?php echo $is_selected ? 'border-[#156E8A] bg-[#F4F9FA]' : 'border-gray-200 bg-white'; ?> rounded-[2px] cursor-pointer transition-colors w-full">
            <h5 class="text-[14px] text-gray-900 font-medium mb-1">
              <?php echo esc_html($m['name']); ?>
            </h5>
            <span class="text-[12px] text-gray-400 font-light mb-4">
              <?php echo esc_html($m['price']); ?>
            </span>

            <?php if ($is_selected) : ?>
              <div class="flex items-center gap-1.5 text-[#156E8A] text-[12px] font-medium mt-auto">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                Selected
              </div>
            <?php else : ?>
              <div class="flex items-center gap-1.5 text-transparent text-[12px] font-medium mt-auto pointer-events-none">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                Selected
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- ========================================== -->
  <!-- 3. DYNAMIC COMPARISON TABLE SECTION        -->
  <!-- ========================================== -->
  <section class="w-full bg-[#FAFCFD] py-5 md:py-20 px-6 md:px-16 lg:px-24 relative z-10">
    
    <!-- Desktop Header Area -->
    <div class="hidden md:block max-w-3xl mx-0 md:mx-auto text-left md:text-center mb-10 md:mb-16 scroll-reveal opacity-0 translate-y-6 transition-all duration-700 ease-out">
      <span class="text-[11px] uppercase tracking-[0.25em] text-[#156E8A] font-bold mb-4 md:mb-6 block">
        <?php echo esc_html(get_field('compare_eyebrow') ?: 'Side by Side'); ?>
      </span>
      <h2 class="text-[32px] md:text-5xl font-light tracking-tight text-gray-900 leading-[1.15] md:leading-[1.2] mb-4 md:mb-6">
        <?php echo esc_html(get_field('compare_headline') ?: 'Find your perfect model.'); ?>
      </h2>
      <?php if (get_field('compare_subtext')) : ?>
        <p class="text-gray-500 text-[12px] md:text-[15px] font-light leading-relaxed max-w-xl mx-0 md:mx-auto">
          <?php echo esc_html(get_field('compare_subtext')); ?>
        </p>
      <?php endif; ?>
    </div>

    <!-- Dynamic Table Wrapper -->
    <div class="max-w-6xl mx-auto scroll-reveal opacity-0 translate-y-6 transition-all duration-700 delay-100 pb-8">
      <div class="overflow-x-auto md:overflow-visible no-scrollbar rounded-xl border border-gray-200 bg-white shadow-sm relative">
        
        <div class="grid grid-cols-[120px_repeat(<?php echo $model_count; ?>,minmax(140px,1fr))] md:grid-cols-<?php echo ($model_count + 1); ?> min-w-[700px] md:min-w-full">
          
          <!-- ================= HEADER ROW ================= -->
          <div class="p-5 md:p-8 sticky left-0 bg-white z-20 flex items-end text-[11px] uppercase tracking-[0.2em] text-gray-400 font-bold border-b border-gray-100">
            Feature
          </div>

          <?php if (is_array($models)) : foreach ($models as $m) :
              $is_highlighted = !empty($m['badge_text']);
          ?>
            <div class="p-5 md:p-8 flex flex-col items-center justify-center text-center <?php echo $is_highlighted ? 'bg-[#EDF3F6] relative' : ''; ?> border-b border-gray-100">
              <?php if ($is_highlighted) : ?>
                <div class="absolute top-0 right-0 md:-top-3 md:left-1/2 md:-translate-x-1/2 bg-[#156E8A] text-white text-[7px] md:text-[8px] uppercase tracking-widest font-bold px-3 py-1.5 md:whitespace-nowrap z-10 rounded-bl-md md:rounded-none">
                  <?php echo esc_html($m['badge_text']); ?>
                </div>
              <?php endif; ?>
              
              <h3 class="text-base md:text-xl font-medium md:font-normal text-gray-900 mb-1 md:mb-2 <?php echo $is_highlighted ? 'mt-4 md:mt-0' : ''; ?>">
                <?php echo esc_html($m['name']); ?>
              </h3>
              
              <span class="text-[11px] md:text-sm text-gray-400 md:text-[#156E8A] font-light">
                <?php echo esc_html($m['price']); ?>
              </span>
            </div>
          <?php endforeach; endif; ?>


          <!-- ================= DYNAMIC FEATURE ROWS ================= -->
          <?php if (!empty($rows)) : 
            $total_rows = count($rows);
            $row_index  = 0;

            foreach ($rows as $row) : 
              $row_index++;
              $is_last_row = ($row_index === $total_rows);
              $border_cls  = $is_last_row ? '' : 'border-b border-gray-100';
              $row_label   = $row['row_label'];
              $vals        = $row['row_values'];
          ?>
            <!-- Feature Title (Sticky Column on Mobile) -->
            <div class="<?php echo $border_cls; ?> p-4 md:p-6 flex items-center text-[11px] md:text-[12px] uppercase tracking-widest font-bold text-gray-800 sticky left-0 bg-white z-10 md:static shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] md:shadow-none">
              <?php echo esc_html($row_label); ?>
            </div>

            <!-- Model Values loop -->
            <?php 
              if (!empty($vals)) :
                foreach ($vals as $col_idx => $v) : 
                  $is_highlighted_col = isset($models[$col_idx]['badge_text']) && !empty($models[$col_idx]['badge_text']);
                  $bg_cls = $is_highlighted_col ? 'bg-[#EDF3F6]' : '';
                  $type   = $v['type'];
            ?>
              <div class="<?php echo $border_cls; ?> p-4 md:p-6 flex items-center justify-center text-[13px] md:text-sm font-light text-gray-600 text-center <?php echo $bg_cls; ?>">
                
                <?php if ($type === 'boolean') : ?>
                  <?php if ($v['bool_val']) : ?>
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-[#156E8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  <?php else : ?>
                    <span class="text-gray-300 font-light">&mdash;</span>
                  <?php endif; ?>
                <?php else : ?>
                  <?php echo esc_html($v['text_val']); ?>
                <?php endif; ?>

              </div>
            <?php 
                endforeach; 
              endif; 
            ?>

          <?php endforeach; endif; ?>

        </div>

      </div>
    </div>
  </section>

  <!-- ========================================== -->
  <!-- 4. DARK CTA SECTION (REUSED FROM TEMPLATE-PARTS) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php get_footer(); ?>