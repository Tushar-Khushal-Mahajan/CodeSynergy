<?php
session_start();

include("./config/config.php");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['id'])) {
    die("Student not logged in");
}

$student_id = $_SESSION['id'];

if (isset($_POST['vote_pdf_id'])) {
    $pdf_id = intval($_POST['vote_pdf_id']);

    // Check if the student has already voted
    $check_vote = $con->prepare("SELECT COUNT(*) FROM pdf_votes WHERE student_id = ? AND pdf_id = ?");
    $check_vote->bind_param("ii", $student_id, $pdf_id);
    $check_vote->execute();
    $check_vote->bind_result($count);
    $check_vote->fetch();
    $check_vote->close();

    if ($count > 0) {
        echo "You have already voted for this file.";
    } else {
        // Insert vote
        $insert_vote = $con->prepare("INSERT INTO pdf_votes (student_id, pdf_id) VALUES (?, ?)");
        $insert_vote->bind_param("ii", $student_id, $pdf_id);
        if ($insert_vote->execute()) {
            // Increment votes for the file
            $update_votes = $con->prepare("UPDATE pdf_files SET votes = votes + 1 WHERE id = ?");
            $update_votes->bind_param("i", $pdf_id);
            $update_votes->execute();
            echo "Vote recorded";
        } else {
            echo "Error recording vote.";
        }
        $insert_vote->close();
    }
} else {
    echo "No PDF ID specified.";
}

$con->close();
