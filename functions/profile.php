<?php
// adding custom fields to WP user profile
function user_profiles( $contactmethods ) {
    //add Job title
    $contactmethods['user_job_title'] = 'Job title';
    // Add website title
    // $contactmethods['user_website_title'] = 'Website title';
    // Add IRC
    $contactmethods['user_launchpad'] = 'Launchpad Username';
    // Add Google profile
    $contactmethods['user_google'] = 'Google+ URL';
    // Add Twitter
    $contactmethods['user_twitter'] = 'Twitter ID';
    //add Facebook
    $contactmethods['user_facebook'] = 'Facebook Profile URL';
    //add image id
    $contactmethods['user_photo'] = 'Profile photo';
    //add location
    $contactmethods['location'] = 'Location (Indicate your city and country. Eg. London, United Kingdom)';
    //add user image
    //$contactmethods['user_photo'] = 'User photo';

    return $contactmethods;
    }
    add_filter('user_contactmethods','user_profiles',10,1);

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

add_action( 'register_form', 'ts_show_extra_register_fields' );

/**
  * updated - 21 March 2018
  * add custom user fields to the user to rest api
  * /wp-json/wp/v2/users?_embed=True ...
**/
add_action( 'rest_api_init', 'user_register_fields' );
function user_register_fields() {
    foreach( array (
    'user_job_title',
    'user_website_title',
    'user_google',
    'user_twitter',
    'user_facebook',
    'user_photo',
    'user_location'
    ) as $field ) {
        register_rest_field( 'user',
            $field,
            array(
                'get_callback'    => 'user_get_contact_data',
                'update_callback' => null,
                'schema'          => null,
              )
            );
          }
        }
function user_get_contact_data( $user, $field_name, $request ) {
  return get_user_meta( $user['id'], $field_name, true );
}



function my_show_extra_profile_fields( $user ) { ?>
<h3>Extra profile information</h3>
<table class="form-table">
	<tr>
		<th><label for="displayonteam">Display (display user on About page)</label></th>
		<td>
			<input type="checkbox" name="displayonteam" id="displayonteam" value="1" <?php if(get_the_author_meta( 'displayonteam', $user->ID )=='1')echo 'checked="checked"'; ?>class="regular-text" />
		</td>
	</tr>
	<!--<tr>
		<th><label for="guestblogger">Guest Blogger</label></th>
		<td>
			<input type="checkbox" name="guestblogger" id="guestblogger" value="1" <?php if(get_the_author_meta( 'guestblogger', $user->ID )=='1')echo 'checked="checked"'; ?>class="regular-text" />
		</td>
	</tr>-->
</table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	if(current_user_can('edit_posts', $user_id ))
		update_user_meta( $user_id, 'displayonteam', isset( $_POST['displayonteam'] ) ? sanitize_text_field( $_POST['displayonteam'] ) : '' );
	update_user_meta( $user_id, 'guestblogger', isset( $_POST['guestblogger'] ) ? sanitize_text_field( $_POST['guestblogger'] ) : '' );
}
// end of adding custom fields to WP user profile

// removing WP user profile fields
add_filter( 'user_contactmethods', 'custom_user_contactmethods' );
function custom_user_contactmethods( $user ) {
        $user_contactmethods = array(
                'aim',
                'yim',
                'jabber'
        );

        foreach ( $user_contactmethods as $user_contactmethod ) {
                unset( $user[$user_contactmethod] );
        }

        return $user;
}
// end removing WP user profile fields

// remove user bio html filtering
remove_filter('pre_user_description', 'wp_filter_kses');
// end remove user bio html filtering

?>
