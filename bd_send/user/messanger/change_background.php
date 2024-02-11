<?php
session_start();
include "../../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../../pages/home.php");
    exit;
} else {
    $my_nik = $_SESSION["nik"];
}
$new_background = $_POST["new_bg"];

$update_bg_sql = "UPDATE `user_registoring` SET `chat_bg` = '$new_background' WHERE `nik` = '$my_nik'";
$update_bg_query = mysqli_query($bd_connect, $update_bg_sql);
header("Location: ../../../pages/messages.php");
?>