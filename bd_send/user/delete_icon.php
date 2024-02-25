<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit();
}
include "../database_connect.php";
$my_nik = $_SESSION["nik"];
$update_sql = "UPDATE `user_registoring` SET `icon_path` = 'user.png' WHERE `nik` = ?";
if ($stmt = mysqli_prepare($bd_connect, $update_sql)) {
    mysqli_stmt_bind_param($stmt, "s", $my_nik);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    echo "Ошибка подготовки запроса: " . mysqli_error($bd_connect);
}
?>