<?php 
/************************************
*
Shopping Portal Main Class
*
*************************************/
class ThemeOptions {

	public static function registerStoresPostType() {
	
					/************************************
					Labels for Custom Post Type(Stores)
					*************************************/

					$labels = array(
					'name'                => _x( 'Stores', 'Post Type General Name', 'Shoppting-Portal' ),
					'singular_name'       => _x( 'Store', 'Post Type Singular Name', 'Shoppting-Portal' ),
					'menu_name'           => __( 'Stores', 'Shoppting-Portal' ),
					'parent_item_colon'   => __( 'Parent Store', 'Shoppting-Portal' ),
					'all_items'           => __( 'All Stores', 'Shoppting-Portal' ),
					'view_item'           => __( 'View Store', 'Shoppting-Portal' ),
					'add_new_item'        => __( 'Add New Store', 'Shoppting-Portal' ),
					'add_new'             => __( 'Add New Store', 'Shoppting-Portal' ),
					'edit_item'           => __( 'Edit Store', 'Shoppting-Portal' ),
					'update_item'         => __( 'Update Store', 'Shoppting-Portal' ),
					'search_items'        => __( 'Search Store', 'Shoppting-Portal' ),
					'not_found'           => __( 'Not Found', 'Shoppting-Portal' ),
					'not_found_in_trash'  => __( 'Not found in Trash', 'Shoppting-Portal' ),
					);
					
					/************************************
					Other supports for Custom Post Type(Stores)
					*************************************/

					$args = array(
					'label'               => __( 'stores', 'Shoppting-Portal' ),
					'description'         => __( 'Stores For Users Guide', 'Shoppting-Portal' ),
					'labels'              => $labels,
					'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
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
					Register Custom Post Type(Stores)
					*************************************/

					register_post_type( 'stores', $args );
					
	}
					/************************************
					Create Taxonomies Post Type(Stores)
					*************************************/
	
	public static function registerTaxonomyForStoresPostType() {
					
					$labels = array(
					'name'              => _x( 'Stores Categories', 'taxonomy general name' ),
					'singular_name'     => _x( 'Stores Category', 'taxonomy singular name' ),
					'search_items'      => __( 'Search Categories' ),
					'all_items'         => __( 'All Stores Categories' ),
					'parent_item'       => __( 'Parent Categories' ),
					'parent_item_colon' => __( 'Parent Category:' ),
					'edit_item'         => __( 'Edit Categories' ),
					'update_item'       => __( 'Update Categories' ),
					'add_new_item'      => __( 'Add New Category' ),
					'new_item_name'     => __( 'New Category Name' ),
					'menu_name'         => __( 'Stores Categories' ),
					);
					
					$args = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'store_cat' ),
					);
					
					register_taxonomy( 'store_cat', array( 'stores' ), $args );
				} 

			/************************************
			Adding Meta Box For custom Page header Title
			*************************************/
    
	public static function store_add_custom_box() {
	
			add_meta_box('',__( 'Store', 'store_textdomain' ), 'ThemeOptions::store_inner_custom_box1', 'stores' , 'side' , 'high');
				
		}
	public static function store_inner_custom_box1( $post ) {
	
		  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
			
		  $store_offer_code = get_post_meta( $post->ID, 'store_offer_code', true );
		  echo '<label for="myplugin_new_field">';
			   _e("Offer:", 'store_textdomain' );
		  echo '</label> ';
		  echo '<input type="text" id="store_offer_code" name="store_offer_code" value="'.esc_attr($store_offer_code).'" size="27" /><br/>';
		  echo '<p style="color:red; width:100%; float:left; text-align:left; font-weight: bold; ">URL Should Not Contain (http://)<br>For Example: (www.walmart.com)<br> not Like(http://www.test.com))</p>';
		  $store_affialiate_link = get_post_meta( $post->ID, 'store_affialiate_link', true );
		  echo '<label for="myplugin_new_field">';
			   _e("Affiliate Link:", 'store_textdomain' );
		  echo '</label> ';
		  echo '<input type="text" id="store_affialiate_link" name="store_affialiate_link" value="'.esc_attr($store_affialiate_link).'" size="27" /><br/>';
		  echo '<br/>';
			

		  $store_affialiate_code = get_post_meta( $post->ID, 'store_affialiate_code', true );
		  echo '<label for="myplugin_new_field">';
			   _e("Affiliate Code:", 'store_textdomain' );
		  echo '</label> ';
		  echo '<input type="text" id="store_affialiate_code" name="store_affialiate_code" value="'.esc_attr($store_affialiate_code).'" size="27" /><br/>';
		  echo '<br/>';
			
		  $store_offer_start = get_post_meta( $post->ID, 'store_offer_start', true );
		  echo '<label for="myplugin_new_field">';
			   _e("Offer start date:", 'store_textdomain' );
		  echo '</label> ';
		  echo '<input type="text" class="datepicker" id="store_offer_start" name="store_offer_start" value="'.esc_attr($store_offer_start).'" size="27" /><br/>';
		  echo '<br/>';

		  $store_offer_end = get_post_meta( $post->ID, 'store_offer_end', true );
		  echo '<label for="myplugin_new_field">';
			   _e("Offer end date:", 'store_textdomain' );
		  echo '</label> ';
		  echo '<input type="text" class="datepicker" id="store_offer_end" name="store_offer_end" value="'.esc_attr($store_offer_end).'" size="27" /><br/>';
		  echo '<br/>';
		  
		  $featured_checkbox = get_post_meta( $post->ID, 'featured_checkbox', true );
		  echo '<label for="myplugin_new_field" style="margin-right: 3%;position: relative;bottom: 3px;">';
			   _e("Featured:", 'store_textdomain' );
		  echo '</label> '; ?>
		  <input type="checkbox" id="featured_checkbox" name="featured_checkbox" value="featured" size="27" <?php if($featured_checkbox == 'featured'){ echo "checked"; } ?>/>
		  <?php echo '<br/>';
		  echo '<hr>';
		  
		  $sort_number = get_post_meta( $post->ID, 'sort_number', true );
		  echo '<label for="myplugin_new_field">';
			   _e("Sort Number:", 'store_textdomain' );
		  echo '</label> ';
		  echo '<input type="text" id="sort_number" name="sort_number" value="'.esc_attr($sort_number).'" size="27" /><br/>';
		  echo '<br/>';
		  echo '<hr>'; 
		  
		  $active_section_check_box = get_post_meta( $post->ID, 'active_section_check_box', true );
		  echo '<label for="myplugin_new_field" style="margin-right: 3%;position: relative;bottom: 3px;">';
			   _e("Active:", 'store_textdomain' );
		  echo '</label> '; ?>
		  <input type="radio" class="featured_checkbox" name="active_section_check_box" value="activestore" size="27" <?php if($active_section_check_box == 'activestore'){ echo "checked"; } ?>/>
		  <?php 
		  echo '<label for="myplugin_new_field" style="margin-right: 3%;position: relative;bottom: 3px;">';
			   _e("Inactive:", 'store_textdomain' );
		  echo '</label> '; ?>
		  <input type="radio" class="featured_checkbox" name="active_section_check_box" value="inactivestore" size="27" <?php if($active_section_check_box == 'inactivestore'){ echo "checked"; } ?>/>
		  <?php echo '<br/>'; 
	 }
		
			/************************************
			When the post is saved, saves our custom data
			*************************************/

	public static function store_save_postdata( $post_id ) {
	
		  if ( 'page' == isset($_REQUEST['post_type']) ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		  } else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		  }
			/************************************
			Secondly we need to check if the user intended to change this value
			*************************************/
		  if ( ! isset( $_POST['myplugin_noncename'] ) || ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
			  return;
		
		  $post_ID = $_POST['post_ID'];
		  
		  $store_affialiate_code = sanitize_text_field( $_POST['store_affialiate_code'] );
		  add_post_meta($post_ID, 'store_affialiate_code', $store_affialiate_code, true) or update_post_meta($post_ID, 'store_affialiate_code', $store_affialiate_code);
		  
		  $store_offer_code = sanitize_text_field( $_POST['store_offer_code'] );
		  add_post_meta($post_ID, 'store_offer_code', $store_offer_code, true) or update_post_meta($post_ID, 'store_offer_code', $store_offer_code);
		  
		  $store_affialiate_link = sanitize_text_field( $_POST['store_affialiate_link'] );
		  add_post_meta($post_ID, 'store_affialiate_link', $store_affialiate_link, true) or update_post_meta($post_ID, 'store_affialiate_link', $store_affialiate_link);
		  
		  $store_offer_start = sanitize_text_field( $_POST['store_offer_start'] );
		  add_post_meta($post_ID, 'store_offer_start', $store_offer_start, true) or update_post_meta($post_ID, 'store_offer_start', $store_offer_start);
		  
		  $store_offer_end = sanitize_text_field( $_POST['store_offer_end'] );
		  add_post_meta($post_ID, 'store_offer_end', $store_offer_end, true) or update_post_meta($post_ID, 'store_offer_end', $store_offer_end);
		  
		  $featured_checkbox = sanitize_text_field( $_POST['featured_checkbox'] );
		  add_post_meta($post_ID, 'featured_checkbox', $featured_checkbox, true) or update_post_meta($post_ID, 'featured_checkbox', $featured_checkbox);
		  
		  $sort_number = sanitize_text_field( $_POST['sort_number'] );
		  add_post_meta($post_ID, 'sort_number', $sort_number, true) or update_post_meta($post_ID, 'sort_number', $sort_number);

		  $active_section_check_box = sanitize_text_field( $_POST['active_section_check_box'] );
		  add_post_meta($post_ID, 'active_section_check_box', $active_section_check_box, true) or update_post_meta($post_ID, 'active_section_check_box', $active_section_check_box);

 		}
			/************************************
			Creating Theme Options For Editable Header Contact Details and Social Links
			*************************************/

	public static function theme_options_init() {
			register_setting( 'sample_options', 'sample_theme_options');
	} 
	
			/************************************
			Add this upcoming theme options in separate page
			*************************************/
			
	public static function theme_options_add_page() {
			add_theme_page( __( 'Affiliate Page', 'sampletheme' ), __( 'Affiliate Page', 'sampletheme' ), 'edit_theme_options', 'affiliate_page', 'ThemeOptions::theme_options_do_page' );
	} 

			/************************************
			Creating Form Enter and update the theme option Values
			*************************************/

	public static function theme_options_do_page() {
			
		   if ( isset($_POST['update_themeoptions']) == 'true' ) { self::themeoptions_update(); }
?>	
			<div class="wrap">
				<div id="social_options">
					<h2>Affiliate Page</h2>
					<?php 
					if (isset($_POST['act_inact'])){
					
						$updated_status = $_POST['active_section_check_box'];
						for($i=0;$i<count($updated_status);$i++){
						$exploded_status = explode('_', $updated_status[$i]);
						update_post_meta($exploded_status[0], 'active_section_check_box', $exploded_status[1]);
						}
					}
					?>
					<p class="notification"></p>
				<form name="update_store_status" id="update_store_status" method="post" action="" >	
				<input type="hidden" name="update_themeoptions" value="true" />
					<input type="submit" name="act_inact" id="act_inact" class="act_inact button button-primary button-large"  value="Update" />
						<label style="margin-bottom:1%';">Left Side Category Background Color</label><br />
						<input type="text" name="general_bg" size="40" id="general_bg"  value="<?php echo get_option('general_bg'); ?>"/><br />
						<label style="margin-bottom:1%';">Left Side Category Hover Background Color</label><br />
						<input type="text" name="hover_bg" size="40" id="hover_bg"  value="<?php echo get_option('hover_bg'); ?>"/><br />

						<div class="dynamic_category_container">
							<div class="inner_portal_store1">
							<div class="logo_store" style="min-height: 40px; font-weight:bold;">
								<p>Store</p>
							</div>
							<div class="logo_store" style="min-height: 40px; font-weight:bold;">
								<p>Store Name</p>
							</div>
							<div class="logo_store" style="min-height: 40px; font-weight:bold;">
								<p>Description</p>
							</div>
							<div class="logo_store" style="min-height: 40px; font-weight:bold;">
								<p>Offer</p>
							</div>
							<div class="logo_store" style="min-height: 40px; font-weight:bold;">
								<p>Affiliate Code</p>
							</div>
							<div class="logo_store" style="min-height: 40px; font-weight:bold; width: 18%;">
								<p>Affiliate Link</p>
							</div>
							
							<div class="logo_store" style="min-height: 40px; font-weight:bold;">
								<p>Active Status</p>
							</div>
							</div>
						</div>					
					<?php 		
								$store_posts = get_posts(array('post_type' => 'stores', 'posts_per_page' => -1, 'order' => 'DESC'));
								foreach($store_posts as $store_post){
								
								$url = wp_get_attachment_image_src( get_post_thumbnail_id($store_post->ID), 'product_page_list');
								$trimmed_words = wp_trim_words($store_post->post_content, 11);
								$featured_checkbox = get_post_meta( $store_post->ID, 'featured_checkbox', true );
								$store_offer_code = get_post_meta( $store_post->ID, 'store_offer_code', true );
								$store_affialiate_code = get_post_meta( $store_post->ID, 'store_affialiate_code', true );
								$store_affialiate_link = get_post_meta( $store_post->ID, 'store_affialiate_link', true );
								if(!empty($featured_checkbox)){?>
						<div class="dynamic_category_container">
							<div class="inner_portal_store">
								<div class="logo_store">
									<img height="200" width="200" src="<?php echo $url[0]; ?>">
								</div>
								<div class="logo_store">
									<h3 style="border:none;margin: 30% 0;"><?php echo $store_post->post_title; ?></h3>
								</div>
								<div class="logo_store">
									<p><?php echo $trimmed_words; ?></p>
								</div>
								<div class="logo_store">
									<h3 style="border:none;margin: 30% 0;"><?php echo $store_offer_code; ?></h3>
								</div>
								<div class="logo_store">
									<h3 style="border:none;margin: 30% 0;"><?php echo $store_affialiate_code; ?></h3>
								</div>
								<div class="logo_store" style="width: 18%;">
									<p style="border:none;margin: 26% 0;"><?php echo $store_affialiate_link; ?></p>
								</div>
								
								<div class="logo_store">
									<div class="inner_align">
										<?php  $active_section_check_box_back = get_post_meta( $store_post->ID, 'active_section_check_box', true );
										echo '<label style="margin-right: 9%;position: relative;bottom: 3px;">';
										_e("Active:");
										echo '</label> '; 
										//$staus_value = $store_post->ID.'_'.$active_section_check_box_back; ?>
										<input type="checkbox" id="<?php echo $store_post->ID; ?>" class="<?php echo $store_post->ID; ?>_featured_checkbox1 sample_check" name="active_section_check_box[]" value="<?php echo $store_post->ID; ?>_activestore" size="27" <?php if($active_section_check_box_back == 'activestore'){ echo "checked"; } ?>/>
										<?php 
										echo '<label style="margin-right: 3%;position: relative;bottom: 3px;">';
										_e("Inactive:");
										echo '</label> '; ?>
										<input type="checkbox" id="<?php echo $store_post->ID; ?>" class="<?php echo $store_post->ID; ?>_featured_checkbox1 sample_check" name="active_section_check_box[]" value="<?php echo $store_post->ID; ?>_inactivestore" size="27" <?php if($active_section_check_box_back == 'inactivestore'){ echo "checked"; } ?>/>
										<?php echo '<br/>'; ?>
									</div>
								</div>
							</div>
						</div><!-- dynamic_category_container -->
						<?php } } ?>
						</form>
				</div>
		</div>
					<style>
					.wrap {
						float: left;
						margin: 10px 20px 0 2px;
						position: relative;
						width: 98%;
					}		
					#social_options {
						float: left;
						width: 100%;
					}								
					.inner_align {
						position: relative;
						top: 32px;
					}					
					#social_options {
					width: 100%;
					}
					.act_inact.button.button-primary.button-large {
						position: absolute !important;
						right: -325px;
						top: 30px !important;
					}					
					#social_options label {
					font-size: 15px;
					font-weight: bold;
					line-height: 45px;
					padding: 0 0 12px;
					}
					#social_options input {
					margin: 0 30% 0 0;
					position: relative;
					top: -7px;
					}
					#social_options form {
						float: left;
						margin-left: 25px;
						margin-top: 35px;
						width: 98%;
					}
					#social_options #btn {
					cursor: pointer;
					width: 100px;
					}
					.notification {
					color: red;
					font-size: 16px;
					font-weight: bold;
					padding-left: 5%;
					}
					#btn{
					background: none repeat scroll 0 0 #2ea2cc;
					border-color: #0074a2;
					box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15);
					color: #fff;
					text-decoration: none;
					border-radius: 3px;
					border-style: solid;
					border-width: 1px;
					box-sizing: border-box;
					cursor: pointer;
					display: inline-block;
					font-size: 13px;
					height: 28px;
					line-height: 26px;
					margin: 5% 0 0 2%;
					padding: 0 10px 1px;
					text-decoration: none;
					white-space: nowrap;					
					}
					.favourite_check {
						position: relative;
						top: 38px;
					}
					.logo_store > p {
						font-size: 13px;
						margin: 1%;
						padding: 4%;
						text-align: center;
					}
					.dynamic_category_container{ width:100%; float:left;}	
					.dynamic_category_container:last-child{ border-bottom: 1px solid #000; }	
					.inner_portal_store {
						border-right: 1px solid #000;
						border-left: 1px solid #000;
						border-bottom:none;
						border-top: 1px solid #000;
						float: left;
						text-align: center;
						width: 99.5%;
					}
					.inner_portal_store1 {
						border-right: 1px solid #000;
						border-left: 1px solid #000;
						border-bottom:none;
						border-top: 1px solid #000;
						float: left;
						text-align: center;
						width: 99.5%;
					}
					
					.logo_store {
						position:relative;
						float: left;
						width: 13%;
						border-right: 1px solid #000;
						min-height: 162px;
					}
					.inner_portal_store .logo_store:last-child { 
						border-right: medium none;
						width: 15%;
						 }
					.inner_portal_store1 .logo_store:last-child { 
						border-right: medium none;
						width: 15%;
					}						 
					.logo_store > img {
						float: left;
						height: auto;
						width: 100%;
						min-height: 110px;
					}
														
					</style>	
<?php 
		}
			/************************************
			Update the Contact theme option values
			*************************************/
		
	 public static function themeoptions_update() {
	  
			update_option( 'general_bg', $_POST['general_bg'] );
			update_option( 'hover_bg', $_POST['hover_bg'] );
			
		}
	public static function myplugin_activate_create_menus_locations() {
		$locations = get_registered_nav_menus();
		foreach($locations as $location => $menu_display_name){ $location_alone[] = $location; }
		if(!in_array('primary-menu', $location_alone)){
			register_nav_menu('primary-menu', __('Primary Menu'));
			}
	
		}
		

	}
		
		add_action( 'init', array( 'ThemeOptions','registerStoresPostType' ) );
		add_action( 'init', array( 'ThemeOptions','registerTaxonomyForStoresPostType' ) );
		add_action( 'init', array( 'ThemeOptions','myplugin_activate_create_menus_locations' ) );
		
		add_action( 'admin_init', array( 'ThemeOptions', 'theme_options_init' ) );
		add_action( 'admin_menu', array( 'ThemeOptions', 'theme_options_add_page' ) );
		add_action( 'theme_update_actions', array( 'ThemeOptions', 'theme_options_do_page' ) );
		
		add_action( 'add_meta_boxes',array( 'ThemeOptions', 'store_add_custom_box' ));
		add_action( 'save_post', array( 'ThemeOptions', 'store_save_postdata') );
?>