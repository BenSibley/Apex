<?php
/*
** Template Name: Full-width
*/
get_header(); ?>
<div id="loop-container" class="loop-container">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post(); ?>
			<div <?php post_class(); ?>>
				<?php do_action( 'page_before' ); ?>
				<article>
					<?php ct_apex_featured_image(); ?>
					<div class="post-container">
						<div class='post-header'>
							<h1 class='post-title'><?php the_title(); ?></h1>
						</div>
						<div class="post-content">
							<?php echo get_the_content(); ?>
							<?php wp_link_pages( array(
								'before' => '<p class="singular-pagination">' . __( 'Pages:', 'apex' ),
								'after'  => '</p>',
							) ); ?>
						</div>
					</div>
					<?php do_action( 'page_after' ); ?>
				</article>
				<?php comments_template(); ?>
			</div>
		<?php endwhile;
	endif; ?>
</div>
<?php get_footer();