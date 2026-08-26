<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_filter('kitify/adobe_fonts/id', 'miniture_kitify_adobe_fonts_id');
if(!function_exists('miniture_kitify_adobe_fonts_id')){
    function miniture_kitify_adobe_fonts_id(){
        return '';
    }
}

add_filter('kitify/logo/attr/src', 'miniture_kitify_logo_attr_src');
if(!function_exists('miniture_kitify_logo_attr_src')){
    function miniture_kitify_logo_attr_src( $src ){
        $nova_theme = nova_get_theme_options();
        if(!$src && $nova_theme){
	        $src = esc_url( $nova_theme['header_logo']['url'] );
        }
        return $src;
    }
}

add_filter('kitify/logo/attr/src4l', 'miniture_kitify_logo_attr_src4l');
if(!function_exists('miniture_kitify_logo_attr_src4l')){
    function miniture_kitify_logo_attr_src4l( $src ){
        $nova_theme = nova_get_theme_options();
        if(!$src && $nova_theme){
	        $src = esc_url( $nova_theme['header_logo_light']['url'] );
        }
        return $src;
    }
}

add_filter('kitify/logo/attr/width', 'miniture_kitify_logo_attr_width');
if(!function_exists('miniture_kitify_logo_attr_width')){
    function miniture_kitify_logo_attr_width( $value ){
        if(!$value){
            $value = esc_html( nova_get_option('header_logo_width') );
        }
        return $value;
    }
}

add_action('elementor/frontend/widget/before_render', 'miniture_kitify_add_class_into_sidebar_widget');
if(!function_exists('miniture_kitify_add_class_into_sidebar_widget')){
    function miniture_kitify_add_class_into_sidebar_widget( $widget ){
        if('sidebar' == $widget->get_name()){
            $widget->add_render_attribute('_wrapper', 'class' , 'widget-area');
        }

    }
}
add_filter('kitify/nova-menu/control/style', 'miniture_kitify_add_nova_menu_style');
if(!function_exists('miniture_kitify_add_nova_menu_style')){
    function miniture_kitify_add_nova_menu_style(){
        return [
          'default' => esc_html__( 'Default', 'miniture' ),
          'top-line' => esc_html__( 'Top Line', 'miniture' ),
          'bottom-line' => esc_html__( 'Bottom Line', 'miniture' ),
        ];
    }
}
add_filter('kitify/nova-menu-cart/control/preset', 'miniture_kitify_add_nova_cart_style');
if(!function_exists('miniture_kitify_add_nova_cart_style')){
    function miniture_kitify_add_nova_cart_style(){
        return [
          'default' => esc_html__( 'Default', 'miniture' ),
        ];
    }
}
add_filter('kitify/banner/control/simple_style', 'miniture_kitify_add_simple_style');
if(!function_exists('miniture_kitify_add_simple_style')){
    function miniture_kitify_add_simple_style(){
        return [
          'none' => esc_html__( 'None', 'miniture' ),
          'cat' => esc_html__( 'Category', 'miniture' ),
        ];
    }
}

add_filter('kitify/banner-list/preset_overlay', 'miniture_kitify_banner_list_overlay_preset');
if(!function_exists('miniture_kitify_banner_list_overlay_preset')){
    function miniture_kitify_banner_list_overlay_preset(){
        return [
          'default' => esc_html__( 'Default', 'miniture' ),
          'pop-card' => esc_html__( 'Pop Card', 'miniture' ),
        ];
    }
}
add_filter('kitify/advanced_carousel/control/item_layout', 'miniture_kitify_add_advanced_carousel_item_layout');
if(!function_exists('miniture_kitify_add_advanced_carousel_item_layout')){
    function miniture_kitify_add_advanced_carousel_item_layout(){
        return [
          'banners'   => esc_html__( 'Banners', 'miniture' ),
          'simple'   => esc_html__( 'Simple', 'miniture' ),
          'category'   => esc_html__( 'Category', 'miniture' ),
        ];
    }
}

add_filter('kitify/products/control/grid_style', 'miniture_kitify_add_product_grid_style');
if(!function_exists('miniture_kitify_add_product_grid_style')){
    function miniture_kitify_add_product_grid_style(){
        return [
            '1' => esc_html__('Default', 'miniture'),
            '2' => esc_html__('Pop Card', 'miniture'),
        ];
    }
}

add_filter('kitify/products/control/list_style', 'miniture_kitify_add_product_list_style');
if(!function_exists('miniture_kitify_add_product_list_style')){
    function miniture_kitify_add_product_list_style(){
        return [
            '1' => esc_html__('Type 1', 'miniture'),
            'mini' => esc_html__('Mini', 'miniture'),
        ];
    }
}
add_filter('kitify/woo-categories/control/preset', 'miniture_kitify_add_woo_categories_style');
if(!function_exists('miniture_kitify_add_woo_categories_style')){
    function miniture_kitify_add_woo_categories_style(){
        return [
          'default' => esc_html__( 'Default', 'miniture' ),
          'miniture-01' => esc_html__( 'Miniture 01', 'miniture' ),
          'miniture-02' => esc_html__( 'Miniture 02', 'miniture' ),
          'miniture-03' => esc_html__( 'Miniture 03', 'miniture' ),
        ];
    }
}
add_filter('kitify/posts/control/preset', 'miniture_kitify_add_posts_preset');
if(!function_exists('miniture_kitify_add_posts_preset')){
    function miniture_kitify_add_posts_preset(){
        return [
          ' grid-1' => esc_html__( 'Grid 1', 'miniture' ),
            'grid-2' => esc_html__( 'Grid 2', 'miniture' ),
            'list-1' => esc_html__( 'List 1', 'miniture' ),
            'list-2' => esc_html__( 'List 2', 'miniture' ),
        ];
    }
}

add_filter('kitify/testimonials/control/preset', 'miniture_kitify_add_testimonials_preset');
if(!function_exists('miniture_kitify_add_testimonials_preset')){
    function miniture_kitify_add_testimonials_preset(){
        return [
          'type-1' => esc_html__( 'Default', 'miniture' ),
          'miniture-01' => esc_html__( 'Miniture 01', 'miniture' ),
          'miniture-02' => esc_html__( 'Miniture 02', 'miniture' ),
        ];
    }
}
add_filter('kitify/products/box_selector', 'miniture_kitify_product_change_box_selector');
if(!function_exists('miniture_kitify_product_change_box_selector')){
    function miniture_kitify_product_change_box_selector(){
        return '{{WRAPPER}} ul.products .product-item';
    }
}

add_filter('kitify/posts/format-icon', 'miniture_kitify_change_postformat_icon', 10, 2);
if(!function_exists('miniture_kitify_change_postformat_icon')){
    function miniture_kitify_change_postformat_icon( $icon, $type ){
        return $icon;
    }
}
add_filter('kitify/wootabs/layout/tabs_layout', 'miniture_kitify_tabs_layout');
if(!function_exists('miniture_kitify_tabs_layout')){
    function miniture_kitify_tabs_layout(){
        return [
            'default' => esc_html__('Default', 'miniture'),
            'tab_left' => esc_html__('Tabs left', 'miniture'),
            'accordion' => esc_html__('Accordion', 'miniture'),
        ];
    }
}
add_filter('kitify/banner/control/animation_effect', 'miniture_kitify_animation_effect');
if(!function_exists('miniture_kitify_animation_effect')){
    function miniture_kitify_animation_effect(){
        return [
            'none'   => esc_html__( 'None', 'miniture' ),
            'hidden-content'   => esc_html__( 'Hidden Content', 'miniture' ),
            'pop-card'   => esc_html__( 'Pop Card', 'miniture' ),
            'pop-card-2'   => esc_html__( 'Pop Card 2', 'miniture' ),
            'pop-card-3'   => esc_html__( 'Pop Card 3', 'miniture' ),
            'pop-card-4'   => esc_html__( 'Pop Card 4', 'miniture' ),
            'pop-card-5'   => esc_html__( 'Pop Card 5', 'miniture' )
        ];
    }
}
add_filter('kitify/team-member/control/preset', 'miniture_kitify_team_preset');
if(!function_exists('miniture_kitify_team_preset')){
    function miniture_kitify_team_preset(){
        return [
            'type-1' => esc_html__( 'Type 1', 'miniture' ),
            'type-2' => esc_html__( 'Type 2', 'miniture' ),
            'type-3' => esc_html__( 'Type 3', 'miniture' ),
            'type-4' => esc_html__( 'Type 4', 'miniture' ),
            'type-5' => esc_html__( 'Type 5', 'miniture' ),
            'pop-card' => esc_html__( 'Pop Card', 'miniture' ),
        ];
    }
}
// -----------------------------------------------------------------------------
// Elementor register breakpoint
// -----------------------------------------------------------------------------

if ( ! function_exists( 'miniture_register_breakpoint' ) ) :
function miniture_register_breakpoint(){
  if(defined('ELEMENTOR_VERSION')){
      $has_register_breakpoint = get_option('miniture_has_register_breakpoint', false);
      if(empty($has_register_breakpoint)){
          update_option('elementor_experiment-additional_custom_breakpoints', 'active');
          update_option('elementor_experiment-container', 'active');
          update_option('elementor_experiment-e_swiper_latest', 'inactive');
          $kit_active_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
          $raw_kit_settings = get_post_meta( $kit_active_id, '_elementor_page_settings', true );
          if(empty($raw_kit_settings)){
            $raw_kit_settings = [];
          }
          $default_settings = [
              'space_between_widgets' => '0',
              'page_title_selector' => 'h1.entry-title',
              'stretched_section_container' => '',
              'active_breakpoints' => [
                  'viewport_mobile',
                  'viewport_mobile_extra',
                  'viewport_tablet',
                  'viewport_tablet_extra',
                  'viewport_laptop',
              ],
              'viewport_mobile' => 767,
              'viewport_md' => 768,
              'viewport_mobile_extra' => 991,
              'viewport_tablet' => 1024,
              'viewport_tablet_extra' => 1279,
              'viewport_lg' => 1280,
              'viewport_laptop' => 1599,
              'system_colors' => [
                [
                  '_id' => 'primary',
                  'title' => esc_html__( 'Primary', 'miniture' )
                ],
                [
                  '_id' => 'secondary',
                  'title' => esc_html__( 'Secondary', 'miniture' )
                ],
                [
                  '_id' => 'text',
                  'title' => esc_html__( 'Text', 'miniture' )
                ],
                [
                  '_id' => 'accent',
                  'title' => esc_html__( 'Accent', 'miniture' )
                ]
              ],
              'system_typography' => [
                [
                  '_id' => 'primary',
                  'title' => esc_html__( 'Primary', 'miniture' )
                ],
                [
                  '_id' => 'secondary',
                  'title' => esc_html__( 'Secondary', 'miniture' )
                ],
                [
                  '_id' => 'text',
                  'title' => esc_html__( 'Text', 'miniture' )
                ],
                [
                  '_id' => 'accent',
                  'title' => esc_html__( 'Accent', 'miniture' )
                ]
              ]
          ];
          $raw_kit_settings = array_merge($raw_kit_settings, $default_settings);
          update_post_meta( $kit_active_id, '_elementor_page_settings', $raw_kit_settings );
          Elementor\Core\Breakpoints\Manager::compile_stylesheet_templates();
          update_option('miniture_has_register_breakpoint', true);
      }
  }
}
endif;
add_action( 'elementor/init', 'miniture_register_breakpoint' );

/**
 * Add support for Elementor Pro locations
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'miniture_register_elementor_locations' ) ) :
  function miniture_register_elementor_locations( $elementor_theme_manager ) {
      $elementor_theme_manager->register_all_core_location();
  }
endif;
// Add support for Elementor Pro locations
add_action( 'elementor/theme/register_locations', 'miniture_register_elementor_locations' );
