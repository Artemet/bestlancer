<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$user_id = $_SESSION["id"];

//posts
$qiwi = $_POST["qiwi"];
$bank_card = $_POST["bank_card"];

//main_send
$detail_sql = "UPDATE `user_registoring` SET `payment_methods` = CONCAT(?, ', ', ?) WHERE `id` = ?";
$detail_query = mysqli_prepare($bd_connect, $detail_sql);

if ($detail_query) {
    mysqli_stmt_bind_param($detail_query, "ssi", $qiwi, $bank_card, $user_id);

    if (mysqli_stmt_execute($detail_query)) {
        header("Location: ../../pages/settings.php");
    } else {
        exit("Ошибка при выполнении запроса: " . mysqli_stmt_error($detail_query));
    }
} else {
    exit("Ошибка при подготовке запроса: " . mysqli_error($bd_connect));
}
?>