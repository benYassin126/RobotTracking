<?php

SESSION_START(); // Start The SESSION To Get all Varabels and Set Some Varabels

$PageTitle = "Dashboard"; // Set 'Admin Login' in Page Tiltle Via getTitle() Funciton



//check if user authoize to login this page

if(isset($_SESSION["AdminID"])) {

include 'init.php'; // To include All Importants File Like [Connect To DB and Header ..etc]

	 ?>

	<!-- START HTML FOR DASHBORD-->
		<div class="stat text-center">

			<div class="container">

				<h1 class="">Dashboard</h1>

				<div class="row">

					<div class="col-sm-offset-3 col-sm-3">

						<a href="users.php">

							<div class="one-stat st-members">

								<i class="fa fa-users"></i>

								<div class="info">

									<p>  Total Users  </p>

									<span> <?php echo countOfRecors("UserID" , "users"); // use countOfRecors Function to get Number of Records in Table  ?> </span>

								</div>	

							</div>

					</a>

					</div>


					<div class="col-sm-3">

						<a href="Books.php">

							<div class="one-stat st-item">

								<i class="fa fa-tag"></i>

								<div class="info">

									<p>Total Robots</p>

									<span><?php echo countOfRecors("RobotID" , "robots"); // use countOfRecors Function to get Number of Records in Table   ?></span>	

								</div>

							</div>

						</a>

					</div>

				</div>

			</div>

		</div>



		<?php



		 $NumberOfLimitForUsers = 10; // Chose ntmber of record to show last page

		 $LastUsers = LastRecord ("*", "users" , "UserID", $NumberOfLimitForUsers); // use LastRecord funciton to get last records in a table



		 $NumberOfLimitForRobots = 10;

		 $LastBooks = LastRecord ("*", "robots" , "RobotID", $NumberOfLimitForRobots); // use LastRecord funciton to get last records in a table


		 ?>

		<div class="lastest">

			<div class="container">

				<div class="row">

					<div class="col-sm-6">

						<div class="panel panel-default">

							<div class="panel-heading">

								<i class="fa fa-users"></i> 

								Lastest <?php echo $NumberOfLimitForUsers; ?> Users

								<span class="toggle-info pull-right">

									<i class="fa fa-plus fa-lg"></i>

								</span>

							</div>

							<div class="panel-body">

								<ul class="list-unstyled lastestUser">

									<?php

				foreach ($LastUsers as $last) {
		 	//get data from db and style it

							echo "<li>" .  $last["UserName"]  . "<a href='users.php?do=delete&UserID=" .$last["UserID"] . "'>

							<span class='btn btn-danger pull-right confirm'>

								<i class='fa fa-times'></i>

									delete

							</span>  

						</a> " . "<a href='users.php?do=edit&UserID=" .$last["UserID"] . "'>

							<span class='btn btn-success pull-right'>

								<i class='fa fa-edit'></i>

									Edit

							</span>  

						</a> ";

							echo "</li>";


							}


									 ?>

								 </ul>

							</div>

						</div>

					</div>



					<div class="col-sm-6">

						<div class="panel panel-default">

							<div class="panel-heading">

								<i class="fa fa-tag"></i> 

								Lastest <?php echo $NumberOfLimitForRobots; ?>  Robots

									<span class="toggle-info pull-right">

									<i class="fa fa-plus fa-lg"></i>

								</span>

							</div>

							<div class="panel-body">

								<ul class="list-unstyled lastestUser">

									<?php

				foreach ($LastBooks as $last) {

					//get data from db and style it

								echo "<li>" .  $last["RobotName"]  . "<a href='books.php?do=delete&BookID=" .$last["RobotID"] . "'>

									<span class='btn btn-danger pull-right confirm'>

										<i class='fa fa-times'></i>

											delete

									</span>  

								</a> " . "<a href='books.php?do=edit&BookID=" .$last["RobotID"] . "'>

									<span class='btn btn-success pull-right'>

										<i class='fa fa-edit'></i>

											Edit

									</span>  

								</a> ";

								echo "</li>";

				}



									 ?>

									 </ul>

							</div>

						</div>

					</div>

				</div>











				</div>

			</div>

		</div>

	</div>



	<?php

	//add Footer to This Page

	include $tmpl . "footer.php";



	} else {

	//if not admin dont show this page
		header("location:index.php");

		exit();



	}

?>