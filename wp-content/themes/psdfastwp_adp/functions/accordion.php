<?php
/*-----------------------------------
Shortcode [acordion]
-----------------------------------*/

function wp_custom_acordion($content = null) {

	ob_start();

    if( have_rows('lista_socios') ): ?>
        <?php while ( have_rows('lista_socios') ) : the_row(); ?>
        	<?php $imageUrlpartner = get_sub_field('socios_logo');  ?>
        	<img src="<?php echo $imageUrlpartner['url']; ?>" alt="">
			<?php the_field('socios_nombre');  ?>
			<?php the_field('socios_url');  ?>
			<?php the_field('socios_contenido');  ?>
        <?php endwhile; ?>

	    <script>
			jQuery(document).ready(function($){                	
			    $("#accordion dt").click(function () {
			        $(this).next(".pane").slideToggle("slow").siblings(".pane:visible").slideUp("slow");
			        $(this).toggleClass("current");
			        $(this).siblings("dt").removeClass("current");
			    });
			});               	
	    </script>
    <?php endif; 

	$content = ob_get_contents();
	ob_end_clean();
	return $content;  
}

add_shortcode('acordion', 'wp_custom_acordion');