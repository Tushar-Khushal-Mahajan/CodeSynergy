<?php
session_start();

// Database connection
include ("./config/config.php");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Ensure student is logged in
if (!isset($_SESSION['id'])) {
    die("Student not logged in");
}
$student_id = $_SESSION['id'];

// Fetch PDF files from the database ordered by votes
$sql = "SELECT id, name, language, area, votes FROM pdf_files ORDER BY votes DESC";
$result = $con->query($sql);

$files = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
}

// Fetch distinct areas and languages for dropdowns
$areas = $con->query("SELECT DISTINCT area FROM pdf_files");
$languages = $con->query("SELECT DISTINCT language FROM pdf_files");

$distinctAreas = [];
$distinctLanguages = [];

if ($areas->num_rows > 0) {
    while ($row = $areas->fetch_assoc()) {
        $distinctAreas[] = $row['area'];
    }
}

if ($languages->num_rows > 0) {
    while ($row = $languages->fetch_assoc()) {
        $distinctLanguages[] = $row['language'];
    }
}

// Fetch voted PDF IDs for the current student
$voted_pdfs = [];
$vote_query = $con->query("SELECT pdf_id FROM pdf_votes WHERE student_id = $student_id");
if ($vote_query->num_rows > 0) {
    while ($row = $vote_query->fetch_assoc()) {
        $voted_pdfs[] = $row['pdf_id'];
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Files</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <style>
        .pdf-list {
            list-style-type: none;
            padding: 0;
        }
        .pdf-list li {
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            cursor: pointer;
        }
        .pdf-list span {
            flex: 1;
        }
        .pdf-list button {
            margin-left: 10px;
        }
        .vote-btn {
            margin-left: 10px;
            background-color: #4CAF50;
            color: white;
        }
        .pdf-list li:hover {
            background-color: #f0f0f0;
        }
        .modal-dialog {
            max-width: 80%;
        }
        .modal-body {
            padding: 0;
        }
        .file-viewer {
            width: 100%;
            height: 500px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Available PDF Files</h1>
        <!-- Filter Section -->
        <div class="mb-4">
            <h5>Filter Files</h5>
            <form id="filterForm">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="area">Area</label>
                        <select class="form-control" id="area" name="area">
                            <option value="">Select Area</option>
                            <?php foreach ($distinctAreas as $area): ?>
                                <option value="<?php echo htmlspecialchars($area); ?>"><?php echo htmlspecialchars($area); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="language">Language</label>
                        <select class="form-control" id="language" name="language">
                            <option value="">Select Language</option>
                            <?php foreach ($distinctLanguages as $language): ?>
                                <option value="<?php echo htmlspecialchars($language); ?>"><?php echo htmlspecialchars($language); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary" onclick="applyFilter()">Apply Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- PDF List -->
        <ul class="pdf-list" data-aos="fade-up">
            <?php foreach ($files as $index => $file): ?>
                <li data-file-id="<?php echo $file['id']; ?>" data-area="<?php echo htmlspecialchars($file['area']); ?>" data-language="<?php echo htmlspecialchars($file['language']); ?>">
                    <span><?php echo ($index + 1) . '. ' . htmlspecialchars($file['name']); ?></span>
                    <div>
                        <button class="btn btn-secondary" onclick="openFileInModal('<?php echo htmlspecialchars($file['id']); ?>')">View</button>
                        <button class="btn btn-success" onclick="downloadFile('<?php echo htmlspecialchars($file['id']); ?>')">Download</button>
                        <button class="btn vote-btn" onclick="voteFile('<?php echo htmlspecialchars($file['id']); ?>')" <?php echo in_array($file['id'], $voted_pdfs) ? 'disabled' : ''; ?>>Vote (<?php echo $file['votes']; ?>)</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Modal for File Viewing -->
    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Viewer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="fileViewer" class="file-viewer"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();

        function applyFilter() {
            const area = document.getElementById('area').value.toLowerCase();
            const language = document.getElementById('language').value.toLowerCase();
            const items = document.querySelectorAll('.pdf-list li');

            items.forEach(item => {
                const itemArea = item.dataset.area.toLowerCase();
                const itemLanguage = item.dataset.language.toLowerCase();
                const show = (!area || itemArea.includes(area)) && (!language || itemLanguage.includes(language));
                item.style.display = show ? '' : 'none';
            });
        }

        function openFileInModal(fileId) {
            fetch('view_file.php?id=' + fileId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('fileViewer').innerHTML = data;
                    $('#fileModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the file.');
                });
        }

        function downloadFile(fileId) {
            window.location.href = 'download.php?id=' + fileId;
        }

        function voteFile(id) {
            fetch('vote.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'vote_pdf_id=' + encodeURIComponent(id),
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Vote recorded") {
                    alert('Thank you for your vote!');
                    const button = document.querySelector(`button[onclick="voteFile('${id}')"]`);
                    const currentVotes = parseInt(button.textContent.match(/\d+/)[0]);
                    button.textContent = `Vote (${currentVotes + 1})`;
                    button.disabled = true;
                } else {
                    alert('Error: ' + data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>
