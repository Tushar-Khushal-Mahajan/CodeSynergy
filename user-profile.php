<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./styles/user-profile.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>User Profile</title>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION["id"]) || !isset($_GET['uid'])) {
        showAlert("Not Valid", "Required parameters are missing", "/");
        exit;
    }
    ?>

    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="./images/default-profile.png" alt="User Profile" class="rounded-circle" width="150" id="USER-PROFILE">
                                <div class="mt-3">
                                    <h4 class="username"></h4>
                                    <p class="text-secondary mb-1 about"></p>
                                    <p class="text-muted font-size-sm address"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><a href="#" id="WEBSITE" class="text-primary">Website</a></h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><a href="#" id="GITHUB" class="text-dark">GitHub</a></h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><a href="#" id="TWITTER" class="text-info">Twitter</a></h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><a href="#" id="INSTAGRAM" class="text-danger">Instagram</a></h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><a href="#" id="FACEBOOK" class="text-primary">Facebook</a></h6>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary username"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary email"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Mobile</h6>
                                </div>
                                <div class="col-sm-9 text-secondary mobile"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary address"></div>
                            </div>
                            <hr>
                            <?php if ($_SESSION["id"] == $_GET['uid']) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-info" href="edit-user.php?uid=<?php echo $_GET['uid']; ?>" target="__blank">Edit</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row gutters-sm">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="d-flex align-items-center mb-3">
                                        <i class="material-icons text-info mr-2">Programming</i>
                                        Status
                                    </h6>
                                    <section id="PROGRESSBARS"></section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-7/lgk5dV0tQ5uTGJr5u6SC73qfT0qln/i8dnlJf0aAAoHk7K9+iCf/A12lmoE6O" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Custom Script -->
    <script>
        $(document).ready(function() {
            // Load user data
            $.ajax({
                url: "services/getUserData.php",
                method: "GET",
                data: {
                    REASON: "getUserData",
                    u_id: <?php echo $_GET["uid"]; ?>
                },
                success: function(data) {
                    data = JSON.parse(data);
                    const userData = data.userData;

                    if (userData) {
                        $(".username").text(userData.name);
                        $(".email").text(userData.email);
                        $(".mobile").text(userData.mobile);
                        $(".address").text(userData.address);
                        if (userData['user-profile'].trim()) {
                            $("#USER-PROFILE").attr("src", userData['user-profile']);
                        }

                        // Set social media links
                        for (const key in data.socialMedia) {
                            $(`#${key}`).attr("href", data.socialMedia[key]);
                        }
                    } else {
                        alert("Something went wrong");
                        window.location.replace("index.php");
                    }
                },
                error: function(error) {
                    console.error("Error fetching user data:", error);
                }
            });

            // Load progress bars
            $.ajax({
                url: "services/getUserData.php",
                method: "GET",
                data: {
                    REASON: "getLanguages",
                    uid: <?php echo $_GET["uid"]; ?>
                },
                success: function(data) {
                    data = JSON.parse(data);
                    data.forEach(obj => {
                        const level = parseInt(obj.level);
                        const progress = (level / 3) * 100;
                        $("#PROGRESSBARS").append(`
                            <small>${obj.language}</small>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: ${progress}%" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        `);
                    });
                },
                error: function(error) {
                    console.error("Error fetching progress data:", error);
                }
            });
        });

        function showAlert(title, desc, url) {
            $('body').prepend(`
                <div class="container mt-5">
                    <div class="card bg-warning text-white">
                        <div class="card-header">Warning</div>
                        <div class="card-body">
                            <h5 class="card-title">${title}</h5>
                            <p class="card-text">${desc}.</p>
                            <a href="${url}" class="btn btn-light">CLOSE</a>
                        </div>
                    </div>
                </div>
            `);
        }
    </script>
</body>

</html>
