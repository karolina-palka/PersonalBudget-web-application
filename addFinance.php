<?php

session_start();


?>

<!DOCTYPE html>
<html lang="pl">
<head>
<?php
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
					
						<!--<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4">-->
						<div class="error" id="result"></div>
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
						
							<div class=" d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="current" checked>
								  <label class="form-check-label" for="current">
									<span>Income</span>
								  </label>
								</div>
							<div class="d-flex mb-2 form-check">
								  <input class=" pb-1 form-check-input" type="radio" name="flexRadioDefault" id="previous" >
								  <label class="form-check-label" for="previous">
									<span>Expense</span>
								  </label>
							</div>
							<!--<div class="d-flex mb-2">-->
								<label class="label-margin">Enter the amount:</label>
									  <div class="d-flex justify-content-center"><input type="number" step="0.01" name="amount" ></div>
								
							<!--</div>-->
							<!--<div class="d-flex mb-2">-->
								<label class="label-margin">Choose the category:</label>
									  <div class="d-flex justify-content-center"><select id="category" name="category" >
										<option value="1"> Salary</option>
										<option value="2"> Interest </option>
										<option value="3">Allegro </option>
										<option value="4">Another </option>
									  </select>
									  </div>
							</div>
						<!--</div>-->
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
							<div class="d-flex flex-column">
								<label class="label-margin">Enter the date:</label>
								<div class=" d-flex justify-content-center"><input type="date" id="calendar" name="finance_date" onchange="validateDate()"></div>
							
							
							</div>
							<label class="label-margin">Comments:</label>
									  <div class="d-flex justify-content-center"><textarea id="comment"  name="comment" rows="4" cols="40"></textarea></div>
							
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
		</script>
	</main>
	<div id="footer"> All rights reserved &copy; 2021</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>