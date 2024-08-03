<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./styles/quiz-test.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <title>QUIZ - TEST</title>
</head>

<body>

    <?php

    session_start();

    if (isset($_SESSION['id'])) {
        if (isset($_GET['lid']) && isset($_GET['did'])) {

    ?>

            <header>
                <h2 id="lang_name">C Language Test</h2>

                <p>TIME :- <span class="time-span"></span></p>
            </header>
            <main>
                <article id="article">
                    <!-- autofill using ajax -->
                </article>
                <section class="action mb-5">
                    <button id="save">
                        SUBMIT
                    </button>
                </section>
            </main>


            <section class="score-section">
                <article>
                    <div class="percentage">80</div>
                    <h3>Your Score</h3>
                </article>

                <br><br>
                <section id="info">

                </section>

                <footer>
                    <a href="user-profile.php?uid=<?php echo $_SESSION['id']; ?>" class="btn btn-warning text-black button">CLOSE TEST</a>
                </footer>
            </section>

</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    let min = 4;
    let sec = 59;
    var timerInterval = setInterval(() => {

        if (sec == -1) {
            sec = 59;
            min = min - 1;
        }

        document.getElementsByClassName("time-span")[0].innerText = `${min} : ${sec}`;
        sec--;


        if (min <= -1) {
            let choise = confirm("Time's up! The quiz has ended. Would you like to retake the quiz?");

            if (choise) {
                window.location.reload();

            } else {
                window.location.href = "/";
            }
        }

    }, 1000);

    // load lang by id
    $.ajax({
        url: "services/resources-service.php",
        method: "POST",
        data: {
            reason: "loadLanguages"
        },
        success: function(lang) {
            JSON.parse(lang).forEach(element => {
                if (element.l_id == <?php echo $_GET['lid']; ?>) {
                    $("#lang_name").text(element.l_name + " Test");
                    return;
                }
            });
        },
        error: function(error) {

        }
    });

    // load question and answers by language id and difficulty
    $.ajax({
        url: "services/get-que-ans.php",
        method: "POST",
        data: {
            l_id: <?php echo $_GET['lid']; ?>,
            did: <?php echo $_GET['did']; ?>
        },
        success: function(data) {
            // console.log(data);

            if (data.trim() == "") {
                document.body.innerHTML = `<?php showAlert("Error", '404 NOT FOUND', 'open-test.php'); ?>`;
                clearInterval(timerInterval);
            } else {
                $("#article").html(data);
            }

        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });


    // When save btn
    $('#save').on('click', function() {

        var checkedRadios = $('input[type="radio"]:checked');

        var checkedValues = [];

        // Iterate over each checked radio buttons
        checkedRadios.each(function() {
            checkedValues.push(
                $(this).attr('id'),
            );
        });

        // console.log(checkedValues);

        if (checkedValues.length == 20) {


            $.ajax({
                url: "services/check-mcq.php",
                method: "POST",
                data: {
                    checkedValues,
                    uid: <?php echo $_SESSION['id']; ?>,
                    lid: <?php echo $_GET['lid']; ?>,
                    did: <?php echo $_GET['did']; ?>
                },
                success: function(data) {

                    // console.log("data = ", data, typeof(data));
                    data = parseInt(data);


                    $(".score-section").css("display", "flex");

                    let num = 0;

                    let interval = setInterval(() => {

                        $(".percentage").text(num);

                        num++;


                        if (num > data) {
                            clearInterval(interval);
                        }
                    }, 10);

                    console.log("going to claa");

                    if (data >= 80) { //if pass

                        $("#info").text("Congratulations ! You are pass");


                    } else { //if fail
                        $("#info").text("Minimum 80% is required for pass");
                        $("#info").append("<br><p color='blue' onClick='reload()'> Retake quiz </p>");
                    }

                    // stop test timer
                    clearInterval(timerInterval);



                },
                error: function(error) {
                    alert("error");
                }
            });

        } else {
            alert("All questions are mendatory");
        }
    });

    function reload() {
        window.location.reload();
    }
</script>

<?php

        } else {
            // lang-id and difficulty not found

            showAlert("NOT FOUND", "Required Paremeters are missing", "./");
        }
    } else {
        // user not logged IN

        showAlert("ERROR", "You are not Logged In", "login.html");
    }

    function showAlert($title, $desc, $url)
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
            <a href=' . $url . ' class="btn btn-light">CLOSE</a>
          </div>
        </div>
      </div>
    
        ';
    }
?>

</html>