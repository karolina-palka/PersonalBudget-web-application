<?php

require_once "Database.php";

		Class Finance {
			protected $user_id;
			protected $amount;
			protected $finance_date;
			protected $comment;
			protected $currency;
			
			function getUsername() {
				$this->login =  $_SESSION['username'];
				return $this->login;
			}
			function getUserId() {
				$this->user_id = $_SESSION['logged_id'];
				return $this->user_id;
			}
			
			function getAmount() {
				$this->amount =  filter_input(INPUT_POST, 'amount');
				if ($this->amount<0) {
					$this->amount = - $this->amount;
				}
				return $this->amount;
			}
			function getFinanceDate() {
				$this->finance_date =  filter_input(INPUT_POST, 'finance_date');
				return $this->finance_date;
			}
			function getComment() {
				$this->comment =  filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
				return $this->comment;
			}
			function getCurrencyCat() {
				$this->currency_category =  filter_input(INPUT_POST, 'currency_category', FILTER_SANITIZE_STRING);
				return $this->currency_category;
			}
			function getCurrencyNewCat() {
				$this->new_currency =  filter_input(INPUT_POST, 'currency_cat', FILTER_SANITIZE_STRING);
				return $this->new_currency;
			}
			function getCurrencyNewName() {
				$this->new_currency_name =  filter_input(INPUT_POST, 'currency_name', FILTER_SANITIZE_STRING);
				return $this->new_currency_name;
			}
		};
		
		
		Class Income extends Finance {
		
			private $income_category;
			
			function getIncomeCategory() {
				$this->income_category = filter_input(INPUT_POST, 'category');
				return $this->income_category;
			}
			
	};
	
	Class Expense extends Finance {
		
			private $expense_category;
			private $payment_method;
			
			function getExpenseCategory() {
				$this->expense_category = filter_input(INPUT_POST, 'category');
				return $this->expense_category;
			}
			function getPaymentMethod() {
				$this->payment_method = filter_input(INPUT_POST, 'payment_method');
				return $this->payment_method;
			}
		
	};

	Class IncomeManager {
		
		private $income;
		private $connection;
		function __construct() {
			$this->income = new Income();
			$db = new Database();
			$this->connection = $db->createConnection();
		}
		function getIncomeData() {
				return $this->income;
			}
		function saveDataInSession() {
				$_SESSION['amount'] = $this->income->getAmount();
				$_SESSION['comment'] = $this->income->getComment();
			}
		function unsaveDataInSession() {
			if(isset($_SESSION['amount'])) unset ($_SESSION['amount']);
			if(isset($_SESSION['comment'])) unset ($_SESSION['comment']);
		}
		
		function addNewIncome() {
			$user_id = $_SESSION['logged_id'];
			$amount = $this->income->getAmount();
			$income_date = $this->income->getFinanceDate();
			$comment = $this->income->getComment();
			$category = $this->income->getIncomeCategory();
			$currency_category = $this->income->getCurrencyCat();
			
			
			if (isset($_POST['currency_cat'])) {
			
				$new_currency = $this->income->getCurrencyNewCat();
				$new_currency_name = $this->income->getCurrencyNewName();
				
				$result = $this->connection->query("SELECT * FROM currency_category_assigned_to_users WHERE acronym='$new_currency' AND user_id='$user_id'");
					if ($result->rowCount()) {
						$_SESSION['e_email'] = "The given currency already exists. Please, specify different.";
						$this->saveDataInSession();
						header('Location: addIncome.php');
					} else {
						$queryCurrency = $this->connection->prepare("INSERT INTO currency_assigned_to_users VALUES (NULL, :user_id, :acronym, :name)");
						$queryCurrency->execute([ $user_id, $new_currency, $new_currency_name ]);
						$queryCurrencyId =$this->connection->query("SELECT id FROM currency_assigned_to_users WHERE acronym='$new_currency' AND user_id='$user_id'");
						$currency_id = $queryCurrencyId->fetchColumn();
						
						$queryIncomes = $this->connection->prepare('INSERT INTO incomes VALUES (NULL, :user_id, :income_category_assigned_to_user_id, :amount, :currency, :date_of_income, :income_comment )');
						$queryIncomes->execute([ $user_id, $category, $amount, $currency_id, $income_date, $comment ]);
						$_SESSION['done'] = "Your income and new currency has been successfully saved.";
						$this->unsaveDataInSession();
					}
			} else {
			
				$query = $this->connection->prepare('INSERT INTO incomes VALUES (NULL, :user_id, :income_category_assigned_to_user_id, :amount, :currency, :date_of_income, :income_comment )');
				$query->execute([ $user_id, $category, $amount, $currency_category, $income_date, $comment ]);
				$_SESSION['done'] = "Your income has been successfully saved.";
				$this->unsaveDataInSession();
			}
		}
	};

	Class ExpenseManager {
		
		private $expense;
		private $connection;
		private $user_id;
		
		function __construct() {
			$this->expense = new Expense();
			$db = new Database();
			$this->connection = $db->createConnection();
			$this->user_id = $_SESSION['logged_id'];
		}
		function getExpenseData() {
				return $this->expense;
				
			}
		function saveDataInSession() {
				$_SESSION['amount'] = $this->expense->getAmount();
				$_SESSION['finance_date'] = $this->expense->getFinanceDate();
				$_SESSION['comment'] = $this->expense->getComment();
				$_SESSION['category'] = $this->expense->getExpenseCategory();
				$_SESSION['payment_method'] = $this->expense->getPaymentMethod();
			}
		function unsaveDataInSession() {
			if(isset($_SESSION['amount'])) unset ($_SESSION['amount']);
			if(isset($_SESSION['comment'])) unset ($_SESSION['comment']);
			
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
		
		
		function addNewExpense() {
			
			$user_id = $this->user_id;
			$amount = $this->expense->getAmount();
			$expense_date = $this->expense->getFinanceDate();
			$comment = $this->expense->getComment();
			$category_id = $this->expense->getExpenseCategory();
			$payment_id =$this->expense->getPaymentMethod();
			$currency_id = $this->expense->getCurrencyCat();
			
			
			$query = $this->connection->prepare('INSERT INTO expenses VALUES (NULL, :user_id, :expense_category_assigned_to_user_id, :payment_method_assigned_to_user_id, :amount, :currency_category, :date_of_expense, :comment )');
			$query->execute([ $user_id, $category_id, $payment_id, $amount, $currency_id, $expense_date, $comment ]);
			$_SESSION['done'] = "Your expense has been successfully saved.";
			$this->unsaveDataInSession();
			
		}
	}
?>