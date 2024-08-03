<?php
session_start();
include ("./config/config.php");

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    echo "Error: User not logged in.";
    exit();
}

// Retrieve the user's ID
$userId = $_SESSION['id'];

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $code = $_POST['code'];

    // Check for uploaded file
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Get the file content
        $photo = file_get_contents($_FILES['photo']['tmp_name']);

        // Insert code submission into the database
        $stmt = $con->prepare("INSERT INTO code_submissions (user_id, title, description, code, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssb", $userId, $title, $description, $code, $photo);
        $stmt->send_long_data(4, $photo); // Use send_long_data to handle large BLOBs

        if ($stmt->execute()) {
            echo "Success: Code submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: No file uploaded or file upload error.";
    }
} else {
    echo "Error: Invalid request method.";
}

$con->close();
?>
