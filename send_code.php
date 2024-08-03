<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo 'Unauthorized';
    exit();
}

include ("./config/config.php"); // Include your database connection file

$codeContent = $_POST['codeContent'];
$studentId = $_SESSION['id'];

// You may want to add further validation or sanitization for $codeContent here

// Example: Save code to a results table or perform another action
$stmt = $con->prepare("INSERT INTO results (student_id, code_content) VALUES (?, ?)");
$stmt->bind_param("is", $studentId, $codeContent);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$con->close();
?>
