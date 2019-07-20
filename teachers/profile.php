<?php 
	include 'base.php';
?>
<?php startblock('header') ?>
	<title>Profile - Brac</title>
<?php endblock() ?>

<?php 
	$id = $_SESSION['userid'];
	$school  =$_SESSION['schoolid'];
	$db = DB::connection();
	$res = pg_query($db->getRefference(),"SELECT name,phone,gender,address FROM teacher where id = $id;");
	$user = pg_fetch_object($res);

	$school_name = pg_query($db->getRefference(),
					"SELECT name from school where id = $school;");
	$row = pg_fetch_row($school_name);
	$name = $row['0'];

	$studentList = [];
	$res = pg_query($db->getRefference(),
			"SELECT name,id,gender FROM student WHERE school_id = $school;");
	while($data = pg_fetch_object($res)){
		array_push($studentList, $data);
	}
 ?>

  <div class="d-flex justify-content-center">
 	<div class="col-md-6 mt-5">
 		<div class="list-group">
 			<h6 class="list-group-item text-center text-white bg-dark">Profile</h6>
 			<h4 class="lead list-group-item">Name: <?php echo $user->name; ?> </h4>
 			<h4 class="lead list-group-item">Phone: <?php echo $user->phone; ?> </h4>
 			<h4 class="lead list-group-item">Address: <?php echo $user->address; ?> </h4>
 			<h4 class="lead list-group-item">School: <?php echo $name; ?> </h4>
 		</div>
 	</div>
 </div>

 <div class="d-flex justify-content-center">
	<div class="col-md-6 mt-4">
		<br>
		<h4 class="lead text-center">List of Students</h4>
		<table class="table table-bordered bg-dark text-white">
			<thead>
				<th>ID</th><th>Name</th><th>Gender</th>
			</thead>
			<tbody>
				<?php for($i=0; $i<count($studentList); $i++): ?>
					<tr>
						<td><a href="#"><?php echo $studentList[$i]->id; ?></a></td>
						<td><?php echo $studentList[$i]->name; ?></td>
						<td><?php echo $studentList[$i]->gender; ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>
