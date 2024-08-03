<?php
//database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "teaching";


$con = new mysqli($servername, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Connection Fail" . mysqli_connect_error();
}
