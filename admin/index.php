<?php



SESSION_START(); // Start The SESSION To Get all Varabels and Set Some Varabels

$nonavbar = ''; // in This Page We Dont Need Navbar

$PageTitle = 'Admin'; // Set 'Admin Login' in Page Tiltle Via getTitle() Funciton


include 'init.php'; // To include All Importants File Like [Connect To DB and Header ..etc]



if (isset($_SESSION['AdminID'])) { // if Admin ALready Login To system Dont Show This Page

    header("Location:dashboard.php"); 
    exit;

}



if($_SERVER['REQUEST_METHOD'] == "POST") {



	$username = $_POST['username']; //Get Username From The Below Form

	$pass = sha1($_POST['pass']); //Get password From The Below Form


  //Start SQL Query To Check If user is admin or not ?
	

	$statment = $db->prepare("SELECT * FROM users WHERE UserName = ? AND Password = ? AND Admin = 1 LIMIT 1 ");

 	$statment->execute(array($username , $pass)); //execute statment

 	$row = $statment->fetch(); // Get Data In Array

 	$count = $statment->rowCount(); // return number of colume that executed


  // if user is Admin


 	if  ($count > 0 ) {

    //First thing add adminID AND username To Session in order to Go To Dashboard

 		$_SESSION['AdminID'] = $row['UserID']; 
  		$_SESSION['UserName'] = $row['UserName'];

    // Then Redirct Adoin To dashboard
      header("Location:dashboard.php");  
      exit;

 		}else {

    // if not admon show this mssage

 			echo "Sorry ! Your Not Admin";

 		}

}


?> 


<!-- Start Form -->

<div class="container">

	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">

		<h1 class="text-center ">Login</h1>

		<input class="form-control input-lg" type="text" name="username" placeholder="UserName" autocomplete="off">

		<input class="form-control input-lg" type="password" name="pass" placeholder="password Here" autocomplete="new-password">

		<input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">

	</form>

</div>

<!-- End Form -->

<?php

//add Footer to This Page

include $tmpl . 'footer.php';

 ?>