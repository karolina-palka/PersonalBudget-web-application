
<?php
 echo '	
 <!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Personal Budget</title>
	<meta name="description" content="Take control of your personal budget!">
	<meta name="keywords" content="budget, finances, savings ">
	<meta name="author" content="Karolina Pałka">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  
  
	<link rel="stylesheet"  href="bootstrap-5.1.0-dist/bootstrap-5.1.0-dist/css" >
  
	
	<link rel="stylesheet"  href="mainMenu.css" type="text/css">
	<link rel="stylesheet" href = "css/fontello.css" type="text/css"/>

	<link href="https://fonts.googleapis.com/css2?family=Encode+Sans+SC&family=Zen+Loop:ital@1&display=swap" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
	
	<div class="paper" style="transform: rotate(15deg) translateX(-10px) translateY(15px);"> 
		<i class="icon-pin"></i>
		<h1><i class="icon-lightbulb"> KEEP CALM & </i> </h1>
		<h2>Take control of your personal budget</h2>
		<div id="person" ><i class="icon-pitch"></i></div>
	</div>
				
	<div class="container">
		<div class="row mb-md-n2 ">
			<div class="col-12">
				<div id="airplane" class="d-none d-md-inline-block">
						<i class="icon-airport"></i>
				</div>
				<div class="logo d-flex ">
					<div id="tree1" class="d-none d-md-block align-self-end"><i class="icon-tree-1"></i></div>
					<div id="gift" class="d-none d-md-block align-self-end"><i class="icon-gift"></i></div>
					
					<div id="child" class="d-none d-md-block align-self-end"><i class="icon-child"></i></div>
					<div id="bicycle" class="d-none d-md-block align-self-end"><i class="icon-bicycle"></i></div>
					<div id="flower" class="d-none d-md-block align-self-end"><i class="icon-garden"></i></div>
					<div id="tree2" class="d-none d-xl-block align-self-end"><i class="icon-tree-2"></i></div>
				</div>
			</div>
		</div>
	</div>	

	<header class="sticky-top">
		<nav class="navbar navbar-expand-lg bg-custom navbar-dark">
			 <div class="container-fluid">
				<a class="navbar-brand ml-3" href="mainMenu.php"><i class="icon-lightbulb"></i>Home </a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
					<div class="btn-group btn-group-lg text-center navbar-nav">
						<!--<form action="addFinance.php" method="post">-->
						  <a class="btn btn-lg nav-link shadow-none" name="income" href="addIncome.php" role="button">Add new income</a>
						  <!--<input class="btn btn-lg nav-link shadow-none" style="margin:0;" type="submit" name="income" id="submit" value="Add new income">-->
						 <!--</form>-->
						 <!--<form action="addFinance.php" method="post">-->
						   <a class="btn btn-lg nav-link shadow-none" name="expense" href="addExpense.php" role="button">Add new expense</a>
						<!--</form>-->
						 <div class="btn-group btn-group-lg text-center navbar-nav" >
						  <button id="btnGroupDrop1" type="submit" class="btn btn-lg bg-custom nav-link dropdown-toggle shadow-none active" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Show balance</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="currentMonthBalance.php"><i class="icon-ok"></i>From the current month</a>
							  <a class="dropdown-item" href="showBalance.php"><i class="icon-ok"></i>From the previous month</a>
							  <a class="dropdown-item" href="showBalance.php"><i class="icon-ok"></i>From the chosen period</a>
							</div>
						</div>
						<div class="btn-group btn-group-lg text-center navbar-nav" >
						  <button id="btnGroupDrop1" type="submit" class="btn btn-lg bg-custom nav-link dropdown-toggle shadow-none active" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Your profile</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="showBalance.php"><i class="icon-user"></i>Edit your profile</a>
							  <a class="dropdown-item" href="#"><i class="icon-cog"></i>Change your password</a>
							  <a class="dropdown-item" href="logout.php"><i class="icon-logout"></i>Log out</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		
	</header>';
	?>