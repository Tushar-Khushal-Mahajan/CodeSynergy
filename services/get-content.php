<?php

include("../config/config.php");
/**
 * RETURN THE CONTENT ON THE CONTENT PAGE IT MEANS
 * RETURN HEADING, SUBHEADINGS, AND DESCRIPTION OF SUBHEADING 
 */

// get sub heading content based on sub-heading content
if (isset($_GET['id'])) {

    $subTopicId =  $_GET['id'];

    $result = mysqli_query($con, "SELECT *FROM descr_tbl WHERE s_id = " . $subTopicId);


    $topic_name = mysqli_query($con, "SELECT *FROM topics WHERE t_id = (SELECT t_id FROM sub_topics WHERE id = " . $subTopicId . ") ");
    $topic_name = mysqli_fetch_assoc($topic_name)["t_name"];

    $subTopic =  mysqli_query($con, "SELECT hed_name FROM sub_topics WHERE id = " . $subTopicId);
    $subTopicName = mysqli_fetch_assoc($subTopic)["hed_name"];

    $row = mysqli_fetch_assoc($result)['descr'];

    $data = [
        "topic" => $topic_name,
        "sub_topic" => $subTopicName,
        "sub_topic_id" => $subTopicId,
        "content" =>  $row
    ];

    echo json_encode($data);
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