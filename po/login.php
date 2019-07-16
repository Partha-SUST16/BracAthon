<?php 
	//session_start(); 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>sign in - Brac</title>
<?php endblock() ?>

<?php startblock('content') ?>
	<?php 
		if(isset($_SESSION['userid'])){
			header('Location: profile.php');
		}
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
		 	if($obj){
		 		// create session
		 		$_SESSION['valid'] = true;
		 		$_SESSION['timeout'] = time();
		 		$_SESSION['userid'] = $obj->id;
		 		header('Location: profile.php');
		 	}
		 	else {
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
	 ?>
	 <div class="d-flex justify-content-center mt-3">
		<div class="col-md-3 list-group-item list-group-item-success">
			<h6 class="lead text-center text-dark">Sign In</h6>
			<form method="POST">
				<label>Email</label>
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