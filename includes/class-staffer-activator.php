<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpnook.com
 * @since      1.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Staffer
 * @subpackage Staffer/includes
 * @author     Edward Jenkins <edward@wpnook.com>
 */
class Staffer_Activator {

	/**
	 * Creates the staff post type and flushes the permalinks.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staffer-setup.php';
		// Staffer_Setup::create_staff_cpt();
		// flush rewrite rules to prevent initial 404s
		flush_rewrite_rules();
	}

}
