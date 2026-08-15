<?php
/**
 * Template Name: Corporate Page 
 */

get_header(); 
?>

<main class="corporate-page bg-[#F7F9FA] relative">

  <!-- Soft Radial Glow (Top Right) -->
  <div class="hidden md:block absolute inset-0 pointer-events-none" style="background: radial-gradient(40% 60% at 90% 10%, rgba(21, 110, 138, 0.08) 0%, rgba(0, 0, 0, 0) 100%);"></div>

  <!-- ========================================== -->
  <!-- 1. HERO SECTION (REUSED FROM TEMPLATE-PARTS) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/hero-section'); ?>

  <!-- ========================================== -->
  <!-- 2. STATS / METRICS BANNER                  -->
  <!-- ========================================== -->
  <?php if (have_rows('corporate_stats')) : ?>
    <section class="w-full md:bg-white relative z-10">
      <div class="max-w-[1300px] mx-auto grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-0 items-center lg:min-w-0 lg:py-0 divide-x divide-gray-200/60 lg:px-0">
        <?php while (have_rows('corporate_stats')) : the_row(); ?>
          <div class="flex flex-col items-center justify-center text-center px-6 lg:px-0 lg:py-10 lg:w-auto bg-white p-4">
            <h3 class="text-3xl lg:text-6xl font-light text-[#156E8A] mb-1 lg:mb-4 tracking-tight">
              <?php echo esc_html(get_sub_field('value')); ?>
            </h3>
            <span class="text-[11px] lg:text-[12px] uppercase tracking-[0.1em] lg:tracking-[0.2em] text-gray-400 font-medium">
              <?php echo esc_html(get_sub_field('label')); ?>
            </span>
          </div>
        <?php endwhile; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- ========================================== -->
  <!-- 3. SHARED SPACES B2B SECTION               -->
  <!-- ========================================== -->
  <section class="w-full py-16 lg:py-24 px-6 md:px-10 lg:px-16 transition-colors duration-300 relative z-10">
    <div class="max-w-[1300px] mx-auto">

      <!-- Section Header -->
      <h2 class="text-2xl md:text-3xl lg:text-[42px] text-center font-normal text-gray-900 dark:text-gray-600 mb-8 lg:mb-12 tracking-tight">
        <?php echo wp_kses_post(get_field('spaces_headline') ?: 'Built for every kind of <span class="font-medium text-[#156E8A]">shared space.</span>'); ?>
      </h2>

      <!-- Cards Grid -->
      <?php if (have_rows('shared_spaces')) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
          <?php while (have_rows('shared_spaces')) : the_row(); 
            $title = get_sub_field('title');
            $desc  = get_sub_field('description');
            $svg   = get_sub_field('icon_svg');
          ?>
            <div class="flex flex-col bg-white md:bg-transparent border border-gray-200 dark:border-gray-800 rounded-[8px] dark:rounded-[4px] p-6 lg:p-8 transition-colors">
              <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-transparent dark:border dark:border-gray-800 flex items-center justify-center mb-5 text-[#156E8A] transition-colors shrink-0">
                <?php if ($svg) : ?>
                  <div class="w-[22px] h-[22px] flex items-center justify-center">
                    <?php echo $svg; ?>
                  </div>
                <?php endif; ?>
              </div>
              <h3 class="text-[18px] lg:text-[20px] text-gray-900 dark:text-gray-400 font-normal mb-3">
                <?php echo esc_html($title); ?>
              </h3>
              <p class="text-[12px] text-gray-500 dark:text-gray-600 font-light leading-relaxed">
                <?php echo esc_html($desc); ?>
              </p>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ========================================== -->
  <!-- 4. B2B TEAM CONTACT & LEAD FORM            -->
  <!-- ========================================== -->
  <section class="max-w-[1300px] mx-auto py-16 lg:py-24 relative z-10">
    <div class="flex flex-col lg:flex-row gap-12 lg:gap-24 items-start px-6 md:px-10 lg:px-0">

      <!-- LEFT COLUMN: CONTACT DETAILS -->
      <div class="w-full lg:w-[45%] flex flex-col">
        <h2 class="text-3xl md:text-4xl lg:text-[42px] font-light text-gray-900 dark:text-white mb-4 lg:mb-6 tracking-tight leading-tight">
          <?php echo wp_kses_post(get_field('b2b_contact_headline') ?: 'Talk to our <span class="font-medium text-[#156E8A]">B2B team</span>'); ?>
        </h2>

        <p class="text-[14px] md:text-[15px] text-gray-600 dark:text-gray-400 font-light leading-relaxed mb-8">
          <?php echo esc_html(get_field('b2b_contact_subtext')); ?>
        </p>

        <div class="w-full h-px bg-gray-200 dark:bg-gray-800"></div>

        <!-- Sales Email Block -->
        <?php $email = get_field('b2b_sales_email') ?: 'enquiries@breathein.co.in'; ?>
        <div class="flex items-center gap-5 py-6 lg:py-8 border-b border-gray-200 dark:border-gray-800">
          <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-[#111a20] flex items-center justify-center shrink-0 text-[#156E8A] dark:text-brandTeal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.909A2.25 2.25 0 012.25 6.993V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25"></path></svg>
          </div>
          <div class="flex flex-col">
            <h4 class="text-[18px] lg:text-[20px] text-gray-900 dark:text-white font-normal mb-1">B2B Sales</h4>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="text-[14px] text-[#156E8A] dark:text-brandTeal hover:opacity-80 transition-opacity">
              <?php echo esc_html($email); ?>
            </a>
          </div>
        </div>

        <!-- Phone Block -->
        <?php 
          $phone_disp = get_field('b2b_sales_phone_display') ?: '+91 90766 36639'; 
          $phone_raw  = get_field('b2b_sales_phone_raw') ?: '+919076636639'; 
        ?>
        <div class="flex items-center gap-5 py-6 lg:py-8 border-b border-gray-200 dark:border-gray-800">
          <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-[#111a20] flex items-center justify-center shrink-0 text-[#156E8A] dark:text-brandTeal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.076-7.076l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
          </div>
          <div class="flex flex-col">
            <h4 class="text-[18px] lg:text-[20px] text-gray-900 dark:text-white font-normal mb-1">Call B2B</h4>
            <a href="tel:<?php echo esc_attr($phone_raw); ?>" class="text-[14px] text-[#156E8A] dark:text-brandTeal hover:opacity-80 transition-opacity">
              <?php echo esc_html($phone_disp); ?>
            </a>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: B2B LEAD FORM -->
      <div class="w-full lg:w-[55%] border border-gray-200 dark:border-gray-800 bg-white dark:bg-tickerDark rounded-[4px] p-6 md:p-10 shadow-sm lg:shadow-[0_4px_20px_rgba(0,0,0,0.02)]">

        <?php
        $submitted = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['b2b_nonce']) && wp_verify_nonce($_POST['b2b_nonce'], 'b2b_lead_submit')) {
            // 1. Sanitize Form Input
            $company = sanitize_text_field($_POST['company'] ?? '');
            $contact = sanitize_text_field($_POST['contact_name'] ?? '');
            $phone   = sanitize_text_field($_POST['phone'] ?? '');
            $email   = sanitize_email($_POST['work_email'] ?? '');
            $space   = sanitize_text_field($_POST['space_type'] ?? '');
            $units   = sanitize_text_field($_POST['units_needed'] ?? '');
            $area    = sanitize_text_field($_POST['total_area'] ?? '');

            // 2. Determine Recipient (ACF field or default admin email)
            $to = (function_exists('get_field') && get_field('b2b_sales_email')) 
                  ? get_field('b2b_sales_email') 
                  : get_option('admin_email');

            $subject = "New B2B Lead: " . ($company ?: $contact);

            // 3. Clean HTML Email Body
            $message = "
            <div style='font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.6;'>
              <h2 style='color: #156E8A; border-bottom: 2px solid #eee; padding-bottom: 8px;'>New B2B Quote Request</h2>
              <table style='width: 100%; border-collapse: collapse; margin-top: 15px;'>
                <tr style='background: #f9f9f9;'><td style='padding: 8px; font-weight: bold; width: 35%;'>Company:</td><td style='padding: 8px;'>{$company}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold;'>Contact Person:</td><td style='padding: 8px;'>{$contact}</td></tr>
                <tr style='background: #f9f9f9;'><td style='padding: 8px; font-weight: bold;'>Phone:</td><td style='padding: 8px;'>{$phone}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold;'>Work Email:</td><td style='padding: 8px;'><a href='mailto:{$email}'>{$email}</a></td></tr>
                <tr style='background: #f9f9f9;'><td style='padding: 8px; font-weight: bold;'>Space Type:</td><td style='padding: 8px;'>{$space}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold;'>Approx. Units:</td><td style='padding: 8px;'>{$units}</td></tr>
                <tr style='background: #f9f9f9;'><td style='padding: 8px; font-weight: bold;'>Total Area:</td><td style='padding: 8px;'>{$area}</td></tr>
              </table>
            </div>";

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                "Reply-To: {$contact} <{$email}>"
            );

            // 4. Send Email
            wp_mail($to, $subject, $message, $headers);

            // 5. Save to Database as a custom post type record (Ensures leads are never lost)
            $lead_id = wp_insert_post(array(
                'post_type'   => 'b2b_lead',
                'post_title'  => ($company ? $company . ' - ' : '') . $contact,
                'post_status' => 'publish',
            ));

            if ($lead_id && !is_wp_error($lead_id)) {
                update_post_meta($lead_id, '_company', $company);
                update_post_meta($lead_id, '_contact', $contact);
                update_post_meta($lead_id, '_phone', $phone);
                update_post_meta($lead_id, '_email', $email);
                update_post_meta($lead_id, '_space', $space);
                update_post_meta($lead_id, '_units', $units);
                update_post_meta($lead_id, '_area', $area);
            }

            $submitted = true;
        }
        ?>

        <?php if ($submitted) : ?>
          <div class="p-6 bg-[#F0F5F7] border border-[#156E8A] text-[#156E8A] rounded-[2px] text-center">
            <h4 class="text-lg font-medium mb-1">Thank you!</h4>
            <p class="text-sm font-light">Your quote request has been sent successfully. Our B2B team will get back to you shortly.</p>
          </div>
        <?php else : ?>
          <form class="flex flex-col gap-5 lg:gap-6" action="<?php echo esc_url(get_permalink()); ?>" method="POST">
            
            <?php wp_nonce_field('b2b_lead_submit', 'b2b_nonce'); ?>

            <!-- Company Name -->
            <div class="flex flex-col">
              <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Company / Organisation</label>
              <input type="text" name="company" placeholder="Company name" required class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
            </div>

            <!-- Contact & Phone Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">
              <div class="flex flex-col">
                <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Contact Person</label>
                <input type="text" name="contact_name" placeholder="Name" required class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
              </div>
              <div class="flex flex-col">
                <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Phone</label>
                <input type="tel" name="phone" placeholder="+91" required class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
              </div>
            </div>

            <!-- Work Email -->
            <div class="flex flex-col">
              <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Work Email</label>
              <input type="email" name="work_email" placeholder="you@company.com" required class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
            </div>

            <!-- Space & Units Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">
              <div class="flex flex-col">
                <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Space Type</label>
                <input type="text" name="space_type" placeholder="Office" class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
              </div>
              <div class="flex flex-col">
                <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Approx. Units Needed</label>
                <input type="text" name="units_needed" placeholder="2–5" class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
              </div>
            </div>

            <!-- Total Area -->
            <div class="flex flex-col">
              <label class="text-[10px] uppercase tracking-[0.15em] text-gray-500 font-bold mb-2">Total Area (Optional)</label>
              <input type="text" name="total_area" placeholder="e.g. 5,000 sq ft" class="border border-gray-200 dark:border-gray-700 bg-[#F9FAFB] dark:bg-[#111a20] text-[13px] text-gray-900 dark:text-white rounded-[2px] px-4 py-3.5 outline-none focus:border-[#156E8A] transition-colors w-full">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-[#111111] dark:bg-white text-white dark:text-black py-4 lg:py-4 mt-2 lg:mt-4 flex items-center justify-center gap-3 text-[11px] font-bold uppercase tracking-[0.2em] rounded-[2px] hover:bg-black dark:hover:bg-gray-200 transition-colors">
              <span>Request a Quote</span>
              <span class="text-lg leading-none mb-[2px]">&rarr;</span>
            </button>

          </form>
        <?php endif; ?>

      </div>

    </div>
  </section>

  <!-- ========================================== -->
  <!-- 5. DARK CTA SECTION (REUSED FROM TEMPLATE-PARTS) -->
  <!-- ========================================== -->
  <?php get_template_part('template-parts/cta-section'); ?>

</main>

<?php get_footer(); ?>