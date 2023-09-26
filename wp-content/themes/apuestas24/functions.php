<?php
//Child Theme Functions File
add_action( 'wp_enqueue_scripts', 'enqueue_wp_child_theme' );
function enqueue_wp_child_theme() 
{
    wp_enqueue_style('parent-css', get_template_directory_uri().'/style.css' );
}

/* Apuestas24 Widgets */
require get_stylesheet_directory() . '/inc/widgets/init.php';

add_action( 'init', 'remove_gp_after_header' );
function remove_gp_after_header(){
	remove_action( 'gp_after_header', 'goapostas_after_header' );
}

add_action('gp_after_header', 'apuestas24_after_header');
function apuestas24_after_header() {
	$image = get_field('hero_image');
	if( !$image ) {
		$image = get_the_post_thumbnail_url();
		$image = $image? $image : get_stylesheet_directory_uri() . '/assets/images/news-hero-bg.jpg';
	}
	if( is_singular('news') || is_singular('palpite') ) {
		?>
		<section class="hero hero-shadow" style="background-image: url(<?php echo $image; ?>)">
			<?php
			if (has_post_thumbnail()) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
				?>
				<div class="image-thm" style="background:url(<?php echo $thumb_url[0]; ?>);"></div>
				<div class="img-th"><img src="<?php echo $thumb_url[0]; ?>" /></div>
				<?php
			}
			?>
			<div class="wrap">
				<h1><?php echo get_the_title(); ?></h1>
			</div>
		</section>
		<?php
	}
	else if( is_page() ) {
		$type = get_field('hero_type');
		$title = get_field('hero_title');
		$content = get_field('hero_content');
		if( get_field('hero_image') ) {
			$image = get_field('hero_image');
		}

		if ($type == 3) {
			$class = 'hero-ap24';
			$bg_hero = '';
		}else{
			$class = '';
			$bg_hero = $image;
		}
		?>
		<section class="hero-deg <?php echo $class; ?> hero-type-<?php echo $type; ?>" style="background-image: url(<?php echo $bg_hero; ?>)" >
			<?php if ($type != 3): ?>
				<a href="#" class="scroll-to-sc">
					<span>Rolar para baixo</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon-scrollto.svg" alt="scroll below">
				</a>
			<?php endif ?>

			<?php if ($type == 3): ?>
				<div class="bg-hero-ap24" style="background-image: url(<?php echo $image; ?>)">
				</div>
				<div class="shape-hero-ap24"></div>
			<?php endif ?>
			
			<div class="wrap">
				<?php if( $title ): ?>
				<h1><?php echo $title; ?></h1>
				<?php endif; ?>

				<?php if( $content ): ?>
				<div class="hero-parph">
					<h1><?php echo $content; ?></h1>
				</div>
				<?php endif; ?>
			</div>
			<?php if ($type == 3): ?>
				<div class="wrap-float">
					<div class="wrap">
						<div class="wpb_column vc_column_container vc_col-sm-2">
							<div class="vc_column-inner">
								<div class="wpb_wrapper">
									<div class="wpb_text_column wpb_content_element ">
										<div class="wpb_wrapper">
											<h3><?php echo get_field('title_floating_section'); ?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wpb_column vc_column_container vc_col-sm-3">
							<div class="vc_column-inner">
								<div class="wpb_wrapper">
									<div class="wpb_text_column wpb_content_element ">
										<div class="wpb_wrapper">
											<?php echo get_field('column_1_floating_section'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wpb_column vc_column_container vc_col-sm-3">
							<div class="vc_column-inner">
								<div class="wpb_wrapper">
									<div class="wpb_text_column wpb_content_element ">
										<div class="wpb_wrapper">
											<?php echo get_field('column_2_floating_section'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
		</section>
		<?php
	}
	else if( is_singular('review') || is_singular('bonus') ) {
		$image = ( strpos($image, 'news-hero-bg') === false )? $image : get_stylesheet_directory_uri() . '/assets/images/review-hero-default.jpg';
		?>
		<section class="hero hero-shadow" style="background-image: url(<?php echo $image; ?>)">
			<div class="wrap"></div>
		</section>
		<?php
	}elseif($_GET['search']) {
		$s = $_GET['search'];
		$args = array('posts_per_page' => -1, 's' => $_GET['search'], 'paged' => $paged, 'post_type' => array('post', 'news', 'review'));
		$search_query = new WP_Query( $args );
		?>
		<section class="hero hero-shadow" style="background-image: url(<?php echo get_stylesheet_directory_uri().'/assets/images/bg-search.svg'; ?>)">
			<div class="wrap">
				<h1 style="margin-bottom:0;"><?php echo __('Resultados: “', 'goapostas'); ?><span><?php echo $s.__('”', 'goapostas'); ?></span></h1>
				<p style="text-align:center;"><?php echo __('Aproximadamente ', 'goapostas').$search_query->post_count.__(' resultados', 'goapostas'); ?></p>
			</div>
		</section>
		<?php
	}
}

add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
	$show_only_email = get_field( 'show_only_email' ) ? get_field( 'show_only_email' ) : '';
	if ($show_only_email && $show_only_email == 1 ) {
		$classes[] = 'show-only-email';
	}else{
		$classes[] = 'show-all-form';
	}

	$type_hero = get_field( 'hero_type' ) ? get_field( 'hero_type' ) : '';
	if ($type_hero && $type_hero == 3 ) {
		$classes[] = 'hero-3';
	}

    return $classes;
}