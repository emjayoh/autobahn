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
		$slide_title = 			get_sub_field('home_slide_title');
		$slide_subtitle = 		get_sub_field('home_slide_subtitle');
		$slide_movie = 			get_sub_field('home_slide_movie_modal');
		$slide_movie_text = 	get_sub_field('home_slide_movie_link_txt');
		$slide_movie_url = 		get_sub_field('home_slide_movie_link');
		$slide_cta = 			get_sub_field('home_slide_cta_btn');
		$slide_cta_text = 		get_sub_field('home_slide_cta_btn_txt');
		$slide_cta_link = 		get_sub_field('home_slide_cta_btn_link');

?>

<section class="section onepage-slide slide-align-<?php echo $slide % 3; ?>" id="onepage-slide-<?php echo $slide; ?>">

	<div class="onepage-bg" style="background-image: url('<?php echo $slide_bg; ?>');"></div>
	
	<div class="container onepage-container">
	
		<div class="col-md-7 onepage-content">
	
			<h1><?php echo $slide_title; ?></h1>
			
			<?php if($slide_subtitle) : ?>
				<h5><?php echo $slide_subtitle; ?></h5>
			<?php endif; ?>
			
			<?php if($slide_movie) : ?>
				<div class="movie-modal">
					<a href="<?php echo $slide_movie_url; ?>">
						<span class="glyphicon glyphicon-play-circle"></span>
						<span><?php echo $slide_movie_text; ?></span>
					</a>
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