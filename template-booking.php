<?php
/*
Template Name: Booking
*/
?>

<?php 

	//echo '<pre style="background-color: black; opacity: 1; color: green; z-index:999999; position: relative;">';
	//	print_r( $post );
	//echo '</pre>';
	
	$bookingID = get_the_ID();
		
	$form = get_field('booking_form');
	// Build WP_Query for tour ID passed in URL
	$tour_slug = sanitize_title( $_GET[ 'tourId' ] );
	//$tour_id = preg_replace( '/[^0-9]/', '', $_GET[ 'tourId' ] ); // 129
	$args = array(
		'name' => $tour_slug,
		'post_type' => 'tour',
	);
	$tour_query = new WP_Query( $args );
	
?>

<?php if ( have_posts() ) : while ( $tour_query->have_posts() ) : $tour_query->the_post(); ?>

	<h3><?php the_title(); ?></h3>

	<!-- Nav tabs -->
	<ul class="booking-nav clearfix">
		<li class="active"><a href="#gform_page_2_1">Start</a></li>
		<li><a href="#gform_page_2_2">Info</a></li>
		<li class="disabled"><a href="#gform_page_2_3">Preferences</a></li>
		<li class="disabled"><a href="#gform_page_2_4">Summary</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="booking-tabs">
		<div class="booking-tab active" id="start">
			<div class="booking-section" id="start-section-1">
				<div class="row">
					<div class="col-sm-4 col-sm-push-8 vcenter">
						<div class="tour-style-box uppercase">		
							<?php // Build tour date strings
							$start_date_unix	= get_field('tour_start_date', $tour_query->ID) / 1000;
							$end_date_unix		= get_field('tour_end_date', $tour_query->ID) / 1000;
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
									<li><strong><?php the_field('tour_approx_distance', $tour_query->ID); ?></strong> KM</li>
									<li class="divider">.</li>
									<li><strong><?php echo $numDays; ?></strong> Days</li>
									<li class="divider">.</li>
									<li><strong><?php echo $numNights; ?></strong> Nights</li>
									<li class="divider">.</i></li>
									<li><?php the_field('tour_car', $tour_query->ID); ?></li>
								</ul>
							</div>
							<hr>
							<div class="price textfill">
								<span><?php the_field('tour_cost', $tour_query->ID); ?> Per Person</span>
							</div>
							<hr>
							<div class="countries">
								<span><?php echo implode( ', ', get_field('tour_countries', $tour_query->ID) ); ?></span>
							</div>
							<hr class="red">
						</div>
					</div>
					<div class="col-sm-8 col-sm-pull-4 vcenter">
						<h4>Let's get the booking process started!</h4>
						<p><?php the_field('tour_intro_paragraph', $bookingID); ?></p>
						<h4>What you'll need</h4>
						<ul class="list-unstyled">
							<li>Driver's License</li>
							<li>Emergency Contact</li>
						</ul>
						<div class="btn btn-default first-form-tab">Start Booking</div>
					</div>
				</div>
			</div>
			<hr class="full-row">
			<div class="booking-section" id="start-section-2">
				<h3 class="no-txt-transform">What your tour includes</h3>
				<p>Accommodation including breakfast, most dinners and wine in some of Europe’s most luxurious hotels. Porsche factory, museum and shop. Use of the latest model Porsche 911 including gas for the planned itinerary and full car insurance with a € 2000 maximum liability ( € 7500 - Italy / France with restrictions ). Each car comes equipped with a navigation system pre-programmed in English. You will drive over several Alpine passes, the Autobahn and experience driving through some of the most spectacular scenery in Europe.</p>
				<!--<div class="btn btn-link" data-toggle="collapse" data-target="#tour-includes-details">
					<span>Details v</span>
				</div>
				<div id="tour-includes-details" class="collapse">
					<h4>Porsche 911</h4>
					<p>Bacon ipsum dolor sit amet hamburger meatball pork loin shoulder capicola, pancetta short loin kevin tail ribeye swine. Strip steak kielbasa landjaeger, prosciutto t-bone pastrami bresaola tongue chuck. Hamburger pork loin kevin, ham doner chuck pork chop leberkas. Turkey ham hock tri-tip doner leberkas shankle pork beef ribs. Pork belly filet mignon drumstick frankfurter. Pork filet mignon fatback, hamburger ball tip sirloin andouille spare ribs shankle beef shank prosciutto pork chop corned beef. Brisket pork tongue andouille porchetta short loin.</p>
					<h4>Accomodations & More</h4>
					<ul class="list-unstyled">
						<li>9 days, 7 night's luxury accomodation (See hotel list)</li>
						<li>7 breakfasts and 5 dinners including beer and wine</li>
						<li>Entry into the hotels' spa areas</li>
						<li>Porsche factory, Museum, and Goodie Store</li>
						<li>A detailed road book and so much more</li>
					</ul>
					<div><strong>Note:</strong> All drivers must be a min of 25 years old with 3 years driving experience and a valid license. You must present 1 major credit card to cover any additional costs associated with the rental car.</div>
					<div>( Excess kilometers @ approx 1 Euro per km, Damage, etc ).</div>
				</div>-->
			</div>
			<hr class="full-row">
			<div class="booking-section" id="start-section-3">
				<h3 class="no-txt-transform">What's not included</h3>
				<p>Air transportation, travel insurance, hotel extras, fines etc and excess kilometers above what are included or any other items not specified on the itinerary. Personal expenses are not included in the cost of the trip and remain the personal obligation of each participant. Each participant must check out with the cashier of each hotel prior to departure to assure that all personal expenses, if any, have been settled with the hotel.</p>
				<!--<div class="btn btn-link" data-toggle="collapse" data-target="#tour-excluded-details">
					<span>Details v</span>
				</div>
				<div id="tour-excluded-details" class="collapse">
					<p>Autobahn Adventures, and our handling agents, assume no liability for expenses due to delay and/or changes in air/or other services. All such losses or expenses will have to be borne by the passenger, as tour rates provide for arrangements only for the time stated. In the unlikely event that the services and accommodations set forth herein cannot be supplied, or in the event there is a deviation in the itinerary due to causes beyond the control of Autobahn Adventures, we will supply comparable accommodations and no refund will be made. The tour member waives any claim against Autobahn Adventures or our representatives for any damage to or loss of property, of injury to or death of persons due to any act of negligence of any hotel or any person rendering any of the services and accommodations included in the ground portion of the itinerary.</p>
					<div><strong>Note:</strong> Travel insurance with trip cancellation is recommended, as no refunds are possible after February 1st, 2014</div>
				</div>-->
			</div>
			<hr class="full-row">
			<div class="booking-section" id="start-section-4">
				<h4>Let's get the booking process started!</h4>
				<div class="btn btn-default first-form-tab">Start Booking</div>
			</div>
		</div>
		<?php 
			gravity_form_enqueue_scripts($form->id, true);
			gravity_form($form->id, true, true, false, '', true, 1); 
		?>
	</div>

	<?php
	//echo '<pre style="background-color: black; opacity: 1; color: green; z-index:999999; position: relative;">';
	//print_r( $post );
	//echo '</pre>';
	?>
		

<?php endwhile; endif; ?>


<?php // Restore original Post Data
	wp_reset_postdata();
?>