<?php global $archive_query; ?>

<?php get_template_part('templates/section', 'back-btn'); ?>

<div class="inner-top-nav full-row top-row posts-nav clearfix">
	<ul class="posts-menu row">
		<li><a class="active" href="#overview">Overview</a></li>
		<li><a href="#country-nav">Hotels by Country</a></li>
	</ul>
</div>



<?php get_template_part('templates/content', 'page'); ?>

<div class="hotels-archive">
	
	<?php 	$countries = array();
			foreach( $archive_query->posts as $hotel ){
				$country = get_field('hotel_country', $hotel->ID);
				if( !in_array($country, $countries) ){
					$countries[] = $country;
				}
			}	
	?>
	<!-- Nav tabs -->
	<div class="sliding-top-nav">
		<ul id="country-nav" class="hotels-menu row">
		
			<?php $first = true; foreach($countries as $country) :	?>
				<li>
					<a <?php if($first) echo 'class="active"'; ?> href="#<?php echo strtolower($country); ?>-hotels" >
						<span><?php echo ucwords( str_replace( '-', ' ', $country ) ); ?></span>
					</a>
				</li>
			<?php $first = false; endforeach; ?>
			
		</ul>
		<hr class="nav-divider">
	</div>
	
	<ul class="archive-posts">
	
		<?php // Posts
			while ($archive_query->have_posts()) : $archive_query->the_post(); 
		?>
		
				<li class="archive-post hotel <?php echo strtolower( get_field('hotel_country') ) ?>-hotel">
					<?php get_template_part('templates/content', get_post_type()); ?>
				</li>
			
		<?php endwhile; ?>
		
	</ul>

</div>