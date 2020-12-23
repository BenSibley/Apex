<?php get_header(); ?>
	<div class="entry">
		<article>
			<div class="post-container">
				<div class='post-header'>
					<h1 class='post-title'><?php esc_html_e( '404: Page Not Found', 'apex' ); ?></h1>
				</div>
				<div class="post-content">
					<?php esc_html_e( 'Looks like nothing was found on this url.  Double-check that the url is correct or try the search form below to find what you were looking for.', 'apex' ); ?>
				</div>
				<?php get_search_form(); ?>
			</div>
		</article>
	</div>
<?php get_footer(); ?>