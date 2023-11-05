<?php
session_start();
include "../database_connect.php";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = $_SERVER['HTTP_REFERER'];
}
$nik = $_SESSION["nik"];
$status = "offline";
$status = mysqli_real_escape_string($bd_connect, $status);
$status_sql = "UPDATE `user_registoring` SET `status` = '$status' WHERE `nik` = '$nik'";
$status_query = mysqli_query($bd_connect, $status_sql);
session_destroy();
header("Location: $previous_page");
?>