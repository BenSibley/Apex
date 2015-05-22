<div id="post-meta" class="post-meta">
	<div class="post-date">
		<i class="fa fa-calendar"></i>
		<a href="<?php echo get_month_link( get_the_date('Y'), get_the_date('n') ); ?>">
			<?php echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date( 'n/j/Y g:i a' ) ) ); ?>
		</a>
	</div>
	<div class="post-author">
		<i class="fa fa-user"></i>
		<?php the_author_posts_link(); ?>
	</div>
	<div class="post-comments">
		<i class="fa fa-comment"></i>
		<?php
		if( ! comments_open() && get_comments_number() < 1 ) :
			comments_number( __( 'Comments closed', 'apex' ), __( 'One Comment', 'apex'), __( '% Comments', 'apex' ) );
		else :
			echo '<a href="' . get_comments_link() . '">';
				comments_number( __( 'Leave a Comment', 'apex' ), __( 'One Comment', 'apex'), __( '% Comments', 'apex' ) );
			echo '</a>';
		endif;
		?>
	</div>
</div>