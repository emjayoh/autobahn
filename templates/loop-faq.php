<?php global $archive_query; ?>

<?php get_template_part('templates/section', 'back-btn'); ?>

<?php get_template_part('templates/content', 'page'); ?>

<div class="faq-archive">

<?php 
	$faq_groups = array(	'payment' => 'Payment',
							'included' => "What's Included",
							'traveling' => 'Traveling',
							'driving' => 'Driving',			);
							
	$leftCol = true;
	
	$faq_query = array();
	

	
	foreach( $faq_groups as $group_slug => $group_html ) :
	
			$args = array(	'posts_per_page'   => -1,
							'offset'           => 0,
							'category'         => '',
							'orderby'          => 'post_date',
							'order'            => 'ASC',
							'include'          => '',
							'exclude'          => '',
							'meta_key'         => 'faq_category',
							'meta_value'       => $group_slug,
							'post_type'        => 'faq',
							'post_mime_type'   => '',
							'post_parent'      => '',
							'post_status'      => 'publish',
							'suppress_filters' => true				);
	
			$faq_query[$group_slug] = get_posts($args);
	
	endforeach;
	
		//echo '<pre style="background-color: black; opacity: 1; color: green; z-index:999999; position: relative;">';
			//print_r( $faq_query['payment'] );
		//echo '</pre>';
		
?>

<div class="faq-toc">
	<?php	// Table of Contents
		foreach( $faq_groups as $group_slug => $group_html ) :
			if( $faq_query[$group_slug] ) :
	?>
			
				<?php if( $leftCol ) : ?><div class="row"><?php endif; ?>
				
				
					<div class="col-sm-6">
						<div class="faq-title">
							<?php echo $group_html; ?>
						</div>
						<ul div class="faq-items">
						
							<?php foreach( $faq_query[$group_slug] as $post ) : ?>
							
								<li><a href="#<?php echo $post->post_name; ?>"><?php the_title(); ?></a></li>
							
							<?php endforeach; ?>
						
						</ul>
					</div>
					
				<?php if( !$leftCol ) : ?></div><?php endif; ?>
			
	<?php
				$leftCol = $leftCol ? false : true;
			endif;
		endforeach;
	?>
</div>


<div class="faq-list">
	<?php	// FAQ List
		foreach( $faq_groups as $group_slug => $group_html ) :
		
			if( $faq_query[$group_slug] ) :
	?>			
					<div class="faq-list-section">
						<div class="faq-title">
							<?php echo $group_html; ?>
						</div>
						<ul div class="faq-items archive-posts">
						
							<?php foreach( $faq_query[$group_slug] as $post ) : ?>
							
								<li class="archive-post faq faq-item" id="<?php echo $post->post_name; ?>">
									<div class="question"><?php the_title(); ?></div>
									<div class="answer"><?php echo apply_filters('the_content', $post->post_content ); ?></div>
								</li>
							
							<?php endforeach; ?>
						
						</ul>
					</div>
					
				<?php if( !$leftCol ) : ?></div><?php endif; ?>
			
	<?php
			endif;
		endforeach;
	?>
</div>

</div>