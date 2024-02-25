<?php
session_start();
include "../database_connect.php";
$nik = $_SESSION["nik"];
if (!isset($nik)) {
    header("Location: ../../pages/home.php");
    exit;
} elseif (isset($_GET["final_change"]) && is_numeric($_GET["final_change"])) {
    $final_option = $_GET["final_change"];
    if ($final_option == 1) {
        session_destroy();
        header("Location: ../../pages/home.php");
    }
}
//posts
$old_password = $_POST["old_password"];
$new_password = $_POST["new_password"];
if (empty($old_password) || empty($new_password)) {
    echo "Warning: Введите пароль";
    exit;
} elseif (strlen($new_password) <= 7) {
    echo "Warning: Минимальная длина пароля 8";
    exit;
} elseif (strpos($new_password, "&") === false && strpos($new_password, "$") === false && strpos($new_password, "!") === false && strpos($new_password, "@") === false && strpos($new_password, "#") === false && strpos($new_password, "-") === false && strpos($new_password, "_") === false) {
    echo "Warning: Пароль должен содержать один из символов (&, $, _, -, #, @, !)";
    exit;
} elseif (!preg_match('/\p{L}/u', $new_password)) {
    echo "Warning: Пароль должен содержать цифры";
    exit;
} elseif (!preg_match('/\d/', $new_password)) {
    echo "Warning: Пароль должен содержать буквы";
    exit;
}
//sql
$password_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
$stmt_password = mysqli_prepare($bd_connect, $password_sql);
mysqli_stmt_bind_param($stmt_password, "s", $nik);
mysqli_stmt_execute($stmt_password);
$password_query = mysqli_stmt_get_result($stmt_password);
$password_row = mysqli_fetch_assoc($password_query);
//main_change
$moment_password = $password_row["password"];
if ($old_password !== $moment_password) {
    echo "Warning: Неправильный пароль";
    exit;
}
$new_password = mysqli_real_escape_string($bd_connect, $new_password);
$new_password_sql = "UPDATE `user_registoring` SET `password` = ? WHERE `nik` = ?";
$stmt_new_password = mysqli_prepare($bd_connect, $new_password_sql);
mysqli_stmt_bind_param($stmt_new_password, "ss", $new_password, $nik);
$new_password_query = mysqli_stmt_execute($stmt_new_password);
if ($new_password_query) {
    header("Location: ../../pages/home.php");
    session_destroy();
}
?>