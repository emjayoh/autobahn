<?php get_template_part('templates/section', 'back-btn'); ?>

<div class="inner-top-nav full-row top-row posts-nav clearfix">
	<ul class="posts-menu row">
		<li><a class="active" href="#overview">Overview</a></li>
		<li><a href="#journey">Journey</a></li>
		<li><a href="#accommodations">Accommodations</a></li>
		<li><a href="#scenery">Scenery</a></li>
	</ul>
	<div class="book-now"><?php
		
			$args = array(
				'sort_order' => 'ASC',
				'sort_column' => 'post_title',
				'hierarchical' => 0,
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-booking.php',
				'number' => 1,
				'post_type' => 'page',
				'post_status' => 'publish'
			); 
			$booking_id = 	get_pages($args)[0]->ID;
			$book_url = 	add_query_arg( array(
											'tourId' => $post->post_name,
											), get_permalink( $booking_id ) );
		?>
		
		<a class="btn btn-default" href="<?php echo $book_url; ?>">
			<span>Book Now</span>
		</a>
		
	</div>
</div>



<div id="overview">
	<div class="row tour-intro">
		<div class="col-sm-4 col-sm-push-8 vcenter">
			<div class="tour-style-box uppercase">		
				<?php // Build tour date strings
				$start_date_unix	= get_field('tour_start_date') / 1000;
				$end_date_unix		= get_field('tour_end_date') / 1000;
				$start_date 		= [	'month' => date('M', $start_date_unix),
										'day' => date('d', $start_date_unix),
										'year' => date('Y', $start_date_unix)	];
				$end_date 			= [	'month' => date('M', $end_date_unix),
										'day' => date('d', $end_date_unix),
										'year' => date('Y', $end_date_unix)	];
				
				
				$date_range	= $start_date['month'] . ' ' . $start_date['day'];
				if( $start_date['year'] != $end_date['year'] ){ $date_range .= ', ' . $start_date['year']; }
				$date_range .= ' - ';
				if( $start_date['month'] != $end_date['month'] ){ $date_range .= $end_date['month'] . ' '; }
				$date_range .= $end_date['day'];
				$date_range .= ', ' . $end_date['year'];
				
				$timeDiff = abs($end_date_unix - $start_date_unix);
				$numNights = floor($timeDiff/86400);  // 86400 seconds in one day
				$numDays = $numNights + 1;
				?>
				
				<div class="dates textfill">
					<span><?php echo $date_range; ?></span>
				</div>
				<div class="days textfill">
					<span><?php echo $numDays; ?>.Days</span>
				</div>
				<hr>
				<div class="textfill-ul">
					<ul class="list-unstyled details">
						<li><strong><?php the_field('tour_approx_distance'); ?></strong> KM</li>
						<li class="divider">.</li>
						<li><strong><?php echo $numDays; ?></strong> Days</li>
						<li class="divider">.</li>
						<li><strong><?php echo $numNights; ?></strong> Nights</li>
						<li class="divider">.</i></li>
						<li><?php the_field('tour_car'); ?></li>
					</ul>
				</div>
				<hr>
				<div class="price textfill">
					<span><?php the_field('tour_cost'); ?> Per Person</span>
				</div>
				<hr>
				<div class="countries">
					<span><?php echo implode( ', ', get_field('tour_countries') ); ?></span>
				</div>
				<hr class="red">
			</div>
		</div>
		<div class="col-sm-8 col-sm-pull-4 vcenter">
			<h3><?php the_title(); ?></h3>
			<h4><?php the_field('tour_overview_subtitle'); ?></h4>
			<div><?php the_content(); ?></div>
		</div>
	</div>
</div>

<hr class="full-row">

<div id="journey">

	<h3>The Journey...</h3>
	<p><?php the_field('tour_journey_txt'); ?></p>
	
	<?php 
	
	$legs = get_field('tour_legs');
	if($legs) :
	
	?>
	<div class="sliding-top-nav">
		<ul class="journey-menu row">
		
			<?php foreach($legs as $num => $leg) : ?>
				<li>
					<a <?php if(!$num) echo 'class="active"'; ?> href="#leg-<?php echo $num + 1; ?>" data-toggle="tab">
						<div class="tab-top"><?php echo $leg['tour_leg_days']; ?></div>
						<div class="tab-bottom"><?php echo $leg['tour_leg_country']; ?></div>
					</a>
				</li>
			<?php endforeach; ?>
		
		</ul>
	<hr class="nav-divider">
	</div>

	<?php endif; ?>

	<?php if( have_rows('tour_legs') ): ?>
	
	<div class="tab-content">

		<?php $num = 0; while ( have_rows('tour_legs') ) : the_row(); ?>
		
			<div class="tab-pane fade <?php if(!$num) echo 'in active'; ?>" id="leg-<?php echo $num + 1; ?>">
			
				<div class="row flex-two-images leg-images">
					<div class="col-sm-6">
						<div class="aspect-16-9">
							<div class="bg-cover" style="background-image: url('<?php the_sub_field('tour_leg_img_1'); ?>');"></div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="aspect-16-9">
							<div class="bg-cover" style="background-image: url('<?php the_sub_field('tour_leg_img_2'); ?>');"></div>
						</div>
					</div>
				</div>
				
				<?php if( have_rows('tour_leg_segments') ): ?>
					
					<div class="leg-segments">

						<?php while ( have_rows('tour_leg_segments') ) : the_row(); ?>
						
							<div class="leg-segment">

								<div class="row">
									<div class="col-sm-4">
										<div class="leg-segment-title">
											<span><?php the_sub_field('tour_leg_segment_title'); ?></span>
										</div>
										<div class="leg-segment-subtitle">
											<span><?php the_sub_field('tour_leg_segment_subtitle'); ?></span>
										</div>
									</div>
									<div class="col-sm-8">
										<div class="leg-segment-txt">
											<span><?php the_sub_field('tour_leg_segment_txt'); ?></span>
										</div>
									</div>
								</div>
							
							</div>

						<?php endwhile; ?>

					</div>
					
				<?php endif; ?>
					
			</div>

		<?php $num++; endwhile; ?>
		
	</div>

	<?php endif; ?>
		
	<?php
		$args = array(
			'posts_per_page'   => 4,
			'orderby'          => 'rand',
			'order'            => 'DESC',
			'post_type'        => 'review',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		$caurosel_objects = get_posts( $args );

		if( $caurosel_objects ):
	?>
	
		<div class="flex-reviews-caurosel full-row">
			<div id="reviews-carousel" class="carousel slide row" data-ride="carousel">
			
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php foreach( $caurosel_objects as $key => $value) : ?>
						<li data-target="#reviews-carousel" data-slide-to="<?php echo $key; ?>" <?php if( $key == 0 ) echo 'class="active"'; ?>></li>
					<?php endforeach; ?>
				</ol>
				
				<!-- Previous Control -->
				<div class="col-sm-1 vcenter">
					<a class="left carousel-control" href="#reviews-carousel" data-slide="prev">
						<div class="chevron-left"><</div>
					</a>
				</div>
			
				<!-- Wrapper for slides -->
				<div class="col-sm-10 vcenter">
					<div class="carousel-inner">
						<?php 
							$caurosel_count = 0;
							foreach( $caurosel_objects as $post): // variable must be called $post (IMPORTANT)
						
							$review_auth_override	= get_field('review_author_override');
							$review_stars			= floatval( get_field('review_stars') );
							$review_auth_img		= get_field('review_author_img');
							
							$review_author = $review_auth_override ? $review_auth_override : get_the_author_meta( 'display_name' );
						?>

							<?php setup_postdata($post); ?>
							<div class="review item<?php if($caurosel_count == 0) echo ' active'; ?>">
								<div class="author">
									<?php echo $review_author; ?>
								</div>
								<div class="row review-content">
									<div class="col-sm-2">
										<div class="aspect-square">
											<div class="bg-cover" style="background-image: url('<?php echo $review_auth_img; ?>');"></div>
										</div>
										<div class="rating">
											<?php for( $i = 5; $i > 0; $i-- ) : ?>
												<span><?php echo $review_stars >= $i ? ★ : ☆; ?></span>
											<?php endfor; ?>
										</div>
									</div>
									<div class="col-sm-10">
										<a class="title" href="<?php the_permalink(); ?>">
											<span><?php the_title(); ?></span>
										</a>
									</div>
								</div>
								<div class="excerpt">
									<?php the_excerpt(); ?>
								</div>
								<div class="full-link">
									<a href="<?php the_permalink(); ?>">> Full Review</a>
								</div>
							</div>
								
						<?php
							$caurosel_count++;
							endforeach;
						?>
					</div>
				</div>
				
				<!-- Next Control -->
				<div class="col-sm-1 vcenter">
					<a class="right carousel-control" href="#reviews-carousel" data-slide="next">
						<div class="chevron-right">></div>
					</a>
				</div>
			</div>
		</div>
				
	<?php
		wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
		endif;
	?>

</div>	

<div id="accommodations">

	<h3>Where You'll Stay</h3>
	<p><?php the_field('tour_accommodations_txt'); ?></p>
	
	<?php 

	$hotels = get_field('tour_hotels');

	if( $hotels ): ?>
	
		<div class="sliding-top-nav">
			<ul class="accommodations-menu row">
				<?php $first = true; foreach( $hotels as $hotel ): ?>
					<li>
						<a <?php if($first) echo 'class="active"'; ?> href="#<?php echo $hotel->post_name; ?>" data-toggle="tab">
							<div class="tab-top"><?php echo get_the_title( $hotel->ID ); ?></div>
							<div class="tab-bottom"><?php the_field('hotel_country', $hotel->ID); ?></div>
						</a>
					</li>
				<?php $first = false; endforeach; ?>
			</ul>
			<hr class="nav-divider">
		</div>
		
		
		<div class="hotel-tabs">
			
			<div class="tab-content">
			
				<?php $first = true; foreach( $hotels as $hotel ): ?>
					<div class="tab-pane fade<?php if($first) echo ' in active'; ?>" id="<?php echo $hotel->post_name; ?>">

						<!--Hotel Tab Carousel-->
						<div class="aspect-16-9"><div class="bg-cover">
						<?php 

						$images = get_field('hotel_images', $hotel->ID);
						 
						if( $images ): ?>
						<div id="<?php echo $hotel->post_name; ?>-carousel" class="carousel slide" data-ride="carousel">
							
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php foreach( $images as $num => $image ): ?>
									<li 
										data-target="#<?php echo $hotel->post_name; ?>-carousel"
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
														<span><?php echo get_the_title( $hotel->ID ); ?></span>
													</div>
												</div>
										</div></div>
									</div>
								<?php endforeach; ?>
							</div>
							

							<!-- Controls -->
							<a class="left carousel-control" href="#<?php echo $hotel->post_name; ?>" data-slide="prev">
								<div class="chevron-left"><</div>
							</a>
							<a class="right carousel-control" href="#<?php echo $hotel->post_name; ?>" data-slide="next">
								<div class="chevron-right">></div>
							</a>
							
						</div>
						
						</div></div>
						<?php endif; ?>
						
						<!--Hotel Tab Below-Carousel Content-->
						<?php
							$post = $hotel; // variable must be called $post
							setup_postdata($post);
						?>
						<?php // Content
							get_template_part('templates/content', 'flexible');
						?>
						<?php wp_reset_postdata(); ?>
						
						<?php if( get_field('hotel_site_url') ) : ?>
							<div>
								<a href="<?php the_field('hotel_site_url'); ?>">
									<span class="gold">> Hotel Website</span>
								</a>
							</div>
						<?php endif; ?>

					</div>
				<?php $first = false; endforeach; ?>
				
			</div>
			
		</div>
		
	<?php endif; ?>
	
</div>

<div id="scenery">

	<div class="row full-row flex-full-width-img">
		<img src="/wp-content/uploads/2014/05/scenery.jpg">
		<div class="text-overlay">Don't forget to watch the road</div>
		<div class="bg-tile bg-grid-overlay"></div>
	</div>
	
	<div class="flex-gallery">
			<?php 
			 
			$images = get_field('tour_gallery');
			 
		//echo '<pre style="background-color: black; opacity: 1; color: green; z-index:999999; position: relative;">';
			//print_r( $images );
		//echo '</pre>';
			 
			$index = 1;
			foreach( $images as $image) : ?>
			
			<?php if( $index % 2 ) : ?>
				<div class="row gallery-row <?php echo $index > 4 ? 'hidden' : 'visible'; ?>">
			<?php endif; ?>
				
				<div class="col-sm-6">
					<div class="aspect-16-9">
						<div class="bg-cover" style="background-image: url('<?php echo $image['url']; ?>');"></div>
					</div>
				</div>
				
			<?php if( ! ($index % 2) ) : ?>
				</div>
			<?php endif; ?>

			<?php $index++; endforeach; ?>
			
			<?php if( $index > 8 ) : ?>
			
				<!--<div class="gallery-load-btn">
					<a href="#">Load More Photos</a>
				</div>-->
			
			<?php endif; ?>
	</div>

</div>




<hr class="full-row">

<div class="linear-nav clearfix">

	<div class="linear-nav-link float-left">
		<span class="uppercase gold">
			<?php previous_post_link( '%link', '< %title' ); ?>
		</span>
	</div>
	
	<div class="linear-nav-link float-right">
		<span class="uppercase gold">
			<?php next_post_link( '%link', '%title >' ); ?>
		</span>
	</div>
	
</div>
