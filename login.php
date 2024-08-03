<?php
session_start();

// $servername = "localhost:3307";
// $username = "root";
// $password = "";
// $dbname = "teaching";

include ("./config/config.php");

// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Create connection
// $con = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Prepare and execute SQL query
$stmt = $con->prepare("SELECT id, email, password FROM student WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $db_email, $db_password);
$stmt->fetch();
$stmt->close();

if ($db_email && password_verify($password, $db_password)) {
    // Start session and store student ID
    $_SESSION['id'] = $id;
    header("Location: index.php");
    exit();
} else {
    echo "<script>alert('wrong credential');</script>";
}

$con->close();
