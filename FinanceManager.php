<?php
		Class Finance {
			protected $user_id;
			//private $income_category;
			protected $amount;
			protected $finance_date;
			protected $comment;
			
			/*function getUserId() {
				$this->user_id =  filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
				return $this->login;
			}*/
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
				return $this->amount;
			}
			function getFinanceDate() {
				$this->finance_date =  filter_input(INPUT_POST, 'finance_date');
				return $this->finance_date;
			}
			
			/*function getPhoneNumber() {
				$this->phone_number =  filter_input(INPUT_POST, 'phone_number');
				return $this->phone_number;
			}*/
			
		};
		
		
		Class Income extends Finance {
		
			//private $finance;
			private $income_category;
			
			/*public function __construct() {
				$this->user = new User;
			}*/
			function getIncomeCategory() {
				$this->income_category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
				return $this->income_category;
			}
			function getComment() {
				$this->comment =  filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
				return $this->comment;
			}
			
			function saveDataInSession() {
				$_SESSION['given_login'] = $this->user->getLogin();
				$_SESSION['given_email'] = $this->user->getEmail();
				$_SESSION['given_name'] = $this->user->getName();
				$_SESSION['given_surname'] = $this->user->getSurname();
				$_SESSION['given_ph_number'] = $this->user->getPhoneNumber();
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
	};

?>