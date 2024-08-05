<?php

include("../config/config.php");

/**
 * RETURN THE CONTENT ON THE CONTENT PAGE IT MEANS
 * RETURN HEADING, SUBHEADINGS, AND DESCRIPTION OF SUBHEADING 
 */

// get sub heading content based on sub-heading content
if (isset($_GET['id'])) {

    $subTopicId =  $_GET['id'];

    // Set the character set to UTF-8
    mysqli_query($con, "SET NAMES 'utf8mb4'");
    mysqli_query($con, "SET CHARACTER SET 'utf8mb4'");
    mysqli_query($con, "SET COLLATION_CONNECTION = 'utf8mb4_unicode_ci'");
    //----END--

    $result = mysqli_query($con, "SELECT *FROM descr_tbl WHERE s_id = " . $subTopicId);

    // fetch topic name
    $topic_name = mysqli_query($con, "SELECT *FROM topics WHERE t_id = (SELECT t_id FROM sub_topics WHERE id = " . $subTopicId . ") ");
    $topic_name = mysqli_fetch_assoc($topic_name)["t_name"];

    // fetch sub-topic name
    $subTopic =  mysqli_query($con, "SELECT hed_name FROM sub_topics WHERE id = " . $subTopicId);
    $subTopicName = mysqli_fetch_assoc($subTopic)["hed_name"];

    $row = mysqli_fetch_assoc($result)['descr'];

    $data = [
        "topic" => $topic_name,
        "sub_topic" => $subTopicName,
        "sub_topic_id" => $subTopicId,
        "content" =>  $row
    ];

    $json_data = json_encode($data);

    if(json_last_error() == JSON_ERROR_NONE){
        echo $json_data;
    }
}
// get first sub heading content based on language id 
else {

    $lang_id = $_GET['lang_id'];

    $descr = mysqli_query($con, "SELECT * FROM descr_tbl WHERE s_id = (SELECT id FROM sub_topics WHERE t_id = (SELECT t_id FROM topics WHERE l_id = (SELECT l_id FROM languages WHERE l_id = " . $lang_id . ")LIMIT 1)LIMIT 1)LIMIT 1");

    $sub_topic = mysqli_query($con, "SELECT id,hed_name FROM sub_topics WHERE t_id = (SELECT t_id FROM topics WHERE l_id = " . $lang_id . " LIMIT 1) LIMIT 1");


    $sub_topic = mysqli_fetch_assoc($sub_topic);

    try {

        $data = [
            'topic' => "Introduction",
            "sub_topic" => $sub_topic['hed_name'],
            "sub_topic_id" => $sub_topic['id'],
            'content' =>  mysqli_fetch_assoc($descr)['descr']
        ];

        echo json_encode($data);
    } catch (Exception) {
    }
}
