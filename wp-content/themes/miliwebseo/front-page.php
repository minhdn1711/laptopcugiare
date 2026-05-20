<?php get_header(); ?>
<main class="container mx-auto px-4 min-h-[70vh] pb-12 pt-6">
    <?php 
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            the_content();
        }
    }
    ?>
</main>
<?php get_footer(); ?>
