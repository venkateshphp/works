<?php
include("shopping-country-class.php");
$obj=new check();
if ($_GET["id"]) {

$obj->check_fun($_GET["id"]);

} 
?>
		


