<?php
// Register Custom Post Type
function cpt_services() {

	$labels = array(
		'name'                  => _x( 'Servicios', 'Post Type General Name', 'apuestas_deportivas' ),
		'singular_name'         => _x( 'Servicio', 'Post Type Singular Name', 'apuestas_deportivas' ),
		'menu_name'             => __( 'Servicios', 'apuestas_deportivas' ),
		'name_admin_bar'        => __( 'Servicio', 'apuestas_deportivas' ),
		'archives'              => __( 'Item Archives', 'apuestas_deportivas' ),
		'attributes'            => __( 'Item Attributes', 'apuestas_deportivas' ),
		'parent_item_colon'     => __( 'Parent Item:', 'apuestas_deportivas' ),
		'all_items'             => __( 'Todo los Servicios', 'apuestas_deportivas' ),
		'add_new_item'          => __( 'Agregar Nuevo Servicio', 'apuestas_deportivas' ),
		'add_new'               => __( 'Agregar Nuevo', 'apuestas_deportivas' ),
		'new_item'              => __( 'Nuevo Servicio', 'apuestas_deportivas' ),
		'edit_item'             => __( 'Editar Servicio', 'apuestas_deportivas' ),
		'update_item'           => __( 'Actualziar Servicio', 'apuestas_deportivas' ),
		'view_item'             => __( 'Ver Servicio', 'apuestas_deportivas' ),
		'view_items'            => __( 'Ver Servicios', 'apuestas_deportivas' ),
		'search_items'          => __( 'Search Item', 'apuestas_deportivas' ),
		'not_found'             => __( 'Not found', 'apuestas_deportivas' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'apuestas_deportivas' ),
		'featured_image'        => __( 'Imagen Principal', 'apuestas_deportivas' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'apuestas_deportivas' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'apuestas_deportivas' ),
		'use_featured_image'    => __( 'Utilizar como imagen destacada', 'apuestas_deportivas' ),
		'insert_into_item'      => __( 'Insert into item', 'apuestas_deportivas' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'apuestas_deportivas' ),
		'items_list'            => __( 'Items list', 'apuestas_deportivas' ),
		'items_list_navigation' => __( 'Items list navigation', 'apuestas_deportivas' ),
		'filter_items_list'     => __( 'Filter items list', 'apuestas_deportivas' ),
	);
	$args = array(
		'label'                 => __( 'Servicio', 'apuestas_deportivas' ),
		'description'           => __( 'Post Type Description', 'apuestas_deportivas' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', ),
		'taxonomies'            => array( 'categoria-servicio' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-megaphone',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'servicio', $args );

}
add_action( 'init', 'cpt_services', 0 );