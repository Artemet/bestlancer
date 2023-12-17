<?php
session_start();
if (isset($_SESSION["nik"])) {
    $my_nik = $_SESSION["nik"];
} else {
    warning_return();
    exit;
}
include "../../database_connect.php";
function warning_return()
{
    header("Location: ../../../pages/home.php");
    exit;
}

if (!isset($_SESSION["nik"])) {
    warning_return();
}

if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
    $chat_id = $_GET["chat_id"];
} else {
    warning_return();
}

//user_check
$check_continue = false;
$check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$my_nik' OR `nik_two` = '$my_nik') AND `chat_id` = $chat_id";
$check_query = mysqli_query($bd_connect, $check_sql);
while ($request_count = mysqli_fetch_assoc($check_query)) {
    $check_continue = true;
}
if ($check_continue == false) {
    warning_return();
}

$remove_companion_sql = "DELETE FROM `messenger_users` WHERE `chat_id` = '$chat_id'";
$remove_companion_query = mysqli_query($bd_connect, $remove_companion_sql);
header("Location: ../../../pages/user.php");
?>