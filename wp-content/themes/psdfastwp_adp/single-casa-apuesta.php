<?php get_header(); ?>
<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php
							// if(the_field('cda_review')):
							// 		$reviewRating = the_field('cda_review');
							// 		echo 'test';
							// endif;
			?>
					<script type="application/ld+json">
					{
							"@context":"http:\/\/schema.org\/",
							"@type":"Product",
							"name":"<?php the_title(); ?>",
							"Review":{
									"@type":"Review",
									"name":"<?php the_title(); ?>",
									"author":{"@type":"Person","name":"Apuestas Deportivas Peru"},
									"datePublished":"<?php the_date('Y-m-d'); ?>",
									"reviewRating":{"@type":"Rating","ratingValue":"<?php if(get_field('cda_review')){ the_field('cda_review'); }?>"}
							}
					}
					</script>
			<?php echo do_shortcode('[slider_casa_apuesta]'); ?>
				<?php
			 if ( function_exists('yoast_breadcrumb') ) {
				 yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
			 }
			 ?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; else: ?>
            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
		<?php endif; ?>
		</div>
		<div class="adp_sidebar">
			<div class="widget atributes_casas">
				<div id="margin-custom"><h3 class="widget-title">Valoraciones</h3>
					<div class="textwidget">

					<?php if( have_rows('list_atributes') ): $i = 0; ?>
						<div class="row-grid no-margin">
							<div class="list_atributes_ca">
							<?php while( have_rows('list_atributes') ): the_row();  $i++; ?>
								<style>
									#val_chart_<?php echo $i ?>:before{
										left: <?php the_sub_field( 'puntuacion_vd' ); ?>%;
										top: 50%;
										transform: translate(-12px , -50%)
									}
								</style>
								<div class="title_atributes_ca">
 									<?php
										$name_object_sub_field = (get_sub_field_object('titulo_vd'));
										$name_sub_field = get_sub_field('titulo_vd');
 										$label_select = ($name_object_sub_field['choices'][$name_sub_field]);
									?>
									<?php echo $label_select; ?>
 									<div class="val_ca">
									<?php the_sub_field( 'puntuacion_vd' ); ?> %
									</div>
								</div>
								<div class="chart_progress_layer"><div id="val_chart_<?php echo $i ?>" class="chart_progress_val" style="width: <?php the_sub_field( 'puntuacion_vd' ); ?>%"></div></div>
							<?php endwhile; ?>
							</div>
						</div>
					<?php endif; ?>

					</div>
				</div>
			</div>
			<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
                <div class="clearfix">
                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                </div>
            <?php endif; ?>
						 
		</div>

	</div>
</section>

<?php get_footer(); ?>
