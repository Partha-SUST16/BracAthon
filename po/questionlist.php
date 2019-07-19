<?php include 'base.php'; ?>
<?php startblock('header') ?>
	<title>Routine Question</title>
	<script type="text/javascript">
		function addToCart( grade){
			if(grade>=3)alert('Grade A');
			else if (grade>=2)alart('Grade B');
			else alart('Grade C');
			$.get("questionlist.php");
			return false;
		}
	</script>
<?php endblock() ?>
<?php startblock('container') ?>
<?php 
	$db = DB::connection();
	$user_id = $_SESSION['userid'];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$attendence = $_POST['attendence'];
		$performence = $_POST['performence'];
		$academic = $_POST['academic'];
		$environment = $_POST['environment'];
		$schoolName = $_POST['school'];
		$map  = array('Yes' => 1,'No'=>2 );
		$sum = $map[$attendence]+$map[$performence]+$map[$academic]+$map[$academic]+$map[$environment];
		if($sum>=3)$grade = 'A';
		else if($sum>=2)$grade='B';
		else $grade = 'C';
		$query = "SELECT id FROM school WHERE name = '$schoolName';";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$school_id = $row['0'];
		$query = "SELECT id,grade FROM question WHERE school_id=$school_id AND po_id = $user_id;";
		$res = pg_query($db->getRefference,$query);
		//try {
		/*	$obj = pg_fetch_object($res);
			$id = $obj->id;
			$query = "UPDATE question SET grade = '$grade' WHERE id=$id;";
			
			$res = pg_query($db->getRefference(),$query);*/
		//} catch (Exception $e) {
			/*$query = "INSERT INTO question(po_id,school_id,grade) VALUES ($user_id,$school_id,'$grade');";
			$res = pg_query($db->getRefference(),$query);*/	
		//}
			
		
	}
 ?>
<?php endblock() ?>

<div class="d-flex justify-content-center">
	<div class = "col-md-8">
		<h5 class="list-group-item list-group-item-dark">Routine Question</h5><br>
		<div class="list-group">
			<form class="form-inline" method="POST">
				<label>School Name : </label>
			<input type="text" class="form-control mb-2" name="school" required>
				<div class="d-flex justify-content-center">
				<div class="from-group list-group">
					<h5 class="list-group-item">1. Are students attendence upto the mark?</h5>
					<select value="Get Selected Values" class="form-control" name="attendence">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
						</select>

				</div>
				
				<div class="from-group list-group">
					<h5 class="list-group-item">2. Are Co-curricular activities of students satisfied ?</h5>
					<select value="Get Selected Values" class="form-control" name="performence">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
						</select>
				</div>
				<div class="from-group list-group">
					<h5 class="list-group-item">3. Are students good in academic subject?</h5>					<select value="Get Selected Values" class="form-control" name="academic">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
						</select>
				</div>
				
				<div class="from-group list-group">
					<h5 class="list-group-item">4. Is environment of school is good?</h5>
					<select value="Get Selected Values" class="form-control" name="environment">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
						</select>
				</div>
				<div class="d-flex justify-content-center">
					<button class="btn btn-primary" onclick="addToCart(<?php echo $sum ?>)">Submit</button>
				</div>
				</div>

				<br>
				
			</form>
		</div>	
	</div>
</div>