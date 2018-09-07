<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.ourlocalpharmacy.com/
 * @since             1.5.0
 * @package           Nhs_Api
 *
 * @wordpress-plugin
 * Plugin Name:       NHS-API
 * Plugin URI:        https://www.thepharmacywebsitecompany.co.uk
 * Description:       NHS Conditions and Treatments API feed.
 * Version:           2.0.0
 * Author:            OurLocalPharmacy.com Ltd
 * Author URI:        http://www.ourlocalpharmacy.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nhs-api
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '2.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nhs-api-activator.php
 */
function activate_nhs_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nhs-api-activator.php';
	Nhs_Api_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nhs-api-deactivator.php
 */
function deactivate_nhs_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nhs-api-deactivator.php';
	Nhs_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nhs_api' );
register_deactivation_hook( __FILE__, 'deactivate_nhs_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nhs-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nhs_api() {

	$plugin = new Nhs_Api();
	$plugin->run();

}
//include_once 'nhs-menu.php';
run_nhs_api();


 if ( is_admin() ){ // admin actions
//  add_action( 'admin_menu', 'add_mymenu' );
add_action('admin_menu', 'my_cool_plugin_create_menu');

  add_action( 'admin_init', 'register_mysettings' );
} else {
  // non-admin enqueues, actions, and filters
}

function register_mysettings() { // whitelist options
  register_setting( 'myoption-group', 'nhs_api_key' );
//  register_setting( 'myoption-group', 'some_other_option' );
//  register_setting( 'myoption-group', 'option_etc' );
}
//  add_menu_page('My Cool Plugin Settings', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page', get_stylesheet_directory_uri('stylesheet_directory')."/images/media-button-other.gif");

	function my_cool_plugin_create_menu() {

		//create new top-level menu
		//add_menu_page('NHS API Settings', 'NHS Settings', 'administrator', __FILE__.'/nhs-api.php', 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );
		add_menu_page('NHS API Settings', 'NHS Settings', 'administrator', __FILE__.'/nhs-api.php', 'my_cool_plugin_settings_page' , 'dashicons-admin-settings' );

		//call register settings function
		add_action( 'admin_init', 'register_my_cool_plugin_settings' );
	}


	function register_my_cool_plugin_settings() {
		//register our settings
		register_setting( 'nhs-api-settings-group', 'nhs_api_key' );
		//register_setting( 'nhs-api-settings-group', 'some_other_option' );
		//register_setting( 'nhs-api-settings-group', 'option_etc' );
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
 	    </table>

	    <?php submit_button(); ?>

	</form>
	</div>
<?php }
if(!empty(get_option('nhs_api_key'))){
	define('NHS_API_KEY',get_option('nhs_api_key'));
}

// include 'nhs-template.php';

if ( !function_exists('is_user_logged_in') ) :
/**
 * Checks if the current visitor is a logged in user.
 *
 * @since 2.0.0
 *
 * @return bool True if user is logged in, false if not logged in.
 */
function is_user_logged_in() {
	$uid = get_current_user_id();

	if ( empty( $uid ) )
		return false;

	return true;
}
endif;


$my_post = array(
  'post_title'    => wp_strip_all_tags('Health A to Z'),
	'post_name'       => 'health-atoz',
   'post_status'   => 'publish',
	 'post_type' => 'page',
	 'page_template'=> 'nhs-template.php',
	 'post_author'=> 1,
	 'post_status'=>'publish'
);

// Insert the post into the database
$page = get_page_by_title( 'Health A to Z' );
if(empty($page))
{
	wp_insert_post( $my_post );

}
// Add second page

$my_post = array(
  'post_title'    => wp_strip_all_tags('Article'),
	'post_name'       => 'Article',
   'post_status'   => 'publish',
	 'post_type' => 'page',
	 'page_template'=> 'nhs-article.php',
	 'post_author'=> 1,
	 'post_status'=>'publish'
);

// Insert the post into the database
$page = get_page_by_title( 'article' );
if(empty($page))
{
	wp_insert_post( $my_post );

}

// Assign template to two newly created page
add_filter( 'page_template', 'health_atoz_page_template' );
function health_atoz_page_template( $page_template )
{
    if ( is_page( 'health-atoz' ) ) {
        $page_template = dirname( __FILE__ ) . '/nhs-home.php';
    }
    return $page_template;
}
add_filter( 'page_template', 'article_page_template' );
function article_page_template( $page_template )
{
    if ( is_page( 'article' ) ) {
        $page_template = dirname( __FILE__ ) . '/nhs-article.php';
    }
    return $page_template;
}

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://github.com/easyway7/nhs-api',
		__FILE__,
		'NHS-API'
		);
?>
