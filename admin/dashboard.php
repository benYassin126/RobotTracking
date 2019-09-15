<?php

	
SESSION_START();

$PageTitle = "Dashboard";

//check if user authoize to login this page
if(isset($_SESSION["AdminID"])) {

	include 'init.php';


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
									<span> <?php echo countOfItems("UserID" , "users"); ?> </span>
								</div>	
							</div>
					</a>
					</div>


					<div class="col-sm-3">
						<a href="Books.php">
							<div class="one-stat st-item">
								<i class="fa fa-tag"></i>
								<div class="info">
									<p>Total Books</p>
									<span><?php echo countOfItems("BookID" , "books"); ?></span>	
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>

		<?php

		 $NumberOfLimitForUsers = 10;
		 $LastUsers = LastRecord ("*", "users" , "UserID", $NumberOfLimitForUsers);

		 $NumberOfLimitForBooks = 10;
		 $LastBooks = LastRecord ("*", "books" , "BookID", $NumberOfLimitForBooks);

	


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
											 
											echo "<li>" .  $last["FullName"]  . "<a href='users.php?do=delete&UserID=" .$last["UserID"] . "'>
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
								Lastest <?php echo $NumberOfLimitForBooks; ?>  Books
									<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled lastestUser">
									<?php
										foreach ($LastBooks as $last) {
											echo "<li>" .  $last["BookName"]  . "<a href='books.php?do=delete&BookID=" .$last["BookID"] . "'>
																					<span class='btn btn-danger pull-right confirm'>
																						<i class='fa fa-times'></i>
																							delete
																					</span>  
																				</a> " . "<a href='books.php?do=edit&BookID=" .$last["BookID"] . "'>
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
	include $tmpl . "footer.php";
	

	} else {
		
		header("location:index.php");
		exit();

	}
?>