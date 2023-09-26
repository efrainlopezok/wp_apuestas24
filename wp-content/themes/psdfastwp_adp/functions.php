<?php

if( function_exists('acf_add_options_page') ) {
	//acf_add_options_page();

	acf_add_options_page(array(
		'page_title' 	=> 'Configuración General',
		'menu_title'	=> 'Configuraciones',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'position'		=> '2.1',
		'icon_url'		=> 'dashicons-admin-settings',
	));
}

/**/

// Remove action
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');

// Remove Emojis
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
    return $urls;
}


// Remove embeds
function disable_embeds_code_init() {
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    add_filter( 'embed_oembed_discover', '__return_false' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}
add_action( 'init', 'disable_embeds_code_init', 9999 );

function disable_embeds_tiny_mce_plugin($plugins) {
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
    if(false !== strpos($rewrite, 'embed=true')) {
        unset($rules[$rule]);
    }
    }
    return $rules;
}

// Add filter
//add_filter('show_admin_bar', '__return_false');

// Language
load_theme_textdomain('apuestas_deportivas', get_template_directory() . '/languages');

// Support Shortcode
add_filter('widget_text', 'do_shortcode');

// Support Thumbnails
add_theme_support( 'post-thumbnails' );

// Custom images sizes
add_image_size( 'thumbnail-news-home', '210', '180', array( "1", "") );

// Support Upload SVG
add_filter('upload_mimes', 'my_upload_mimes');

function my_upload_mimes($mimes = array()) {
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}

//Page Slug Body Class
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// Remove title - widget
function remove_widget_title( $widget_title ) {
    if ( substr ( $widget_title, 0, 1 ) == '!' )
        return;
    else
        return ( $widget_title );
}
add_action( 'widget_title', 'remove_widget_title');

// Register menu
register_nav_menus(array(
    'primary' => __('Menu Principal', ''),
    'footer' => __('Menu Footer', ''),
));

// Register Scripts
function script_init_custom() {

    wp_enqueue_script('jquery');

    wp_enqueue_style('rs-css', get_stylesheet_directory_uri() . '/assets/js/ResponsiveSlider/responsiveslides.css');
    wp_register_script('rs-js', get_stylesheet_directory_uri() . '/assets/js/ResponsiveSlider/responsiveslides.min.js');
    wp_enqueue_style('rs-css');
    wp_enqueue_script('rs-js');

}
add_action('init', 'script_init_custom');


function register_custom_script(){

    // SLICK
    wp_enqueue_style( 'slick_css', get_stylesheet_directory_uri() . '/assets/js/slick/slick.css');
    wp_enqueue_style( 'slick_theme_css', get_stylesheet_directory_uri() . '/assets/js/slick/slick-theme.css');
    wp_register_script( 'slick_js', get_stylesheet_directory_uri() . '/assets/js/slick/slick.min.js');

    wp_enqueue_style( 'support_ticket_css', get_stylesheet_directory_uri() . '/assets/css/st_style.css');

    if( is_front_page() ) {
        wp_enqueue_style('slick_css');
        wp_enqueue_script('slick_js');
    }
    if( is_page('registro') ) {
        wp_enqueue_style('support_ticket_css');
    }
}

add_action( 'wp_enqueue_scripts', 'register_custom_script' );

function scripts_header_new() {

    wp_enqueue_style('header-css', get_stylesheet_directory_uri() . '/style.css?v=435242');
    wp_enqueue_style('header-fonts', get_stylesheet_directory_uri() . '/assets/css/fonts.css');
    wp_enqueue_style('header-css');
    wp_enqueue_style('header-fonts');

}
add_action('wp_enqueue_scripts', 'scripts_header_new');

function wpb_add_google_fonts() {

wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700', false );
}

add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

require ( 'functions/shortcodes.php' );
require ( 'functions/slider.php' );
require ( 'functions/news.php' );
require ( 'functions/otherfunc.php' );
require ( 'functions/probabilidades.php' );
require ( 'functions/pagination.php' );
require ( 'functions/custom_fields.php' );

function add_widgets_custom(){
    //require_once __DIR__ . '/widgets/apuestas.php';
    //register_widget('Widget_Apuestas');
    //require_once __DIR__ . '/widgets/cuotas.php';
    //register_widget('Widget_Cuotas');
    require_once __DIR__ . '/widgets/widget-content.php';
    register_widget('Widget_customContent');
}
add_action('widgets_init', 'add_widgets_custom');

// Custom excerpt excerpt
function the_excerpt_max_charlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}

// Custom excerpt content
function the_content_max_charlength($charlength) {
   // $excerpt = get_the_content();
    $excerpt = apply_filters( 'the_content', get_the_content() );

    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}

// Custom format date post created
function custom_format_date_post() {
    $dateDay    = ''.get_the_date('j').'';
    $dateMonth  = ''.get_the_date('F').'';
    $dateYear   = ''.get_the_date('Y').'';
    ?>
    <span class="number"><?php echo $dateDay; ?></span><span class="month"><?php echo $dateMonth; ?></span><span class="year"><?php echo $dateYear; ?></span>
    <?php
}

// Custom format date post created in sigle.php
function custom_format_date_post_sinlge() {
    $dateDay    = ''.get_the_date('j').'';
    $dateMonth  = ''.get_the_date('F').'';
    $dateYear   = ''.get_the_date('Y').'';
    ?>
    <?php echo $dateDay; ?> de <span class="month month_single_page"><?php echo $dateMonth; ?></span> del <?php echo $dateYear; ?>
    <?php
}

// Custom format date claims
function custom_format_date_claims() {
    $dateDay    = ''.get_the_date('d').'';
    $dateMonth  = ''.get_the_date('m').'';
    $dateYear   = ''.get_the_date('Y').'';
    ?>
    <span><?php echo $dateDay; ?>.<?php echo $dateMonth; ?>.<?php echo $dateYear; ?></span>
    <?php
}

// Custom format date post created
function date_post() {
    $dateDay    = ''.get_the_date('j').'';
    $dateMonth  = ''.get_the_date('M').'';
    ?>
    <span class="number"><?php echo $dateDay; ?></span><span class="month"><?php echo $dateMonth; ?></span>
    <?php
}

//customize the PageNavi HTML before it is output
add_filter( 'wp_pagenavi', 'wd_pagination', 10, 2 );
function wd_pagination($html) {
    $out = '';
    $out = str_replace("<a","<li><a",$html);
    $out = str_replace("</a>","</a></li>",$out);
    $out = str_replace("<span","<li><span",$out);
    $out = str_replace("</span>","</span></li>",$out);
    $out = str_replace("<div class='wp-pagenavi'>","",$out);
    $out = str_replace("</div>","",$out);

    return '<div class="pagination">
            <ul>'.$out.'</ul>
        </div>';
}

/*
---------------------------------------------------
MIGRATE FUNCTIONALITY > THEME OLD
---------------------------------------------------
*/

/*-----------------------------------
Add column wp-admin post-slider
-----------------------------------*/
function custom_columns_slider_head($defaults) {
    $defaults['id_column']  = 'Shortcode';
    return $defaults;
}
function custom_columns_slider_content($column_name, $post_ID) {
    global $post;
    if ($column_name == 'id_column') {
        echo '<input type="text" onfocus="this.select();" readonly="readonly" value="[slider id=&quot;'. $post_ID . '&quot;]" class="large-text code">';
    }
}
add_filter('manage_slider_adp_posts_columns', 'custom_columns_slider_head');
add_action('manage_slider_adp_posts_custom_column', 'custom_columns_slider_content', 10, 3);



// ADD NEW COLUMN
function custom_columns_head($defaults) {
    $defaults['id_column']  = 'Probabilidad / Noticia';
    return $defaults;
}
function custom_columns_content($column_name, $post_ID) {
    if ($column_name == 'id_column') {
            $post_object = get_field('partidos-probabilidades');
            if( $post_object ): $post = $post_object;
            setup_postdata( $post );  ?>
                <strong>Probabilidad</strong>
            <?php else:{ ?>
                Noticia
            <?php }
            endif;
    }
}
add_filter('manage_post_posts_columns', 'custom_columns_head');
add_filter('manage_post_posts_custom_column', 'custom_columns_content', 10, 3);

// ADD NEW COLUMN CASAS DEA APUESTAS
function custom_columns_head_ca($defaults) {
    $defaults['id_column']  = 'Estado';
    return $defaults;
}
function custom_columns_content_ca($column_name, $post_ID) {
    if ($column_name == 'id_column') {
        $post_object = get_post_meta($post_ID, 'casa_de_apuesta', true);
        if( $post_object ): $post = $post_object;
            echo "Casa Verificada";
        else:{
            echo "";
        }
    endif;
    }
}
add_filter('manage_casa-apuesta_posts_columns', 'custom_columns_head_ca');
add_filter('manage_casa-apuesta_posts_custom_column', 'custom_columns_content_ca', 10, 3);

function custom_columns_head_ca_d($defaults) {
    $defaults['id_column_1']  = 'Destacado';
    return $defaults;
}
function custom_columns_content_ca_d($column_name, $post_ID) {
    if ($column_name == 'id_column_1') {
        $post_object = get_post_meta($post_ID, 'casa_de_apuesta_destacado', true);
        if( $post_object ): $post = $post_object;
            echo "Si";
        else:{
            echo "";
        }
    endif;
    }
}
add_filter('manage_casa-apuesta_posts_columns', 'custom_columns_head_ca_d');
add_filter('manage_casa-apuesta_posts_custom_column', 'custom_columns_content_ca_d', 10, 3);

// Widget init
function register_widgets_array() {
    $sidebars = array (
        'default'               => 'Default',
        'introtext'             => 'Intro text',
        'banner-content-top'    => 'Banner Content Top',
        'banner-content-bottom' => 'Banner Content Bottom',
        'sidebar-left'          => 'Sidebar Lef',
        'sidebar-right'         => 'Sidebar Righ',
        'sidebar-rentabilidad'  => 'Sidebar Rentabilidad',
        'sidebar-membresia'     => 'Sidebar Membresia',
    );
    foreach ( $sidebars as $id => $sidebar) {
    register_sidebar(
        array (
            'name'          => __( $sidebar, 'apuestasdeportivas' ),
            'id'            => $id,
            'before_widget' => '<div class="widget" id="%1$s"><div id="margin-custom">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action( 'widgets_init', 'register_widgets_array' );

/* SHORTCODE STAR */

//[star number="1"]
function wp_listStarCustom($atts, $content = null) {
    $a = shortcode_atts( array(
        'number' => '1',
    ), $atts );
    ob_start();
    ?>

    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/star-00<?php echo $atts['number'] ?>.png" alt="">

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('star', 'wp_listStarCustom');

function get_max_values_from_pagan_las_casas($postID)
{
    $max_value_1 = 0;
    $max_value_x = 0;
    $max_value_2 = 0;

    $max_house_1 = array();
    $max_house_x = array();
    $max_house_2 = array();

    $av_value_1 = 0;
    $av_value_x = 0;
    $av_value_2 = 0;

    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 1000,
        'post_type' => 'pagan-las-casas',
        'meta_query' => array(array('key' => '_wpcf_belongs_probabilidades_id', 'value' => $postID))
    );

    $pagan_las_casas = get_posts($args);

    foreach($pagan_las_casas as $pc)
    {
        $string_value_1 = get_post_meta($pc->ID, 'wpcf-valor-1', true);
        $string_value_x = get_post_meta($pc->ID, 'wpcf-valor-x', true);
        $string_value_2 = get_post_meta($pc->ID, 'wpcf-valor-2', true);

        $p_1 = 0;
        $p_x = 0;
        $p_2 = 0;
        $div_denom = 0;

        if(is_numeric($string_value_1))
        {
            $value = floatval($string_value_1);
            if($value > $max_value_1) {
                $max_value_1 = $value;
                $max_house_1 = array($pc->ID);
            } elseif($value == $max_value_1) {
                $max_house_1[] = $pc->ID;
            }
            $p_1 = 100/$value;
            $div_denom = 1/$value;
        }

        if(is_numeric($string_value_x))
        {
            $value = floatval($string_value_x);
            if($value > $max_value_x) {
                $max_value_x = $value;
                $max_house_x = array($pc->ID);
            } elseif($value == $max_value_x) {
                $max_house_x[] = $pc->ID;
            }
            $p_x = 100/$value;
            $div_denom += 1/$value;
        }

        if(is_numeric($string_value_2))
        {
            $value = floatval($string_value_2);
            if($value > $max_value_2) {
                $max_value_2 = $value;
                $max_house_2 = array($pc->ID);
            } elseif($value == $max_value_2) {
                $max_house_2[] = $pc->ID;
            }
            $p_2 = 100/$value;
            $div_denom += 1/$value;
        }

        $div = 100 / $div_denom;

        $av_value_1 += ($p_1 * $div) / 100;
        $av_value_x += ($p_x * $div) / 100;
        $av_value_2 += ($p_2 * $div) / 100;
    }

    $count = count($pagan_las_casas);
    if($count > 0)
    {
        $av_value_1 /= $count;
        $av_value_x /= $count;
        $av_value_2 /= $count;
    }

    return array(
        'max_value_1' => number_format($max_value_1, 2),
        'max_value_x' => number_format($max_value_x, 2),
        'max_value_2' => number_format($max_value_2, 2),
        'max_house_1' => $max_house_1,
        'max_house_x' => $max_house_x,
        'max_house_2' => $max_house_2,
        'av_value_1' => $av_value_1,
        'av_value_x' => $av_value_x,
        'av_value_2' => $av_value_2
    );
}

/*-----------------------------------
Shortcode [recenciones]
-----------------------------------*/
function wp_listRecenciones($content = null) {
    ob_start();

    $args = array(
        'post_type' => 'casa-apuesta',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'meta_value_num',
        'meta_key' => 'wpcf-puntaje',
        'order' => 'DESC',
    );

    $custom_query = new WP_Query($args); ?>
    <div class="news_day">
    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
			<?php
			$isverificada=get_post_meta(get_the_ID(), 'casa_de_apuesta', true);
			if($isverificada[0]=='verificada'){

				$post_now = get_post( get_the_ID() );
				$post_slug = $post_now->post_name;
			?>
        <article class="list_item_news content_info<?php echo $i; ?>" >
            <figure><?php the_post_thumbnail('thumbnail-news-home') ?></figure>

            <header><h2 id="<?php echo $post_slug; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></header>
            <?php the_excerpt(); ?>
            <footer class="news clearfix">
                <a class="btn_default green" href="<?php the_permalink(); ?>">Leer más</a>
								<?php $metaBono = get_post_meta( get_the_ID(), 'wpcf-bono', true );
                    if ($metaBono != '') {?>
                        <span class="btn_default white">Bono <?php echo $metaBono ?></span>
                    <?php } ?>
            </footer>
        </article>
			<?php } ?>
    <?php endwhile; wp_reset_query();?>
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('recenciones', 'wp_listRecenciones');

/*-----------------------------------
Shortcode [news-promociones]
-----------------------------------*/
function wp_NewsPromociones($content = null) {
    ob_start();

    if (empty($_GET['page_id_all']))
        $_GET['page_id_all'] = 1;
    if (!isset($_GET["s"])) {
        $_GET["s"] = '';
    }

    $args = array(
        'post_type'     => 'post',
        'post_status'   => 'publish',
        'posts_per_page' => 5,
        'paged' => $_GET['page_id_all'],
        'meta_query' => array(
            array(
                'key' => 'wpcf-check-promociones',
                'value' => '1',
                'compare' => 'LIKE'
        ))
    );

    $custom_query = new WP_Query($args); ?>
    <h3 class="section-title">Ultimas Promociones</h3>
    <?php if ( $custom_query->have_posts() ): ?>
        <div class="news_day">
        <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
            <article class="list_item_news content_info<?php echo $i; ?>">
                <figure><?php the_post_thumbnail('thumbnail-news-home') ?></figure>
                <header><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></header>
                <?php the_excerpt(); ?>
                <footer class="news clearfix">
                    <a class="btn_default green" href="<?php the_permalink(); ?>">Leer más</a>
                </footer>
            </article>
        <?php endwhile;  ?>
        <?php wp_reset_query(); ?>
        </div>
    <?php endif;  ?>

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

    <?php echo do_shortcode('[estract_probabilidades]') ?>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('news-promociones', 'wp_NewsPromociones');

/*-----------------------------------
Shortcode [opiniones]
-----------------------------------*/
function wp_listOpinion($content = null) {
    ob_start();
    ?>
      <table class="custom-table-responsive table_list_opiniones">
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
            <?php while ($wp_queryPost->have_posts()) : $wp_queryPost->the_post();
							$bono=get_post_meta(get_the_ID(), 'wpcf-bono', true);
							if($bono!=''){

						?>

              <tr>
                <td class="left hide_responsive"><?php echo $i++ ?>.</td>
                <td class="image cell_responsive">
                <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">
                <?php echo get_the_post_thumbnail($wp_query->ID); ?>
                </a>
                </td>
                <td class="rating cell_responsive"><?php echo get_post_meta(get_the_ID(), 'wpcf-puntaje', true); ?></td>
                <td class="bonus cell_responsive"><?php echo $bono; ?></td>
                <td class="show_only cell_responsive">
                    <span>Puntos:</span> <?php echo get_post_meta(get_the_ID(), 'wpcf-puntaje', true); ?><br>
                    <span>Bono:</span> <?php echo $bono; ?>
                </td>
                <td class="read-more-td cell_responsive"><a href="<?php the_permalink(); ?>" title="">Leer más</a></td>
                <td class="right custom-btn-list cell_responsive">
                <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">Jugar</a>
                </td>
                <td class="show_only cell_responsive">
                    <a href="<?php the_permalink(); ?>" title="">Leer más</a><br>
                    <a href="<?php echo get_post_meta(get_the_ID(), 'wpcf-url-juego', true); ?>" target="_blank" rel="nofollow" title="">Jugar</a>
                </td>
              </tr>
            <?php
							}
						endwhile;
            wp_reset_query(); ?>
            <?php endif; ?>
        </tbody>
      </table>
      <a href="<?php echo site_url(); ?>/ranking" class="btn_default_link border_b">Ver todas las casas</a>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('opiniones', 'wp_listOpinion');

/**/


// WIDGET MEJORES CUOTAS ===========================

add_action( 'widgets_init', 'mejores_cuotas_widget' );

function mejores_cuotas_widget() {
    register_widget( 'mejores_cuotas_widget' );
}

class mejores_cuotas_widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'mejores_cuotas_widget',
        'description' => 'Mejores cuotas del dia.'
        );
    $control_ops = array( 'width' => 400, 'height' => 350 );
        parent::__construct( 'mejores_cuotas_widget', 'AD - Mejores Cuotas', $widget_ops, $control_ops );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
        echo $args['before_title'] . $title .  $args['after_title'];
        }

        ?>
        <div class="wrapper_mejores_cuotas" style="background-image: url('<?php $img_cuota_widget = the_field('fondo_mc_widget', 'widget_' . $args['widget_id']); ?>');">
            <header class="widget_header clearfix">
                <h3>Mejores Cuotas</h3>
                <span class="partido_cuota"><?php $val_2 = the_field('partido_mc_widget', 'widget_' . $args['widget_id']); ?></span>
            </header>
            <article class="widget_content_cuotas">
                <ul class="row-grid no-margin">
                    <li class="column-3 no-padding"><span>1</span></li>
                    <li class="column-3 no-padding center"><span>X</span></li>
                    <li class="column-3 no-padding"><span>2</span></li>
                </ul>
                <ul class="row-grid no-margin">
                    <li class="column-3 no-padding center"><div class="items_wmc"><?php $val_1 = the_field('valor_1_mc_widget', 'widget_' . $args['widget_id']); ?></div></li>
                    <li class="column-3 no-padding center"><div class="items_wmc"><?php $val_x = the_field('valor_x_mc_widget', 'widget_' . $args['widget_id']); ?></div></li>
                    <li class="column-3 no-padding center"><div class="items_wmc"><?php $val_2 = the_field('valor_2_mc_widget', 'widget_' . $args['widget_id']); ?></div></li>
                </ul>
                <ul class="row-grid no-margin">
                    <li class="column-3 no-padding"><span><?php $valca_1 = the_field('casa_mc_1_widget', 'widget_' . $args['widget_id']); ?></span></li>
                    <li class="column-3 no-padding center"><span><?php $valca_x = the_field('casa_mc_x_widget', 'widget_' . $args['widget_id']); ?></span></li>
                    <li class="column-3 no-padding"><span><?php $valca_2 = the_field('casa_mc_2_widget', 'widget_' . $args['widget_id']); ?></span></li>
                </ul>
            </article>
        </div>
        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
        $title = sanitize_text_field( $instance['title'] );
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( current_user_can( 'unfiltered_html' ) ) {
        $instance['text'] = $new_instance['text'];
        } else {
        $instance['text'] = wp_kses_post( $new_instance['text'] );
        }
        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }
}

// WIDGET APUESTAS DEL DIA ===========================

add_action( 'widgets_init', 'apuestas_del_dia' );

function apuestas_del_dia() {
    register_widget( 'apuestas_del_dia' );
}

class apuestas_del_dia extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'apuestas_del_dia',
        'description' => 'Agregar Apuestas del Dia.'
        );
    $control_ops = array( 'width' => 400, 'height' => 350 );
        parent::__construct( 'apuestas_del_dia', 'AD - Apuestas del Dia', $widget_ops, $control_ops );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
        echo $args['before_title'] . $title .  $args['after_title'];
        }

        ?>
        <div class="wrapper_apuesta_dia">
            <header class="widget_header clearfix">
                <span>CUOTA: <?php $cuota_value = the_field('cuota_ad_widget', 'widget_' . $args['widget_id']); ?></span>
                <img src="<?php $img_casa_widget = the_field('casa_ad_widget', 'widget_' . $args['widget_id']); ?>" alt="">
            </header>
            <article>
                <ul class="list_apuestas_del_dia clearfix">
                <?php
                if( have_rows('seleccionar_apuestas_dia', 'widget_' . $args['widget_id']) ):
                    while ( have_rows('seleccionar_apuestas_dia', 'widget_' . $args['widget_id']) ) : the_row();
                        ?>
                        <li>
                            <span class="column_name"><?php the_sub_field('probabilidad_ad'); ?></span>
                            <span class="column_value">(<?php the_sub_field( 'cuota_ad' ); ?>)</span>
                        </li>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
                </ul>
            </article>
            <footer class="widget_footer">
                <span>Ganamos el 90% de las veces con nuestras apuestas del día</span>
            </footer>
        </div>
				<?php
				//$current_user = wp_get_current_user();
				//if($current_user->user_login=='dev' || $current_user->user_login=='bjornar'){
					getBettingTip();

				 //} ?>


        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
        $title = sanitize_text_field( $instance['title'] );
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( current_user_can( 'unfiltered_html' ) ) {
        $instance['text'] = $new_instance['text'];
        } else {
        $instance['text'] = wp_kses_post( $new_instance['text'] );
        }
        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }
}

/*-----------------------------------
Shortcode [partidos_destacados]
-----------------------------------*/
function wp_list_Partidos_destacados($content = null) {
    ob_start();
    ?>
            <?php
            if (empty($_GET['page_id_all']))
                $_GET['page_id_all'] = 1;
            if (!isset($_GET["s"])) {
                $_GET["s"] = '';
            }

            $args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'paged' => $_GET['page_id_all'],
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'partidos-probabilidades',
                    'value' => 'null',
                    'compare' => '!='
                )
            )
            );


           $loop = new WP_Query($args); ?>

            <?php  if($loop->have_posts()) { ?>
            <div class="news_day">
            <?php while($loop->have_posts()) : $loop->the_post(); ?>
                        <article class="list_item_news content_info">
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

                                    <?php
                                endif; ?>
                            </footer>
                        </article>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
            </div>
            <?php } ?>

                <?php
                 $qrystr = '';
                // pagination start
                    if ($loop->found_posts > get_option('posts_per_page')) {
                        echo "<nav class='pagination'><ul>";
                             if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
                            echo px_pagination($loop->found_posts,get_option('posts_per_page'), $qrystr);
                        echo "</ul></nav>";
                    }
                // pagination end
                ?>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('partidos_destacados', 'wp_list_Partidos_destacados');

/* THEME PROBABILIDAD */

function wp_read_team_1_from_xml($content = null) {
    $content = "<span class='data_read_fron_xml'>" . get_field( 'equipo_from_xml_1' ) . "</span>";
    return $content;
}
function wp_read_team_2_from_xml($content = null) {
    $content = "<span class='data_read_fron_xml'>" . get_field( 'equipo_from_xml_2' ) . "</span>";
    return $content;
}
function wp_read_perc_1_from_xml($content = null) {
    $maximum_values = get_max_values_from_pagan_las_casas(get_the_id());

    $content = "<span class='data_read_fron_xml'>" . number_format($maximum_values['av_value_1'], 2) . "%</span>";

    return $content;
}
function wp_read_perc_2_from_xml($content = null) {
    $maximum_values = get_max_values_from_pagan_las_casas(get_the_id());

    $content = "<span class='data_read_fron_xml'>" . number_format($maximum_values['av_value_x'], 2) . "%</span>";

    return $content;
}
function wp_read_perc_3_from_xml($content = null) {
    $maximum_values = get_max_values_from_pagan_las_casas(get_the_id());

    $content = "<span class='data_read_fron_xml'>" . number_format($maximum_values['av_value_2'], 2) . "%</span>";

    return $content;
}
function wp_type_event_probabilidad($content = null) {
    $terms_category = strip_tags(get_the_term_list( $post->ID, 'tipo-de-evento', '', ', ', '' ));
    $content = "<span class='data_read_fron_xml'>$terms_category</span>";

    return $content;
}
function wp_type_hour_event_probabilidad($content = null) {

    $dateMonth  = ''.get_the_date('F').'';
    $dateDay    = ''.get_the_date('j').'';
    $dateYear   = ''.get_the_date('Y').'';
    //echo $dateMonth; echo $dateDay; echo $dateYear;

    $timestamp = get_post_meta(get_the_ID(), 'wpcf-fecha-probabilidad', true);
    $date = new DateTime();
    $date->setTimestamp($timestamp);

    $formatted1 = $date->format('j');
    $formatted2 = $date->format('F');
    $formatted3 = $date->format('H:i');

    $content = "<span class='data_read_fron_xml'>$formatted1  de $formatted2 a las $formatted3 </span>";

    return $content;
}

add_shortcode('team_01', 'wp_read_team_1_from_xml');
add_shortcode('team_02', 'wp_read_team_2_from_xml');
add_shortcode('porcentaje_01', 'wp_read_perc_1_from_xml');
add_shortcode('porcentaje_02', 'wp_read_perc_2_from_xml');
add_shortcode('porcentaje_03', 'wp_read_perc_3_from_xml');
add_shortcode('type_event', 'wp_type_event_probabilidad');
add_shortcode('hour_event', 'wp_type_hour_event_probabilidad');

function custom_admin_js_probabilidad() {
    ?>
    <script>
        jQuery(document).ready(function($){
            $('#acf-field_5a6aae626ffa9').attr('disabled','disabled');
            $('#acf-field_5a6aaeba6ffab').attr('disabled','disabled');
            $('#acf-field_5a6aae866ffaa').attr('disabled','disabled');
            $('#acf-field_5a6aaf236ffad').attr('disabled','disabled');
            $('#acf-field_5a6aaf2d6ffae').attr('disabled','disabled');
        });
    </script>
    <?php
}
add_action('admin_footer', 'custom_admin_js_probabilidad');

/* COLUMNA FECHA REGISTRO USUARIO */

add_filter( 'manage_users_columns', 'rudr_modify_user_table' );

function rudr_modify_user_table( $columns ) {
    $columns['registration_date'] = 'Fecha de Registro';
    return $columns;
}
add_filter( 'manage_users_custom_column', 'rudr_modify_user_table_row', 10, 3 );
function rudr_modify_user_table_row( $row_output, $column_id_attr, $user ) {
    $date_format = 'j M, Y H:i';
    switch ( $column_id_attr ) {
        case 'registration_date' :
            return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
            break;
        default:
    }
    return $row_output;
}
add_filter( 'manage_users_sortable_columns', 'rudr_make_registered_column_sortable' );
function rudr_make_registered_column_sortable( $columns ) {
    return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
}

/* PIE REGISTER */

add_action( 'pie_register_after_register_validate','my_custom_user_role_cb', 10, 1);
//add_action( 'user_register', 'my_custom_user_role_cb', 10, 1 );
//function my_custom_user_role_cb( $user_id ) {
    //if ( isset( $_POST['radio_5'] ) ) {
        //update_user_meta($user_id, 'role', 'wpas_user');
        // wp_update_user( array ('ID' => $user_id, 'role' => 'customers' ) ) ;
    //}
//}

function my_custom_user_role_cb( $user_id ) {
   //$user_id = wp_update_user( array( 'ID' => $user_id, 'role' => $_POST['wpas_user'] ) );

   update_user_meta($user_id, 'role', 'wpas_user');
        // wp_update_user( array ('ID' => $user_id, 'role' => 'customers' ) ) ;
}

/*-----------------------------------
Shortcode [pagetag]
-----------------------------------*/
function wp_listpagetag($atts,$content) {
    ob_start();

		extract(shortcode_atts(array(
        'tagname' => '',
    ), $atts));

		$post_tag=$tagname;

		$custom_query = new WP_Query( 'tag='.$post_tag );

     ?>
    <div class="news_day">
    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
        <article class="list_item_news content_info">
					<!-- thumbnail-news-home  -->
            <figure><?php the_post_thumbnail('full') ?></figure>
            <header><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></header>
            <?php the_excerpt(); ?>
            <footer class="news clearfix">
                <a class="btn_default green" href="<?php the_permalink(); ?>">Leer más</a>
            </footer>
        </article>
    <?php endwhile; wp_reset_query();?>
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('pagetag', 'wp_listpagetag');

add_shortcode('current-year', function($atts, $content)
{
    extract(shortcode_atts(array(
        'start' => '',
    ), $atts));

    $current_year = date('Y');


    if($start === $current_year || $start === '')
        return "{$current_year}";
    else
        return "{$start} - {$current_year}";
});

function get_post_mejores_cuotas(){

$today= date_timestamp_get(date_create());

$args = array(
	'numberposts'	=> -1,
	'post_type'		=> 'probabilidades',
	'meta_query' => array(
				'relation'		=> 'AND',
        array(
            'key' => 'mostrar_en_mejores_cuotas',
            'value' => '"si"',
            'compare' => 'LIKE'
        ),
				array(
					'key'	  	=> 'wpcf-fecha-probabilidad',
					'value'	  	=> $today,
					'type' 	=> 'NUMERIC',
					'compare' 	=> '>',
				),
    )
);

$posts = get_posts($args);
$id='';
$maximum_values='';
$val1=0;
$valx=0;
$val2=0;
$house_1='';
$house_x='';
$house_2='';
$fechaprobabilidad=0;


if($posts){

	foreach($posts as $pc)
	{
	  $id=$pc->ID;

		$fechaprobabilidad_new=get_post_meta( $id , 'wpcf-fecha-probabilidad',true);

		if($fechaprobabilidad_new<$fechaprobabilidad || $fechaprobabilidad==0){

			$title=wp_get_post_title($id);

			$fechaprobabilidad=$fechaprobabilidad_new;

			$maximum_values = get_max_values_from_pagan_las_casas($id);

			$val1_new=$maximum_values['max_value_1'];
			$valx_new=$maximum_values['max_value_x'];
			$val2_new=$maximum_values['max_value_2'];

			if($val1_new>$val1){
				$val1=$val1_new;
				$house_1=$maximum_values['max_house_1'];
				$house_1_n = wp_get_post_title(get_post_meta( $house_1[0] , '_wpcf_belongs_casa-apuesta_id',true)); //wpcf-resource-category
			}
			if($valx_new>$valx){
				$valx=$valx_new;
				$house_x=$maximum_values['max_house_x'];
				$house_x_n = wp_get_post_title(get_post_meta( $house_x[0] , '_wpcf_belongs_casa-apuesta_id',true)); //wpcf-resource-category

			}
			if($val2_new>$val2){
				$val2=$val2_new;
				$house_2=$maximum_values['max_house_2'];
				$house_2_n = wp_get_post_title(get_post_meta( $house_2[0] , '_wpcf_belongs_casa-apuesta_id',true)); //wpcf-resource-category

			}
		}

	}
}

$array[]='';

$array['title_probabilidad']=$title;
$array['cuota_1']=$val1;
$array['cuota_x']=$valx;
$array['cuota_2']=$val2;
$array['casa_1']=$house_1_n;
$array['casa_x']=$house_x_n;
$array['casa_2']=$house_2_n;

return $array;
//return "Probabilidad: ".$title." | Cuotas: 1=".$val1." (".$house_1_n.") | x=".$valx." (".$house_x_n.") |  2=".$val2." (".$house_2_n.")";
}


function wp_show_post_mejores_cuotas($content = null) {
    $show = get_post_mejores_cuotas();

    $content = "<span class='show_ids'>" . $show['title_probabilidad']. $show['cuota_1'] ." ".$show['cuota_x']." ".$show['cuota_2'] . "</span>";

    return $content;
}
add_shortcode('posts_mejores_cuotas', 'wp_show_post_mejores_cuotas');

function wp_show_widget_mejores_cuotas($content = null) {

    $show = get_post_mejores_cuotas();

		$content='<header class="widget_header clearfix">
				<h3>Mejores Cuotas</h3>
				<span class="partido_cuota">'. $show['title_probabilidad'] .'</span>
		</header>
		<article class="widget_content_cuotas">
				<ul class="row-grid no-margin">
						<li class="column-3 no-padding"><span>1</span></li>
						<li class="column-3 no-padding center"><span>X</span></li>
						<li class="column-3 no-padding"><span>2</span></li>
				</ul>
				<ul class="row-grid no-margin">
						<li class="column-3 no-padding center"><div class="items_wmc">'. $show['cuota_1'] .'</div></li>
						<li class="column-3 no-padding center"><div class="items_wmc">'. $show['cuota_x'] .'</div></li>
						<li class="column-3 no-padding center"><div class="items_wmc">'. $show['cuota_2'] .'</div></li>
				</ul>
				<ul class="row-grid no-margin name_casa_row">
						<li class="column-3 no-padding"><span class="name_casa">'. $show['casa_1'] .'</span></li>
						<li class="column-3 no-padding center"><span class="name_casa">'. $show['casa_x'] .'</span></li>
						<li class="column-3 no-padding"><span class="name_casa">'. $show['casa_2'] .'</span></li>
				</ul>
		</article>';

    return $content;
}
add_shortcode('sc_mejores_cuotas', 'wp_show_widget_mejores_cuotas');

function wp_test_get_fields($content = null) {
    // $show = get_post_meta( '12999' , '', true);
		//
		// $json=json_encode($show);
		// $content=$json;
    //$content = "<span class='show_name'>" . $show . "</span>";
		//$date = date_create();
		$content= date_timestamp_get(date_create());
    return $content;
}
add_shortcode('test_get_fields', 'wp_test_get_fields');

function wp_get_post_title($postid){

	$post = get_post( $postid );
	$title = $post->post_title;

	return $title;
}


// WIDGET MEJORES CUOTAS *NUEVO* ===========================

add_action( 'widgets_init', 'mejores_cuotas_2_widget' );

function mejores_cuotas_2_widget() {
    register_widget( 'mejores_cuotas_2_widget' );
}

class mejores_cuotas_2_widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'mejores_cuotas_2_widget',
        'description' => 'Mejores cuotas del dia.'
        );
    $control_ops = array( 'width' => 400, 'height' => 350 );
        parent::__construct( 'mejores_cuotas_2_widget', 'AD - Mejores Cuotas 2', $widget_ops, $control_ops );
    }


    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
        echo $args['before_title'] . $title .  $args['after_title'];
        }



        ?>
        <div class="wrapper_mejores_cuotas" style="background-image: url('<?php $img_cuota_widget = the_field('fondo_mc_2_widget', 'widget_' . $args['widget_id']); ?>');">

				<?php $mc_2_content_widget = the_field('mc_2_content_widget', 'widget_' . $args['widget_id']); ?>


        </div>


				<?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
        $title = sanitize_text_field( $instance['title'] );
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( current_user_can( 'unfiltered_html' ) ) {
        $instance['text'] = $new_instance['text'];
        } else {
        $instance['text'] = wp_kses_post( $new_instance['text'] );
        }
        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }


}
add_shortcode('show_bettingtip', 'getBettingTip');

function getBettingTip(){

	// $args = array( 'post_type' => 'betting-tips', 'posts_per_page' => 1 );
		$args = array(
		'post_type' => 'betting-tips',
		'posts_per_page' => 1,
		'meta_key' => 'wpcf-mostrar_tip',
    'meta_value' => 1
	);
	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) : $loop->the_post();
		$tip_date = get_the_date( 'M j, Y' );
	?>
		<div class="wrapper_betting_tips">

			<div class="info_betting_tips">
				<?php if ( has_post_thumbnail() ){ ?>
					<div class="betting_tip_img">
					<?php the_post_thumbnail( 'full' ); ?>
					</div>
				<?php } ?>
				<span class="betting_tip_date"><?php echo $tip_date; ?></span>
				<br>
				<span class="betting_tip_author">Autor: <?php the_author(); ?></span>
			</div>
	  <div class="betting_tip_text">
			<?php
			$texto = get_post_meta( get_the_ID(), 'wpcf-texto_tip', true );
			echo $texto;
			 ?>
		</div>
	</div>
	<?php
endwhile;
	}
	?>
<?php

class videodeldia_Widget extends WP_Widget {


  // Set up the widget name and description.
  public function __construct() {
    $widget_options = array( 'classname' => 'videodeldia_widget', 'description' => 'Video Youtube widget' );
    parent::__construct( 'videodeldia_widget', 'Video Youtube', $widget_options );
  }


  // Create the widget output.
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $videourl = apply_filters( 'widget_text', $instance[ 'urlvideo' ] );
    $videotext = apply_filters( 'widget_text', $instance[ 'textvideo' ] );

    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
    <!-- <p><?php //echo $videourl; ?></p> -->
		<!-- https://www.youtube.com/embed/RZThVqLI7H4?controls=0 -->
		<a href="https://www.youtube.com/watch?v=<?php echo $videourl; ?>" target="_blank"><div id="IframeWrapper" style="position: relative;"><iframe width="100%" height="200" style="z-index:1" src="https://www.youtube.com/embed/<?php echo $videourl; ?>?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe><div id="iframeBlocker" style="position:absolute; top: 0; left: 0; width:95%; height:95%;background-color:aliceblue;opacity:0.1;"></div></div></a>
    <h5 style="border-bottom: 1px solid #ccc;padding: 10px;"><?php echo $videotext; ?></h5>
    <?php echo $args['after_widget'];
  }


  // Create the admin area widget settings form.
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php $urlvideo = ! empty( $instance['urlvideo'] ) ? $instance['urlvideo'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'urlvideo' ); ?>">Youtube URL code:</label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'urlvideo' ); ?>" name="<?php echo $this->get_field_name( 'urlvideo' ); ?>" value="<?php echo esc_attr( $urlvideo ); ?>" />
    </p>
    <?php $textvideo = ! empty( $instance['textvideo'] ) ? $instance['textvideo'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'textvideo' ); ?>">Descripción:</label>
			<textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('textvideo'); ?>" name="<?php echo $this->get_field_name('textvideo'); ?>"><?php echo $textvideo; ?></textarea>

    </p>
    <?php
  }


  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'urlvideo' ] = strip_tags( $new_instance[ 'urlvideo' ] );
    $instance[ 'textvideo' ] = strip_tags( $new_instance[ 'textvideo' ] );
    return $instance;
  }

}

// Register the widget.
function ad_videodeldia_widget() {
  register_widget( 'videodeldia_Widget' );
}
add_action( 'widgets_init', 'ad_videodeldia_widget' );

function register_custom_scroll(){

    wp_register_script( 'cscroll_js', get_stylesheet_directory_uri() . '/assets/js/scroll.js');
		wp_enqueue_script('cscroll_js');
}

add_action( 'wp_enqueue_scripts', 'register_custom_scroll' );

function my_post_object_result( $title, $post, $field, $post_id ) {
    $timestamp = get_post_meta($post->ID, 'wpcf-fecha-probabilidad', true);
    $date = new DateTime();
    $date->setTimestamp($timestamp);
    $title = ' ['.$post->ID.'] '.$title;
    $title .= ' ( Fecha: ' . $date->format('d-m-Y') .  ' )';
    return $title;
}
add_filter('acf/fields/post_object/result/name=partidos-probabilidades', 'my_post_object_result', 10, 4);

function my_post_object_query( $args, $field, $post_id ) {
    $args['meta_key'] = 'wpcf-fecha-probabilidad';
    $args['meta_value'] = array('');
    $args['meta_compare'] = 'NOT IN';
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    return $args;
}
add_filter('acf/fields/post_object/query/name=partidos-probabilidades', 'my_post_object_query', 10, 3);

function scripts_apdep_site() {

    wp_enqueue_style('apdepsite-css', get_stylesheet_directory_uri() . '/assets/css/apdepsite.css?v=1');
    wp_enqueue_style('apdepsite-css');

}
add_action('wp_enqueue_scripts', 'scripts_apdep_site');
 ?>
