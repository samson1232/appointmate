<?php
    session_start();
    include 'db_connection.php';


    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $accessRight = $_POST['access-right'];
    $currentUser = $_SESSION["user_id"];

    $accessRightsMap = [
        'admin' => 1,
        'Convenor' => 2,
        'Attendee' => 3
    ];
    $accessRightId = $accessRightsMap[$accessRight];


    $checkUserSql = "SELECT * FROM user WHERE user_name = ? OR user_email = ?";
    $checkStmt = $conn->prepare($checkUserSql);
    $checkStmt->bind_param('ss', $username, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "User already exist.";
        $_SESSION['msg_type'] = "danger";
        header("Location: userManagement.php?page=accountCreate");
        exit;
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (user_name, user_password, user_email, access_right_id, amended_by_ref) 
            VALUES (?, ?, ?, ?, ?)";

    $sqlStatement = $conn->prepare($sql);

    $sqlStatement->bind_param('sssii', $username, $hashedPassword, $email, $accessRightId, $currentUser);

    if ($sqlStatement->execute()) {
        $_SESSION['message'] = "User successfully created.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "There was an error creating the user.";
        $_SESSION['msg_type'] = "danger";
    }

    $conn->close();
    header("Location: userManagement.php?page=accountCreate");
    exit();
?>
