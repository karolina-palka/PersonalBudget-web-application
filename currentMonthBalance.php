<?php
 session_start();
 $_SESSION['current'] = "checked";
 $_SESSION['previous'] = "disabled";
 $_SESSION['chosen'] = "disabled";
 
 header('Location: showBalance.php');
 exit();
 
 