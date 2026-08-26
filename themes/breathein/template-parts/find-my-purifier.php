<?php
/**
 * Template Name: Find my purifier Page 
 */
get_header();
?>
<main>
    <!-- ========================================== -->
    <!-- HERO SECTION: FIND MY PURIFIER             -->
    <!-- ========================================== -->
    <section class="relative flex items-center overflow-hidden bg-[#FAFCFD]">
        <!-- Centered Radial Glow (Desktop Only) -->
        <div
            class="hidden md:block absolute inset-0 pointer-events-none"
            style="
            background: radial-gradient(
              circle at 50% 50%,
              rgba(21, 110, 138, 0.08) 0%,
              rgba(250, 252, 253, 0) 50%
            );
          "></div>

        <div
            class="max-w-[1400px] mx-auto px-6 md:px-10 lg:px-20 py-16 lg:py-24 w-full relative z-10 flex flex-col md:items-center md:text-center">
            <div class="max-w-2xl lg:max-w-3xl flex flex-col md:items-center">
                <!-- Breadcrumb (Mobile Only) -->
                <nav
                    class="uppercase tracking-[.25em] text-[12px] text-gray-400 mb-6 md:hidden">
                    HOME <span class="text-gray-300 px-2">/</span> FIND
                </nav>

                <!-- Eyebrow -->
                <!-- Left aligned with line on mobile, centered without line on desktop -->
                <div
                    class="flex items-center gap-4 mb-5 md:mb-6 justify-start md:justify-center">
                    <div class="w-8 h-px bg-[#156E8A] md:hidden"></div>
                    <p
                        class="uppercase tracking-[.25em] text-[11px] md:text-[12px] text-[#156E8A] font-bold">
                        FIND MY PURIFIER
                    </p>
                </div>

                <!-- Headline -->
                <h1
                    class="text-5xl md:text-6xl lg:text-[80px] font-light leading-[1.1] tracking-tight text-gray-900 mb-5 md:mb-6">
                    Let's find <span class="font-medium text-[#156E8A]">your</span><br class="hidden md:block" />
                    perfect match.
                </h1>

                <!-- Subtext -->
                <p
                    class="max-w-xl lg:max-w-2xl text-gray-500 text-sm md:text-base leading-relaxed font-light">
                    Four quick questions. We'll weigh your space, your air, and how
                    you live &mdash; then recommend the one model built for it.
                </p>
            </div>
        </div>
    </section>

    <section
        class="w-full min-h-screen bg-[#FAFCFD] py-12 md:py-20 px-4 md:px-8 flex flex-col items-center">
        <!-- ========================================== -->
        <!-- MOBILE PROGRESS BAR (Hidden on Desktop)    -->
        <!-- ========================================== -->
        <div
            class="lg:hidden flex items-center justify-between w-full max-w-[280px] mb-8 relative">
            <!-- Connecting Line (Fixed z-index) -->
            <div
                class="absolute top-1/2 left-0 w-full h-px bg-gray-200 z-0"></div>

            <!-- Step 1 (Active - Added relative z-10) -->
            <div
                class="relative z-10 w-8 h-8 rounded-full bg-[#156E8A] text-white flex items-center justify-center text-[15px] font-medium border-4 border-[#FAFCFD]">
                1
            </div>
            <!-- Step 2 -->
            <div
                class="relative z-10 w-8 h-8 rounded-full bg-white text-gray-400 flex items-center justify-center text-[15px] font-medium border border-gray-200">
                2
            </div>
            <!-- Step 3 -->
            <div
                class="relative z-10 w-8 h-8 rounded-full bg-white text-gray-400 flex items-center justify-center text-[15px] font-medium border border-gray-200">
                3
            </div>
            <!-- Step 4 -->
            <div
                class="relative z-10 w-8 h-8 rounded-full bg-white text-gray-400 flex items-center justify-center text-[15px] font-medium border border-gray-200">
                4
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MAIN WIZARD CARD                           -->
        <!-- ========================================== -->
        <div
            class="w-full max-w-[850px] bg-white border border-gray-200 rounded-[4px] shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
            <!-- ========================================== -->
            <!-- DESKTOP PROGRESS BAR (Hidden on Mobile)    -->
            <!-- ========================================== -->
            <div
                class="hidden lg:flex items-center justify-between px-16 py-6 border-b border-gray-100 relative">
                <!-- Connecting Line (Fixed z-index) -->
                <div
                    class="absolute top-1/2 left-16 right-16 h-px bg-gray-200 z-0"></div>

                <!-- Step 1 (Active - Added relative z-10) -->
                <div
                    class="relative z-10 w-10 h-10 rounded-full bg-white text-[#156E8A] border-2 border-[#156E8A] flex items-center justify-center text-[15px] font-medium outline outline-4 outline-white">
                    1
                </div>
                <!-- Step 2 -->
                <div
                    class="relative z-10 w-10 h-10 rounded-full bg-white text-gray-400 border border-gray-300 flex items-center justify-center text-[15px] font-medium outline outline-4 outline-white">
                    2
                </div>
                <!-- Step 3 -->
                <div
                    class="relative z-10 w-10 h-10 rounded-full bg-white text-gray-400 border border-gray-300 flex items-center justify-center text-[15px] font-medium outline outline-4 outline-white">
                    3
                </div>
                <!-- Step 4 -->
                <div
                    class="relative z-10 w-10 h-10 rounded-full bg-white text-gray-400 border border-gray-300 flex items-center justify-center text-[15px] font-medium outline outline-4 outline-white">
                    4
                </div>
            </div>

            <!-- ========================================== -->
            <!-- CARD CONTENT AREA                          -->
            <!-- ========================================== -->
            <div class="px-6 py-10 lg:px-20 lg:pt-16 lg:pb-24">
                <!-- Headline -->
                <h1
                    class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 tracking-tight mb-3 lg:mb-4">
                    How <span class="font-medium text-[#156E8A]">large</span> is the
                    space?
                </h1>

                <!-- Subtext -->
                <p class="text-gray-400 font-light text-[15px] lg:text-[15px]">
                    Drag to match the room you want to keep clean.
                </p>

                <!-- Dynamic Number Value -->
                <div class="mt-10 lg:mt-16">
                    <div class="flex items-baseline gap-2 mb-2 lg:mb-3">
                        <span
                            id="roomAreaValue"
                            class="text-5xl md:text-6xl lg:text-[72px] font-light text-gray-900 tracking-tight leading-none">600</span>
                        <span class="text-gray-400 text-lg lg:text-xl font-light">sq ft</span>
                    </div>

                    <!-- Room Description Label -->
                    <!-- Mobile: Uppercase and smaller. Desktop: Sentence case and slightly larger. -->
                    <div
                        class="text-[#156E8A] font-bold lg:font-medium text-[11px] lg:text-[15px] uppercase lg:normal-case tracking-[0.1em] lg:tracking-normal">
                        About a large living room
                    </div>
                </div>

                <!-- Custom Range Slider Area -->
                <div class="mt-8 lg:mt-12">
                    <!-- Slider Input -->
                    <!-- The value is set to 35 to roughly match the 600 sq ft position visually -->
                    <input
                        type="range"
                        id="roomAreaSlider"
                        min="100"
                        max="1500"
                        value="450"
                        class="w-full custom-slider outline-none"
                        aria-label="Square footage selector" />

                    <!-- Min / Max Labels -->
                    <div
                        class="flex justify-between mt-4 text-[12px] text-gray-300 font-bold uppercase tracking-[0.15em]">
                        <span>100</span>
                        <span>1,500 SQ FT</span>
                    </div>
                </div>

                <!-- Mobile Only Button (Inside padding) -->
                <button
                    class="lg:hidden w-full mt-12 bg-[#111111] text-white px-8 py-4 uppercase text-[12px] tracking-[0.2em] font-bold flex justify-center items-center gap-3 hover:bg-[#156E8A] transition-colors rounded-sm">
                    CONTINUE <span class="text-lg leading-none mb-[2px]">&rarr;</span>
                </button>
            </div>

            <!-- ========================================== -->
            <!-- DESKTOP ACTION BAR (Hidden on Mobile)      -->
            <!-- ========================================== -->
            <!-- Light gray background, top border, right-aligned button -->
            <div
                class="hidden lg:flex justify-end px-20 py-8 bg-[#F9FAFB] border-t border-gray-100">
                <button
                    class="bg-[#111111] text-white px-10 py-4 uppercase text-[11px] tracking-[0.2em] font-bold flex justify-center items-center gap-3 hover:bg-[#156E8A] transition-colors rounded-sm">
                    CONTINUE <span class="text-lg leading-none mb-[2px]">&rarr;</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TRUST FOOTER                               -->
        <!-- ========================================== -->
        <div class="mt-8 flex items-center justify-center gap-2.5 text-center">
            <!-- Shield Icon -->
            <svg
                class="w-4 h-4 text-[#156E8A]"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
            </svg>

            <!-- Text -->
            <p class="text-[11px] md:text-[15px] text-gray-400 font-light">
                Backed by a
                <span class="text-[#156E8A] font-bold">2-year warranty</span> &amp;
                free filter reminders on every model.
            </p>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- DARK CTA SECTION: EXPLORE / COMPARE        -->
    <!-- ========================================== -->
    <section
        class="w-full bg-[#0B1115] py-10 md:py-20 px-6 flex flex-col items-center justify-center text-center">
        <h2
            class="text-4xl md:text-5xl lg:text-[56px] font-light text-white mb-6 md:mb-8 tracking-tight">
            Decided? <span class="text-[#156E8A]">Let's go.</span>
        </h2>

        <p
            class="text-gray-400 font-light text-[12px] md:text-[15px] max-w-2xl mx-auto mb-12 leading-relaxed">
            Open the full collection to see each model in detail, or read how real
            homes chose theirs.
        </p>

        <div
            class="flex flex-row items-center justify-center gap-6 sm:gap-10 w-full max-w-md sm:max-w-none">
            <!-- Primary Solid Button -->
            <a
                href="#"
                class="bg-white text-[#0B1115] px-4 py-4 md:py-4 uppercase text-[12px] md:text-[13px] tracking-[0.2em] font-bold flex items-center justify-center gap-3 hover:bg-gray-200 transition-colors rounded-sm w-full sm:w-auto">
                <span>View the Collection</span>
                <svg
                    class="w-3.5 h-3.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>

            <!-- Secondary Ghost/Underline Button -->
            <a
                href="#"
                class="text-white border-b border-gray-700 pb-1 uppercase text-[12px] md:text-[13px] tracking-[0.2em] font-bold hover:text-[#156E8A] hover:border-[#156E8A] transition-colors w-full sm:w-auto text-center mt-2 sm:mt-0">
                See Real Homes
            </a>
        </div>
    </section>
</main>
<?php get_footer(); ?>