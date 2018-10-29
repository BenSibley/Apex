<?php if ( get_theme_mod( 'comments_link' ) == 'no' ) {
	return;
}
?>
<span class="comments-link">
	<i class="fas fa-comment" title="<?php esc_attr_e( 'comment icon', 'apex' ); ?>" aria-hidden="true"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( esc_html__( 'Comments closed', 'apex' ), esc_html__( '1 Comment', 'apex' ), esc_html_x( '% Comments', 'noun: 5 comments', 'apex' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( esc_html__( 'Leave a Comment', 'apex' ), esc_html__( '1 Comment', 'apex' ), esc_html_x( '% Comments', 'noun: 5 comments', 'apex' ) );
		echo '</a>';
	endif;
	?>
</span>