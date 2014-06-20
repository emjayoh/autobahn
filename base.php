<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

	<!--[if lt IE 8]>
		<div class="alert alert-warning">
			<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
		</div>
	<![endif]-->
	
	<div class="wrap" role="document">
	
		<section class="header normal-header">
			<?php do_action('get_header'); ?>
			<?php get_template_part('templates/header-top-navbar'); ?>
		</section>
		
		<?php get_template_part('templates/section', 'hero'); ?>
		
		<div class="container">
			<div class="main">
				<?php 
					// Get page specific content
					include roots_template_path();
				?>
			</div>
		</div>
		
		<section class="footer">
			<?php get_template_part('templates/footer'); ?>
		</section>
		
	</div><!-- /.wrap -->

	<?php wp_footer(); ?>
	  <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KG5V9N"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KG5V9N');</script>
<!-- End Google Tag Manager -->
</body>
</html>
