<?php


function miniture_theme_register_required_plugins() {

  $plugins = array(

    'kitify' => array(
      'name'               => esc_html__('Kitify','miniture'),
      'slug'               => 'kitify',
      'source'             => 'http://assets.novaworks.net/plugins/kitify.zip',
      'required'           => true,
      'description'        => esc_html__('A perfect plugin for Elementor','miniture'),
      'demo_required'      => true,
      'version'            => '1.2.2'
    ),
    'miniture-core' => array(
      'name'               => esc_html__('Miniture Core','miniture'),
      'slug'               => 'miniture-core',
      'source'             => 'http://assets.novaworks.net/plugins/miniture-core.zip',
      'required'           => true,
      'description'        => esc_html__('Extends the functionality of Miniture with theme specific shortcodes and page builder elements.','miniture'),
      'demo_required'      => true,
      'version'            => '1.0.1'
    ),
    'elementor' => array(
      'name'               => esc_html__('Elementor Page Builder','miniture'),
      'slug'               => 'elementor',
      'required'           => true,
      'description'        => esc_html__('The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.','miniture'),
      'demo_required'      => true
    ),
    'wc-ajax-product-filter' => array(
      'name'               => esc_html__('Nova Ajax Product Filters','miniture'),
      'slug'               => 'nova-ajax-product-filter',
      'source'             => 'http://assets.novaworks.net/plugins/nova-ajax-product-filter.zip',
      'required'           => true,
      'description'        => esc_html__('A plugin to filter woocommerce products with AJAX request.','miniture'),
      'demo_required'      => true,
      'version'            => '1.0.2'
    ),
    'woocommerce' => array(
      'name'               => esc_html__('WooCommerce','miniture'),
      'slug'               => 'woocommerce',
      'required'           => true,
      'description'        => esc_html__('The eCommerce engine','miniture'),
      'demo_required'      => true
    ),
    'revslider' => array(
      'name'               => esc_html__('Slider Revolution','miniture'),
      'slug'               => 'revslider',
      'source'				     => 'http://assets.novaworks.net/plugins/revslider.zip',
      'required'           => false,
      'demo_required'      => true,
      'version'            => '6.7.36'
    ),
    'miniture-demo-data' => array(
      'name'               => esc_html__('Miniture Package Demo Data','miniture'),
      'slug'               => 'miniture-demo-data',
      'source'				     => 'http://assets.novaworks.net/plugins/miniture/miniture-demo-data.zip',
      'required'           => false,
      'demo_required'      => true,
      'version'            => '1.0.1'
    ),
    'woo-variation-swatches' => array(
      'name'               => esc_html__('Variation Swatches for WooCommerce','miniture'),
      'slug'               => 'woo-variation-swatches',
      'required'           => false,
      'description'        => esc_html__('Beautiful colors, images and buttons variation swatches for woocommerce product attributes. Requires WooCommerce 3.2+','miniture'),
      'demo_required'      => true
    ),
    'yith-woocommerce-wishlist' => array(
      'name'               => esc_html__('YITH WooCommerce Wishlist','miniture'),
      'slug'               => 'yith-woocommerce-wishlist',
      'required'           => false,
      'description'        => esc_html__('YITH WooCommerce Wishlist gives your users the possibility to create, fill, manage and share their wishlists allowing you to analyze their interests and needs to improve your marketing strategies.','miniture'),
      'demo_required'      => true
    ),
    'contact-form-7' => array(
      'name'               => esc_html__('Contact Form 7','miniture'),
      'slug'               => 'contact-form-7',
      'required'           => false,
      'description'        => esc_html__('Just another contact form plugin. Simple but flexible.','miniture'),
      'demo_required'      => true
    ),
    'envato-market' => array(
      'name'               => esc_html__('Envato Market','miniture'),
      'slug'               => 'envato-market',
      'source'             => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
      'required'           => false,
      'description'        => esc_html__('Automatically update your Envato theme','miniture'),
      'demo_required'      => true
    ),
  );

	$config = array(
	  'id'                => 'miniture',
		'default_path'      => '',
		'parent_slug'       => 'themes.php',
		'menu'              => 'tgmpa-install-plugins',
		'has_notices'       => true,
		'is_automatic'      => true,
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'miniture_theme_register_required_plugins' );
