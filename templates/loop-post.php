<?php global $archive_query; ?>

<div class="inner-top-nav full-row top-row posts-nav clearfix">
	<ul class="posts-menu row">
		<li><a class="active" href="#featured-posts" >Featured Posts</a></li>
		<li><a href="#all-posts">All Posts</a></li>
	</ul>
	<div class="search-posts">
		<?php get_search_form(); ?>
	</div>
</div>

<?php get_template_part('templates/content', 'page'); ?>

<div class="row posts-archive">
	<div class="col-sm-7">
		<ul class="archive-posts">
		
			<?php while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
						
				<li class="archive-post post <?php echo $current_tour ? 'featured' : null; ?>">
					<?php get_template_part('templates/content', get_post_type()); ?>
				</li>
				
			<?php endwhile; ?>
			
		</ul>
	</div>

	<!--Sidebar-->
	<aside class="sidebar col-sm-5" role="complementary">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-2">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</aside><!-- /.sidebar -->
</div>