<?php

session_start();

require_once "FinanceManager.php";

	$expenseManager = new ExpenseManager();
	
if (($_POST['finance_date'])!="") {
	
	$expenseData = $expenseManager->getExpenseData();
	$user_id = $_SESSION['logged_id'];
	$amount = $expenseData->getAmount();
	$expense_date = $expenseData->getFinanceDate();

	$comment = $expenseData->getComment();
	$category = $expenseData->getExpenseCategory();
	$payment_method = $expenseData->getPaymentMethod();
	//$id = 2;
	
	require_once "database.php";
	$query = $db->prepare('INSERT INTO expenses VALUES (NULL, :user_id, :expense_category_assigned_to_user_id, :payment_method_assigned_to_user_id, :amount, :date_of_expense, :expense_expense )');
	$query->execute([ $user_id, $category, $payment_method, $amount, $expense_date, $comment ]);
	$_SESSION['done'] = "Your expense has been successfully saved.";
	$expenseManager->unsaveDataInSession();
	
} else {
	$_SESSION['e_date'] = "Please specify correct date!";
	$expenseManager->saveDataInSession();
	header('Location: addExpense.php');
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
	
								echo '<div class="communication">'.$_SESSION['done'].'<p><a class="dark-link" href="addExpense.php">Add another expense >></a></p></div>';
								unset ($_SESSION['done']);
								
							} else {
								echo '<div class="text-center label-margin ">'."Something has gone wrong".'</div>';
								echo '<p><a class="dark-link" href="addExpense.php">Add another expense >></a></p>';
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