<div <?php post_class(); ?>>
	<?php hybrid_do_atomic( 'page_before' ); ?>
	<article>
		<?php ct_apex_featured_image(); ?>
		<div class="post-container">
			<div class='post-header'>
				<h2 class='post-title'><?php the_title(); ?></h2>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p class="singular-pagination">' . __('Pages:','apex'), 'after' => '</p>', ) ); ?>
			</div>
		</div>
		<?php hybrid_do_atomic( 'page_after' ); ?>
	</article>
	<?php comments_template(); ?>
</div>