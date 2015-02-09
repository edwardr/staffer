<?php // staffer single template
	get_header(); ?>

<?php
	// prints the start wrapper
	// must be carried over if using a custom template, else options will not work
	$stafferoptions = get_option ( 'staffer' );
	if (isset ($stafferoptions['customwrapper']) && isset ($stafferoptions['startwrapper'])) {
		$customstartwrapper = $stafferoptions['startwrapper'];
		echo $stafferoptions['startwrapper'];
		}
		else {
			include ( plugin_dir_path (__FILE__) . 'inc/start-wrapper.php');
			}
			?>
			
		<?php if (have_posts() ) : ?>
		
			<?php while ( have_posts() ) : the_post(); ?>

	<header class="staffer-staff-header">
		<?php 
			// checks for slug and builds path
			if ( get_option ('permalink_structure') ) {

			$pageslug = $stafferoptions['slug'];
			if ( $pageslug == '' ) {
					$pageslug = 'staff';
				}
			$homeurl = esc_url( home_url( '/' ) );
			$basepageurl = $homeurl . $pageslug;
			} else {
			$homeurl = esc_url( home_url( '/' ) );
			$basepageurl = $homeurl . '?post_type=staff';
			}
			$pagetitle = $stafferoptions['ptitle'];
			if ($pagetitle == '' ) {
				$pagetitle = 'Staff';
			}
		?>

		<?php
			// checks for manual mode
			// does not display breadcrumb trail in manual mode
			if ( ! isset ( $stafferoptions['manual_mode'] ) ) { ?>
			<div class="staffer-breadcrumbs">
				<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php _e ('Home', 'staffer'); ?></a> &#8250;
					<a href="<?php echo esc_url ($basepageurl) ; ?>" itemprop="url"><?php echo $pagetitle; ?></a> &#8250;
					<span itemprop="title"><?php the_title(); ?></span>
				</div>
			</div>

		<?php } ?>
		
		<?php 
			echo '<h2>';
			echo the_title();
			echo '</h2>';
			if ( get_post_meta ($post->ID,'staffer_staff_title', true) != '' ) {
				echo '<em>';
				echo get_post_meta ($post->ID,'staffer_staff_title', true) . '</em><br>';
				}
			$terms = get_the_term_list ( $post->ID, 'department', '', ', ' );
			if ( $terms != '' ) {
				echo '<em>';
				_e ( 'Department: ', 'staffer' );
				echo $terms;
				echo '</em>';
				} ?>
	</header>

		<div class="staff-content">
		<?php
		the_post_thumbnail ( 'medium', array ('class' => 'alignleft') );
			the_content(); ?>
		</div>
	
	<div class="staffer-staff-social-links">
	<?php
	// social + contact links
	if ( get_post_meta ($post->ID,'staffer_staff_fb', true) != '' ) { ?>
		<a href="<?php echo get_post_meta ($post->ID,'staffer_staff_fb', true); ?>" target="_blank">
			<i class="fa fa-facebook fa-fw"></i></a>
	<?php 
		}
	if ( get_post_meta ($post->ID,'staffer_staff_gplus', true) != '' ) { ?>
		<a href="<?php echo get_post_meta ($post->ID,'staffer_staff_gplus', true); ?>" target="_blank">
			<i class="fa fa-google-plus fa-fw"></i></a>
	<?php }
	if ( get_post_meta ($post->ID,'staffer_staff_twitter', true) != '' ) { ?>
		<a href="<?php echo get_post_meta ($post->ID,'staffer_staff_twitter', true); ?>" target="_blank">
			<i class="fa fa-twitter fa-fw"></i></a>
	<?php }
	if ( get_post_meta ($post->ID,'staffer_staff_linkedin', true) != '' ) { ?>
		<a href="<?php echo get_post_meta ($post->ID,'staffer_staff_linkedin', true); ?>" target="_blank">
			<i class="fa fa-linkedin fa-fw"></i></a>
	<?php }
	if ( get_post_meta ($post->ID,'staffer_staff_email', true) != '' ) {
		$email = get_post_meta ($post->ID,'staffer_staff_email', true); ?>
		<a href="mailto:<?php echo antispambot($email);?>?Subject=<?php _e ('Contact from ', 'staffer'); ?><?php bloginfo('name'); ?>" target="_blank">
			<i class="fa fa-envelope fa-fw"></i></a>
	<?php }
	if ( get_post_meta ($post->ID,'staffer_staff_website', true) != '' ) {
		$website = get_post_meta ($post->ID,'staffer_staff_website', true); ?>
		<a href="<?php echo get_post_meta ($post->ID,'staffer_staff_website', true); ?>" target="_blank">
			<i class="fa fa-user fa-fw"></i></a>
	<?php }
	if ( get_post_meta ($post->ID,'staffer_staff_phone', true) != '' ) {
		$phone = get_post_meta ($post->ID,'staffer_staff_phone', true); ?>
			<span><?php echo get_post_meta ($post->ID,'staffer_staff_phone', true); ?></span>
	<?php }
	?>
	</div>

			<?php endwhile;
					endif; ?>

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