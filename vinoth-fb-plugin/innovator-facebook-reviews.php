<?php
    /*
    Plugin Name: innovator-facebook-reviews
    Plugin URI: http://www.innovator.se/
    Description: Plugin for displaying facebook-reviews
    Author: Jonas Stensved
    Version: 1.0
    Author URI: http://www.innovator.se/
    */
?>
<?php 
/************************************
*
Facebook Reviews
*
*************************************/
require_once 'src/config.php';
require_once 'src/facebook.php';
require_once 'reviews-posts.php';
require_once 'fetching-fb-reviews-frontend.php';

class facebookReviews {

			/************************************
			Creating Theme Options For Facebook page setting
			*************************************/

	public static function theme_options_init_fbrvs() {
			register_setting( 'theme_options', 'theme_options');
	} 
	
			/************************************
			Add this options in separate page
			*************************************/
			
	public static function theme_options_add_facebook_page() {
			add_options_page( __( 'Facebook Reviews', 'sampletheme' ), __( 'Facebook Reviews', 'sampletheme' ), 'edit_theme_options', 'facebook_reviews_settings', 'facebookReviews::theme_options_do_facebook_page' );
	} 

			/************************************
			Creating UI for entering facebook details
			*************************************/

	public static function theme_options_do_facebook_page() {
			
		   	if ( $_POST['update_themeoptions_fb'] == 'true' ) { self::themeoptions_update_fbrvs(); }
			/************************************
			save auth key from facebook if callback from oauth
			*************************************/
			if(isset($_GET['code'])){
				
			   $fbrvs_appid = get_option('fbrvs_app_id');
			   $fbrvs_app_secret = get_option('fbrvs_secret_key');
			   $call_back = admin_url().'options-general.php?page=facebook_reviews_settings';
				
				$facebooka = new Facebook(array(
									'appId'  => $fbrvs_appid,
									'secret' => $fbrvs_app_secret,
									'cookie' => true
								));
	
				$token_url = "https://graph.facebook.com/oauth/access_token?"
				. "client_id=".$fbrvs_appid."&redirect_uri=" . urlencode($call_back)
				. "&client_secret=".$fbrvs_app_secret."&code=" . $_GET['code'];
				
			/************************************
			get access token from url
			*************************************/
				
				$response = file_get_contents($token_url);  
				$params = null;
				
				parse_str($response, $params);
				
				$getting_access = $params['access_token'];
				update_option( 'fbrvs_access_token', $getting_access );
				
			}
?>	
			<div class="wrap">
				<div id="social_options">
					<h2>Facebook Application Details</h2>
					<p class="notification"></p>
					<form method="post" action="<?php echo admin_url('options-general.php?page=facebook_reviews_settings'); ?>" name="header_form" id="header_form" >
						<input type="hidden" name="update_themeoptions_fb" value="true" />
						<label for="metakeyselect">Facebook App ID</label><br />
						<input type="text" name="fbrvs_app_id" size="40" id="fbrvs_app_id"  value="<?php echo get_option('fbrvs_app_id'); ?>"/><br />
						<label>Facebook App Secret Key</label><br />
						<input type="text" name="fbrvs_secret_key" size="40" id="fbrvs_secret_key"  value="<?php echo get_option('fbrvs_secret_key'); ?>"/><br />
						<label>Facebook Page</label><br />                        
						<?php
							$access_token_for_graph = get_option('fbrvs_access_token');
							if(!empty($access_token_for_graph)){

						/************************************
						Access token is saved in option, use it to fetch pages from FB API
						*************************************/

							$graph_url_pages = "https://graph.facebook.com/me/accounts?access_token=".$access_token_for_graph;
							$pages = json_decode(file_get_contents($graph_url_pages)); // get all pages information from above url.
						?>
							<div class="align_position">
								<select name="fbrvs_page_info" id="fbrvs_page_info" style="width:30%;" >
							<?php
						/************************************
						Feedback: Consider using a foreach-loop here instead
						*************************************/

								for($i=0;$i<count($pages->data);$i++)
								{
								echo "<option value='".$pages->data[$i]->access_token."-".$pages->data[$i]->id."'>".$pages->data[$i]->name."</option>";
								}
								
						/************************************
						for condition access token
						*************************************/
							?>
								</select>
								
							</div>
						<?php } else {
						/************************************
						No access token, as user to connect to facebook
						*************************************/

						$call_back = admin_url().'options-general.php?page=facebook_reviews_settings';
						?>   
						<div class="align_position">
						<a href="https://www.facebook.com/dialog/oauth?client_id=<?php echo get_option('fbrvs_app_id'); ?>&redirect_uri=<?php echo $call_back; ?>&scope=manage_pages">Sign in with Facebook</a><br />
						</div>
						<?php }	?>                        
						<input id="btn" class="button button-primary button-large" type="submit" value="Save/Update" name="req_submit" />	
					</form>
					<?php if(!empty($access_token_for_graph)){ ?>
					<form class="align_disconnect" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
						<input type="hidden" name="action" value="disconnect_fb">
						<input class="button button-primary button-large" type="submit" value="Disconnect">
					</form>
					
						<!--<a href="<?php //echo admin_url('options-general.php?page=facebook_reviews_settings&disconnect=true'); ?>">Disconnect</a><br />-->
					<?php } ?>
				</div>
			<?php 
			if(!empty($access_token_for_graph)){
			?>
				<div id="social_options">
					<h2>Sync Facebook Reviews To Our Admin Panel</h2>
					<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
						<input type="hidden" name="action" value="fetch_fb">
						<input class="button button-primary button-large" type="submit" value="Sync Now">
					</form>
					<p class="notification">Click Here to Fetch the Reviews From Facebook With Selected Page To our FB Reviews Posts</p>
				</div>	
			<?php }	?>
			
			</div>
		<style type="text/css">
					.wrap p{
					margin:0;
					}
					.align_disconnect{
					bottom: 0;
					left: 140px;
					margin: 0 !important;
					position: absolute;
					width: 16%;
					}
					.align_position {
					float: left;
					margin-bottom: 4%;
					margin-top: 2%;
					width: 100%;
					}
					#social_options {
					width: 50%;
					position:relative;
					}
					#social_options label {
					font-size: 15px;
					font-weight: bold;
					padding: 0 0 12px;
					}
					#social_options input {
					margin: 0 0 25px;
					}
					#social_options form {
					margin-left: 25px;
					margin-top:35px;
					}
					.notification {
					color: red;
					font-size: 16px;
					font-weight: bold;
					padding-left: 0%;
					}
						
		</style>
<?php 
		}
			/************************************
			Update the Facebook Details
			*************************************/
		
	 public static function themeoptions_update_fbrvs() {
	  
			update_option( 'fbrvs_app_id', $_POST['fbrvs_app_id'] );
			update_option( 'fbrvs_secret_key', $_POST['fbrvs_secret_key'] );
			update_option( 'fbrvs_page_info', $_POST['fbrvs_page_info'] );
		
		} 
	public static function fetchingFacebookReviewsToAdmin() {
       
				$fbrvs_appid = get_option('fbrvs_app_id');
				$fbrvs_app_secret = get_option('fbrvs_secret_key');
				$selected_page_data_for_fetch = explode('-',get_option('fbrvs_page_info'));
				
				/**********************************
				 Fetching Our App Details From Plugin Options
				**********************************/
				$facebook = new Facebook(array(
				  'appId'  => $fbrvs_appid,
				  'secret' => $fbrvs_app_secret,
				  'cookie' => true
				));
				/**********************************
				 Facebook API call to Fetch the Ratings By Using Acces token and Page ID
				**********************************/
				$reviews_details = $facebook->api('/'.$selected_page_data_for_fetch[1].'/ratings', 'GET', array('access_token' => $selected_page_data_for_fetch[0] ));        
				$loop_count = count($reviews_details[data]);
				$args = array('posts_per_page' => -1,'order' => 'DESC','post_type' => 'fb_reviews','post_status' => 'publish');
				$fb_posts = get_posts( $args );
				/**********************************
				Neglecting The Reviews Post Duplication
				**********************************/
				foreach($fb_posts as $fb_post){ $fetched_users[] = get_post_meta( $fb_post->ID, 'fbrvs_user_id', true ); }
				/**********************************
				 Creating New Reviews Post By Using The Facebook Reviews Data
				**********************************/
				foreach($reviews_details[data] as $key => $reviews_detail){
						$user_id = $reviews_detail[reviewer][id];
						$user_name = $reviews_detail[reviewer][name];
						$user_rating = $reviews_detail[rating];
						$user_review_text = $reviews_detail[review_text];
						$post_date = gmdate('Y-m-d H:i:s', strtotime($reviews_detail[created_time]));
						if(!in_array($user_id, $fetched_users)){
						$new_review = array(
						'post_content'          => $user_review_text,
						'post_title'            => $user_name,
						'post_status'           => 'publish', 
						'post_type'             => 'fb_reviews',
						'post_date'      =>  $post_date,
						);							
						$fbrvs_post_id = wp_insert_post($new_review, true);
						add_post_meta($fbrvs_post_id, 'fbrvs_user_id', $user_id, true);
						add_post_meta($fbrvs_post_id, 'fbrvs_user_rating', $user_rating, true);
					}
				 } //end foreach

				/**********************************
				 Redirect Back To Plugin Page
				**********************************/

        wp_redirect(admin_url("options-general.php?page=facebook_reviews_settings"));
    	
		}/*** End Function ****/
	public static function disconnectingFacebookReviews() {		
			delete_option('fbrvs_access_token');
 			wp_redirect(admin_url("options-general.php?page=facebook_reviews_settings"));			
		}
	 } /*** End Class ****/ 
				/**********************************
				 Add Actions Used For Facebook Function Hooks
				**********************************/
		add_action( 'admin_init', array( 'facebookReviews', 'theme_options_init_fbrvs' ) );
		add_action( 'admin_menu', array( 'facebookReviews', 'theme_options_add_facebook_page' ) );
		add_action( 'theme_update_actions', array( 'facebookReviews', 'theme_options_do_facebook_page' ) );
		add_action( 'admin_post_fetch_fb', array( 'facebookReviews', 'fetchingFacebookReviewsToAdmin') );
		add_action( 'admin_post_disconnect_fb', array( 'facebookReviews', 'disconnectingFacebookReviews') );
//		if (isset($_GET['disconnect']))
//		{
//				delete_option('fbrvs_access_token');
//		}
?>