<?php

/**
 * The main template file.
 *
 * This is the fallback template used by WordPress when no
 * more-specific template (e.g. front-page.php, page.php)
 * matches the current request.
 *
 * @package Breathein
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="homepage-wrapper">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>

<?php get_footer(); ?>
