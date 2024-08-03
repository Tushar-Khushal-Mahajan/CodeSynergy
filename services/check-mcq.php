<?php


include("../config/config.php");

/**
 * GET ANS ARRAY AND CHECK EACH AND EVERY ANSWER IS CORRECT OR NOT AND IF IT IS CORRECT RETURN THE USER SCORE
 * AND UPDATE THE USER LEVEL.
 */

if (isset($_POST['checkedValues']) && isset($_POST['lid']) && isset($_POST['did']) && isset($_POST['uid'])) {


    $data = $_POST['checkedValues'];

    // echo json_decode($data);

    $ids = array();
    foreach ($data as  $itr) {

        array_push($ids, $itr);
    }

    // Sanitize IDs and convert to a comma-separated string
    $idsString = implode(',', array_map('intval', $ids));

    // Construct the query
    $query = "SELECT count('q_id') as total FROM answer_option WHERE answer_id IN ($idsString) AND is_correct = true";

    // Execute the query
    $result = mysqli_query($con, $query);



    $percentage = (intval(mysqli_fetch_assoc($result)['total']) / 20) * 100;


    // update user level
    if ($percentage >= 80) {

        $lid = $_POST['lid'];
        $did = intval($_POST['did']);
        $uid = $_POST['uid'];

        $userLevel = mysqli_query($con, "SELECT * FROM `user_level` WHERE uid=" . $uid . " and l_id=" . $lid . "");

        $userLevel = mysqli_fetch_assoc($userLevel);

        if ($userLevel != null) {  //UPDATE USER LEVEL IF ALREADY PRESENT
            $presentLevel = intval($userLevel['did']);

            if ($presentLevel < $did) {
                mysqli_query($con, "UPDATE `user_level` SET did = " . $did . " WHERE uid=" . $uid . " AND l_id = " . $lid . "");
            }
        } else {   //INSERT IF FIRST TEST
            mysqli_query($con, "INSERT INTO user_level (uid,l_id, did ) VALUES(" . $uid . "," . $lid . "," . $did . ")");
        }
    }


    echo $percentage;
} else {
}
