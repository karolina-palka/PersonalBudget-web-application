<?php

session_start();

require_once "common_main.php";
require_once "FinanceManager.php";

$financeManager = new ExpenseManager();

$categories  = $financeManager->getUserExpenseCategories();
$currency_categories = $financeManager->getUserCurrencyCategories();
$payment_methods = $financeManager->getUserPaymentCategories();


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
					
					<form action="save_expense.php" method="post">
					
						<div class="error" id="result">
						<?php
							if(isset($_SESSION['e_date'])) {
								echo '<div class="error">'.$_SESSION['e_date'].'</div>';
								unset ($_SESSION['e_date']);
							}							 
						?> </div>
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
						
							<div class=" d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="current" disabled>
								  <label class="form-check-label" for="current">
									<span>Income</span>
								  </label>
								</div>
							<div class="d-flex mb-2 form-check">
								  <input class=" pb-1 form-check-input" type="radio" name="flexRadioDefault" id="previous" checked >
								  <label class="form-check-label" for="previous">
									<span>Expense</span>
								  </label>
							</div>

								<label class="label-margin">Enter the amount:</label>
									  <div class="d-flex justify-content-center"><input type="number" step="0.01" name="amount" <?= isset($_SESSION['amount']) ? 'value="' . $_SESSION['amount']. '"' : '' ?> > </div>
								
								<label class="label-margin">Choose category:</label>
									  <div class="d-flex justify-content-center"><select id="category" name="category" >
										<?php 
										foreach ($categories as $category) {
											echo '<option ';
											if (isset($category['id'])) {
												echo 'value="' . $category['id']. '" >'.$category['name'].'</option>';
											}
										}
										?>
									  </select>
									  </div>
								  <label class="label-margin">Choose payment method:</label>
								  <div class="d-flex justify-content-center"><select id="payment_method" name="payment_method" >
									<!--<option value="Cash"> Cash</option>
									<option value="Debit Card"> Debit Card </option>
									<option value="Credit Card"> Credit Card </option>-->
									<?php 
										foreach ($payment_methods as $payment_method) {
											echo '<option ';
											if (isset($payment_method['id'])) {
												echo 'value="' . $payment_method['id']. '" >'.$payment_method['name'].'</option>';
											}
										}
									?>
								  </select>
								  </div>
								  <label class="label-margin">Choose currency:</label>
								<div class="d-flex justify-content-center">
									<select id="currency_category" name="currency_category">
										<!--<option value="PLN"> PLN </option>
										<option value="EUR"> EUR </option>
										<option value="USD"> USD </option>
										<option value="GBP"> GBP </option>-->
										<?php 
										foreach ($currency_categories as $currency_category) {
											echo '<option ';
											if (isset($currency_category['id'])) {
												echo 'value="' . $currency_category['id']. '" >'.$currency_category['acronym'].'</option>';
											}
										}
										?>
										<option value="0"> Add another currency </option>
									</select>
								</div>
							</div>

						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
							<div class="d-flex flex-column">
								<label class="label-margin">Enter the date:</label>
								<div class=" d-flex justify-content-center"><input type="date" id="calendar" name="finance_date" onchange="validateDate()"></div>
							
							
							</div>
							<label class="label-margin">Comments:</label>
									  <div class="d-flex justify-content-center"><textarea id="comment"  name="comment" rows="4" cols="40"><?= isset($_SESSION['comment']) ? $_SESSION['comment']: '' ?></textarea></div>
							
							<div class="d-flex justify-content-center"><input type="submit" id="submit" value="Submit"></div>
							
						</div>
					</form>	
					
				</div>
			</div>
		</div>
		<script>
			function validateDate() {
				var today = new Date();
				var year = today.getFullYear();
				var month = today.getMonth() + 1;
				var day = today.getDate();
				var padMonth = "-";
				var padDay = "-";
				if (month < 10 ) padMonth = padMonth + "0";
				if ( day < 10)  padDay = padDay + "0";
				var fullToday = year+ padMonth + month + padDay + day;
				var userDate = document.getElementById("calendar").value;
				document.getElementById('result').innerHTML = fullToday; 
				
				if (fullToday < userDate){
					document.getElementById('submit').disabled = true;
					document.getElementById('result').innerHTML = "Please specify correct date!"; 
				} else {
					document.getElementById('submit').disabled = false;
					document.getElementById('result').innerHTML = " ";
				}
			}
		</script>
	</main>
	<div id="footer"> All rights reserved &copy; 2021</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>