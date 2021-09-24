<?php

session_start();
require_once "FinanceManager.php";

$financeManager = new ExpenseManager();

$categories  = $financeManager->getUserIncomeCategories();
$currency_categories = $financeManager->getUserCurrencyCategories();

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
					<form action="save_income.php" method="post">
					<div class="error" id="result">
					<?php
						if(isset($_SESSION['e_date'])) {
							echo '<div class="error">'.$_SESSION['e_date'].'</div>';
							unset ($_SESSION['e_date']);
						}
						if (isset($_SESSION['e_category'])) {
							echo '<div class="error">'.$_SESSION['e_category'].'</div>';
							unset($_SESSION['e_category']);
						}
												 
					?></div>
						<div class="error" id="result"></div>
						<!--<div clas="d-inline-flex align-items-center">-->
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
							
						
							<div class=" d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="current" checked>
								  <label class="form-check-label" for="current">
									<span>Income</span>
								  </label>
								</div>
							<div class="d-flex mb-2 form-check">
								  <input class=" pb-1 form-check-input" type="radio" name="flexRadioDefault" id="previous" disabled>
								  <label class="form-check-label" for="previous">
									<span>Expense</span>
								  </label>
							</div>

							<label class="label-margin">Choose category:</label>
							<div class="d-flex justify-content-center">
								<select id="category" name="category" onchange="addCategoryIfNeeded()">
								
									<?php 
										foreach ($categories as $category) {
											echo '<option ';
											if (isset($category['id'])) {
												echo 'value="' . $category['id']. '" >'.$category['name'].'</option>';
											}
										}
									?>
									<option value="0"> Add new category </option>
								</select>
							</div>
							<label class="label-margin">or type in new one:</label>
							<div class="d-flex justify-content-center">
								<input type="text" id="add_category" name="new_category" disabled <?= isset($_SESSION['add_category']) ? 'value="' . $_SESSION['add_category']. '"' : '' ?> >
							</div>
							<label class="label-margin">Choose currency:</label>
							<div class="d-flex justify-content-center">
								<select id="currency_category" name="currency_category" onchange="addCurrencyIfNeeded()">
								
									<?php 
										foreach ($currency_categories as $currency_category) {
											echo '<option ';
											if (isset($currency_category['id'])) {
												echo 'value="' . $currency_category['id']. '" >'.$currency_category['acronym'].'</option>';
											}
										}
									?>
									<option value="0"> Add new currency </option>
								</select>
							</div>
								
							<label class="label-margin">or type in new one:</label>
							<div class="d-flex justify-content-center">
								<input type="text" id="add_currency" name="currency_cat" disabled <?= isset($_SESSION['add_currency']) ? 'value="' . $_SESSION['add_currency']. '"' : '' ?> >
							</div>
							<label class="label-margin">Name (optionally):</label>
							<div class="d-flex justify-content-center">
								<input type="text" id="currency_name"  name="currency_name" disabled <?= isset($_SESSION['currency_name']) ? 'value="' . $_SESSION['currency_name']. '"' : '' ?> >
							</div>
						</div>
						
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4" >
							<label class="label-margin">Enter the amount:</label>
							<div class="d-flex justify-content-center">
								<input type="number" step="0.01" name="amount" <?= isset($_SESSION['amount']) ? 'value="' . $_SESSION['amount']. '"' : '' ?>>
							</div>
						
							<div class="d-flex flex-column ">
								<label class="label-margin">Enter the date:</label>
								<div class=" d-flex justify-content-center"><input type="date" id="calendar" name="finance_date" onchange="validateDate()" ></div>
							</div>
							
							<label class="label-margin">Comments:</label>
							<div class="d-flex justify-content-center">
								<textarea id="comment"  name="comment" rows="4" cols="40" ><?= isset($_SESSION['comment']) ? $_SESSION['comment']: '' ?></textarea>
							</div>
							
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
				//document.getElementById('result').innerHTML = fullToday; 
				
				if (fullToday < userDate) {
					document.getElementById('submit').disabled = true;
					document.getElementById('result').innerHTML = "Please specify correct date!"; 
				} else {
					document.getElementById('submit').disabled = false;
					document.getElementById('result').innerHTML = " ";
				}
			}
			
			/*$("#currency_category").change(function() {
				//if (($(this).val()) == 5) {
					alert($(this).val())
				});*/
					
			function addCurrencyIfNeeded() {
				
				if (document.getElementById("currency_category").value == "0") {
					document.getElementById("add_currency").disabled = false;
					document.getElementById("currency_name").disabled = false;
				} else {
					document.getElementById("add_currency").disabled = true;
					document.getElementById("currency_name").disabled = true;
				}
			}
			function addCategoryIfNeeded() {
				
				if (document.getElementById("category").value == "0") {
					document.getElementById("add_category").disabled = false;
				} else {
					document.getElementById("add_category").disabled = true;
	
				}
			}
	
			
		</script>

	</main>
	<div id="footer"> All rights reserved &copy; 2021</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>