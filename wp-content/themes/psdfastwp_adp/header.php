<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="author" content="<?php bloginfo('name'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" >
    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/ap24cl_logo.png">
		<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper_site">
    <header class="header">
        <div class="toolbar">
            <div class="wrapper clearfix">
                <div class="content_header_table" style="float: left;">
                    <div class="logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ap24cl_logo.png" alt="" height="150">
                        </a>
                    </div>
                </div>
								<div class="apdep_slogan">
									  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/SLOGAN_apuestas_Chile.png" alt="" height="145">
								</div>
                <!-- <div class="content_header_table" style="float: right;">
                    <ul class="menu-top clearfix">
                        <?php
                        /*if ( is_user_logged_in() ) {
                            ?>
                            <li><a href="<?php echo esc_url( home_url( '' ) ); ?>/mis-reclamos">Mi Cuenta</a></li>
                            <li><a href="<?php echo esc_url( home_url( '' ) ); ?>/?piereg_logout_url=true&redirect_to=http%3A%2F%2Fapuestasdeportivas.pe">Cerrar Sesion</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="<?php echo esc_url( home_url( '' ) ); ?>/registro">Registrate</a></li>
                            <li><a href="<?php echo esc_url( home_url( '' ) ); ?>/login">Iniciar Sesion</a></li>
                            <?php
                        }*/
                        ?>
                    </ul>
                </div> -->
            </div>
        </div>
        <nav>
            <div class="wrapper clearfix">
                <div class="headerbar">
                <div class="headerbar_menu clearfix">
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class' => 'menu receive_clone clearfix',
                    'container' => '',
                    'container_class' => ''
                ));
                ?>
								<div class="search-bar"><?php get_search_form() ?></div>
                <div class="menu_open">&#9776;</div>
                </div>
            </div>
            </div>
        </nav>

    </header>
    <div class="overlay_menu_responsive"></div>
    <div id="sidenav_menu" class="sidenav">
        <div class="menu_close">&times;</div>
        <div class="content_menu_responsive"></div>
    </div>
