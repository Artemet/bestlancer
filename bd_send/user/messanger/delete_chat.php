<?php
session_start();
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

$remove_companion_sql = "DELETE FROM `messenger_users` WHERE `chat_id` = '$chat_id'";
$remove_companion_query = mysqli_query($bd_connect, $remove_companion_sql);
header("Location: ../../../pages/user.php");
?>