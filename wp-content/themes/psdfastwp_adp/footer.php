<footer class="footer">

	<div class="custom_footer">
		<div class="wrapper">
			<div class="row-grid">

				<div class="column-4">
					<p><img src="<?php the_field('logo_footer', 'option'); ?>" alt=""></p>
				 	<?php the_field('texto_footer', 'option'); ?>
				</div>

				<div class="column-4">
				    <?php wp_nav_menu( array(
	                    'theme_location' => 'footer',
	                    'menu_class' => 'menu-footer',
	                    'container' => '',
	                    'container_class' => ''
                	));?>
				</div>

				<div class="column-4">
					<div class="widget membresia">
						<?php if ( is_active_sidebar( 'sidebar-membresia' ) ) : ?>
			                <?php dynamic_sidebar( 'sidebar-membresia' ); ?>
			            <?php endif; ?> 
					</div>
				</div>

				<div class="column-4">
				 	<div class="widget">
				 		<h3 class="title_widget"><?php _e('Redes sociales', 'apuestas_deportivas'); ?></h3>
				 		<div class="social_media_footer clearfix">
		                    <ul class="social_media_list clearfix">
		                        <?php if( get_field('url_facebook', 'option') ) { ?>
		                        <li><a href="<?php the_field('url_facebook', 'option'); ?>" target="_black"><i class="icon-facebook"></i></a></li>
		                        <?php } ?>
		                        <?php if( get_field('url_twitter', 'option') ) { ?>
		                        <li><a href="<?php the_field('url_twitter', 'option'); ?>" target="_black"><i class="icon-twitter"></i></a></li>
		                        <?php } ?>
		                    </ul>
				 		</div>
				 	</div>
				</div>
	    	</div>
	    </div>
    </div>

	<section class="footer_copyright">
		<div class="wrapper clearfix">
			<div class="widget">
				<?php the_field('copyright_footer', 'option'); ?>
			</div>
		</div>
	</section>

</footer>

</div>
</div>


<?php wp_footer(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom_script.js?v=102"></script>

</body>
</html>