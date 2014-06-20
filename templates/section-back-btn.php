<?php // Back Button
	
	$post_type = $post->post_type;
	if($post_type == 'post'){
		$parent_url = site_url('blog/');
		$parent_title = 'the Blog';
	}else{
		$parent_id = $post->post_parent;
		if( $parent_id ){
			$parent_url = get_permalink( $parent_id );
			$parent_title = get_the_title( $parent_id );
		}else{
			$parent_slug = get_post_type_object( $post_type )->rewrite[slug];
			$parent_url = get_site_url() . '/' . $parent_slug;
			$parent_title = get_page_by_path($parent_slug)->post_title;
		}
	}	
	
	if( $parent_url && $parent_title ) : ?>
		<div class="main-back-btn uppercase">
			<a href="<?php echo $parent_url; ?>">< Back to <?php echo $parent_title; ?></a>
		</div>
<?php endif; ?>