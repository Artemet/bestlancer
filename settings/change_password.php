<?php
session_start();
include "../database_connect.php";
$nik = $_SESSION["nik"];
if (!isset($nik)) {
    header("Location: ../../pages/home.php");
    exit();
}
//posts
$old_password = $_POST["old_password"];
$new_password = $_POST["new_password"];
if (empty($old_password) || empty($new_password) || $old_password == $new_password) {
    header("Location: ../../pages/settings.php");
    exit();
}
//sql
$password_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
$stmt = mysqli_prepare($bd_connect, $password_sql);
mysqli_stmt_bind_param($stmt, "s", $nik);
mysqli_stmt_execute($stmt);
$password_query = mysqli_stmt_get_result($stmt);
$password_row = mysqli_fetch_assoc($password_query);
//main_change
$moment_password = $password_row["password"];
if ($old_password !== $moment_password) {
    header("Location: ../../pages/settings.php");
    exit();
}
$new_password = mysqli_real_escape_string($bd_connect, $new_password);
$new_password_sql = "UPDATE `user_registoring` SET `password` = ? WHERE `nik` = ?";
$stmt = mysqli_prepare($bd_connect, $new_password_sql);
mysqli_stmt_bind_param($stmt, "ss", $new_password, $nik);
$new_password_query = mysqli_stmt_execute($stmt);
if ($new_password_query) {
    header("Location: ../../pages/home.php");
    session_destroy();
}
?>