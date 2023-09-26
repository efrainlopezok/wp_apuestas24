<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GoApostas
 */

get_header();

$attr_se = '';
if ($_GET['search']) {
	$attr_se = 'search-container';

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array('posts_per_page' => -1, 's' => $_GET['search'], 'paged' => $paged, 'post_type' => array('post', 'news', 'review'));
	$custom_query = new WP_Query( $args );
	?>
	<div id="primary" class="content-area full-width <?php echo $attr_se; ?>">
		<main id="main" class="site-main">
		<?php
		while($custom_query->have_posts() ) :
			$custom_query->the_post();
			?>
			<article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
				<?php
				if (has_post_thumbnail()) {
					?>
					<div class="thumb"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?></a></div>
					<?php
				}else{
					?>
					<div class="thumb"><a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/goapostas-default.jpg" width="150" height="150" /></a></div>
					<?php
				}
				?>
				<div class="content-res-f">
					<header class="entry-header">
						<?php
						if ( is_singular() ) :
							the_title( '<h1 class="entry-title">', '</h1>' );
						else :
							the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
						endif;
						?>
					</header>
					<div class="entry-content">
						<?php
						echo '<p>'.get_the_excerpt().'</p>';
						echo '<a class="search-link" href="'.get_the_permalink().'">'.get_the_permalink().'</a>';
						?>
					</div>
				</div>
			</article>
			<?php
		endwhile;
		wp_reset_postdata();

		?>
		</main>
	</div>

	<?php
}else{
	?>
		<div id="primary" class="content-area full-width">
			<main id="main" class="site-main">
			
			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) :
					?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
					<?php
				endif;

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

			</main><!-- #main -->
		</div><!-- #primary -->

	<?php
}

get_footer();
