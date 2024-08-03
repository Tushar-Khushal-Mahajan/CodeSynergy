<?php
// Database connection
include ("./config/config.php");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get file ID from query parameter
$file_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($file_id > 0) {
    // Fetch file content from the database
    $stmt = $con->prepare("SELECT file_path FROM pdf_files WHERE id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($content);
    $stmt->fetch();
    $stmt->close();

    if ($content) {
        // Display file content in an iframe
        echo '<iframe src="data:application/pdf;base64,' . base64_encode($content) . '" class="file-viewer"></iframe>';
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid file ID.';
}

$con->close();
?>
