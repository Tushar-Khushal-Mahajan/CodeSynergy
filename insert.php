<?php
session_start();
include ("./config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_SESSION['id'];
    $fileName = $_POST['fileName'] ?? '';
    $codeContent = $_POST['codeContent'] ?? '';

    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if the student ID is set
    if (!$studentId) {
        echo "Error: Student ID not set.";
        exit();
    }

    // Check if the file name and code content are not empty
    if (empty($fileName) || empty($codeContent)) {
        echo "Error: File name or code content is empty.";
        exit();
    }

    // Prepare the SQL query
    $query = "INSERT INTO files (student_id, name, content) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content=?";
    $stmt = $con->prepare($query);

    // Check if the statement was prepared correctly
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind the parameters
    $stmt->bind_param("isss", $studentId, $fileName, $codeContent, $codeContent);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
