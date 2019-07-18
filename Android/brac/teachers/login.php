<?php 
	include 'base.php';
	session_start();
	$result = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashed_password = md5($password);

		$query = "SELECT id,name,phone,school_id,address,gender 
				 FROM teacher WHERE name='$username' AND 
				 password = '$hashed_password'; ";
		$db = DB::connection();
		$res = pg_query($db->getRefference(),$query);
		$obj = pg_fetch_object($res);
		$query = "SELECT po_id FROM poteacher WHERE teacher_id = $obj->id;";

		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$po_id = $row['0'];
		$query = "SELECT name FROM po WHERE id = $po_id;";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$po_name = $row['0'];
		$query = "SELECT name from school WHERE id = $obj->school_id;";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$school_name = $row['0'];

		if($obj){
		 	$result['teacher_id'] = $obj->id;
		 	$result['teacher_name'] = $obj->name;
		 	$result['gender'] = $obj->gender;
		 	$result['phone'] = $obj->phone;
		 	$result['school_name'] = $school_name;
		 	$result['address'] = $obj->address;
		 	$result['po_name'] = $po_name;
		 	$result['error'] = false;
		 	$result['school_id'] = $obj->school_id;
		 	//header('Location: profile.php');
		}
		else {
			$result['error']= true;
		 	}
	}
	echo json_encode($result);
 