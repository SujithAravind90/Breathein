((jQuery) => {
  "use strict";

  const syncPaymentMethodState = () => {
    jQuery(".wc_payment_method").each(function () {
      const option = jQuery(this);
      const radio = option.children('input[name="payment_method"]');

      option.toggleClass("is-selected", radio.is(":checked"));
    });
  };

  jQuery(syncPaymentMethodState);

  jQuery(document).on(
    "change",
    '.woocommerce-checkout input[name="payment_method"]',
    syncPaymentMethodState
  );

  jQuery(document.body).on(
    "updated_checkout payment_method_selected",
    syncPaymentMethodState
  );
})(jQuery);
