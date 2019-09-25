<?php
SESSION_START();

$PageTitle = "Login";

include 'init.php';



if($_SERVER['REQUEST_METHOD'] == "POST") {

	$username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
	$pass = sha1($_POST['Password']);

	
	$statment = $db->prepare("SELECT * FROM users WHERE UserName = ? AND Password = ? LIMIT 1");
 	$statment->execute(array($username , $pass)); //execute statment
 	$row = $statment->fetch(); // Get Data In Array
 	$count = $statment->rowCount(); // return number of colume that executed

 	if  ($count > 0 ) {

		echo "<div class='loginErorrs'>";
			echo "<div class='container alert alert-success'>  <i class='far fa-check-circle'></i> Welcome back you will be redirected now  </div>";
		echo "</div>";
		header("refresh:3 , url=UI.php");
		exit();


 		}else {
 			echo "<div class='loginErorrs'>";
 				echo "<div class='container alert alert-danger'>  <i class='fa fa-times'></i> UserName OR Password is Erorr ! </div>";
 			echo "</div>";
 		}
}



?> 

<h1 class="text-center TitleText">Login</h1>
<hr class="LineTitle">

<div class="loginPage">
	<div class="container">
		<div class="row">
			<div class="BackLogin">
				<form action = "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-user"></i> <label>UserName <span class="alstrx">*</span></label></span>
					  <input type="text" class="input-lg form-control" name="username" required="required"">
					 </div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-lock"></i> <label>password  <span class="alstrx">*</span></label></span>
					  <input type="Password" class="input-lg form-control" name="Password" autocomplete="new-password">
					</div>

					<div class="input-group btnLogo">
						<input type="submit" value="Login"  class="btn btn-primary btn-lg ">
					</div>
				</form>
				<hr class="LineTitle">
				<a href="register.php"><p style="display: inline-block;">Dont have acount ? Register a new account</p></a>
				<a href='register.php' class='btn btn-success'>  <i class="fas fa-user-plus"></i> Sign Up  </a>
			</div>
		</div>
	</div>
</div>


<?php

include $tmpl . 'footer.php';


 ?>