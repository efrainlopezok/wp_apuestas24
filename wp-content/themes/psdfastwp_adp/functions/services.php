<?php



/*-----------------------------------

Shortcode [services]

-----------------------------------*/

function wp_list_services($content = null) {
	ob_start();

	  $args = array( 
	  'post_type' => 'servicio', 
	  'post_status' => 'publish',
	  'posts_per_page' => -1,);
	  $wp_query = new WP_Query($args);
	  if($wp_query->have_posts()) :
	  	while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			<article class="clearfix">
		 		<?php $imageUrlServiceIcon = get_field('service_icono');  ?>
		 		<?php the_post_thumbnail(); ?>
		 		<div class="wrapper_content_service">
		 			<img class="icon_service" src="<?php echo $imageUrlServiceIcon['url']; ?>" alt="">
		 			<h3><?php the_title(); ?></h3>
		 			<?php the_excerpt(); ?>
		 			<a class="btn_default" href="<?php the_permalink(); ?>"><span>Más Información</span></a>

		 		</div>	  		

 			</article>

		<?php
		endwhile;
		wp_reset_postdata();?>
		<?php
	  endif;
	?>

	<?php

	$content = ob_get_contents();

	ob_end_clean();

	return $content;  

}

add_shortcode('services', 'wp_list_services');



/*-----------------------------------
Shortcode [services_home]
-----------------------------------*/

function wp_list_services_home($content = null) {
	ob_start();
	  $args = array( 
	  'post_type' => 'servicio', 
	  'post_status' => 'publish',
	  'posts_per_page' => 5,);
	  $wp_query = new WP_Query($args);
	  if($wp_query->have_posts()) : $i = 0;
	  	?>
	  	<ul class="row-grid">
	  	<?php
	  	while ($wp_query->have_posts()) : $wp_query->the_post(); $i++; ?>
	  		<li class="column-3 list_service_home" id="service_home_<?php echo $i; ?>">
			<a class="link_content_service" href="<?php echo add_query_arg( 'service', $i, 'areas-de-practica' ); ?>"><img src="<?php the_field('icono_servicio_inicio'); ?>" alt="<?php the_title(); ?>">
 			<div class="title_service"><?php the_title(); ?></div>
 			<div class="content_service"><?php the_excerpt_max_charlength(80); ?></div></a>
 			<a class="hvr_next_horizontal" href="<?php echo add_query_arg( 'service', $i, 'areas-de-practica' ); ?>"><?php _e('Ver más', 'apuestas_deportivas'); ?></a>
 			</li>
		<?php
		endwhile;
		?>
		</ul>
		<?php
		wp_reset_postdata();?>
		<?php
	  endif;
	?>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  

}
add_shortcode('services_home', 'wp_list_services_home');