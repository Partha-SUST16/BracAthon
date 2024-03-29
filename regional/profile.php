<?php 
	//session_start(); 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>Profile - Brac</title>
<?php endblock() ?>

<?php 
	$id = $_SESSION['userid'];
	$db = DB::connection();
	$res = pg_query($db->getRefference(),"SELECT name,phone,gender,address FROM regional WHERE id=$id;");
	$user = pg_fetch_object($res);

	$poList = [];
	$res = pg_query($db->getRefference(),
		"SELECT divbranch.branch_id AS id,branch.name AS Name
		FROM divbranch
		LEFT JOIN branch ON divbranch.branch_id = branch.id 
		WHERE divbranch.regional_id = $id;");
	while($data = pg_fetch_object($res)){
		array_push($poList, $data);
	}
 ?>
 <div class="d-flex justify-content-center">
 	<div class="col-md-6 mt-5">
 		<div class="list-group">
 			<h6 class="list-group-item text-center text-white bg-dark">Profile</h6>
 			<h4 class="lead list-group-item">Name: <?php echo $user->name; ?> </h4>
 			<h4 class="lead list-group-item">Phone: <?php echo $user->phone; ?> </h4>
 			<h4 class="lead list-group-item">Address: <?php echo $user->address; ?> </h4>
 		</div>
 	</div>
 </div>

 <div class="d-flex justify-content-center">
	<div class="col-md-6 mt-4">
		<br>
		<h4 class="lead text-center">List of BranchManager</h4>
		<table class="table table-bordered bg-dark text-white">
			<thead>
				<th>ID</th><th>Name</th>
			</thead>
			<tbody>
				<?php for($i=0; $i<count($poList); $i++): ?>
					<tr>
						<td><a href="branchdashboard.php?id=<?php echo $poList[$i]->id; ?>"><?php echo $poList[$i]->id; ?></a></td>
						<td><?php echo $poList[$i]->name; ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>