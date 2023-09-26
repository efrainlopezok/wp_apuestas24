<?php
/*-----------------------------------
Shortcode [slider]
-----------------------------------*/
function wp_custom_slider($atts, $content = null) {
	$a = shortcode_atts(['id' => ''], $atts);
	ob_start();
	$args = [
		'post_type' => 'slider_adp',
		'post_status' => 'publish',
		'p' => $atts['id'],
		'posts_per_page' => 1
	];
	$wp_query = new WP_Query($args);
	if($wp_query->have_posts()) :
		while ($wp_query->have_posts()) : $wp_query->the_post();
			if( have_rows('item_slider_adp') ): ?>
				<div class="wrapper_container_rs_slider">
				    <div class="rslides_container">
						<ul class="rslides" id="sliderADP">
		                    <?php while ( have_rows('item_slider_adp') ) : the_row(); ?>
							<?php $slideradpbg='';
								if( get_sub_field('slider_adp_nobg')==false ){
									$slideradpbg='sliderNoBg';
								} ?>
							<li class="itemsSliderADP <?php echo $slideradpbg; ?>">
								<img src="<?php the_sub_field('slider_adp_imagen'); ?>" alt="">
							<?php $slidenobg_close='';
								if( $slideradpbg=='sliderNoBg'){
									if ( get_sub_field( 'slider_adp_link_image' ) ) :
										$slidenobg = get_sub_field( 'slider_adp_link_image' );
										$slidenobg_url = $slidenobg['url'];
										$slidenobg_target = $slidenobg['target'];
										$slidenobg_close = '</a>';
								?>
								<a <?php echo $slidenobg_target; ?> href="<?php echo $slidenobg_url; ?>">
								<?php endif; } ?>
		                    		<div class="wrapper_slider">
										<div class="content_info_slider">
											<?php if( get_sub_field('slider_adp_titulo') ): ?>
												<h3><?php the_sub_field('slider_adp_titulo'); ?></h3>
											<?php endif; ?>
											<span><?php the_sub_field('slider_adp_texto'); ?></span>
											<div class="content_btns_sliders">
												<?php
													if ( get_sub_field( 'slider_adp_link_1' ) ) :
													$button = get_sub_field( 'slider_adp_link_1' );
													$button_label = $button['text'];
													$button_url = $button['url'];
													$button_target = $button['target'];
													?>
													<a target="<?php echo $button_target; ?>" href="<?php echo $button_url; ?>"><?php echo $button_label; ?></a>
													<?php
													endif;
													if ( get_sub_field( 'slider_adp_link_2' ) ) :
													$button = get_sub_field( 'slider_adp_link_2' );
													$button_label = $button['text'];
													$button_url = $button['url'];
													$button_target = $button['target'];
													?>
													<a class="blue" target="<?php echo $button_target; ?>" href="<?php echo $button_url; ?>"><?php echo $button_label; ?></a>
													<?php
													endif;
												?>
											</div>
										</div>
									</div>
									<?php echo $slidenobg_close; ?>
		                    	</li>
		                    <?php endwhile; ?>
						</ul>
				    </div>
				</div>
                <script>
					jQuery(document).ready(function($){
				       $("#sliderADP").responsiveSlides({
				        auto: true,
				        pager: true,
				        nav: false,
				        speed: 800,
				        timeout: 8000,
				        maxwidth: 1024,
				        namespace: "centered-btns"
				      });
					});
                </script>
                <?php
			else :
			endif;
		endwhile;
		wp_reset_postdata();
	endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('slider', 'wp_custom_slider');

/*-----------------------------------
Shortcode [slider_casa_apuesta]
-----------------------------------*/
function wp_custom_slider_casa_apuesta($atts, $content = null) {
	if( have_rows('item_slider_adp') ): ?>
	    <div class="rslides_container_fixed">
			<ul class="rslides" id="sliderADP">
	            <?php while ( have_rows('item_slider_adp') ) : the_row(); ?>
	            	<li class="itemsSliderADP" style="background-image: url('<?php the_sub_field('slider_adp_imagen'); ?>');">
	            		<div class="wrapper_slider">
							<div class="content_info_slider">
								<header>
									<figure><?php the_post_thumbnail(); ?></figure>
									<?php $value = get_field( "puntuacion" ); ?>
									<div class="value_rating">Rating <?php echo do_shortcode('[star number='. $value .']'); ?> <?php the_field( 'puntuacion' ); ?>/5</div>
								</header>
								<?php if( get_sub_field('slider_adp_titulo') ): ?>
									<h3><?php the_sub_field('slider_adp_titulo'); ?></h3>
								<?php endif; ?>
								<span><?php the_sub_field('slider_adp_texto'); ?></span>
								<?php
									if ( get_sub_field( 'slider_adp_link_1' ) ) :
									$button = get_sub_field( 'slider_adp_link_1' );
									$button_label = $button['text'];
									$button_url = $button['url'];
									$button_target = $button['target'];
									?>
									<a target="<?php echo $button_target; ?>" href="<?php echo $button_url; ?>"><?php echo $button_label; ?></a>
									<?php
									endif;
								?>
								<?php
									if ( get_sub_field( 'slider_adp_link_2' ) ) :
									$button = get_sub_field( 'slider_adp_link_2' );
									$button_label = $button['text'];
									$button_url = $button['url'];
									$button_target = $button['target'];
									?>
									<a class="blue" target="<?php echo $button_target; ?>" href="<?php echo $button_url; ?>"><?php echo $button_label; ?></a>
									<?php
									endif;
								?>
							</div>
						</div>
	            	</li>
	            <?php endwhile; ?>
			</ul>
	    </div>
	<script>
		jQuery(document).ready(function($){
	       $("#sliderADP").responsiveSlides({
	        auto: true,
	        pager: true,
	        nav: false,
	        speed: 800,
	        timeout: 8000,
	        maxwidth: 760,
	        namespace: "centered-btns"
	      });
		});
	</script>
	<?php
	else :
	endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('slider_casa_apuesta', 'wp_custom_slider_casa_apuesta');
