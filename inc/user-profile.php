<?php

// add profile image option for contributors roles and higher
function ct_apex_user_profile_image_setting( $user ) {

	// get user ID
	$user_id = get_current_user_id();

	// abort if user not contributor or higher
	if ( ! current_user_can( 'edit_posts', $user_id ) ) return false;
	?>
	<table id="profile-image-table" class="form-table">
		<tr>
			<th><label for="apex_user_profile_image"><?php _e( 'Profile image', 'apex' ); ?></label></th>
			<td>
				<!-- Outputs the image after save -->
				<img id="image-preview" src="<?php echo esc_url( get_the_author_meta( 'apex_user_profile_image', $user->ID ) ); ?>" style="width:100px;"><br />
				<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
				<input type="text" name="apex_user_profile_image" id="apex_user_profile_image" value="<?php echo esc_url( get_the_author_meta( 'apex_user_profile_image', $user->ID ) ); ?>" class="regular-text" />
				<!-- Outputs the save button -->
				<input type='button' id="apex-user-profile-upload" class="button-primary" value="<?php _e( 'Upload Image', 'apex' ); ?>"/><br />
				<span class="description"><?php _e( 'Upload an image here to use instead of your Gravatar.', 'apex' ); ?></span>
			</td>
		</tr>
	</table><!-- end form-table -->
<?php } // additional_user_fields
add_action( 'show_user_profile', 'ct_apex_user_profile_image_setting' );
add_action( 'edit_user_profile', 'ct_apex_user_profile_image_setting' );

/**
 * Saves additional user fields to the database
 */
function ct_apex_save_user_profile_image( $user_id ) {

	// only saves if the current user can edit current user profile
	if ( ! current_user_can( 'edit_user', $user_id ) ) return false;

	update_user_meta( $user_id, 'apex_user_profile_image', esc_url_raw( $_POST['apex_user_profile_image'] ) );
}

add_action( 'personal_options_update', 'ct_apex_save_user_profile_image' );
add_action( 'edit_user_profile_update', 'ct_apex_save_user_profile_image' );