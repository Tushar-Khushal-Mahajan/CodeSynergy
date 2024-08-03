<?php
session_start();
include ("./config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like_comment_id'])) {
    $commentId = $_POST['like_comment_id'];
    $userId = $_SESSION['id'];

    // Check if user has already liked this comment
    $sql = "SELECT COUNT(*) FROM likes WHERE comment_id = ? AND user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $commentId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $hasLiked = $result->fetch_column() > 0;

    if (!$hasLiked) {
        // Insert like into the database
        $sql = "INSERT INTO likes (comment_id, user_id) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $commentId, $userId);
        $stmt->execute();
    }

    // Fetch the updated like count
    $sql = "SELECT COUNT(*) FROM likes WHERE comment_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $commentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $likeCount = $result->fetch_column();

    // Output the updated like count
    echo $likeCount;
}
?>
