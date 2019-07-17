<?php include 'base.php' ?>

<?php 
	$failed = false;
	$schoolid = $_SESSION['schoolid'];
	$userid = $_SESSION['userid'];
	$db = DB::connection();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$examid = $_POST['examid'];
		$studentid = $_POST['studentid'];
		$subjectid = $_POST['subjectid'];
		$grade = $_POST['grade'];

		
		$res=pg_exec($db->getRefference(),
			"CALL givePerformence(
				$schoolid::int,
				$examid::int,
				$studentid::int,
				$subjectid::int,
				'$grade'::varchar
			);");
		if($res){

		}else {
			$failed = true;
		}
	}
	$res = pg_exec($db->getRefference(),"SELECT id,name FROM subject;");
			$subjectList=[];
			while($data = pg_fetch_object($res)){
				array_push($subjectList, $data);
			}
			$res = pg_exec($db->getRefference(),"SELECT id,name FROM exam;");
			$examList = [];
			while($data = pg_fetch_object($res)){
				array_push($examList, $data);
			}

 ?>

<div class="d-flex justify-content-center">
	<div class="col-md-8">
		<div class="list-group-item mt-4">
			<p class="lead text-center mb-4">Perfromence Report</p>
			<form method="POST">
				<?php if($failed == true): ?>
					<p class="alert alert-danger">insertion failed</p>
				<?php endif; ?>
				<div class="form-group">
					<label for="studentid">Student ID:</label>
					<input type="text" name="studentid" class="form-control" id ="studentid" placeholder="StudentID" required>
				</div>

				<div class="form-group">
					<label for="examid">Exam ID:</label>
					<select class="form-control" id="examid" name="examid" required>
					<?php if(count($examList)): ?>
					<?php for($i=0; $i<count($examList); $i++): ?>
	     			 	<option value="<?php echo $examList[$i]->id; ?>"><?php echo $examList[$i]->name; ?></option>
	      			<?php endfor; ?>
	      			<?php else: ?>
	      				<option><?php echo "No Exam Available"; ?></option>
	      			<?php endif; ?>
	    			</select>
				</div>

				<div class="form-group">
					<label for="subjectid">Subject Name</label>
					<select class="form-control" id= "subjectid" name="subjectid" required>
					<?php for($i=0; $i<count($subjectList); $i++): ?>
						<option value="<?php echo $subjectList[$i]->id ?>"><?php echo $subjectList[$i]->name; ?></option>
					<?php endfor; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="grade">Grade:</label>
					<input type="numeric" name="grade" id="grade" class="form-control" placeholder="Grade" required>
				</div>

				<button class="btn btn-success mt-3">Insert</button>
			</form>
		</div>
		<br><br><br>
	</div>
</div>

