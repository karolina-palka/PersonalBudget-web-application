<?php
		Class User {
			private $login;
			private $password;
			private $email;
			private $name;
			private $surname;
			private $phone_number;
			
			function getLogin() {
				$this->login =  filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
				return $this->login;
			}
			function getPassword() {
				$this->password =  filter_input(INPUT_POST, 'password');
				return $this->password;
			}
			function getEmail() {
				$this->email =  filter_input(INPUT_POST, 'email');
				return $this->email;
			}
			function getName() {
				$this->name =  filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
				return $this->name;
			}
			function getSurname() {
				$this->surname =  filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
				return $this->surname;
			}
			function getPhoneNumber() {
				$this->phone_number =  filter_input(INPUT_POST, 'phone_number');
				return $this->phone_number;
			}
			
		};
		
		
		Class UserManager {
		
			private $user;
			
			public function __construct() {
				$this->user = new User;
			}
			function getUserData() {
				return $this->user;
			}
			
			function saveDataInSession() {
				$_SESSION['given_login'] = $this->user->getLogin();
				$_SESSION['given_email'] = $this->user->getEmail();
				$_SESSION['given_name'] = $this->user->getName();
				$_SESSION['given_surname'] = $this->user->getSurname();
				$_SESSION['given_ph_number'] = $this->user->getPhoneNumber();
			}
	};


?>