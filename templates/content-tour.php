<div class="row">
	<div class="col-sm-4 archive-thumbnail-outer vcenter">
		<a href="<?php the_permalink(); ?>" class="archive-thumbnail-inner aspect-4-3">
			<div class="bg-cover" style="background-image: url('<?php the_field('static_hero_img'); ?>');"></div>
		</a>
	</div>
	
	<div class="col-sm-8 archive-content-box vcenter">
	
		<h6 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
		<div class="h7 subtitle">
		
			<?php // Build tour date range string
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
			?>
			
			<span class="dates"><?php echo $date_range; ?></span>
			<span class="divider hidden-xs"> | </span>
			<span class="locations"><?php echo implode( ', ', get_field('tour_countries') ); ?></span>
		</div>
		<div class="blurb">
			<?php the_excerpt(); ?>
		</div>
		<div class="btn btn-primary archive-more-btn">
			<a href="<?php the_permalink(); ?>">Learn More</a>
		</div>
		
	</div>
</div>