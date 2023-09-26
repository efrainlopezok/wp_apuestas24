<?php get_header(); ?>
<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
			<?php
		 if ( function_exists('yoast_breadcrumb') ) {
			 yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		 }
		 ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<blockquote class="clearfix">
				<div class="content_title_date">
					<h1><?php the_title(); ?></h1>
					<time><?php custom_format_date_post_sinlge(); ?></time>
				</div>
				<div class="content_graph_line">
					<figure class="bar_chart clearfix">
						<?php
							$maximum_values = get_max_values_from_pagan_las_casas(get_the_id());
							$max_height = 75;
							$height_1 = number_format($maximum_values['av_value_1'] * $max_height / 100, 2);
							$height_x = number_format($maximum_values['av_value_x'] * $max_height / 100, 2);
							$height_2 = number_format($maximum_values['av_value_2'] * $max_height / 100, 2);
						?>
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

			<figure class="post_thumbnail"><?php the_post_thumbnail(); ?></figure>



			<?php the_content(); ?>
		<?php endwhile; else: ?>
            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
		<?php endif; ?>


                    <div class="wrapper-cpt-probabilidades">
					<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">-->
                    <table class="custom-table-responsive probabilidades">
                      <tbody>
                        <tr>
						  <th scope="col" class="th-header-001">Casa de Apuestas</th>
						  <th scope="col" class="cuota-mobile">Cuotas</th>
						  <th scope="col" class="cuota-mobile">Porcentaje</th>
                          <th scope="col" class="th-header-002">
                          <span class="title-rwd-default">1</span>
                          </th>
                          <th scope="col" class="th-header-003">X</th>
                          <th scope="col" class="th-header-004">2</th>
                          <th scope="col" class="th-header-005">1%</th>
                          <th scope="col" class="th-header-006">X%</th>
                          <th scope="col" class="th-header-007">2%</th>
                          <th scope="col" class="th-header-008">Payback</th>
                        </tr>

                    <?php

					$child_posts = types_child_posts('pagan-las-casas');

					$max_value_1 = $maximum_values['max_value_1'];
					$max_value_x = $maximum_values['max_value_x'];
					$max_value_2 = $maximum_values['max_value_2'];

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

						$p_1 = 100 / $value_1;
						$p_x = 100 / $value_x;
						$p_2 = 100 / $value_2;
						$div = 100 / (1/$value_1 + 1/$value_x + 1/$value_2);

						$value_1 = number_format($value_1, 2);
						$value_x = number_format($value_x, 2);
						$value_2 = number_format($value_2, 2);
					  ?>
							<tr>
                				<td class="image-child-post td-content-001">
                                	<a target="_blank" href="<?php echo $link_juego; ?>">
										<?php echo $thumbnail; ?>
                                        <span class="td-a-title"><?php echo $casa_title; ?></span>
                                    </a>
								</td>
								<td class="cuota-mobile">
									<span>
										1 : <?php echo $value_1; ?><br>
										X : <?php echo $value_x; ?><br>
										2 : <?php echo $value_2; ?>
                					</span>
								</td>
								<td class="cuota-mobile">
									<span>
										1% : <?php echo number_format($p_1 * $div / 100, 2); ?><br>
										X% : <?php echo number_format($p_x * $div / 100, 2); ?><br>
										2% : <?php echo number_format($p_2 * $div / 100, 2); ?>
                					</span>
								</td>
                				<td class='td-content-002 <?php echo $value_1 == $max_value_1 ? "apuesta-alta" : "" ?>'>
									<?php echo $value_1;?>
                                </td>
               					<td class='td-content-003 <?php echo $value_x == $max_value_x ? "apuesta-alta" : "" ?>'>
									<?php echo $value_x; ?>
                                </td>
                				<td class='td-content-004 <?php echo $value_2 == $max_value_2 ? "apuesta-alta" : "" ?>'>
									<?php echo $value_2; ?>
                                </td>
                                 <td class="td-content-005">
                                 	<?php echo number_format($p_1 * $div / 100, 2); ?>%
                                 </td>
                                 <td class="td-content-006">
								 	<?php echo number_format($p_x * $div / 100, 2); ?>%
                                 </td>
                                 <td class="td-content-007">
								 	<?php echo number_format($p_2 * $div / 100, 2); ?>%
                                 </td>
                                 <td class="td-content-008">
								 	<?php echo number_format($div, 2); ?>%
                                 </td>
							</tr>

                      <?php
					}
					?>

                      </tbody>
                    </table>
                    <?php
		 	?>

                    </div>

                    <div class="wrapper-rentabilidad">
						<?php if ( is_active_sidebar( 'sidebar-rentabilidad' ) ) : ?>
                            <div class="clearfix">
                                <?php dynamic_sidebar( 'sidebar-rentabilidad' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

		<?php echo do_shortcode('[estract_probabilidades]') ?>

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
