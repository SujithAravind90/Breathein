<?php
/**
 * Breathein saved addresses.
 *
 * This keeps the supplied address-card design while reading the actual
 * billing and shipping details from the current WooCommerce customer.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

/* Always read the database customer. WC()->customer may contain checkout
 * session data from before the address edit was saved. */
$customer = new WC_Customer(get_current_user_id());
$default_type = function_exists('breathein_customer_default_address_type')
    ? breathein_customer_default_address_type()
    : '';

$address_types = [
    'billing' => __('Billing Address', 'breathein'),
];

if (
    (!function_exists('wc_ship_to_billing_address_only') || !wc_ship_to_billing_address_only())
    && (!function_exists('wc_shipping_enabled') || wc_shipping_enabled())
) {
    $address_types['shipping'] = __('Shipping Address', 'breathein');
}

$account_url = function_exists('wc_get_page_permalink')
    ? wc_get_page_permalink('myaccount')
    : home_url('/my-account/');

$get_value = static function (WC_Customer $customer, string $type, string $field): string {
    $method = 'get_' . $type . '_' . $field;

    if (!method_exists($customer, $method)) {
        return '';
    }

    return trim((string) $customer->{$method}('view'));
};

$get_state_name = static function (string $country, string $state): string {
    if (!$state || !function_exists('WC') || !WC()->countries) {
        return $state;
    }

    $states = WC()->countries->get_states($country);

    return is_array($states) && isset($states[$state])
        ? (string) $states[$state]
        : $state;
};

$get_country_name = static function (string $country): string {
    if (!$country || !function_exists('WC') || !WC()->countries) {
        return $country;
    }

    return isset(WC()->countries->countries[$country])
        ? (string) WC()->countries->countries[$country]
        : $country;
};

$cards = [];

foreach ($address_types as $type => $title) {
    $first_name = $get_value($customer, $type, 'first_name');
    $last_name = $get_value($customer, $type, 'last_name');
    $company = $get_value($customer, $type, 'company');
    $address_1 = $get_value($customer, $type, 'address_1');
    $address_2 = $get_value($customer, $type, 'address_2');
    $city = $get_value($customer, $type, 'city');
    $state_code = $get_value($customer, $type, 'state');
    $postcode = $get_value($customer, $type, 'postcode');
    $country_code = $get_value($customer, $type, 'country');
    $phone = $get_value($customer, $type, 'phone');

    if (!$phone && 'shipping' === $type) {
        $phone = $get_value($customer, 'billing', 'phone');
    }

    $state = $get_state_name($country_code, $state_code);
    $country = $get_country_name($country_code);
    $full_name = trim($first_name . ' ' . $last_name);
    $location_parts = array_filter([$city, $state], static function ($value): bool {
        return '' !== trim((string) $value);
    });
    $location = implode(', ', $location_parts);

    if ($postcode) {
        $location = $location ? $location . ' — ' . $postcode : $postcode;
    }

    $has_address = (bool) array_filter(
        [$company, $address_1, $address_2, $city, $state, $postcode, $phone],
        static function ($value): bool {
            return '' !== trim((string) $value);
        }
    );

    $cards[$type] = [
        'title'       => $title,
        'edit_url'    => wc_get_endpoint_url('edit-address', $type, $account_url),
        'full_name'   => $full_name,
        'company'     => $company,
        'address_1'   => $address_1,
        'address_2'   => $address_2,
        'location'    => $location,
        'country'     => $country,
        'phone'       => $phone,
        'has_address' => $has_address,
        'is_default'  => $has_address && $default_type === $type,
    ];
}

$add_type = isset($cards['billing']) && !$cards['billing']['has_address']
    ? 'billing'
    : (isset($cards['shipping']) && !$cards['shipping']['has_address'] ? 'shipping' : 'billing');
$can_add_address = isset($cards[$add_type]) && !$cards[$add_type]['has_address'];
$add_url = $can_add_address
    ? wc_get_endpoint_url('edit-address', $add_type, $account_url)
    : $account_url;
?>

<div class="breathein-account-addresses flex flex-col w-full">
    <h2 class="hidden lg:block text-[20px] font-medium tracking-tight mb-[12px]">
        <?php esc_html_e('Addresses', 'breathein'); ?>
    </h2>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h2 class="hidden lg:block text-[20px] font-medium tracking-tight mb-[12px]">
                <?php esc_html_e('Saved Addresses', 'breathein'); ?>
            </h2>
            <p class="text-[13px] md:text-[14px] text-gray-500 font-light">
                <?php esc_html_e('Manage your delivery addresses', 'breathein'); ?>
            </p>
        </div>

        <a
            href="<?php echo esc_url($add_url); ?>"
            class="bg-[#156E8A] text-white px-5 py-3 md:py-2.5 text-[11px] font-bold uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-[#115a72] transition-colors rounded-sm shrink-0 w-full md:w-auto">
            <?php echo esc_html($can_add_address ? __('+ Add Address', 'breathein') : __('Manage Addresses', 'breathein')); ?>
        </a>
    </div>

    <div class="flex flex-col gap-4 lg:gap-6">
        <?php foreach ($cards as $type => $card) : ?>
            <article class="breathein-account-address-card flex flex-col lg:flex-row justify-between bg-white dark:bg-[#0a0f12] border border-gray-200 dark:border-gray-800 rounded-[2px] w-full transition-colors duration-300 hover:shadow-sm">
                <div class="flex items-center md:items-start gap-4 px-5 py-4 lg:p-6 border-b border-gray-100 dark:border-gray-800 lg:border-none shrink-0">
                    <div class="w-12 h-12 bg-[#F4F8F9] dark:bg-[#111a20] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#156E8A] dark:text-[#2094B6]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>

                    <div class="flex lg:hidden items-center gap-3">
                        <h3 class="text-[17px] font-bold text-gray-900 dark:text-white">
                            <?php echo esc_html($card['title']); ?>
                        </h3>
                        <?php if ($card['is_default']) : ?>
                            <span class="bg-[#E0F2FE] dark:bg-[#075985] text-[#0284C7] dark:text-[#38BDF8] text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-[2px]">
                                <?php esc_html_e('Default', 'breathein'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex flex-col px-5 py-5 lg:p-6 lg:pl-0 flex-1">
                    <div class="hidden lg:flex items-center gap-3 mb-2">
                        <h3 class="text-[16px] font-bold text-gray-900 dark:text-white">
                            <?php echo esc_html($card['title']); ?>
                        </h3>
                        <?php if ($card['is_default']) : ?>
                            <span class="bg-[#E0F2FE] dark:bg-[#075985] text-[#0284C7] dark:text-[#38BDF8] text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-[2px]">
                                <?php esc_html_e('Default', 'breathein'); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if ($card['has_address']) : ?>
                        <?php if ($card['full_name']) : ?>
                            <div class="text-[16px] font-medium mb-1.5 text-gray-900 dark:text-gray-200">
                                <?php echo esc_html($card['full_name']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($card['company']) : ?>
                            <div class="text-[14px] text-gray-500 dark:text-gray-400 mb-1">
                                <?php echo esc_html($card['company']); ?>
                            </div>
                        <?php endif; ?>

                        <address class="text-[14px] text-gray-400 font-light leading-relaxed mb-3 not-italic">
                            <?php if ($card['address_1']) : ?><?php echo esc_html($card['address_1']); ?><br><?php endif; ?>
                            <?php if ($card['address_2']) : ?><?php echo esc_html($card['address_2']); ?><br><?php endif; ?>
                            <?php if ($card['location']) : ?><?php echo esc_html($card['location']); ?><br><?php endif; ?>
                            <?php if ($card['country']) : ?><?php echo esc_html($card['country']); ?><?php endif; ?>
                        </address>

                        <?php if ($card['phone']) : ?>
                            <div class="text-[14px] text-gray-400 font-light"><?php echo esc_html($card['phone']); ?></div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="text-[16px] font-medium mb-1.5 text-gray-900 dark:text-gray-200">
                            <?php printf(esc_html__('No %s saved', 'breathein'), esc_html(strtolower($card['title']))); ?>
                        </div>
                        <p class="text-[14px] text-gray-400 font-light leading-relaxed">
                            <?php esc_html_e('Add an address to speed up your next checkout.', 'breathein'); ?>
                        </p>
                    <?php endif; ?>

                    <div class="flex flex-col lg:hidden w-full mt-6 gap-3">
                        <?php if ($card['has_address'] && !$card['is_default']) : ?>
                            <form method="post" class="w-full">
                                <input type="hidden" name="breathein_address_action" value="set_default">
                                <input type="hidden" name="breathein_address_type" value="<?php echo esc_attr($type); ?>">
                                <?php wp_nonce_field('breathein_address_action', 'breathein_address_nonce'); ?>
                                <button type="submit" class="w-full border border-[#156E8A]/50 text-[#156E8A] dark:border-gray-700 dark:text-[#2094B6] py-2.5 text-[12px] font-medium uppercase tracking-[0.05em] text-center transition-colors hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <?php esc_html_e('Set Default', 'breathein'); ?>
                                </button>
                            </form>
                        <?php endif; ?>

                        <div class="flex items-center gap-3 w-full">
                            <a href="<?php echo esc_url($card['edit_url']); ?>" class="flex-1 border border-[#156E8A] text-[#156E8A] dark:border-[#2094B6] dark:text-[#2094B6] py-2.5 text-[12px] font-medium uppercase tracking-[0.05em] text-center transition-colors hover:bg-[#156E8A] hover:text-white">
                                <?php echo esc_html($card['has_address'] ? __('Edit', 'breathein') : __('Add', 'breathein')); ?>
                            </a>

                            <?php if ($card['has_address']) : ?>
                                <form method="post" class="flex-1">
                                    <input type="hidden" name="breathein_address_action" value="remove">
                                    <input type="hidden" name="breathein_address_type" value="<?php echo esc_attr($type); ?>">
                                    <?php wp_nonce_field('breathein_address_action', 'breathein_address_nonce'); ?>
                                    <button type="submit" class="w-full border border-red-300 text-red-600 dark:border-red-900 dark:text-red-400 py-2.5 text-[12px] font-medium uppercase tracking-[0.05em] text-center transition-colors hover:bg-red-50 dark:hover:bg-red-950/30">
                                        <?php esc_html_e('Remove', 'breathein'); ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:flex flex-wrap justify-end items-center gap-3 p-6 shrink-0 h-max max-w-[240px]">
                    <?php if ($card['has_address'] && !$card['is_default']) : ?>
                        <form method="post">
                            <input type="hidden" name="breathein_address_action" value="set_default">
                            <input type="hidden" name="breathein_address_type" value="<?php echo esc_attr($type); ?>">
                            <?php wp_nonce_field('breathein_address_action', 'breathein_address_nonce'); ?>
                            <button type="submit" class="border border-[#156E8A]/50 dark:border-gray-700 text-[#156E8A] dark:text-[#2094B6] px-4 py-2 text-[13px] font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <?php esc_html_e('Set Default', 'breathein'); ?>
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($card['edit_url']); ?>" class="border border-[#156E8A]/50 dark:border-gray-700 text-[#156E8A] dark:text-[#2094B6] px-6 py-2 text-[13px] font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <?php echo esc_html($card['has_address'] ? __('Edit', 'breathein') : __('Add', 'breathein')); ?>
                    </a>

                    <?php if ($card['has_address']) : ?>
                        <form method="post">
                            <input type="hidden" name="breathein_address_action" value="remove">
                            <input type="hidden" name="breathein_address_type" value="<?php echo esc_attr($type); ?>">
                            <?php wp_nonce_field('breathein_address_action', 'breathein_address_nonce'); ?>
                            <button type="submit" class="border border-red-300 text-red-600 dark:border-red-900 dark:text-red-400 px-4 py-2 text-[13px] font-medium hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors">
                                <?php esc_html_e('Remove', 'breathein'); ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>
