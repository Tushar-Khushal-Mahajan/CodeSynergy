<?php
session_start();

include ("./config/config.php");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['id'])) {
    die("Student not logged in");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Adjust column name to match your database schema
    $sql = "SELECT name, file_path FROM pdf_files WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $file_path);
    $stmt->fetch();
    $stmt->close();
    $con->close();

    if ($file_path) {
        // Read the file content from the database
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($name) . '"');
        header('Content-Length: ' . strlen($file_path));
        echo $file_path;
        exit;
    } else {
        http_response_code(404);
        echo "File not found.";
    }
} else {
    http_response_code(400);
    echo "No file ID specified.";
}
