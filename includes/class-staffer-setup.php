<?php

/**
 * Initial Staffer setup
 *
 * @link       https://wpnook.com
 * @since      1.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/public
 */

class Staffer_Setup {

	/**
	 * Registers the staff post type
	 *
	 * @since 1.0.0
	 */
	public static function create_staff_cpt() {

		$options = get_option ('staffer');

		if ( $options['slug'] ) {
			$slug = $options['slug'];
			$rewrite = array(
				'slug'                => $slug,
				'with_front'          => true,
				'pages'               => true,
				'feeds'               => true,
			);
		} else {
			$rewrite = false;
		}

		// fixes title tag issue and adds label option
		if ( empty ($options['label'] ) ) {
			$label = _x( 'Staff', 'post type general name', 'staffer' );
		} else {
			$label = $options['label'];
		}

		if ( isset( $options['manual_mode'] ) ) {
			$archive = false;
		} else {
			$archive = true;
		}

		// labels for the post type
		$labels = array(
				'name'               => $label,
				'singular_name'      => _x( 'Staff Member', 'post type singular name', 'staffer' ),
				'menu_name'          => _x( 'Staff', 'admin menu', 'staffer' ),
				'name_admin_bar'     => _x( 'Staff', 'add new on admin bar', 'staffer' ),
				'add_new'            => _x( 'Add New', 'staff', 'staffer' ),
				'add_new_item'       => __( 'Add New Staff Member', 'staffer' ),
				'new_item'           => __( 'New Staff Member', 'staffer' ),
				'edit_item'          => __( 'Edit Staff Member', 'staffer' ),
				'view_item'          => __( 'View Staff Member', 'staffer' ),
				'all_items'          => __( 'All Staff Members', 'staffer' ),
				'search_items'       => __( 'Search Staff Members', 'staffer' ),
				'not_found'          => __( 'No Staff Members Found.', 'staffer' ),
				'not_found_in_trash' => __( 'No Staff Members Found in Trash.', 'staffer' )
			);

		// register the staff post type
		register_post_type('staff', array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => $archive,
			'show_in_menu' => true,
			'menu_order' => '4',
			'rewrite' => $rewrite,
			'menu_icon' => 'dashicons-id',
			'supports' => array(
				'title',
				'editor',
				'revisions',
				'thumbnail',
				'excerpt'
				)
			));
	}

	/**
	 * Adds thumbnail support if the current theme does not support it
	 * @since 1.0.0
	 */
	public static function theme_thumbnail_support() {
		if ( ! current_theme_supports ('post-thumbnails') ) {
			add_theme_support ('post-thumbnails' );
		}
	}

	/**
	 * Adds support for using custom Staffer templates
	 * @since 1.0.0
	 */
	public static function staff_template_override( $template ) {
		if ( is_post_type_archive( 'staff' ) && ! file_exists( get_stylesheet_directory() . '/archive-staff.php' ) ) {
			$template = plugin_dir_path (__FILE__) . 'archive-staff.php';
		}
		if ( is_singular( 'staff' ) && ! file_exists( get_stylesheet_directory() . '/single-staff.php' ) ) {
			$template = plugin_dir_path (__FILE__) . 'single-staff.php';
		}

		$staffer_options = get_option ('staffer');

		if ( !isset ( $staffer_options['manual_mode'] ) ) {
			if ( is_tax( 'department' ) && ! file_exists( get_stylesheet_directory() . '/taxonomy-staffer-department.php' ) ) {
				$template = plugin_dir_path (__FILE__) . 'taxonomy-staffer-department.php';
			}
		}
		return $template;
	}

	/**
	 * Hooks into pre_get_posts for the staff post type and taxonomy only
	 * @since 1.0.0
	 */
	public static function staff_per_page_mod( $query ) {
		$options = get_option ('staffer');
		$posts_per_page = $options['perpage'];

		if ( ! $posts_per_page ) {
			return;
		}

		if ( $query->is_main_query() && is_post_type_archive( 'staff' ) && !is_admin() ) {
				$query->set( 'posts_per_page', $posts_per_page );
			} elseif ( $query->is_main_query() && is_tax ( 'department' ) && !is_admin() ) {
				$query->set( 'posts_per_page', $posts_per_page );
		}

	}

	/**
	 * Adds the Staffer shortcode
	 * @since 1.0.0
	 */
	public static function staffer_shortcode( $atts ) {

		ob_start();
		$atts_arr = array(
			'order' => 'DESC',
			'orderby' => 'date',
			'number' => -1,
			'department' => '',
		);

		extract( shortcode_atts( $atts_arr, $atts ) );

		if ( $department == '' ) {
			$tax_query = null;
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
			'order' => $order,
			'orderby' => $orderby,
			'posts_per_page' => $number,
			'tax_query' => $tax_query,
		);

		$staff_posts = get_posts( $args );

		if ( $staff_posts ):
			setup_postdata();
			$layout_type = isset( $options['gridlayout'] ) ? 'grid' : 'list';
			echo '<ul class="staffer-archive-' . $layout_type . '">';

			foreach( $staff_posts as $staff ) {
				echo '<li><header class="staffer-staff-header">' . $staff->post_title . '</header></li>';
			}

			echo '</ul>';
			wp_reset_postdata();
		endif;
	
		$staff_query = new WP_Query( $args );
		if ( $staff_query->have_posts() ) { 
			global $post;
			$stafferoptions = get_option ( 'staffer' );

		if (isset ($stafferoptions['gridlayout']) ) { ?>
			<ul class="staffer-archive-grid">
				<?php } else { ?>
					<ul class="staffer-archive-list">
					<?php }

				while ( $staff_query->have_posts() ) : $staff_query->the_post(); ?>
				<li>
					<header class="staffer-staff-header">
					<h3 class="staffer-staff-title"><a href="<?php the_permalink(); ?>">
						<?php echo the_title(); ?>
						</a>
					</h3>
					<?php
					if ( get_post_meta ($post->ID,'staffer_staff_title', true) != '' ) {
						echo '<em>';
						echo get_post_meta ($post->ID,'staffer_staff_title', true) . '</em><br>';
						}
						?>
					
					</header>
						<div class="staff-content">
					<?php if (isset ($stafferoptions['gridlayout']) ) { ?>
						<?php the_post_thumbnail ( 'medium', array ('class' => 'aligncenter') ); ?>
							<?php } else { ?>
							<?php the_post_thumbnail ( 'medium', array ('class' => 'alignleft') ); ?>
							<?php }
							if ($stafferoptions['estyle'] == null or $stafferoptions['estyle'] == 'excerpt' ) {
								the_excerpt();
							} elseif ($stafferoptions['estyle'] == 'full' ) {
								the_content();
							} elseif ($stafferoptions['estyle'] == 'none' ) {
								// nothing to see here
							} 
							?>
						</div>
					</li>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</ul>
		<?php $output = ob_get_clean();
		return $output;
		}	
	}
}