<?php
SESSION_START();

$PageTitle = "Robot Tracking ";

include 'init.php';


if (!isset($_SESSION['UserNameSession'])) {
		header('Location:index.php');
		exit();
}

$UserNameSession = $_SESSION['UserNameSession'];
$UserIDSession = $_SESSION['UserIDSession'];

	//to fill input for edit profile
	$stmt = $db->prepare("SELECT * FROM users WHERE UserID = ?");
 	$stmt->execute(array($UserIDSession)); //execute statment
	$rowForUsers = $stmt->fetch();

	//to fill input for edit robot
	$stmt = $db->prepare("SELECT * 
		FROM robots
		WHERE UserID = ?");
 	$stmt->execute(array($UserIDSession)); //execute statment
	$rowForRobots = $stmt->fetch();

	//to get number of robot
	$statment = $db->prepare("SELECT * FROM robots WHERE UserID = ?");
 	$statment->execute(array($UserIDSession)); //execute statment
  	$count = $statment->rowCount();

  	$NumberOfRobots = $count;

if (isset($_GET['do'])) {
	$do = $_GET['do'];
}

if (isset($_GET['do']) && $_GET['do'] == "update") {
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$UserID = $_POST['userid'];
		$Username = $_POST['Username'];
		$oldPassword = $_POST['old-Password'];
		$newPassword = sha1($_POST['new-password']);
		$Email = $_POST['Email'];

		$erorrArray = array();

		if (empty($newPassword)) {
			
			$newPassword = $oldPassword ;
		}

	$statment = $db->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
 	$statment->execute(array($Username , $UserID)); //execute statment
 	$count = $statment->rowCount();
 	
 	if ($count > 0) {

 		$erorrArray [] = "Username Is Exist!";

 	}



 	if (empty($erorrArray)) {

 				 	$stmt = $db->prepare("
			 		UPDATE 
			 		users
			 		SET 
			 		UserName = ? ,Password = ?  , Email = ? 
			 		WHERE 
			 		UserID = ?");


			 	$stmt->execute(array($Username ,$newPassword ,  $Email ,$UserID)); //execute statment
		
			 	$count = $stmt->rowCount(); // return number of colume that executed

				//sucsess Massege 	
			 	echo "<div class='alert alert-success container'>Update is Done</div>";

			 	
			 		header("refresh:1 , url=UI.php");
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

}elseif (isset($_GET['do']) && $_GET['do'] == 'add') {
	

if($_SERVER['REQUEST_METHOD'] == "POST") {

		$UserID =  $_SESSION['UserIDSession'];
		$RobotName = $_POST['RobotName'];
		$RobotType = $_POST['RobotType'];
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

 	if (empty($RobotName) || empty($RobotType)) {

 		$erorrArray [] = "Plase Fill all inputs";
 		# code...
 	}

 	if (strlen($RobotName) < 3 ) {

 		$erorrArray [] = "Robot Nmae Cannot be less Than 3 Charectrs ";
 		
 	}



 	if (empty($erorrArray)) {
 		
	// update new value

			 	$stmt = $db->prepare("
			 		INSERT INTO  
			 		robots
			 		(RobotName , RobotType, UserID, Date,SafeArea,DangerPlace)
			 		VALUES 
			 		(? , ? ,?, now(),?,?) 
			 		");


			 	$stmt->execute(array($RobotName ,$RobotType,$UserID,$SafeArea,$DangerPlaceStr)); //execute statment
		
			 	$count = $stmt->rowCount(); // return number of colume that executed

			 					//sucsess Massege 



			

				$stmt2 = $db->prepare("SELECT RobotID FROM robots WHERE RobotName = ?");


			 	$stmt2->execute(array($RobotName));

			 	$A = $stmt2->fetchAll();
			 	
						foreach ($A as  $Onerobot) {
			 	$stmt3 = $db->prepare("
			 		INSERT INTO  
			 		locations
			 		(RobotID)
			 		VALUES 
			 		(?) 
			 		");
			 	$stmt3->execute(array($Onerobot['RobotID'])); //execute statment
		
							
							}


}



}

}

?> 

<!-- The Peofile Modal -->
<div id="ProfileModel" class="modal">

  <!-- Modal content -->

  <div class="modal-content">
  		<h1 class="text-center">Edit Profile </h1>
  		<div class="BackLogin">
				<form action = "?do=update" method = "POST">
					<input type="hidden"  name="userid" value="<?php echo $rowForUsers['UserID']; ?>">
		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-user"></i> <label> Username    <span class="alstrx">*</span></label></span>
					  <input type="text" value="<?php echo $rowForUsers['UserName']; ?>" required="required" class=" form-control"  name="Username">

					 </div>


		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-lock"></i> <label> New Password <span class="alstrx">*</span></label></span>
					  <input type="Password" class=" form-control Password" name="new-password"   autocomplete="new-password">
					  <input type="hidden"  value="<?php echo $rowForUsers['Password']; ?>"  class="input-lg form-control" name="old-Password" >
					</div>

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-email"></i> <label>Email   <span class="alstrx">*</span></label></span>
					  <input type="Email" value="<?php echo $rowForUsers['Email']?>" required="required" class=" form-control" name="Email">
					 </div>
					<div class="input-group btnLogo">
						<input type="submit" value="Save"  class="btn btn-success btn-lg ">
					</div>    
			</div>
				</form>
				<button id="ClProf" class="btn btn-danger btn-block">Close</button>
			</div>
  </div>

</div>


<!-- The Edit Modal -->
<div id="EditModel" class="modal">

  <!-- Modal content -->
  <div class="modal-content">

<h1 class="text-center">Add Robot</h1>
<hr class="LineTitle">

			<div class="BackLogin">
				<form action = "?do=add" method = "POST"enctype="multipart/form-data">

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="far fa-bookmark"></i> <label> Robot Name :  <span class="alstrx">*</span></label></span>
					  <input type="text" placeholder="Enter Name Of Robot Here ...."  class="form-control" name="RobotName"  autofocus="true"  required="required">
					
					 </div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>Robot Type :<span class="alstrx">*</span></label></span>
					  <select name="RobotType">
					  		<option value="0"></option>
						 	<option value="Drones">Drones</option>
						 	<option value="Consumer">Consumer</option>
						 	<option value="Humanoids">Humanoids</option>
						 	<option value="Military">Military</option>
					  </select>
					</div>
					<p>Securty Chose:</p>
					<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="far fa-bookmark"></i> <label> Safe Area :  <span class="alstrx">*</span></label></span>
					  <input type="number" placeholder="Enter The distance"  class="form-control" name="SafeArea"  value="50">
					
					 </div>

					<div class="input-group LogGroup">
					    <span class="input-group-addon " id="basic-addon1"><i class="far fa-bookmark"></i> <label> Safe Area :  <span class="alstrx">*</span></label></span>
						<input type="checkbox" name="place1" value="MilitaryCity" checked> Military City<br>
						<input type="checkbox" name="place2" value="Airport" checked>Airport<br>
					
					 </div>

					<div class="input-group btnLogo">
						<input type="submit" value="Add Robot"  class="btn btn-success btn-lg ">
					</div>
				</form>
				<button id="ClEd" class="btn btn-danger btn-block">Close</button>
			</div>
    </div>
  </div>

<!-- START HTML-->
<div class="container">
	<div class="rowForUsers">
		<!-- START CODING LEFT SIDE-->
		 <div class="LeftContent col-lg-4 col-xs-4">
			 <h3 class="text-center">Control Panel</h3>
			 <hr>
			 <div class="upUi">
				 <img class='img img-responsive prof'src="layout/img/profile.png">
				 <p>UserNmae : <?php echo $rowForUsers['UserName']; ?> </p>
				 <p>Number Of Robots : <?php echo $NumberOfRobots; ?></p>
				 <button id = 'profileBtn'class="btn btn-success">Edit Profile</button>
				 <a href="Logout.php"><button class="btn btn-danger">Logout</button></a> 	
			 </div>
			 <hr>
			 <div class="downUi">
			 	<h3>My Robots</h3>
			<div class="table-resposive">

				<table class="main-table text-center table table-bordered table-striped table-dark">

					<tr>

						<td>Robot Name</td>

						<td>Robot Type</td>

						<td>Control</td>

					</tr>



					<?php
						$stmt = $db->prepare("SELECT * FROM Robots WHERE UserID = $UserIDSession");

	$stmt->execute();

	$AllRobots =$stmt->fetchAll();

						foreach ($AllRobots as  $OneRobot) {

							echo "<tr>";

								echo "<td> " . $OneRobot['RobotName'] ."</td>";

								echo "<td> " . $OneRobot['RobotType'] ."</td>";



								echo "<td>



								 <a href='editRobot.php?do=edit&RobotID=" . $OneRobot['RobotID'] . "' class='btn btn-success btn-sm' value='".   $OneRobot['RobotID']   ."'> <i class='fa fa-edit'> </i>Edit</a> 

							 	 <a href='editRobot.php?do=delete&RobotID=" . $OneRobot['RobotID'] . "' class='btn btn-danger  confirm  btn-sm'> <i class='fas fa-times'></i> Delete</a>";



							 	 echo "</td>"; 



							echo "</tr>";

							

						}





					 ?>







				</table>

			</div>
			 </div>
			 <button id="EditBtn" class="btn btn-primary btn-lg">Add ROBOT</button>


			 <hr>


			 	<h3 class="text-center">Hestory of robotrs</h3>

			<div class="BackLogin">
				<form action = "Hestory.php" method = "POST"enctype="multipart/form-data">

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>Robot Name :<span class="alstrx">*</span></label></span>
					  <select name="RobotID">
					  		<?php foreach ($AllRobots as  $OneRobot) {

							echo "<option value=". $OneRobot['RobotID'] . ">" . $OneRobot['RobotName'] ."</option>";
						}
							?>
					  </select>
					</div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>From :<span class="alstrx">*</span></label></span>
					  <input type="datetime-local" name="StartDate">
					</div>
		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>To<span class="alstrx">*</span></label></span>
					  <input type="datetime-local" name="EndDate">
					</div>
					<div class="input-group btnLogo">
						<input type="submit" value="search"  class="btn btn-success btn-lg ">
					</div>
				</form>
			</div>
		 	

			 

		 </div>
		<!-- END CODING LEFT SIDE-->

		<!-- START CODING RIGHT SIDE-->
		 <div class="RightContent col-lg-8 col-xs-8">
		 	<div class="alert">
		 		<h3 style="color: red;font-weight: bold;">*ALERTS :</h3>
		 		<hr>
		 		<div id="alert">
		 			
		 		</div>
		 	</div>


		 	<hr>
		 	<div id="map"></div>
		 	<div class="text-center">
		 		<button class="btn btn-primary" onclick="initMap()">RestMap</button>	
		 	</div>
		 
		 	<?php


		 	 ?>
		 		
		 	<script type="text/javascript">



					var robotData = <?php echo get_robot_data($UserIDSession)?>;

					console.log(robotData);
					var counter = 0;
					var CurrentArry = [];

			 
					for(var i=0; i<robotData.length; i++){
						var CurrentLatLng = "" + robotData[i][7] +"," + robotData[i][8];
						urll = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + CurrentLatLng + "&sensor=false&key=AIzaSyBJ3sEHb8_vH2YWmYXX28ZL53i8g9zO_bc";
					  $.ajax({	
						url : urll,
					    type: 'GET',
					    dataType: 'json',
					    async: false,
					    success: function(data){
						var Caddress = data.results[0].formatted_address;
						var res = Caddress.split("،");
						var TheAddress = "" + res[1] + "," + res[2];
					    var CurrentAddress = TheAddress.replace(/[0-9]/g, '');
					    CurrentArry.push(CurrentAddress); 
					    counter++;
					    }
					  });

					}
					


				function distance(lat1, lon1, lat2, lon2, unit) {
					if ((lat1 == lat2) && (lon1 == lon2)) {
						return 0;
					}
					else {
						var radlat1 = Math.PI * lat1/180;
						var radlat2 = Math.PI * lat2/180;
						var theta = lon1-lon2;
						var radtheta = Math.PI * theta/180;
						var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
						if (dist > 1) {
							dist = 1;
						}
						dist = Math.acos(dist);
						dist = dist * 180/Math.PI;
						dist = dist * 60 * 1.1515;
						if (unit=="K") { dist = dist * 1.609344 }
						if (unit=="N") { dist = dist * 0.8684 }
						return dist;
					}
				}

				function getLocation() {
				  if (navigator.geolocation) {
				    navigator.geolocation.getCurrentPosition(showPosition);
				  } else {
				    console.log( "Geolocation is not supported by this browser.");
				  }
				}


				distanceUserRoobot = [];
				function showPosition(position) {
					console.log("Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude);
					var UserLat = position.coords.latitude;
					var UserLng = position.coords.longitude;
	        		var allSelctedArea = true;
	        		var allSafeArea = true;
	 				for (i = 0; i < robotData.length; i++) {
						var CalcDistanceUser = distance(UserLat,UserLng,robotData[i][7],robotData[i][8],"K");
						var RoundDistanceUser = Math.round(CalcDistanceUser * 100) / 100;
						distanceUserRoobot[i] = RoundDistanceUser;
						if (distanceUserRoobot[i] < robotData[i][5]) {
							$("#alert").append("<div class='alert alert-danger container'> <i class='fas fa-times'></i> <i class='fas fa-times'></i> <i class='fas fa-times'></i> <b id='RobotDanger'>" +  robotData[i][1]   +"</b> Out OF Selected Arera <i class='fas fa-times'></i> <i class='fas fa-times'></i> <i class='fas fa-times'> </i></div>");
							allSelctedArea = false;
							
						}
						var DangerPlacee = robotData[i][6];
						var SerchDangerPlace = DangerPlacee.search("MilitaryCity");


						var CurrentAddress = CurrentArry[i];
						var SerchCurrntAddess = CurrentAddress.search("منطقة العسكرية");

						var DangerPlacee2 = robotData[i][6];
						var SerchDangerPlace2 = DangerPlacee2.search("Airport");


						var CurrentAddress2 = CurrentArry[i];
						var SerchCurrntAddess2 = CurrentAddress2.search("حي المطار");


						console.log("ROBOT DANGER " + SerchDangerPlace2 + " Cur" + SerchCurrntAddess2 );

						if (SerchDangerPlace != -1 &&  SerchCurrntAddess != -1 ) {

							$("#alert").append("<div class='alert alert-danger container'> <i class='fas fa-times'></i> <i class='fas fa-times'></i> <i class='fas fa-times'></i> <b id='RobotDanger'>" +  robotData[i][1]   +"</b> In a Restricted area <i class='fas fa-times'></i> <i class='fas fa-times'></i> <i class='fas fa-times'> </i></div>");
							allSafeArea = false;
						}

						if (SerchDangerPlace2 != -1 && SerchCurrntAddess2 != -1) {
							$("#alert").append("<div class='alert alert-danger container'> <i class='fas fa-times'></i> <i class='fas fa-times'></i> <i class='fas fa-times'></i> <b id='RobotDanger'>" +  robotData[i][1]   +"</b> In a Restricted area <i class='fas fa-times'></i> <i class='fas fa-times'></i> <i class='fas fa-times'> </i></div>");
							allSafeArea = false;
						}

					}
					if (allSelctedArea == true) {
						$("#alert").append("<div class='alert alert-success container'> <i class='far fa-check-circle'></i> ALL ROBOTs IN Selected AREA</div>");
					}	
					if (allSafeArea == true) {
						$("#alert").append("<div class='alert alert-success container'> <i class='far fa-check-circle'></i> ALL ROBOTs IN Safe Side</div>");
					}	
				}

				getLocation();







	    

				function initMap() {
					var CenterOfTabuk = {lat: 28.392127, lng:36.559459};
					var map = new google.maps.Map(
					document.getElementById('map'), {zoom: 20, center: CenterOfTabuk});
					var infowindow;
					var Consumer_icon = 'layout/img/robots_icon/Consumer.png';
					var drones_icon = 'layout/img/robots_icon/drones.png';
					var Humanoids_icon = 'layout/img/robots_icon/Humanoids.png';
					var Military_icon = 'layout/img/robots_icon/Military.png';
					var markers = {};
			        var i ;var icon = "";
			        var bounds = new google.maps.LatLngBounds();

			        for (i = 0; i < robotData.length; i++) {
			        	switch(robotData[i][2]) {
						  case "Consumer":
						    icon = Consumer_icon;
						    break;
						  case "Drones" :
						    icon = drones_icon;
						    break;
						  case "Humanoids":
						    icon = Humanoids_icon;
						    break;
						  case "Military" :
						    icon = Military_icon;
						    break;
						  default:
						  icon = "null";
						}
					var myLatLng = new google.maps.LatLng(robotData[i][7], robotData[i][8]);
			            marker = new google.maps.Marker({
			                position: new google.maps.LatLng(robotData[i][7], robotData[i][8]),
			                map: map,
			                icon :   icon,
			                html: 	"<div class='MaskPanel'>" +
			                		 "<div class='panel panel-info'>" +
			                		 	"<div class='panel-heading'>Robot Informaiton</div>"+
			                		 	"<div class='panel-body'>"+
			                		 		"Name: <span class='CusInfo'>[ "  + robotData[i][1] +  "] </span>"+
			                		 		"</br> Now in :  <span class='CusInfo'>[ " +  CurrentArry[i] + "]</span>"+
			                		 		"</br> Away from you :  <span class='CusInfo'>[ " +  distanceUserRoobot[i] + " Kilometers ]</span>"+
			                		 		"</br>"+
			                		 			 "<a target='_blank' href='https://www.google.com/maps/search/?api=1&query=" + robotData[i][7] + "," + robotData[i][8] + "'> "+
			                		 				"<buttn class='btn btn-primary buttnClass'>GO To Robot !!</buttn></a>"+
			                		 		"</div>"+
			                		 	"</div>" +
			                		 "</div>"
			                	  
			            });


			            bounds.extend(myLatLng);
					    google.maps.event.addListener(marker, 'click', (function(marker, i) {
		                return function() {
		                    infowindow = new google.maps.InfoWindow();
		                    infowindow.setContent(marker.html);
		                    infowindow.open(map, marker);
		                }
		            })(marker, i));
					 }
					 map.fitBounds(bounds);
				}


		 	</script>
		</div>
		<!-- END CODING RIGHT SIDE-->
	</div> <!-- END rowForUsers-->
</div> <!-- END Conter-->


<!-- END HTML-->
<?php

include $tmpl . 'footer.php';


 ?>

 