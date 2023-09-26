<?php
/***************************************
*   Custom Widgets
***************************************/
add_action( 'vc_before_init', 'goapostas_vc_before_init_actions_apuestas24' );
function goapostas_vc_before_init_actions_apuestas24() {
    // Require new custom Widget
    require_once( get_stylesheet_directory().'/inc/widgets/bonus-loop.php' );
    require_once( get_stylesheet_directory().'/inc/widgets/news-loop-filter.php' );
    require_once( get_stylesheet_directory().'/inc/widgets/review-loop.php' );
    
}

