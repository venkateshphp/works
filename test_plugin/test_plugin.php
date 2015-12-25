<?php
/*include("ajax/ajax.php");*/
/**
  * Plugin Name: Add Social Link
  * Plugin URI: http://your-domain.com
  * Description: This plugin for add social plugin link
  * Version: 1.0.0
  * Author: You
  * Author URI: http://your-domain.com
  */
  
  
 /* define the files start*/
 if ( !defined( 'TO_PLUGIN_BASENAME' ) ) define( 'TO_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
 if ( !defined( 'TO_PLUGIN_NAME' ) ) define( 'TO_PLUGIN_NAME', trim( dirname( TO_PLUGIN_BASENAME ), '/' ) );
 if ( !defined( 'TO_PLUGIN_URL' ) )	define( 'TO_PLUGIN_URL', WP_PLUGIN_URL . '/' . TO_PLUGIN_NAME ); 
  /* define the files end*/

/**
 * Proper way to enqueue scripts and styles
 */
 
 
 
/************************************
Class For Theme Options
*************************************/
 
 class ThemeOptions {
 
		/************************************
		Function For Register The Script 
		*************************************/
 
 public static function register_script1(){ 
 	wp_register_script( 'script-name', TO_PLUGIN_URL.'/js/jquery-1.10.2.min.js' );
	wp_register_script( 'test-script-name', TO_PLUGIN_URL.'/js/test.js' );
	
	wp_register_script( 'ace_code_highlighter_js', TO_PLUGIN_URL.'/js/ace.js' );
	wp_register_script( 'ace_mode_js', TO_PLUGIN_URL.'/js/mode-css.js' );
	wp_register_script( 'custom_css_js', TO_PLUGIN_URL.'/js/custom-css.js' );
}
     
	    /************************************
		Function For Register The Style
		*************************************/
    
 public static function enqueue_style1(){
	wp_enqueue_script( 'script-name' );
	wp_enqueue_script( 'test-script-name' );
	
	wp_enqueue_script( 'ace_code_highlighter_js' );
	wp_enqueue_script( 'ace_mode_js' );
	wp_enqueue_script( 'custom_css_js' );
}

		
		    /************************************
			    	Creating Theme Options 
			*************************************/
	public static function theme_options_init() {
			register_setting( 'sample_options', 'sample_theme_options');
           /* register_setting( 'custom_css', 'custom_css',  'custom_css_validation');*/
	} 		
		
		    /************************************
			Add this upcoming theme options in separate page
			*************************************/
			
	public static function theme_options_add_page() {
     	add_theme_page( __( 'Theme Options', 'sampletheme' ), __( 'Theme Options', 'sampletheme' ), 'edit_theme_options', 'theme_options', 'ThemeOptions::theme_options_do_page' );
  	} 

		    /************************************
			Creating Form Enter and update the theme option Values
			*************************************/

	public static function theme_options_do_page() {
	 ?>
	<div class="buttons">
	 <input type="button" id="social_btn" value="Social Links"/><input type="button" id="favicon_btn" value="FavIcon"/><input type="button" id="custom_css_btn" value="Custom Css"/>			     </div>
	 
	      <!--social link start-->
		  
		<div class="social_tab"<?php if(isset($_POST['fav_submit'])||isset($_POST['custom_css'])){ ?>  style="display:none;"<?php }elseif(isset($_POST['req_submit'])){ ?> style="display:block;" <?php } ?> >
			<?php
				if ( isset($_POST['update_themeoptions']) == 'true' ) { /*themeoptions_update();*/ }
			?>	
			<div class="wrap">
				<div id="social_options">
					<h2>Social Icon Links</h2>
					<form method="post" action="" name="social_form" id="social_form" enctype="multipart/form-data">
						<input type="hidden" name="update_themeoptions" value="true" />
				<!--added new for file uplaod start-->	
				<?php
				if(isset($_POST['social_url'])) {
				//added for move the images  in upload folders start
				if(!empty($_FILES)) {
				foreach($_FILES["uplaoded_files"]["name"] as $key => $value) {
				//echo "key value=".$key;
				if(!empty($_FILES["uplaoded_files"]["name"][$key])) {
				$upload = wp_upload_bits($_FILES["uplaoded_files"]["name"][$key], null, file_get_contents($_FILES["uplaoded_files"]["tmp_name"][$key]));
				$upload_path = wp_upload_dir();
				$path=$upload_path["url"];
				$name=$_FILES["uplaoded_files"]["name"][$key];
			$image_url[$key]=$path."/".$name;
			}
				}
			}else {
			$image_url="";
			}
		/*	echo "<pre>";
			print_r($image_url);
			echo "</pre>";*/
			
				//added for move the images  in upload folders end
				
				
				$urls=$_POST['social_url'];
				
				self::themeoptions_update($urls,$image_url);
				$i=0;
				foreach($urls as $key => $url){
				echo "i1 value=".$i;
				echo "<br>";
				  if($image_url) {
				  $src=$image_url[$key];
				  }else {
				  $src="";
				  }
				?>
				<div style="margin-bottom:4px;" class="clonedInput">
					<input type="button" class="btnDel" value="Delete"/>
					<input type="file" name="uplaoded_files[]" id="preview-<?php echo $i;?>"  onchange="showMyImageNew(this,this.id)"   />
					<img id="thumbnail-<?php echo $i;?>" style="border-radius: 25px;position: relative;right: 11px;top: 19px;<?php if(!$src){?>display:none;<?php }?>"  src="<?php echo $src;?>" alt="image"  height="50" width="50"/>
					<input type="text" name="social_url[]" value="<?php echo $url;?>" />
				</div>
				<?php
			$i++;
				}
				}else{
				 $urls= get_option('social_url');
				  $image_urls= get_option('image_url');
				  $urls=maybe_unserialize($urls);
				   $image_url=maybe_unserialize($image_urls);
				   echo "urls count".count($urls);
				  if($urls) {
				  $i=0;
				  foreach($urls as $key => $url){
				  if($image_url) {
				  $src=$image_url[$key];
				  }else {
				  $src="";
				  }
				  echo "i value=".$i;
				echo "<br>";
				?>
				<div style="margin-bottom:4px;" class="clonedInput">
					<input type="button" class="btnDel" value="Delete"/>
				<input type="file" name="uplaoded_files[]" id="preview-<?php echo $i;?>" onchange="showMyImageNew(this,this.id)"   />
					<img id="thumbnail-<?php echo $i;?>" style="border-radius: 25px;position: relative;right: 11px;top: 19px;<?php if(!$src){?>display:none;<?php }?>"  src="<?php echo $src;?>" alt="image"  height="50" width="50"/>
					<input type="text" name="social_url[]" value="<?php echo $url;?>" />
				</div>
				<?php
				$i++;
				}
				}else {
				?>
				<div style="margin-bottom:4px;" class="clonedInput">
					<input type="button" class="btnDel" value="Delete" disabled="disabled" />
				<input type="file" name="uplaoded_files[]" id="preview-0" onchange="showMyImageNew(this,this.id)"   />
					<img id="thumbnail-0" style="border-radius: 25px;position: relative;right: 11px;top: 19px;display:none;"  src="" alt="image"  height="50" width="50"/>
					<input type="text" name="social_url[]" value="" />
				</div>
				<?php } }?>  
				<div>
					<input type="button" id="btnAdd" value="add another name" />
				</div>
				<!--added new for file uplaod end-->	
				<input id="btn" type="submit" value="Save" name="req_submit" />	
				</form>
				<?php if(isset($_FILES['uplaoded_files'])) {
				}
				if(isset($_POST['social_url'])) {
				}
				?>
				</div><!--social_options-->
			</div><!--wrap-->
			<?php   $urls= get_option('social_url'); 
			if($urls) {
			$count=count($urls);
			$iteration=$count-1;
			echo "available";
			}else {
			echo "Not available";
			$iteration=1;
			}
			
			?>
			<script type="text/javascript">
			$(document).ready(function() {
			var inputs = <?php echo $iteration; ?>; 
			var iteration = 1; 
			$('#btnAdd').click(function() {
				$('.btnDel:disabled').removeAttr('disabled');
				//var c = $('.clonedInput:first').clone().val('');
				var c = $('.clonedInput:first').clone(true);
					c.children(':text').attr({name:'social_url[]'});
					c.children(':file').attr('id','preview-'+inputs);
				//	c.children('img').attr('id','thumbnail-'+inputs);
					c.children('img').attr({id:'thumbnail-'+inputs,src:""}).css({'display':'none'});
					
					++inputs;

				$('.clonedInput:last').after(c);
			});
			$('.btnDel').click(function() {
			//alert('check');
				if (confirm('continue delete?')) {
					--inputs;
					$(this).closest('.clonedInput').remove();
					$('.btnDel').attr('disabled',($('.clonedInput').length  < 2));
				}
			});
			
			});
			</script>
			<style>
			#social_options{
				width: 100%;
				float:left;
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
			#social_options #btn {
			cursor: pointer;
			width: 100px;
			}
			</style>	
			</div><!--social_tab-->
			
			<!--social link end-->
		    <!--favicon start-->
			
			<div class="favicon_tab" <?php if(isset($_POST['fav_submit'])){ ?> style="display:block;"<?php 
			}else { ?> style="display:none;"<?php } ?>>
			<?php
					if (  isset($_POST['update_themeoptions1']) == 'true' ) {  
			$upload = wp_upload_bits($_FILES["favicon_image_url"]["name"], null, file_get_contents($_FILES["favicon_image_url"]["tmp_name"]));
			$upload_path = wp_upload_dir();
			$path=$upload_path["url"];
			$name=$_FILES["favicon_image_url"]["name"];
			$image_url=$path."/".$name;
			self::themeoptions_update1($image_url); 
				}
			?>	
			<div class="wrap">
				<div id="social_options">
				<h2>Fav Icon</h2>
				<form method="post" action="" name="social_form" id="fav_icon_form" enctype="multipart/form-data" >
					<input type="hidden" name="update_themeoptions1" value="true" />
					<label>Fav Icon</label><br />
					<input type="file" name="favicon_image_url" id="favicon_img" size="40" id="fb" value="<?php echo get_option('favicon_image_url');?>"  accept="image/*"  onchange="showMyImage(this)"  /><br />
					<input id="btn1" type="submit" value="Save" name="fav_submit" />	
					 <br/>
				<?php
				if(get_option('favicon_image_url')) { ?>
				<img id="thumbnil"  src="<?php echo get_option('favicon_image_url');?>" alt="image" height="100" width="100" />
				<?php
				}else { ?>
				<img id="thumbnil" style="width:20%; margin-top:10px;display:none;"  src="" alt="image"  height="100" width="100"/>
				<?php }	 ?>
				</form>
				</div><!--social_options-->
			</div><!--wrap-->
			</div><!--favicon_tab-->
			
			 <!--favicon part end-->
			  <!--custom css part start-->
			
		<div class="custom_css_tab" <?php if(isset($_POST['custom_css'])){ ?> style="display:block;"<?php 
	}else { ?> style="display:none;"<?php } ?>> 
	
	<style>
	textarea {
	resize: none;
	}
	
	div.msg {
	border-left: 4px solid #7ad03a;
	padding: 1px 12px;
	background-color: #fff;
	-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
	box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
	
	}
	.media-upload-form div.error, .wrap div.error, .wrap div.msg {
	margin: 5px 0 15px;
	}
	p {
	font-size: 13px;
	line-height: 1.5;
	margin: 1em 0;
	}
	</style>
		<?php
		if(isset($_POST['custom_css'])){
		self::themeoptions_update2(); 
		}
		// The default message that will appear
		$custom_css_default = __( '/*
		Welcome to the Custom CSS editor!
		
		Please add all your custom CSS here and avoid modifying the core theme files, since that\'ll make upgrading the theme problematic. Your custom CSS will be loaded after the theme\'s stylesheets, which means that your rules will take precedence. Just add your CSS here for what you want to change, you don\'t need to copy all the theme\'s style.css content.
		*/' );
		$custom_css = get_option( 'custom_css', $custom_css_default );
		?>
		<div class="wrap">
			<form id="custom_css_form" method="post" action="" style="margin-top: 15px;">
			<?php if(isset($_POST['custom_css'])){ ?><div id="message" class="msg"><p><strong> Custom CSS Updated.
			</strong></p></div>
			<?php }?>
			<h2><?php _e( 'Custom CSS' ); ?></h2>
				<textarea id="custom_css_textarea" name="custom_css"  style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"><?php echo $custom_css; ?></textarea>
				<p><input type="submit" name="custom_css_sub" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
			</form>
		</div><!--wrap-->
	</div><!--custom_css_tab-->
	
	 <!--custom css part end-->
<?php 
	
	}
	
	        /************************************
			Update the Contact theme option values
			*************************************/
		
			public static function themeoptions_update($urls,$image_urls)
			{ 
			update_option('social_url',maybe_serialize($urls));
				update_option('image_url',maybe_serialize($image_urls));
		
			//print_r(maybe_unserialize($ser));
		    }
			 public static function themeoptions_update1($image_url){
				update_option('favicon_image_url',$image_url);	
			 }
			 public static function  themeoptions_update2(){
				update_option('custom_css',$_POST['custom_css']);	
			 }


	public static function display_custom_css() {
	
$custom_css = get_option( 'custom_css' );
if ( ! empty( $custom_css ) ) { ?>
<style type="text/css">
    <?php
    echo '/* Custom CSS */' . "\n";
    echo $custom_css . "\n";
    ?>
</style>
    <?php  
}

}

} /*class end*/


		 add_action( 'init', array( 'ThemeOptions','register_script1' ) );
		add_action( 'admin_enqueue_scripts', array( 'ThemeOptions','enqueue_style1' ) );
		
		
		
		add_action( 'admin_init', array( 'ThemeOptions', 'theme_options_init' ) ); 
		add_action( 'admin_menu', array( 'ThemeOptions', 'theme_options_add_page' ) );
		add_action( 'theme_update_actions', array( 'ThemeOptions', 'theme_options_do_page' ) );
		
		add_action( 'wp_head', array( 'ThemeOptions', 'display_custom_css' ) ); 
		
		add_shortcode('social_icons', array( 'ThemeOptions', 'theme_options_do_page' ));








 
 

	
	
	
