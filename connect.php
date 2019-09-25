<?php

    $dsn = "mysql:host=localhost;dbname=robottracking"; //For Data Source Name We Will Use It As Parameter

    $user ="root"; // For User We Will Use It As Parameter

    $pass=""; // if We Have Pass We Will Use It As Parameter

    $options = array (

        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" // For Ababic DataBase


         ); // Colliction Of Optaions For Good Connect

    try {


            $db = new PDO ($dsn , $user , $pass , $options); // Start Connect To DataBase


            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // Set Exception Mode


    } catch (PDOException $e) {



        echo  $e->getMessage(); // print Erorr Message

    }



 ?>