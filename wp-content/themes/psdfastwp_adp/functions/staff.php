<?php
/*-----------------------------------
Shortcode [customers]
-----------------------------------*/

function wp_list_staff($content = null) {
	ob_start();
	  $args = array( 
	  'post_type' => 'staff', 
	  'post_status' => 'publish',
	  'posts_per_page' => -1,);
	  $wp_query = new WP_Query($args);
	  if($wp_query->have_posts()) :
	  	echo "<div class='wrapper_list_staff'><ul class='row-grid'>";
	  	while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			<li class="column-3 line_h_staff">
				<a href="<?php the_permalink(); ?>">
 					<?php the_post_thumbnail('thumbnail-staff'); ?>
 					<h3><?php the_title(); ?></h3>
 				</a>
			</li>
		<?php
		endwhile;
		wp_reset_postdata();
		echo "<ul></div>";
	  endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}

add_shortcode('show_staff', 'wp_list_staff');