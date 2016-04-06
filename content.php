<div <?php post_class(); ?>>
	<?php do_action( 'post_before' ); ?>
	<article>
		<?php ct_apex_featured_image(); ?>
		<div class="post-container">
			<div class='post-header'>
				<h1 class='post-title'><?php the_title(); ?></h1>
				<?php get_template_part( 'content/post-byline' ); ?>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array(
					'before' => '<p class="singular-pagination">' . __( 'Pages:', 'apex' ),
					'after'  => '</p>',
				) ); ?>
			</div>
			<?php do_action( 'post_after' ); ?>
			<div class="post-meta">
				<?php get_template_part( 'content/post-categories' ); ?>
				<?php get_template_part( 'content/post-tags' ); ?>
				<?php get_template_part( 'content/post-nav' ); ?>
			</div>
		</div>
	</article>
	<?php comments_template(); ?>
</div>