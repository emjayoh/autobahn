<div>
	<div class="row">
		<div class="col-sm-6">
			<h6 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
		</div>
	</div>
		
	<div class="subtitle uppercase">
		<span>By <span>
		<span class="gold"><?php the_author(); ?></span>
		<span> on </span>
		<span><?php the_time('m.d.Y'); ?></span>
	</div>

	<div class="long-excerpt">
		<?php the_content(); ?>
	</div>
	
	<div class="archive-comments">
		<span><?php echo get_comments_number(); ?></span><span class="gold uppercase">&nbsp;Comments</span>
	</div>
		
	<div class="btn btn-primary archive-more-btn">
		<a href="<?php the_permalink(); ?>">Read More</a>
	</div>
</div>