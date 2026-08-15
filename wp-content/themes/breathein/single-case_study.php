<?php
/**
 * Single Case Study template.
 *
 * WordPress only loads a single CPT template from the theme root. The
 * designed markup lives in template-parts/single-case_study.php, so this
 * file connects the registered case_study post type to that view.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

get_template_part('template-parts/single-case_study');
