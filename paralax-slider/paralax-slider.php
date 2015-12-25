<?php
/**
  * Plugin Name: Paralax Slider
  * Plugin URI: http://your-domain.com
  * Description: This plugin for add social plugin link
  * Version: 1.0.0
  * Author: You
  * Author URI: http://your-domain.com
  */
  
  
 /* define the files start*/
 if ( !defined( 'PS_PLUGIN_BASENAME' ) ) define( 'PS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
 if ( !defined( 'PS_PLUGIN_NAME' ) ) define( 'PS_PLUGIN_NAME', trim( dirname( PS_PLUGIN_BASENAME ), '/' ) );
 if ( !defined( 'PS_PLUGIN_URL' ) )	define( 'PS_PLUGIN_URL', WP_PLUGIN_URL . '/' . PS_PLUGIN_NAME ); 
  /* define the files end*/

/************************************
Class For Theme Options
*************************************/
 
 class SliderThemeOptions {
 
 		/************************************
		Function For Register The Script 
		*************************************/
 
 public static function register_scripts(){ 
 	wp_register_script( 'jquery-min', PS_PLUGIN_URL.'/js/jquery-1.7.1.min.js' );
	wp_register_script( 'jquery-cslider', PS_PLUGIN_URL.'/js/jquery.cslider.js' );
	wp_register_script( 'modernizr-custom', PS_PLUGIN_URL.'/js/modernizr.custom.28468.js' );
	wp_register_script( 'custom-js', PS_PLUGIN_URL.'/js/custom.js' );

}

 		/************************************
		Function For Enqueue The Script 
		*************************************/
 
 public static function enqueue_scripts(){ 
	wp_enqueue_script( 'jquery-min' );
	wp_enqueue_script( 'jquery-cslider' );
	wp_enqueue_script( 'modernizr-custom' );
	wp_enqueue_script( 'custom-js' );

}

	    /************************************
		Function For Register The Style
		*************************************/
    
 public static function register_styles(){
	wp_register_style( 'demo', PS_PLUGIN_URL.'/css/demo.css' );
	wp_register_style( 'style', PS_PLUGIN_URL.'/css/style.css' );
}

 		/************************************
		Function For Enqueue The Script 
		*************************************/
 
 public static function enqueue_styles(){ 
	wp_enqueue_style( 'demo' );
	wp_enqueue_style( 'style' );
}


 
 public static function registerSlidersPostType() {
	
					/************************************
					Labels for Custom Post Type(Sliders)
					*************************************/

					$labels = array(
					'name'                => _x( 'Sliders', 'Post Type General Name', 'paralax-slider' ),
					'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'paralax-slider' ),
					'menu_name'           => __( 'Sliders', 'paralax-slider' ),
					'parent_item_colon'   => __( 'Parent Slider', 'paralax-slider' ),
					'all_items'           => __( 'All Sliders', 'paralax-slider' ),
					'view_item'           => __( 'View Slider', 'paralax-slider' ),
					'add_new_item'        => __( 'Add New Slider', 'paralax-slider' ),
					'add_new'             => __( 'Add New Slider', 'paralax-slider' ),
					'edit_item'           => __( 'Edit Slider', 'paralax-slider' ),
					'update_item'         => __( 'Update Slider', 'paralax-slider' ),
					'search_items'        => __( 'Search Slider', 'paralax-slider' ),
					'not_found'           => __( 'Not Found', 'paralax-slider' ),
					'not_found_in_trash'  => __( 'Not found in Trash', 'paralax-slider' ),
					);
					
					/************************************
					Other supports for Custom Post Type(Sliders)
					*************************************/

					$args = array(
					'label'               => __( 'Sliders', 'paralax-slider' ),
					'description'         => __( 'Sliders For Users Guide', 'paralax-slider' ),
					'labels'              => $labels,
					'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields','page-attributes',),
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => 5,
					'can_export'          => true,
					'has_archive'         => true,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'capability_type'     => 'page',
					);

					/************************************
					Register Custom Post Type(Sliders)
					*************************************/

					register_post_type( 'sliders', $args );
					add_theme_support( 'post-thumbnails' );
	}
	
	                /************************************
					Create Taxonomies Post Type(Sliders)
					*************************************/
	
	public static function registerTaxonomyForSlidersPostType() {
					
					$labels = array(
					'name'              => _x( 'Sliders Categories', 'taxonomy general name' ),
					'singular_name'     => _x( 'Sliders Category', 'taxonomy singular name' ),
					'search_items'      => __( 'Search Categories' ),
					'all_items'         => __( 'All Slider Categories' ),
					'parent_item'       => __( 'Parent Categories' ),
					'parent_item_colon' => __( 'Parent Category:' ),
					'edit_item'         => __( 'Edit Categories' ),
					'update_item'       => __( 'Update Categories' ),
					'add_new_item'      => __( 'Add New Category' ),
					'new_item_name'     => __( 'New Category Name' ),
					'menu_name'         => __( 'Sliders Categories' ),
					);
					
					$args = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'sliders-category' ),
					);
					
					register_taxonomy( 'sliders-category', array( 'sliders' ), $args );
				} 
				
					public static function generateShorcode() {
					?>	
					<div id="da-slider" class="da-slider">
					<?php
					$sliders=get_posts(array(
					'post_type' => 'sliders',
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'posts_per_page'   => -1,
					));
					foreach ( $sliders as $slider ) : 
					 $url = wp_get_attachment_image_src( get_post_thumbnail_id($slider->ID), 'slider_feature_image'); 
					?>
					<div class="da-slide">
					<h2><?php echo $slider->post_title; ?></h2>
					<p><?php echo $slider->post_content; ?></p>
					<a href="<?php echo get_permalink($post->ID); ?>" class="da-link">Read more</a>
					<div class="da-img"><img src="<?php echo $url[0]; ?>" alt="image01" /></div>
					</div>
					<?php endforeach;
					?>
					<nav class="da-arrows">
					<span class="da-arrows-prev"></span>
					<span class="da-arrows-next"></span>
					</nav>
					</div>
					<?php
					}
					
					public static function generateShorcodeForCategoryWise($atts) {
				
					extract(shortcode_atts(array(
					'category'      => '',
					), $atts));
					
					$output = '<div id="da-slider" class="da-slider">.';				
					
					$sliders=get_posts(array(
					'post_type' => 'sliders',
					'tax_query' => array(
					array(
					'taxonomy' => 'sliders-category',
					'field' => 'name',
					'terms' => $category)//taxonomy name id
					))
					);
					
					foreach ( $sliders as $slider ) {
					
					 $output .= '<div class="da-slide">';
					 $output .= '<h2>'.$slider->post_title.'</h2>';
					 $output .= '<p>'.$slider->post_content.'</p>';
					 $output .= '<a href="'.get_permalink($slider->ID).'" class="da-link">Read more</a>';
					 
					 $url = wp_get_attachment_image_src( get_post_thumbnail_id($slider->ID), 'slider_feature_image');
					 $output .= '<div class="da-img"><img src="'.$url[0].'" alt="image01" /></div>';
					 $output .= '</div>';
					}
					
					 $output .= '<nav class="da-arrows">
					<span class="da-arrows-prev"></span>
					<span class="da-arrows-next"></span>
					</nav>
				    </div>';
	    		  return $output;
					}
					

 }

//CAll the functions
    add_action( 'init', array( 'SliderThemeOptions','registerSlidersPostType' ) );
	add_action( 'init', array( 'SliderThemeOptions','registerTaxonomyForSlidersPostType' ) );				

	
	add_action( 'init', array( 'SliderThemeOptions','register_scripts' ) );
	add_action( 'wp_enqueue_scripts', array( 'SliderThemeOptions','enqueue_scripts' ) );
	
	add_action( 'init', array( 'SliderThemeOptions','register_styles' ) );
	add_action( 'wp_enqueue_scripts', array( 'SliderThemeOptions','enqueue_styles' ) );

	add_shortcode('slider-shortcode', array( 'SliderThemeOptions', 'generateShorcode' ));//[slider-shortcode]
    add_shortcode( 'slider-shortcode-category', array( 'SliderThemeOptions', 'generateShorcodeForCategoryWise' ));//Like  [slider-shortcode-category category="type2"] // [slider-shortcode-category category] , [slider-shortcode-category]
	
	
	if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'slider_feature_image', 260, 260, true ); //(cropped)
	}




 ?>