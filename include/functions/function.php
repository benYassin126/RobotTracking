<?php

function getAll($fields , $table , $where = NULL , $and = NULL , $orderfield , $ordering ="DESC") {

	global $db;

	$stmt = $db->prepare("SELECT $fields FROM $table $where $and ORDER BY $orderfield $ordering");

	$stmt->execute();

	$row =$stmt->fetchAll();



	return $row;

}

//Function to set Title

 function getTitle()
{
	global $PageTitle;


	if(isset($PageTitle)) {

		echo $PageTitle;
	} else {
		echo "Default";
	}
}

//Funcuiton to get Robot data From DB
function get_robot_data($UserID){
    $con=mysqli_connect ("localhost", 'root', '','robottracking');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"
		SELECT RobotName,RobotType,LastHourLat,LastHourLng,LastDayLat,LastDayLng
		FROM robots
		INNER JOIN locations ON robots.RobotID = locations.RobotID
		WHERE robots.UserID = $UserID;
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}


//Redairct Function 

function Redirect ($msg ,$url = null , $seconds = 3) {


	if($url == null) {

		$url = "index.php";

		$link = "Home Page";

	}else { 
		if (isset($_SERVER["HTTP_REFERER"]) &&  $_SERVER["HTTP_REFERER"] != '') {

			$url = $_SERVER["HTTP_REFERER"];

			$link = "Perver Page";
		}else {

			$url = "index.php";
			$link = "Perver Page";
			
		}

	}


	echo  $msg;

	echo "<div class='alert alert-info container'> You Will Dirctory to $link After $seconds seconds </div>";

	header("refresh:$seconds , url=$url");
	exit();
}


//chek if item is exsit in table or not


function TestExist($select , $from ,$value) {

	global $db;
	 	$statment = $db->prepare("
 		SELECT 
 		$select
 		FROM 
 		$from
 		WHERE 
 		$select = ? ");


 	$statment->execute(array($value)); //execute statment
 	$count = $statment->rowCount(); // return number of colume that executed

 		return $count;
}


//Calculet number of Record in a Table


function countOfItems($itemName , $tableName) {


			global $db;

		 	$stmt = $db->prepare("
	 		SELECT count($itemName)
	 		FROM 
	 		$tableName");


	 	$stmt->execute(); //execute statment
	 	$row = $stmt->fetchColumn(); // Get Data In Array

	 	return $row;
}


//Function to Get last record

function LastRecord ($select, $table , $order,$limit) {


		global $db;

	 	$stmt = $db->prepare("
 		SELECT 	$select FROM $table ORDER BY $order DESC LIMIT $limit");


 	$stmt->execute(); //execute statment
 	$row = $stmt->fetchAll(); // Get Data In Array

 	return $row;

}





?>