<?php 
	include 'base.php';
	$school_id = $_GET['school'];
	$result= [];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['name'];
		$father = $_POST['father'];
		$mother = $_POST['mother'];
		$address = $_POST['address'];
		$phone  = $_POST['phone'];
		$batch = $_POST['batch'];
		$gender = $_POST['gender'];
		$db = DB::connection();
		pg_query($db->getRefference(),
					"CALL createStudent(
					'$name'::varchar,
					$school_id::int,
					'$father'::varchar,
					'$mother'::varchar,
					'$address'::varchar,
					'$phone'::varchar,
					'$batch'::varchar,
					'$gender'::varchar
					)");
		$result['error'] = false;
	}