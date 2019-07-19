 <?php 
 	include 'base.php';
 	$schoolid = $_GET['school'];
	$studentid = $_GET['id'];
	$result = [];
	$db = DB::connection();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$exam = $_POST['exam'];
		//$studentid = $_POST['studentid'];
		$subject = $_POST['subject'];
		$grade = $_POST['grade'];

		$map = array('Bangla' => 1, 'English'=> 2);
		$map2 = array('Monthly-1' => 1,'Monthly-2'=>2);
		
		$res=pg_exec($db->getRefference(),
			"CALL givePerformence(
				$schoolid::int,
				$map2[$exam]::int,
				$studentid::int,
				$map[$subject]::int,
				'$grade'::varchar
			);");
		if($res){
			$result['error'] = false;
		}else {
			$result['error'] = true;
		}
	}
	echo json_encode($result);