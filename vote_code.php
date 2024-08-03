<?php
session_start();
include ("./config/config.php");

if (!isset($_SESSION['id'])) {
    echo 'error: not logged in';
    exit();
}

$userId = $_SESSION['id'];
$submissionId = $_POST['id'] ?? '';

if (empty($submissionId)) {
    echo 'error: no submission ID';
    exit();
}

$sqlCheckVote = "SELECT * FROM user_votes WHERE user_id = ? AND code_submission_id = ?";
$stmtCheckVote = $con->prepare($sqlCheckVote);

if ($stmtCheckVote === false) {
    echo 'error: prepare failed for check vote';
    exit();
}

$stmtCheckVote->bind_param("ii", $userId, $submissionId);
$stmtCheckVote->execute();
$resultCheckVote = $stmtCheckVote->get_result();

if ($resultCheckVote->num_rows > 0) {
    echo '<script>alert("already_voted")</script>';
    exit();
}


$sqlUpdateVotes = "UPDATE code_submissions SET votes = votes + 1 WHERE id = ?";
$stmtUpdateVotes = $con->prepare($sqlUpdateVotes);

if ($stmtUpdateVotes === false) {
    echo 'error: prepare failed for update votes';
    exit();
}

$stmtUpdateVotes->bind_param("i", $submissionId);

if ($stmtUpdateVotes->execute()) {

    $sqlInsertVote = "INSERT INTO user_votes (user_id, code_submission_id) VALUES (?, ?)";
    $stmtInsertVote = $con->prepare($sqlInsertVote);

    if ($stmtInsertVote === false) {
        echo 'error: prepare failed for insert vote';
        exit();
    }

    $stmtInsertVote->bind_param("ii", $userId, $submissionId);
    
    if ($stmtInsertVote->execute()) {
        echo 'success';
    } else {
        echo 'error: execute failed for insert vote';
    }

    $stmtInsertVote->close();
} else {
    echo 'error: execute failed for update votes';
}

$stmtCheckVote->close();
$stmtUpdateVotes->close();
$con->close();
?>
