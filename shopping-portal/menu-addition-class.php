<?php 
if ( !class_exists( 'HijackMe' ) ) {
class HijackMe {
public function hijack_menu($objects) {
/**
* If user isn't logged in, we return the link as normal
*/
if ( !is_user_logged_in() ) {
return $objects;
}
/**
* If they are logged in, we search through the objects for items with the
* class wl-login-pop and we change the text and url into a logout link
*/
foreach ( $objects as $k=>$object ) {
if ( in_array( 'wl-login-pop', $object->classes ) ) {
$objects[$k]->title = 'Logout';
$objects[$k]->url = wp_logout_url();
$remove_key = array_search( 'wl-login-pop', $object->classes );
unset($objects[$k]->classes[$remove_key]);
}
}
 
return $objects;
}
}
}
 
$hijackme = new HijackMe();
 
add_filter('wp_nav_menu_objects', array($hijackme, 'hijack_menu'), 10, 2);
?>