<?php

session_start();

require_once "UserManager.php";

	if (!isset($_SESSION['logged_id'])){
	
	if (!isset($_POST['email'])) {
		header("Location: index.php");
		exit();
	} else {
		
		unset ($_SESSION['given_email']);
		$userManager = new UserManager();
		$userData = $userManager->getUserData();
		$email = $userData->getEmail();
		$pass = $userData->getPassword();
		
		require_once 'database.php';
		$result = $db->prepare('SELECT * FROM users WHERE email=:email');
		$result->bindValue(':email', $email, PDO::PARAM_STR);
		$result->execute();
		//$result = $db->query("SELECT * FROM users WHERE email='$email'");
	
		$user = $result->fetch();
		
		if($user && password_verify($pass, $user['password'])) {
			$_SESSION['logged_id'] = $user['id'];
			$_SESSION['name'] = $user['name'];
			$_SESSION['login'] = $user['username'];
			unset($_SESSION['bad_attempt']);
			
		} else {
			
			$_SESSION['bad_attempt'] = "E-mail or password are incorrect. Please, specify them correctly.";
			$_SESSION['given_email'] = $_POST['email'];
			header('Location: login.php');
			exit();
		}
	}
		
} 
	
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<?php
require_once "common_main.php";
?>
</head>
	<main>
		<div class="container-fluid">
			<div class="row mt-1 no-gutters">
				<div class="col-12 col-md-3 ml-md-n3 mx-sm-auto mx-md-0" >
					<div id="sideNav">

						<div class="optionL"><a href="mainMenu.php" class="link" target= "_blank">Home</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Saved reports</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Links</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Contact</a></div>
				
					</div>
				</div>
				<div  id="custom-container" class="col-12 col-md-8">
					<article>
						<h3>Welcome <?= isset($_SESSION['name']) ? $_SESSION['name'].'!' : ' to the Personal Budget!' ?></h3>
						
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