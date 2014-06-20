<?php get_template_part('templates/section', 'back-btn'); ?>
<?php get_template_part('templates/content', 'flexible'); ?>

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