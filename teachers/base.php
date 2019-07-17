<?php require_once '../static/lib/php/template.php' ?>
<?php require_once '../db/database.php'; ?>
<?php 

// start session
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../static/lib/css/bootstrap.min.css">
	<script type="text/javascript" src="../static/lib/js/jquery.min.js"></script>
	<script type="text/javascript" src="../static/lib/js/popper.min.js"></script>
	<script type="text/javascript" src="../static/lib/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
	<style type="text/css">
		body, html {
			background-color: #EEEEEE;
		}
	</style>

	<?php startblock('header') ?>
	<?php endblock() ?>

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #151515;">
		<a class="navbar-brand" href="login.php">Brac</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav"">
			<ul class="navbar-nav">
				<?php if(isset($_SESSION['userid'])): ?>
				<li class="nav-item">
					<a class="nav-link" href="dashboard.php">Dashboard</a>
				</li>
				<li class="nav-item">
						<a class="nav-link" href="profile.php">Profile</a>
					</li>
				 	<li class="nav-item">
						<a class="nav-link" href="signout.php">Sign out</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="createstudent.php">CreateStudent</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="addproblem.php">Report Problem</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="performence.php">Report Performence</a>
					</li>
				<?php else: ?>
				 	<li class="nav-item">
						<a class="nav-link" href="login.php">Sign in</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>
	<div id='base_content'>
		<?php startblock('content') ?>
		<?php endblock() ?>
	</div>
</body>
</html>