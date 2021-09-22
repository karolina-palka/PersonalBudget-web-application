<?php

require_once "Database.php";

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
			private $isSafeToConnect;
			private $pass_hash;
			/*private $login;
			private $password;
			private $email;
			private $name;
			private $surname;
			private $phone_number;*/
			private $connection;
			
			public function __construct() {
				$this->user = new User;
				$this->isSafeToConnect = true;
				//$this->connection = DatabaseManager::connect();
				$db = new Database();
				$this->connection = $db->createConnection();
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
			function unsaveDataInSession() {
				if (isset($_SESSION['given_login'])) unset($_SESSION['given_login']);
				if (isset($_SESSION['given_email'])) unset($_SESSION['given_email']);
				if (isset($_SESSION['given_name'])) unset($_SESSION['given_name']);
				if (isset($_SESSION['given_surname'])) unset($_SESSION['given_surname']);
				if (isset($_SESSION['given_ph_number'])) unset($_SESSION['given_ph_number']);
			}
			/*function getDataFromForm() {
				$this->login = $this->user->getLogin();
				$this->password = $this->user->getPassword();
				$this->email = $this->user->getEmail();
				$this->name = $this->user->getName();
				$this->surname = $this->user->getSurname();
				$this->phone_number = $this->user->getPhoneNumber();
				
			}*/
			
			function validateLogin() {
				
				if ((strlen($this->user->getLogin())<3) || (strlen($this->user->getLogin())>20))
				{
					$this->isSafeToConnect = false;
					$_SESSION['e_login'] = "Login must be 3 to 20 characters long!";
					
					$this->saveDataInSession();
					header('Location: register.php');
				}
				if (ctype_alnum($this->user->getLogin())==false)
				{
					$this->isSafeToConnect = false;
					$_SESSION['e_login'] = "Login can only consist of letters and numbers";
					$this->saveDataInSession();
					header('Location: register.php');
				}
			}
			
			function validateEmail() {
				$emailB = filter_var($this->user->getEmail(), FILTER_SANITIZE_EMAIL);
				
				if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) ||($emailB!=$this->user->getEmail()))
				{
					$this->isSafeToConnect = false;
					$_SESSION['e_email'] = "Please specify your e-mail address appropriately.";
					$this->saveDataInSession();
					header('Location: register.php');
				}
				
			}
			
			function validatePassword() {
				if ((strlen($this->user->getPassword())<8) || (strlen($this->user->getPassword())>20))
				{
					$this->isSafeToConnect = false;
					$_SESSION['e_password'] = "Password must be 8 to 20 characters long!";
					$this->saveDataInSession();
					header('Location: register.php');
				}
						
				$this->pass_hash = password_hash($this->user->getPassword(), PASSWORD_DEFAULT);
				
			}
			
			function checkIfEmailAlreadyExists() {
				
				if ($this->isSafeToConnect) {
					$email = $this->user->getEmail();
					$result = $this->connection->query("SELECT * FROM users WHERE email='$email'");
						if ($result->rowCount()) {
							$_SESSION['e_email'] = "The given e-mail address already exists. Please, specify different.";
							
							$this->saveDataInSession();
							header('Location: register.php');
							return true;
					} else {
						return false;
					}
					
				}
			}
			
			function saveUserToDatabase() {
				
				if ($this->isSafeToConnect) {
					
					if (!($this->checkIfEmailAlreadyExists())) {
						
					$query = $this->connection->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email, :name, :surname, :phone_number )');
					$query->execute([$this->user->getLogin(), $this->pass_hash, $this->user->getEmail(), $this->user->getName(), $this->user->getSurname(), $this->user->getPhoneNumber() ]);
				
					$userQuery = $this->connection->query("SELECT id FROM users WHERE email='$this->email'");
					$user_id = $userQuery->fetchColumn();
					
					$table_name = "currency_assigned_to_".$user_id;
					
					$this->connection->query("CREATE TABLE $table_name ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, acronym VARCHAR(11) NOT NULL, name VARCHAR(50) NOT NULL)");
					$this->connection->query("INSERT INTO $table_name SELECT * FROM currency_default");
					
					$table_name = "incomes_category_assigned_to_".$user_id;
					$this->connection->query("CREATE TABLE $table_name ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL)");
					$this->connection->query("INSERT INTO $table_name SELECT * FROM incomes_category_default");
					
					$table_name = "expenses_category_assigned_to_".$user_id;
					$this->connection->query("CREATE TABLE $table_name LIKE expenses_category_default");
					$this->connection->query("INSERT INTO $table_name SELECT * FROM expenses_category_default");
					
					$table_name = "payment_methods_assigned_to_".$user_id;
					$this->connection->query("CREATE TABLE $table_name ( id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL)");
					$this->connection->query("INSERT INTO $table_name SELECT * FROM payment_methods_default");

					$this->unsaveDataInSession();
					}
					
				}
			}
			
			function logIn() {
				
			$this->unsaveDataInSession();
			$result = $this->connection->prepare('SELECT * FROM users WHERE email=:email');
			$result->bindValue(':email', $this->user->getEmail(), PDO::PARAM_STR);
			$result->execute();
		
			$user = $result->fetch();
			
			if($user && password_verify($this->user->getPassword(), $user['password'])) {
				$_SESSION['logged_id'] = $user['id'];
				$_SESSION['name'] = $user['name'];
				$_SESSION['login'] = $user['username'];
				unset($_SESSION['bad_attempt']);
				$this->unsaveDataInSession();
				
			} else {
				
				$_SESSION['bad_attempt'] = "E-mail or password are incorrect. Please, specify them correctly.";
				$_SESSION['given_email'] = $_POST['email'];
				header('Location: login.php');
				exit();
			}
		}
	}
	

?>