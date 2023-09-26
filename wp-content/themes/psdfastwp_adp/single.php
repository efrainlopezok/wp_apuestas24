<?php get_header(); ?>
<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
		<?php
		$current_user = wp_get_current_user();
		$checkuser=$current_user->user_login;

		 ?>
		 <?php
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		}
		?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<span>Autor: <?php the_author(); ?></span>
			<time><?php custom_format_date_post_sinlge(); ?></time>
			<!--<figure class="post_thumbnail"><?php //the_post_thumbnail(); ?></figure>-->

		<?php
			$probabilidad_id = get_post_meta(get_the_id(), 'partidos-probabilidades', true);

			$child_posts = types_child_posts('pagan-las-casas');

			if($probabilidad_id > 0):
				$maximum_values = get_max_values_from_pagan_las_casas($probabilidad_id);
				$max_height = 75;
				$height_1 = number_format($maximum_values['av_value_1'] * $max_height / 100, 2);
				$height_x = number_format($maximum_values['av_value_x'] * $max_height / 100, 2);
				$height_2 = number_format($maximum_values['av_value_2'] * $max_height / 100, 2);
		?>

<div class="single-probabilidades">

<?php

$post_object = get_field('casadeapuestas');
$max_value_1 = $maximum_values['max_value_1'];
$max_value_x = $maximum_values['max_value_x'];
$max_value_2 = $maximum_values['max_value_2'];


if( $post_object ):
	$post = $post_object;
	setup_postdata( $post );

	$link_juego = get_post_meta(($casa_apuesta_id), 'wpcf-url-juego', true);
	?>

	<blockquote class="clearfix">

		<?php

		?>



		<div class="mejores_cuotas_from_widget">
			<div class="wrapper_mejores_cuotas">

				<article class="widget_content_cuotas">
            <ul class="row-grid no-margin">
                <li class="column-3 no-padding"><span>1</span></li>
                <li class="column-3 no-padding center"><span>X</span></li>
                <li class="column-3 no-padding"><span>2</span></li>
            </ul>
            <ul class="row-grid no-margin">
                <li class="column-3 no-padding center"><div class="items_wmc"><?php echo $max_value_1; ?></div></li>
                <li class="column-3 no-padding center"><div class="items_wmc"><?php echo $max_value_x; ?></div></li>
                <li class="column-3 no-padding center"><div class="items_wmc"><?php echo $max_value_2; ?></div></li>
            </ul>
            <ul class="row-grid no-margin">
                <li class="column-1 no-padding"><span><a target="_blank" href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>"><?php the_title(); ?></a></span></li>
            </ul>
        </article>

			</div>
		</div>

		<div class="content_graph_line">

		<figure class="bar_chart clearfix">
		<div class="bar-chart">
			<div class="bar-item" style="left: 0px">
				<div class="bar-toptext"><?php echo number_format($maximum_values['av_value_1'], 2) ?>%</div>
				<div class="bar-bodycolor" style="height: <?php echo $height_1; ?>px;
													background-color: rgb(35, 149, 0);"></div>
				<div class="bar-bottomtext">1</div>
			</div>
			<div class="bar-item" style="left: 80px">
				<div class="bar-toptext"><?php echo number_format($maximum_values['av_value_x'], 2) ?>%</div>
				<div class="bar-bodycolor" style="height: <?php echo $height_x; ?>px;
													background-color: rgb(99, 99, 99);"></div>
				<div class="bar-bottomtext">X</div>
			</div>
			<div class="bar-item" style="left: 160px">
				<div class="bar-toptext"><?php echo number_format($maximum_values['av_value_2'], 2) ?>%</div>
				<div class="bar-bodycolor" style="height: <?php echo $height_2; ?>px;
													background-color: rgb(0, 82, 194);"></div>
				<div class="bar-bottomtext">2</div>
			</div>
		</div>
		</figure>
	</div>
	</blockquote>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>
</div>


		<?php
			endif;
		?>

			<?php the_content(); ?>
		<?php endwhile; else: ?>
            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
		<?php endif; ?>

		<?php //echo do_shortcode('[estract_probabilidades]') ?>
<hr>
<br>

<div class="wrapper-cpt-probabilidades">



	<?php
	$post_object = get_field('partidos-probabilidades');
    if( $post_object ):
	$post = $post_object;
	setup_postdata( $post ); ?>
	<h3><?php the_title(); ?> </h3>

<table class="custom-table-responsive probabilidades" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <th scope="col">Casa de Apuestas</th>
      <th scope="col">1</th>
      <th scope="col">X</th>
      <th scope="col">2</th>
    </tr>

<?php

$maximum_values = get_max_values_from_pagan_las_casas(get_the_id());
$max_value_1 = $maximum_values['max_value_1'];
$max_value_x = $maximum_values['max_value_x'];
$max_value_2 = $maximum_values['max_value_2'];

$child_posts = types_child_posts('pagan-las-casas');
foreach ($child_posts as $child_post) {
	$value_1 = is_numeric($child_post->fields['valor-1']) ? floatval($child_post->fields['valor-1']) : 0;
	$value_x = is_numeric($child_post->fields['valor-x']) ? floatval($child_post->fields['valor-x']) : 0;
	$value_2 = is_numeric($child_post->fields['valor-2']) ? floatval($child_post->fields['valor-2']) : 0;
	$casa_apuesta_id = get_post_meta($child_post->ID, '_wpcf_belongs_casa-apuesta_id', true);
	$link_juego = "#";
	$thumbnail = "";
	$casa_title = "";
	if($casa_apuesta_id > 0)
	{
		$link_juego = get_post_meta(($casa_apuesta_id), 'wpcf-url-juego', true);
		$thumbnail = get_the_post_thumbnail( $casa_apuesta_id, 'post-thumbnail', $attr = '' );
		$casa_title = get_the_title($casa_apuesta_id);
	}
  ?>
		<tr>
			<td class="image-child-post">
            	<a target="_blank" href="<?php echo $link_juego; ?>">
					<?php echo $thumbnail; ?>
                    <?php echo $casa_title; ?>
                </a>
            </td>
			<td class='<?php echo $value_1 == $max_value_1 ? "apuesta-alta" : "" ?>'><?php echo number_format($value_1, 2);?></td>
				<td class='<?php echo $value_x == $max_value_x ? "apuesta-alta" : "" ?>'><?php echo number_format($value_x, 2); ?></td>
			<td class='<?php echo $value_2 == $max_value_2 ? "apuesta-alta" : "" ?>'><?php echo number_format($value_2, 2); ?></td>
		</tr>

  <?php
}

?>

  </tbody>
</table>

        <?php wp_reset_postdata(); ?>

<br>
<hr>
<?php endif; ?>
<?php
$current_user = wp_get_current_user();
$postid = get_the_ID();
if($current_user->user_login=='dev' || $current_user->user_login=='bjornar' || $postid=='23168'){ ?>
<div class="social-media">
	<div class="buttons">
		<a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink() ?>" class="share-facebook" target="_blank">
			<img src="<?php echo get_template_directory_uri() ?>/assets/images/fb.svg" class="icono icono-compartir">
		</a>
		<a href="https://twitter.com/share?url=<?php echo get_permalink() ?>&amp;text=<?php echo get_the_excerpt() ?>" class="share-twitter" target="_blank">
			<img src="<?php echo get_template_directory_uri() ?>/assets/images/tw.svg" class="icono icono-compartir">
		</a>
	</div>
	<hr>
</div>
<?php } ?>
<?php
$postid=get_the_ID();
comments_template('', true);
?>
<br>
<hr>
<br>

</div>





<h3 class="section-title">Otras noticias de tu interes</h3>

<?php echo do_shortcode('[partidos_destacados]'); ?>


		</div>
		<div class="adp_sidebar">
			<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
                <div class="clearfix">
                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                </div>
            <?php endif; ?>
						 
		</div>

	</div>
</section>

<?php get_footer(); ?>
