<?php
/*-----------------------------------
Shortcode [customers]
-----------------------------------*/

function wp_list_customers($content = null) {
	ob_start();
	  $args = array( 
	  'post_type' => 'cliente', 
	  'post_status' => 'publish',
	  'posts_per_page' => 1,);
	  $wp_query = new WP_Query($args);
	  if($wp_query->have_posts()) :
	  	while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

	  	<?php if( ! empty(get_field('mostrar_no_mostrar') ) ) : ?>

		<section class="list_customers">
			<div class="wrapper">
		  		<div class="wrapper_content_excerpt">
		  			<h3><?php the_title(); ?></h3>
		  			<?php the_field('cliente_excerpt'); ?>
		  		</div>
		  		<?php
	                if( have_rows('lista_clientes') ): ?>
	                	<div class="owl-carousel slider_clientes">
	                    <?php while ( have_rows('lista_clientes') ) : the_row(); ?>
	                    	<?php $imageUrlCustomers = get_sub_field('cliente_logo');  ?>
							<?php $urlCustomers = get_sub_field( "cliente_url" ); ?>
							<div class="content_item_customers">
								<img src="<?php echo $imageUrlCustomers['url']; ?>" alt="" title="<?php the_sub_field('cliente_nombre'); ?>">
							</div>
	                    <?php endwhile; ?>
	                	</div>
	            <?php else : endif; ?>
			</div>
		</section>

		<?php endif; ?>

		<?php
		endwhile;
		wp_reset_postdata();
	  endif;
	?>

	<script>
		jQuery(document).ready(function($){ 
		  $('.slider_clientes').owlCarousel({
		      loop: true,
		      margin: 10,
		      dots: false,
		      nav: true,
		      navText: ["<i class='icon-prev'></i>","<i class='icon-next'></i>"],
		      responsiveClass: true,
		      responsive: {
		        0: {
		          items: 1,
		          nav: true
		        },

		        600: {
		          items: 2,
		          nav: true
		        },
		        1000: {
		          items: 5,
		          nav: true,
		        }
		      }
		  })
		});               	

	</script>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  

}

add_shortcode('customers', 'wp_list_customers');