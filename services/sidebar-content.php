<?php


include("../config/config.php");


/**
 * RETURN HEADINGS ANS SUBHEADINGS THAT IS REQUIRED TO DISPLAY INTO THE SIDEBAR IN THE content.php PAGE.
 */

$lang_id =  $_GET['id'];


$topics = mysqli_query($con, "SELECT *FROM topics WHERE l_id = " . $lang_id);


while ($topicRow = mysqli_fetch_assoc($topics)) {

    $topic_id = $topicRow['t_id'];


    // ------ create module
    echo "<div class='module'>";

    echo "
        <div class='topic-heading'>
            <p class='topics'><strong>" . $topicRow['t_name'] . "</strong></p>
        </div>
    ";

    $subTopics = mysqli_query($con, "SELECT *FROM sub_topics WHERE t_id = " . $topic_id);


    while ($SubTopicRow = mysqli_fetch_assoc($subTopics)) {

        $sub_topic_id = $SubTopicRow['id'];

        echo "
        <div class='sub-topics'>
            <p class='sub-topics' id='subheading-" . $sub_topic_id . "' onclick='subHeading(" . $sub_topic_id . ")'>" . htmlspecialchars($SubTopicRow['hed_name']) . "</p>
        </div>
    ";
    }

    echo "</div>";
    // end module
}
