<?php
/**
 * Template Part: Reusable Hero Section
 */

// Fetch Hero ACF fields with fallbacks
$eyebrow  = get_field('hero_eyebrow');
$title    = get_field('hero_title');
$subtext  = get_field('hero_subtext');
?>

<section class="relative flex items-center overflow-hidden bg-[#FAFCFD]">
  <!-- Soft Radial Glow (Top Right) -->
  <div class="hidden md:block absolute inset-0 pointer-events-none" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

  <div class="max-w-[1400px] mx-auto px-6 md:px-10 lg:px-20 py-10 lg:py-20 w-full relative z-10">
    <div class="max-w-2xl">
      <!-- Dynamic Breadcrumbs -->
      <?php if (function_exists('render_custom_breadcrumbs')) { render_custom_breadcrumbs(); } ?>

      <!-- Eyebrow -->
      <?php if ($eyebrow) : ?>
        <div class="flex items-center gap-4 mb-6">
          <div class="w-8 h-px bg-[#156E8A]"></div>
          <p class="uppercase tracking-[.25em] text-[11px] text-[#156E8A] font-bold">
            <?php echo esc_html($eyebrow); ?>
          </p>
        </div>
      <?php endif; ?>

      <!-- Headline -->
      <?php if ($title) : ?>
        <h1 class="text-5xl md:text-6xl lg:text-[80px] font-light leading-tight tracking-tight text-gray-900 mb-5">
          <?php echo wp_kses_post($title); ?>
        </h1>
      <?php endif; ?>

      <!-- Subtext -->
      <?php if ($subtext) : ?>
        <p class="max-w-xl text-gray-500 text-sm md:text-base leading-relaxed font-light">
          <?php echo esc_html($subtext); ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</section>