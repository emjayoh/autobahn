<div class="row full-row">

	<div class="aspect-21-9">
		
		<div class="bg-cover" style="background-image: url('<?php the_field('car_banner_img'); ?>'); ">
		
			<h2 class="text-overlay"><?php the_field('car_banner_title'); ?></h2>
		
		</div>
				
	</div>

</div>

<div class="row summary">

	<div class="col-sm-8 vcenter">
		<h4><?php the_field('car_summary_title'); ?></h4>
		<div><?php the_field('car_summary_txt'); ?></div>
	</div>
	<div class="col-sm-4 col-xs-6 col-xs-offset-3 vcenter">
		<img class="manufacturers-logo" src="<?php the_field('car_make_logo'); ?>">
	</div>

</div>

<?php the_content(); ?>

<?php get_template_part('templates/content', 'page'); ?>

<div class="flex-gallery">
	
	<?php $images = get_field('car_gallery'); ?>

		<?php 
			$index = 1;
			foreach( $images as $image) :
		?>
					
			<?php if( $index % 2 ) : ?><div class="row gallery-row <?php echo $index > 4 ? 'hidden' : 'visible'; ?>"><?php endif; ?>
						
				<div class="col-sm-6">
					<div class="aspect-16-9">
						<div class="bg-cover" style="background-image: url('<?php echo $image['url']; ?>');"></div>
					</div>
				</div>
			
			<?php if( ! ($index % 2) ) : ?></div><?php endif; ?>

		<?php 
			$index++;
			endforeach;
		?>
		
		<?php if( $index > 4 ) : ?>
		
			<div class="gallery-load-btn">
				<a href="#">Load More Photos</a>
			</div>
		
		<?php endif; ?>
					
</div>