<footer class="content-info" role="contentinfo">
	<div class="footer-top">
		<div class="container">
			<?php dynamic_sidebar('sidebar-footer'); ?>
			<div class="row">
				<div class="col-sm-5">
					<div class="footer-brand">Autobahn Adventures</div>
					<div class="footer-phone">(714) 964-0280</div>
					<a href="" class="btn btn-info footer-contact-btn">Contact Us</a>
					<div class="social-icons">
						<a href="https://www.facebook.com/pages/Autobahn-Adventures/322732429048" class="social-icn facebook"><span class="socicon socicon-facebook"></span></a>
						<a href="https://twitter.com/AutobahnAdv" class="social-icn twitter"><span class="socicon socicon-twitter"></span></a>
						<a href="https://www.youtube.com/user/autobahnadventures" class="social-icn youtube"><span class="socicon socicon-youtube"></span></a>
					</div>					
				</div>
				<div class="col-sm-7">
					<div class="row footer-nav">
						<div class="col-sm-4 footer-nav-col">
							<?php wp_nav_menu( array(
										'theme_location'  	=> 'footer_col_1',
										'walker'      		=> new Walker_Nav_Menu, )
									); ?>
						</div>
						<div class="col-sm-4 footer-nav-col">
							<?php wp_nav_menu( array(
										'theme_location'  	=> 'footer_col_2',
										'walker'      		=> new Walker_Nav_Menu, )
									); ?>
						</div>	
						<div class="col-sm-4 footer-nav-col">
							<?php wp_nav_menu( array(
										'theme_location'  	=> 'footer_col_3',
										'walker'      		=> new Walker_Nav_Menu, )
									); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<span class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></span>
			<a class="scrolltop" href="">Back to Top ^</a>
		</div>
	</div>
</footer>

