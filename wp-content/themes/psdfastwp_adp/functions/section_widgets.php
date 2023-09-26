<?php

// Widget init
function default_widgets_init() {
    $sidebars = array (
        'default'   => 'Default',
        'language'  => 'Idiomas',
        'sitemap'   => 'Site Map',
        'copyright' => 'Copyright',
    );  
    foreach ( $sidebars as $id => $sidebar) {
    register_sidebar(
        array (
            'name'          => __( $sidebar, 'staffdigital' ),
            'id'            => $id,
            'before_widget' => '<div class="widget" id="%1$s"><div class="widget_margin">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h3 class="title_widget">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action( 'widgets_init', 'default_widgets_init' );