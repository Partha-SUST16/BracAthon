<?php 
	include 'base.php';
	$result = [];
	$school_id = $_GET['school'];
	$db = DB::connection();
	$problemList = [];
	$res = pg_query($db->getRefference(),
			"SELECT id,catagory,details,issue_date,is_varified FROM problem WHERE school_id=$school_id;" 
			);
	while($data = pg_fetch_object($res)){
		array_push($problemList, $data);
	}
	$result['error']  = false;
	$result['problem'] = $problemList;
	echo json_encode($result);