<?php
session_start(); 
// Starting PHP session

// Include database connection file (conn_db.php)
require_once 'conn_db.php';

// Function to validate user login
function login($username, $password, $conn) {
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    //replace database table 'users' with actual table same applies to the entity names
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // result if User exists, then setting session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        return true;
    } else {
        // result if user does not exist or invalid credentials
        return false;
    }
}

// Checking if the login form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Creating a Database instance
    $database = new Database();
    $connection = $database->getConnection();

    // Calling the login function
    if (login($username, $password, $connection)) {
        // Redirect user to home page
        header("Location: home.php");
        exit;
    } else {
        // Display an error message
        $error = "Invalid username or password.";
    }
}
?>

<!--html code to help with testing the login code-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
