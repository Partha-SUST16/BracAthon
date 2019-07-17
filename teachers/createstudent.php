<?php 
	//session_start(); 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>Create Student - Brac</title>
<?php endblock() ?>

<?php 
	$failed = false;
	$userid = $_SESSION['userid'];
	$userschool = $_SESSION['schoolid'];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['name'];
		$father = $_POST['father'];
		$mother = $_POST['mother'];
		$address = $_POST['address'];
		$phone  = $_POST['phone'];
		$batch = $_POST['batch'];
		$gender = $_POST['gender'];

		$db = DB::connection();
		pg_query($db->getRefference(),
					"CALL createStudent(
					'$name'::varchar,
					$userschool::int,
					'$father'::varchar,
					'$mother'::varchar,
					'$address'::varchar,
					'$phone'::varchar,
					'$batch'::varchar,
					'$gender'::varchar
					)");
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
			<label>Father's Name</label>
			<input type="text" class="form-control mb-2" name="father" required>
			<label>Mother's Name</label>
			<input type="text" class="form-control mb-2" name="mother" required>
			<div class="form-group mb-2">
				<label for="Language">Gender</label>
				<select class="form-control" name="gender" required>
					<option value="F">Female</option>
					<option value="M">Male</option>
					<option value="O">Other</option>
				</select>
			</div>
			<label>Batch</label>
			<input class="form-control" type="text" name="batch"></input>
			<label>Address</label>
			<textarea class="form-control mb-2" name="address" required></textarea>
			<label>Phone</label>
			<input type="text" class="form-control" name="phone">
			<br>
			<button class="btn btn-success">Register</button>
		</form>
	</div>
</div>
<br>