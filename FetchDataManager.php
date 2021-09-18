<?php
		Class FetchDataManager {
			public static $login="karo";
			public static $password;
			public static $email;
			public static $name;
			public static $surname;
			public static $phone_number;
			
			function getLogin() {
				self::$login =  filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
				return self::$login;
			}
			function getPassword() {
				self::$password =  filter_input(INPUT_POST, 'password');
				return self::$password;
			}
			function getEmail() {
				self::$email =  filter_input(INPUT_POST, 'email');
				return self::$email;
			}
			function getName() {
				self::$name =  filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
				return self::$name;
			}
			function getSurname() {
				self::$surname =  filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
				return self::$surname;
			}
			function getPhoneNumber() {
				self::$phone_number =  filter_input(INPUT_POST, 'phone_number');
				return self::$phone_number;
			}
			/*function getPhoneNumber() {
				return self::$phone_number;
			}*/
			function saveDataInSession() {
				$_SESSION['given_login'] = self::getlogin();
				$_SESSION['given_email'] = self::getEmail();
				$_SESSION['given_name'] = self::getName();
				$_SESSION['given_surname'] = self::getSurname();
				$_SESSION['given_ph_number'] = self::getPhoneNumber();
			}
	};


?>