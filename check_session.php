<?php
session_start();
$response = array('loggedIn' => false);

if (isset($_SESSION['id'])) {
    $response['loggedIn'] = true;
}

echo json_encode($response);
?>
