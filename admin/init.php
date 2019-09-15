<?php

 include  "connect.php"; // connect to database


//sort diroctry

$tmpl = "include/tamplate/";
$lang = "include/languges/";
$func = "include/functions/";
$css = "layout/css/";
$js = "layout/js/";



//include important file

 include $func .'function.php';
 include $tmpl . "header.php"; // heder
 include $lang . 'english.php';




 // check if not $navbar no set navbar
 if(!isset($nonavbar)) {
 	 
 	 include $tmpl . "navbar.php";

 	}



?>