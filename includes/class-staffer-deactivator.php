<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wpnook.com
 * @since      1.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Staffer
 * @subpackage Staffer/includes
 * @author     Edward Jenkins <edward@wpnook.com>
 */
class Staffer_Deactivator {

	/**
	 * Flush permalinks and handle database
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
