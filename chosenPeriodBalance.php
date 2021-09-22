<?php
 session_start();
 $_SESSION['current'] = "disabled";
 $_SESSION['previous'] = "disabled";
 $_SESSION['chosen'] = "checked";
 
 header('Location: showBalance.php');
 exit();
 
 