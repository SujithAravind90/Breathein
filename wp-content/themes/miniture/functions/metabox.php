<?php
if ( !function_exists( 'nova_add_custom_product_metabox') ) :
function nova_add_custom_product_metabox( $meta_boxes ) {
    $prefix = 'miniture_';
    $theme_meta_boxes = array();
    if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {
    $theme_meta_boxes[] = [
        'title'      => esc_html__( 'Header Image', 'miniture' ),
        'id'         => 'header-image',
        'post_types' => ['product'],
        'context'    => 'normal',
        'priority'   => 'high',
        'fields'     => [
            [
                'type'             => 'image',
                'id'               => $prefix.'product_page_header_image',
                'max_file_uploads' => 1,
            ],
        ],
    ];
  }
  $theme_meta_boxes[] = [
      'title'      => esc_html__( 'For post format QUOTE', 'miniture' ),
      'id'         => 'format_quote',
      'post_types' => ['post'],
      'context'    => 'normal',
      'priority'   => 'high',
      'fields'     => [
          [
              'type' => 'textarea',
              'name' => esc_html__( 'Quote Content', 'miniture' ),
              'id'   => $prefix.'post_quote_content',
          ],
          [
              'type' => 'text',
              'id'   => $prefix . 'post_quote_author',
              'name' => esc_html__( 'Author', 'miniture' ),
          ],
          [
              'type' => 'color',
              'id'   => $prefix . 'post_quote_text_color',
              'name' => esc_html__( 'Text Color', 'miniture' ),
              'std'  => '#000',
          ],
          [
              'type' => 'color',
              'id'   => $prefix . 'post_quote_bg_color',
              'name' => esc_html__( 'Background Color', 'miniture' ),
              'std'  => '#FFF',
          ],
      ],
  ];
  $theme_meta_boxes[] = [
      'title'      => esc_html__( 'For post format VIDEO', 'miniture' ),
      'id'         => 'format_video',
      'post_types' => ['post'],
      'context'    => 'normal',
      'priority'   => 'high',
      'fields'     => [

          [
              'type' => 'text',
              'id'   => $prefix . 'post_video_url',
              'name' => esc_html__( 'Youtube/Vimeo Video Url', 'miniture' ),
          ],
      ],
  ];
  $meta_boxes = apply_filters('miniture/metabox/meta_boxes',$theme_meta_boxes);
  return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'nova_add_custom_product_metabox' );
endif;
