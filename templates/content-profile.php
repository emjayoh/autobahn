<?php

	if(!$boxNum) $boxNum = 1;
	
	$box_img = get_field('static_hero_img');
	$box_title = get_the_title();
	$box_subtitle	= '<span class="uppercase">' . 'By ' . '<span class="gold">'
					. get_the_author_meta( 'display_name' )
					. '</span>' . ' on '
					. get_the_time('m.d.Y') . '</span>';
	$box_text = get_the_excerpt();
	$box_btn_link = get_permalink();
	$box_btn_txt = 'Learn More';

?>

		<div class="archive-post profile showcase-box col-sm-4">
			<a class="aspect-4-3" href="<?php echo $box_btn_link; ?>">
				<div class="bg-cover" style="background-image: url('<?php echo $box_img; ?>');"></div>
			</a>
			<div class="showcase-title">
				<span><?php echo $box_title; ?></span>
			</div>
			<div class="showcase-text">
				<span><?php echo $box_text; ?></span>
			</div>
			<div class="btn btn-primary showcase-box-btn">
				<a href="<?php echo $box_btn_link; ?>"><?php echo $box_btn_txt; ?></a>
			</div>
		</div>
		
<?php

	if( $boxNum % 3 == 0 ){ echo '</div><div class="boxes-row clearfix">'; }
	$boxNum++; 

?>