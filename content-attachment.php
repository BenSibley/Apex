<div <?php post_class(); ?>>
	<?php hybrid_do_atomic( 'attachment_before' ); ?>
	<article>
		<div class="post-container">
			<div class='post-header'>
				<h2 class='post-title'><?php the_title(); ?></h2>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
			</div>
			<?php get_template_part('content/post-nav-attachment'); ?>
		</div>
	</article>
	<?php hybrid_do_atomic( 'attachment_after' ); ?>
	<?php comments_template(); ?>
</div>