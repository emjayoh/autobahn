<?php global $archive_query; ?>

<?php get_template_part('templates/content', 'page'); ?>

<div class="tours-archive">
	<!-- Nav tabs -->
	<div class="sliding-top-nav">
		<ul class="tours-menu row">
			<li><a class="active" href="#current-tours" >Current Tours</a></li>
			<li><a href="#past-tours">Past Tours</a></li>
		</ul>
		<hr class="nav-divider">
	</div>

	
	<ul class="archive-posts">
		<?php // Posts
			while ($archive_query->have_posts()) : $archive_query->the_post(); 
		?>
		
			<?php $current_tour = time() < get_field('tour_start_date') / 1000 ? true : false; ?>
			
			<li class="archive-post tour <?php echo $current_tour ? 'current' : 'past'; ?>">
				<?php get_template_part('templates/content', get_post_type()); ?>
			</li>
			
		<?php endwhile; ?>
	</ul>
</div>