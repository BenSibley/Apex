<?php if ( get_theme_mod( 'comments_link' ) == 'no' ) {
	return;
}
?>
<span class="comments-link">
	<i class="fa fa-comment" title="<?php esc_attr_e( 'comment icon', 'apex' ); ?>" aria-hidden="true"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( __( 'Comments closed', 'apex' ), __( '1 Comment', 'apex' ), _x( '% Comments', 'noun: 5 comments', 'apex' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( __( 'Leave a Comment', 'apex' ), __( '1 Comment', 'apex' ), _x( '% Comments', 'noun: 5 comments', 'apex' ) );
		echo '</a>';
	endif;
	?>
</span>