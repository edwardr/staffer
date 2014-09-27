<?php // staffer archive template
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
			
			// checks for the custom title
			$stafferarchivetitle = $stafferoptions['ptitle'];
			if ( isset ( $stafferarchivetitle ) && ($stafferarchivetitle != '' ) ) {
			?>
			<h2 class="staffer-archive-page-title"><?php echo $stafferarchivetitle; ?></h2>
			<?php }
				else {
				?>
			<h2 class="staffer-archive-page-title"><?php post_type_archive_title(); ?></h2>
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
			if ($the_query->max_num_pages > 1) { ?>
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
<?php if (isset ($stafferoptions['sidebar'] ) ) {
	get_sidebar();
	}
	?>
<?php get_footer(); ?>