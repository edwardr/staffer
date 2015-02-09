<?php // staffer list template

$stafferoptions = get_option('staffer');

// checks the post per page option
//if ( $stafferoptions['perpage'] != null ) {
	//$postsperpage = $stafferoptions['perpage'];
//}
//else {
	//$postsperpage = 9;
//}
					//$args = array ( 
					//	'post_type' => 'staff',
						//'pagination'	=> true,
					//	'posts_per_page' => $postsperpage, 
						//'paged' => $paged
						//);
					//$the_query = new WP_Query( $args );
					
			if (have_posts() ) : ?>
			
			<ul class="staffer-archive-list">
			
			<?php while ( have_posts() ) : ?>
			
			<?php the_post(); ?>

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
					<?php
						if ( has_post_thumbnail() ) { ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail ( 'medium', array ('class' => 'alignleft') ); ?>
							</a>
							<?php
						}
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
			endif; ?>
			</ul>