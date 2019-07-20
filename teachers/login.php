<?php 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>sign in - Brac</title>
<?php endblock() ?>

<?php startblock('content') ?>
<?php 
$result = [];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashed_password = md5($password);

		$query = "SELECT id,name,phone,school_id,address 
				 FROM teacher WHERE name='$username' AND 
				 password = '$hashed_password'; ";
		$db = DB::connection();
		$res = pg_query($db->getRefference(),$query);
		$obj = pg_fetch_object($res);
		
		if($obj){
			$_SESSION['valid'] = true;
		 	$_SESSION['timeout'] = time();
		 	$_SESSION['userid'] = $obj->id;
		 	$_SESSION['schoolid']=$obj->school_id;
		 	$result['teacher_id'] = $obj->id;
		 	$result['error'] = false;
		 	header('Location: profile.php');
		}
		else {
			$result['error']= true;
		 		echo '
		 			<div class="d-flex justify-content-center">
			 			<div class="col-md-3">
				 			<div class="alert alert-danger mt-3">
							  <strong>invalid email or password</strong>
							</div>
						</div>
					</div>
		 		';
		 	}
	}
	//echo json_encode($result);
 ?>
  <div class="d-flex justify-content-center mt-3">
		<div class="col-md-3 list-group-item list-group-item-success">
			<h6 class="lead text-center text-dark">Sign In</h6>
			<form method="POST">
				<label>Name</label>
				<input class="form-control" type="text" name="username" required>
				<br>
				<label>Password</label>
				<input class="form-control" type="password" name="password" required>
				<br>
				<button class="btn btn-success mb-3" type="submit">sign in</button>
			</form>
		</div>
	</div>
	
	<?php
		if (isset($_SESSION['userid'])) {
		  echo 'User Logged In';
		}
				

	 ?>
<?php endblock() ?>