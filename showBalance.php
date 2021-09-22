<?php
 session_start();
 
 
  if((isset($_POST['balance_date1'])) && (!isset($_SESSION['bad_attempt']))){
 
	 if (($_POST['balance_date1']!="") && ($_POST['balance_date2']!="")) {
		 require_once "database.php";
		 $from = $_POST['balance_date1'];
		 $to = $_POST['balance_date2'];
		 $user_id = $_SESSION['logged_id'];
		 
		if (isset ($_POST['category'])) {
			  $category = $_POST['category'];
			  $sqlIncomesQuery = "SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_$user_id as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND ass.id = '$category' AND date_of_income BETWEEN '$from' AND '$to' ORDER BY date_of_income ";
			  $sqlIncomesQuery = "SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_$user_id as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND ass.id = '$category' AND date_of_expense BETWEEN '$from' AND '$to' ORDER BY date_of_expense ";
		 }
		else {
			$sqlIncomesQuery ="SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_$user_id as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND date_of_income BETWEEN '$from' AND '$to'  ORDER BY date_of_income ";
			$sqlIncomesQuery = "SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_$user_id as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND date_of_expense BETWEEN '$from' AND '$to' ORDER BY date_of_expense ";
		}
		 $incomesQuery = $db->query($sqlIncomesQuery);
		 $expensesQuery = $db->query($sqlIncomesQuery);
		 
		 
		/*$incomesQuery = $db->query("SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_$user_id as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND date_of_income BETWEEN '$from' AND '$to'  ORDER BY date_of_income ");

		$expensesQuery = $db->query("SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_$user_id as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND date_of_expense BETWEEN '$from' AND '$to' ORDER BY date_of_expense ");*/
		
		$incomes = $incomesQuery->fetchAll();
		$expenses = $expensesQuery->fetchAll();
		$total_income = 0;
		$total_expense = 0;
		$row_number = 0;
		 }
		 
	else {
		
		$_SESSION['bad_attempt'] = "Bad attempt. Please specify correct date!";
	
	}
	 
}
	 

 require_once "common_main.php";
?>
	<main>
		<div class="container-fluid">
			<div class="row mt-1 ">
				<div class="col-12 col-md-3 ml-md-n3 mx-sm-auto mx-md-0" >
					<div id="sideNav">

						<div class="optionL"><a href="mainMenu.php" class="link" target= "_blank">Home</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Saved reports</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Links</a></div>
						<div class="optionL"><a href="#" class="link" target= "_blank">Contact</a></div>
				
					</div>
				</div>
				<div  id="custom-container" class="col-12 col-md-8">
			
					<form method="post">
						<div class="error" id="result"> 
						<?php
							if(isset($_SESSION['bad_attempt'])) {
								echo '<div class="error">'.$_SESSION['bad_attempt'].'</div>';
								//unset ($_SESSION['bad_attempt']);
							}							 
						?> </div>
					
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block ">
								
								<div class="d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="current" <?= isset($_SESSION['current']) ? $_SESSION['current'] : '' ?> >
								  <label class="form-check-label" for="current">
									<span>current month</span>
								  </label>
								</div>
								<div class="d-flex mb-2 form-check">
								  <input class=" pb-1 form-check-input" type="radio" name="flexRadioDefault" id="previous" <?= isset($_SESSION['previous']) ? $_SESSION['previous'] : '' ?>  >
								  <label class="form-check-label" for="previous">
									<span>previous month</span>
								  </label>
								</div>
								
								<div class="d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="chosen" <?= isset($_SESSION['chosen']) ? $_SESSION['chosen'] : '' ?> >
								  <label class="form-check-label text-end" for="chosen">
									<span>chosen period:</span>
								  </label>
								  
								</div>
								<div class="d-flex flex-column">
								
									<label>Choose the category (optionally):</label><div class="d-flex justify-content-center">
									<select id="category" name="category" >
										<option value="1"> Transport</option>
										<option value="2"> Books </option>
										<option value="3"> Food </option>
										<option value="4"> Apartments </option>
										<option value="5"> Telecommunication </option>
										<option value="6"> Health </option>
										<option value="7"> Clothes </option>
										<option value="8"> Hygiene </option>
										<option value="9"> Cosmetics </option>
										<option value="10"> Medicines </option>
										<option value="11"> Kids </option>
										<option value="12"> Recreation </option>
										<option value="13"> Trip </option>
										<option value="14"> Savings </option>
										<option value="15"> Debt Repayment </option>
										<option value="16"> For Retirement </option>
										<option value="17"> Gift </option>
										<option value="17"> Another </option>
									  </select>
									</div>
								</div>
						</div>	
						
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
					
							<div class="d-flex flex-column">
								
									<label>from:</label><div class="d-flex justify-content-center">
									<input id="calendar1" type="date" onchange="validateAndSetDate()" name="balance_date1" <?= isset($_POST['balance_date1']) ? 'value="' . $_POST['balance_date1']. '"' : '' ?>> 
									</div>
								</div>
							
							<div class="d-flex flex-column">
									
									<label>to:</label><div class="d-flex justify-content-center">
									<input id="calendar2" type="date" onchange="checkDate()" name="balance_date2" <?= isset($_POST['balance_date2']) ? 'value="' . $_POST['balance_date2']. '"' : '' ?>></div>
					
									<div class="d-flex justify-content-center" id="browseButton" ><input id="browse" type="submit" value="Browse" disabled></div>
								 
							</div>
								
						</div>
					</form>
					<?php
					
					if (isset($_POST['balance_date1'])) {
					echo '<table class="label-margin" >
							<thead>
								<tr><th colspan="5">Incomes</th></tr>
								<tr><th>No</th><th>Date</th><th>Amount</th><th>Income category</th><th>Comment</th></tr>
							</thead>
							<tbody>';
						if (isset($_SESSION['bad_attempt'])) {
							echo $_SESSION['bad_attempt'];
							unset ($_SESSION['bad_attempt']);
						} else {
								foreach($incomes as $income){
										if (isset($income['date_of_income'])) {
										$total_income += $income['amount'];
										$row_number +=1;
										echo "<tr><td>{$row_number}</td><td>{$income['date_of_income']}</td><td>{$income['amount']}</td><td>{$income['name']}</td><td>{$income['income_comment']}</td></tr>";
									} else {
										$_SESSION['no_incomes'] = "You don't have any incomes yet.";
									}										
								}
								echo '<tr><td colspan="5">Total records: ' . $incomesQuery->rowCount()."</td><tr>";
								echo '<tr><td colspan="5" class="incomes"> Total incomes: ' . $total_income.'</td><tr>';
								
							echo '</tbody>
							</table>';
							$row_number=0;
							} 
								if (isset($_SESSION['no_incomes'])) {
									echo $_SESSION['no_incomes'];
									 unset($_SESSION['no_incomes']);
								}
						}
					//}
					if (isset($_POST['balance_date1'])) {
						echo '<table class="label-margin" >
							<thead>
								<tr><th colspan="5" >Expenses </th></tr>
								<tr><th>No</th><th>Date</th><th>Amount</th><th>Expense category</th><th>Comment</th></tr>
							</thead>
							<tbody>';
							if (isset($_SESSION['bad_attempt'])) {
							echo $_SESSION['bad_attempt'];
							unset ($_SESSION['bad_attempt']);
						} else {
							foreach ($expenses as $expense) {
								if (isset($expense['date_of_expense'])) {
									$total_expense += $expense['amount'];
									$row_number +=1;
									echo "<tr><td>{$row_number}</td><td>{$expense['date_of_expense']}</td><td>{$expense['amount']}</td><td>{$expense['name']}</td><td>{$expense['expense_comment']}</td></tr>";
								} else {
									$_SESSION['no_expenses'] = "You don't have any expenses yet.";
								}
							}
							$total_balance = $total_income - $total_expense;
							echo '<tr><td colspan="5">Total records: ' . $expensesQuery->rowCount().'</td><tr>';
							echo '<tr><td colspan="5" class="expenses">Total expenses: ' . $total_expense.'</td><tr>';
							echo '<tr><td colspan="5" class="summary">Total balance: '.$total_balance.'</td></tr>';

						echo '</tbody>
						</table>';
					
							} 
								if (isset($_SESSION['no_expenses'])) { 
								echo $_SESSION['no_expenses'];	
								unset ($_SESSION['no_expenses']); }
						}
						?>
				</div>
			</div>
		</div>
			
			<script>	

				function getEndDayOfActualMonth(month, year)
				{
					var days;
					 if (month <= 7 && month%2 != 0)
					{
						days = 31;
					}
					else if (month <= 7 && month%2 == 0)
					{
						if (month ==2)
						{
							if(year%4==0 && year%100!=0)
							{
								days = 29;
							}
							else
							{
								days = 28;
							}
						}
						else
						{
						   days = 30;
						}
					}
					else if (month >7 && month%2 == 0)
					{
						days = 31;
					}
					else if (month >7 && month%2 != 0)
					{
						days = 30;
					}
					return days;
				}
				
				function setDatePeriod(month, day)
				{
					var padMonth = "-";
					var padDay = "-";
					if (month < 10 ) padMonth = padMonth + "0";
						
					var startDate = "2021" + padMonth + month + padDay + "01";
					
					if ( day <10)  padDay = padDay + "0";
					var endDate = "2021" + padMonth + month + padDay + day;
					
					document.getElementById('calendar1').value = startDate;
					document.getElementById('calendar2').value = endDate;
					
					document.getElementById('calendar1').readOnly = true;
					document.getElementById('calendar2').readOnly = true;
				}
			
				  	
				function setCurrentMonth() {
						var today= new Date();
						var year = today.getFullYear();
						var month = today.getMonth() + 1;
						var day = today.getDate();
						setDatePeriod(month, day);
					
				}

				 function setPreviousMonth() {
						var today = new Date();
						var year = today.getFullYear();
						var month = today.getMonth();
						var days = getEndDayOfActualMonth(month, year);
						setDatePeriod(month, days);
					
				}
				 window.onload = function() {
					 if ( document.getElementById('previous').checked) {
					 setPreviousMonth();
					 validateAndSetDate();
					 } else if ( document.getElementById('current').checked) {
						setCurrentMonth(); 
						validateAndSetDate();
					 } 
				 }
				 
			function checkDate() {
					 var period1 = document.getElementById("calendar1").value;
					document.getElementById('calendar2').min = period1;
					 var period2 = document.getElementById("calendar2").value;
					document.getElementById('calendar1').max = period2;
					var fullToday = getFullToday();
					if ((fullToday < period2) ) {
						document.getElementById('calendar2').value = fullToday;
						document.getElementById('calendar1').max = fullToday;
						
					}
					while ( document.getElementById('calendar2').value < document.getElementById('calendar1').value) {
						document.getElementById('calendar1').value = document.getElementById('calendar2').value;
						//document.getElementById('calendar2').min = document.getElementById('calendar1').value;
					}
				 }
			 
			 function getFullToday() {
				 var today = new Date();
				var year = today.getFullYear();
				var month = today.getMonth() + 1;
				var day = today.getDate();
				var padMonth = "-";
				var padDay = "-";
				if (month < 10 ) padMonth = padMonth + "0";
				if ( day < 10)  padDay = padDay + "0";
				var fullToday = year+ padMonth + month + padDay + day;
				return fullToday;
			 }
		
			function validateAndSetDate() {
				
				var fullToday = getFullToday();
				
				var userDate1 = document.getElementById("calendar1").value;
				var userDate2 = document.getElementById("calendar2").value;
				//document.getElementById('result').innerHTML = fullToday; 
				
				if ((fullToday < userDate1) ){
					document.getElementById('browse').disabled = true;
					document.getElementById('result').innerHTML = "Please specify correct date!"; 
					document.getElementById('calendar2').value = fullToday;
				} else if ((fullToday >= userDate1) ){
					document.getElementById('browse').disabled = false;
					
					document.getElementById('result').innerHTML = " ";
					
				}
			}
			</script>
		
		
	<div id="footer"> All rights reserved &copy; 2021</div>
	</main>
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>