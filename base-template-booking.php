<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

	<!--[if lt IE 8]>
		<div class="alert alert-warning">
			<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
		</div>
	<![endif]-->
	
	<div class="wrap" role="document">
	
		<section class="header funnel-header">
			<?php do_action('get_header'); ?>
			<div class="container">
				<a class="block float-left" href="<?php echo home_url(); ?>/">
					<img alt="Autobahn Adventures Logo" src="<?php echo get_template_directory_uri(); ?>/assets/img/site-logo.png" class="site-logo">
				</a>
			</div>
		</section>
				
		<div class="container">
			<div class="main">
				<?php 
					// Get page specific content
					include roots_template_path();
				?>
			</div>
		</div>
		
		<section class="footer funnel-footer">
			<?php get_template_part('templates/footer'); ?>
		</section>
		
	</div><!-- /.wrap -->

	<?php wp_footer(); ?>
	
</body>
</html>
