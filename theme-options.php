<?php

/* create theme options page */
function ct_apex_register_theme_page(){
	add_theme_page( 'Apex Dashboard', 'Apex Dashboard', 'edit_theme_options', 'apex-options', 'ct_apex_options_content', 'ct_apex_options_content');
}
add_action( 'admin_menu', 'ct_apex_register_theme_page' );

/* callback used to add content to options page */
function ct_apex_options_content(){

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => admin_url('themes.php?page=apex-options')
		),
		admin_url('customize.php')
	);

	?>
	<div id="apex-dashboard-wrap" class="wrap">
		<h2><?php _e('Apex Dashboard', 'apex'); ?></h2>
		<?php hybrid_do_atomic( 'theme_options_before' ); ?>
		<div class="content content-customization">
			<h3><?php _e('Customization', 'apex'); ?></h3>
			<p><?php _e('Click the "Customize" link in your menu, or use the button below to get started customizing Apex', 'apex'); ?>.</p>
			<p>
				<a class="button-primary" href="<?php echo esc_url( $customizer_url ); ?>"><?php _e('Use Customizer', 'apex') ?></a>
			</p>
		</div>
		<div class="content content-support">
			<h3><?php _e('Support', 'apex'); ?></h3>
			<p><?php _e("You can find the knowledgebase, changelog, support forum, and more in the Apex Support Center", "apex"); ?>.</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/documentation/apex-support-center/"><?php _e('Visit Support Center', 'apex'); ?></a>
			</p>
		</div>
		<div class="content content-premium-upgrade">
			<h3><?php _e('Get More Features & Flexibility', 'apex'); ?></h3>
			<p><?php _e('Download the Apex Pro plugin and unlock custom colors, new layouts, a flexible header image, and more', 'apex'); ?>...</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/apex-pro/"><?php _e('See Full Feature List', 'apex'); ?></a>
			</p>
		</div>
		<div class="content content-resources">
			<h3><?php _e('WordPress Resources', 'apex'); ?></h3>
			<p><?php _e('Save time and money searching for WordPress products by following our recommendations', 'apex'); ?>.</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/wordpress-resources/"><?php _e('View Resources', 'apex'); ?></a>
			</p>
		</div>
		<div class="content content-delete-settings">
			<h3><?php _e('Reset Customizer Settings', 'apex'); ?></h3>
			<p>
				<?php
				printf( __( '<strong>Warning:</strong> Clicking this button will erase your current settings in the <a href="%s">Customizer</a>', 'apex' ), esc_url( $customizer_url ) );
				?>
			</p>
			<form method="post">
				<input type="hidden" name="apex_reset_customizer" value="apex_reset_customizer_settings" />
				<p>
					<?php wp_nonce_field( 'apex_reset_customizer_nonce', 'apex_reset_customizer_nonce' ); ?>
					<?php submit_button( __( 'Reset Customizer Settings', 'apex' ), 'delete', 'delete', false ); ?>
				</p>
			</form>
		</div>
		<?php hybrid_do_atomic( 'theme_options_after' ); ?>
	</div>
<?php } ?>
