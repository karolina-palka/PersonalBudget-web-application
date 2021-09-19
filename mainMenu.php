<?php

require_once "UserManager.php";

if (!isset($_POST['email'])) {
	header("Location: index.php");
} else {
	$email = UserManager::getEmail();
	$password = UserManager::getPassword();
	
	require_once 'database.php';
	$userQuery = $db->prepare('SELECT id, password FROM admins WHERE email=:email');
		$userQuery->bindValue(':email', $email, PDO::PARAM_STR);
		$userQuery->execute();
		
		$user = $userQuery->fetch();
		
		if($user && password_verify($password, $user['password'])) {
			$_SESSION['logged_id'] = $user['id'];
			unset($_SESSION['bad_attempt']);
		} else {
			
			$_SESSION['bad_attempt'] = true;
			$_SESSION['given_login'] = $_POST['login'];
			header('Location: admin.php');
			exit();
		}
		
}
	
}

?>

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
	
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  
  
	<link rel="stylesheet"  href="bootstrap-5.1.0-dist/bootstrap-5.1.0-dist/css" type="text/css">
  
  
	<!--<link rel="stylesheet"  href="css/bootstrap.min.css" type="text/css">-->
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
				<a class="navbar-brand ml-3" href="mainMenu.html"><i class="icon-lightbulb"></i>Home </a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
					<div class="btn-group btn-group-lg text-center navbar-nav">
							
						  <a class="btn btn-lg nav-link shadow-none" href="addFinance.html" role="button">Add new income</a>
						 
						   <a class="btn btn-lg nav-link shadow-none" href="addFinance.html" role="button">Add new expense</a>
							
						<div class="btn-group btn-group-lg text-center navbar-nav" >
						  <button id="btnGroupDrop1" type="submit" class="btn btn-lg bg-custom nav-link dropdown-toggle shadow-none active" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Show balance</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="showBalance.html"><i class="icon-ok"></i>From the current month</a>
							  <a class="dropdown-item" href="showBalance.html"><i class="icon-ok"></i>From the previous month</a>
							  <a class="dropdown-item" href="showBalance.html"><i class="icon-ok"></i>From the chosen period</a>
							</div>
						</div>
						<div class="btn-group btn-group-lg text-center navbar-nav" >
						  <button id="btnGroupDrop1" type="submit" class="btn btn-lg bg-custom nav-link dropdown-toggle shadow-none active" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Your profile</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="showBalance.html"><i class="icon-user"></i>Edit your profile</a>
							  <a class="dropdown-item" href="#"><i class="icon-cog"></i>Change your password</a>
							  <a class="dropdown-item" href="#"><i class="icon-logout"></i>Log out</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		
	</header>
	<main>
		<div class="container-fluid">
			<div class="row mt-1 no-gutters">
				<div class="col-12 col-md-3 ml-md-n3 mx-sm-auto mx-md-0" >
					<div id="sideNav">

						<div class="optionL"><a href="mainMenu.html" class="link" target= "_blank">Home</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Saved reports</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Links</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Contact</a></div>
				
					</div>
				</div>
				<div  id="custom-container" class="col-12 col-md-8">
					<article>
						<h3>Welcome to the Personal Budget!</h3>
						
						This app helps you deal with your personal budget. No longer need to use sticky notes because all the knowledge about your finances are at one place. As a logged in user you can use the following functions: add new income, add new expense, show balance from the current month, previous month or the chosen period of time. You can also browse your records sorted by date.</br>
						Have a nice visit!
					</article>
		
				</div>
		
			</div>
		</div>
	</main>
	
	<div id="footer"> All rights reserved &copy; 2021</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	
</body>
</html>