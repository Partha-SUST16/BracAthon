<?php require_once 'db/database.php'; ?>

<?php 
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['username'];
		$phone  =$_POST['phone'];
		$school_name = $_POST['school_name'];
		$password = $_POST['password'];
		$hased_pass = md5($password);
		$address = $_POST['address'];
		$gender = $_POST['gender'];

		$db = DB::connection();
		$query = "SELECT id FROM school WHERE name ILIKE '$school_name' ;";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$id = $row['0'];

/*
			name varchar(50),
			_phone varchar(11),
			school_id int,
			password varchar(40),
			gender varchar(1),
			address varchar(10)
*/
		pg_query($db->getRefference(),
				"CALL createTeacher(
					'$name'::varchar,
					'$phone'::varchar,
					 $id::int,
					'$hased_pass'::varchar,
					'$gender'::varchar,
					'$address'::varchar
				);");
	}
 ?>