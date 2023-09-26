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
