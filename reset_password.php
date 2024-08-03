<?php

include ("./config/config.php");


$email = $_POST['email'];
$password = $_POST['password'];



if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];


    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $con->prepare("UPDATE student SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    if ($stmt->execute()) {
        echo "Password has been updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$con->close();
?>
