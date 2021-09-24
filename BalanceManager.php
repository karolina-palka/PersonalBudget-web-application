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
		$this->user_id =  $_SESSION['logged_id'];
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
	
	function selectRecordsFromExpenseCategory() {
		$user_id = $this->user_id;
		$from = $_POST['balance_date1'];
		$to = $_POST['balance_date2'];
		$currency = $this->finance->getCurrencyCat();
		
		$category = $_POST['exp_category'];
		$sqlExpensesQuery = "SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_users as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND ass.id = '$category' AND date_of_expense BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_expense "; 
		return $sqlExpensesQuery;
	}
	
	function selectRecordsFromIncomeCategory() {
		$user_id = $this->user_id;
		$from = $_POST['balance_date1'];
		$to = $_POST['balance_date2'];
		$currency = $this->finance->getCurrencyCat();
		
		$category = $_POST['inc_category'];
		$sqlIncomesQuery = "SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_users as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND ass.id = '$category' AND date_of_income BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_income ";
		return $sqlIncomesQuery;
	}
	
	function showBalance() {
		
		if (($_POST['balance_date1']!="") && ($_POST['balance_date2']!="")) {
		 
			 $from = $_POST['balance_date1'];
			 $to = $_POST['balance_date2'];
			 $user_id = $_SESSION['logged_id'];
			 $currency = $this->finance->getCurrencyCat();
			 $_SESSION['currency'] = $currency;
			 
			if (isset ($_POST['exp_category'])) {
				$_SESSION['exp_category'] = $_POST['exp_category'];
				$sqlExpensesQuery = $this->selectRecordsFromExpenseCategory();
					
			 } else  {
				 $sqlExpensesQuery = "SELECT * FROM expenses as exp LEFT OUTER JOIN expenses_category_assigned_to_users as ass ON exp.expense_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND date_of_expense BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_expense ";
			 }
			 if (isset ($_POST['inc_category'])) {
				 $_SESSION['inc_category'] = $_POST['inc_category'];
				 $sqlIncomesQuery = $this->selectRecordsFromIncomeCategory();
				 
			 } else  {
				$sqlIncomesQuery ="SELECT * FROM incomes as inc LEFT OUTER JOIN incomes_category_assigned_to_users as ass ON inc.income_category_assigned_to_user_id = ass.id WHERE ass.user_id='$user_id' AND date_of_income BETWEEN '$from' AND '$to' AND currency = '$currency' ORDER BY date_of_income ";
			 }
			$currencyQuery = "SELECT acronym FROM currency_assigned_to_users WHERE id='$currency'";
			 
 			$this->incomesQuery = $this->returnResultsFromToDatabase($sqlIncomesQuery);
			$this->expensesQuery = $this->returnResultsFromToDatabase($sqlExpensesQuery);
			$this->currency_acronym = $this->returnResultsFromToDatabase($currencyQuery)->fetchColumn();
			
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
			$categories = $this->getUserCategories('currency_assigned_to_users');
			return $categories;
		}
		
		function getUserCategories($table_name) {
			$user_id = $this->user_id;
			$updateQuery = $this->connection->query("SELECT * FROM $table_name WHERE user_id='$user_id'");
			$categories = $updateQuery->fetchAll();
			return $categories;
		}
		
		function addNewCurrency() {
			$user_id = $this->user_id;
			$new_currency = $this->expense->getCurrencyNewCat();
			$new_currency_name = $this->expense->getCurrencyNewName();
				
			$result = $this->connection->query("SELECT * FROM currency_assigned_to_users WHERE acronym='$new_currency' AND user_id='$user_id'");
			if ($result->rowCount()) {
				$_SESSION['e_category'] = "The given currency already exists. Please, specify different.";
				$this->saveDataInSession();
				header('Location: addIncome.php');
			} else {
				$queryCurrency = $this->connection->prepare("INSERT INTO currency_assigned_to_users VALUES (NULL, :user_id, :acronym, :name)");
				$queryCurrency->execute([ $user_id, $new_currency, $new_currency_name ]);
				$queryCurrencyId =$this->connection->query("SELECT id FROM currency_assigned_to_users WHERE acronym='$new_currency' AND user_id='$user_id'");
				$currency_id = $queryCurrencyId->fetchColumn();
				
				return $currency_id;
				
			}
		}
		
		function addNewCategory() {
			$user_id = $this->user_id;
			$new_category = $_POST['new_category'];
				
			$result = $this->connection->query("SELECT * FROM expenses_category_assigned_to_users WHERE name='$new_category' AND user_id='$user_id'");
			if ($result->rowCount()) {
				$_SESSION['e_category'] = "The given category already exists. Please, specify different.";
				$this->saveDataInSession();
				header('Location: addIncome.php');
			} else {
				$categoryQuery = $this->connection->prepare("INSERT INTO expenses_category_assigned_to_users VALUES (NULL, :user_id, :name)");
				$categoryQuery->execute([ $user_id, $new_category ]);
				$categoryQueryId =$this->connection->query("SELECT id FROM expenses_category_assigned_to_users WHERE name='$new_category' AND user_id='$user_id'");
				$category_id = $categoryQueryId->fetchColumn();
				
				return $category_id;
			
			}
		}
		
	
};



