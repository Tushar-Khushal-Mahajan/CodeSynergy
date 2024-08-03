<?php
session_start();
include ("./config/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);


$code = $_GET['code'] ?? '';

if (empty($code)) {
    echo "Error: No code provided.";
    exit();
}


$decodedCode = urldecode($code);
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Exo:400,700" rel="stylesheet">
    <style>
     * {
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Exo', sans-serif;
    overflow: hidden;
    position: relative;
}

.area {
    background: #4e54c8;
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);
    width: 100%;
    height: 100vh;
    overflow: hidden;
    position: relative;
}

.circles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 0;
}

.circles li {
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
}

.circles li:nth-child(1) {
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}

.circles li:nth-child(2) {
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles li:nth-child(3) {
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles li:nth-child(4) {
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles li:nth-child(5) {
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles li:nth-child(6) {
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles li:nth-child(7) {
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles li:nth-child(8) {
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles li:nth-child(9) {
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles li:nth-child(10) {
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}

@keyframes animate {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }
    100% {
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }
}

.context {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100vh;
    position: relative;
    z-index: 1;
}

.form-container {
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: rgba(60, 66, 87, 0.12) 0px 7px 14px 0px, rgba(0, 0, 0, 0.12) 0px 3px 6px 0px;
    max-width: 448px;
    width: 100%;
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.form-container:hover {
    transform: scale(1.02);
    box-shadow: rgba(84, 105, 212, 0.3) 0px 10px 20px, rgba(0, 0, 0, 0.2) 0px 6px 12px;
}

.form-container h1 {
    margin-bottom: 20px;
    color: #4e54c8;
    animation: text-fade-in 2s ease-in-out;
}

@keyframes text-fade-in {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.form-group label {
    margin-bottom: 10px;
    display: block;
    font-weight: 600;
    transition: color 0.3s ease;
}

.form-group label:hover {
    color: #4e54c8;
}

.form-group textarea {
    font-size: 16px;
    line-height: 28px;
    padding: 8px 16px;
    width: 100%;
    min-height: 44px;
    border: unset;
    border-radius: 4px;
    outline-color: rgba(84, 105, 212, 0.5);
    background-color: #ffffff;
    box-shadow: rgba(60, 66, 87, 0.16) 0px 0px 0px 1px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.form-group textarea:hover {
    transform: scale(1.05);
    box-shadow: rgba(84, 105, 212, 0.5) 0px 4px 8px;
}

.form-group textarea:focus {
    box-shadow: rgba(84, 105, 212, 0.7) 0px 0px 5px 2px;
}

.btn {
    margin-right: 10px;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary {
    background-color: rgb(84, 105, 212);
    border: none;
    color: #ffffff;
}

.btn-success {
    background-color: rgb(34, 193, 195);
    border: none;
    color: #ffffff;
}

.btn-secondary {
    background-color: rgb(108, 117, 125);
    border: none;
    color: #ffffff;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.btn:active {
    transform: translateY(1px);
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2);
}

    </style>
</head>
<body>
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="context">
            <div class="form-container">
                <h1>Code Submission</h1>
                <form id="submissionForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo">Add Photo</label>
                        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <textarea class="form-control" id="code" name="code" rows="7" readonly><?php echo htmlspecialchars($decodedCode); ?></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" id="globalSubmit">Global Submit</button>
                    <a href="fetchcodetitle.php" class="btn btn-secondary">Go to Room</a>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('globalSubmit').addEventListener('click', () => {
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const code = document.getElementById('code').value;
            const photoInput = document.getElementById('photo');
            const photo = photoInput.files[0];

            if (!title || !description || !photo) {
                alert('All fields are required');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('code', code);
            formData.append('photo', photo);

            fetch('save_code.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert('Code submitted successfully');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
    </script>
</body>
</html>
