/* assets/js/cart.js */

(function ($) {
  "use strict";

  let updateTimer = null;

  function getNumber(value, fallback) {
    const number = Number.parseFloat(value);
    return Number.isFinite(number) ? number : fallback;
  }

  function syncQuantityControl($control) {
    const $input = $control.find("input.qty:not([type='hidden'])");
    const $decrease = $control.find(
      '[data-breathein-quantity-change="-1"]',
    );
    const $increase = $control.find(
      '[data-breathein-quantity-change="1"]',
    );

    if (!$input.length) {
      $decrease.prop("disabled", true);
      $increase.prop("disabled", true);
      return;
    }

    const value = getNumber($input.val(), 0);
    const minimum = getNumber($input.attr("min"), 0);
    const maximum = getNumber($input.attr("max"), Number.POSITIVE_INFINITY);

    $decrease.prop("disabled", value <= minimum);
    $increase.prop("disabled", value >= maximum);
  }

  function syncAllQuantityControls() {
    $("[data-breathein-quantity]").each(function () {
      syncQuantityControl($(this));
    });
  }

  function submitCartUpdate($form) {
    const $updateButton = $form.find('[name="update_cart"]');

    if (!$updateButton.length) {
      return;
    }

    $updateButton.prop("disabled", false).trigger("click");
  }

  function queueCartUpdate($form) {
    window.clearTimeout(updateTimer);
    updateTimer = window.setTimeout(function () {
      submitCartUpdate($form);
    }, 120);
  }

  $(document).on(
    "click",
    "[data-breathein-quantity-change]",
    function (event) {
      event.preventDefault();

      const $button = $(this);
      const $control = $button.closest("[data-breathein-quantity]");
      const $input = $control.find("input.qty:not([type='hidden'])");

      if (!$input.length || $button.prop("disabled")) {
        return;
      }

      const step = Math.max(getNumber($input.attr("step"), 1), 0.000001);
      const minimum = getNumber($input.attr("min"), 0);
      const maximum = getNumber(
        $input.attr("max"),
        Number.POSITIVE_INFINITY,
      );
      const currentValue = getNumber($input.val(), minimum);
      const direction = getNumber(
        $button.attr("data-breathein-quantity-change"),
        0,
      );
      const decimalPlaces = String(step).includes(".")
        ? String(step).split(".")[1].length
        : 0;
      const nextValue = Math.min(
        maximum,
        Math.max(minimum, currentValue + direction * step),
      );

      $input
        .val(nextValue.toFixed(decimalPlaces))
        .trigger("input")
        .trigger("change");

      syncQuantityControl($control);
    },
  );

  $(document).on(
    "change",
    ".woocommerce-cart-form input.qty",
    function () {
      const $input = $(this);
      syncQuantityControl($input.closest("[data-breathein-quantity]"));
      queueCartUpdate($input.closest("form.woocommerce-cart-form"));
    },
  );

  $(syncAllQuantityControls);
  $(document.body).on("updated_wc_div", syncAllQuantityControls);
})(jQuery);
