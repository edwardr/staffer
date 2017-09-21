<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpnook.com
 * @since      1.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Staffer
 * @subpackage Staffer/admin
 * @author     Edward Jenkins <edward@wpnook.com>
 */
class Staffer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Staffer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Staffer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/staffer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Staffer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Staffer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/staffer-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adds a link to the main staff archive.
	 *
	 * Too many people confused about accessing the page.
	 * Adds nothing if manual mode is enabled.
	 * @since 1.0.0
	 */
	public function staff_admin_menu_link() {

		$options = get_option ('staffer');
		if ( isset( $options['manual_mode'] ) ) {
			return;
		} else {
			global $submenu;
			$base_url = home_url('/');

			if ( $options['slug'] == '' ) {
				$slug = 'staff';
			} else {
				$slug = $options['slug'];
			}

			if ( get_option ('permalink_structure') ) {
				$url = $base_url . $slug;
			} else {
				$url = $base_url . '?post_type=staff';
			}

			$submenu['edit.php?post_type=staff'][] = array( __('View Staff Page', 'staffer'), 'manage_options', $url );

		}
	}

}
