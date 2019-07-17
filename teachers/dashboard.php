<?php include 'base.php' ?>

<?php startblock('header') ?>
	<title>DashBoard</title>
<?php endblock() ?>

<?php startblock('container') ?>
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
<?php endblock() ?>

<div class="d-flex justify-content-center">
	<p4><?php echo $percentageA; ?></p4><br>
	<p4><?php echo $percentageB; ?></p4><br>
	<p4><?php echo $percentageC; ?></p4><br>
	<?php if($totalStudent==0): ?>
		<p>No student available.</p>
	<?php else : ?>
	<div class="container">
		<canvas id ="performence"></canvas>
		<br><br>
		<canvas id ="problem"></canvas>
	</div>
<?php endif; ?>

<script>
	var performenceChart = document.getElementById("performence");
	var problemChart = document.getElementById("problem");
	Chart.defaults.global.defaultFontFamily = "Lato";
	Chart.defaults.global.defaultFontSize = 18;
	var grade = {
		label : 'Grade in % of student',
		data: [<?php echo $percentageA; ?>,<?php echo $percentageB; ?>,<?php echo $percentageC; ?>],
		backgroundColor : 'rgba(99, 132, 0, 0.6)',
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
					  type: 'bar',
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


</script>
</div>
