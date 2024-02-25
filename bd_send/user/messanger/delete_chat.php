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
$check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
$check_query = mysqli_prepare($bd_connect, $check_sql);
if ($check_query) {
    mysqli_stmt_bind_param($check_query, "ssi", $my_nik, $my_nik, $chat_id);
    mysqli_stmt_execute($check_query);
    $result = mysqli_stmt_get_result($check_query);
    if (mysqli_num_rows($result) > 0) {
        $check_continue = true;
    }
} else {
    warning_return();
}

if ($check_continue == false) {
    warning_return();
}

$remove_companion_sql = "DELETE FROM `messenger_users` WHERE `chat_id` = ?";
$remove_companion_query = mysqli_prepare($bd_connect, $remove_companion_sql);
if ($remove_companion_query) {
    mysqli_stmt_bind_param($remove_companion_query, "i", $chat_id);
    mysqli_stmt_execute($remove_companion_query);
    header("Location: ../../../pages/user.php");
} else {
    warning_return();
}
?>