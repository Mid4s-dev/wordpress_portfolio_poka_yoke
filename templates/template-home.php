<?php
/**
 * Template Name: Portfolio Home
 * Template Post Type: page
 *
 * @package Portfolio
 */

get_header();
?>

<!-- Hero Section -->
<?php get_template_part( 'patterns/portfolio', 'hero' ); ?>

<!-- Services Section -->
<?php get_template_part( 'patterns/portfolio', 'services' ); ?>

<!-- Projects Section -->
<?php get_template_part( 'patterns/portfolio', 'projects' ); ?>

<!-- Contact Section -->
<?php get_template_part( 'patterns/portfolio', 'contact' ); ?>

<?php
get_footer();
