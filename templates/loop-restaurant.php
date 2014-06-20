<?php global $archive_query; ?>

<?php get_template_part('templates/section', 'back-btn'); ?>

<?php get_template_part('templates/content', 'page'); ?>

<div class="events-archive">

	<?php

		while ($archive_query->have_posts()) : $archive_query->the_post();
		
			get_template_part('templates/content', get_post_type());
			
		endwhile;
		
	?>

</div>