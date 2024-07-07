<?php
session_start();
include 'db_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE user_name = ?";
$sqlStatement = $conn->prepare($sql);
$sqlStatement->bind_param('s', $username);
$sqlStatement->execute();
$result = $sqlStatement->get_result();
$user = $result->fetch_assoc();
$isAccountDeactivated = $user['account_status'];
$verifyPassword = password_verify($password, $user['user_password']);

if ($isAccountDeactivated == 'inactive' && $verifyPassword)
{
    header("Location: login.php?error=deactivated");
    $conn->close();
    exit(); 
    
}
else
{
    if($user && $verifyPassword) {
        $_SESSION['user_name'] = $username;
        $_SESSION['access_right_id'] = $user['access_right_id'];
        $_SESSION['user_id'] = $user['user_id'];
    
        header("Location: login.php?success=loginSuccess");
        exit();
    } else {
        header("Location: login.php?error=loginFailed");
        $conn->close();
        exit();
    }

}



?>