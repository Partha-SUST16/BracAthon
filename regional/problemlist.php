<?php include 'base.php'; ?>

<?php startblock('header') ?>
	<title> Problem</title>
<?php endblock() ?>

<?php 
	$r_id = $_SESSION['userid'];
	$problemList = [];
	$db = DB::connection();
	$branchList=[];
	$query = "SELECT branch_id FROM divbranch WHERE regional_id = $r_id;";
	$res = pg_query($db->getRefference(),$query);
	while($data = pg_fetch_object($res)){
		array_push($branchList, $data);
	}
	for($k = 0;$k<count($branchList);$k++){
		$branch_id = $branchList[$k]->branch_id;
		$poList = [];
		$query = "SELECT po_id FROM branchpo WHERE branch_id = $branch_id;";
		$res = pg_query($db->getRefference(),$query);
			while($data = pg_fetch_object($res)){
				array_push($poList, $data);
			}
		for($j = 0;$j<count($poList);$j++){
			$user_id = $poList[$j]->po_id;
			//print_r($user_id);
			$teacherList = [];
			$query = "SELECT teacher_id FROM poteacher WHERE po_id = $user_id;";
			$res = pg_query($db->getRefference(),$query);
			while($data = pg_fetch_object($res)){
				array_push($teacherList, $data);
			}
			for($i=0;$i<count($teacherList);$i++){
				$teacher_id = $teacherList[$i]->teacher_id;
				$res = pg_exec($db->getRefference(),"SELECT school_id FROM teacher WHERE id = $teacher_id;");
				$row = pg_fetch_row($res);
				$school_id = $row['0'];
				$res = pg_query($db->getRefference(),
					"SELECT id,catagory,details,issue_date,is_varified,school_id,is_solved FROM problem WHERE school_id=$school_id;" 
					);
				while($data = pg_fetch_object($res)){
					array_push($problemList, $data);
				}
			}		
		}	
	}
	$map = array('t' => 'Approved', 'f'=>'Not Approved Yet');
	$map2 = array('t' => 'Solved', 'f'=>'Not Solved Yet');
 ?>
 <div class="d-flex justify-content-center">
	<div class="col-md-8">
		<br>
		<h4 class="lead text-center">Pending Problems</h4>
		<table class="table table-bordered bg-dark text-white">
			<thead>
				<th>ProblemID</th><th>SchoolID</th><th>Date</th><th>Category</th><th>Details</th><th>Approved Status</th><th>Solve Status</th>

			</thead>
			<tbody>
				<?php for($i=0; $i<count($problemList); $i++): ?>
					<tr>
						<td><a href="updateproblem.php?id=<?php echo $problemList[$i]->id ?>"><?php echo $problemList[$i]->id; ?></a></td>
						<td><?php echo $problemList[$i]->school_id; ?></td>
						<td><?php echo $problemList[$i]->issue_date; ?></td>
						<td><?php echo $problemList[$i]->catagory; ?></td>
						<td><?php echo $problemList[$i]->details; ?></td>
						<td><?php echo $map[$problemList[$i]->is_varified]; ?></td>
						<td><?php echo $map2[$problemList[$i]->is_solved]; ?></td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>