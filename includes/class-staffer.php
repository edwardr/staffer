<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://codewrangler.io
 * @since      2.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    Staffer
 * @subpackage Staffer/includes
 * @author     codeWrangler, Inc. <edward@codewrangler.io>
 */
class Staffer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      Staffer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'staffer';
		$this->version = '2.1.0';
		$this->plugin_path = plugins_url('/staffer');

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->get_options();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Staffer_Loader. Orchestrates the hooks of the plugin.
	 * - Staffer_i18n. Defines internationalization functionality.
	 * - Staffer_Admin. Defines all hooks for the admin area.
	 * - Staffer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staffer-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staffer-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-staffer-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-staffer-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staff.php';

		$this->loader = new Staffer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Staffer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Staffer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Staffer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_boxes' );
		$this->loader->add_action( 'save_post_staff', $plugin_admin, 'save_staffer_meta' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'staffer_admin_menu' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'staffer_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Staffer_Public( $this->get_plugin_name(), $this->get_version() );

		$options = $this->get_options();

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'register_taxonomies' );
		$this->loader->add_action( 'init', $plugin_public, 'register_post_types' );
		$this->loader->add_action( 'after_setup_theme', $plugin_public, 'staffer_thumbnail_check' );

		$this->loader->add_filter( 'the_content', $plugin_public, 'staff_main_page_content' );

		$this->loader->add_shortcode( 'staffer', $plugin_public, 'staffer_shortcode' );

		$this->loader->add_filter( 'body_class', $plugin_public, 'staffer_body_class' );


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 * @return    Staffer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Normalize the options to deal with legacy DB settings
	 * @since     2.0.0
	 * @return  array   Options array
	 */

	public function get_options() {

		$options = get_option('staffer');

		$disable_css = isset( $options['disablecss'] )&& !empty( $options['disablecss'] ) ? true : false;
		$label = isset( $options['label'] ) && !empty( $options['label'] ) ?
			$options['label'] : __('Staff', 'staffer');
		$use_custom_wrapper = isset( $options['customwrapper'] ) && !empty( $options['customwrapper'] ) ? true : false;
		$custom_start_wrapper = isset( $options['startwrapper'] ) ? $options['startwrapper'] : '';
		$custom_end_wrapper = isset( $options['endwrapper'] ) ? $options['endwrapper'] : '';
		$layout = isset( $options['gridlayout'] ) && !empty( $options['gridlayout'] ) ? 'grid' : 'list';
		$manual_mode = isset( $options['manual_mode'] ) && !empty( $options['manual_mode'] ) ? true : false;
		$excerpt_style = isset( $options['estyle'] ) && !empty( $options['estyle'] ) ? $options['estyle'] : 'excerpt';
		$staff_per_page = isset( $options['perpage'] ) && !empty( $options['perpage'] ) ? $options['perpage'] : 10;
		$staffer_slug = isset( $options['slug'] ) && !empty( $options['slug'] ) ? $options['slug'] : __('staff', 'staffer' );
		$page_title = isset( $options['ptitle'] ) && !empty( $options['ptitle'] ) ? $options['ptitle'] : __('Staff', 'staffer' );
		$page_description = isset( $options['sdesc'] ) ? $options['sdesc'] : '';
		$custom_css = isset( $options['customcss'] ) && !empty( $options['customcss'] ) ? $options['customcss'] : false;
		$main_page_id = isset( $options['main_page_id'] ) && !empty( $options['main_page_id'] ) ? $options['main_page_id'] : false;

		$normalize_options = array(
			'disable_css'          => $disable_css,
			'label'                => $label,
			'use_custom_wrapper'   => $use_custom_wrapper,
			'custom_start_wrapper' => $custom_start_wrapper,
			'custom_end_wrapper'   => $custom_end_wrapper,
			'layout'               => $layout,
			'manual_mode'          => $manual_mode,
			'excerpt_style'        => $excerpt_style,
			'staff_per_page'       => $staff_per_page,
			'staffer_slug'         => $staffer_slug,
			'page_title'           => $page_title,
			'page_description'     => $page_description,
			'custom_css'           => $custom_css,
			'main_page_id'         => $main_page_id,
		);

		return $normalize_options;

	}

	/**
	 * Generates the main staff page
	 * @since     2.0.0
	 */

	public function create_staff_page() {
		$staffer = new Staffer();
		$options = $staffer->get_options();

		if( !$options['main_page_id'] ) {
			if( !get_post( $options['main_page_id'] ) ) {

				$args = array(
					'post_type' => 'page',
					'post_status' => 'publish',
					'post_title' => $options['page_title'],
					'post_name' => sanitize_title_with_dashes( $options['page_title'] ),
					'post_content' => $options['page_description'],
				);

				$main_page_id = wp_insert_post( $args );

				$saved_options = get_option('staffer');
				$saved_options['main_page_id'] = $main_page_id;

				update_option( 'staffer', $saved_options );

			}

		}
	}


	/**
	 * Generates the Staffer content for the main staff page
	 * @since     2.0.0
	 * @return  string  Markup for Staffer output
	 */
	
	public function build_staff_page() {
		//ob_start();

		$args = array(
			'post_type' => 'staff',
			'order' => 'DESC',
			'orderby' => 'date',
			'posts_per_page' => -1,
		);

		$staff_posts = get_posts( $args );

		$output = '';

		if( $staff_posts ):
			$staffer = new Staffer();
			$options = $this->get_options();
			$ul_class = $options['layout'] == 'grid' ? 'staffer-archive-grid' : 'staffer-archive-list';
			$img_class = $options['layout'] == 'grid' ? 'aligncenter' : 'alignleft staffer-list-image';

			$output .= '<ul class="' . $ul_class . '">';

			foreach( $staff_posts as $staff ) {
				$staff_obj = new CW_Staff( $staff->ID );
				$thumbnail = get_the_post_thumbnail ( $staff_obj->ID, 'staffer-thumb', array ('class' => $img_class ) );
				$large = get_the_post_thumbnail ( $staff_obj->ID, 'large', array ('class' => $img_class ) );

				if( '' == $thumbnail ) {
					$default_thumb = $this->plugin_path . '/public/assets/staffer-default-image.jpg';
					$thumbnail .= '<img src="' . $default_thumb . '" alt="' . $staff_obj->name . '" class="' . $img_class . '" />';
				}

				$departments_string = '';

				if( $staff_obj->departments ) {
					foreach( $staff_obj->departments as $department ) {
						$departments_string .= $department->name . ', ';
					}
				}

				$social_output = '<div class="social-icons">';

				$social_arr = array(
					'facebook' => $staff_obj->facebook,
					'twitter' => $staff_obj->twitter,
					'linkedin' => $staff_obj->linkedin,
					'youtube' => $staff_obj->youtube,
					'instagram' => $staff_obj->instagram,
					'github' => $staff_obj->github
				);

				foreach( $social_arr as $k => $v ) {
					if( '' != $v ) {
						$social_output .= '<a target="_blank" href="' . $v . '"><img class="staffer-social-icon" src="' . $this->plugin_path . '/public/assets/' . $k . '.svg" alt="" /></a>';
					}
				}

				$social_output .= '</div>';

				$departments_string = rtrim( $departments_string,', ' );

				$output .= '<li class="staff-li">';

				$output .= '<div class="staff-content cw-staffer-clearfix">';

				$output .= '<a data-bio="' . esc_attr( wpautop( do_shortcode($staff_obj->bio ) ) ) . '"
									data-name="' . $staff_obj->name . '"
									data-departments="' . $departments_string . '"
									data-image="' . esc_attr( $thumbnail ) . '"
									data-large-image="' . esc_attr( $large ) . '"
									data-phone="' . $staff_obj->phone . '"
									data-email="' . $staff_obj->email . '"
									data-facebook="' . $staff_obj->facebook . '"
									data-twitter="' . $staff_obj->twitter . '"
									data-linkedin="' . $staff_obj->linkedin . '"
									data-youtube="' . $staff_obj->youtube . '"
									data-instagram="' . $staff_obj->instagram . '"
									data-github="' . $staff_obj->github . '"
									data-google-plus="' . $staff_obj->google_plus . '"
									data-website="' . $staff_obj->website . '"
									data-title="' . $staff_obj->title . '"
									data-staff-slug="' . $staff->post_name. '"
									data-staff-id="' . $staff_obj->ID . '"
									class="cw-launch-staffer-modal" href="/">' . $thumbnail . '</a>';
				
				if( $options['layout'] == 'grid' ) {
					$output .= '</div>';
					$output .= '<header class="staffer-staff-header">';
				}

				$output .= '<h3 class="staffer-staff-title">
										<a data-bio="' . esc_attr( wpautop( do_shortcode($staff_obj->bio ) ) ) . '"
											data-name="' . $staff_obj->name . '"
											data-departments="' . $departments_string . '"
											data-image="' . esc_attr( $thumbnail ) . '"
											data-large-image="' . esc_attr( $large ) . '"
											data-phone="' . $staff_obj->phone . '"
											data-email="' . $staff_obj->email . '"
											data-facebook="' . $staff_obj->facebook . '"
											data-twitter="' . $staff_obj->twitter . '"
											data-linkedin="' . $staff_obj->linkedin . '"
											data-youtube="' . $staff_obj->youtube . '"
											data-instagram="' . $staff_obj->instagram . '"
											data-github="' . $staff_obj->github . '"
											data-google-plus="' . $staff_obj->google_plus . '"
											data-website="' . $staff_obj->website . '"
											data-title="' . $staff_obj->title . '"
											data-staff-slug="' . $staff->post_name. '"
											data-staff-id="' . $staff_obj->ID . '"
											class="cw-launch-staffer-modal" href="/">
										' . $staff_obj->name . '</a>
									</h3>';

				if( $staff_obj->title ) {
					$output .= '<small class="staffer-staff-title"><em>' . $staff_obj->title . '</em></small>';
				}

				if( $departments_string ) {
					$output .= '<small class="staffer-staff-departments"><em>' . $departments_string . '</em></small>';
				}

				if( $staff_obj->phone ) {
					$output .= '<small class="staffer-staff-phone"><em>' . $staff_obj->phone . '</em></small>';
				}

				if( $staff_obj->email ) {
					$output .= '<small class="staffer-staff-email"><em></em></small>';
				}

				if( $options['layout'] == 'list' ) {
					$output .= $social_output;
					//$output .= '<div class="staff-bio">' . wpautop( $staff_obj->excerpt ) . '</div>';
				}

				if( $options['layout'] == 'grid' ) {
					$output .= '</header>';
				}

				$output .= '</li>';
			}

			$output .= '</ul>';

			$output .= '
						<div class="cw-staffer-modal">
							<div class="cw-modal-inner">
							<span class="cw-modal-close dashicons dashicons-no"></span>
							<h5 class="staff-name"></h5>
							<div class="cw-modal-header">
							<div class="section">
							<h5 class="staff-title"></h5>
							<h5 class="staff-department"></h5>
							<div class="social-icons"></div>
							</div>
							<div class="section">
							<h5 class="staff-phone"></h5>
							<h5 class="staff-email"></h5>
							<h5 class="staff-website"></h5>
							</div>
							</div>
							<div class="cw-modal-body cw-staffer-clearfix"></div>
							</div>
						</div>';

		endif;

		return do_shortcode( $output );
	}

}
