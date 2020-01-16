<?php
session_start();
$PageTitle = "History of Robots";

include 'init.php';

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$RobotID = $_POST['RobotID'];
			echo $RobotID;
			$StartDate   = "'" .$_POST['StartDate'] .":00'";
			$EndDate   = "'" .$_POST['EndDate'] .":00'";
			$UserID = $_SESSION['UserIDSession'];
	}
	?>
<!-- START HTML-->
<div class="container">
	<div class="rowForUsers">
		<!-- START CODING LEFT SIDE-->
		 <div class="LeftContent col-lg-4 col-xs-4">
			 <h4 style="margin-top: 200px;" class="text-center">All places where the robot was through </br> [ <?php echo  $StartDate ?> ] </br>To </br> [ <?php echo  $EndDate ?> ] .</h4>
			 <h3>Total of Kilometers :<h2 style="color:red;"  id="TotalKilo"></h2> </h3>
			 <hr>
			 <div id="alert" style="display: none; width: 100%" class='container alert alert-warning '>  <i class="fas fa-times"></i> no information  </div>
			
		 </div>
		<!-- END CODING LEFT SIDE-->

		<!-- START CODING RIGHT SIDE-->
		 <div class="RightContent col-lg-8 col-xs-8">
		 	<div id="map"></div>
		 	<?php echo $RobotID ?>
			</div>
	
		 	<script type="text/javascript">

				var robotlocations = <?php echo get_robot_locations($RobotID)?>;
				if (robotlocations.length == 0 ) {
					$("#alert").fadeIn();
				}
				console.log(robotlocations);
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
	

				function toTimestamp(strDate){
				 var datum = Date.parse(strDate);
				 return datum/1000;
				}
					var start1 = <?php echo $StartDate;?>;
					var start2 = start1.replace(/-/g, " ");
					var StartDate = start2.replace(/T/g, " ");

					var end1 = <?php echo $EndDate;?>;
					var end2 = end1.replace(/-/g, " ");
					var EndDate = end2.replace("T", " ");

					nowTimeStamp = Math.floor(new Date().getTime()/1000);
					StartDateStamp = toTimestamp(StartDate);
					EndDateStamp = toTimestamp(EndDate);


					//Conditon if Time End Less Than Start
					if (EndDateStamp < StartDateStamp ) {
						alert('Time End Less Than Start!');
						//window.location.href = "index.php";
					}if (EndDateStamp == 946674000) {
						alert('Plase Enter Date');
						window.location.href = "index.php";		
					}if (StartDateStamp >= nowTimeStamp || EndDateStamp >= nowTimeStamp) {
						alert('How i can Track Futer Date !!!!');
						window.location.href = "index.php";	
					}

					AllLat = [];
					AllLng = [];
					TimeOfLoctaion = [];

			        for (i = 0; i < robotlocations.length; i++) {

			        	var loc = robotlocations[i][0];
			     		var location1 = loc.replace(/-/g, " ");
			     		var locationStamp = toTimestamp(location1);

						if (locationStamp > StartDateStamp && locationStamp < EndDateStamp) {
							AllLat.push(robotlocations[i][1]);
							AllLng.push(robotlocations[i][2]);
							TimeOfLoctaion.push(robotlocations[i][0]);
						}
					}



				var map = [];
				var markerss = [];
				var coords = [];	


				function initMap() {

					var startIcon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
					var endIcon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
					var throughIcon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
					var CenterOfTabuk = {lat: 28.392127, lng:36.559459};
					var map = new google.maps.Map(
					document.getElementById('map'), {zoom: 15, center: CenterOfTabuk});
					var infowindow;
					var markers = {};
			        var i ;
			        var bounds = new google.maps.LatLngBounds();
			        console.log(robotlocations);


			        for (i = 0; i < AllLat.length; i++) {
			        	switch(i) {
						  case 0:
						    icon = endIcon;
						    break;
						  case AllLat.length -1 :
						    icon = startIcon;
						    break;
						  default:
						  icon = throughIcon;
						}

							
							
						var myLatLng = new google.maps.LatLng(AllLat[i], AllLng[i]);
				            marker = new google.maps.Marker({
				                position: myLatLng,
				                map: map,
				                icon : icon,
				                html: 	"<div class='MaskPanel'>" +
				                		 "<div class='panel panel-info'>" +
				                		 	"<div class='panel-heading'>Robot Informaiton</div>"+
				                		 	"<div class='panel-body'>"+
				                		 		"Time: <span class='CusInfo'>[ "  + TimeOfLoctaion[i] +  "] </span>"+
				                		 		"</div>"+
				                		 	"</div>" +
				                		 "</div>"
				                	  
				            });
				           //push to array
						    markerss.push(marker);
						    coords.push(myLatLng);

			            bounds.extend(myLatLng);
					    google.maps.event.addListener(marker, 'click', (function(marker, i) {
		                return function() {
		                    infowindow = new google.maps.InfoWindow();
		                    infowindow.setContent(marker.html);
		                    infowindow.open(map, marker);
		                }
		            })(marker, i));
					 }
					var line= new google.maps.Polyline({
					    path: coords,
					    geodesic: true,
					    strokeColor: '#FF0000',
					    strokeOpacity: 1.0,
					    strokeWeight: 2
					});

					line.setMap(map);
					 map.fitBounds(bounds);
				
				var TheTotalKelow = 0;
				for (i = 0; i < AllLat.length -1  ; i++) {
					var j = i + 1;
					var CalcDistanceDay = distance(AllLat[i],AllLng[i],AllLat[j],AllLng[j],"K");
					//var RoundDistanceDay = Math.round(CalcDistanceDay * 100) / 100;
					TheTotalKelow = TheTotalKelow + CalcDistanceDay;
					console.log(TheTotalKelow);

				}
				var RoundTotalKilew = Math.round(TheTotalKelow * 100) / 100;
				document.getElementById("TotalKilo").innerHTML = "[ " + RoundTotalKilew + " ] Kilometers";
			}




		 	</script>
		 	<?php

include $tmpl . 'footer.php';


 ?>