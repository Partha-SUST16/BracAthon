<?php include 'base.php' ?>

<?php startblock('header') ?>
	<title>DashBoard</title>
<?php endblock() ?>


	<?php 
		$userid = $_SESSION['userid'];
		$school_id = $_SESSION['schoolid'];
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
		$query = "SELECT COUNT(id) FROM student WHERE gender='F';";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$female = $row['0'];
		$query = "SELECT COUNT(id) FROM student WHERE gender='M';";
		$res = pg_query($db->getRefference(),$query);
		$row = pg_fetch_row($res);
		$male = $row['0'];
		$total = $male+$female;
		$male = ($male/$total)*100.0;
		$female = ($female/$total)*100.0;
		$percentageA = (($gradeA)/$totalStudent)*100.0;
		$percentageB = (($gradeB)/$totalStudent)*100.0;
		$percentageC = (($gradeC)/$totalStudent)*100.0;

		$res = pg_query($db->getRefference(),"SELECT COUNT(id) FROM problem WHERE school_id = $school_id AND is_solved = false GROUP BY catagory;");
		$row2 = pg_fetch_all_columns($res);
		$totalProblem = $row2['0']+$row2['1']+$row2['2'];
		$problemNormal = ($row2['2']/$totalProblem )* 100.0;
		$problemMajor = ($row2['0']/$totalProblem)*100.0;
		$problemMinor = ($row2['1']/$totalProblem)*100.0;


	 ?>


<div class="d-flex justify-content-center">
	<h4><?php echo $female; ?></h4>
	<?php if($totalStudent==0): ?>
		<p>No student available.</p>
	<?php else : ?>
	<div class="container col-md-5">
		<canvas id ="performence"></canvas>
		<br><br>
		<canvas id ="problem"></canvas>
		<br><br>
		<canvas id ="attendence"></canvas>
		<br><br>
		<canvas id = "maleFemale" height="60px" width="80px"></canvas>
	</div>
<?php endif; ?>

<script>
	var performenceChart = document.getElementById("performence");
	var problemChart = document.getElementById("problem");
	var attendenceChart = document.getElementById("attendence");
	var maleFemale = document.getElementById("ratio");
	Chart.defaults.global.defaultFontFamily = "Lato";
	Chart.defaults.global.defaultFontSize = 18;
	var grade = {
		label : 'Grade in % of student',
		data: [<?php echo $percentageA; ?>,<?php echo $percentageB; ?>,<?php echo $percentageC; ?>],
		backgroundColor : [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)'
          ],
		borderWidth: 0,
  		yAxisID: "y-axis-percentage"
	};
	var percentage = {
		labels : ["A","B","C"],
		datasets:[grade]
	}
	var chartOptions = {
		  scales: {
		    xAxes: [{
		      barPercentage: .5,
		      categoryPercentage: 0.6
		    }],
		    yAxes: [{
		      id: "y-axis-percentage"
		    }]
		  }
		};
	var barChart =  new Chart(performenceChart, {
					  type: 'doughnut',
					  data: percentage,
					  options : chartOptions
					});
	var problems = {
		label : 'Problem(NOT Solved) by %',
		data: [<?php echo $problemNormal; ?>,<?php echo $problemMinor; ?>,<?php echo $problemMajor; ?>],
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

	/////////////////
	var da = {
		label : 'Male Female Ratio',
		data: [<?php echo $male; ?>,<?php echo $female; ?>],
		backgroundColor : 
            [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)']
          ,
		borderWidth: 0,
  		yAxisID: "y-axis-male"
	};
	var ma = {
		labels : ["Male","Female"],
		datasets:[da]
	}
	var char = {
		  scales: {
		    xAxes: [{
		      barPercentage: .5,
		      categoryPercentage: 0.6
		    }],
		    yAxes: [{
		      id: "y-axis-male"
		    }]
		  }
		};
	var pie =  new Chart(maleFemale, {
					  type: 'pie',
					  data: ma,
					  options : char
					});


</script>
</div>
