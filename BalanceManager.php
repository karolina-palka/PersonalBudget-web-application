<?php

require_once "Database.php";
require_once "FinanceManager.php";

Class BalanceManager {
	
	private $connection;
	private $finance;
	private $user_id;
	public $incomesQuery;
	public $expensesQuery;
	public $currency_acronym;
	
	function __construct() {
		
		$this->finance = new Finance();
		$this->user_id = $_SESSION['logged_id'];
		$this->createConnection();
	}
	
	function createConnection() {
			$db = new Database();
			$this->connection = $db->createConnection();
	}
		
	function returnResultsFromToDatabase($sqlQuery) {
		 $queryResult = $this->connection->query($sqlQuery);
		 //$results = $queryResult->fetchAll();
		 return $queryResult;
	}
	function showBalance() {
		
		if (($_POST['balance_date1']!="") && ($_POST['balance_date2']!="")) {
		 
			 $from = $_POST['balance_date1'];
			 $to = $_POST['balance_date2'];
			 $user_id = $_SESSION['logged_id'];
			 $currency = $this->finance->getCurrencyCat();
			 
			if (isset ($_POST['category'])) {
				  $category = $_POST['category'];
				  $sqlIncomesQuery = "SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_users as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND ass.id = '$category' AND date_of_income BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_income ";
				  $sqlExpensesQuery = "SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_users as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND ass.id = '$category' AND date_of_expense BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_expense ";
					
				
					
			 }
			else {
				$sqlIncomesQuery ="SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_users as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND date_of_income BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_income ";
				$sqlExpensesQuery = "SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_users as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND date_of_expense BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_expense ";
			}
			$currencyQuery = "SELECT acronym FROM currency_category_assigned_to_users WHERE id='$currency'";
			 //$incomesQuery = $this->connection->query($sqlIncomesQuery);
 			$this->incomesQuery = $this->returnResultsFromToDatabase($sqlIncomesQuery);
			$this->expensesQuery = $this->returnResultsFromToDatabase($sqlExpensesQuery);
			$this->currency_acronym = $this->returnResultsFromToDatabase($currencyQuery)->fetchColumn();
			//$expensesQuery = $this->connection->query($sqlIncomesQuery);
			 
			 
			/*$incomesQuery = $db->query("SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_$user_id as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND date_of_income BETWEEN '$from' AND '$to'  ORDER BY date_of_income ");

			$expensesQuery = $db->query("SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_$user_id as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE user_id='$user_id' AND date_of_expense BETWEEN '$from' AND '$to' ORDER BY date_of_expense ");*/
			
			//$this->incomes = $incomesQuery->fetchAll();
			//$this->$expenses = $expensesQuery->fetchAll();
			
		} else {
			
			$_SESSION['bad_attempt'] = "Bad attempt. Please specify correct date!";
		}
		
	}
	
		function getUserExpenseCategories() {
			$categories = $this->getUserCategories('expenses_category_assigned_to_users');
			return $categories;
		}
		
		function getUserIncomeCategories() {
			$categories = $this->getUserCategories('incomes_category_assigned_to_users');
			return $categories;
		}
		
		function getUserPaymentCategories() {
			$categories = $this->getUserCategories('payment_methods_assigned_to_users');
			return $categories;
		}
		function getUserCurrencyCategories() {
			$categories = $this->getUserCategories('currency_category_assigned_to_users');
			return $categories;
		}
		
		function getUserCategories($table_name) {
			$user_id = $this->user_id;
			$updateQuery = $this->connection->query("SELECT * FROM $table_name WHERE user_id='$user_id'");
			$categories = $updateQuery->fetchAll();
			return $categories;
		}
	
};



