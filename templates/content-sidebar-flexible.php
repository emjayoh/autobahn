<?php while (have_posts()) : the_post(); ?>
	
	<!--Flex Content-->
	<?php if( get_field('flex_sidebar') ): ?>
	 
		<?php while( have_rows('flex_sidebar') ) : the_row(); ?>
	 
			<?php if( get_row_layout() == 'flex_side_row_phone' ): // type: Phone Number
			
				$ph_num = get_sub_field('flex_side_ph');
			
			?>
	 
				<div class="flex-side-ph">
					<div class="sidebar-heading">
						<span>Phone</span>
					</div>
					<div class="sidebar-txt">
						<span><?php echo $ph_num; ?></span>
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_side_row_email' ): // type: Email
			
				$email = get_sub_field('flex_side_email');
			
			?>
	 
				<div class="flex-side-email">
					<div class="sidebar-heading">
						<span>Email</span>
					</div>
					<div class="sidebar-txt">
						<a href="mailto:<?php echo $email; ?>">
							<span><?php echo $email; ?></span>
						</a>
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_side_row_link' ): // type: Text Link
			
				$title = 	get_sub_field('flex_side_link_heading');
				$text = 	get_sub_field('flex_side_link_txt');
				$location = get_sub_field('flex_side_link_location');
				
				switch ( $location ){
					case 'Internal':
						$link = get_sub_field('flex_side_link_object');
						$link = get_permalink( $link->ID );
						break;
					case 'External':
						$link = get_sub_field('flex_side_link_url');
						break;
				}
			
			?>
	 
				<div class="flex-side-txt-link">
					<div class="sidebar-heading">
						<span><?php echo $title; ?></span>
					</div>
					<div class="sidebar-txt">
						<a href="<?php echo $link; ?>">
							<span><?php echo $text; ?></span>
						</a>
					</div>
				</div>
				
			<?php elseif( get_row_layout() == 'flex_side_row_sm_img_links' ): // type: Small Image Links
			
				$title = 			get_sub_field('flex_side_sm_img_links_heading');
				$links_repeater = 	get_sub_field('flex_side_sm_img_links');
			
			?>
	 
				<div class="flex-side-sm-img-links">
					<div class="sidebar-heading">
						<span><?php echo $title; ?></span>
					</div>
					<div class="sidebar-img-links">
						
						<?php if( have_rows('flex_side_sm_img_links') ): ?>

							<?php while ( have_rows('flex_side_sm_img_links') ) : the_row();
							
								$image	=	get_sub_field('flex_side_sm_img_links_img');
								$url	=	get_sub_field('flex_side_sm_img_links_url');
							
							?>
							
								<a class="img-link" href="<?php echo $url; ?>">
									<img src="<?php echo $image; ?>">
								</a>

							<?php endwhile; ?>
							
						<?php endif; ?>
						
					</div>
				</div>
				
				
			<!--End Flex Types-->
			<?php endif; ?>
	 
		<?php endwhile; ?>
		
	<?php endif; ?>
	<!--End Flex Content-->
	
<?php endwhile; ?>