<?php

defined('ABSPATH') || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('antialiased text-gray-900 selection:bg-brandTeal/20 relative'); ?>>
<?php wp_body_open(); ?>

<?php
get_template_part(
    'template-parts/includes/header-main'
);
?>
