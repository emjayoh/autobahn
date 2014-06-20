<?php
/*
Template Name: Page w/ Sidebar
*/
?>

<!--Main Content-->
<div class="row sidebar-page">
	<div class="col-sm-7">
		<?php get_template_part('templates/content', 'page'); ?>
	</div>

	<!--Sidebar-->
	<aside class="sidebar col-sm-5" role="complementary">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-2">
				<?php get_template_part('templates/content-sidebar', 'flexible'); ?>
			</div>
		</div>
	</aside><!-- /.sidebar -->
</div>