<section class="hero">

	<?php
		
		// second arg ($id) in acf functions needed for blog page
		// it does nothing extra for other pages pages
		$id = get_queried_object_id();
		
		//echo '<pre style="background-color: black; opacity: 1; color: green; z-index:999999; position: relative;">';
		//	print_r( $wp_query );
		//echo '</pre>';
		
		if( get_field('hero_type', $id) == 'Static' || get_field('hero_type', $id) == null ){
		
			$is_dynamic			= false;
			
			$hero_bg			= get_field('static_hero_img', $id);
			$hero_alt_title		= get_field('static_hero_alt_title', $id);
			$hero_subtitle		= get_field('static_hero_subtitle', $id);
			
			if( get_field('static_hero_movie_modal', $id) ){
				$hero_modal 		= true;
				$hero_modal_link	= get_field('static_hero_movie_modal_link', $id);
				$hero_modal_txt		= get_field('static_hero_movie_modal_txt', $id);
			}
		
		}
		if( get_field('hero_type', $id) == 'Dynamic' ){
		
			$is_dynamic			= true;
			$featured_post		= get_field('dynamic_hero_featured_item', $id);
			$hero_bg			= get_field('static_hero_img', $featured_post->ID);
			//$hero_bg			= wp_get_attachment_url( get_post_thumbnail_id ( $featured_post->ID ) );
			$hero_btn_link		= get_permalink( $featured_post->ID );
			switch ( get_field('dynamic_hero_title', $id) ) {
				case 0: //Featured Item Title
					$hero_alt_title = $featured_post->post_title;
					break;
				case 1: //Custom
					$hero_alt_title = get_field('dynamic_hero_custom_title', $id);
					break;
			}
			
			
			// Subtitle
			switch ( get_field('dynamic_hero_subtitle', $id) ) {
				case 0: //Post Type Default (Case 1 for Posts and Reviews, Case 2 for other post types)
					$display_case = in_array($featured_post->post_type, ['post', 'review']) ? 1 : 2;
				case 1: //Featured Item Author/Date
					if(!$display_case || $display_case == 1){
						$hero_subtitle	= '<span class="uppercase">' . 'By ' . '<span class="gold">'
										. get_the_author_meta( 'display_name', $featured_post->post_author )
										. '</span>' . ' on '
										. get_the_time('m.d.Y', $featured_post->ID) . '</span>';
						break;
					}
				case 2: //Featured Item Excerpt
					if(!$display_case || $display_case == 2){
						$hero_subtitle = $featured_post->post_excerpt;
						break;
					}
				case 3: //Custom
					$hero_subtitle = get_field('dynamic_hero_custom_subtitle', $id);
					break;
			}
		
		}
		
		$hero_modal_src = '//www.youtube.com/embed/' . $hero_modal_link . '?rel=0;&amp;vq=hd1080&amp;controls=0&amp;showinfo=0&amp;modestbranding=1';

	?>

	<?php if( $hero_bg ) :?>
		<div class="hero-bg" style="background-image: url('<?php echo $hero_bg; ?>');"></div>
	<?php endif; ?>
	
	<div class="hero-content container<?php if( !$hero_bg ) echo ' hero-no-bg'; ?>">
		<div class="row">
			<div class="col-sm-7">
			
				<?php if($is_dynamic) : ?>
					<div class="hero-tag">
						<span>Featured <?php echo ucfirst($featured_post->post_type); ?></span>
					</div>
				<?php endif; ?>
				
				<?php // Hero Title ?>
				<h2>
					<?php
						if ( $hero_alt_title ){
							echo $hero_alt_title;
						} else{
							echo roots_title();
						}
					?>
				</h2>
			
				<?php // Hero Movie Modal ?>
				<?php if ( $hero_modal ) : ?>
						
						<!-- Button trigger modal -->
						<div class="movie-modal">
							<div data-toggle="modal" data-target="#hero-video-modal">
								<span class="glyphicon glyphicon-play-circle"></span>
								<span><?php echo $hero_modal_txt; ?></span>
							</div>
						</div>
						
						<!-- Modal -->
						<div class="modal fade" id="hero-video-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="fitVids">
										<iframe width="640" height="360" src="<?php echo $hero_modal_src; ?>" data-src="<?php echo $hero_modal_src; ?>&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
							</div>
						</div>
						
				<?php endif; ?>
				
				<?php // Hero Subtitle ?>
				<?php if ( $hero_subtitle ) : ?>
						<h5>
							<?php echo $hero_subtitle; ?>
						</h5>
				<?php endif; ?>
				
				<?php // Hero Button ?>
				<?php if ( $hero_btn_link ) : ?>
					<div class="btn btn-default hero-btn">
						<a href="<?php echo $hero_btn_link; ?>">Learn More</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>