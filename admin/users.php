<?php
SESSION_START();
$PageTitle = "Usres Manage";

include 'init.php';

?> 

<?php
//check do then set in varible
if (isset($_GET['do'])) {

	$do = $_GET['do'];

}else {

	$do = "manage";
}

if ($do == "manage") {

	
?>
		<div class="container">
			<h1 class="text-center">Users Manage</h1>
			<div class="table-resposive">
				<table class="main-table text-center table table-bordered table-striped table-dark">
					<tr>
						<td>#ID</td>
						<td>Full Name</td>
						<td>Phone Number</td>
						<td>Registerd Date</td>
						<td>Control</td>
					</tr>

					<?php
						$AllUsers = getAll("*" , "users" , 'WHERE Admin = 0' ,'' , "UserID" ,"DESC");


						foreach ($AllUsers as  $OneUser) {
							echo "<tr>";
								echo "<td> " . $OneUser['UserID'] ."</td>";
								echo "<td> " . $OneUser['FullName'] ."</td>";
								echo "<td> " . $OneUser['NumberPhone'] ."</td>";
								echo "<td> " . $OneUser['Date'] ."</td>";

								echo "<td>

								 <a href='?do=edit&UserID=" . $OneUser['UserID'] . "' class='btn btn-success'> <i class='fa fa-edit'> </i>Edit</a> 
							 	 <a href='?do=delete&UserID=" . $OneUser['UserID'] . "' class='btn btn-danger  confirm '> <i class='fas fa-times'></i> Delete</a>";
							 	 if ($OneUser['Block'] == 1) {

							 	 echo "<a href='?do=unblock&UserID=" . $OneUser['UserID'] . "' class='btn btn-info  confirm '> <i class='fas fa-ban'></i> UnBlock</a>";
							 	 
							 	 }

							 	 echo "</td>"; 

							echo "</tr>";
							
						}


					 ?>



				</table>
			</div>
		</div>
<?php

}elseif ($do == "edit") {

	echo "<h1 class='text-center'>Edit User</h1>";


	//check if id come from get is number
	if (isset($_GET['UserID'])  && is_numeric($_GET['UserID'])) {
	 	
	 	$userid =  $_GET['UserID'];
		$statment = $db->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
		$statment->execute(array($userid)); //execute statment
		$row = $statment->fetch(); // Get Data In Array

	 	?>

	 	<div class="container users">
	 		<div class="col-sm-6">
	 			<form action="?do=update" method="POST">
	 			<input type="hidden"  name="userid" value="<?php echo $row['UserID']; ?>">
	 			<div class="input-group">
				  <span class="input-group-addon " id="basic-addon1"><i class="fa fa-user"></i> <label>Full Name <span class="alstrx">*</span></label></span>
				  <input type="text" class="input-lg form-control" name="FullName" required="required" value="<?php echo $row['FullName']; ?>">
				 </div>

	 			<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-lock"></i> <label>Password <span class="alstrx">*</span></label></span>
				  <input type="text" class="input-lg form-control" name="new-Password">
				  <input type="hidden"  value="<?php echo $row['Password']; ?>"  class="input-lg form-control" name="old-Password" >
				</div>

	 			<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-phone"></i> <label>Phone Number <span class="alstrx">*</span></label></span>
				  <input type="text" class="input-lg form-control" name ="NumberPhone" pattern="[0-9]{10}" title="Phone number Must Be 10 integrs"  required="required" value="<?php echo $row['NumberPhone']; ?>">
				</div>

	 			

	 			<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-globe"></i> <label>Admin <span class="alstrx">*</span></label></span>
				 <select name="Admin">
				 	<option <?php if ($row['Admin'] == 1) { echo "selected";} ?> value="1">Admin</option>
				 	<option  <?php if ($row['Admin'] == 0) { echo "selected";} ?> value="0">Not Admin</option>
				  </select>
				</div>

	 			<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-globe"></i> <label>Block <span class="alstrx">*</span></label></span>
				 <select name="Block">
				 	<option <?php if ($row['Block'] == 0) { echo "selected";} ?> value="0">UnBlock</option>
				 	<option  <?php if ($row['Block'] == 1) { echo "selected";} ?> value="1">Block</option>
				  </select>
				</div>
				<input type="submit" value="Save" class="btn btn-primary btn-lg">
				</form>
	 		</div>
	 	</div>



	 	<?php

	 }else {

	 	//if do= not number or do not exist
		 $msg = "ID Undifened";
		Redirect ($msg ,'', $seconds = 3);
	 }
	
}elseif ($do == "unblock") {

	//check if id come from get is number
	if (isset($_GET['UserID'])  && is_numeric($_GET['UserID'])) {
	 	
	 	$userid =  $_GET['UserID'];

	 	//query for unblock
		$statment = $db->prepare("UPDATE users SET Block = 0 WHERE UserID = ?");
	 	$statment->execute(array($userid)); //execute statment
	 	$count = $statment->rowCount(); // return number of colume that executed

	 	//Seccess Msg
		echo "<div class='alert alert-success container'> Done User Now  Is UnBlock </div>";
		//Redairct After Done Update
		header("refresh:2 , url=users.php");
		exit();

	 }else {

	 	//if do= not number or do not exist
		 $msg = "ID Undifened";
		Redirect ($msg ,'', $seconds = 3);
	 }
	
}elseif ($do == "update") {

	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$UserID = $_POST['userid'];
		$FullName = $_POST['FullName'];
		$oldPassword = $_POST['old-Password'];
		$newPassword = sha1($_POST['new-Password']);
		$NumberPhone = $_POST['NumberPhone'];
		$Block = $_POST['Block'];
		$Admin = $_POST['Admin'];
		$erorrArray = array();

		if (empty($newPassword)) {
			
			$newPassword = $oldPassword ;
		}

	$statment = $db->prepare("SELECT * FROM users WHERE NumberPhone = ? AND UserID != ?");
 	$statment->execute(array($NumberPhone , $UserID)); //execute statment
 	$count = $statment->rowCount();
 	
 	if ($count > 0) {

 		$erorrArray [] = "NumberPhone is Exist";

 	}

 	if (strlen($NumberPhone) < 10) {

 		$erorrArray [] = "NumberPhone Must Be 10 integers";
 		
 	}



 	if (empty($erorrArray)) {

 				 	$stmt = $db->prepare("
			 		UPDATE 
			 		users
			 		SET 
			 		FullName = ? ,Password = ?  , NumberPhone = ?, Admin = ? ,Block = ? 
			 		WHERE 
			 		UserID = ?");


			 	$stmt->execute(array($FullName ,$newPassword ,  $NumberPhone ,$Admin , $Block , $UserID)); //execute statment
		
			 	$count = $stmt->rowCount(); // return number of colume that executed

				//sucsess Massege 	
			 	$msgsuc =  "<div class='alert alert-success container'>done There is " . $count . " Affected </div>";

			 	Redirect($msgsuc , 'back',4);
 		

 	}else {

 		//if there are erorr not sent and show erorr
		 foreach ($erorrArray as  $msg) {

		 		echo "<div class='alert alert-danger container'> $msg</div>";
		 }

		 Redirect ('' ,'back', 3);


 	}
		
	}else {
		//if come not REQUEST_METHOD
		echo "<div class='alert alert-danger container'> come not REQUEST_METHOD</div>";

		Redirect ('' , 3);
	}



	
}elseif ($do == "delete") {

	//check if id come from get is number
	if (isset($_GET['UserID'])  && is_numeric($_GET['UserID'])) {
	 	
	 	$userid =  $_GET['UserID'];

	 	//query for unblock
		$statment = $db->prepare("DELETE FROM users  WHERE UserID = ?");
	 	$statment->execute(array($userid)); //execute statment
	 	$count = $statment->rowCount(); // return number of colume that executed

	 	//Seccess Msg
		echo "<div class='alert alert-success container'> Done User Now  Is Deleted </div>";
		//Redairct After Done Update
		header("refresh:2 , url=users.php");
		exit();

	 }else {

	 	//if do= not number or do not exist
		 $msg = "ID Undifened";
		Redirect ($msg ,'', $seconds = 3);
	 }
	
}elseif ($do == "unblock") {

	//check if id come from get is number
	if (isset($_GET['UserID'])  && is_numeric($_GET['UserID'])) {
	 	
	 	$userid =  $_GET['UserID'];

	 	//query for unblock
		$statment = $db->prepare("UPDATE users SET Block = 0 WHERE UserID = ?");
	 	$statment->execute(array($userid)); //execute statment
	 	$count = $statment->rowCount(); // return number of colume that executed

	 	//Seccess Msg
		echo "<div class='alert alert-success container'> Done User Now  Is UnBlock </div>";
		//Redairct After Done Update
		header("refresh:2 , url=users.php");
		exit();

	 }else {

	 	//if do= not number or do not exist
		 $msg = "ID Undifened";
		Redirect ($msg ,'', $seconds = 3);
	 }
	
}else {

	$msg = "Do Undifened";
	Redirect ($msg ,'', $seconds = 3);
}

include $tmpl . 'footer.php';


 ?>