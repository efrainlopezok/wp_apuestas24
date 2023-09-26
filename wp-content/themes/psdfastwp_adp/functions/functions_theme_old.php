<?php



// Custom widget
function widgets_custom(){   
	require_once __DIR__ . '/widgets/banner.php';
    register_widget('Widget_customBanner');   
	require_once __DIR__ . '/widgets/slider.php';
    register_widget('Widget_customSlider');  
	require_once __DIR__ . '/widgets/widget-content.php';
	register_widget('Widget_customContent'); 
}
add_action('widgets_init', 'widgets_custom');


// Custom excerpt
function custom_excerpt_length($length) {
	return 35;
}
add_filter('excerpt_length', 'custom_excerpt_length');

add_filter( 'the_excerpt', 'custom_excerpt' );
function custom_excerpt( $text ) {
   if ( strpos( $text, '[&hellip;]') ) {
      $excerpt = str_replace( '[&hellip;]', '[...]', $text );
   } else {
      $excerpt = $text;
   }
   return $excerpt;
}
/*-----------------------------------
Shortcode [opiniones]
-----------------------------------*/
function wp_listOpinion($content = null) {
	ob_start();
	?>
         
      <!--<table class="list-casa-de-apuestas table table-condensed table_D3D3D3">-->
      <table class="custom-table-responsive-1">
		<thead>
        	<tr>
            </tr>
		</thead>
        <tbody>
        <?php
			$args = array( 
			'post_type' => 'casa-apuesta', 
			'posts_per_page' => 10, 
			'post_status' => 'publish',
			'orderby' => 'meta_value_num',
			'meta_key' => 'wpcf-puntaje',
			'order' => 'DESC');
			$wp_queryPost = new WP_Query($args); ?>
        	<?php if($wp_queryPost->have_posts()) :  ?>
            <?php $i = 1; ?>
          	<?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post(); ?>
              <tr>
                <td class="left"><?php echo $i++ ?>.</td>
                <td class="image">              
                <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">
                <?php echo get_the_post_thumbnail($wp_query->ID); ?>
                </a>
                </td>
                <td class="rating"><?php echo get_post_meta(get_the_ID(), 'wpcf-puntaje', true); ?></td>
                <td class="bonus"><?php echo get_post_meta(get_the_ID(), 'wpcf-bono', true); ?></td>
                <td class="read-more-td"><a href="<?php the_permalink(); ?>" title="">Leer más</a></td>
                <td class="right custom-btn-list">
                <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">
                Jugar
                </a>
                </td>
              </tr>
          	<?php endwhile;
			wp_reset_query(); ?>
        	<?php endif; ?>
        </tbody>
        
		<tfoot>
			<tr>
            	<td colspan="6"><a href="<?php echo site_url(); ?>/ranking" class="btn">Ver todos  &gt;&gt;</a></td>
			</tr>
		</tfoot>
      </table>
            
	<?php		
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}
add_shortcode('opiniones', 'wp_listOpinion');

/*-----------------------------------
Shortcode [sliders-ad]
-----------------------------------*/
function wp_listSliderAD($content = null) {
	ob_start();?>
        <?php
			$args = array( 
			'post_type' => 'slider', 
			'posts_per_page' => 10, 
			'post_status' => 'publish');
			$wp_queryPost = new WP_Query($args); ?>
        	<?php if($wp_queryPost->have_posts()) :  ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/ResponsiveSlides/responsiveslides.css" type="text/css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/ResponsiveSlides/responsiveslides.min.js"></script>       
            <div class="rslides_container">
            <ul class="rslides" id="slider">

          	<?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post(); ?>
            <li>
			<?php $meta = get_post_meta( get_the_ID(), 'wpcf-opcion-del-link', true ); ?>
            	
				<?php if( get_post_meta( get_the_ID(), 'wpcf-url-slider', true ) ) { ?>
					<?php if( checked( $meta, 1, false ) ) { ?>
                      <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-slider', true); ?>" target="_blank" rel="nofollow" title="">
                      <?php echo get_the_post_thumbnail($wp_query->ID); ?>
                      </a>
                 	<?php } else { ?>
                       <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-slider', true); ?>" rel="nofollow" title="">
                      <?php echo get_the_post_thumbnail($wp_query->ID); ?>
                      </a>
                	<?php } ?>
				<?php } else {?>
                	<?php echo get_the_post_thumbnail($wp_query->ID); ?>
                <?php } ?>
            
            </li>
          	<?php endwhile;
			wp_reset_query(); ?>
            </ul>
            </div>
            <script>
				$(document).ready(function(){
					jQuery(function () {
						jQuery("#slider").responsiveSlides({
							auto: true,
							pager: true,
							nav: true,
							speed: 800,
							maxwidth: 960,
							namespace: "centered-btns"
						});
					});
				});
            </script>            
        	<?php endif; ?>
	<?php		
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}
//add_shortcode('sliders-ad', 'wp_listSliderAD');

/*-----------------------------------
Shortcode [casaapuestas-ad]
-----------------------------------*/
function wp_listCasaApuestasAD($content = null) {
	ob_start();?>
        <?php
			$args = array( 
			'post_type' => 'casa-apuesta', 
			'posts_per_page' => 10, 
			'post_status' => 'publish');
			$wp_queryPost = new WP_Query($args); ?>
        	<?php if($wp_queryPost->have_posts()) :  ?>
            
			<ul class="list-sidebar-custom">
          	<?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post(); ?>
                <li>
                <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">
                <?php echo get_the_post_thumbnail($wp_query->ID); ?>
                </a>
                </li>
          	<?php endwhile;
			wp_reset_query(); ?>
            </ul>

        	<?php endif; ?>
	<?php		
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}
add_shortcode('casaapuestas-ad', 'wp_listCasaApuestasAD');

/*-----------------------------------
Shortcode [probabilidades]
-----------------------------------*/
function wp_listProbabilidades($content = null) {
	ob_start();

	$tipoEvento = "";
	if(isset($_GET["tipo_evento"])) {
		$tipoEvento = $_GET["tipo_evento"];
	}
	?>
	<form>
		<select name="tipo_evento">
			<option value="">Todas las Ligas</option>
			<?php
			$terms = get_terms( 'tipo-de-evento', array('hide_empty' => true,) ); 
			foreach($terms as $term) : ?>
				<option value="<?php echo $term->term_id; ?>" <?php echo ($term->term_id == $tipoEvento ? "selected" : ""); ?>><?php echo $term->name ?></option>
			<?php
			endforeach;
			?>
		</select>
		<script>
			$(document).ready(function() {
				var $selectTipoEvento = $("select[name=tipo_evento]");
				$selectTipoEvento.change(function() {
					$selectTipoEvento.parent().submit();
				});
			});
		</script>
	</form>
	<br />
	<div class="wrapper-probabilidades"> 
		<!--<table class="list-casa-de-apuestas table table-condensed table_D3D3D3">-->
        <table class="custom-table-responsive">
		<thead>
        <tr>
          <th colspan="2" scope="col">Partidos destacados</th>
          <th scope="col" class="th-001">Liga</th>
          <th scope="col" class="th-002"><span class="valores-por">1 X 2</span><span class="valores-default">1</span></th>
          <th scope="col" class="th-003">X</th>
          <th scope="col" class="th-004">2</th>
        </tr>
		</thead>
        <tbody>
        <?php
			//$custom_terms = get_terms('tipo-de-evento');
			
 	  //foreach($custom_terms as $custom_term) {
		  wp_reset_query();
		  $args = array(
		  
			  'post_type' => 'probabilidades',
			  'posts_per_page' => 15,
			  'post_status' => 'publish',
			  //'orderby' => 'date',
			  'orderby' => 'meta_value_num',
			  'order' => 'DESC',
			  'meta_key' => 'wpcf-fecha-probabilidad',
			  //'tax_query' => array(
			  //	  array(
			  //		  'taxonomy' => 'tipo-de-evento',
			  //		  'field' => 'slug',
			  //		  'terms' => $custom_term->slug,
			  //	  ),
			  //),
		   );
		   if($tipoEvento != "") {
		  	$args['tax_query'] = array(
				array(
					'taxonomy' => 'tipo-de-evento',
					'field' => 'id',
					'terms' => $tipoEvento
				)
			);
		   }
		   $url = get_term_link($custom_term);
		   $loop = new WP_Query($args);
		   if($loop->have_posts()) { ?>
           <?php while($loop->have_posts()) : $loop->the_post();
				$maximum_values = get_max_values_from_pagan_las_casas(get_the_ID());
				$term_list = wp_get_post_terms(get_the_ID(), 'tipo-de-evento', array("fields" => "names"));
?>
              <tr>
                <td class="left-001">
                <?php
					$show_date = get_post_meta(get_the_ID(), 'wpcf-fecha-probabilidad', true);
					//echo date("d-m-Y - H:i", $show_date);
					echo date("d-m-Y", $show_date);
				?>
                </td>
                <td class="left-002"><a href="<?php the_permalink(); ?>" rel="nofollow" title=""><?php the_title($wp_query->ID); ?></a></td>
                <td class="left-003"><?php echo implode(", ", $term_list) ?></td>
                <td class="right-001"><?php echo number_format($maximum_values['max_value_1'], 2); ?></td>
                <td class="right-002"><?php echo number_format($maximum_values['max_value_x'], 2); ?></td>
                <td class="right-003"><?php echo number_format($maximum_values['max_value_2'], 2); ?></td>
              </tr>
          	<?php endwhile;
			wp_reset_query(); ?>
        	<?php    }
	  //} 
		?>
        </tbody>
		<tfoot>
			<tr>
            	<td colspan="6"><a href="http://www.apuestasdeportivas.pe/comparacion-de-probabilidades/" class="btn">Ver todos  &gt;&gt;</a></td>
			</tr>
		</tfoot>
		</table>
	</div>
	<?php		
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}
add_shortcode('probabilidades', 'wp_listProbabilidades');

/**/





/**/

/*-----------------------------------
Shortcode [news-promociones]
-----------------------------------*/
function wp_NewsPromociones($content = null) {
	ob_start();


        ?>
        <!-- -->
 
				<?php
                    if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }

				$args = array( 
						'post_type'     => 'post',
						'post_status'   => 'publish',
						'meta_query' => array(
							array(
								'key' => 'wpcf-check-promociones',
								'value' => '1',
								'compare' => 'LIKE'
						))
				);
				//$args = array_merge($args_cat,$args);
				$custom_query = new WP_Query($args);
                 ?>
                <div class="pix-blog blog-medium">
                <?php if ( $custom_query->have_posts() ): ?>
	                <?php
                    while ( $custom_query->have_posts() ) : $custom_query->the_post();
						 //px_defautlt_artilce();
						 
						 ?>
                         <?php 
						 	global $post,$px_theme_option;
							$img_class = '';
							$image_url = px_attachment_image_src(get_post_thumbnail_id($post->ID), 325, 244);
							if($image_url == ""){
								$img_class = 'no-image';
							}
							?>
								 <article id="post-<?php the_ID(); ?>" <?php post_class($img_class); ?> >
								  <?php if($image_url <> ""){?>
                                  		<div class="clearfix">
										<figure class="image-news-promociones">
										<?php if( get_post_meta($post->ID, 'wpcf-link-imagen', true ) ) { ?>
                                        	<a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-link-imagen', true); ?>" target="_blank">
                                            	<img src="<?php echo $image_url;?>" alt="">
                                            </a>
                                        <?php } else {?>
                                        		<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a> 
                                        <?php } ?>                                        
                                        </figure>
                                        
									<?php }?>
									<div class="text text-news-promociones">
										<h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?></a></h2>
										<p><?php echo px_get_the_excerpt(255,false); ?></p>
									   <div class="blog-bottom clearfix">
									   <?php px_posted_on(true,false,false,false,true,false);?>
									   <a href="<?php the_permalink(); ?>" class="btnreadmore btn pix-bgcolrhvr"><i class="fa fa-plus"></i><?php if(isset($px_theme_option["trans_switcher"]) && $px_theme_option["trans_switcher"] == "on") {  _e("READ MORE",'Kingsclub'); }elseif(isset($px_theme_option["trans_read_more"])){  echo $px_theme_option["trans_read_more"];}?></a>
									   </div>
									</div>
                                    </div>
								</article>
						 
					<?php
					
					 endwhile; 
					 
					  
                         $qrystr = '';
                        // pagination start
                        	if ($custom_query->found_posts > get_option('posts_per_page')) {
                            	echo "<nav class='pagination'><ul>";
                                     if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
									 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
									 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
									 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
									 if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
									 if ( isset($_GET['team-category']) ) $qrystr .= "&team-category=".$_GET['team-category'];
									 if ( isset($_GET['event-tag']) ) $qrystr .= "&event-tag=".$_GET['event-tag'];
									 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
 						        echo px_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr);
                                echo "</ul></nav>";
                            }
                        // pagination end
                    
					 
					  endif;  ?>
        			</div>
        <!-- -->
        <br><br><br>
	<?php
			
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}
//add_shortcode('news-promociones', 'wp_NewsPromociones');

/*-----------------------------------
Shortcode [news-home]
-----------------------------------*/
function wp_NewsHome($content = null) {
	ob_start(); ?>
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	<?php
	$args = array( 
		'post_type' => 'post', 
		'posts_per_page' => 10, 
		'post_status' => 'publish',
		'order' => 'DESC',
	);
			
	$custom_query = new WP_Query($args); ?>
	
    <div class="pix-blog blog-medium">
	
	<?php if ( $custom_query->have_posts() ): 
		while ( $custom_query->have_posts() ) : $custom_query->the_post();
			global $post,$px_theme_option;
			$img_class = '';
			$image_url = px_attachment_image_src(get_post_thumbnail_id($post->ID), 325, 244);
			if($image_url == ""){
				$img_class = 'no-image';
			} ?>
		<!-- ====== START ====== -->
        
		<article id="post-<?php the_ID(); ?>" <?php post_class($img_class); ?> >
			<?php if($image_url <> ""){?>
				<div class="clearfix">
					<figure class="image-news-promociones">
                    <?php if( get_post_meta($post->ID, 'wpcf-link-imagen', true ) ) { ?>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-link-imagen', true); ?>" target="_blank">
                    	<img src="<?php echo $image_url;?>" alt="">
                    </a>
                    <?php } else {?>
                    	<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a> 
                    <?php } ?>                                        
					</figure>
					<?php }?>
					<div class="text text-news-promociones">
                    	<h2 class="pix-post-title">
                    	<a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?></a>
                    	</h2>
                    	<p><?php echo px_get_the_excerpt(255,false); ?></p>
                   		<div class="blog-bottom clearfix">
						<?php px_posted_on(true,false,false,false,true,false);?>
						<a href="<?php the_permalink(); ?>" class="btnreadmore btn pix-bgcolrhvr"><i class="fa fa-plus"></i><?php if(isset($px_theme_option["trans_switcher"]) && $px_theme_option["trans_switcher"] == "on") {  _e("READ MORE",'Kingsclub'); }elseif(isset($px_theme_option["trans_read_more"])){  echo $px_theme_option["trans_read_more"];}?></a>
						</div>
					</div>
				</div>
		</article>
        
		<!-- ====== END ====== -->
	<?php endwhile; 
		$qrystr = '';
		if ($custom_query->found_posts > get_option('posts_per_page')) {
			echo "<nav class='pagination'><ul>";
            	if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
				if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
				if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
				if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
				if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
				if ( isset($_GET['team-category']) ) $qrystr .= "&team-category=".$_GET['team-category'];
				if ( isset($_GET['event-tag']) ) $qrystr .= "&event-tag=".$_GET['event-tag'];
				if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
 				echo px_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr);
                echo "</ul></nav>";
			}
		endif;  ?>
	</div>
 
	<?php		
	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}
//add_shortcode('news-home', 'wp_NewsHome');
