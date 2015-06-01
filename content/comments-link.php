<span class="comments-link">
	<i class="fa fa-comment" title="<?php _e('comment icon', 'apex'); ?>"></i>
	<?php
	if( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( __( 'Comments closed', 'apex' ), __( '1 Comment', 'apex'), __( '% Comments', 'apex' ) );
	else :
		echo '<a href="' . get_comments_link() . '">';
			comments_number( __( 'Leave a Comment', 'apex' ), __( '1 Comment', 'apex'), __( '% Comments', 'apex' ) );
		echo '</a>';
	endif;
	?>
</span>