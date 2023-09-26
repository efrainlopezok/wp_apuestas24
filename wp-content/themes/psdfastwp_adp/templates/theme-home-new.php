<?php
/* Template Name: Template - Inicio Nuevo */
get_header(); ?>

<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">

		<?php //echo do_shortcode('[slider]'); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!-- <h1><?php //the_title(); ?></h1> -->
			<?php the_content(); ?>
		<?php endwhile; else: ?>
            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
		<?php endif; ?>

		<?php echo do_shortcode('[show_betting_highlighted]') ?>

	<h2 class="section-title">Noticias del dia</h2>
	<div class="content_block_info">
		<?php //echo do_shortcode('[news_home]') ?>
		<?php

        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
        if (!isset($_GET["s"])) {
            $_GET["s"] = '';
        }

		$args = array(
            'post_type' => 'post',
			'post_status' => 'publish',
            'posts_per_page' => 8,
            'paged' => $_GET['page_id_all'],
            'meta_query' => array(
                array(
                    'key' => 'partidos-probabilidades',
					'value' => 'null',
                    'compare' => '!='
                )
            )
		);

	  	$custom_query = new WP_Query($args); ?>
	  	<?php if($custom_query->have_posts()) :  ?>
	  		<div class="news_day">
	  		<?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

	  			<article class="list_item_news content_info<?php echo $i; ?>">
	  				<figure><?php the_post_thumbnail('thumbnail-news-home') ?></figure>
						<?php $post_date = get_the_date( 'd/m/Y' ); ?>
						<header><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<h5 class="date_item_news"><?php echo $post_date; ?></h5>
						</header>
	  				<?php the_excerpt(); ?>
	  				<footer class="news clearfix">
	  					<a class="btn_default green" href="<?php the_permalink(); ?>">Leer más</a>

						<?php $post_object = get_field('casadeapuestas');
                        if( $post_object ):
                            $post = $post_object;
                            setup_postdata( $post ); ?>

								<?php $metaBono = get_post_meta( get_the_ID(), 'wpcf-bono', true );
								    if ($metaBono == '') {
								    } else {
								        ?>
								        <span class="btn_default white">Bono <?php echo $metaBono ?></span>
								        <?php
								    }
								?>

                            	<?php if( empty( get_post_meta(get_the_ID(), 'wpcf-bono', true ) ) ) : ?>

                            	<?php endif; ?>
                            	<span class="btn_default_image"><a target="_blank" href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" title="<?php the_title(); ?>" ><?php the_post_thumbnail() ?></a></span>
 							<?php
                        endif; ?>
	  				</footer>
	  			</article>
 			<?php endwhile; wp_reset_query(); ?>
	  		</div>

	  	<?php endif; ?>

        <?php
         $qrystr = '';
        // pagination start
            if ($custom_query->found_posts > get_option('posts_per_page')) {
                echo "<nav class='pagination'><ul>";
                     if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
                    echo px_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr);
                echo "</ul></nav>";
            }
        // pagination end
        ?>


	</div>

			<?php echo do_shortcode('[estract_probabilidades]') ?>




			<?php //echo do_shortcode('[show_claims]') ?>

		</div>
		<div class="adp_sidebar">
			<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
                <div class="clearfix">
                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                </div>
            <?php endif; ?>
						<p style="font-size: 11px;">*Resultados en vivo por <a title="Livescore.in" href="http://www.livescore.in/es/" target="_blank">Livescore.in</a></p>
		</div>

	</div>
</section>



<?php get_footer(); ?>
