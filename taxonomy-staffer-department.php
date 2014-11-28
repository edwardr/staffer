<?php // staffer department template
	get_header(); ?>

<?php 
	// loads the options
	// must be carried over if using a custom template, else options will not work
	$stafferoptions = get_option ( 'staffer' );
		if (isset ($stafferoptions['customwrapper']) && isset ($stafferoptions['startwrapper'])) {
			$customstartwrapper = $stafferoptions['startwrapper'];
			echo $stafferoptions['startwrapper'];
			}
		else {
			include ( plugin_dir_path (__FILE__) . 'inc/start-wrapper.php');
			}
			
			// retrieves tax title
			$department = get_queried_object()->name;
			$department = ucwords ( $department );
			?>
			<h2 class="staffer-archive-page-title"><?php echo $department; ?></h2>

			<?php
				// adds description if present
				$taxdescription = term_description();
				if ($taxdescription != '') { ?>
				<div class="staffer-page-description">
					<?php echo wpautop( $taxdescription ); ?>
				</div>
			<?php } ?>

			
		<?php
			// chooses between the grid and list layout
			// must be carried over if using a custom template, else options will not work
			if (isset ($stafferoptions['gridlayout']) ) {
				include ( plugin_dir_path (__FILE__) . 'inc/staffer-grid.php');
				}
			if ( ! isset ($stafferoptions['gridlayout'] ) ) {
				include ( plugin_dir_path (__FILE__) . 'inc/staffer-list.php');
				}
				?>
				
	<?php
			if ($wp_query->max_num_pages > 1) { ?>
			<div class="staffer-navigation">
			<?php posts_nav_link(); ?>
			</div>
			<?php } ?>
			
	<?php
		// prints the end wrapper
		// must be carried over if using a custom template, else options will not work
		if (isset ($stafferoptions['customwrapper']) && isset ($stafferoptions['endwrapper'])) {
		$customstartwrapper = $stafferoptions['endwrapper'];
		echo $stafferoptions['endwrapper'];
		}
		else {
			include ( plugin_dir_path (__FILE__) . 'inc/end-wrapper.php');
			}
			?>
<?php get_footer(); ?>