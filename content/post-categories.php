<?php

$categories = get_the_category( $post->ID );
$separator  = ', ';
$output     = '';

if ( $categories ) {

	echo '<p class="post-categories">';
		echo '<span>' . _x( "Published in", "Published in post category", "apex" ) . ' </span>';
		foreach ( $categories as $category ) {
			// if it's the last and not the first (only) category, pre-prend with "and"
			if ( $category === end( $categories ) && $category !== reset( $categories ) ) {
				$output = rtrim( $output, ", " ); // remove trailing comma
				$output .= ' ' . __( 'and', 'apex' )  . ' ';
			}
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( _x( 'View all posts in %s', 'View all posts in post category',  'apex' ), $category->name ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $separator;
		}
		echo trim( $output, $separator );
	echo "</p>";
}