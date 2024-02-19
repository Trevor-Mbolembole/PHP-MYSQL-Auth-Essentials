<?php
session_start(); 
// Starting PHP session

// Include database connection file (conn_db.php)
require_once 'database.php';

// Function to generate a random 4-digit user ID
function generateUserID() {
    return mt_rand(1000, 9999);
}

// Function to handle profile picture upload
function uploadProfilePicture($file) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Checking if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        return "File is not an image.";
    }

    // Checking image file size
    if ($file["size"] > 500000) {
        return "Sorry, your file is too large.";
    }

    // Allowing only certain image file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return "Sorry, only JPG, JPEG, PNG files are allowed.";
    }

    // Checking if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return "Sorry, your file was not uploaded.";
    } else {
        // if everything is ok, trying to upload file
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return "Sorry, there was an error uploading your file.";
        }
    }
}

// Function to register user with profile picture
function registerUserWithProfilePic($fullname, $username, $phone, $email, $password, $profile_picture, $conn) {
    $fullname = $conn->real_escape_string($fullname);
    $username = $conn->real_escape_string($username);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $profile_picture = $conn->real_escape_string($profile_picture);
    $user_id = generateUserID();

    // Checking if username or email already exists
    $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        return "Username or email already exists.";
    }

    // Inserting user data into database
    $insert_query = "INSERT INTO users (user_id, full_name, username, phone_number, email, password, profile_picture) 
                     VALUES ('$user_id', '$fullname', '$username', '$phone', '$email', '$password', '$profile_picture')";
    if ($conn->query($insert_query) === TRUE) {
        return "User registered successfully.";
    } else {
        return "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

// Checking if the registration form is submitted
if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Uploading profile picture
    $profile_picture = uploadProfilePicture($_FILES['profile_picture']);

    // Creating a Database instance
    $database = new Database();
    $connection = $database->getConnection();

    // Calling the register function
    $message = registerUserWithProfilePic($fullname, $username, $phone, $email, $password, $profile_picture, $connection);
}
?>

<!--html code to help with testing the register with profile picture code-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register with Profile Picture</h2>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required><br><br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
