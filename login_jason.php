<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require("db.php"); 
$conn = mysqli_connect($host, $user, $passwd, $dbname);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;


    if ($username && $password) {
        // Escape the user input to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $username);

        // Prepare the SQL query without placeholders
        $query = "SELECT Password FROM user WHERE Username = '$username'";
        $result = mysqli_query($conn, $query);
        #echo($result);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['Password'];
                    echo($hashed_password);
                    echo($password);

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username; // Start the session
                    header("Location: calenderAdmin.html"); // Redirect to the admin page or other user-specific page
                    exit();
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No user found with that username.";
            }
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
    } else {
        echo "Username and password are required.";
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($conn);
?>
