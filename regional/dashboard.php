<?php include 'base.php' ?>

<?php startblock('header') ?>
	<title>DashBoard</title>
	<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Overall Performence of all school"
	},
	axisX: {
		valueFormatString: "DD MMM,YY"
	},
	axisY: {
		title: "Parameter",
		includeZero: false,
		suffix: ""
	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [{
		name: "Attendence Record",
		type: "spline",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2017,1,24), y: 31 },
			{ x: new Date(2017,2,25), y: 31 },
			{ x: new Date(2017,3,26), y: 29 },
			{ x: new Date(2017,4,27), y: 29 },
			{ x: new Date(2017,5,28), y: 31 },
			{ x: new Date(2017,6,29), y: 30 },
			{ x: new Date(2017,7,30), y: 29 }
		]
	},
	{
		name: "Performence Record",
		type: "spline",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2017,1,24), y: 20 },
			{ x: new Date(2017,2,25), y: 20 },
			{ x: new Date(2017,3,26), y: 25 },
			{ x: new Date(2017,4,27), y: 25 },
			{ x: new Date(2017,5,28), y: 25 },
			{ x: new Date(2017,6,29), y: 25 },
			{ x: new Date(2017,7,30), y: 25 }
		]
	},
	{
		name: "Problem Solved",
		type: "spline",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2017,1,24), y: 22 },
			{ x: new Date(2017,2,25), y: 19 },
			{ x: new Date(2017,3,26), y: 23 },
			{ x: new Date(2017,4,27), y: 24 },
			{ x: new Date(2017,5,28), y: 24 },
			{ x: new Date(2017,6,29), y: 23 },
			{ x: new Date(2017,7,30), y: 23 }
		]
	},
	{
		name: "Facility provided to Unprivileged",
		type: "spline",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2017,1,24), y: 5 },
			{ x: new Date(2017,2,25), y: 6 },
			{ x: new Date(2017,3,26), y: 4 },
			{ x: new Date(2017,4,27), y: 7 },
			{ x: new Date(2017,5,28), y: 6 },
			{ x: new Date(2017,6,29), y: 10 },
			{ x: new Date(2017,7,30), y: 2 }
		]
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
<?php endblock() ?>
<?php startblock('container') ?>
<?php 
	$r_id = $_SESSION['userid'];
	$db = DB::connection();
	$totalStudent = 0;
	$gradeA = 0;
	$gradeB = 0;
	$gradeC = 0;
	$totalProblem = 0;
	$normalProblem = 0;
	$minorProblem = 0;
	$majorProblem = 0;
	$branchList = [];
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
			$userid = $poList[$j]->po_id;
			$teacherList = [];
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

				//problem
				$res = pg_query($db->getRefference(),"SELECT COUNT(id) FROM problem WHERE school_id = $school_id AND is_solved = false GROUP BY catagory;");
				$row2 = pg_fetch_all_columns($res);
				$totalProblem = $totalProblem+$row2['0']+$row2['1']+$row2['2'];
				$normalProblem = $normalProblem+$row2['2'];
				$minorProblem = $minorProblem + $row2['1'];
				$majorProblem  = $majorProblem + $row2['0'];
			}	
		}
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
 ?>
 <?php endblock() ?>

 <div class="d-flex justify-content-center">
	<!-- <h4><?php echo $totalStudent; ?></h4><br> -->
	<!-- <h4><?php echo $gradeC; ?></h4><br>
	<h4><?php echo $gradeA; ?></h4><br>
	<h4><?php echo $totalStudent ?></h4> -->
	<div class="container col-md-5">
		<div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
		<br><br>
		<canvas id ="performence"></canvas>
		<br><br>
		<canvas id ="problem"></canvas>
		<br><br>
		<canvas id ="attendence"></canvas>
		<br><br>
		<canvas id = "maleFemale" height="60px" width="80px"></canvas>
		<br><br>
		<canvas id ="ethnic"></canvas>
		<br><br>
		<canvas id = "schoolGrading"></canvas>
		<br><br>
		
		<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
	</div>
	<script>
		var performenceChart = document.getElementById("performence").getContext("2d");
		var problemChart = document.getElementById("problem");
		var maleFemale = document.getElementById("maleFemale");
		var ethnic = document.getElementById("ethnic");
		var schoolGrade = document.getElementById("schoolGrading");

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
		var da = {
		label : 'Male Female Ratio',
		data: [40,60],
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

    ////////////////////////////////////
    /////////////////////
	var da_ = {
		label : 'facilate education to ethnic and disabled people',
		data: [40,60,20,50,69,10,60,70,50,10,90,25],
		backgroundColor : 
            [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(139, 173, 88, 1)',
            'rgba(173, 88, 88, 1)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(139, 173, 88, 1)',
            'rgba(173, 88, 88, 1)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(139, 173, 88, 1)',
            'rgba(173, 88, 88, 1)']
          ,
		borderWidth: 0,
  		yAxisID: "y-axis-male"
	};
	var da = {
		label : 'Schrool grading ',
		data: [50,20,37,48,80],
		backgroundColor : 
            [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)']
          ,
		borderWidth: 0,
  		yAxisID: "y-axis-male"
	};
	var ma = {
		labels : ["kuril","bosundhora","kamarpara","guari","medinipur"],
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
	var pie =  new Chart(schoolGrade, {
					  type: 'bar',
					  data: ma,
					  options : char
					});

	</script>
</div>