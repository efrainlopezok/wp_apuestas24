<?php

/*-----------------------------------
Shortcode [estract_probabilidades]
-----------------------------------*/
function wp_listProbabilidadesEstract($content = null) {
	ob_start();

	$tipoEvento = "";
	if(isset($_GET["tipo_evento"])) {
		$tipoEvento = $_GET["tipo_evento"];
	}
	?>

<h2 class="section-title">Comparador de Cuotas</h2>
<div class="content_block_info">

	<div class="wrapper-probabilidades">
    <ul class="list_container_table header_list clearfix">
      <li class="col_date"><span>Fecha</span></li>
      <li class="col_match"><span>Partidos destacados</span></li>
      <li class="col_liga"><span>Liga</span></li>
      <li class="value_val responsive"><span>1</span><span class="title_cuotas_responsive">Cuotas</span></li>
      <li class="value_val"><span>X</span></li>
      <li class="value_val last_item_header"><span>2</span></li>
      <li class="play"><span></span></li>
    </ul>

    <?php
		  wp_reset_query();
		  $args = array(
			  'post_type' => 'probabilidades',
			  'posts_per_page' => 10,
			  'post_status' => 'publish',
			  'orderby' => 'meta_value_num',
			  'order' => 'DESC',
			  'meta_key' => 'wpcf-fecha-probabilidad',
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
		   //$url = get_term_link($custom_term);
		   $loop = new WP_Query($args);
		   if($loop->have_posts()) { ?>
       <div class="container_table_list_probabilidad">
          <?php while($loop->have_posts()) : $loop->the_post();
          $maximum_values = get_max_values_from_pagan_las_casas(get_the_ID());
          $term_list = wp_get_post_terms(get_the_ID(), 'tipo-de-evento', array("fields" => "names")); ?>
          <ul class="list_container_table content_list row_table_list_probabilidad clearfix">
            <?php $show_date = get_post_meta(get_the_ID(), 'wpcf-fecha-probabilidad', true); ?>

              <li class="col_date"><span class="height_row"><?php echo date("d-m-Y", $show_date); ?></span></li>
              <li class="col_match"><span class="height_row"><a href="<?php the_permalink(); ?>" rel="nofollow" title=""><?php the_title(); ?>
              </a>
              <div class="content_date_responsive"><strong>Fecha: </strong><?php echo date("d-m-Y", $show_date); ?></div>
                <div class="content_liga_responsive"><strong>Liga: </strong><?php echo implode(", ", $term_list) ?></div></span></li>
              <li class="col_liga"><span class="height_row"><?php echo implode(", ", $term_list) ?></span></li>
              <li class="value_val responsive">
                <span class="height_row"><?php echo number_format($maximum_values['max_value_1'], 2); ?></span>
                <span class="title_cuotas_responsive">1 : <?php echo number_format($maximum_values['max_value_1'], 2); ?></span>
                <span class="title_cuotas_responsive">X : <?php echo number_format($maximum_values['max_value_x'], 2); ?></span>
                <span class="title_cuotas_responsive">2 : <?php echo number_format($maximum_values['max_value_2'], 2); ?></span>
                </span>
              </li>
              <li class="value_val"><span class="height_row"><?php echo number_format($maximum_values['max_value_x'], 2); ?></span></li>
              <li class="value_val"><span class="height_row"><?php echo number_format($maximum_values['max_value_2'], 2); ?></span></li>
              <li class="play"><span><a href="#" class="trabaja__nosotros--pitcher">Jugar</a></span></li>

            </ul>
          	<?php endwhile;
			wp_reset_query(); ?>
      </div>
        	<?php    }
	  //}
		?>

    <div class="wrapper__btn_all">
      <a href="<?php echo esc_url( home_url( '' ) ); ?>/comparacion-de-probabilidades/" class="btn_default_link border_b">Ver todas las Probabilidades</a>
    </div>


		<div class="trabaja__nosotros__wrap">
		 	<div class="trabaja__nosotros__pop__up"><span class="trabaja__nosotros__pop__up__close icon-close"></span>
				<div class="trabaja__nocotros__pop__up__container">
					<?php $args = array(
							'post_type'     => 'casa-apuesta',
							'post_status'   => 'publish',
							'meta_query' => array(
								array(
									'key' => 'casa_de_apuesta',
									'value' => '1',
									'compare' => 'LIKE'
							))
					);
					$wp_queryPost = new WP_Query($args);
					if($wp_queryPost->have_posts()) :  ?>
					<div class="layer_table">
						<div class="layer_table_cell">
							<ul class="list_casa_verificada">
							<?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post(); ?>
								<li>
						            <?php //the_title($wp_query->ID); ?>
						            <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">
						            <?php the_post_thumbnail(); ?><br>
				                	Jugar</a>
				                </li>
							<?php endwhile;
							wp_reset_query(); ?>
							</ul>
						</div>
					</div>
					<?php
				    endif; ?>
				</div>
			</div>
		</div>

	</div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.matchHeight-min.js"></script>

<script>
  jQuery(document).ready(function($){
    $('.row_table_list_probabilidad').each(function() {
      $(this).children('li').matchHeight();
    });
  });
</script>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('estract_probabilidades', 'wp_listProbabilidadesEstract');

/*-----------------------------------
Shortcode [probabilidades-full]
-----------------------------------*/
function wp_listProbabilidadesFull($atts, $content = null) {

  $a = shortcode_atts( array(
    'pagination' => '',
  ), $atts );

    ob_start();

    $tipoEvento = "";
    if(isset($_GET["tipo_evento_full"])) {
        $tipoEvento = $_GET["tipo_evento_full"];
    }
    ?>

    <div class="wrapper-prob-full">
    <div class="wrapper_header_page_probabilidades clearfix">
    <span class="label_filter">Filtrar por:</span>
    <form method="GET">
        <select name="tipo_evento_full" class="select-full">
            <option value="">Todas las Ligas</option>
            <?php
            $terms = get_terms( 'tipo-de-evento', array('hide_empty' => true,) );
            foreach($terms as $term) : ?>
                <option value="<?php echo $term->term_id; ?>" <?php echo ($term->term_id == $tipoEvento ? "selected" : ""); ?>><?php echo $term->name ?></option>
            <?php
            endforeach;
            ?>
        </select>

    </form>
    </div>

<!-- START CONTAINER TABLE LIST -->
<div class="wrapper-probabilidades">
<!-- START HEADER -->
  <ul class="list_container_table header_list clearfix">
    <li class="col_date"><span>Fecha</span></li>
    <li class="col_match"><span>Partidos destacados</span></li>
    <li class="col_liga"><span>Liga</span></li>
    <li class="value_val responsive"><span>1</span><span class="title_cuotas_responsive">Cuotas</span></li>
    <li class="value_val"><span>X</span></li>
    <li class="value_val last_item_header"><span>2</span></li>
    <li class="play"><span></span></li>
  </ul>
<!-- END HEADER -->
<!-- START CONTENT -->
  <div class="container_table_list_probabilidad">

        <?php
          wp_reset_query();

        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
        if (!isset($_GET["s"])) {
            $_GET["s"] = '';
        }
          $dateMonthAgo = $date = new DateTime("-1 Month");
          $args = array(
              'post_type' => 'probabilidades',
              'posts_per_page' => $atts['pagination'],
              'paged' => $_GET['page_id_all'],
              'post_status' => 'publish',
              'orderby' => 'meta_value_num',
              'order' => 'DESC',
              'meta_key' => 'wpcf-fecha-probabilidad',
              'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'       => 'wpcf-fecha-probabilidad',
                    'compare'   => '>=',
                    'value'     => $dateMonthAgo->getTimestamp(),
                    'type'      => 'numeric',
                )
              )
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
              <ul class="list_container_table content_list row_table_list_probabilidad clearfix">
              <?php $show_date = get_post_meta(get_the_ID(), 'wpcf-fecha-probabilidad', true); ?>

              <li class="col_date"><span class="height_row"><?php echo date("d-m-Y", $show_date); ?></span></li>
              <li class="col_match"><span class="height_row"><a href="<?php the_permalink(); ?>" rel="nofollow" title=""><?php the_title(); ?>
              </a>
              <div class="content_date_responsive"><strong>Fecha: </strong><?php echo date("d-m-Y", $show_date); ?></div>
                <div class="content_liga_responsive"><strong>Liga: </strong><?php echo implode(", ", $term_list) ?></div></span></li>
              <li class="col_liga"><span class="height_row"><?php echo implode(", ", $term_list) ?></span></li>
              <li class="value_val responsive">
                <span class="height_row"><?php echo number_format($maximum_values['max_value_1'], 2); ?></span>
                <span class="title_cuotas_responsive">1 : <?php echo number_format($maximum_values['max_value_1'], 2); ?></span>
                <span class="title_cuotas_responsive">X : <?php echo number_format($maximum_values['max_value_x'], 2); ?></span>
                <span class="title_cuotas_responsive">2 : <?php echo number_format($maximum_values['max_value_2'], 2); ?></span>
                </span>
              </li>
              <li class="value_val"><span class="height_row"><?php echo number_format($maximum_values['max_value_x'], 2); ?></span></li>
              <li class="value_val"><span class="height_row"><?php echo number_format($maximum_values['max_value_2'], 2); ?></span></li>
              <li class="play"><span><a href="#" class="trabaja__nosotros--pitcher">Jugar</a></span></li>

              </ul>
            <?php endwhile;
            wp_reset_query(); ?>
            <?php    }
        ?>

    <div class="trabaja__nosotros__wrap">
      <div class="trabaja__nosotros__pop__up"><span class="trabaja__nosotros__pop__up__close icon-close"></span>
        <div class="trabaja__nocotros__pop__up__container">
          <?php $args = array(
              'post_type'     => 'casa-apuesta',
              'post_status'   => 'publish',
              'meta_query' => array(
                array(
                  'key' => 'casa_de_apuesta',
                  'value' => '1',
                  'compare' => 'LIKE'
              ))
          );
          $wp_queryPost = new WP_Query($args);
          if($wp_queryPost->have_posts()) :  ?>
          <div class="layer_table">
            <div class="layer_table_cell">
              <ul class="list_casa_verificada">
              <?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post(); ?>
                <li>
                        <?php //the_title($wp_query->ID); ?>
                        <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">
                        <?php the_post_thumbnail(); ?><br>
                          Jugar</a>
                        </li>
              <?php endwhile;
              wp_reset_query(); ?>
              </ul>
            </div>
          </div>
          <?php
            endif; ?>
        </div>
      </div>
    </div>

  </div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER TABLE LIST -->

<!-- START PAGINATION -->

</div>

<?php
 $qrystr = '';
    if ($loop->post_count > get_option('posts_per_page')) {
        echo "<nav class='pagination'><ul>";
             if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
            echo px_pagination($loop->post_count,get_option('posts_per_page'), $qrystr);
        echo "</ul></nav>";
    }
?>

<!-- END PAGINATION -->

<script>
    $(document).ready(function() {
        var $selectTipoEvento = $("select[name=tipo_evento_full]");
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
add_shortcode('probabilidades-full', 'wp_listProbabilidadesFull');

/* END [probabilidades-full] */


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
        <table class="custom-table-responsive">
		<thead>
        <tr>
          <th colspan="2" scope="col">Partidos destacados</th>
          <th scope="col" class="th-001">Liga</th>
          <th scope="col" class="th-002"><span class="valores-default">1</span></th>
          <th scope="col" class="th-003">X</th>
          <th scope="col" class="th-004">2</th>
        </tr>
		</thead>
        <tbody>
        <?php
		  wp_reset_query();
		  $args = array(
			  'post_type' => 'probabilidades',
			  'posts_per_page' => 15,
			  'post_status' => 'publish',
			  'orderby' => 'meta_value_num',
			  'order' => 'DESC',
			  'meta_key' => 'wpcf-fecha-probabilidad',
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
            	<td colspan="6"><a href="<?php echo esc_url( home_url( '' ) ); ?>/comparacion-de-probabilidades/" class="btn">Ver todos  &gt;&gt;</a></td>
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

/**
 * Filter probabilidades
 */
function agents_posts_filter( $query ){
  if ( is_main_query() and is_post_type_archive('probabilidades') ) {
    $dateMonthAgo = $date = new DateTime("-1 Month");
    $meta_query = array(
        'relation' => 'AND',
        array(
            'key'       => 'wpcf-fecha-probabilidad',
            'compare'   => '>=',
            'value'     => $dateMonthAgo->getTimestamp(),
            'type'      => 'numeric',
        )
    );
    $query->set( 'meta_query', $meta_query );
  }
  return;
}
add_action( 'pre_get_posts', 'agents_posts_filter' );

function set_custom_edit_probabilidades_columns($columns) {
  $columns['fecha-probabilidad'] = __( 'Fecha de probabilidad', 'fecha-probabilidad' );
  $n_columns = array();
  $move = 'fecha-probabilidad';
  $before = 'author';
  foreach($columns as $key => $value) {
    if ($key==$before){
      $n_columns[$move] = $move;
    }
      $n_columns[$key] = $value;
  }
  return $n_columns;
}
add_filter( 'manage_probabilidades_posts_columns', 'set_custom_edit_probabilidades_columns' );

function custom_probabilidades_column( $column, $post_id ) {
  switch ( $column ) {
    case 'fecha-probabilidad' :
      $fecha = get_post_meta($post_id, 'wpcf-fecha-probabilidad', true);
      echo date('d/m/Y', $fecha);
    }
}
add_action( 'manage_probabilidades_posts_custom_column' , 'custom_probabilidades_column', 10, 2 );
