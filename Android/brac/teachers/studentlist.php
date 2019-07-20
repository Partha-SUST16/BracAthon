<?php 
	include 'base.php';
	$result = [];
	$school = $_GET['school'];
	$studentList = [];
		$db = DB::connection();

	$res = pg_query($db->getRefference(),
			"SELECT name,id,gender FROM student WHERE school_id = $school;");
	while($data = pg_fetch_object($res)){
		array_push($studentList, $data);
	}
	$result['error'] = false;
	$result['student'] = $studentList;
	echo json_encode($result);