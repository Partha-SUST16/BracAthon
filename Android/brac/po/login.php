<?php 
	include 'base.php';
	$result = [];
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = $_POST['username'];
			$password = $_POST['password'];
			$hashed_password = md5($password);
			$query = "SELECT id,name,phone,gender,address FROM
					   po WHERE name = '$username' AND 
					   password = '$hashed_password';";
			$db = DB::connection();
		 	$res = pg_query($db->getRefference(), $query);
		 	$obj = pg_fetch_object($res);
		 	$query = "SELECT branch_id FROM branchpo WHERE po_id = $obj->id;";
		 	$res = pg_query($db->getRefference(),$query);
			$row = pg_fetch_row($res);
			$branch_id = $row['0'];
			$query = "SELECT name FROM branch WHERE id = $branch_id;";
			$res = pg_query($db->getRefference(),$query);
			$row = pg_fetch_row($res);
			$branch_name = $row['0'];

		 	if($obj){
		 		$result['name'] = $obj->name;
		 		$result['phone'] = $obj->phone;
		 		$result['gender'] = $obj->gender;
		 		$result['address'] = $obj->address;
		 		$result['branch'] = $branch_name;
		 		$result['id'] = $obj->id;
		 		$result['error'] = false;

		 	}else {
		 		$result['error'] = true;
		 	}
	} else {
		$result['error'] = true;
	}
	echo json_encode($result);