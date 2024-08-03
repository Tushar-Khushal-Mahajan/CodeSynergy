<?php
include ("./config/config.php");

$commentId = $_GET['id'] ?? '';

if (empty($commentId)) {
    echo "Error: No comment ID provided.";
    exit();
}

// Fetch comment details
$sql = "SELECT comments.comment, student.name, code_submissions.title
        FROM comments
        JOIN student ON comments.user_id = student.id
        JOIN code_submissions ON comments.submission_id = code_submissions.id
        WHERE comments.id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $commentId);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

if ($comment) {
    echo '<p><strong>' . htmlspecialchars($comment['name']) . '</strong> commented on <strong>' . htmlspecialchars($comment['title']) . '</strong>:<br>' . htmlspecialchars($comment['comment']) . '</p>';
} else {
    echo "Comment not found.";
}
?>
