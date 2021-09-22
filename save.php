<?php
session_start();
	
require_once "UserManager.php";
	

	if (!isset($_POST['email'])) {
		header('Location: register.php');
	} else {
	
		$userManager = new UserManager();
		$userData = $userManager->getUserData();
		
		$login = $userData->getLogin();
		$password = $userData->getPassword();
		$email = $userData->getEmail();
		$name = $userData->getName();
		$surname = $userData->getSurname();
		$phone_number = $userData->getPhoneNumber();
		
		$isSafeToConnect = true;
			if ((strlen($login)<3) || (strlen($login)>20))
		{
			$isSafeToConnect = false;
			$_SESSION['e_login'] = "Login must be 3 to 20 characters long!";
			
			$userManager->saveDataInSession();
			header('Location: register.php');
		}
		if (ctype_alnum($login)==false)
		{
			$isSafeToConnect = false;
			$_SESSION['e_login'] = "Login can only consist of letters and numbers";
			$userManager->saveDataInSession();
			header('Location: register.php');
		}
		
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) ||($emailB!=$email))
		{
			$isSafeToConnect = false;
			$_SESSION['e_email'] = "Please specify your e-mail address appropriately.";
			$userManager->saveDataInSession();
			header('Location: register.php');
		}
		
		if ((strlen($password)<8) || (strlen($password)>20))
		{
			$isSafeToConnect = false;
			$_SESSION['e_password'] = "Password must be 8 to 20 characters long!";
			$userManager->saveDataInSession();
			header('Location: register.php');
		}
		$pass_hash = password_hash($password, PASSWORD_DEFAULT);
		
		if ($isSafeToConnect) {
			
			require_once 'database.php';
			$result = $db->query("SELECT * FROM users WHERE email='$email'");
			if ($result->rowCount()) {
				$_SESSION['e_email'] = "The given e-mail address already exists. Please, specify different.";
				$userManager->saveDataInSession();
				header('Location: register.php');
			} else {
				
				$query = $db->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email, :name, :surname, :phone_number )');
				$query->execute([$login, $pass_hash, $email, $name, $surname, $phone_number ]);
			
				$user_id = $db->query("SELECT id FROM users WHERE email='$email'");
				$user1 = $user_id->fetchColumn();
				
				$table_name = "currency_assigned_to_".$user1;
				
				$db->query("CREATE TABLE $table_name ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, acronym VARCHAR(11) NOT NULL, name VARCHAR(50) NOT NULL)");
				$db->query("INSERT INTO $table_name SELECT * FROM currency_default");
				
				$table_name = "incomes_category_assigned_to_".$user1;
				$db->query("CREATE TABLE $table_name ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL)");
				$db->query("INSERT INTO $table_name SELECT * FROM incomes_category_default");
				
				$table_name = "expenses_category_assigned_to_".$user1;
				$db->query("CREATE TABLE $table_name LIKE expenses_category_default");
				$db->query("INSERT INTO $table_name SELECT * FROM expenses_category_default");
				
				$table_name = "payment_methods_assigned_to_".$user1;
				$db->query("CREATE TABLE $table_name ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL)");
				$db->query("INSERT INTO $table_name SELECT * FROM payment_methods_default");

				$userManager->unsaveDataInSession();
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Personal Budget</title>
	<meta name="description" content="Take control of your personal budget!">
	<meta name="keywords" content="budget, finances, savings ">
	<meta name="author" content="Karolina Pałka">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  
	<link rel="stylesheet"  href="bootstrap-5.1.0-dist/bootstrap-5.1.0-dist/css" type="text/css">
	
	<link rel="stylesheet"  href="main.css" type="text/css">
	<link rel="stylesheet" href = "css/fontello.css" type="text/css"/>

	<link href="https://fonts.googleapis.com/css2?family=Encode+Sans+SC&family=Zen+Loop:ital@1&display=swap" rel="stylesheet">

	
</head>

<body>
	<header>
	
		<div class="paper" style="transform: rotate(15deg);"> 
			<i class="icon-pin"></i>
			
			<h1><i class="icon-lightbulb"> Register &</i> </h1>
			<h2>Take control of your personal budget</h2>
		</div>
	</header>
	
	<main>
	
	<div class="container">
			<div class="row mt-1 ">
				<div class="col-sm-12 col-md-8 col-lg-12 me-auto ms-auto" >
					<div id="container">
						<article>
							<div class="communication">Thank you for the registration!

							<p><a class="dark-link" href="login.php">Log in</a></p></div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</main>
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>