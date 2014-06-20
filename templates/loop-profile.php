<?php global $archive_query; ?>

<?php get_template_part('templates/section', 'back-btn'); ?>

<div class="inner-top-nav full-row top-row posts-nav clearfix">
	<ul class="posts-menu row">
		<li><a class="active" href="#overview">Overview</a></li>
		<li><a href="#reviews">Reviews</a></li>
		<li><a href="#profiles">Customer Profiles</a></li>
	</ul>
</div>

<?php get_template_part('templates/content', 'page'); ?>

<div class="row flex-showcase-boxes profiles-archive">
	<div class="col-xs-12">							
		<ul class="showcase-boxes archive-posts">
			<div class="boxes-row clearfix">
			
				<?php
					
					while ($archive_query->have_posts()) : $archive_query->the_post();
					
						get_template_part('templates/content', get_post_type());
						
					endwhile;
				
				?>
				
			</div>
		</ul>
	</div>
</div>