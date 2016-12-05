<?php

function ct_apex_register_theme_page() {
	add_theme_page( __( 'Apex Dashboard', 'apex' ), __( 'Apex Dashboard', 'apex' ), 'edit_theme_options', 'apex-options', 'ct_apex_options_content', 'ct_apex_options_content' );
}
add_action( 'admin_menu', 'ct_apex_register_theme_page' );

function ct_apex_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => add_query_arg( 'page', 'apex-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$support_url = 'https://www.competethemes.com/documentation/apex-support-center/';
	?>
	<div id="apex-dashboard-wrap" class="wrap">
		<h2><?php _e( 'Apex Dashboard', 'apex' ); ?></h2>
		<?php do_action( 'theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php _e( 'Get Started', 'apex' ); ?></h3>
				<p><?php _e( "Not sure where to start? The <strong>Apex Getting Started Guide</strong> will take you step-by-step through every feature in Apex.", "apex" ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/help/getting-started-apex/"><?php _e( 'View Guide', 'apex' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_apex_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php _e( 'Apex Pro', 'apex' ); ?></h3>
					<p><?php _e( 'Download the Apex Pro plugin and unlock custom colors, new layouts, a flexible header image, and more', 'apex' ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/apex-pro/"><?php _e( 'See Full Feature List', 'apex' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php _e( 'Leave a Review', 'apex' ); ?></h3>
				<p><?php _e( 'Help others find Apex by leaving a review on wordpress.org.', 'apex' ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/apex/reviews/"><?php _e( 'Leave a Review', 'apex' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php _e( 'Reset Customizer Settings', 'apex' ); ?></h3>
				<p>
					<?php
					printf( __( "<strong>Warning:</strong> Clicking this button will erase the Apex theme's current settings in the <a href='%s'>Customizer</a>.", 'apex' ), esc_url( $customizer_url ) );
					?>
				</p>
				<form method="post">
					<input type="hidden" name="apex_reset_customizer" value="apex_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'apex_reset_customizer_nonce', 'apex_reset_customizer_nonce' ); ?>
						<?php submit_button( __( 'Reset Customizer Settings', 'apex' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'theme_options_after' ); ?>
	</div>
<?php }