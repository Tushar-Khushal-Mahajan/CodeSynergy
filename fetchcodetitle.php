<?php
session_start();
include ("./config/config.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

$userId = $_SESSION['id'];

// Fetch all code submissions with user details, ordered by votes
$sql = "SELECT code_submissions.id, code_submissions.title, code_submissions.votes, student.name, student.email 
        FROM code_submissions 
        JOIN student ON code_submissions.user_id = student.id 
        ORDER BY code_submissions.votes DESC";
$result = $con->query($sql);
$submissions = $result->fetch_all(MYSQLI_ASSOC);

// Fetch user votes
$sqlVotes = "SELECT id FROM code_submissions WHERE user_id = ?";
$stmt = $con->prepare($sqlVotes);
$stmt->bind_param("i", $userId);
$stmt->execute();
$resultVotes = $stmt->get_result();
$userVotes = $resultVotes->fetch_all(MYSQLI_ASSOC);
$votedSubmissions = array_column($userVotes, 'code_submission_id');

$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Submissions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Exo', sans-serif;
            background: #f8f9fa;
        }
        .container {
            margin-top: 40px;
        }
        .submission-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .submission-box:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .submission-box h3 {
            display: inline-block;
            margin-right: 10px;
        }
        .submission-box h6 {
            color: #6c757d;
        }
        .vote-button {
            position: absolute;
            right: 20px;
            top: 20px;
        }
        .submission-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            margin-right: 10px;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .submission-box {
            animation: fadeInUp 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Code Submissions</h1>
        <div class="mb-4">
            <input type="text" id="search" class="form-control" placeholder="Search by title">
        </div>
        <div id="submissions">
            <?php 
            $index = 1;
            foreach($submissions as $row): 
                $hasVoted = in_array($row['id'], $votedSubmissions);
            ?>
                <div class="submission-box" onclick="window.location.href='read.php?id=<?= $row['id'] ?>'">
                    <span class="submission-number"><?= $index++ ?></span>
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <h6><strong>By:</strong> <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</h6>
                    <button class="btn btn-primary vote-button" onclick="voteCode(event, <?= $row['id'] ?>, <?= $hasVoted ? 'true' : 'false' ?>)">
                        <?= $hasVoted ? 'Voted' : 'Vote' ?> (<?= $row['votes'] ?>)
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const submissionsContainer = document.getElementById('submissions');
        const submissions = <?= json_encode($submissions) ?>;
        
        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const filteredSubmissions = submissions.filter(submission => 
                submission.title.toLowerCase().includes(searchTerm)
            );

            renderSubmissions(filteredSubmissions);
        });

        function renderSubmissions(submissions) {
            submissionsContainer.innerHTML = '';
            let index = 1;
            submissions.forEach(submission => {
                const hasVoted = <?= json_encode($votedSubmissions) ?>.includes(submission.id);
                const submissionBox = document.createElement('div');
                submissionBox.className = 'submission-box';
                submissionBox.onclick = () => window.location.href = `read.php?id=${submission.id}`;
                submissionBox.innerHTML = `
                    <span class="submission-number">${index++}</span>
                    <h3>${escapeHtml(submission.title)}</h3>
                    <h6><strong>By:</strong> ${escapeHtml(submission.name)} (${escapeHtml(submission.email)})</h6>
                    <button class="btn btn-primary vote-button" onclick="voteCode(event, ${submission.id}, ${hasVoted})">
                        ${hasVoted ? 'Voted' : 'Vote'} (${submission.votes})
                    </button>
                `;
                submissionsContainer.appendChild(submissionBox);
            });
        }

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function voteCode(event, id, hasVoted) {
            event.stopPropagation(); // Prevents the click event from propagating to the parent element
            if (hasVoted) {
                alert('You already voted for this submission.');
                return;
            }

            fetch('vote_code.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': id
                })
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'success') {
                    alert('Vote recorded successfully.');
                    location.reload(); // Refresh the page to update the vote count
                } else {
                    alert('You Alredy Vote...!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Initial render
        renderSubmissions(submissions);
    </script>
</body>
</html>
