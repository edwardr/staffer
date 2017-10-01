<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codewrangler.io
 * @since      2.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Staffer
 * @subpackage Staffer/public
 * @author     codeWrangler, Inc. <edward@codewrangler.io>
 */
class Staffer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Registers the Staffer post type
	 *
	 * @since  1.0.0
	 */

	public function register_post_types() {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		if( $options['main_page_id'] ) {
			if( get_post_status( $options['main_page_id'] ) != 'publish' || get_post_type( $options['main_page_id'] ) != 'page' ) {
				$staffer->create_staff_page();
			}
		} else {
			$staffer->create_staff_page();
		}

		$options = $staffer->get_options();

		$page = get_post( $options['main_page_id'] );
		$slug = $page->post_name;

		$rewrite = array(
			'slug'        => $slug,
			'with_front'  => false,
			'pages'       => false,
			'feeds'       => true,
		);

		register_post_type('staff', array(
			'labels' => array(
				'name' => $options['label'],
				'singular_name' => __('Profile'),
				'add_new_item' => __('Add New Profile'),
				'edit_item' => __('Edit Profile'),
				'new_item' => __('New Profile'),
				'all_items' => __('All Profiles'),
				'view_item' => __('View Profile'),
				'search_items' => __('Search Profiles'),
				'not_found' => __('Nothing Found'),
				'not_found_in_trash' => __('Nothing Found'),
			),
			'public' => false,
			'has_archive' => false,
			'show_ui' => true,
			'menu_order' => '4',
			'rewrite' => $rewrite,
			'menu_icon' => 'dashicons-id',
			'supports' => array(
				'title',
				'editor',
				'revisions',
				//'custom-fields',
				'thumbnail',
				'excerpt'
				)
			)
		);

	}


	/**
	 * Registers the Staffer taxonomy
	 *
	 * @since  1.0.0
	 */
	
	public function register_taxonomies() {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		register_taxonomy(
			'department',
			'staff',
			array(
				'hierarchical' => true,
				'label' => __( 'Departments', 'staffer' ),
				'public' => false,
				'show_ui' => true,
			)
		);

	}

	/**
	 * Adds post-thumbnail support if theme has not
	 *
	 * @since  2.0.0
	 */
	
	public function staffer_thumbnail_check() {

		if ( !current_theme_supports ('post-thumbnails') ) {
			add_theme_support ('post-thumbnails' );
		}

		add_image_size( 'staffer-thumb', 250, 250, array( 'center', 'center' ) );

	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/staffer-styles.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'dashicons' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/staffer-scripts.js', array( 'jquery' ), $this->version, false );

		$data = array(
			'plugin_path' => plugin_dir_url( __FILE__ ),
		);

		wp_localize_script( $this->plugin_name, 'cwStaffer', $data );

	}

	/**
	 * Staffer shortcode callback
	 *
	 * @since    1.0.0
	 */
	public function staffer_shortcode( $atts ) {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		ob_start();

		extract( shortcode_atts( array (
			'order' => 'DESC',
			'orderby' => 'date',
			'number' => -1,
			'department' => '',
			'layout'		 => $options['layout'],
		), $atts ) );

		if ( '' == $department ) {
			$tax_query = '';
		} else {
			$tax_query = array (
				array (
					'taxonomy'	=> 'department',
					'field'		=> 'slug',
					'terms'		=> $department,
					),
				);
		}

		$args = array(
			'post_type' => 'staff',
			'order' => esc_attr( $order ),
			'orderby' => esc_attr( $orderby ),
			'posts_per_page' => (int)$number,
			'tax_query' => $tax_query,
		);

		$staff_posts = get_posts( $args );

		if( $staff_posts ):
			$ul_class = $layout == 'grid' ? 'staffer-archive-grid' : 'staffer-archive-list';
			$img_class = $layout == 'grid' ? 'aligncenter' : 'alignleft staffer-list-image';

			echo '<ul class="' . $ul_class . '">';

			foreach( $staff_posts as $staff ) {
				$staff_obj = new CW_Staff( $staff->ID );
				$thumbnail = get_the_post_thumbnail ( $staff_obj->ID, 'staffer-thumb', array ('class' => $img_class ) );
				$large = get_the_post_thumbnail ( $staff_obj->ID, 'large', array ('class' => $img_class ) );

				if( '' == $thumbnail ) {
					$default_thumb = $staffer->plugin_path . '/public/assets/staffer-default-image.jpg';
					$thumbnail .= '<img src="' . $default_thumb . '" alt="' . $staff_obj->name . '" class="' . $img_class . '" />';
				}

				$departments_string = '';

				if( $staff_obj->departments ) {
					foreach( $staff_obj->departments as $department ) {
						$departments_string .= $department->name . ', ';
					}
				}

				if( $layout == 'grid' ) {
					$social_output = '';
				} else {
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
							$social_output .= '<a target="_blank" href="' . $v . '"><img class="staffer-social-icon" src="' . $staffer->plugin_path . '/public/assets/' . $k . '.svg" alt="" /></a>';
						}
					}

					$social_output .= '</div>';
				}

				$departments_string = rtrim( $departments_string,', ' );

				echo '<li class="staff-li">';

				echo '<div class="staff-content cw-staffer-clearfix">';

				echo '<a data-bio="' . esc_attr( wpautop( do_shortcode($staff_obj->bio ) ) ) . '"
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
					echo '</div>';
					echo '<header class="staffer-staff-header">';
				}

				echo '<h3 class="staffer-staff-title">
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
					echo '<small class="staffer-staff-title"><em>' . $staff_obj->title . '</em></small>';
				}

				if( $departments_string ) {
					echo '<small class="staffer-staff-departments"><em>' . $departments_string . '</em></small>';
				}

				if( $staff_obj->phone ) {
					echo '<small class="staffer-staff-phone"><em>' . $staff_obj->phone . '</em></small>';
				}

				if( $staff_obj->email ) {
					echo '<small class="staffer-staff-email"><em></em></small>';
				}

				if( $options['layout'] == 'list' ) {
					echo $social_output;
				}

				if( $options['layout'] == 'grid' ) {
					echo '</header>';
				}

				echo '</li>';
			}

			echo '</ul>';

			echo '<div class="cw-staffer-modal">
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

			echo '<script>jQuery("body").addClass("staffer-main-page");</script>';

		endif;

		$output = ob_get_clean();

		return $output;

	}

	/**
	 * Adds the Staffer content to the main staff page
	 * @since     2.0.0
	 * @return  string  Post content
	 */

	public function staff_main_page_content( $content ) {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		global $post;

		if( $post->ID == $options['main_page_id'] ) {

			if( !is_admin() && is_singular() && is_main_query() ) {
				//$existing_content = $content;
				//var_dump( $staffer->build_staff_page() );
				$staff_feed = $staffer->build_staff_page();
				$content .= $staff_feed;
			}

		}

		return $content;

	}

	/**
	 * Adds a body class to the main Staffer page
	 * @since     2.0.0
	 * @return  array  Array of body classes
	 */

	public function staffer_body_class( $classes ) {
		global $post;
		$staffer = new Staffer();
		$options = $staffer->get_options();

		if( $post->ID == $options['main_page_id'] ) {
			$classes[] = 'staffer-main-page';
		}

		return $classes;	
	}

}
