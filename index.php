<?php get_header();

get_template_part('content/archive-header');

?>

<div id="loop-container" class="loop-container">
    <?php
    if ( have_posts() ) :
        while (have_posts() ) :
            the_post();
            ct_apex_get_content_template();
        endwhile;
    endif;
    ?>
</div>

<?php echo ct_apex_loop_pagination(); ?>

<?php get_footer(); ?>