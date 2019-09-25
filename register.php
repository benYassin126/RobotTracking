<?php

$PageTitle = "Sign Up";
include 'init.php';


if($_SERVER['REQUEST_METHOD'] == "POST") {
		$username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
		$Email = filter_var($_POST['Email'],FILTER_SANITIZE_EMAIL);
		$Password = sha1($_POST['Password']);
		$erorrArray = array();
		$statment = $db->prepare("SELECT * FROM users WHERE UserName = ? ");
	 	$statment->execute(array($username)); //execute statment
	 	$count = $statment->rowCount();

	


	if ($count > 0) {

 		$erorrArray [] = "UserName is exist";

 	}
 	if (empty($username) || empty($Password) || empty($Email)) {

 		$erorrArray [] = "Plase Fill all inputs";
 		# code...
 	}

 	if (strlen($username) < 3 ) {

 		$erorrArray [] = "UserName Cannot be less Than 3 Charectrs ";
 		
 	}

 	if (empty($erorrArray)) {
 		
	// update new value

			 	$stmt = $db->prepare("
			 		INSERT INTO  
			 		users
			 		(username , Password  ,Email, Date)
			 		VALUES 
			 		(? , ? ,?  ,  now()) 
			 		");


			 	$stmt->execute(array($username ,$Password  ,$Email)); //execute statment
		
			 	$count = $stmt->rowCount(); // return number of colume that executed

				//sucsess Massege 	
		echo "<div class='loginErorrs'>";
			echo "<div class='container alert alert-success'>  <i class='far fa-check-circle'></i>  Welcome  " . $username ."  successfully registered  </div>";
		echo "</div>";

		header("refresh:3 , url=dashboard.php");
		exit();




 	}else {
 		// if there are erorr
 		echo "<div class='loginErorrs'>";
 		echo "<div class='container alert alert-danger'>";
			foreach ($erorrArray as  $msg) {
 			
 				echo "<p> <i class='fa fa-times'></i> $msg </p>"; 

			 }
			 echo "</div>";
		echo "</div>";
 	}


	}else {
		//if come not req
	}

?> 

<h1 class="text-center">Sign Up</h1>
<hr class="LineTitle">


	<div class="container">
		<div class="row">
			<div class="BackLogin">
				<form action = "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-user"></i> <label> username<span class="alstrx">*</span></label></span>
					  <input type="text" value="<?php if(isset($username)) { echo $username; } ?>" required="required" class=" form-control username"  name="username">

					 </div>


		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-user"></i> <label> Email<span class="alstrx">*</span></label></span>
					  <input type="email" value="<?php if(isset($Email)) { echo $Email; } ?>" required="required" class=" form-control username"  name="Email">

					 </div>


		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-lock"></i> <label>Password <span class="alstrx">*</span></label></span>
					  <input type="Password" class=" form-control Password" name="Password" required="required"  autocomplete="new-password">
					</div>





					<div class="input-group btnLogo">
						<input type="submit" value="Sign Up"  class="btn btn-success btn-lg ">
					</div>

				</form>
			</div>
		</div>
	</div>
<?php

include $tmpl . 'footer.php';


 ?>