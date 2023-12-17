<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit();
}
include "../database_connect.php";
$my_nik = $_SESSION["nik"];
$update_sql = "UPDATE `user_registoring` SET `icon_path` = 'user.png' WHERE `nik` = '$my_nik'";
$unblock_query = mysqli_query($bd_connect, $update_sql);
?>