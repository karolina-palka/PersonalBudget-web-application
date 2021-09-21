<?php
		Class Finance {
			protected $user_id;
			protected $amount;
			protected $finance_date;
			protected $comment;
			
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
		function __construct() {
			$this->income = new Income();
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
	};

	Class ExpenseManager {
		
		private $expense;
		function __construct() {
			$this->expense = new Expense();
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
	};
?>