<?php // staffer list template

$stafferoptions = get_option('staffer');

// checks the post per page option
if ( $stafferoptions['perpage'] != null ) {
	$postsperpage = $stafferoptions['perpage'];
}
else {
	$postsperpage = 9;
}
					$args = array ( 
						'post_type' => 'staff',
						'pagination'	=> true,
						'posts_per_page' => $postsperpage, 
						'paged' => $paged
						);
					$the_query = new WP_Query( $args );
					
			if ($the_query->have_posts() ) : ?>
			
			<ul class="staffer-archive-list">
			
			<?php while ( $the_query->have_posts() ) : ?>
			
			<?php $the_query->the_post(); ?>

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
					<?php the_post_thumbnail ( 'medium', array ('class' => 'alignleft') );
						the_excerpt(); ?>
					</div>
				</li>
			<?php endwhile;
			endif; ?>
			</ul>