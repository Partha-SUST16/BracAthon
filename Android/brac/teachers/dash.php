<?php 
	include 'base.php';
	$result = [];
	$userid = $_GET['id'];
	$school_id = $_GET['school'];
	$db = DB::connection();
		$res = pg_query($db->getRefference(),"SELECT COUNT(student_id) FROM performence WHERE school_id=$school_id GROUP BY grade;");
			$col = pg_fetch_all_columns($res);
			$gradeA =  $col['0'];
			$gradeB =  $col['1'];
			$gradeC =  $col['2'];
			$totalStudent = $col['0']+$col['1']+$col['2'];
		$res = pg_query($db->getRefference(),"SELECT student FROM getallSchools() WHERE id = $school_id;");
		$row = pg_fetch_row($res);

		$studentList = [];
		$query = "SELECT id,name FROM student WHERE school_id = $school_id;";
		
		$res = pg_query($db->getRefference(),$query);
		while($data = pg_fetch_object($res)){
			array_push($studentList, $data);
		}
		$studentName = [];
		for($i=0;$i<COUNT($studentList);$i++){
			$studentName[$i] = $studentList[$i]->name;
		}
	
		$attendenceList = array();
		for($i=0;$i<count($studentList);$i++){
			$student_id = $studentList[$i]->id;
			$query = "SELECT status FROM attendence WHERE school_id = $school_id AND student_id = $student_id AND status  = 1;";
			$res = pg_query($db->getRefference(),$query);
			$col = pg_fetch_all_columns($res);
			$dummy =COUNT($col);
			array_push($attendenceList,$dummy);
		}	

		$percentageA = (($gradeA)/$totalStudent)*100.0;
		$percentageB = (($gradeB)/$totalStudent)*100.0;
		$percentageC = (($gradeC)/$totalStudent)*100.0;

		$res = pg_query($db->getRefference(),"SELECT COUNT(id) FROM problem WHERE school_id = $school_id AND is_solved = false GROUP BY catagory;");
		$row2 = pg_fetch_all_columns($res);
		$totalProblem = $row2['0']+$row2['1']+$row2['2'];
		$problemNormal = ($row2['2']/$totalProblem )* 100.0;
		$problemMajor = ($row2['0']/$totalProblem)*100.0;
		$problemMinor = ($row2['1']/$totalProblem)*100.0;
	$result['major'] = $problemMajor;
	$result['minor'] = $problemMinor;
	$result['normal'] = $problemNormal;
	$result['a'] = $percentageA;
	$result['b'] = $percentageB;
	$result['c'] = $percentageC;
	$result['student'] = $studentName;
	$result['attendence'] =$attendenceList;
	$result['error'] = false;
	echo json_encode($result);
