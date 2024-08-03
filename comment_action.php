<?php
session_start();
include ("./config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $submissionId = $_GET['id']; // Pass the submission ID from the URL
    $userId = $_SESSION['id'];

    // Insert comment into the database
    $sql = "INSERT INTO comments (submission_id, user_id, comment) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iis", $submissionId, $userId, $comment);
    $stmt->execute();

    // Fetch the new comment details
    $newCommentId = $stmt->insert_id;
    $sql = "SELECT comments.id, comments.comment, student.name, 
            (SELECT COUNT(*) FROM likes WHERE likes.comment_id = comments.id) as like_count 
            FROM comments 
            JOIN student ON comments.user_id = student.id 
            WHERE comments.id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $newCommentId);
    $stmt->execute();
    $commentResult = $stmt->get_result();
    $comment = $commentResult->fetch_assoc();

    // Output the new comment HTML
    echo '<div class="comment">
            <p><strong>' . htmlspecialchars($comment['name']) . ':</strong> ' . htmlspecialchars($comment['comment']) . '</p>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="like_comment_id" value="' . $comment['id'] . '">
                <button type="submit" class="like-btn"><i class="bi bi-hand-thumbs-up"></i></button>
                <span class="like-count">' . $comment['like_count'] . ' Likes</span>
            </form>
        </div>';
}
?>
