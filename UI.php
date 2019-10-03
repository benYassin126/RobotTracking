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
		 		
		 	<script type="text/javascript">
				function initMap() {
					var CenterOfTabuk = {lat: 28.392127, lng:36.559459};
					var map = new google.maps.Map(
					document.getElementById('map'), {zoom: 20, center: CenterOfTabuk});
					//var marker = new google.maps.Marker({position: CenterOfTabuk, map: map});
					var robotData = <?php echo get_robot_data($UserIDSession)?>;
					console.log(robotData);
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
			                		 		"Name: <span class='CusInfo'>"  + robotData[i][0] +  "</span>"+
			                		 		"</br> Type:  <span class='CusInfo'>" +  robotData[i][1] + "</span>"+
			                		 		"</br> lat:  <span class='CusInfo'>" +  robotData[i][2] + "</span>"+
			                		 		"</br> lng:  <span class='CusInfo'>" +  robotData[i][3] + "</span>"+
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

 