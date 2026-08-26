/* assets/js/main.js */

(function ($) {
  "use strict";

$(document).ready(async function () {
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
// 3. MAIN PAGE SCRIPTS (Swipers, Reveal, etc)
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
  };

  const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const paymentOptions = document.querySelectorAll('.payment-option');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                
                paymentOptions.forEach(option => {
                    const isChecked = option.querySelector('input[type="radio"]').checked;
                    const outerRadio = option.querySelector('.radio-outer');
                    const innerRadio = option.querySelector('.radio-inner');

                    if (isChecked) {
                        // Add Active State
                        option.classList.remove('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-tickerDark', 'hover:border-gray-300', 'dark:hover:border-gray-600');
                        option.classList.add('border-[#156E8A]', 'bg-[#EEF5F7]', 'dark:bg-[#111a20]');
                        
                        outerRadio.classList.remove('border-gray-200', 'dark:border-gray-600');
                        outerRadio.classList.add('border-[#156E8A]');
                        
                        innerRadio.classList.remove('hidden');
                    } else {
                        // Reset to Inactive State
                        option.classList.remove('border-[#156E8A]', 'bg-[#EEF5F7]', 'dark:bg-[#111a20]');
                        option.classList.add('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-tickerDark', 'hover:border-gray-300', 'dark:hover:border-gray-600');
                        
                        outerRadio.classList.remove('border-[#156E8A]');
                        outerRadio.classList.add('border-gray-200', 'dark:border-gray-600');
                        
                        innerRadio.classList.add('hidden');
                    }
                });
            });
        });
}

})(jQuery);
