<?php

session_start();

require_once "FinanceManager.php";

/*if (!isset($_POST['amount'])) {
	header('Location: addIncome.php');
	exit();
} else {*/

	$incomeManager = new IncomeManager();
	
	if (($_POST['finance_date'])!="") {
		
		require_once "database.php";
		
		$incomeData = $incomeManager->getIncomeData();
		$user_id = $_SESSION['logged_id'];
		$amount = $incomeData->getAmount();
		$income_date = $incomeData->getFinanceDate();
		$comment = $incomeData->getComment();
		$category = $incomeData->getIncomeCategory();
		$currency_category = $incomeData->getCurrencyCat();
		
		if (isset($_POST['currency_cat'])) {
			$new_currency = $incomeData-> getCurrencyNewCat();
			$new_currency_name = $incomeData->getCurrencyNewName();
			
			$result = $db->query("SELECT * FROM currency_assigned_to_$user_id WHERE acronym='$new_currency'");
			if ($result->rowCount()) {
				$_SESSION['e_email'] = "The given currency already exists. Please, specify different.";
				$incomeManager->saveDataInSession();
				header('Location: addIncome.php');
			} else {
				$queryCurrency = $db->prepare("INSERT INTO currency_assigned_to_$user_id VALUES (NULL, :acronym, :name)");
				$queryCurrency->execute([ $new_currency, $new_currency_name ]);
				$queryCurrencyId = $db->query("SELECT id FROM currency_assigned_to_$user_id WHERE acronym='$new_currency'");
				$currency_id = $queryCurrencyId->fetchColumn();
				
				$queryIncomes = $db->prepare('INSERT INTO incomes VALUES (NULL, :user_id, :income_category_assigned_to_user_id, :amount, :currency, :date_of_income, :income_comment )');
				$queryIncomes->execute([ $user_id, $category, $amount, $currency_id, $income_date, $comment ]);
				$_SESSION['done'] = "Your income and new currency has been successfully saved.";
				$incomeManager->unsaveDataInSession();
			}
		} else {
		
			$query = $db->prepare('INSERT INTO incomes VALUES (NULL, :user_id, :income_category_assigned_to_user_id, :amount, :currency, :date_of_income, :income_comment )');
			$query->execute([ $user_id, $category, $amount, $currency_category, $income_date, $comment ]);
			$_SESSION['done'] = "Your income has been successfully saved.";
			$incomeManager->unsaveDataInSession();
		}
	} else {
		$_SESSION['e_date'] = "Please specify correct date!";
		$incomeManager->saveDataInSession();
		header('Location: addIncome.php');
		exit();
	}
	


require_once "common_main.php";
?>

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
					<?php
							if (isset($_SESSION['done'])) {
	
								echo '<div class="communication">'.$_SESSION['done'].'<p><a class="dark-link" href="addIncome.php">Add another income >></a></p></div>';
								unset ($_SESSION['done']);
								
							} else {
								echo '<div class="text-center label-margin ">'."Something has gone wrong".'</div>';
								echo '<p><a class="dark-link" href="addIncome.php">Add another income >></a></p>';
							}
						
						?>
				</div>
			</div>
		</div>
	</main>
	<div id="footer"> All rights reserved &copy; 2021</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>