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
	$row = $stmt->fetch();
	//to get number of robot
	$statment = $db->prepare("SELECT * FROM robots WHERE UserID = ?");
 	$statment->execute(array($UserIDSession)); //execute statment
  	$count = $statment->rowCount();

  	$NumberOfRobots = $count;

if (isset($_GET['do'])) {
	$do = $_GET['do'];
}

if (isset($do) && $do = "update") {
	
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
}


?> 

<!-- The Peofile Modal -->
<div id="ProfileModel" class="modal">

  <!-- Modal content -->

  <div class="modal-content">
  		<h1 class="text-center">Edit Profile </h1>
  		<div class="BackLogin">
				<form action = "?do=update" method = "POST">


					<input type="hidden"  name="userid" value="<?php echo $row['UserID']; ?>">
		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-user"></i> <label> Username    <span class="alstrx">*</span></label></span>
					  <input type="text" value="<?php echo $row['UserName']; ?>" required="required" class=" form-control"  name="Username">

					 </div>


		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-lock"></i> <label> New Password <span class="alstrx">*</span></label></span>
					  <input type="Password" class=" form-control Password" name="new-password"   autocomplete="new-password">
					  <input type="hidden"  value="<?php echo $row['Password']; ?>"  class="input-lg form-control" name="old-Password" >
					</div>

		 			<div class="input-group LogGroup">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-email"></i> <label>Email   <span class="alstrx">*</span></label></span>
					  <input type="Email" value="<?php echo $row['Email']?>" required="required" class=" form-control" name="Email">
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
    <button id="ClEd" class="btn btn-danger btn-block">Close</button>
    </div>
  </div>

<!-- START HTML-->
<div class="container">
	<div class="row">
		<!-- START CODING LEFT SIDE-->
		 <div class="LeftContent col-lg-4 col-xs-4">
			 <h3 class="text-center">Control Panel</h3>
			 <hr>
			 <div class="upUi">
				 <img class='img img-responsive prof'src="layout/img/profile.png">
				 <p>UserNmae : <?php echo $row['UserName']; ?> </p>
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

						$AllRobots = getAll("*" , "robots" , '' ,'' , "RobotID" ,"DESC"); // use getAll Function to get all records

						foreach ($AllRobots as  $OneRobot) {

							echo "<tr>";

								echo "<td> " . $OneRobot['RobotName'] ."</td>";

								echo "<td> " . $OneRobot['RobotType'] ."</td>";



								echo "<td>



								 <a id='EditBtn' class='btn btn-success btn-sm'> <i class='fa fa-edit'> </i>Edit</a> 

							 	 <a href='?do=delete&UserID=" . $OneRobot['UserID'] . "' class='btn btn-danger  confirm  btn-sm'> <i class='fas fa-times'></i> Delete</a>";



							 	 echo "</td>"; 



							echo "</tr>";

							

						}





					 ?>







				</table>

			</div>
			 </div>
			 <button class="btn btn-primary btn-lg">Add ROBOT</button>
			 

		 </div>
		<!-- END CODING LEFT SIDE-->
		<!-- START CODING RIGHT SIDE-->
		 <div class="RightContent col-lg-8 col-xs-8">
		 	<div id="map"></div>
		 	<?php


		 	 ?>
		 		
		 	<script type="text/javascript">


					var robotData = <?php echo get_robot_data($UserIDSession)?>;
					console.log(robotData);
					var counter = 0;
					var CurrentArry = [];
					var LastDayArry = [];

					for (i = 0; i < robotData.length; i++) {
						var CurrentLatLng = "" + robotData[i][2] +"," + robotData[i][3];
						var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + CurrentLatLng + "&sensor=false&key=AIzaSyBJ3sEHb8_vH2YWmYXX28ZL53i8g9zO_bc";
						var jqxhr = $.getJSON(url, function (data) {
							var Caddress = data.results[0].formatted_address;
							var res = Caddress.split("،");
							var TheAddress = "" + res[1] + "," + res[2];
							var CurrentAddress = TheAddress.replace(/[0-9]/g, '');
							console.log(CurrentAddress);
						    CurrentArry.push(CurrentAddress);     
						})
						.done(function() {
								counter++;
						})
						var LastDayLatLng = "" + robotData[i][4] +"," + robotData[i][5];
						var url1 = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + LastDayLatLng + "&sensor=false&key=AIzaSyBJ3sEHb8_vH2YWmYXX28ZL53i8g9zO_bc";
						var jqxhr1 = $.getJSON(url1, function (data) {
							var Laddress = data.results[0].formatted_address;
							var res = Laddress.split("،");
							var TheAddress = "" + res[1] + "," + res[2];
							TheAddress.replace(/[0-9]/g, '');
							var LastAdderss = TheAddress.replace(/[0-9]/g, '');
							console.log(LastAdderss);
							LastDayArry.push(LastAdderss);  
							
						})
						.done(function() {
							counter++;
						})
					}

					console.log("d0   " + counter )

					var myVarToset = setInterval(Counterr, 10);
					function Counterr() {
						console.log(counter);
						if (counter == robotData.length * 2 & UserLat > 0 ) {
							CalcUserFromRobot();
							initMap();
							clearInterval(myVarToset);
						}
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

					//Get User Location
					var UserLat = 0;
					var UserLng = 0;

					if (navigator.geolocation) { //check if geolocation is available
		                navigator.geolocation.getCurrentPosition(function(position){
		                   UserLat = position.coords.latitude;
		                   UserLng = position.coords.longitude;
		                }); 
	            	}


	            	function CalcUserFromRobot() {
	            		distanceUserRoobot = [];
		 				for (i = 0; i < robotData.length; i++) {
							var CalcDistanceUser = distance(UserLat,UserLng,robotData[i][2],robotData[i][3],"K");
							var RoundDistanceUser = Math.round(CalcDistanceUser * 100) / 100;
							distanceUserRoobot[i] = RoundDistanceUser;
						}	            		
	            	}



            	
				AllLat = [];
				AllLng = [];
				distanceOverDay = [];
				distanceUserRoobot = [];

				for (i = 0; i < robotData.length; i++) {
					AllLat.push(robotData[i][2]);
					AllLat.push(robotData[i][4]);
					AllLng.push(robotData[i][3]);
					AllLng.push(robotData[i][5]);
					var CalcDistanceDay = distance(AllLat[0],AllLng[0],AllLat[1],AllLng[1],"K");
					var RoundDistanceDay = Math.round(CalcDistanceDay * 100) / 100;
					distanceOverDay[i] = RoundDistanceDay;
					AllLat = [];
					AllLng = [];
				}
					

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
			        	switch(robotData[i][1]) {
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
					var myLatLng = new google.maps.LatLng(robotData[i][2], robotData[i][3]);
			            marker = new google.maps.Marker({
			                position: new google.maps.LatLng(robotData[i][2], robotData[i][3]),
			                map: map,
			                icon :   icon,
			                html: 	"<div class='MaskPanel'>" +
			                		 "<div class='panel panel-info'>" +
			                		 	"<div class='panel-heading'>Robot Informaiton</div>"+
			                		 	"<div class='panel-body'>"+
			                		 		"Name: <span class='CusInfo'>[ "  + robotData[i][0] +  "] </span>"+
			                		 		"</br> Now in :  <span class='CusInfo'>[ " +  CurrentArry[i] + "]</span>"+
			                		 		"</br> Last Day Was in :  <span class='CusInfo'>[ " +  LastDayArry[i] + " ]</span>"+
			                		 		"</br> Kilometers over the last day :  <span class='CusInfo'>[ " +  distanceOverDay[i] + " Kilometers ]</span>"+
			                		 		"</br> Away from you :  <span class='CusInfo'>[ " +  distanceUserRoobot[i] + " Kilometers ]</span>"+
			                		 		"</br>"+
			                		 			 "<a target='_blank' href='https://www.google.com/maps/search/?api=1&query=" + robotData[i][2] + "," + robotData[i][3] + "'> "+
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
	</div> <!-- END ROW-->
</div> <!-- END Conter-->


<!-- END HTML-->
<?php

include $tmpl . 'footer.php';


 ?>

 