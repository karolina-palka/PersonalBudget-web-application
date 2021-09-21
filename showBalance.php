<?php
 session_start();
 
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
			
					<form action="showBalance.php" method="post">
					
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block ">
								
								<div class="d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="current" checked onclick="checkDate()">
								  <label class="form-check-label" for="current">
									<span>current month</span>
								  </label>
								</div>
								<div class="d-flex mb-2 form-check">
								  <input class=" pb-1 form-check-input" type="radio" name="flexRadioDefault" id="previous" checked onclick="checkDate()">
								  <label class="form-check-label" for="previous">
									<span>previous month</span>
								  </label>
								</div>
								
								<div class="d-flex mb-2 form-check">
								  <input class=" form-check-input" type="radio" name="flexRadioDefault" id="chosen" checked onclick="checkDate()">
								  <label class="form-check-label text-end" for="chosen">
									<span>chosen period:</span>
								  </label>
								  
								</div>
								<!--<div class="d-flex flex-column ">
								<div class="d-flex justify-content-center" id="browseButton" ><input id="browse" type="submit" value="Browse" onclick="checkTimePeriod()"></div></div>-->
						</div>	
						
						<div class ="d-sm-inline-block d-md-block d-xl-inline-block mx-4 ">
						
							
							<div class="d-flex flex-column">
								
									<label>from:</label><div class="d-flex justify-content-center">
									<input id="calendar1" type="date" name="balance_date"> 
									</div>
									
							
								</div>
							
							<div class="d-flex flex-column">
									
									<label>to:</label><div class="d-flex justify-content-center">
									<input id="calendar2" type="date" name="balance_date"></div>
					
									<div class="d-flex justify-content-center" id="browseButton" ><input id="browse" type="submit" value="Browse" onclick="checkTimePeriod()"></div>
								 
							</div>
								
						</div>
						
					</form>
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
					
					document.getElementById('calendar1').disabled = true;
					document.getElementById('calendar2').disabled = true;
				}

				function checkDate()
				{
					var today= new Date();
					var year = today.getFullYear();
					
					if (document.getElementById('current').checked)
					{
						var month = today.getMonth() + 1;
						var day = today.getDate();
						setDatePeriod(month, day);

					}

					else if (document.getElementById('previous').checked)
					{
						var month = today.getMonth();
						var days = getEndDayOfActualMonth(month, year);
						setDatePeriod(month, days);
					}
					else 
					{
						document.getElementById('calendar1').disabled = false;
						document.getElementById('calendar2').disabled = false;
					}
				}
				
				function checkTimePeriod()
				{
					if(document.getElementById('chosen').checked)
					{
						var period1 = document.getElementById("calendar1").value;
						document.getElementById('calendar2').min = period1;
						
					}
				}
			
			</script>
		
		
	<div id="footer"> All rights reserved &copy; 2021</div>
	</main>
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>