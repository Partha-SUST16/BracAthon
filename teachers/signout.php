<?php

	include 'base.php';
	if(isset($_SESSION['userid'])){
		session_unset(); 


		header('Refresh: 0; URL = login.php');
	}
	else{
		header('Refresh: 0; URL = login.php');
	}
	
?>