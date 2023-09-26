<?php

/*-----------------------------------
Register CSS for Admin
-----------------------------------*/
function load_admin_style() {
    wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/assets/admin/admin.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

/*-----------------------------------
Remove options of panel
-----------------------------------*/
function the_remove_menu_cpt() {
	if( current_user_can('editor')) {
		remove_menu_page('tools.php');
		remove_menu_page('edit.php');
		remove_menu_page('edit-comments.php'); 
	}
};

add_action( 'admin_menu', 'the_remove_menu_cpt' );

/*-----------------------------------
Custom logo admin
-----------------------------------*/
function custom_login_logo() { ?>
	<style type="text/css">
		body.login #login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri() ?>/assets/admin/logo.png);
			margin-bottom: 20px;
			background-size: auto !important;
			width: auto !important;
			height: 84px;
			outline: none;
		 }
		 .login #login_error, .login .message{
				border-left: 4px solid #b0c41e !important;
		 }
	</style>
<?php }

add_action( 'login_enqueue_scripts', 'custom_login_logo' );

add_filter( 'login_headerurl', 'custom_loginlogo_url' );
 
function custom_loginlogo_url($url) {
    return get_site_url();
}