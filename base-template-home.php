<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

	<!--[if lt IE 8]>
		<div class="alert alert-warning">
			<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
		</div>
	<![endif]-->
	
	<div class="wrap" role="document">
	
		<section class="header fixed-header">
			<?php do_action('get_header'); ?>
			<?php get_template_part('templates/header-top-navbar'); ?>
		</section>
	
		<?php include roots_template_path(); ?>
		
		<section class="section footer onepage-footer">
			<?php get_template_part('templates/footer'); ?>
		</section>
		
	</div><!-- /.wrap -->

	<?php wp_footer(); ?>
	
</body>
</html>
