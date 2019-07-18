<?php include 'base.php' ?>

<?php startblock('header') ?>
	<title>DashBoard</title>
<?php endblock() ?>


	<?php 
		$userid = $_GET['id'];
		$db = DB::connection();

		$totalStudent = 0;
		$gradeA = 0;
		$gradeB = 0;
		$gradeC = 0;
		$totalProblem = 0;
		$normalProblem = 0;
		$minorProblem = 0;
		$majorProblem = 0;

		$teacherList = [];
		$studentName = [];
		$attendenceList = array();
		$query = "SELECT teacher_id FROM poteacher WHERE po_id = $userid;";
		$res = pg_query($db->getRefference(),$query);
		while($data = pg_fetch_object($res)){
			array_push($teacherList, $data);
		}
		for($i=0;$i<count($teacherList);$i++){
		//	print_r($teacherList[$i]);
			$teacher_id = $teacherList[$i]->teacher_id;
			$res = pg_exec($db->getRefference(),"SELECT school_id FROM teacher WHERE id = $teacher_id;");
			$row = pg_fetch_row($res);
			$school_id = $row['0'];
			$res = pg_query($db->getRefference(),"SELECT student FROM getallSchools() WHERE id = $school_id;");
			$row = pg_fetch_row($res);
			//$row['0'];
			$res = pg_query($db->getRefference(),"SELECT COUNT(student_id) FROM performence WHERE school_id=$school_id GROUP BY grade;");
			$col = pg_fetch_all_columns($res);
			$gradeA = $gradeA + $col['0'];
			$gradeB = $gradeB + $col['1'];
			$gradeC = $gradeC + $col['2'];
			$totalStudent =$totalStudent+$col['0']+$col['1']+$col['2'];

			//attendence
			$studentList = [];
			$query = "SELECT id,name FROM student WHERE school_id = $school_id;";
			
			$res = pg_query($db->getRefference(),$query);
			while($data = pg_fetch_object($res)){
				array_push($studentList, $data);
			}
			
			for($i=0;$i<COUNT($studentList);$i++){
				$studentName[$i] = $studentList[$i]->name;
			}
		
			
			for($i=0;$i<count($studentList);$i++){
				$student_id = $studentList[$i]->id;
				$query = "SELECT status FROM attendence WHERE school_id = $school_id AND student_id = $student_id AND status  = 1;";
				$res = pg_query($db->getRefference(),$query);
				$col = pg_fetch_all_columns($res);
				$dummy =COUNT($col);
				array_push($attendenceList,$dummy);
			}



			//problem
			$res = pg_query($db->getRefference(),"SELECT COUNT(id) FROM problem WHERE school_id = $school_id AND is_solved = false GROUP BY catagory;");
			$row2 = pg_fetch_all_columns($res);
			$totalProblem = $totalProblem+$row2['0']+$row2['1']+$row2['2'];
			$normalProblem = $normalProblem+$row2['2'];
			$minorProblem = $minorProblem + $row2['1'];
			$majorProblem  = $majorProblem + $row2['0'];
		}
		$normalProblem = ($normalProblem/$totalProblem)*100.0;
		$minorProblem = ($minorProblem/$totalProblem)*100.0;
		$majorProblem = ($majorProblem/$totalProblem)*100.0;
		//print_r($gradeA)
		$gradeA = ($gradeA/$totalStudent)*100.0;
		//$gradeA = $gradeA-10;
		/*print_r($gradeA+"\n");
		print_r($gradeB+"\n");*/
		$gradeB = ($gradeB/$totalStudent)*100.0;
		//$gradeB = $gradeB+0.0001;

		/*print_r($gradeB+"\n");
		print_r($gradeC+"\n");*/
		$gradeC = ($gradeC/$totalStudent)*100.0;
		//$gradeC = $gradeC+0.0001;
		//print_r($gradeC+"\n");

	 ?>


<div class="d-flex justify-content-center">
	<p>DashBoard of PO</p>
	<!-- <h4><?php echo $totalStudent; ?></h4><br> -->
	<!-- <h4><?php echo $gradeC; ?></h4><br>
	<h4><?php echo $gradeA; ?></h4><br>
	<h4><?php echo $totalStudent ?></h4> -->
	<div class="container">
		<canvas id ="performence"></canvas>
		<br><br>
		<canvas id ="problem"></canvas>
				<br><br>
		<canvas id ="attendence"></canvas>
	</div>
	<script>
		var performenceChart = document.getElementById("performence").getContext("2d");
		var problemChart = document.getElementById("problem");
		var attendenceChart = document.getElementById("attendence");
		Chart.defaults.global.defaultFontFamily = "Lato";
		Chart.defaults.global.defaultFontSize = 18;
		var problems = {
			label : 'Problem(NOT Solved) by %',
			data: [<?php echo $normalProblem; ?>,<?php echo $minorProblem; ?>,<?php echo $majorProblem; ?>],
			backgroundColor : ['rgba(255, 99, 132, 0.6)',
	            'rgba(54, 162, 235, 0.6)',
	            'rgba(255, 206, 86, 0.6)'],
			borderWidth: 1,
	  		yAxisID: "y-axis-problem"
		};
		var percentage = {
			labels : ["Normal","Minor","Major"],
			datasets:[problems]
		}
		var chartOp = {
			  scales: {
			    xAxes: [{
			      barPercentage: .5,
			      categoryPercentage: 0.6
			    }],
			    yAxes: [{
			      id: "y-axis-problem"
			    }]
			  }
			};
		var bara =  new Chart(problemChart, {
						  type: 'bar',
						  data: percentage,
						  options : chartOp
						});

		////////////////////////
		var problems_ = {
			label : 'Performence by %',
			data: [ <?php echo $gradeA; ?>,<?php echo $gradeB; ?>,<?php echo $gradeC; ?>],
			backgroundColor : ['rgba(255, 99, 132, 0.6)',
	            'rgba(54, 162, 235, 0.6)',
	            'rgba(255, 206, 86, 0.6)'],
			borderWidth: 1,
	  		yAxisID: "y-axis-percentage"
		};
		var percentage_ = {
			labels : ["A","B","C"],
			datasets:[problems_]
		}
		var chartOp_ = {
			  scales: {
			    xAxes: [{
			      barPercentage: 0.6,
			      categoryPercentage: .6
			    }],
			    yAxes: [{
			      id: "y-axis-percentage"
			    }]
			  }
			};
		var bara_ =  new Chart(performenceChart, {
						  type: 'bar',
						  data: percentage_,
						  options : chartOp_
						});

		var problems3 = {
		label : 'Attendence',
		data: 
<?php echo json_encode($attendenceList); ?>,
		backgroundColor : 
            'rgba(255, 206, 86, 0.6)',
		borderWidth: 1,
  		yAxisID: "y-axis-attendence"
	};
	var percentage3 = {
		labels :<?php echo json_encode($studentName); ?>,
		datasets:[problems3]
	}

	var chartOpt = {
		  scales: {
		    xAxes: [{
		      barPercentage: .5,
		      categoryPercentage: 0.6
		    }],
		    yAxes: [{
		      id: "y-axis-attendence"
		    }]
		  }
		};
	var kara =  new Chart(attendenceChart, {
					  type: 'bar',
					  data: percentage3,
					  options : chartOpt
					});
	</script>
</div>
