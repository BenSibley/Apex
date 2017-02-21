<?php

if ( is_home() ) {
	echo '<h1 class="screen-reader-text">' . esc_html( get_bloginfo("name") ) . ' ' . _x('Posts', 'noun: Site Title\'s Posts', 'apex') . '</h1>';
}
if ( ! is_archive() ) {
	return;
}
?>

<div class='archive-header'>
	<h1>
		<?php the_archive_title(); ?>
	</h1>
	<?php the_archive_description(); ?>
</div>