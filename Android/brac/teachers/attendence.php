<?php 
	include 'base.php';
	$school_id = $_GET['school'];
	$name = $_GET['name'];
	//echo $name;
	$result= [];
	$nameList = explode(',', $name);
	$db = DB::connection();
	$status = 1;
	for($i = 0;$i<count($nameList);$i++){
		$studentName = $nameList[$i];
		echo json_encode($studentName);
		$query = "SELECT id FROM student WHERE name = '$studentName';";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$student_id = $row['0'];
		$query = "CALL giveAttendence(
					$student_id::int,
					$school_id::int,
					$status::int
				);";
		$res = pg_query($db->getRefference(),$query);
	}

	
	