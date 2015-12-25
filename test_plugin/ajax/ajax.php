<?php


echo "bro";

if(isset($_POST['formData'])){
echo "available";
echo "<pre>";
print_r($_POST['formData']);
echo "</pre>";
}else {
echo "Not Available";
}
/*$upload = wp_upload_bits($_FILES["favicon_image_url"]["name"], null, file_get_contents($_FILES["favicon_image_url"]["tmp_name"]));
$upload_path = wp_upload_dir();

$path=$upload_path["url"];

$name=$_FILES["favicon_image_url"]["name"];

$image_url=$path."/".$name;

themeoptions_update1( $image_url); 


 function themeoptions_update1($image_url)
 	{ 
	update_option('favicon_image_url',$image_url);	
	
	}
*/
?>