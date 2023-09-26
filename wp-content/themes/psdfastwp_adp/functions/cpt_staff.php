<?php
// Register Custom Post Type
function cpt_Staffs() {

	$labels = array(
		'name'                  => _x( 'Staffs', 'Post Type General Name', 'apuestas_deportivas' ),
		'singular_name'         => _x( 'Staff', 'Post Type Singular Name', 'apuestas_deportivas' ),
		'menu_name'             => __( 'Staffs', 'apuestas_deportivas' ),
		'name_admin_bar'        => __( 'Staff', 'apuestas_deportivas' ),
		'archives'              => __( 'Item Archives', 'apuestas_deportivas' ),
		'attributes'            => __( 'Item Attributes', 'apuestas_deportivas' ),
		'parent_item_colon'     => __( 'Parent Item:', 'apuestas_deportivas' ),
		'all_items'             => __( 'Todo los Staffs', 'apuestas_deportivas' ),
		'add_new_item'          => __( 'Agregar Nuevo Staff', 'apuestas_deportivas' ),
		'add_new'               => __( 'Agregar Nuevo', 'apuestas_deportivas' ),
		'new_item'              => __( 'Nuevo Staff', 'apuestas_deportivas' ),
		'edit_item'             => __( 'Editar Staff', 'apuestas_deportivas' ),
		'update_item'           => __( 'Actualziar Staff', 'apuestas_deportivas' ),
		'view_item'             => __( 'Ver Staff', 'apuestas_deportivas' ),
		'view_items'            => __( 'Ver Staffs', 'apuestas_deportivas' ),
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
		'label'                 => __( 'Staff', 'apuestas_deportivas' ),
		'description'           => __( 'Post Type Description', 'apuestas_deportivas' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', ),
		'taxonomies'            => array( 'categoria-Staff' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'staff', $args );

}
add_action( 'init', 'cpt_Staffs', 0 );