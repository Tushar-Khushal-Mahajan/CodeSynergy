<?php
session_start();
include ("./config/config.php"); // include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iss", $userId, $title, $content);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $con->error]);
    }

    $stmt->close();
    $con->close();
}
?>
