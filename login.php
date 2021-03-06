<?php
session_start();


if (isset($_SESSION['logged_id'])) {
	header("Location: mainMenu.php");
	exit();
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
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>

	<header>
	
		<div class="paper" style="transform: rotate(15deg);"> 
			<i class="icon-pin"></i>
			
			<h1><i class="icon-lightbulb"> Log in &</i> </h1>
			<h2>Take control of your personal budget</h2>
		</div>
	</header>
	
	<main>
		<div class="container">
			<div class="row mt-1 ">
				<div class="col-sm-12 col-md-6 col-lg-5 me-auto ms-auto" >
					<div id="container" >
						<article>
							
								<form  action="mainMenu.php" method="post">
								<?php
									if (isset($_SESSION['bad_attempt'])) {
										//echo $_SESSION['bad_attempt'];
										echo '<div class="error">'.$_SESSION['bad_attempt'].'</div>';
										unset ($_SESSION['bad_attempt']);
									}
								?>
									<div class="d-flex flex-column">
										<div class="d-flex justify-content-center"><input class="d-flex justify-content-center" type="email" placeholder="e-mail" name="email" onfocus="this.placeholder=''" onblur="this.placeholder='login'" <?= isset($_SESSION['given_email']) ? 'value="' . $_SESSION['given_email']. '"' : '' ?>>
										</div>
										<div class="d-flex justify-content-center">
										<input class="d-flex justify-content-center" type="password" placeholder="password" onfocus="this.placeholder=''" name="password" onblur="this.placeholder='password'"></div>
										
										<div class="d-flex justify-content-center">
										<input class="d-flex justify-content-center" type="submit" value="Log in"></div>
									</div>
									
								</form>
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