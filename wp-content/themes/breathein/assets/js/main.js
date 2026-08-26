/* assets/js/main.js */

(function ($) {
  "use strict";

$(document).ready(async function () {
  setActiveNav();
  initHeaderFooterLogic();
  // 2. Initialize the rest of the page components (Swipers, ScrollReveal)
  initPageScripts();
});

// ==========================================
// 2. HEADER & FOOTER SPECIFIC LOGIC
// ==========================================
function initHeaderFooterLogic() {
  function openNav() {
    const $mobileNavOverlay = $("#mobileNavOverlay");
    const $body = $("body");
    const $openButton = $("#openMobileNav");

    $mobileNavOverlay
      .removeClass("hidden")
      .addClass("flex")
      .attr("aria-hidden", "false");
    $openButton.attr("aria-expanded", "true");
    setTimeout(function () {
      $mobileNavOverlay
        .removeClass("opacity-0 pointer-events-none")
        .addClass("opacity-100 pointer-events-auto");
    }, 10);
    $body.addClass("overflow-hidden");
  }

  function closeNav() {
    const $mobileNavOverlay = $("#mobileNavOverlay");
    const $body = $("body");
    const $openButton = $("#openMobileNav");

    $mobileNavOverlay
      .removeClass("opacity-100 pointer-events-auto")
      .addClass("opacity-0 pointer-events-none")
      .attr("aria-hidden", "true");
    $openButton.attr("aria-expanded", "false");
    setTimeout(function () {
      $mobileNavOverlay.removeClass("flex").addClass("hidden");
    }, 300);
    $body.removeClass("overflow-hidden");
  }

  // REPLACE your old click handlers with these Event Delegated versions:
  $(document).on("click", "#openMobileNav", function (e) {
    e.preventDefault();
    openNav();
  });

  $(document).on(
    "click",
    "#closeMobileNav, #mobileNavOverlay nav a",
    function (e) {
      if ($(this).attr("id") === "closeMobileNav") e.preventDefault();
      closeNav();
    },
  );

  $(document).on("keydown", function (e) {
    if (e.key === "Escape" && $("#openMobileNav").attr("aria-expanded") === "true") {
      closeNav();
      $("#openMobileNav").trigger("focus");
    }
  });

  // Smart Header Scroll Logic
  let lastScrollTop = 0;

  $(window).on("scroll", function () {
    const $header = $("#smart-header");
    if (!$header.length) return; // Prevent errors if header isn't found

    let currentScroll = $(this).scrollTop();

    if (currentScroll <= 0) {
      $header.removeClass("-translate-y-full").addClass("translate-y-0");
      lastScrollTop = currentScroll;
      return;
    }

    if (currentScroll > lastScrollTop && currentScroll > 100) {
      $header.removeClass("translate-y-0").addClass("-translate-y-full");
    } else {
      $header.removeClass("-translate-y-full").addClass("translate-y-0");
    }

    lastScrollTop = currentScroll;
  });

  // Back to Top Button Logic (Footer)
  $(document).on("click", "#backToTop", function (e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
}

// ==========================================
// 3. NAVIGATION ACTIVE STATE
// ==========================================
function setActiveNav() {
  const currentUrl = new URL(window.location.href);
  const currentPath = currentUrl.pathname.replace(/\/+$/, "") || "/";
  const navLinks = document.querySelectorAll("nav a[href]");

  navLinks.forEach((link) => {
    const linkHref = link.getAttribute("href");
    if (
      !linkHref ||
      linkHref.startsWith("#") ||
      linkHref.startsWith("mailto:") ||
      linkHref.startsWith("tel:")
    ) {
      return;
    }

    const linkUrl = new URL(linkHref, currentUrl.href);
    if (linkUrl.origin !== currentUrl.origin) return;

    const linkPath = linkUrl.pathname.replace(/\/+$/, "") || "/";
    if (linkPath === currentPath) {
      link.classList.remove("text-gray-500", "font-light");
      link.classList.add(
        "text-[#156E8A]",
        "font-medium",
        "border-b",
        "border-[#156E8A]",
        "pb-1",
      );
    } else {
      link.classList.remove(
        "text-[#156E8A]",
        "font-medium",
        "border-b",
        "border-[#156E8A]",
        "pb-1",
      );
      link.classList.add("text-gray-500", "font-light");
    }
  });
}

// ==========================================
// 4. MAIN PAGE SCRIPTS (Swipers, Reveal, etc)
// ==========================================
function initPageScripts() {
  // Hero Swiper Carousel
  if ($(".heroSwiper").length) {
    const heroSwiper = new Swiper(".heroSwiper", {
      loop: true,
      effect: "fade",
      fadeEffect: { crossFade: true },
      speed: 1000,
      autoplay: { delay: 6000, disableOnInteraction: false },
      pagination: { el: ".swiper-pagination", clickable: true },
      on: {
        slideChangeTransitionStart: function () {
          $(
            ".swiper-slide .slide-content, .swiper-slide .slide-product, .swiper-slide .slide-widget",
          ).removeClass("!opacity-100 !translate-y-0 !translate-x-0");
        },
        slideChangeTransitionEnd: function () {
          $(".swiper-slide-active .slide-content").addClass(
            "!opacity-100 !translate-y-0",
          );
          $(".swiper-slide-active .slide-product").addClass(
            "!opacity-100 !translate-y-0",
          );
          $(".swiper-slide-active .slide-widget").addClass(
            "!opacity-100 !translate-x-0",
          );
        },
        init: function () {
          setTimeout(() => {
            $(".swiper-slide-active .slide-content").addClass(
              "!opacity-100 !translate-y-0",
            );
            $(".swiper-slide-active .slide-product").addClass(
              "!opacity-100 !translate-y-0",
            );
            $(".swiper-slide-active .slide-widget").addClass(
              "!opacity-100 !translate-x-0",
            );
          }, 100);
        },
      },
    });
  }

  // Scroll Reveal Animations
  const revealElements = document.querySelectorAll(".scroll-reveal");
  if (revealElements.length) {
    const revealOptions = { threshold: 0.15, rootMargin: "0px 0px -50px 0px" };
    const revealObserver = new IntersectionObserver(function (
      entries,
      observer,
    ) {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.remove(
            "opacity-0",
            "translate-y-8",
            "translate-y-6",
          );
          observer.unobserve(entry.target);
        }
      });
    }, revealOptions);
    revealElements.forEach((el) => revealObserver.observe(el));
  }

  // Product Matcher Slider Logic
  const $roomSlider = $("#roomAreaSlider");
  const $roomValue = $("#roomAreaValue");
  if ($roomSlider.length) {
    const $matcherRoot = $roomSlider.closest("[data-product-matcher]");
    const $matcherProducts = $matcherRoot.find("[data-matcher-product]");
    const $matcherStatus = $matcherRoot.find("#matcherStatus");
    const $matcherProductId = $matcherRoot.find("#matcherProductId");
    const $matcherRoomArea = $matcherRoot.find("#matcherRoomArea");
    const locale = document.documentElement.lang || "en-IN";
    const numberFormatter = new Intl.NumberFormat(locale);
    const labelDisplay = document.getElementById("roomAreaLabel");
    let activeProductId = null;

    function updateProductMatcher() {
      const roomArea = Number($roomSlider.val());
      const formattedRoomArea = numberFormatter.format(roomArea);
      let $matchedProduct = $();

      $roomValue.text(formattedRoomArea);
      $roomSlider.attr(
        "aria-valuetext",
        `${formattedRoomArea} square feet`,
      );
      $matcherRoomArea.val(roomArea);

      if (labelDisplay) {
        if (roomArea < 300) {
          labelDisplay.textContent = "About a small bedroom";
        } else if (roomArea < 600) {
          labelDisplay.textContent = "About a medium living room";
        } else if (roomArea < 1000) {
          labelDisplay.textContent = "About a large open-plan space";
        } else {
          labelDisplay.textContent = "About a very large or commercial space";
        }
      }

      $matcherProducts.each(function () {
        const $candidate = $(this);
        const coverage = Number($candidate.attr("data-coverage"));

        if (!$matchedProduct.length && coverage >= roomArea) {
          $matchedProduct = $candidate;
        }
      });

      if (!$matchedProduct.length && $matcherProducts.length) {
        $matchedProduct = $matcherProducts.last();
      }

      if (!$matchedProduct.length) {
        return;
      }

      $matcherProducts.each(function () {
        const $product = $(this);
        const isActive = this === $matchedProduct.get(0);

        $product.toggleClass("hidden", !isActive);

        if (isActive) {
          $product.removeAttr("hidden aria-hidden");
        } else {
          $product.attr({ hidden: true, "aria-hidden": "true" });
        }
      });

      const productId = $matchedProduct.attr("data-product-id") || "";
      const productName = $matchedProduct.attr("data-product-name") || "";
      const productCoverage = Number(
        $matchedProduct.attr("data-coverage"),
      );

      $matcherProductId.val(productId);

      if (activeProductId !== productId) {
        $matcherStatus.text(
          `${productName} is your match and covers up to ` +
            `${numberFormatter.format(productCoverage)} square feet.`,
        );
        activeProductId = productId;
      }
    }

    $roomSlider.on("input change", updateProductMatcher);
    updateProductMatcher();
  }

  // Other Swipers
  if ($(".benefitsSwiper").length) {
    new Swiper(".benefitsSwiper", {
      slidesPerView: 1,
      spaceBetween: 8,
      grabCursor: true,
      pagination: { el: ".benefitsSwiper .swiper-pagination", clickable: true },
      breakpoints: {
        768: { slidesPerView: 2, spaceBetween: 6, grabCursor: true },
        1024: {
          slidesPerView: 4,
          spaceBetween: 6,
          grabCursor: false,
          allowTouchMove: false,
        },
      },
    });
  }

  if ($(".caseStudiesSwiper").length) {
    new Swiper(".caseStudiesSwiper", {
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: ".caseStudiesSwiper .swiper-pagination",
        clickable: true,
      },
      breakpoints: { 768: { allowTouchMove: false } },
    });
  }

  if ($(".ownershipSwiper").length) {
    new Swiper(".ownershipSwiper", {
      slidesPerView: 1.1,
      spaceBetween: 16,
      pagination: {
        el: ".ownershipSwiper .swiper-pagination",
        clickable: true,
      },
      breakpoints: { 768: { allowTouchMove: false } },
    });
  }

  if ($(".whyChooseSwiper").length) {
    new Swiper(".whyChooseSwiper", {
      slidesPerView: 1.1,
      spaceBetween: 16,
      pagination: {
        el: ".whyChooseSwiper .swiper-pagination",
        clickable: true,
      },
      breakpoints: { 768: { allowTouchMove: false } },
    });
  }
  if ($(".productThumbSwiper").length) {
    new Swiper(".productThumbSwiper", {
      spaceBetween: 16, // Gap between thumbs on mobile
      slidesPerView: 3, // Show 3 thumbs
      watchSlidesProgress: true,
      breakpoints: {
        768: {
          spaceBetween: 20, // Wider gap on desktop
        },
      },
    });
  }
  if ($(".productMainSwiper").length) {
    new Swiper(".productMainSwiper", {
      spaceBetween: 16, // Gap between thumbs on mobile
      slidesPerView: 1, // Show 3 thumbs
      watchSlidesProgress: true,
      breakpoints: {
        768: {
          spaceBetween: 20, // Wider gap on desktop
        },
      },
      thumbs: {
        swiper: ".productThumbSwiper",
      },
    });
  }
  if ($(".reviewsSwiper").length) {
    new Swiper(".reviewsSwiper", {
      slidesPerView: "auto", // Allows the 85% width cards to peek out
      spaceBetween: 16, // Gap between mobile cards
      grabCursor: true,
      pagination: {
        el: ".reviews-pagination",
        clickable: true,
      },
      breakpoints: {
        // When window width is >= 1024px (Tailwind lg breakpoint)
        1024: {
          enabled: false, // Disables Swiper entirely
          spaceBetween: 0, // Resets spacing so CSS Grid takes over perfectly
        },
      },
    });
  }
  if ($(".caseStudySwiper").length) {
    new Swiper(".caseStudySwiper", {
      slidesPerView: 1, // Allows the 85% width cards to peek out on mobile
      spaceBetween: 16,
      grabCursor: true,
      breakpoints: {
        // Tablet
        768: {
          slidesPerView: 2,
          spaceBetween: 24,
        },
        // Desktop
        1024: {
          slidesPerView: 3,
          spaceBetween: 32, // Perfect gap for the 3-column grid
        },
      },
    });
  }

  // ==========================================
  // MOBILE COMPARE TABLE INTERACTION
  // ==========================================
  const compareData = [
    {
      id: 0,
      name: "Air Pro",
      price: "From ₹9,999",
      badge: null,
      isHighlight: false,
      specs: {
        model: "720W",
        coverage: "35 - 40 m²",
        cadr: "215 m³/h",
        filtration: "3-Stage",
        idealSpace: "Bedroom / Compact",
        weight: "4.9 kg",
        hepaH13: true,
        appControl: false,
        realtimeAqi: false,
        reactiveO2: false,
        humidifier: false,
        virusRemoval: "99.07%"
      }
    },
    {
      id: 1,
      name: "Air Pro 1",
      price: "From ₹19,999",
      badge: "MOST CHOSEN",
      isHighlight: true,
      specs: {
        model: "D90",
        coverage: "50 - 55 m²",
        cadr: "400 m³/h",
        filtration: "4-Stage",
        idealSpace: "Medium-Large Room",
        weight: "9.8 kg",
        hepaH13: true,
        appControl: true,
        realtimeAqi: true,
        reactiveO2: true,
        humidifier: false,
        virusRemoval: "99.97%"
      }
    },
    {
      id: 2,
      name: "Air Pro 2",
      price: "From ₹24,999",
      badge: null,
      isHighlight: false,
      specs: {
        model: "H80",
        coverage: "75 - 80 m²",
        cadr: "600 m³/h",
        filtration: "7-in-1 System",
        idealSpace: "Open Plan Living",
        weight: "12.5 kg",
        hepaH13: true,
        appControl: true,
        realtimeAqi: true,
        reactiveO2: true,
        humidifier: true,
        virusRemoval: "99.99%"
      }
    },
    {
      id: 3,
      name: "Air Pro Max",
      price: "From ----",
      badge: null,
      isHighlight: false,
      specs: {
        model: "MAX1",
        coverage: "120 - 150 m²",
        cadr: "1000 m³/h",
        filtration: "6-Stage Multi-Cyclone",
        idealSpace: "Entire Floor",
        weight: "18.2 kg",
        hepaH13: true,
        appControl: true,
        realtimeAqi: true,
        reactiveO2: true,
        humidifier: false,
        virusRemoval: "99.99%"
      }
    }
  ];

  let selectedCompareModels = [0, 1];

  function renderMobileCompare() {
    const $container = $("#mobileCompareTable");
    if (!$container.length) return;

    const m1 = compareData[selectedCompareModels[0]];
    const m2 = compareData[selectedCompareModels[1]];

    const renderVal = (val) => {
      if (val === true) {
        return `<svg class="w-3.5 h-3.5 text-[#156E8A] dark:text-[#22D3EE] mx-auto" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
      }
      if (val === false) {
        return `<span class="text-gray-300 dark:text-gray-600 font-light">&mdash;</span>`;
      }
      return `<span class="text-gray-700 dark:text-gray-300 font-normal">${val}</span>`;
    };

    const specRows = [
      { label: "MODEL", key: "model" },
      { label: "COVERAGE", key: "coverage" },
      { label: "CADR", key: "cadr" },
      { label: "FILTRATION", key: "filtration" },
      { label: "IDEAL SPACE", key: "idealSpace" },
      { label: "WEIGHT", key: "weight" },
      { label: "HEPA H13", key: "hepaH13" },
      { label: "APP CONTROL", key: "appControl" },
      { label: "REAL-TIME AQI", key: "realtimeAqi" },
      { label: "REACTIVE O₂", key: "reactiveO2" },
      { label: "HUMIDIFIER", key: "humidifier" },
      { label: "VIRUS REMOVAL", key: "virusRemoval" }
    ];

    let html = `
      <div class="grid grid-cols-[105px_1fr_1fr] text-xs">
        <!-- Header -->
        <div class="p-3.5 flex items-end text-[10px] uppercase tracking-wider text-gray-400 font-bold border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-[#111a20]">
          FEATURE
        </div>
        <div class="p-3.5 flex flex-col items-center justify-center text-center border-b border-gray-100 dark:border-gray-800 ${m1.isHighlight ? 'bg-[#EDF3F6] dark:bg-[#16222a]' : 'bg-white dark:bg-[#111a20]'} relative">
          ${m1.badge ? `<div class="bg-[#156E8A] text-white text-[7px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-sm mb-1">${m1.badge}</div>` : ''}
          <h4 class="text-[13px] font-medium text-gray-900 dark:text-white">${m1.name}</h4>
          <span class="text-[10px] text-gray-400 dark:text-gray-400 font-light mt-0.5">${m1.price}</span>
        </div>
        <div class="p-3.5 flex flex-col items-center justify-center text-center border-b border-gray-100 dark:border-gray-800 ${m2.isHighlight ? 'bg-[#EDF3F6] dark:bg-[#16222a]' : 'bg-white dark:bg-[#111a20]'} relative">
          ${m2.badge ? `<div class="bg-[#156E8A] text-white text-[7px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-sm mb-1">${m2.badge}</div>` : ''}
          <h4 class="text-[13px] font-medium text-gray-900 dark:text-white">${m2.name}</h4>
          <span class="text-[10px] text-gray-400 dark:text-gray-400 font-light mt-0.5">${m2.price}</span>
        </div>
    `;

    specRows.forEach(row => {
      html += `
        <div class="p-3 border-b border-gray-100 dark:border-gray-800 flex items-center text-[10px] uppercase tracking-wider font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#111a20]">
          ${row.label}
        </div>
        <div class="p-3 border-b border-gray-100 dark:border-gray-800 flex items-center justify-center text-center ${m1.isHighlight ? 'bg-[#EDF3F6] dark:bg-[#16222a]' : 'bg-white dark:bg-[#111a20]'}">
          ${renderVal(m1.specs[row.key])}
        </div>
        <div class="p-3 border-b border-gray-100 dark:border-gray-800 flex items-center justify-center text-center ${m2.isHighlight ? 'bg-[#EDF3F6] dark:bg-[#16222a]' : 'bg-white dark:bg-[#111a20]'}">
          ${renderVal(m2.specs[row.key])}
        </div>
      `;
    });

    // Action Row
    html += `
        <div class="p-3 bg-white dark:bg-[#111a20]"></div>
        <div class="p-3 ${m1.isHighlight ? 'bg-[#EDF3F6] dark:bg-[#16222a]' : 'bg-white dark:bg-[#111a20]'} flex items-center justify-center">
          <button class="w-full bg-[#141414] text-white text-[10px] font-bold tracking-wider uppercase py-2.5 px-2 rounded hover:bg-[#156E8A] transition-colors">
            BUY NOW
          </button>
        </div>
        <div class="p-3 ${m2.isHighlight ? 'bg-[#EDF3F6] dark:bg-[#16222a]' : 'bg-white dark:bg-[#111a20]'} flex items-center justify-center">
          <button class="w-full bg-[#141414] text-white text-[10px] font-bold tracking-wider uppercase py-2.5 px-2 rounded hover:bg-[#156E8A] transition-colors">
            BUY NOW
          </button>
        </div>
      </div>
    `;

    $container.html(html);

    // Update selector card active states
    $(".mobile-compare-btn").each(function () {
      const id = parseInt($(this).data("model"), 10);
      const isSelected = selectedCompareModels.includes(id);
      if (isSelected) {
        $(this).addClass("border-[#156E8A] bg-[#EDF3F6]/60 dark:bg-[#16222a]").removeClass("border-gray-200 dark:border-gray-800 bg-white dark:bg-[#111a20]");
        $(this).find(".select-status").removeClass("hidden").addClass("flex");
      } else {
        $(this).removeClass("border-[#156E8A] bg-[#EDF3F6]/60 dark:bg-[#16222a]").addClass("border-gray-200 dark:border-gray-800 bg-white dark:bg-[#111a20]");
        $(this).find(".select-status").addClass("hidden").removeClass("flex");
      }
    });
  }

  if ($("#mobileCompareTable").length) {
    renderMobileCompare();

    $(document).on("click", ".mobile-compare-btn", function () {
      const id = parseInt($(this).data("model"), 10);
      if (selectedCompareModels.includes(id)) {
        return;
      }
      selectedCompareModels.shift();
      selectedCompareModels.push(id);
      renderMobileCompare();
    });
  }

  // 1. ACCORDION TOGGLE LOGIC
  const faqButtons = document.querySelectorAll(".faq-toggle-btn");

  faqButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const content = button.nextElementSibling;
      const iconContainer = button.querySelector(".icon-container");

      // Toggle Content visibility
      content.classList.toggle("hidden");

      // Rotate Chevron Icon
      if (content.classList.contains("hidden")) {
        iconContainer.classList.remove("-rotate-180");
      } else {
        iconContainer.classList.add("-rotate-180");
      }
    });
  });

  // 2. SYNCHRONIZED CATEGORY FILTER LOGIC
  const filterButtons = document.querySelectorAll(".faq-filter-btn");
  const faqItems = document.querySelectorAll(".faq-item");

  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const targetCategory = this.getAttribute("data-filter");

      // A. Reset styles for ALL buttons (Desktop & Mobile)
      filterButtons.forEach((btn) => {
        // Remove active colors and borders
        btn.classList.remove(
          "text-[#156E8A]",
          "dark:text-[#2094B6]",
          "border-[#156E8A]",
          "dark:border-[#2094B6]",
        );
        // Add inactive text
        btn.classList.add("text-gray-500");
        // Add transparent border for mobile buttons
        if (btn.classList.contains("mob-filter-btn")) {
          btn.classList.add("border-transparent");
        }
      });

      // B. Apply active style to the target category (syncs Mobile & Desktop)
      const targetBtns = document.querySelectorAll(
        `.faq-filter-btn[data-filter="${targetCategory}"]`,
      );
      targetBtns.forEach((btn) => {
        btn.classList.remove("text-gray-500", "border-transparent");
        btn.classList.add("text-[#156E8A]", "dark:text-[#2094B6]");

        if (btn.classList.contains("mob-filter-btn")) {
          btn.classList.add("border-[#156E8A]", "dark:border-[#2094B6]");
        }
      });

      // C. Filter FAQ Items in the list
      faqItems.forEach((item) => {
        if (
          targetCategory === "all" ||
          item.getAttribute("data-category") === targetCategory
        ) {
          item.classList.remove("hidden");
        } else {
          item.classList.add("hidden");
        }
      });
    });
  });

  // 2. Simple Scroll Spy Logic (Highlights sidebar links as you scroll)
  const sections = document.querySelectorAll(".faq-section");
  const navLinks = document.querySelectorAll(".faq-nav-link");

  window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      // Check if we've scrolled past the section (with a 150px offset for headers)
      if (scrollY >= sectionTop - 150) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach((link) => {
      // Reset all links
      link.classList.remove("border-[#156E8A]", "text-[#156E8A]");
      link.classList.add("border-transparent", "text-gray-500");

      // Highlight active link
      if (link.getAttribute("href") === `#${current}`) {
        link.classList.remove("border-transparent", "text-gray-500");
        link.classList.add("border-[#156E8A]", "text-[#156E8A]");
      }
    });
  });

  const paymentRadios = document.querySelectorAll(
    'input[name="payment_method"]',
  );
  const paymentOptions = document.querySelectorAll(".payment-option");

  paymentRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      paymentOptions.forEach((option) => {
        const isChecked = option.querySelector('input[type="radio"]').checked;
        const outerRadio = option.querySelector(".radio-outer");
        const innerRadio = option.querySelector(".radio-inner");

        if (isChecked) {
          // Add Active State
          option.classList.remove(
            "border-gray-200",
            "dark:border-gray-700",
            "bg-white",
            "dark:bg-tickerDark",
            "hover:border-gray-300",
            "dark:hover:border-gray-600",
          );
          option.classList.add(
            "border-[#156E8A]",
            "bg-[#EEF5F7]",
            "dark:bg-[#111a20]",
          );

          outerRadio.classList.remove(
            "border-gray-200",
            "dark:border-gray-600",
          );
          outerRadio.classList.add("border-[#156E8A]");

          innerRadio.classList.remove("hidden");
        } else {
          // Reset to Inactive State
          option.classList.remove(
            "border-[#156E8A]",
            "bg-[#EEF5F7]",
            "dark:bg-[#111a20]",
          );
          option.classList.add(
            "border-gray-200",
            "dark:border-gray-700",
            "bg-white",
            "dark:bg-tickerDark",
            "hover:border-gray-300",
            "dark:hover:border-gray-600",
          );

          outerRadio.classList.remove("border-[#156E8A]");
          outerRadio.classList.add("border-gray-200", "dark:border-gray-600");

          innerRadio.classList.add("hidden");
        }
      });
    });
  });

  let currentStep = 1;
  const totalScreens = 5;
  const totalProgressSteps = 4; // Visual circles

  // --- BUTTON ELEMENTS ---
  const btnBack = document.getElementById("btn-back");
  const btnNext = document.getElementById("btn-next");
  const btnBackResults = document.getElementById("btn-back-results");
  const nextText = document.getElementById("btn-next-text");
  const globalFooter = document.getElementById("global-wizard-footer");

  // --- NAVIGATION LOGIC ---
  function navigateWizard(direction) {
    if (currentStep + direction < 1 || currentStep + direction > totalScreens)
      return;

    // Hide current step
    document
      .getElementById(`wizard-step-${currentStep}`)
      .classList.add("hidden");
    document
      .getElementById(`wizard-step-${currentStep}`)
      .classList.remove("block");

    currentStep += direction;

    // Show new step
    document
      .getElementById(`wizard-step-${currentStep}`)
      .classList.remove("hidden");
    document
      .getElementById(`wizard-step-${currentStep}`)
      .classList.add("block");

    updateProgressBar();
  }

  // --- BIND CLICK EVENTS ---
  if (btnBack) btnBack.addEventListener("click", () => navigateWizard(-1));
  if (btnNext) btnNext.addEventListener("click", () => navigateWizard(1));
  if (btnBackResults)
    btnBackResults.addEventListener("click", () => navigateWizard(-1));

  // --- PROGRESS BAR LOGIC ---
  function updateProgressBar() {
    if (!btnBack || !btnNext || !btnBackResults || !nextText || !globalFooter) {
      return;
    }

    // Toggle Global Footer visibility (hide on Results screen)
    if (currentStep === totalScreens) {
      globalFooter.classList.add("hidden");
      globalFooter.classList.remove("flex");
    } else {
      globalFooter.classList.remove("hidden");
      globalFooter.classList.add("flex");
    }

    // Back button visibility
    if (currentStep === 1) {
      btnBack.classList.add("invisible");
    } else {
      btnBack.classList.remove("invisible");
    }

    // Next button text
    if (currentStep === totalScreens - 1) {
      nextText.innerText = "SEE RESULTS";
    } else {
      nextText.innerText = "CONTINUE";
    }

    // Calculate progress line width based on active step (max 4)
    const activeLineStep = Math.min(currentStep, totalProgressSteps);
    const linePercentage =
      ((activeLineStep - 1) / (totalProgressSteps - 1)) * 80;
    const deskLine = document.getElementById("desk-progress-line");
    if (deskLine) deskLine.style.width = `${linePercentage}%`;

    // Update Circles
    for (let i = 1; i <= totalProgressSteps; i++) {
      const deskCircle = document.getElementById(`desk-step-${i}`);
      const mobCircle = document.getElementById(`mob-step-${i}`);

      // STATE: COMPLETED (Filled Background, White Text, No Outline Offset)
      if (i < currentStep) {
        if (deskCircle)
          deskCircle.className =
            "relative z-10 w-10 h-10 rounded-full bg-[#156E8A] text-white flex items-center justify-center text-[15px] font-medium transition-colors duration-300";
        if (mobCircle)
          mobCircle.className =
            "relative z-10 w-8 h-8 rounded-full bg-[#156E8A] text-white flex items-center justify-center text-[15px] font-medium transition-colors duration-300";
      }
      // STATE: CURRENT (White Background, Colored Border/Outline, Colored Text)
      else if (i === currentStep) {
        if (deskCircle)
          deskCircle.className =
            "relative z-10 w-10 h-10 rounded-full bg-white dark:bg-[#0a0f12] text-[#156E8A] dark:text-[#2094B6] border-2 border-[#156E8A] dark:border-[#2094B6] flex items-center justify-center text-[15px] font-medium outline outline-4 outline-white dark:outline-[#0a0f12] transition-colors duration-300";
        if (mobCircle)
          mobCircle.className =
            "relative z-10 w-8 h-8 rounded-full bg-white dark:bg-[#0a0f12] text-[#156E8A] dark:text-[#2094B6] border-2 border-[#156E8A] dark:border-[#2094B6] flex items-center justify-center text-[15px] font-medium transition-colors duration-300 outline outline-4 outline-[#FAFCFD] dark:outline-black";
      }
      // STATE: INACTIVE (White Background, Gray Border, Gray Text)
      else {
        if (deskCircle)
          deskCircle.className =
            "relative z-10 w-10 h-10 rounded-full bg-white dark:bg-[#0a0f12] text-gray-400 border border-gray-300 dark:border-gray-700 flex items-center justify-center text-[15px] font-medium outline outline-4 outline-white dark:outline-[#0a0f12] transition-colors duration-300";
        if (mobCircle)
          mobCircle.className =
            "relative z-10 w-8 h-8 rounded-full bg-white dark:bg-[#111a20] text-gray-400 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-[15px] font-medium transition-colors duration-300 outline outline-4 outline-[#FAFCFD] dark:outline-black";
      }
    }
  }

  // --- 1. SLIDER DYNAMIC UPDATE ---
  const slider = document.getElementById("roomAreaSlider");
  const valueDisplay = document.getElementById("roomAreaValue");
  const labelDisplay = document.getElementById("roomAreaLabel");

  if (slider && valueDisplay) {
    slider.addEventListener("input", function () {
      valueDisplay.textContent = this.value;

      if (!labelDisplay) return;

      if (this.value < 300) {
        labelDisplay.textContent = "About a small bedroom";
      } else if (this.value < 600) {
        labelDisplay.textContent = "About a medium living room";
      } else if (this.value < 1000) {
        labelDisplay.textContent = "About a large open-plan space";
      } else {
        labelDisplay.textContent = "About a very large or commercial space";
      }
    });
  }

  // --- 2. HANDLE RADIO BUTTONS (Ceiling & Room Type) ---
  const radioInputs = document.querySelectorAll('input[type="radio"]');
  radioInputs.forEach((radio) => {
    radio.addEventListener("change", function () {
      const siblingRadios = document.querySelectorAll(
        `input[name="${this.name}"]`,
      );

      siblingRadios.forEach((sibling) => {
        const label = sibling.closest(".radio-option");
        if (label) {
          label.classList.remove(
            "bg-[#EEF5F7]",
            "dark:bg-[#0c1318]",
            "border-[#156E8A]",
          );
          label.classList.add(
            "bg-white",
            "dark:bg-[#111a20]",
            "border-gray-200",
            "dark:border-gray-700",
          );
        }
      });

      const activeLabel = this.closest(".radio-option");
      if (activeLabel) {
        activeLabel.classList.remove(
          "bg-white",
          "dark:bg-[#111a20]",
          "border-gray-200",
          "dark:border-gray-700",
        );
        activeLabel.classList.add(
          "bg-[#EEF5F7]",
          "dark:bg-[#0c1318]",
          "border-[#156E8A]",
        );
      }
    });
  });

  // --- 3. HANDLE CHECKBOXES (Concerns) ---
  const checkboxInputs = document.querySelectorAll('input[type="checkbox"]');
  checkboxInputs.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const label = this.closest(".concern-option");
      const emptyIndicator = label.querySelector(".indicator-empty");
      const checkedIndicator = label.querySelector(".indicator-checked");

      if (this.checked) {
        label.classList.remove(
          "bg-white",
          "dark:bg-[#111a20]",
          "border-gray-200",
          "dark:border-gray-700",
        );
        label.classList.add(
          "bg-[#EEF5F7]",
          "dark:bg-[#0c1318]",
          "border-[#156E8A]",
        );

        emptyIndicator.classList.add("hidden");
        checkedIndicator.classList.remove("hidden");
        checkedIndicator.classList.add("flex");
      } else {
        label.classList.remove(
          "bg-[#EEF5F7]",
          "dark:bg-[#0c1318]",
          "border-[#156E8A]",
        );
        label.classList.add(
          "bg-white",
          "dark:bg-[#111a20]",
          "border-gray-200",
          "dark:border-gray-700",
        );

        checkedIndicator.classList.add("hidden");
        checkedIndicator.classList.remove("flex");
        emptyIndicator.classList.remove("hidden");
      }
    });
  });

  // --- INITIALIZE UI STATE ---
  updateProgressBar();

  const filterBtns = document.querySelectorAll(".order-filter-btn");
  const orderItems = document.querySelectorAll(".order-item");

  filterBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      console.log(btn);
      const targetFilter = btn.getAttribute("data-filter");

      // 1. Reset all buttons to inactive styling and ARIA state
      filterBtns.forEach((b) => {
        b.setAttribute("aria-pressed", "false"); // <-- Accessibility update
        b.classList.remove(
          "bg-[#156E8A]",
          "dark:bg-[#2094B6]",
          "text-white",
          "border-[#156E8A]",
        );
        b.classList.add(
          "bg-white",
          "dark:bg-[#111a20]",
          "text-gray-400",
          "border-gray-200",
          "dark:border-gray-700",
        );
      });

      // 2. Apply active styling and ARIA state to the clicked button
      btn.setAttribute("aria-pressed", "true"); // <-- Accessibility update
      btn.classList.remove(
        "bg-white",
        "dark:bg-[#111a20]",
        "text-gray-400",
        "border-gray-200",
        "dark:border-gray-700",
      );
      btn.classList.add(
        "bg-[#156E8A]",
        "dark:bg-[#2094B6]",
        "text-white",
        "border-[#156E8A]",
      );

      // 3. Instantly Show/Hide the corresponding orders and update ARIA visibility
      orderItems.forEach((item) => {
        // Force opacity back to 1 just in case previous script got it stuck at 0
        item.style.opacity = "1";

        if (
          targetFilter === "all" ||
          item.getAttribute("data-status") === targetFilter
        ) {
          item.style.display = ""; // Reverts to default CSS (flex/grid)
          item.setAttribute("aria-hidden", "false"); // <-- Accessibility update
        } else {
          item.style.display = "none"; // Completely hides the element
          item.setAttribute("aria-hidden", "true"); // <-- Accessibility update
        }
      });
    });
  });

  const activeMobileTab = document.querySelector('.active-mobile-tab');
  if (activeMobileTab) {
    // 'inline: center' ensures it scrolls to the middle of the screen
    activeMobileTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
  }
}

})(jQuery);
