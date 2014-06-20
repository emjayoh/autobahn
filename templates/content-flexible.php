<?php //while (have_posts()) : the_post();

		//echo '<pre style="background-color: black; opacity: 1; color: green; z-index:999999; position: relative;">';
		//	print_r( $featured_item );
		//echo '</pre>';

?>
	
	<!--Flex Content-->
	<?php if( get_field('flex_content') ): ?>
	 
		<?php while( have_rows('flex_content') ) : the_row(); ?>
	 
			<?php if( get_row_layout() == 'flex_row_heading_lg' ): // type: Large Heading ?>
	 
				<div class="row flex-heading-lg">
					<h3 class="col-xs-12">
						<?php the_sub_field('flex_heading_lg'); ?>
					</h3>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_heading_md' ): // type: Medium Heading ?>
	 
				<div class="row flex-heading-md">
					<h4 class="col-sm-8">
						<?php the_sub_field('flex_heading_md'); ?>
					</h4>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_wysiwyg' ): // type: WYSIWYG ?>
	 
				<div class="flex-wysiwyg">
					<?php the_sub_field('flex_wysiwyg_wysiwyg'); ?>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_video_modal' ): // type: Video Modal
			
				$modal_ID = 'modal-' . rand(10000 , 99999);
			
				$video_modal_src = '//www.youtube.com/embed/' . get_sub_field('flex_video_link') . '?rel=0;&amp;vq=hd1080&amp;controls=1&amp;showinfo=0&amp;modestbranding=1';
			
			?>
			
				<!-- Button trigger modal -->
				<div class="movie-modal flex-video-modal">
					<div data-toggle="modal" data-target="#<?php echo $modal_ID; ?>">
						<span class="glyphicon glyphicon-play-circle"></span>
						<span><?php the_sub_field('flex_video_txt'); ?></span>
					</div>
				</div>
			
				<!-- Modal -->
				<div class="modal fade" id="<?php echo $modal_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="fitVids">
								<iframe width="640" height="360" src="<?php echo $video_modal_src; ?>" data-src="<?php echo $video_modal_src; ?>&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_paragraph' ): // type: Paragraph ?>
	 
				<div class="row flex-paragraph">
					<p class="col-sm-10">
						<?php the_sub_field('flex_paragraph'); ?>
					</p>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_showcase_boxes' ): // type: Showcase Boxes ?>
			
				<div class="row flex-showcase-boxes">
					<div class="col-xs-12">
						
						<?php if( have_rows('flex_showcase_box') ): ?>
							
							<div class="showcase-boxes">
														
								<?php 
								
									$boxNum = 1;
								
									while ( have_rows('flex_showcase_box') ) : the_row();
								
										$box_img = get_sub_field('flex_showcase_box_img');
										$box_title = get_sub_field('flex_showcase_box_title');
										$box_text = get_sub_field('flex_showcase_box_txt');
										$box_btn = get_sub_field('flex_showcase_box_btn');
										$box_btn_txt = get_sub_field('flex_showcase_box_btn_txt');
										switch ( get_sub_field('flex_showcase_box_btn_linkto') ){
											case 'Internal':
												$box_btn_link = get_sub_field('flex_showcase_box_btn_link_internal');
												$box_btn_link = get_permalink( $box_btn_link->ID );
												break;
											case 'External':
												$box_btn_link = get_sub_field('flex_showcase_box_btn_link_external');
												break;
										}
								
								?>
								
									<?php
									
										if( $boxNum % 3 == 1 ){ echo '<div class="boxes-row clearfix">'; }
										
									?>
								
								
										<div class="showcase-box col-sm-4">
											<a class="aspect-4-3 hover-btn hover-btn-learn-more" href="<?php echo $box_btn_link; ?>">
												<div class="bg-cover" style="background-image: url('<?php echo $box_img; ?>');"></div>
											</a>
											<div class="showcase-title">
												<a href="<?php echo $box_btn_link; ?>"><?php echo $box_title; ?></a>
											</div>
											<div class="showcase-text">
												<span><?php echo $box_text; ?></span>
											</div>
											<div class="btn btn-primary showcase-box-btn">
												<a href="<?php echo $box_btn_link; ?>"><?php echo $box_btn_txt; ?></a>
											</div>
										</div>
										
									<?php
									
										if( $boxNum % 3 == 0 ){ echo '</div>'; }
										$boxNum++; 
									
									?>
								
								<?php endwhile; ?>
								
								</div>
							
							</div>
						
						<?php endif; ?>
						
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_full_width_img' ): // type: Full Width Image ?>
	 
				<div class="row full-row flex-full-width-img">
					
					<img src="<?php the_sub_field('flex_full_width_img'); ?>">
					
					<?php if(get_sub_field('flex_full_width_overlay_txt')) : ?>
						<div class="text-overlay"><?php the_sub_field('flex_full_width_overlay_txt'); ?></div>
					<?php endif; ?>
					
					<?php if(get_sub_field('flex_full_width_overlay_grid')) : ?>
						<div class="bg-tile bg-grid-overlay"></div>
					<?php endif; ?>
					
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_img_paragraph' ): // type: Image Left, Paragraph Right ?>
	 
				<div class="row flex-img-paragraph">
					<div class="col-sm-4 vcenter">
						<img src="<?php the_sub_field('flex_img_paragraph_pic'); ?>">
					</div>
					<div class="col-sm-6 vcenter">
						<p><?php the_sub_field('flex_img_paragraph_txt'); ?></p>
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_paragraph_img' ): // type: Image Right, Paragraph Left ?>
	 
				<div class="row flex-paragraph-img">
					<div class="col-sm-6 vcenter">
						<p><?php the_sub_field('flex_paragraph_img_txt'); ?></p>
					</div>
					<div class="col-sm-4 vcenter">
						<img src="<?php the_sub_field('flex_paragraph_img_pic'); ?>">
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_two_images' ): // type: Two Images ?>
	 
				<div class="row flex-two-images">
					<div class="col-sm-6">
						<div class="aspect-16-9">
							<div class="bg-cover" style="background-image: url('<?php the_sub_field('flex_two_images_1'); ?>');"></div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="aspect-16-9">
							<div class="bg-cover" style="background-image: url('<?php the_sub_field('flex_two_images_2'); ?>');"></div>
						</div>
					</div>
				</div>
	 
			<?php elseif( get_row_layout() == 'flex_row_three_featured_items' ): // type: Three Featured Item Boxes ?>
			
				<div class="row flex-featured-boxes">
					<div class="col-xs-12">
						
						<?php if( have_rows('flex_featured_items') ): ?>
							
							<ul class="featured-boxes">
							
								<?php while ( have_rows('flex_featured_items') ) : the_row(); 
								
									$featured_item = get_sub_field('flex_featured_item');
									$box_img = get_field('static_hero_img', $featured_item->ID);
									$box_title = $featured_item->post_title;
									$box_subtitle	= '<span class="uppercase">' . 'By ' . '<span class="gold">'
													. get_the_author_meta( 'display_name', $featured_item->post_author )
													. '</span>' . ' on '
													. get_the_time('m.d.Y', $featured_item->ID) . '</span>';
									$box_text = $featured_item->post_excerpt;
									$box_btn_link = get_permalink( $featured_item->ID );
								
								?>
								
									<li class="featured-box col-sm-4">
										<a class="aspect-4-3" href="<?php echo $box_btn_link; ?>">
											<div class="bg-cover" style="background-image: url('<?php echo $box_img; ?>');"></div>
										</a>
										<div class="featured-title">
											<span><?php echo $box_title; ?></span>
										</div>
										<div class="featured-subtitle">
											<span><?php echo $box_subtitle; ?></span>
										</div>
										<div class="featured-text">
											<span><?php echo $box_text; ?></span>
										</div>
										<div class="btn btn-primary showcase-box-btn">
											<a href="<?php echo $box_btn_link; ?>">Read More</a>
										</div>
									</li>
								
								<?php endwhile; ?>
							
							</ul>
						
						<?php endif; ?>
						
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_horizontal_rule' ): // type: Horizontal Rule
				
				$hr_style	= 'margin-top: ' . get_sub_field('flex_horizontal_rule_pad_top') . 'px; '
							. 'margin-bottom: ' . get_sub_field('flex_horizontal_rule_pad_bot') . 'px; '
							. 'height: ' . get_sub_field('flex_horizontal_rule_height') . 'px; '
							. 'background-color: ' . get_sub_field('flex_horizontal_rule_color') . '; '
							. 'border: 0;';
							
				$hr_class	= 'flex-horizontal-rule';
				if( get_sub_field('flex_horizontal_rule_full_width') == true)
					$hr_class .= ' full-row';
			
			?>
				
				<hr style="<?php echo $hr_style; ?>" class="<?php echo $hr_class; ?>">
				
			<?php elseif( get_row_layout() == 'flex_row_vid_embed' ): // type: Embedded Video
				
				$vid_link	= get_sub_field('flex_embed_vid_link');
				$vid_txt	= get_sub_field('flex_embed_vid_overlay_txt');
			?>
			<div class="flex-video-embed aspect-16-9">
					<iframe style="width: 100%;" src='//www.youtube.com/embed/<?php echo $vid_link; ?>?rel=0;&amp;vq=hd1080&amp;controls=1&amp;showinfo=0&amp;modestbranding=1';></iframe>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_reviews_caurosel' ): // type: Reviews Caurosel
				
				$caurosel_objects = get_sub_field('flex_reviews_caurosel_items');
			
				if( $caurosel_objects ): ?>
				
					<div class="flex-reviews-caurosel full-row">
				
						<div id="reviews-carousel" class="carousel slide row" data-ride="carousel" data-interval="8000">
						
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

			<?php elseif( get_row_layout() == 'flex_row_gravity_form_field' ): // type: Gravity Form ?>
	 
				<div class="flex-gravity-form">

					<?php 
						$form = get_sub_field('flex_row_gravity_form');
						gravity_form_enqueue_scripts($form->id, true);
						gravity_form(	
										$form->id,	//$id_or_title
										false,		//$display_title
										false,		//$display_description
										false,		//$display_inactive
										'',			//$field_values
										true,		//$ajax
										1			//$tabindex
									); 
					?>
					
				</div>
				
			<?php elseif( get_row_layout() == 'flex_row_gallery' ): // type: Gallery
			
				$images = get_sub_field('flex_gallery');
				
			?>
	 
				<div class="flex-gallery">

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

				
			<!--End Flex Types-->
			<?php endif; ?>
	 
		<?php endwhile; ?>
		
	<?php endif; ?>
	<!--End Flex Content-->
	
<?php //endwhile; ?>