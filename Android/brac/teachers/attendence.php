<?php 
	include 'base.php';
	$school_id = $_GET['school'];
	$result= [];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$student_id = $_POST['student'];
		$status = $_POST['status'];
		$db = DB::connection();
		$res = ($db->getRefference(),
				"CALL giveAttendence(
					$student_id::int,
					$
				)")
	}