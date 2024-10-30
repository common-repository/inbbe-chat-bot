<?php

defined('ABSPATH') or die( "Bye bye" );


add_action( 'admin_menu', 'inbbe_menu_admin' );

function inbbe_menu_admin()
{
	add_menu_page(INBBE_NAME,INBBE_NAME,'manage_options',INBBE_PATH . '/admin/conf.php'); 
    add_options_page(INBBE_NAME,INBBE_NAME, 'manage_options', 'inbbe', 'inbbe_options'); 
}