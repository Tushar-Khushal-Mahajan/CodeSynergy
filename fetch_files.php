<?php
session_start();
include ("./config/config.php"); // Assuming 'db.php' includes database connection code

$studentId = $_SESSION['id'];

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the student ID is set
if (!$studentId) {
    echo "Error: Student ID not set.";
    exit();
}

$action = $_GET['action'] ?? '';
$fileName = $_POST['fileName'] ?? '';

// Handle file deletion
if ($action === 'delete') {
    $stmt = $con->prepare("DELETE FROM files WHERE name = ? AND student_id = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }
    $stmt->bind_param("si", $fileName, $studentId);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} elseif ($fileName) {
    // Fetch file content
    $stmt = $con->prepare("SELECT content FROM files WHERE name = ? AND student_id = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }
    $stmt->bind_param("si", $fileName, $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();
    echo $file['content'] ?? '';
    $stmt->close();
} else {
    // Fetch file names
    $stmt = $con->prepare("SELECT name FROM files WHERE student_id = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row['name'];
    }

    echo json_encode($files);
}

$con->close();
?>
