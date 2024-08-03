<?php


/**
 * THIS SERVICE IS RESPONSIBLE FOR DOWNLOADING THE RESOURCE BY ITS RESOURCE ID
 */

include("../config/config.php");

$result = mysqli_query($con, "SELECT * FROM resources WHERE r_id = '" . $_POST . "'");

$base64Pdf = mysqli_fetch_assoc($result)["file_url"];

// Decode the Base64 data
$pdfData = base64_decode($base64Pdf);

// Set headers for PDF download
header("Content-Type: application/pdf");
header("Content-Length: " . strlen($pdfData));
header("Content-Disposition: attachment; filename=\"document.pdf\"");

// Output the PDF data
echo $pdfData;
