<?php
include ("./config/config.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];



if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $con->prepare("INSERT INTO student (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    echo '<script>alert("Registration Done Successfully!!");</script>';
    include "login.html";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
