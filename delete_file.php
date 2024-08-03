<?php
session_start();
include ("./config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_SESSION['id'];
    $fileName = $_POST['fileName'];

    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if the student ID is set
    if (!$studentId) {
        echo "Error: Student ID not set.";
        exit();
    }

    // Check if the file name is not empty
    if (empty($fileName)) {
        echo "Error: File name is empty.";
        exit();
    }

    $query = "DELETE FROM files WHERE student_id=? AND name=?";
    $stmt = $con->prepare($query);
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $stmt->bind_param("is", $studentId, $fileName);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>
