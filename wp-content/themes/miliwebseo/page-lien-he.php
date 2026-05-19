<?php
/**
 * The template for displaying the contact page (slug: lien-he)
 *
 * @package Miliwebseo
 */

get_header();
?>

<?php
while ( have_posts() ) :
    the_post();
    the_content();
endwhile;
?>

<?php
get_footer();
