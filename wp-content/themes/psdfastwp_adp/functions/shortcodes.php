<?php

/*-----------------------------------
Shortcode [show_header]
-----------------------------------*/

function wp_header_pages($content = null) {
	ob_start(); ?>
		<?php
			$imageUrlHeaderPage = get_field('page_imagen');
			$titlePages = explode(' | ', get_field('page_titulo'));
		?>
		<section class="header_pages" style="background-image: url('<?php echo $imageUrlHeaderPage['url']; ?>');">
			<div class="wrapper">
				<span><?php the_field('page_textos'); ?></span>
				<h1>
				<?php
					if( count($titlePages)){
					    foreach($titlePages as $value){
					        echo trim($value);
					        echo "<br> ";
					    }
					}
				 ?>
				 </h1>
			</div>
		</section>
    <?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('show_header', 'wp_header_pages');

/*-----------------------------------
Shortcode [show_claims]
-----------------------------------*/

function wp_list_claims($content = null) {
	ob_start();
	$args = array(
	'post_type' => 'ticket',
	'post_status' => 'processing',
	'posts_per_page' => 10,);
	$wp_query = new WP_Query($args); ?>
	<?php if($wp_query->have_posts()) : ?>

	<h3 class="section-title">Reclamos de nuestros Usuarios</h3>
	<div class="content_block_info">
		<div class="wrapper_claims">

		<ul class="list_claims clearfix">
			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			<li class="column-3"><div class="layer">
 			<h3>Reclamo - <?php the_ID(); ?></h3>
 			<?php $terms_district = get_the_term_list( $post->ID, 'field_c_a', '', ', ', '' ) ;?>
 			<h5><?php echo strip_tags($terms_district); ?></h5>
 			<span><?php custom_format_date_claims(); ?></span>
 			<br>
 			<?php
 				$content = get_the_content();
				echo substr($content, 0, 100);
				echo "...";
			?>
 			<span class="author"><?php //the_author(); ?></span>
 			</div>
 			</li>
 			<?php endwhile; ?>
		</ul>
		<?php wp_reset_postdata(); ?>

		</div>
	</div>

	<a class="btn_default green center" href="<?php echo esc_url( home_url( '' ) ); ?>/reclamos">Ver todo los reclamos</a>

	<?php endif; ?>

	<script>
		$('.list_claims').slick({
		  dots: true,
		  infinite: false,
		  autoplay: true,
		  speed: 300,
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  responsive: [
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		  ]
		});
	</script>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('show_claims', 'wp_list_claims');

/*-----------------------------------
Shortcode [all_claims]
-----------------------------------*/

function wp_list_all_claims($content = null) {
	ob_start();


    $tipoEvento = "";
    if(isset($_GET["casa_apuesta"])) {
        $tipoEvento = $_GET["casa_apuesta"];
    }

	$args = array(
		'post_type' => 'ticket',
		'post_status' => 'processing',
		'posts_per_page' => 12,
        'paged' => $_GET['page_id_all'],
	);

	if($tipoEvento != "") {
		$args['tax_query'] = array(
		array(
			'taxonomy' => 'field_c_a',
			'field' => 'id',
			'terms' => $tipoEvento
		)
	);
	}

    if (empty($_GET['page_id_all']))
        $_GET['page_id_all'] = 1;
    if (!isset($_GET["s"])) {
        $_GET["s"] = '';
    }

	$loop = new WP_Query($args);
	if($loop->have_posts()) :
	?>

<div class="itemsSliderADP">
	<div class="content_info_slider">
	<a class="blue" target="" href="<?php echo esc_url( home_url( '' ) ); ?>/enviar-ticket//">Registrar un reclamo</a>
	</div>
</div>

    <div class="wrapper-prob-full">
    <div class="wrapper_header_page_probabilidades clearfix">
    <span class="label_filter">Filtrar por:</span>
    <form method="GET">
        <select name="casa_apuesta" class="select-full">
            <option value="">Todas las Casas</option>
            <?php
            $terms = get_terms( 'field_c_a', array('hide_empty' => true,) );
            foreach($terms as $term) : ?>
                <option value="<?php echo $term->term_id; ?>" <?php echo ($term->term_id == $tipoEvento ? "selected" : ""); ?>><?php echo $term->name ?></option>
            <?php
            endforeach;
            ?>
        </select>

    </form>
    </div>
</div>

	<h3 class="section-title">Reclamos de nuestros usuarios</h3>

		<div class="wrapper_all_claims">
			<div class="row__grid">

			<?php while ($loop->have_posts()) : $loop->the_post(); ?>
				<?php $term_casa = get_the_term_list( $loop->ID, 'field_c_a', '', ', ', '' ) ;?>
				<?php $term_casa1 = get_the_term_list( $post->ID, 'field_c_a', '', ', ', '' ) ;?>
				<div class="column__3">
					<article class="content_info_calims">
					<div class="content_claims_article">
			 			<h3>Reclamo - <?php the_ID(); ?></h3>
			 			<?php $terms_district = get_the_term_list( $post->ID, 'field_c_a', '', ', ', '' ) ;?>
			 			<h5><?php echo strip_tags($terms_district); ?></h5>
			 			<span class="date"><?php custom_format_date_claims(); ?></span>
			 			<br>
			 			<?php
			 				$content = get_the_content();
							echo substr($content, 0, 150);
							echo "...";
						?>
			 			<span class="author"><?php //the_author(); ?></span>

			 			<br>
			 		</div>
			 		<a href="<?php the_permalink(); ?>"> Ver detalles</a>
					</article>
	 			</div>
	 		<?php endwhile;?>
			</div>
		</div>

		<?php
		wp_reset_postdata();
	endif;

	?>

<?php
 $qrystr = '';
    if ($loop->found_posts > get_option('posts_per_page')) {
        echo "<nav class='pagination'><ul>";
             if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
            echo px_pagination($loop->found_posts,get_option('posts_per_page'), $qrystr);
        echo "</ul></nav>";
    }
?>

<script>
    $(document).ready(function() {
        var $selectTipoEvento = $("select[name=casa_apuesta]");
        $selectTipoEvento.change(function() {
            $selectTipoEvento.parent().submit();
        });
    });
</script>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('all_claims', 'wp_list_all_claims');

/*-----------------------------------
Shortcode [show_verified_bh]
-----------------------------------*/

function wp_list_verified_BH($content = null) {
	ob_start();
	$args = array(
		'post_type' => 'casa-apuesta',
		'post_status' => 'publish',
		'posts_per_page' => 3,
	    'meta_query' => array(
			array(
				'key' => 'casa_de_apuesta',
				'value' => '1',
				'compare' => 'LIKE'
		))
	);
	$wp_query = new WP_Query($args);
	if($wp_query->have_posts()) :
		?>
		<ul class="list_claims clearfix">
		<?php
		while ($wp_query->have_posts()) : $wp_query->the_post();
			?>

 			<?php
		endwhile;
		?>
		</ul>
		<?php
		wp_reset_postdata();
	endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('show_verified_bh', 'wp_list_verified_BH');

/*-----------------------------------
Shortcode [show_betting_highlighted]
-----------------------------------*/

function wp_list_betting_highlighted($content = null) {
	ob_start();
	$args = array(
		'post_type'     => 'casa-apuesta',
		'post_status'   => 'publish',
		'meta_query' => array(
			array(
				'key' => 'casa_de_apuesta_destacado',
				'value' => '1',
				'compare' => 'LIKE'
		)),
        'orderby' => 'meta_value_num',
        'meta_key' => 'puntuacion',
        'order' => 'DESC',
	);
	$wp_queryPost = new WP_Query($args);
	if($wp_queryPost->have_posts()) :  ?>
		<h2 class="section-title">Casas de apuestas destacadas</h2>
		<div class="content_block_info">
			<div class="wrapper__table_ca">
			<?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post(); ?>
			<ul class="list__table__ca">
				<li title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></li>
	        	<li><span><?php echo get_post_meta(get_the_ID(), 'wpcf-bono', true); ?></span></li>
	        	<li><span><?php the_field( 'puntuacion' ); ?>/5 <i class="icon-star"></i></span></li>
	        	<li class="ca_li_responsive"><span><a href="<?php the_permalink(); ?>"><span class="replace_icons">Más info</span><i title="Más información" class="icon-more"></i></a></span></li>
	        	<li class="cell_bkg ca_li_responsive"><span><a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" ><span class="replace_icons">Ir a la web</span><i title="Ir a la web" class="icon-next"></i></a></span></li>
	            </li>
			</ul>
			<?php endwhile;
			wp_reset_query(); ?>
			</div>
			<div class="wrapper__btn_all">
				<a href="<?php echo site_url(); ?>/ranking" class="btn_default_link border_b">Ver todas las casas</a>
			</div>
		</div>
	<?php
    endif; ?>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('show_betting_highlighted', 'wp_list_betting_highlighted');

/*-----------------------------------
Shortcode [news_day]
-----------------------------------*/

function wp_list_news_day_home($content = null) {
	ob_start(); ?>

	<h3 class="section-title">Noticias del dia</h3>
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
            'posts_per_page' => 5,
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
	  				<header><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></header>
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

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

//add_shortcode('news_day_home', 'wp_list_news_day_home');
