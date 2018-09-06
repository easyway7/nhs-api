<?php
if ( is_admin() ){ // admin actions
//  add_action( 'admin_menu', 'add_mymenu' );
  add_action( 'admin_init', 'register_mysettings' );
} else {
  // non-admin enqueues, actions, and filters
}

function register_mysettings() { // whitelist options
  register_setting( 'myoption-group', 'new_option_name' );
  register_setting( 'myoption-group', 'some_other_option' );
  register_setting( 'myoption-group', 'option_etc' );
}
//  add_menu_page('My Cool Plugin Settings', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page', get_stylesheet_directory_uri('stylesheet_directory')."/images/media-button-other.gif");
	add_action('admin_menu', 'my_cool_plugin_create_menu');

	function my_cool_plugin_create_menu() {

		//create new top-level menu
		add_menu_page('NHS API Settings', 'NHS Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );

		//call register settings function
		add_action( 'admin_init', 'register_my_cool_plugin_settings' );
	}


	function register_my_cool_plugin_settings() {
		//register our settings
		register_setting( 'nhs-api-settings-group', 'new_option_name' );
		register_setting( 'nhs-api-settings-group', 'some_other_option' );
		register_setting( 'nhs-api-settings-group', 'option_etc' );
	}

	function my_cool_plugin_settings_page() {
	?>
	<div class="wrap">
	<h1>NHS API</h1>

	<form method="post" action="options.php">
	    <?php settings_fields( 'nhs-api-settings-group' ); ?>
	    <?php do_settings_sections( 'nhs-api-settings-group' ); ?>
	    <table class="form-table">
	        <tr valign="top">
	        <th scope="row">NHS API Key</th>
	        <td><input type="text" name="nhs_api_key" value="<?php echo esc_attr( get_option('nhs_api_key') ); ?>" /></td>
	        </tr>

	        <tr valign="top">
	        <th scope="row">Some Other Option</th>
	        <td><input type="text" name="some_other_option" value="<?php echo esc_attr( get_option('some_other_option') ); ?>" /></td>
	        </tr>

	        <tr valign="top">
	        <th scope="row">Options, Etc.</th>
	        <td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('option_etc') ); ?>" /></td>
	        </tr>
	    </table>

	    <?php submit_button(); ?>

	</form>
	</div>
<?php }

?>
