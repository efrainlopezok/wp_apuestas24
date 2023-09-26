<?php get_header(); ?>
<section class="main_content">
	<div class="wrapper">
		<article>
			<h1><?php _e('Error', 'apuestas_deportivas'); ?></h1>
			<h3 class="messages"><?php _e('Esta página no existe', 'apuestas_deportivas'); ?></h3>
			<article>
				<p><?php _e('Al parecer la página que estas buscando se rompió o no existe, porque no intestas volver a la página principal o quizás encuentres lo que buscabas.', 'apuestas_deportivas'); ?></p>
			</article>
			<a class="btn_default color_two center" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="default_span"><?php _e('Regresar al Inicio', 'apuestas_deportivas'); ?></span>
			</a>
		</article>
	</div>
</section>

<?php get_footer(); ?>