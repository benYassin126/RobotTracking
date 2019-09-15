<?php
SESSION_START();

$nonavbar = '';
$PageTitle = 'Admin Login';

include 'init.php';

if (isset($_SESSION['AdminID'])) {

	header("location:dashboard.php");
	exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST") {

	$phone = filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
	$pass = sha1($_POST['pass']);

	
	$statment = $db->prepare("SELECT * FROM users WHERE NumberPhone = ? AND Password = ? AND Admin = 1 LIMIT 1 ");
 	$statment->execute(array($phone , $pass)); //execute statment
 	$row = $statment->fetch(); // Get Data In Array
 	$count = $statment->rowCount(); // return number of colume that executed

 	if  ($count > 0 ) {

 		$_SESSION['AdminID'] = $row['UserID'];
  		$_SESSION['FullName'] = $row['FullName'];
		header("location:dashboard.php");
		exit();

 		}else {
 			echo "Pass Or Phone Erorr !";
 		}




}

?> 


<div class="container">
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
		<h1 class="text-center ">Login</h1>
		<input class="form-control input-lg" type="text" name="phone" placeholder="Phone Number" autocomplete="off">
		<input class="form-control input-lg" type="password" name="pass" placeholder="password Here" autocomplete="new-password">
		<input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
	</form>
</div>

<?php

include $tmpl . 'footer.php';


 ?>