<?php include 'base.php'; session_start();?>
<?php 
		if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$userid = (int)$_POST['userid'];
		$school_id =(int) $_POST['schoolid'];
		$db = DB::connection();
		$res = pg_query($db->getRefference(),"SELECT COUNT(student_id) AS id FROM performence WHERE school_id=$school_id GROUP BY grade;");
		$arr = array();
		while($data = pg_fetch_object($res))
		{
			array_push($arr,$data);
		}
		$gradeA =  $arr[0]->id;
			$gradeB =  $arr[1]->id;
			$gradeC =  $arr[2]->id;
		$totalStudent = $arr[1]->id+$arr[0]->id+$arr[2]->id;
		/*$col = pg_fetch_all_columns($res, 0);
		$gradeA =  pg_fetch_all_columns($res, 0);
			$gradeB =  pg_fetch_all_columns($res, 1);
			$gradeC =  pg_fetch_all_columns($res, 2);
			$totalStudent = $col['0']+$col['1']+$col['2'];*/
		$res = pg_query($db->getRefference(),"SELECT student FROM getallSchools() WHERE id = $school_id;");
		$row = pg_fetch_row($res);
		

		$percentageA = (($gradeA)/$totalStudent)*100.0;
		$percentageB = (($gradeB)/$totalStudent)*100.0;
		$percentageC = (($gradeC)/$totalStudent)*100.0;

		$res = pg_query($db->getRefference(),"SELECT COUNT(id) FROM problem WHERE school_id = $school_id AND is_solved = false GROUP BY catagory;");
		$row2 = pg_fetch_all_columns($res);
		$totalProblem = $row2['0']+$row2['1']+$row2['2'];
		$problemNormal = ($row2['2']/$totalProblem )* 100.0;
		$problemMajor = ($row2['0']/$totalProblem)*100.0;
		$problemMinor = ($row2['1']/$totalProblem)*100.0;
		$result = array();
		$result['error'] = false;
		$result['percentageA'] =$percentageA;
		$result['percentageB']=$percentageB;
		$result['percentageC'] = $percentageC;
		$result['problemNormal'] = $problemNormal;
		$result['problemMinor'] = $problemMinor;
		$result['problemMajor'] = $problemMajor;
		} 
 else $result['error'] = true;
		
echo json_encode($result);
