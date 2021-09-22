<?php
 session_start();
 $_SESSION['current'] = "disabled";
 $_SESSION['previous'] = "checked";
 $_SESSION['chosen'] = "disabled";
 
 header('Location: showBalance.php');
 exit();
 
 