<div <?php post_class(); ?>>
	<?php hybrid_do_atomic( 'post_before' ); ?>
	<article>
	    <?php ct_apex_featured_image(); ?>
	    <div class="post-container">
		    <div class='post-header'>
		        <h2 class='post-title'><?php the_title(); ?></h2>
			    <span class="post-date">
					<?php
					$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date('r') ) );
					printf( __( 'Published %s', 'apex' ), $date );
					?>
				</span>
		    </div>
		    <div class="post-content">
		        <?php the_content(); ?>
		        <?php wp_link_pages(array('before' => '<p class="singular-pagination">' . __('Pages:','apex'), 'after' => '</p>', ) ); ?>
		    </div>
		    <?php hybrid_do_atomic( 'post_after' ); ?>
		    <div class="post-meta">
			    <?php get_template_part('content/post-categories'); ?>
			    <?php get_template_part('content/post-tags'); ?>
			    <?php get_template_part('content/post-nav'); ?>
		    </div>
	    </div>
	</article>
	<?php comments_template(); ?>
</div>