<?php
/*
   Plugin Name: Wp Paytoolbox
   Plugin URI: http://vatri.net
   Version: 0.1
   Author: Boris Trivic
   Description: Wordpress integration for Paytoolbox API
   Text Domain: wppaytoolbox
   Domain Path: /languages
  */

include 'WpPaytoolbox-class.php';
include 'models/WpptbProduct.php';
include 'models/WpptbCategory.php';
include 'vendor/autoload.php';


define("WPPTB_BASE_URL", "https://demo.paytoolbox.com");
define("WPPTB_API_URL", WPPTB_BASE_URL. "/shop-api");
define('WPPTB_API_USERNAME', 'test@paytoolbox.com');
define('WPPTB_API_PASSWORD', 'test');


function wppaytoolbox_init(){
	$WpPaytoolbox = new WpPaytoolbox();
	$WpPaytoolbox->init();
}

function wppaytoolbox_get_all_categories(){
	return $GLOBALS['wpptb-all-categories'];
}
function wppaytoolbox_get_category_products(){
	return $GLOBALS['wpptb-category-products'];
}
function wppaytoolbox_get_product(){
	return $GLOBALS['wpptb-product'];
}

function wpptb_start_session() {
    if(!session_id()) {
        session_start();
    }
}

add_action('plugins_loaded','wppaytoolbox_init');

add_action('init', 'wpptb_start_session', 1);
