<?php
session_start(); 
// Start PHP session

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Display username
$username = $_SESSION['username'];
?>

<!--html code to display the username after logging in-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?></h2>
    
    <!--click link to log out and ternimate session-->
    <a href="logout.php">Logout</a>
</body>
</html>
