<?php include 'base.php' ?>
<?php startblock('header') ?>
	<title>Problems</title>
<?php endblock() ?>
<?php startblock('container') ?>
<?php 
	$failed = false;
	$school_id = $_SESSION['schoolid'];
	$db = DB::connection();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$catagory = $_POST['catagory'];
		$reason = $_POST['reason'];
		
		$res = pg_exec($db->getRefference(),
			"CALL addProblem(
				$school_id::int,
				'$catagory'::varchar,
				'$reason'::varchar
			);");
		if($res){

		}else {
			$failed = true;
		}
	}
	$problemList = [];
	$res = pg_query($db->getRefference(),
			"SELECT id,catagory,details,issue_date,is_varified FROM problem WHERE school_id=$school_id;" 
			);
	while($data = pg_fetch_object($res)){
		array_push($problemList, $data);
	}
	$map = array('t' => 'Approved', 'f'=>'Not Approved Yet');
 ?>

 <?php endblock() ?>
 <div class="d-flex justify-content-center">
	<div class="col-md-8">
		<div class="list-group-item mt-4">
			<p class="lead text-center mb-4">Add New Problem</p>
			<form method="POST">
				<?php if($failed == true): ?>
					<p class="alert alert-danger">insertion failed</p>
				<?php endif; ?>

				<div class="form-group">
					<label for="catagory">Catagory:</label>
					<select class="form-control" name="catagory" id="catagory" value="Get Selected Values" required>
	     			 	<option value="Normal">Normal</option>
	     			 	<option value="Minor">Minor</option>
	     			 	<option value="Major">Major</option>
	    			</select>
				</div>
				<div class="form-group">
					<label for="reason">Details:</label>
					<textarea class="form-control" type="text" id="reason" name="reason" required></textarea>
				</div>

				<button class="btn btn-success mt-3">Insert</button>
			</form>
		</div>
		<br><br><br>
	</div>
</div>

<div class="d-flex justify-content-center">
	<div class="col-md-8">
		<br>
		<h4 class="lead text-center">Problems</h4>
		<table class="table table-bordered bg-dark text-white">
			<thead>
				<th>ID</th><th>Date</th><th>Category</th><th>Details</th><th>Approved Status</th>

			</thead>
			<tbody>
				<?php for($i=0; $i<count($problemList); $i++): ?>
					<tr>
						<td><a href="#"><?php echo $problemList[$i]->id; ?></a></td>
						<td><?php echo $problemList[$i]->issue_date; ?></td>
						<td><?php echo $problemList[$i]->catagory; ?></td>
						<td><?php echo $problemList[$i]->details; ?></td>
						<td><?php echo $map[$problemList[$i]->is_varified]; ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>