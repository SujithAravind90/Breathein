<?php
/**
 * Template Name: Book a demo Page
 */

get_header();

$book_demo_page_id = get_queried_object_id();

$book_demo_field = static function (string $field_name, $default = '') use ($book_demo_page_id) {
    if (function_exists('get_field')) {
        $value = get_field($field_name, $book_demo_page_id);

        if ($value !== null && $value !== '' && $value !== false) {
            return $value;
        }
    }

    return $default;
};

$book_demo_link = static function ($value, string $default_url, string $default_title): array {
    $value = is_array($value) ? $value : [];

    return [
        'url'    => !empty($value['url']) ? (string) $value['url'] : $default_url,
        'title'  => !empty($value['title']) ? (string) $value['title'] : $default_title,
        'target' => !empty($value['target']) ? (string) $value['target'] : '_self',
    ];
};

$book_demo_hero_eyebrow = (string) $book_demo_field('book_demo_hero_eyebrow', 'Talk to an Air-Care Expert');
$book_demo_hero_title_lead = (string) $book_demo_field('book_demo_hero_title_lead', 'See it. Hear it.');
$book_demo_hero_title_highlight = (string) $book_demo_field('book_demo_hero_title_highlight', 'Breathe it.');
$book_demo_hero_description = (string) $book_demo_field(
    'book_demo_hero_description',
    'Book a free demo or a callback from a Breathe In specialist. We\'ll help you choose the right model for your space — no pressure, no obligation.'
);

$book_demo_interest_options = $book_demo_field('book_demo_interest_options', []);
$book_demo_space_options = $book_demo_field('book_demo_space_options', []);

if (!is_array($book_demo_interest_options) || empty($book_demo_interest_options)) {
    $book_demo_interest_options = [
        ['option_value' => 'home_demo', 'option_label' => 'Book a home demo'],
        ['option_value' => 'callback', 'option_label' => 'Request a callback'],
        ['option_value' => 'commercial', 'option_label' => 'Discuss commercial setup'],
    ];
}

if (!is_array($book_demo_space_options) || empty($book_demo_space_options)) {
    $book_demo_space_options = [
        ['option_value' => 'bedroom', 'option_label' => 'Bedroom'],
        ['option_value' => 'living_room', 'option_label' => 'Living Room'],
        ['option_value' => 'office_workspace', 'option_label' => 'Office Workspace'],
        ['option_value' => 'entire_home', 'option_label' => 'Entire Home'],
    ];
}

$book_demo_phone_display = (string) $book_demo_field('book_demo_phone_display', '+91 90766 36639');
$book_demo_phone_link = (string) $book_demo_field('book_demo_phone_link', '+919076636639');
$book_demo_phone_link = preg_replace('/[^0-9+]/', '', $book_demo_phone_link);
$book_demo_whatsapp_url = (string) $book_demo_field('book_demo_whatsapp_url', 'https://wa.me/919076636639');
$book_demo_email_address = (string) $book_demo_field('book_demo_email_address', 'enquiries@breathein.co.in');
$book_demo_status = isset($_GET['demo_status'])
    ? sanitize_key(wp_unslash($_GET['demo_status']))
    : '';
$book_demo_success_message = (string) $book_demo_field(
    'book_demo_success_message',
    'Your request has been sent successfully. Our team will get back to you shortly.'
);
$book_demo_error_message = (string) $book_demo_field(
    'book_demo_error_message',
    'We could not send your request. Please check the details and try again.'
);

$book_demo_primary_link = $book_demo_link(
    $book_demo_field('book_demo_cta_primary_link', []),
    home_url('/find-my-purifier/'),
    'Find My Purifier'
);
$book_demo_secondary_link = $book_demo_link(
    $book_demo_field('book_demo_cta_secondary_link', []),
    home_url('/collection/'),
    'Browse the Products'
);
?>

<main class="bg-[#F7F9FA]">
    <div class="hidden md:block absolute inset-0 pointer-events-none" style="
            background: radial-gradient(
              40% 60% at 90% 10%,
              rgba(21, 110, 138, 0.08) 0%,
              rgba(0, 0, 0, 0) 100%
            );
          "></div>

    <!-- ========================================== -->
    <!-- HERO SECTION                               -->
    <!-- ========================================== -->
    <section class="relative flex items-center overflow-hidden">
        <div class="max-w-[1300px] mx-auto px-6 md:px-10 lg:px-20 py-10 lg:py-20 w-full relative z-10">
            <div class="max-w-2xl">
                <nav class="uppercase tracking-[.25em] text-[12px] text-gray-400 mb-5">
                    HOME <span class="text-gray-300 px-2">/</span> <?php echo esc_html(get_the_title($book_demo_page_id)); ?>
                </nav>

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-8 h-px bg-[#156E8A]"></div>
                    <p class="uppercase tracking-[.25em] text-[11px] text-[#156E8A] font-bold">
                        <?php echo esc_html($book_demo_hero_eyebrow); ?>
                    </p>
                </div>

                <h1 class="text-3xl md:text-6xl lg:text-[80px] font-light leading-tight tracking-tight text-gray-900 mb-5">
                    <?php echo esc_html($book_demo_hero_title_lead); ?>
                    <span class="font-medium text-[#156E8A]"> <?php echo esc_html($book_demo_hero_title_highlight); ?></span>
                </h1>

                <p class="max-w-xl text-gray-500 text-sm md:text-base leading-relaxed font-light">
                    <?php echo nl2br(esc_html($book_demo_hero_description)); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- CONTACT & DEMO REQUEST SECTION             -->
    <!-- ========================================== -->
    <section class="w-full bg-white dark:bg-[#050505] py-16 lg:py-24 px-6 md:px-10 lg:px-16 font-sans transition-colors duration-300">
        <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <div class="bg-white dark:bg-[#0a0f12] border border-gray-200 dark:border-gray-800 p-6 md:p-8 lg:p-10 rounded-[2px] w-full transition-colors duration-300 shadow-sm">
                <?php if ('success' === $book_demo_status) : ?>
                    <div class="mb-6 p-5 bg-[#F0F5F7] border border-[#156E8A] text-[#156E8A] rounded-[2px] text-center">
                        <h2 class="text-lg font-medium mb-1">Thank you!</h2>
                        <p class="text-sm font-light"><?php echo esc_html($book_demo_success_message); ?></p>
                    </div>
                <?php elseif (in_array($book_demo_status, ['invalid', 'error', 'email_failed'], true)) : ?>
                    <div class="mb-6 p-5 bg-red-50 border border-red-200 text-red-700 rounded-[2px] text-center">
                        <p class="text-sm font-light"><?php echo esc_html($book_demo_error_message); ?></p>
                    </div>
                <?php endif; ?>

                <form class="flex flex-col gap-6" action="<?php echo esc_url(get_permalink($book_demo_page_id)); ?>" method="post">
                    <input type="hidden" name="breathein_demo_form" value="1">
                    <?php wp_nonce_field('breathein_submit_demo_request', 'breathein_demo_nonce'); ?>
                    <div class="hidden" aria-hidden="true">
                        <label for="company_website">Company website</label>
                        <input id="company_website" type="text" name="company_website" value="" tabindex="-1" autocomplete="off">
                    </div>

                    <div>
                        <label for="demo_full_name" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                            <?php echo esc_html($book_demo_field('book_demo_name_label', 'Full Name')); ?>
                        </label>
                        <input id="demo_full_name" name="full_name" type="text" placeholder="<?php echo esc_attr($book_demo_field('book_demo_name_placeholder', 'Your name')); ?>" required autocomplete="name"
                            class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white placeholder-gray-400 outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="demo_phone" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                                <?php echo esc_html($book_demo_field('book_demo_phone_label', 'Phone')); ?>
                            </label>
                            <input id="demo_phone" name="phone" type="tel" placeholder="<?php echo esc_attr($book_demo_field('book_demo_phone_placeholder', '+91')); ?>" required autocomplete="tel"
                                class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white placeholder-gray-400 outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors">
                        </div>
                        <div>
                            <label for="demo_city" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                                <?php echo esc_html($book_demo_field('book_demo_city_label', 'City')); ?>
                            </label>
                            <input id="demo_city" name="city" type="text" placeholder="<?php echo esc_attr($book_demo_field('book_demo_city_placeholder', 'e.g. Bengaluru')); ?>" required autocomplete="address-level2"
                                class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white placeholder-gray-400 outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors">
                        </div>
                    </div>

                    <div>
                        <label for="demo_email" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                            <?php echo esc_html($book_demo_field('book_demo_email_label', 'Email')); ?>
                        </label>
                        <input id="demo_email" name="email" type="email" placeholder="<?php echo esc_attr($book_demo_field('book_demo_email_placeholder', 'you@email.com')); ?>" required autocomplete="email"
                            class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white placeholder-gray-400 outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="demo_interest" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                                <?php echo esc_html($book_demo_field('book_demo_interest_label', 'I\'d like to')); ?>
                            </label>
                            <div class="relative">
                                <select id="demo_interest" name="interest" required
                                    class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors appearance-none cursor-pointer">
                                    <?php foreach ($book_demo_interest_options as $option) : ?>
                                        <?php if (!empty($option['option_label']) && !empty($option['option_value'])) : ?>
                                            <option value="<?php echo esc_attr($option['option_value']); ?>"><?php echo esc_html($option['option_label']); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="demo_space_type" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                                <?php echo esc_html($book_demo_field('book_demo_space_label', 'Space Type')); ?>
                            </label>
                            <div class="relative">
                                <select id="demo_space_type" name="space_type" required
                                    class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors appearance-none cursor-pointer">
                                    <?php foreach ($book_demo_space_options as $option) : ?>
                                        <?php if (!empty($option['option_label']) && !empty($option['option_value'])) : ?>
                                            <option value="<?php echo esc_attr($option['option_value']); ?>"><?php echo esc_html($option['option_label']); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="demo_message" class="block text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em] mb-2.5">
                            <?php echo esc_html($book_demo_field('book_demo_message_label', 'Anything else? (Optional)')); ?>
                        </label>
                        <textarea id="demo_message" name="message" rows="3" placeholder="<?php echo esc_attr($book_demo_field('book_demo_message_placeholder', 'Tell us about your space or concerns')); ?>"
                            class="w-full bg-[#F9FAFB] dark:bg-[#111a20] border border-gray-200 dark:border-gray-800 rounded-[2px] p-3.5 text-[14px] text-gray-900 dark:text-white placeholder-gray-400 outline-none focus:border-[#156E8A] dark:focus:border-[#2094B6] transition-colors resize-none"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#111111] dark:bg-white text-white dark:text-black px-6 py-4 mt-2 text-[11px] font-bold uppercase tracking-[0.2em] flex items-center justify-center gap-3 hover:bg-[#156E8A] dark:hover:bg-gray-200 transition-colors rounded-[2px] shadow-lg shadow-black/10">
                        <?php echo esc_html($book_demo_field('book_demo_submit_label', 'REQUEST MY DEMO')); ?> <span class="text-lg leading-none mb-[2px]">&rarr;</span>
                    </button>
                </form>
            </div>

            <!-- RIGHT COLUMN: CONTACT DETAILS -->
            <div class="flex flex-col w-full lg:pt-4">
                <h2 class="text-3xl md:text-[34px] font-light text-gray-900 dark:text-white tracking-tight mb-4">
                    <?php echo esc_html($book_demo_field('book_demo_contact_heading', 'Prefer to reach us directly?')); ?>
                </h2>

                <p class="text-[14px] md:text-[15px] text-gray-500 dark:text-gray-400 font-light leading-relaxed mb-10 max-w-[480px]">
                    <?php echo nl2br(esc_html($book_demo_field('book_demo_contact_description', 'Our support team speaks English, Hindi and Kannada, Monday to Saturday, 10:00 AM — 6:00 PM IST.'))); ?>
                </p>

                <div class="flex flex-col">
                    <div class="flex items-start gap-5 py-6 border-t border-gray-100 dark:border-gray-800">
                        <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-[#0c1318] flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-[#156E8A] dark:text-[#2094B6]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.077-7.077l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-[16px] lg:text-[17px] font-medium text-gray-900 dark:text-white mb-1"><?php echo esc_html($book_demo_field('book_demo_phone_title', 'Call us')); ?></h3>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 font-light"><a href="tel:<?php echo esc_attr($book_demo_phone_link); ?>" class="text-[#156E8A] dark:text-[#2094B6] hover:underline"><?php echo esc_html($book_demo_phone_display); ?></a> <span class="hidden md:inline">&middot; <?php echo esc_html($book_demo_field('book_demo_phone_hours', 'Mon–Sat, 10AM–6PM IST')); ?></span></p>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 font-light md:hidden"><?php echo esc_html($book_demo_field('book_demo_phone_hours', 'Mon–Sat, 10AM–6PM IST')); ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5 py-6 border-t border-gray-100 dark:border-gray-800">
                        <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-[#0c1318] flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-[#156E8A] dark:text-[#2094B6]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 11.996c0 2.29.982 4.364 2.578 5.864l-1.455 2.91 3.25-.97a9.123 9.123 0 004.627 1.25z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-[16px] lg:text-[17px] font-medium text-gray-900 dark:text-white mb-1"><?php echo esc_html($book_demo_field('book_demo_whatsapp_title', 'WhatsApp')); ?></h3>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 font-light"><a href="<?php echo esc_url($book_demo_whatsapp_url); ?>" target="_blank" rel="noopener" class="text-[#156E8A] dark:text-[#2094B6] hover:underline"><?php echo esc_html($book_demo_field('book_demo_whatsapp_display', $book_demo_phone_display)); ?></a> <span class="hidden md:inline">&middot; <?php echo esc_html($book_demo_field('book_demo_whatsapp_description', 'Send photos/videos for troubleshooting')); ?></span></p>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 font-light md:hidden"><?php echo esc_html($book_demo_field('book_demo_whatsapp_description', 'Send photos/videos for troubleshooting')); ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5 py-6 border-t border-gray-100 dark:border-gray-800">
                        <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-[#0c1318] flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-[#156E8A] dark:text-[#2094B6]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.909A2.25 2.25 0 012.25 6.993V6.75"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-[16px] lg:text-[17px] font-medium text-gray-900 dark:text-white mb-1"><?php echo esc_html($book_demo_field('book_demo_email_title', 'Email')); ?></h3>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 font-light"><a href="mailto:<?php echo esc_attr($book_demo_email_address); ?>" class="text-[#156E8A] dark:text-[#2094B6] hover:underline"><?php echo esc_html($book_demo_email_address); ?></a></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5 py-6 border-y border-gray-100 dark:border-gray-800">
                        <div class="w-12 h-12 rounded-full bg-[#F0F5F7] dark:bg-[#0c1318] flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-[#156E8A] dark:text-[#2094B6]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-[16px] lg:text-[17px] font-medium text-gray-900 dark:text-white mb-1"><?php echo esc_html($book_demo_field('book_demo_office_title', 'Corporate office')); ?></h3>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 font-light leading-relaxed"><?php echo nl2br(esc_html($book_demo_field('book_demo_office_address', 'Novel Office, Brigade Tech Park, Tower-B, Whitefield, Bengaluru 560066'))); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- DARK CTA SECTION: EXPLORE / COMPARE        -->
    <!-- ========================================== -->
    <section class="w-full bg-[#0B1115] py-10 md:py-20 px-6 flex flex-col items-center justify-center text-center">
        <h2 class="text-4xl md:text-5xl lg:text-[56px] font-light text-white mb-6 md:mb-8 tracking-tight">
            <?php echo wp_kses($book_demo_field('book_demo_cta_headline', 'Not ready to talk? <span class="text-[#156E8A]">Find your match first.</span>'), ['span' => ['class' => []], 'br' => []]); ?>
        </h2>

        <p class="text-gray-400 font-light text-[12px] md:text-[15px] max-w-2xl mx-auto mb-12 leading-relaxed">
            <?php echo nl2br(esc_html($book_demo_field('book_demo_cta_subtext', 'Use the room finder to get an instant recommendation, then book a demo when you\'re ready.'))); ?>
        </p>

        <div class="flex flex-row items-center justify-center gap-6 sm:gap-10 w-full max-w-md sm:max-w-none">
            <a href="<?php echo esc_url($book_demo_primary_link['url']); ?>" target="<?php echo esc_attr($book_demo_primary_link['target']); ?>"
                class="bg-white text-[#0B1115] px-4 py-4 md:py-4 uppercase text-[12px] md:text-[13px] tracking-[0.2em] font-bold flex items-center justify-center gap-3 hover:bg-gray-200 transition-colors rounded-sm w-full sm:w-auto">
                <span><?php echo esc_html($book_demo_primary_link['title']); ?></span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="<?php echo esc_url($book_demo_secondary_link['url']); ?>" target="<?php echo esc_attr($book_demo_secondary_link['target']); ?>"
                class="text-white border-b border-gray-700 pb-1 uppercase text-[12px] md:text-[13px] tracking-[0.2em] font-bold hover:text-[#156E8A] hover:border-[#156E8A] transition-colors w-full sm:w-auto text-center mt-2 sm:mt-0">
                <?php echo esc_html($book_demo_secondary_link['title']); ?>
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
