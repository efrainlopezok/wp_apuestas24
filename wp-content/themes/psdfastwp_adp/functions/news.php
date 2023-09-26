<?php

/*-----------------------------------
Shortcode [news]
-----------------------------------*/
function wp_custom_news($content = null) {
	ob_start();
		$args = array(
	  	'post_type' => 'post',
	  	'post_status' => 'publish',
	  	'posts_per_page' => 6,);
	  	$wp_query = new WP_Query($args); ?>
	  	<?php if($wp_query->have_posts()) :  $i = 0 ?>
	  		<ul class="row-grid no-margin">
	  		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i++; ?>
	  			<li class="column-3 no-padding list_news_home" id="news_home_<?php echo $i; ?>">
	  				<div class="content">
	  					<div class="date_content">
	  						<div class="date"><?php date_post(); ?></div>
		  					<h3><?php the_title(); ?></h3>
		  					<p><?php the_excerpt_max_charlength(72); ?></p>
		  					<a href="<?php the_permalink(); ?>"><?php _e('Leer más', 'apuestas_deportivas'); ?></a>
	  					</div>
	  				</div>
	  			</li>
 			<?php endwhile; wp_reset_postdata(); ?>
	  		</ul>
	  	<?php endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('news', 'wp_custom_news');

/*-----------------------------------
Shortcode [news_home]
-----------------------------------*/
function wp_custom_newsHome($content = null) {
	ob_start();

		$args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
			'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'partidos-probabilidades',
					'value' => 'null',
                    'compare' => '!='
                )
            )
		);

	  	$wp_query = new WP_Query($args); ?>
	  	<?php if($wp_query->have_posts()) :  ?>
	  		<div class="news_day">
	  		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

	  			<article class="list_item_news content_info<?php echo $i; ?>">
	  				<figure><?php the_post_thumbnail() ?></figure>
	  				<header><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></header>
	  				<?php the_excerpt(); ?>
	  				<footer>
	  					<a class="btn_default green" href="<?php the_permalink(); ?>">Leer más</a>

						<?php $post_object = get_field('casadeapuestas');
                        if( $post_object ):
                            $post = $post_object;
                            setup_postdata( $post ); ?>
                            	<span class="btn_default white">Bono $ <?php echo get_post_meta(get_the_ID(), 'wpcf-bono', true); ?></span>
 							<?php wp_reset_postdata();
                        endif; ?>


	  				</footer>
	  			</article>
 			<?php endwhile; wp_reset_query(); ?>
	  		</div>
	  	<?php endif; ?>
	  	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
//add_shortcode('news_home', 'wp_custom_newsHome');
