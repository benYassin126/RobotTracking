<?php

SESSION_START(); // Start The SESSION To Get all Varabels and Set Some Varabels

$PageTitle = "Robots Manage";

include 'init.php'; // To include All Importants File Like [Connect To DB and Header ..etc]


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

			<h1 class="text-center">Robots Manage</h1>

			<div class="table-resposive">

				<table class="main-table text-center table table-bordered table-striped table-dark">

					<tr>

						<td>#RobotID</td>

						<td>Robot Name</td>

						<td>Robot Type</td>


						<td>Date</td>

						<td>Owner of Robot</td>

						<td>Control</td>

					</tr>



					<?php

						 	$stmt = $db->prepare("

								SELECT robots.* , users.Username 

								FROM 

								robots

								INNER JOIN 

								users

								ON

								users.UserID = robots.UserID

								");



	 						$stmt->execute(); //execute statment

	 						$AllUsers = $stmt->fetchAll(); // Get Data In Array

						 





						foreach ($AllUsers as  $Onerobot) {

							echo "<tr>";

								echo "<td> " . $Onerobot['RobotID'] ."</td>";

								echo "<td> " . $Onerobot['RobotName'] ."</td>";

								echo "<td> " . $Onerobot['RobotType'] ."</td>";

								echo "<td> " . $Onerobot['Date'] ."</td>";

								echo "<td> " . $Onerobot['Username'] ."</td>";



								echo "<td>



								 <a href='?do=edit&RobotID=" . $Onerobot['RobotID'] . "' class='btn btn-success'> <i class='fa fa-edit'> </i>Edit</a> 

							 	 <a href='?do=delete&RobotID=" . $Onerobot['RobotID'] . "' class='btn btn-danger  confirm '> <i class='fas fa-times'></i> Delete</a>";



							 	 echo "</td>"; 



							echo "</tr>";

							

						}





					 ?>







				</table>

			</div>

		</div>

<?php



}elseif ($do == "edit") {



	echo "<h1 class='text-center'>Edit robots</h1>";





	//check if id come from get is number

	if (isset($_GET['RobotID'])  && is_numeric($_GET['RobotID'])) {

	 	

	 	$RobotID =  $_GET['RobotID'];

		$statment = $db->prepare("SELECT * FROM robots WHERE RobotID = ? LIMIT 1");

		$statment->execute(array($RobotID)); //execute statment

		$row = $statment->fetch(); // Get Data In Array



	 	?>



	 	<div class="container users">

	 		<div class="col-sm-6">



	 			<form action="?do=update" method="POST">



		 			<input type="hidden"  name="RobotID" value="<?php echo $row['RobotID']; ?>">



		 			<div class="input-group">

					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-robot"></i> <label>Robot Name <span class="alstrx">*</span></label></span>

					  <input type="text" class="input-lg form-control" name="RobotName" required="required" value="<?php echo $row['RobotName']; ?>">

					 </div>



		 			<div class="input-group">

					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>RobotType <span class="alstrx">*</span></label></span>

						<select name="RobotType">

						 	<option <?php if ($row['RobotType'] == "Consumer") { echo "selected";} ?> value="Consumer">Consumer</option>

						 	<option  <?php if ($row['RobotType'] == "Drones") { echo "selected";} ?> value="Drones">Drones</option>

						 	<option  <?php if ($row['RobotType'] == "Humanoids") { echo "selected";} ?> value="Humanoids">Humanoids</option>

						 	<option  <?php if ($row['RobotType'] == "Military ") { echo "selected";} ?> value="Military ">Military </option>

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

	

	

}elseif ($do == "update") {



	if ($_SERVER['REQUEST_METHOD'] == "POST") {



		$RobotID = $_POST['RobotID'];

		$RobotName = $_POST['RobotName'];

		$RobotType = $_POST['RobotType'];



		$erorrArray = array();



 	if (strlen($RobotName) < 3) {



 		$erorrArray [] = "robot Name Biger than 3 Charecter";

 		

 	}







 	if (empty($erorrArray)) {



 				 	$stmt = $db->prepare("

			 		UPDATE 

			 		robots

			 		SET 

			 		RobotName = ? ,RobotType = ? 

			 		WHERE 

			 		RobotID = ?");





			 	$stmt->execute(array($RobotName ,$RobotType ,$RobotID)); //execute statment

		

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

	if (isset($_GET['robotID'])  && is_numeric($_GET['robotID'])) {

	 	

	 	$robotID =  $_GET['robotID'];



	 	//query for unblock

		$statment = $db->prepare("DELETE FROM robots  WHERE robotID = ?");

	 	$statment->execute(array($robotID)); //execute statment

	 	$count = $statment->rowCount(); // return number of colume that executed



	 	//Seccess Msg

		echo "<div class='alert alert-success container'> Done robot Now  Is Deleted </div>";

		//Redairct After Done Update

		header("refresh:2 , url=robots.php");

		exit();



	 }else {



	 	//if do= not number or do not exist

		 $msg = "ID Undifened";

		Redirect ($msg ,'', $seconds = 3);

	 }

	

}


include $tmpl . 'footer.php';





 ?>