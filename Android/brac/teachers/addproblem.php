<?php 
	include 'base.php';
	$school_id = $_GET['school'];
	$result= [];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$catagory = $_POST['catagory'];
		$reason = $_POST['reason'];
		$db = DB::connection();
		$res = pg_exec($db->getRefference(),
			"CALL addProblem(
				$school_id::int,
				'$catagory'::varchar,
				'$reason'::varchar
			);");
		if($res){
			$result['error'] = false;
		}else {
			$result['error'] = true;
		}
	}
	echo json_encode($result);