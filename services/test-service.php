<?php

include("../config/config.php");

/**
 * RETURN THE LANGUAGED AND THE DIFFICULATY
 * THIS SERVICE IS USED BY open-test.php
 */

$langResult = mysqli_query($con, "SELECT *FROM languages");

$lang = [];

while ($langRow = mysqli_fetch_assoc($langResult)) {
    $lang[] = [
        "lang" => $langRow['l_name'],
        "lid" => $langRow['l_id']
    ];
}

// -------------

$difficultyResult = mysqli_query($con, "SELECT *FROM difficulty");

$difficulty = [];

while ($diff = mysqli_fetch_assoc($difficultyResult)) {
    $difficulty[] = [
        'did' => $diff['did'],
        'title' => $diff['title']
    ];
}

$data = [
    "languages" => $lang,
    "levels" => $difficulty
];

echo json_encode($data);
