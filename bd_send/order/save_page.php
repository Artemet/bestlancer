<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
//send_page
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = $_SERVER['HTTP_REFERER'];
    $my_nik = $_SESSION["nik"];
    //old_filter
    $sql_old = "SELECT `filter` FROM `user_registoring` WHERE `nik` = '$my_nik'";
    $query_old = mysqli_query($bd_connect, $sql_old);
    $resolt = mysqli_fetch_assoc($query_old)['filter'];
    //new_filter
    if (!empty($resolt)) {
        $sql_update = "UPDATE `user_registoring` SET `filter` = '' WHERE `nik` = '$my_nik'";
    } else {
        $sql_update = "UPDATE `user_registoring` SET `filter` = '$previous_page' WHERE `nik` = '$my_nik'";
    }
    $query_update = mysqli_query($bd_connect, $sql_update);
} else {
    header("Location: ../../pages/home.php");
}
?>