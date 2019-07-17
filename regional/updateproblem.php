<?php include 'base.php'; ?>
<?php startblock('header') ?>
	<title>Update Status</title>
<?php endblock() ?>

<?php startblock('container') ?>
<?php 
	$id = $_GET['id'];
	$query = "SELECT is_varified,is_solved FROM problem WHERE id = $id;";
	$db = DB::connection();
	$res = pg_query($db->getRefference(),$query);
	$row = pg_fetch_row($res);
	$is_varified = $row['0'];
	$is_solved = $row['1'];
	/*print_r($is_varified);
	print_r($is_solved);
	print_r($id);*/
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$varify = $_POST['varify'];
		$solve = $_POST['solve'];

		$update_query = "UPDATE problem SET is_varified = '$varify' WHERE id = $id;";
		pg_query($db->getRefference(),$update_query);
		$update_query = "UPDATE problem SET is_solved = '$solve' WHERE id = $id;";
		pg_query($db->getRefference(),$update_query);
		header('Refresh: 0; URL = problemlist.php');
	}
	$map = array('t' => 'True', 'f' => 'False');
 ?>
<?php endblock() ?>


<div class="d-flex justify-content-center">
	<div class="col-md-8">
	<div class="list-group">
		<h5 class="list-group-item list-group-item-dark">Problem Information</h5>
		<h5 class="list-group-item">ID: <?php echo $id; ?></h5>
		<h5 class="list-group-item list-group-item-primary">Vefication Status: <?php echo $map[$is_varified]; ?></h5>
		<h5 class="list-group-item list-group-item-primary">Solve Status: <?php echo $map[$is_solved]; ?></h5>
	</div>
		<div></div>
		<form class="form-inline " method="POST">
					<div class="form-group list-group">
						<label for="varify"> IS_Verified : </label>
						<select value="Get Selected Values" class="form-control" name="varify">
								<option value="t">True</option>
								<option value="f">False</option>
						</select>
					</div>
					<div class="form-group list-group">
						<label for="solve"> IS_Solved : </label>
						<select value="Get Selected Values" class="form-control" name="solve">
								<option value="f">False</option>
								<option value="t">True</option>
						</select>
					</div>
					<button class="btn btn-primary">Update</button>
				</form>

</div>
</div>