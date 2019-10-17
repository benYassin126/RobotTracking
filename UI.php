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


?> 


<!-- START HTML-->

<div class="container">
	<div class="row">
		<!-- START CODING LEFT SIDE-->
		 <div class="LeftContent col-lg-2 col-xs-4">
			 <h3>Control Panel</h3>

		 </div>
		<!-- END CODING LEFT SIDE-->
		<!-- START CODING RIGHT SIDE-->
		 <div class="RightContent col-lg-10 col-xs-8">
		 	<div id="map"></div>
		 	<?php


		 	 ?>
		 		
		 	<script type="text/javascript">


					var robotData = <?php echo get_robot_data($UserIDSession)?>;
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

					var myVarToset = setInterval(Counterr, 10);
					function Counterr() {
						if (counter == robotData.length * 2 ) {
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
				AllLat = [];
				AllLng = [];
				distanceOverDay = [];

				for (i = 0; i < robotData.length; i++) {
					AllLat.push(robotData[i][2]);
					AllLat.push(robotData[i][4]);
					AllLng.push(robotData[i][3]);
					AllLng.push(robotData[i][5]);
				distanceOverDay[i] = distance(AllLat[0],AllLng[0],AllLat[1],AllLng[1],"K");
				AllLat = [];
				AllLng = [];
				console.log(parseInt(distanceOverDay[i]));
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
						  case "drones" :
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
			                		 		"</br> Kilometers over the last day :  <span class='CusInfo'>[ " +  distanceOverDay[i] + " ]</span>"+
			                		 		"</br> Away from you :  <span class='CusInfo'>[ " +  robotData[i][2] + " ]</span>"+
			                		 		"</br><buttn class='btn btn-block btn-primary buttnClass'>GO IT !!</buttn>"+
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

 