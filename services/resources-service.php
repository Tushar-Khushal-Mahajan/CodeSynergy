<?php

include("../config/config.php");

/** 
 * RETURN ALL RESOURCES 
 */
if ($_POST['reason'] === "GET_RID_TITLE") {

    // include("../config/config.php");

    $result = mysqli_query($con, "SELECT r_id, title FROM `resources`");


    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {

        try {
            $data[] = [
                "r_id" => $row["r_id"],
                "title" => $row["title"]
            ];
        } catch (Exception) {
        }
    }

    echo json_encode($data);
}

//----------------------------
/**
 * RETURN RESOURCES BY LANGUAGE-ID
 */
else if ($_POST['reason'] === "GET_RES_BY_LNG_ID") {

    $result = mysqli_query($con, "SELECT r_id, title FROM `resources` WHERE l_id = '" . $_POST["l_id"] . "'");


    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {

        try {
            $data[] = [
                "r_id" => $row["r_id"],
                "title" => $row["title"]
            ];
        } catch (Exception) {
        }
    }

    echo json_encode($data);
}

//------------------------------
/**
 * RETURN RESOURCES BY USER-SEARCH
 */
else if ($_POST["reason"] === "GET_RES_BY_USER_SERACH") {
    $result = mysqli_query($con, "SELECT r_id, title FROM resources WHERE title LIKE'%" . $_POST["searchValue"] . "%'");


    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {

        try {
            $data[] = [
                "r_id" => $row["r_id"],
                "title" => $row["title"]
            ];
        } catch (Exception) {
        }
    }

    echo json_encode($data);
}


// ---------------------------

/**
 * FOR DOWNLOADING A RESOURCE BY ID
 */
else if ($_POST['reason'] === "DOWNLOAD_RESOURCE") {

    // include("../config/config.php");

    $result = mysqli_query($con, "SELECT * FROM resources WHERE r_id = '" . $_POST["r_id"] . "'");

    $base64Pdf = mysqli_fetch_assoc($result)["file_url"];

    // Decode the Base64 data
    $pdfData = base64_decode($base64Pdf);

    // Set headers for PDF download
    header("Content-Type: application/pdf");
    header("Content-Length: " . strlen($pdfData));
    header("Content-Disposition: attachment; filename=\"document.pdf\"");

    // Output the PDF data
    echo $pdfData;
    exit;
}

//-----------------------------

/**
 * FOR LOAD A LANGUAGES
 */
else if ($_POST['reason'] === "loadLanguages") {

    $result = mysqli_query($con, "SELECT *FROM languages");

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "l_id" => $row["l_id"],
            "l_name" => $row["l_name"]
        ];
    }

    echo json_encode($data);
}
