<?php

/*

===========================================
= Members Page
= You Can Delete | add | edeit user From Here

===========================================

*/


SESSION_START();

$PageTitle = "Title Here";

//check if user authoize to login this page
if(isset($_SESSION["USERNAME"])) {

	include 'init.php';

	// Set do Value becuse go to proper page

	$do = isset($_GET["do"]) ? $_GET["do"] : "manage";

	// Manage Page

	if ($do == "manage") {

		echo "manage";


	}elseif ($do == "add") {

		echo "add";
		
	}elseif ($do == "insert") {

		echo "insert";

	}elseif ($do == "edit") {  

		echo "edit";

	 }elseif ($do == "update") { 

	 	echo "update";

	 }elseif ($do == "delete") {

	 	echo "delete";

	 }elseif ($do == "approve") {

	 	echo "delete";

	 }else {

	 	$msg  =  "<div class='alert alert-danger container'> Do is Undfined </div> ";
	 	Redirect ($msg  ,"index.php", 3);
	 }

	 		


	include $tmpl . "footer.php";
	

	} else {
		
		header("location:index.php");
		exit();

	}



 ?>