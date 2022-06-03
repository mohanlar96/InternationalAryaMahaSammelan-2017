<?php
session_start();


$msg="";



	$username=trim($_POST["username"]);
	$password=trim($_POST["password"]);
	
	


		if($username=="soesayam" && $password=="soesayam123"){
			$_SESSION["admin"]="success";
			$msg="success";

		}else{
			$msg="Your Username and  Password Incorrect";
		}




	


echo $msg;

?>