<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codewrangler.io
 * @since             2.0.0
 * @package           Staffer
 *
 * @wordpress-plugin
 * Plugin Name:       Staffer
 * Plugin URI:        https://wordpress.org/plugins/staffer/
 * Description:       Staff profile management for WordPress
 * Version:           2.1.0
 * Author:            codeWrangler, Inc.
 * Author URI:        https://codewrangler.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       staffer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-staffer-activator.php
 */
function activate_staffer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-staffer-activator.php';
	Staffer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-staffer-deactivator.php
 */
function deactivate_staffer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-staffer-deactivator.php';
	Staffer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_staffer' );
register_deactivation_hook( __FILE__, 'deactivate_staffer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-staffer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_staffer() {

	$plugin = new Staffer();
	$plugin->run();

}
run_staffer();
