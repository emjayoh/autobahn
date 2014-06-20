<?php get_template_part('templates/section', 'back-btn'); ?>

<?php while (have_posts()) : the_post(); ?>

<div class="row">
	<div class="col-sm-7">
		<article <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<div class="entry-meta">
				<?php get_template_part('templates/entry-meta'); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
			</footer>
			<hr>
			<?php comments_template('/templates/comments.php'); ?>
		</article>
	</div>
	
	<!--Sidebar-->
	<aside class="sidebar col-sm-5" role="complementary">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-2">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</aside>
	<!-- /.sidebar -->
</div>

<?php endwhile; ?>

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