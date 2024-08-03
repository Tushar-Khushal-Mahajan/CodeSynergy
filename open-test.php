<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Selection</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/open-test.css">
</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION["id"])) {


    ?>
        <div class="container">
            <header class="text-center mt-5">
                <h1>SELECT LANGUAGE</h1>
            </header>
            <main class="mt-4">
                <div class="row langCardRow">

                </div>
                <div class="text-center mb-4">
                    <label for="difficulty">Select Difficulty Level:</label>
                    <select id="difficulty" class="form-control d-inline-block w-auto ml-2 dif-lvl">

                    </select>
                </div>
            </main>
            <footer class="text-right mb-4">
                <button class="btn btn-secondary">BACK</button>
                <button class="btn btn-primary" onclick="startQuiz()">START QUIZ</button>
            </footer>
        </div>

        <!-- Toast Notifications -->
        <div class="toast-container position-fixed bottom-0 right-0 p-3 d-none" style="z-index: 11;">
            <div id="quiz-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                <div class="toast-header">
                    <strong class="mr-auto">Quiz Notification</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body" id="toast-message">
                    <!-- Message will be set dynamically -->
                    <div class="mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-danger btn-sm" onclick="cancelQuiz()">Cancel</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="confirmQuiz()">Start Test</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script> -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // load languages into cards
            $.ajax({
                url: "services/test-service.php",
                method: "GET",
                data: {},
                success: function(data) {
                    let languages = JSON.parse(data)['languages'];
                    let levels = JSON.parse(data)['levels'];

                    $(".langCardRow").html("");

                    console.log(languages);
                    languages.forEach(lng => {

                        // insert languages into cards
                        $(".langCardRow").append(
                            `
                    <div class="col-md-4 mb-3">
                        <div class="card" onclick="selectLanguage('${lng.lang}')">
                            <div class="card-body text-center">
                                <h5 class="card-title">${lng.lang}</h5>
                            </div>
                        </div>
                        <input type="radio" name="language" id="${lng.lang}" value="${lng.lid}" hidden>
                    </div>
                    `);

                        // insert levels into dropdown
                        $(".dif-lvl").html("");


                        console.log(levels);

                        levels.forEach(level => {
                            $(".dif-lvl").append(`
                            <option value="${level.did}">${level.title}</option>
                        `);
                        });

                    });

                },
                error: function(error) {
                    console.log(error);
                }
            });

            // toast logic :---------
            $('#quiz-toast').toast('hide');

            function selectLanguage(language) {

                document.querySelectorAll('.card').forEach(card => {
                    card.classList.remove('selected');
                });

                const selectedCard = document.querySelector(`.card[onclick="selectLanguage('${language}')"]`);
                selectedCard.classList.add('selected');

                document.getElementById(language).checked = true;
            }

            function showToast(message) {

                document.getElementById('toast-message').innerHTML = `
        ${message}
        <div class="mt-2 pt-2 border-top">
            <button type="button" class="btn btn-danger btn-sm" onclick="cancelQuiz()">Cancel</button>
            <button type="button" class="btn btn-success btn-sm" onclick="confirmQuiz()">Start Test</button>
        </div>
    `;

                // Show the toast
                $(".toast-container").removeClass("d-none");
                $('#quiz-toast').toast('show');
            }

            var isOk = false;

            var selectedLanguage;
            var selectedDifficulty;

            function startQuiz() {
                try {

                    selectedLanguage = document.querySelector('input[name="language"]:checked').value;
                    selectedDifficulty = document.getElementById("difficulty").value;

                    if (selectedLanguage) {
                        // const message = `Starting quiz in ${selectedLanguage.value.toUpperCase()} with ${selectedDifficulty.toUpperCase()} difficulty.`;
                        showToast("Do you want to start a Quiz !.");

                        isOk = true;
                    } else {
                        showToast('Please select a language.');
                    }
                } catch {
                    showToast('Please select a language.');
                }
            }

            function cancelQuiz() {
                $('#quiz-toast').toast('hide');
            }

            function confirmQuiz() {
                // Logic to start the quiz

                if (isOk) {
                    $('#quiz-toast').toast('hide');

                    // var url = "https://example.com";
                    window.open(`quiz-test.php?lid=${selectedLanguage}&did=${selectedDifficulty}`);
                } else {
                    alert('Please select a language.');
                }
            }
        </script>

    <?php
    } else {
        echo '
        <div class="container mt-5">
            <div class="card bg-warning text-white">
                <div class="card-header">Warning</div>
                <div class="card-body">
                    <h5 class="card-title">Invalid Credentials</h5>
                    <p class="card-text">You are not logged In</p>
                    <a href="login.html" class="btn btn-light">CLOSE</a>
                </div>
            </div>
        </div>
        ';
    }
    ?>
</body>

</html>