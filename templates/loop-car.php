<?php global $archive_query; ?>

<?php get_template_part('templates/section', 'back-btn'); ?>

<div class="inner-top-nav full-row top-row posts-nav clearfix">
	<ul class="posts-menu row">
	
		<li><a class="active" href="#overview">Overview</a></li>
		
		<?php foreach( $archive_query->posts as $car ) : ?>
		
			<li><a href="#car-<?php echo $car->post_name; ?>"><?php echo $car->post_title; ?></a></li>
		
		<?php endforeach; ?>
		
	</ul>
</div>

<?php get_template_part('templates/content', 'page'); ?>

<div class="cars-archive">
	
	<ul class="archive-posts">
	
		<?php // Posts
			while ($archive_query->have_posts()) : $archive_query->the_post(); 
		?>
		
				<li id="car-<?php echo $post->post_name; ?>" class="archive-post car">
					<?php get_template_part('templates/content', get_post_type()); ?>
				</li>
			
		<?php endwhile; ?>
		
	</ul>

</div>