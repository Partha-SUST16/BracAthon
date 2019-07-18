<?php include 'base.php'; 

$result = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$query = "SELECT id,name,phone,school_id,address,gender 
					 FROM teacher WHERE name='$username' ; ";
		$db = DB::connection();
		$res = pg_query($db->getRefference(),$query);
		$obj = pg_fetch_object($res);
		$userid = $obj->id;
		$school_id = $obj->school_id;
	} else 
	{
		echo "No ";
	}

} else 
	$result['error'] = true;
echo json_encode($result);