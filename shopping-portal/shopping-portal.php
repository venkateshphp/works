<?php
/*
	Plugin Name: Shopping Portal
	Plugin URI: http://www.securenext.com/ 
	Description: Shopping Stores Management.
	Version: 1.3.1
	Author: Vinoth Kumar S
	Author URI: Securenext Software
	Tested WordPress Versions: 4.0
*/

///////////////////////////////// Static ///////////////////////////////////////

if ( !defined( 'SP_PLUGIN_BASENAME' ) ) define( 'SP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( !defined( 'SP_PLUGIN_NAME' ) ) define( 'SP_PLUGIN_NAME', trim( dirname( SP_PLUGIN_BASENAME ), '/' ) );
if ( !defined( 'SP_PLUGIN_URL' ) )	define( 'SP_PLUGIN_URL', WP_PLUGIN_URL . '/' . SP_PLUGIN_NAME ); 

include_once('portal-class.php');
include_once('menu-addition-class.php');
			/************************************
			For registering Scripts
			*************************************/

add_action('init', 'register_script');

function register_script(){
	wp_register_style( 'ui-datepicker', SP_PLUGIN_URL.'/css/ui.css' );
	wp_register_style( 'shopping-ui-default-design', SP_PLUGIN_URL.'/css/shopping-page-default.css' );
	wp_register_script( 'jquery-for-datepicker', SP_PLUGIN_URL.'/js/for_date_picker/jquery.js' );
	wp_register_script( 'ui-js-jquery', SP_PLUGIN_URL.'/js/for_date_picker/jquery-ui.js' );
	wp_register_script( 'ui-calling-js', SP_PLUGIN_URL.'/js/for_date_picker/calling-js.js' );
	
	wp_register_script( 'js-jquerymin', SP_PLUGIN_URL.'/js/jquery-1.10.2.min.js' );
	wp_register_script( 'js-jqueryvalidate', SP_PLUGIN_URL.'/js/jquery.validate.min.js' );
	wp_register_script( 'js-jquerycommon', SP_PLUGIN_URL.'/js/shopping-common-js.js' );
	
	wp_register_script( 'js-jqueryajax', SP_PLUGIN_URL.'/js/ajax-shopping-header.js' );
	// Now we can localize the script with our data.
	$home_url = array( 'home_url' => get_option('home') );  // home url
	$ajax_file_url = array( 'ajax_file_url' => SP_PLUGIN_URL );  // Ajax file url
	wp_localize_script( 'js-jqueryajax', 'home_url_object', $home_url );
	wp_localize_script( 'js-jqueryajax', 'ajax_file_url_object', $ajax_file_url );	
	
}
			/************************************
			For Enqueuing Scripts For Frontend as well as backend
			*************************************/
if(is_admin()){
		add_action('admin_enqueue_scripts', 'enqueue_style');
if( ! function_exists( 'enqueue_style' ) ) {			
	function enqueue_style(){
			wp_enqueue_style( 'ui-datepicker' );
			wp_enqueue_script( 'jquery-for-datepicker' );
			wp_enqueue_script( 'ui-js-jquery' );
			wp_enqueue_script( 'ui-calling-js' );
		}
	} 
  } else {
	add_action('wp_enqueue_scripts', 'enqueue_style');
if( ! function_exists( 'enqueue_style' ) ) {	
		function enqueue_style(){
			wp_enqueue_style( 'shopping-ui-default-design' );
			wp_enqueue_script( 'js-jquerymin' );
			wp_enqueue_script( 'js-jqueryvalidate' );
			wp_enqueue_script( 'js-jquerycommon' );
			wp_enqueue_script( 'js-jqueryajax' );
		}
	}
  }
if( ! function_exists( 'loginLoutMenu' ) ) {
function loginLoutMenu( $items, $args ){
 	
		if (is_user_logged_in() && $args->theme_location == 'primary-menu') {
		$items .= '<li><a href="'. get_option('home') .'/member-information/">My Account</a></li>';
		$items .= '<li><a href="'. wp_logout_url( home_url() ) .'">Log Out</a></li>';
		}
		elseif (!is_user_logged_in() && $args->theme_location == 'primary-menu') {
		$items .= '<li><a href="'. get_option('home') .'/login/">Log In</a></li>';
		$items .= '<li><a href="'. get_option('home') .'/register/">Register</a></li>';
		}
		return $items;
		
 	}
 }	
	
add_filter( 'wp_nav_menu_items','loginLoutMenu', 10, 2 );

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'product_page_list', 675, 415, true ); //(cropped)
	add_image_size( 'store_page_image', 250, 250, true ); //(cropped)
}

/************************************
Create Pages thst are needed for our plugins
*************************************/

function myplugin_activate_create_pages() {
$args = array( 'posts_per_page'  => -1,'order' => 'DESC', 'post_type' => 'page', 'post_status' => 'any');
$posts_array = get_posts( $args ); 
foreach( $posts_array as  $post_array){ $page_slugs[] = $post_array->post_name; }
$page_titles = array('Featured', 'Favourites', 'Shopping Portal Page', 'Register', 'Login','Member Information');
$hardcoded_slugs = array('featured', 'favourites', 'shopping-portal-page', 'register', 'login','member-information');
for($k=0;$k<count($hardcoded_slugs);$k++){
if(!in_array($hardcoded_slugs[$k] , $page_slugs)){
		$my_page = array(
			'post_title' => $page_titles[$k],
			'post_content' => 'Lorum Ipsum',
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_author' => 1
		);
		
		$post_id = wp_insert_post($my_page);						
	}
  }
 }
register_activation_hook( SP_PLUGIN_BASENAME, 'myplugin_activate_create_pages' );
?>