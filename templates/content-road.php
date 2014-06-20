<div class="aspect-16-9">
	
	<div class="bg-cover">
	
		<div class="road-carousel">
	
			<!--Road Carousel-->
			<?php 

			$images = get_field('road_images');
			 
			if( $images ): ?>
			<div id="<?php echo $post->post_name; ?>-carousel" class="carousel slide" data-ride="carousel">
				
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php foreach( $images as $num => $image ): ?>
						<li 
							data-target="#<?php echo $post->post_name; ?>-carousel"
							data-slide-to="<?php echo $num; ?>"
							<?php echo $num ? '' : ' class="active"' ?>
						></li>
					<?php endforeach; ?>
				</ol>
				
				
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<?php foreach( $images as $num => $image ): ?>
						<div class="item <?php echo $num ? '' : 'active' ?>">
							<div><div class="aspect-16-9"><?php //need both divs to animate properly ?>
									<div class="bg-cover" style="background-image: url('<?php echo $image['url']; ?>');">
										<div class="carousel-center">
											<span><?php echo get_the_title( $post->ID ); ?></span>
										</div>
									</div>
							</div></div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#<?php echo $post->post_name; ?>" data-slide="prev">
					<div class="chevron-left"><</div>
				</a>
				<a class="right carousel-control" href="#<?php echo $post->post_name; ?>" data-slide="next">
					<div class="chevron-right">></div>
				</a>
				
			</div>
			
			<?php endif; ?>
						
		</div>
		
	</div>
			
</div>
	
<?php get_template_part('templates/content', 'page'); ?>