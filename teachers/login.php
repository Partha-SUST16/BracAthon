<?php require_once 'db/database.php'; ?>


<?php 
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$username = $_POST['username'];
		$password = $POST['password'];
		$hashed_password = md5($password);

		$quey = "SELECT id,name,phone,school_id,address 
				 FROM teacher WHERE name='$username' AND 
				 password = '$hashed_password'; ";
		$db = DB::connection();
		$res = pg_query($db->getRefference(),$query);
		$obj = pg_fetch_object($res);
	}
 ?>