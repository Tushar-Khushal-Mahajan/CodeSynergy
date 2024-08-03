<?php
session_start();
include ("./config/config.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

$submissionId = $_GET['id'] ?? '';

if (empty($submissionId)) {
    echo "Error: No submission ID provided.";
    exit();
}

// Fetch the submission details
$sql = "SELECT code_submissions.title, code_submissions.description, code_submissions.code, code_submissions.photo, student.name, student.email 
        FROM code_submissions 
        JOIN student ON code_submissions.user_id = student.id 
        WHERE code_submissions.id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $submissionId);
$stmt->execute();
$result = $stmt->get_result();
$submission = $result->fetch_assoc();

if (!$submission) {
    echo "Error: Submission not found.";
    exit();
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
        $userId = $_SESSION['id'];
        $sql = "INSERT INTO comments (submission_id, user_id, comment) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iis", $submissionId, $userId, $comment);
        $stmt->execute();
    }

    if (isset($_POST['like_comment_id'])) {
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
            $sql = "INSERT INTO likes (comment_id, user_id) VALUES (?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $commentId, $userId);
            $stmt->execute();
        }
    }
}

// Fetch comments sorted by like count
$sql = "SELECT comments.id, comments.comment, student.name, 
        (SELECT COUNT(*) FROM likes WHERE likes.comment_id = comments.id) as like_count 
        FROM comments 
        JOIN student ON comments.user_id = student.id 
        WHERE comments.submission_id = ?
        ORDER BY like_count DESC"; // Order comments by like count
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $submissionId);
$stmt->execute();
$commentsResult = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($submission['title']) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" rel="stylesheet">

    <style>
body {
    font-family: 'Exo', sans-serif;
    background: #f8f9fa;
}

.container {
    margin-top: 40px;
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.container:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #343a40;
    transition: color 0.3s ease;
    align-items: center;
}

h1:hover {
    color: #007bff;
}

p {
    font-size: 1.1rem;
    color: #495057;
}

.code-container,
.img-container {
    max-height: 300px;
    overflow: auto;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    margin-top: 20px;
    transition: all 0.3s ease;
    background: #e9ecef;
}

.code-container::before,
.img-container::before {
    content: attr(data-title);
    position: absolute;
    top: -10px;
    left: 20px;
    background: #007bff;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: background 0.3s ease;
}

.code-container:hover::before {
    background: #0056b3;
}

.img-container:hover::before {
    background: #0056b3;
}

pre {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-size: 1rem;
    color: #212529;
    transition: background 0.3s ease, color 0.3s ease;
}

pre:hover {
    background: #343a40;
    color: #f8f9fa;
}

.img-container {
    position: relative;
    background: #f8f9fa;
}

.img-container img {
    width: 100%;
    height: auto;
    border-radius: 5px;
}

.img-container .popup-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.7);
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}

.img-container .popup-btn:hover {
    background: rgba(255, 255, 255, 1);
    transform: scale(1.1);
}

@media (max-width: 768px) {
    h1 {
        font-size: 2rem;
    }

    p {
        font-size: 1rem;
    }

    .code-container,
    .img-container {
        max-height: 200px;
    }
}

.comments-container {
    margin-top: 40px;
}

.comment {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    transition: background 0.3s ease;
}

.comment:hover {
    background: #e9ecef;
}

.comment p {
    margin: 0;
}

.like-btn {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.3s ease;
}

.like-btn:focus {
    outline: none;
}

.like-btn.clicked {
    color: #28a745;
}

.like-count {
    color: #495057;
    font-size: 0.9rem;
    margin-left: 10px;
}

.comment-form {
    margin-top: 20px;
}

.comment-form textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    transition: border-color 0.3s ease;
}

.comment-form textarea:focus {
    border-color: #007bff;
    outline: none;
}

.comment-form button {
    margin-top: 10px;
    padding: 10px 20px;
    border: none;
    background: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}

.comment-form button:hover {
    background: #0056b3;
    transform: scale(1.05);
   
}

    </style>
</head>
<body>
    <div class="container" data-aos="fade-up">
        <h1><?= htmlspecialchars($submission['title']) ?></h1>
        <p><strong>By:</strong> <?= htmlspecialchars($submission['name']) ?> <strong style=" margin-left: 2cm">Email: </strong><?= htmlspecialchars($submission['email']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($submission['description']) ?></p>
        <div class="row">
            <div class="col-md-6 code-container" data-aos="zoom-in">
                <pre><?= htmlspecialchars($submission['code']) ?></pre>
            </div>
            <div class="col-md-6 img-container" data-aos="zoom-in">
                <?php if ($submission['photo']) : ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($submission['photo']) ?>" alt="Code Photo">
                    <button class="popup-btn" data-toggle="modal" data-target="#photoModal">View Full Image</button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-container">
            <h2>Comments</h2>
            <?php while ($comment = $commentsResult->fetch_assoc()) : ?>
                <div class="comment">
                    <p><strong><?= htmlspecialchars($comment['name']) ?>:</strong> <?= htmlspecialchars($comment['comment']) ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="like_comment_id" value="<?= $comment['id'] ?>">
                        <button type="submit" class="like-btn"><i class="bi bi-hand-thumbs-up"></i></button>
                        <span class="like-count"><?= $comment['like_count'] ?> Likes</span>
                    </form>
                </div>
            <?php endwhile; ?>

            <form method="POST" class="comment-form">
                <textarea name="comment" placeholder="Add your comment here"></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Full Image Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Full Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="data:image/jpeg;base64,<?= base64_encode($submission['photo']) ?>" class="img-fluid" alt="Code Photo">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();

        $(document).ready(function() {
            // Handle comment submission
            $('.comment-form').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var formData = $form.serialize();
                var submissionId = '<?= $submissionId ?>'; // Pass the submission ID from PHP

                $.ajax({
                    url: 'comment_action.php?id=' + submissionId, // Append submission ID to URL
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Check for errors in response
                        if (response.includes('Error')) {
                            alert(response);
                        } else {
                            // Append the new comment to the comments section
                            $('.comments-container').append(response);
                            $form[0].reset(); // Reset the form
                        }
                    },
                    error: function() {
                        alert('An error occurred while submitting your comment.');
                    }
                });
            });

            // Handle like button click
            $(document).on('click', '.like-btn', function(e) {
                e.preventDefault();
                var $button = $(this);
                var commentId = $button.siblings('input[name="like_comment_id"]').val();

                $.ajax({
                    url: 'like_action.php',
                    type: 'POST',
                    data: {
                        like_comment_id: commentId
                    },
                    success: function(response) {
                        // Update the like count
                        $button.siblings('.like-count').text(response + ' Likes');
                    },
                    error: function() {
                        alert('An error occurred while liking the comment.');
                    }
                });
            });
        });
    </script>
</body>
</html>
