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

$update_bg_sql = "UPDATE `user_registoring` SET `chat_bg` = ? WHERE `nik` = ?";
$update_bg_query = mysqli_prepare($bd_connect, $update_bg_sql);

if ($update_bg_query) {
    mysqli_stmt_bind_param($update_bg_query, "ss", $new_background, $my_nik);

    if (mysqli_stmt_execute($update_bg_query)) {
        header("Location: ../../../pages/messages.php");
    } else {
        exit("Ошибка при выполнении запроса: " . mysqli_stmt_error($update_bg_query));
    }
} else {
    exit("Ошибка при подготовке запроса: " . mysqli_error($bd_connect));
}
?>