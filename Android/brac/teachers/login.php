<?php 
	include 'base.php';
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
		
		if($obj){
		 	$result['teacher_id'] = $obj->id;
		 	$result['teacher_name'] = $obj->name;
		 	$result['gender'] = $obj->gender;
		 	$result['school_id'] = $obj->school_id;
		 	$result['address'] = $obj->address;
		 	$result['error'] = false;
		 	//header('Location: profile.php');
		}
		else {
			$result['error']= true;
		 	}
	}
	echo json_encode($result);
 