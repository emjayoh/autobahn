<div class="archive-post event">
	
	<div class="event-banner row full-row">
	
		<div class="aspect-21-9">
	
			<div class="event-banner-title col-sm-6 col-sm-offset-3">
				<?php the_title(); ?>
			</div>
			
			<?php $img = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
			
			<div class="bg-cover" style="background-image: url('<?php echo $img; ?>');"></div>
		
		</div>
		
	</div>
	
	<?php get_template_part('templates/content', 'page'); ?>
	
</div>