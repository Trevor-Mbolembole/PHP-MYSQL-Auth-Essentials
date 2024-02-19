<?php
session_start(); // Start PHP session

// Include database connection file (conn_db.php)
require_once 'conn_db.php';

// Function to generate a random 4-digit user ID
function generateUserID() {
    return mt_rand(1000, 9999); // Generate a random number between 1000 and 9999
}
 // Hashing the password
 $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the registration form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Generate a random 4-digit user ID
    $user_id = generateUserID();

    // Create a Database instance
    $database = new Database();
    $connection = $database->getConnection();

    // Insert user data into the database
    $query = "INSERT INTO users (user_id, full_name, username, phone_number, email, password) VALUES ('$user_id', '$full_name', '$username', '$phone_number', '$email', '$hashed_password')";
    if ($connection->query($query) === TRUE) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
}
?>
<!--html code to help with testing the register without profile picture code-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
