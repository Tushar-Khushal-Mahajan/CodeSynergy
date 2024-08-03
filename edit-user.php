<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/edit-user.css">

    <title>Edit User</title>
</head>

<body>
    <?php

    session_start();

    if (isset($_SESSION["id"])) {

        if (isset($_GET['uid'])) {
            if ($_SESSION['id'] == $_GET['uid']) {
    ?>

                <div class="container">
                    <div class="main-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <div id="USER-PROFILE-DIV">
                                                <input type="file" value="user-profile" id="USER-PROFILE-INPUT" />
                                                <img src="" alt="Admin" onerror="this.onerror=null; this.src='./images/default-profile.png'" class="rounded-circle p-1 bg-primary" width="110" id="PROFILE-IMG">
                                            </div>
                                            <div class="mt-3">
                                                <h4 id="NAME-LABEL">John Doe</h4>
                                                <p class="text-secondary mb-1" id="ABOUT-LABEL">Full Stack Developer</p>
                                                <p class="text-muted font-size-sm" id="ADDRESS-LABEL">Bay Area, San Francisco, CA</p>
                                            </div>
                                        </div>
                                        <hr class="my-4">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                                    </svg>Website</h6>
                                                <input type="text" id="website-link" class="text-secondary form-control">
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github me-2 icon-inline">
                                                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                    </svg>Github</h6>
                                                <input type="text" id="github-link" class="text-secondary form-control">
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter me-2 icon-inline text-info">
                                                        <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                                    </svg>Twitter</h6>
                                                <input type="text" id="twiter-link" class="text-secondary form-control">
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger">
                                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                    </svg>Instagram</h6>
                                                <input type="text" id="instagram-link" class="text-secondary form-control">
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook me-2 icon-inline text-primary">
                                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                    </svg>Facebook</h6>
                                                <input type="text" id="facebook-link" class="text-secondary form-control">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" value="" id="NAME-INPUT">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" value="john@example.com" id="EMAIL-INPUT">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Phone</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" value="(239) 816-9029" id="PHONE-INPUT">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">About</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <textarea class="form-control" id="ABOUT-INPUT"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" id="ADDRESS-INPUT" value="Bay Area, San Francisco, CA">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="button" id="SUBMIT" class="btn btn-primary px-4" value="Save Changes">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT5WnDRXo2HbzzblAAJeQmPbZx4lsc5dVn+s66tQp27NvkzC2D" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-7/lgk5dV0tQ5uTGJr5u6SC73qfT0qln/i8dnlJf0aAAoHk7K9+iCf/A12lmoE6O" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
                <script>
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

                            // console.log(data);

                            // console.log(data);
                            userData = data.userData;
                            $("#NAME-LABEL").text(userData.name);
                            $("#ABOUT-LABEL").text(userData.about);
                            $("#ADDRESS-LABEL").text(userData.address);

                            $("#NAME-INPUT").val(userData.name);
                            $("#EMAIL-INPUT").val(userData.email);
                            $("#PHONE-INPUT").val(userData.mobile);
                            $("#ABOUT-INPUT").text(userData.about);
                            $("#ADDRESS-INPUT").val(userData.address);

                            if (userData['user-profile'].trim() != "") {
                                $("#PROFILE-IMG").attr("src", userData['user-profile']).show();
                            }

                            // console.log(data.socialMedia);

                            $("#facebook-link").val(data.socialMedia.FACEBOOK);
                            $("#instagram-link").val(data.socialMedia.INSTAGRAM);
                            $("#twiter-link").val(data.socialMedia.TWITTER);
                            $("#github-link").val(data.socialMedia.GITHUB);
                            $("#website-link").val(data.socialMedia.WEBSITE);
                        },
                        error: function(error) {
                            console.error("error = \n", error);
                        }
                    });


                    //holds the image data
                    var binary_image;

                    $("#USER-PROFILE-INPUT").change((e) => {
                        const file = e.target.files[0];
                        const reader = new FileReader();

                        reader.addEventListener("load", () => {
                            binary_image = reader.result;

                            $("#PROFILE-IMG").attr("src", binary_image).show();
                            // console.log(binary_image);
                        });

                        reader.readAsDataURL(file);

                    });


                    //WHEN SUBMIT BTN CLICK
                    $("#SUBMIT").click(() => {

                        let email = $("#EMAIL-INPUT").val();

                        if (email.trim() != "") {

                            let profile = $("#PROFILE-IMG").attr("src");

                            let name = $("#NAME-INPUT").val();
                            let phone = $("#PHONE-INPUT").val();
                            let about = $("#ABOUT-INPUT").val();
                            let address = $("#ADDRESS-INPUT").val();

                            let fbLink = $("#facebook-link").val();
                            let instaLink = $("#instagram-link").val();
                            let twiterLink = $("#twiter-link").val();
                            let githubLink = $("#github-link").val();
                            let websiteLink = $("#website-link").val();

                            // --------------

                            User = {
                                uid: <?php echo $_GET['uid'] ?>,
                                name,
                                email,
                                phone,
                                about,
                                address,
                                profile
                            };

                            socialMedia = {
                                "FACEBOOK": fbLink,
                                "INSTAGRAM": instaLink,
                                "TWITTER": twiterLink,
                                "GITHUB": githubLink,
                                "WEBSITE": websiteLink
                            }

                            // --------------
                            $.ajax({
                                url: "services/getUserData.php",
                                method: "POST",
                                data: {
                                    REASON: "updateUserData",
                                    "User": JSON.stringify(User),
                                    "socialMedia": JSON.stringify(socialMedia)
                                },
                                success: function(data) {
                                    // console.log(data);

                                    if (confirm("Changes Applied \nDo you want to go profile page !..")) {
                                        window.close();
                                    } else {

                                    }
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        } else {
                            alert("Email is required");
                        }
                    });
                </script>

    <?php
            } else {
                // echo "access denied";
                showAlert("WARNING", "ACCESS DENIED");
            }
        } else {
            // echo "access denied";
            showAlert("WARNING", "ACCESS DENIED");
        }
    } else {
        // echo "you are not logged In";
        showAlert("WARNING", "you are not logged In");
    }

    function showAlert($title, $desc)
    {
        echo '
        <div class="container mt-5">
        <div class="card bg-warning text-white">
          <div class="card-header">
            Warning
          </div>
          <div class="card-body">
            <h5 class="card-title">' . $title . '</h5>
            <p class="card-text">' . $desc . '.</p>
            <a href="./" class="btn btn-light">CLOSE</a>
          </div>
        </div>
      </div>
    
        ';
    }
    ?>

</body>

</html>