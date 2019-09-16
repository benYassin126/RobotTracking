<?php

//Delet all Session To logout
session_start();

session_unset();

session_destroy();

	header("location:index.php");//Go To Panel Login
    exit;



?>