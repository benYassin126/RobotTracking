<?php
SESSION_START();

$PageTitle = "Edit Robot";

include 'init.php';


if (isset($_GET['do'])) {

	$do = $_GET['do'];

}else {
		//if come not REQUEST_METHOD
		echo "<div class='alert alert-danger container'> come not REQUEST_METHOD</div>";

		Redirect ('' , 3);
}

if ($do == 'edit') {


		$RobotID = $_GET['RobotID'];
		$UserID = $_SESSION['UserIDSession'];

		$statment = $db->prepare("SELECT * 
		FROM robots
		WHERE RobotID = ?");
	 	$statment->execute(array($RobotID)); //execute statment
	 	$row = $statment->fetch(); // Get Data In Array
	 	$count = $statment->rowCount(); // return number of colume that executed

	 	if ($count > 0) {

?>

<h1 class="text-center">Edit Robot</h1>
<hr class="LineTitle">

			<div class="BackLogin">
				<form action = "?do=update" method = "POST"enctype="multipart/form-data">

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="far fa-bookmark"></i> <label> Robot Name :  <span class="alstrx">*</span></label></span>
					  <input type="text" placeholder="Enter Name Of Robot Here ...." value="<?php if(isset($row['RobotName'])) { echo $row['RobotName']; } ?>" class="form-control" name="RobotName"  autofocus="true"  required="required">
					  <input type="hidden" name="RobotID"  value="<?php if(isset($RobotID)) { echo $RobotID; } ?>">

					 </div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>Robot Type :<span class="alstrx">*</span></label></span>
					  <select name="RobotType">
					  		<option <?php if (isset($row['RobotType']) && $row['RobotType'] == 0) {echo "selected";}?> value="0"></option>
						 	<option <?php if (isset($row['RobotType']) && $row['RobotType'] == "Drones") {echo "selected";}?> value="Drones">Drones</option>
						 	<option <?php if (isset($row['RobotType']) && $row['RobotType'] == "Consumer") {echo "selected";}?> value="Consumer">Consumer</option>
						 	<option <?php if (isset($row['RobotType']) && $row['RobotType'] == "Humanoids") {echo "selected";}?> value="Humanoids">Humanoids</option>
						 	<option <?php if (isset($row['RobotType']) && $row['RobotType'] == "Military") {echo "selected";}?> value="Military">Military</option>
					  </select>
					</div>
					<p>* You Can use <a target="_blank" href="https://www.google.com/maps">Google MAPs </a> to fill in the following fields</p>

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-map-marker"></i> <label> New Lat :  <span class="alstrx">*</span></label></span>
					  <input type="text" placeholder="Enter latitude Of Robot Here ...." value="<?php if(isset($row['Lat'])) { echo $row['Lat']; } ?>" class="form-control" name="Lat"  autofocus="true"  required="required">
					 </div>

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-map-marker"></i> <label> New Lng :  <span class="alstrx">*</span></label></span>
					  <input type="text" placeholder="Enter longitude Of Robot Here ...." value="<?php if(isset($row['Lng'])) { echo $row['Lng']; } ?>" class="form-control" name="Lng"  required="required">
					 </div>

					<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="far fa-bookmark"></i> <label> Safe Area :  <span class="alstrx">*</span></label></span>
					  <input type="number" placeholder="Enter The distance"  class="form-control" name="SafeArea"  value="<?php if(isset($row['SafeArea'])) { echo $row['SafeArea']; } ?>">
					
					 </div>


					 <div class="input-group LogGroup">
					    <span class="input-group-addon " id="basic-addon1"><i class="far fa-bookmark"></i> <label> Safe Area :  <span class="alstrx">*</span></label></span>
						<input type="checkbox" name="place1" value="MilitaryCity" checked> Military City<br>
						<input type="checkbox" name="place2" value="Airport" checked>Airport<br>
					
					 </div>
					<div class="input-group btnLogo">
						<input type="submit" value="Edit Robot"  class="btn btn-success btn-lg ">
					</div>
				</form>



<?php
}else{
		//if come not REQUEST_METHOD
		echo "<div class='alert alert-danger container'> No Robot!</div>";

		Redirect ('' , 3);
}

}elseif ($do == "update") {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {



		$RobotID = $_POST['RobotID'];
		$RobotName = $_POST['RobotName'];
		$RobotType = $_POST['RobotType'];
		$Lat = $_POST['Lat'];
		$Lng = $_POST['Lng'];
		$SafeArea = $_POST['SafeArea'];
		$DangerPlace = array();


		if (isset($_POST['place1'])) {
			$DangerPlace [] = $_POST['place1'];
		}
		if (isset($_POST['place2'])) {
			$DangerPlace [] = $_POST['place2'];
		}

		$DangerPlaceStr = implode(",", $DangerPlace);


		$erorrArray = array();

 	if (strlen($RobotName) < 3) {



 		$erorrArray [] = "robot Name Biger than 3 Charecter";

 		

 	}


 	if (empty($erorrArray)) {


			 	$stmt = $db->prepare("
					UPDATE 
					robots
					SET RobotName = ? , RobotType = ? ,SafeArea = ?,DangerPlace = ?,Lat = ? , Lng = ?
					WHERE RobotID = ?
			 		");


			 	$stmt->execute(array($RobotName,$RobotType,$SafeArea,$DangerPlaceStr,$Lat,$Lng,$RobotID)); //execute statment
		
			 	


			 	$count = $stmt->rowCount(); // return number of colume that executed


			 	$stmt1 = $db->prepare("
			 		INSERT INTO  
			 		locations
			 		(DateAndTime ,LocLat,LocLng,RobotID)
			 		VALUES 
			 		(CURRENT_TIMESTAMP , ? ,?, ?) 
			 		");



			 	$stmt1->execute(array($Lat,$Lng,$RobotID)); //execute statment

			 	echo "<div class='alert alert-success container'>done There is " . $count . " Affected </div>";

			 	
			 		header("refresh:2 , url=UI.php");
					exit();

 		



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





}elseif (isset($_GET['do']) && $_GET['do'] == "delete" ) {


		$RobotID = $_GET['RobotID'];
		$UserID = $_SESSION['UserIDSession'];

		$statment = $db->prepare("DELETE FROM robots  WHERE RobotID = ? AND UserID = ?");
	 	$statment->execute(array($RobotID,$UserID)); //execute statment
	 	$count = $statment->rowCount(); // return number of colume that executed

	 	if ($count > 0) {

	 	//Seccess Msg
		echo "<div class='loginErorrs'>";
			echo "<div class='container alert alert-success'>  <i class='far fa-check-circle'></i> Deleted successfully </div>";
		echo "</div>";

		header("refresh:3 , url=UI.php");
		exit();
	 		
	 	}else {
 			echo "<div class='loginErorrs'>";
 				echo "<div class='container alert alert-danger'>  <i class='fa fa-times'></i> ERORR ROBOT NOT FOUND !</div>";
 			echo "</div>";
	 	//Redairct After Done Update
		header("refresh:2 , url=UI.php");
		exit();
	 	}




}

?> 

<?php

include $tmpl . 'footer.php';


 ?>

 