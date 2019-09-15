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
			<h1 class="text-center">Books Manage</h1>
			<div class="table-resposive">
				<table class="main-table text-center table table-bordered table-striped table-dark">
					<tr>
						<td>#BookID</td>
						<td>Book Name</td>
						<td>Category</td>
						<td>City</td>
						<td>Time</td>
						<td>Status</td>
						<td>Date</td>
						<td>Username</td>
						<td>Control</td>
					</tr>

					<?php
						 	$stmt = $db->prepare("
								SELECT books.* , users.FullName 
								FROM 
								books
								INNER JOIN 
								users
								ON
								users.UserID = books.UserID
								");

	 						$stmt->execute(); //execute statment
	 						$AllUsers = $stmt->fetchAll(); // Get Data In Array
						 


						foreach ($AllUsers as  $OneBook) {
							echo "<tr>";
								echo "<td> " . $OneBook['BookID'] ."</td>";
								echo "<td> " . $OneBook['BookName'] ."</td>";
								echo "<td> " . $OneBook['Category'] ."</td>";
								echo "<td> " . $OneBook['City'] ."</td>";
								echo "<td> " . $OneBook['Time'] ."</td>";
								if ($OneBook['Status'] == 0) {
									
									echo "<td> Open </td>";

								}else {

									echo "<td> Close </td>";
								}
								
								echo "<td> " . $OneBook['Date'] ."</td>";
								echo "<td> " . $OneBook['FullName'] ."</td>";

								echo "<td>

								 <a href='?do=edit&BookID=" . $OneBook['BookID'] . "' class='btn btn-success'> <i class='fa fa-edit'> </i>Edit</a> 
							 	 <a href='?do=delete&BookID=" . $OneBook['BookID'] . "' class='btn btn-danger  confirm '> <i class='fas fa-times'></i> Delete</a>";

							 	 echo "</td>"; 

							echo "</tr>";
							
						}


					 ?>



				</table>
			</div>
		</div>
<?php

}elseif ($do == "edit") {

	echo "<h1 class='text-center'>Edit Books</h1>";


	//check if id come from get is number
	if (isset($_GET['BookID'])  && is_numeric($_GET['BookID'])) {
	 	
	 	$BookID =  $_GET['BookID'];
		$statment = $db->prepare("SELECT * FROM books WHERE BookID = ? LIMIT 1");
		$statment->execute(array($BookID)); //execute statment
		$row = $statment->fetch(); // Get Data In Array

	 	?>

	 	<div class="container users">
	 		<div class="col-sm-6">

	 			<form action="?do=update" method="POST">

		 			<input type="hidden"  name="BookID" value="<?php echo $row['BookID']; ?>">

		 			<div class="input-group">
					  <span class="input-group-addon " id="basic-addon1"><i class="fas fa-book"></i> <label>Book Name <span class="alstrx">*</span></label></span>
					  <input type="text" class="input-lg form-control" name="BookName" required="required" value="<?php echo $row['BookName']; ?>">
					 </div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paste"></i> <label>Category <span class="alstrx">*</span></label></span>
						<select name="Category">
						 	<option <?php if ($row['Category'] == "جامعي") { echo "selected";} ?> value="جامعي">جامعي</option>
						 	<option  <?php if ($row['Category'] == "اسلامي") { echo "selected";} ?> value="اسلامي">اسلامي</option>
						 	<option  <?php if ($row['Category'] == "تطوير ذات") { echo "selected";} ?> value="تطوير ذات">تطوير ذات</option>
						 	<option  <?php if ($row['Category'] == "تاريخي") { echo "selected";} ?> value="تاريخي">تاريخي</option>
						 	<option  <?php if ($row['Category'] == "ادبي") { echo "selected";} ?> value="ادبي">ادبي</option>
						 	<option  <?php if ($row['Category'] == "علمي") { echo "selected";} ?> value="علمي">علمي</option>
						 	<option  <?php if ($row['Category'] ==  "قصص وروايات") { echo "selected";} ?> value="قصص وروايات">قصص وروايات</option>
						 	<option  <?php if ($row['Category'] == "اخرى") { echo "selected";} ?> value="اخرى">اسلامي</option>
					  </select>
					</div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-globe"></i> <label>City <span class="alstrx">*</span></label></span>
					 <select name="City">
					  	<option <?php if ($row['City'] == "تبوك") { echo "selected";} ?> value="تبوك">تبوك</option>
					  	<option <?php if ($row['City'] == "الرياض") { echo "selected";} ?> value="الرياض">الرياض</option>
					  	<option <?php if ($row['City'] == "مكة المكرمة") { echo "selected";} ?> value="مكة المكرمة">مكة المكرمة</option>
					  	<option <?php if ($row['City'] == "المدينة المنورة") { echo "selected";} ?> value="المدينة المنورة">المدينة المنورة</option>
					  	<option <?php if ($row['City'] == "القصيم") { echo "selected";} ?> value="القصيم">تبوك</option>
					  	<option <?php if ($row['City'] == "الدمام") { echo "selected";} ?> value="الدمام">الدمام</option>
					  	<option <?php if ($row['City'] == "عسير") { echo "selected";} ?> value="عسير">عسير</option>
					  	<option <?php if ($row['City'] == "حائل") { echo "selected";} ?> value="حائل">حائل</option>
					  	<option <?php if ($row['City'] == "نجران") { echo "selected";} ?> value="نجران">نجران</option>
					  	<option <?php if ($row['City'] == "الباحة") { echo "selected";} ?> value="الباحة">الباحة</option>
					  	<option <?php if ($row['City'] == "الجوف") { echo "selected";} ?> value="الجوف">الجوف</option>
					  </select>
					</div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-clock"></i> <label>  Time <span class="alstrx">*</span></label></span>
					  <input type="text" class="input-lg form-control" name="Time" required="required" value="<?php echo $row['Time']; ?>">
					</div>

		 			<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1"><i class="fas fa-crosshairs"></i> <label>Status <span class="alstrx">*</span></label></span>
					 <select name="Status">
					 	<option <?php if ($row['Status'] == 1) { echo "selected";} ?> value="1">Close</option>
					 	<option  <?php if ($row['Status'] == 0) { echo "selected";} ?> value="0">Open</option>
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

		$BookID = $_POST['BookID'];
		$BookName = $_POST['BookName'];
		$Category = $_POST['Category'];
		$City = $_POST['City'];
		$Time = $_POST['Time'];
		$Status = $_POST['Status'];

		$erorrArray = array();

 	if (strlen($BookName) < 3) {

 		$erorrArray [] = "Book Name Biger than 3 Charecter";
 		
 	}



 	if (empty($erorrArray)) {

 				 	$stmt = $db->prepare("
			 		UPDATE 
			 		books
			 		SET 
			 		BookName = ? ,Category = ? , City = ? , Time = ? , Status = ?
			 		WHERE 
			 		BookID = ?");


			 	$stmt->execute(array($BookName ,$Category ,  $City , $Time , $Status ,$BookID)); //execute statment
		
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
	if (isset($_GET['BookID'])  && is_numeric($_GET['BookID'])) {
	 	
	 	$BookID =  $_GET['BookID'];

	 	//query for unblock
		$statment = $db->prepare("DELETE FROM books  WHERE BookID = ?");
	 	$statment->execute(array($BookID)); //execute statment
	 	$count = $statment->rowCount(); // return number of colume that executed

	 	//Seccess Msg
		echo "<div class='alert alert-success container'> Done Book Now  Is Deleted </div>";
		//Redairct After Done Update
		header("refresh:2 , url=books.php");
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