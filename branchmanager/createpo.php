<?php 
	//session_start(); 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>Create PO - Brac</title>
<?php endblock() ?>

<?php 
	$failed = false;
	/*createPO
	 		name varchar(50),
			_phone varchar(11),
			password varchar(40),
			gender varchar(1),
			address varchar(10)
	*/
	$userid = $_SESSION['userid'];
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$gender = $_POST['gender'];
		$address = $_POST['address'];
		$password = $_POST['password'];
		$hashed_password = md5($password);
		$db = DB::connection();
		pg_query($db->getRefference(),
				 "CALL createPO(
				 	'$name'::varchar,
				 	'$phone'::varchar,
				 	'$hashed_password'::varchar,
				 	'$gender'::varchar,
				 	'$address'::varchar
				 	);");
		$res = pg_query($db->getRefference(),"SELECT id FROM po WHERE name ='$name' AND password = '$hashed_password'
			;");
		$row = pg_fetch_row($res);
		$poid = $row['0'];
		//po_id int,branch_id int
		$query = "CALL addPO($poid::int,$userid::int);";
		$res2 = pg_query($db->getRefference(),$query);
		
		//header('Location : profile.php');
	}
 ?>

<div class="d-flex justify-content-center mt-4">
	<div class="col-md-5 list-group-item">
		<h4 class="lead text-center">Registration Form</h4>
		<form method="POST">
			<?php if($failed == true): ?>
				<p class="alert alert-danger">creation failed</p>
			<?php endif; ?>
			<label>Name</label>
			<input type="text" class="form-control mb-2" name="name" required>
			<label>Phone</label>
			<input type="text" class="form-control mb-2" name="phone" required>
			<div class="form-group mb-2">
				<label for="Language">Gender</label>
				<select class="form-control" name="gender" required>
					<option value="F">Female</option>
					<option value="M">Male</option>
					<option value="O">Other</option>
				</select>
			</div>
			<label>Address</label>
			<textarea class="form-control mb-2" name="address" required></textarea>
			<label>Password</label>
			<input type="password" class="form-control" name="password">
			<br>
			<button class="btn btn-success">Sign up</button>
		</form>
	</div>
</div>
<br>