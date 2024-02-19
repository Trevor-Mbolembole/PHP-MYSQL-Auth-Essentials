<?php
session_start(); 
// Start PHP session

// Unset all session variables
$_SESSION = array();

//Terminate the user session
session_destroy();

// Redirect user to login page after logout
header("Location: login.php");
exit;
?>
