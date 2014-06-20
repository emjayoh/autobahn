<?php
/*
Template Name: Home Page
*/
?>
	
<?php

	$slide = 1;

	while( have_rows('home-slide') ): the_row(); 

		// vars
		$slide_bg = 			get_sub_field('home_slide_bg');
		$slide_darken = 		get_sub_field('home_slide_bg_darken');
		$slide_title = 			get_sub_field('home_slide_title');
		$slide_subtitle = 		get_sub_field('home_slide_subtitle');
		$slide_movie = 			get_sub_field('home_slide_movie_modal');
		$slide_movie_text = 	get_sub_field('home_slide_movie_link_txt');
		$slide_movie_code = 	get_sub_field('home_slide_movie_link');
		$slide_cta = 			get_sub_field('home_slide_cta_btn');
		$slide_cta_text = 		get_sub_field('home_slide_cta_btn_txt');
		$slide_cta_link = 		get_sub_field('home_slide_cta_btn_link');
		
		$slide_opacity = 		(100 - $slide_darken)/100;
		
		$slide_movie_src = '//www.youtube.com/embed/' . $slide_movie_code . '?rel=0;&amp;vq=hd1080&amp;controls=0&amp;showinfo=0&amp;modestbranding=1';

?>

<section class="section onepage-slide slide-align-<?php echo $slide % 3; ?>" id="onepage-slide-<?php echo $slide; ?>">

	<div class="onepage-bg" style="background-image: url('<?php echo $slide_bg; ?>'); opacity: <?php echo $slide_opacity; ?>"></div>
	
	<div class="container onepage-container">
	
		<div class="col-md-7 onepage-content">
	
			<h1><?php echo $slide_title; ?></h1>
			
			<?php if($slide_subtitle) : ?>
				<h5><?php echo $slide_subtitle; ?></h5>
			<?php endif; ?>
			
			<?php if($slide_movie) : ?>
				
				<!-- Button trigger modal -->
				<div class="movie-modal">
					<div data-toggle="modal" data-target="#video-modal-<?php echo $slide; ?>">
						<span class="glyphicon glyphicon-play-circle"></span>
						<span><?php echo $slide_movie_text; ?></span>
					</div>
				</div>
			
				<!-- Modal -->
				<div class="modal fade" id="video-modal-<?php echo $slide; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="fitVids">
								<iframe width="640" height="360" src="<?php echo $slide_movie_src; ?>" data-src="<?php echo $slide_movie_src; ?>&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
				</div>
				

				
			<?php endif; ?>
			
			<?php if($slide_cta) : ?>
				<div class="btn btn-default cta-button">
					<a href="<?php echo $slide_cta_link; ?>">
						<?php echo $slide_cta_text; ?>
					</a>
				</div>
			<?php endif; ?>
		
		</div>
	
	</div>
	
</section>

<?php

	$slide++;
	endwhile;

?>