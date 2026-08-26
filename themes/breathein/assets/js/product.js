(function ($) {
  "use strict";

  function initProductGallery() {
    var mainElement = document.querySelector(".breathein-product-main-swiper");
    var thumbElement = document.querySelector(".breathein-product-thumb-swiper");

    if (!mainElement || !thumbElement || typeof Swiper === "undefined") {
      return;
    }

    var thumbnails = new Swiper(thumbElement, {
      spaceBetween: 16,
      slidesPerView: 3,
      watchSlidesProgress: true,
      breakpoints: {
        768: {
          spaceBetween: 20,
        },
      },
    });

    new Swiper(mainElement, {
      spaceBetween: 16,
      slidesPerView: 1,
      thumbs: {
        swiper: thumbnails,
      },
    });
  }

  function clampQuantity(input, requestedValue) {
    var min = Number(input.getAttribute("min")) || 1;
    var max = Number(input.getAttribute("max")) || 0;
    var value = Number(requestedValue) || min;

    value = Math.max(min, value);

    if (max > 0) {
      value = Math.min(max, value);
    }

    input.value = value;
    $(input).trigger("change");
  }

  $(function () {
    initProductGallery();

    $(document).on("click", "[data-breathein-quantity-change]", function () {
      var button = this;
      var control = button.closest("[data-breathein-quantity]");
      var input = control ? control.querySelector('input[name="quantity"]') : null;

      if (!input) {
        return;
      }

      var direction = Number(button.getAttribute("data-breathein-quantity-change")) || 0;
      var step = Number(input.getAttribute("step")) || 1;
      clampQuantity(input, (Number(input.value) || 1) + direction * step);
    });

    $(document).on("input change", '.breathein-product-cart input[name="quantity"]', function () {
      clampQuantity(this, this.value);
    });
  });
})(jQuery);
