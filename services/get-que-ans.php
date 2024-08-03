<?php

include("../config/config.php");


/**
 * RETURN THE QUESTION ANSWER BY THE LANGUAGE ID AND DIFFICULTY (BASIC, INTERMEDIATE, ADVANCED)
 */

try {

  if (isset($_POST['l_id']) && isset($_POST['did'])) {

    $lid = $_POST['l_id'];
    $did = $_POST['did'];


    $result = mysqli_query($con, "SELECT *FROM question_table WHERE l_id = " . $lid . " AND did = " . $did . "");


    $questions = [];

    while ($row = mysqli_fetch_assoc($result)) {


      echo " <section class='question-answer-section'>

                <p class='question'>
                   " . htmlspecialchars($row['question']) . "
                </p>
                <ul class='ansList'>";


      $ans = mysqli_query($con, "SELECT *FROM answer_option where qid = " . $row["qid"] . " LIMIT 4");

      $ansArray = [];

      while ($ansRow = mysqli_fetch_assoc($ans)) {

        echo "
                    <li class='ans'> <input type='radio' name=" . $row['qid'] . " value=" . $ansRow['answer_id'] . " id=" . $ansRow['answer_id'] . " /> <label for=" . $ansRow['answer_id'] . "> " . htmlspecialchars($ansRow['answer_text']) . " </label> </li>   
            ";
      }

      echo "
                </ul>
            </section>";
    }
  } else {
    throw new Exception('Something went wrong');
  }
} catch (Exception $e) {
  echo '
    <div class="container mt-5">
    <div class="card bg-warning text-white">
      <div class="card-header">
        Error
      </div>
      <div class="card-body">
        <h5 class="card-title"> Error </h5>
        <p class="card-text"> Something Went Wrong </p>
        <a href="/" class="btn btn-light">CLOSE</a>
      </div>
    </div>
  </div>

    ';
}
