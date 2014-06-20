<?php
/*
Template Name: Post Archive Page
*/
?>

<?php // Build WP_Query for CPT posts being archived
	$archive_post_type = get_field('archive_post_type');
	$args = array(
				'post_type' => $archive_post_type,
				'posts_per_page' => -1,
			);
	$archive_query = new WP_Query( $args );
?>

<?php  // Error message if no posts
	if (!$archive_query->have_posts()) :
	
		get_template_part('templates/section', 'back-btn');
	
		if( is_array( $archive_post_type ) ){
		
			$printable_list_cpts = // Build array of cpt names into string separated by " or "
				implode( ' or ', array_map( // Capitalize and pluralize each cpt slug
									function($str) {
										return ucfirst($str) . 's';
									}, $archive_post_type
								 )
				); // example echo: "Tours or Reviews"
				
		} else {
			$printable_list_cpts = ucfirst($archive_post_type) . 's';
		}
?>
		<div class="alert alert-warning">
			<span>Sorry, no <?php echo $printable_list_cpts; ?> were found.</span>
		</div>
		<?php get_search_form(); ?>
<?php endif; ?>


<?php // Content
	get_template_part('templates/loop', $archive_post_type);
?>

<?php // Pagination
	if ($archive_query->max_num_pages > 1) :
?>
	<nav class="post-nav">
		<ul class="pager">
			<li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
			<li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
		</ul>
	</nav>
<?php endif; ?>

<?php // Restore original Post Data
	wp_reset_postdata();
?>