<?php 
	//session_start(); 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>Create School - Brac</title>
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
		$area = $_POST['area'];
		$_union = $_POST['_union'];
		$thana = $_POST['thana'];
		$region = $_POST['region'];

		$db = DB::connection();
		pg_query($db->getRefference(),
				 "CALL createSchool(
				 	'$name'::varchar,
				 	'$area'::varchar,
				 	'$_union'::varchar,
				 	'$thana'::varchar,
				 	'$region'::varchar
				 	);");
		$res = pg_query($db->getRefference(),"SELECT id FROM po WHERE name ='$name'
			;");
		
		//header('Location : profile.php');
	}
 ?>

<div class="d-flex justify-content-center mt-4">
	<div class="col-md-5 list-group-item">
		<h4 class="lead text-center">School Registration Form</h4>
		<form method="POST">
			<?php if($failed == true): ?>
				<p class="alert alert-danger">creation failed</p>
			<?php endif; ?>
			<label>Name</label>
			<input type="text" class="form-control mb-2" name="name" required>
			<label>Area</label>
			<input type="text" class="form-control mb-2" name="area" required>
			<label>Union</label>
			<input class="form-control mb-2" name="_union" required></input>
			<label>Thana</label>
			<input type="text" class="form-control" name="thana">
			<label>Region</label>
			<input type="text" class="form-control" name="region">
			<br>
			<button class="btn btn-success">Submit</button>
		</form>
	</div>
</div>
<br>