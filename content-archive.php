<div <?php post_class(); ?>>
	<?php do_action( 'archive_post_before' ); ?>
	<article>
		<?php ct_apex_featured_image(); ?>
		<div class="post-container">
			<div class='post-header'>
				<?php do_action( 'sticky_post_status' ); ?>
				<h2 class='post-title'>
					<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<span class="post-date">
					<?php
					$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date('r') ) );
					printf( __( 'Published %s', 'apex' ), $date );
					?>
				</span>
			</div>
			<div class="post-content">
				<?php ct_apex_excerpt(); ?>
				<?php get_template_part('content/comments-link'); ?>
			</div>
		</div>
	</article>
	<?php do_action( 'archive_post_after' ); ?>
</div>