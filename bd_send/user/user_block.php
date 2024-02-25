<?php
session_start();
include "../database_connect.php";

if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}

$my_nik = $_SESSION["nik"];

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $blocking_user_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = ?";
    $blocking_user_query = mysqli_prepare($bd_connect, $blocking_user_sql);
    mysqli_stmt_bind_param($blocking_user_query, "i", $user_id);
    mysqli_stmt_execute($blocking_user_query);
    $blocking_user_result = mysqli_stmt_get_result($blocking_user_query);
    $blocking_user_data = mysqli_fetch_assoc($blocking_user_result);
    $blocking_user_resolt = $blocking_user_data['nik'];

    $user_status_sql = "SELECT `status`, `main_block` FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_two` = ? AND `nik_one` = ?)";
    $user_status_query = mysqli_prepare($bd_connect, $user_status_sql);
    mysqli_stmt_bind_param($user_status_query, "ssss", $my_nik, $blocking_user_resolt, $my_nik, $blocking_user_resolt);
    mysqli_stmt_execute($user_status_query);
    $user_status_result = mysqli_stmt_get_result($user_status_query);
    $user_status_data = mysqli_fetch_assoc($user_status_result);
    $user_status_resolt = $user_status_data['status'];
    $user_block_resolt = $user_status_data['main_block'];

    if ($user_block_resolt !== $my_nik && $user_status_resolt !== "unblock") {
        exit("Ошибка пользователя!");
    }

    $block_sql = null;
    if ($user_status_resolt == 'unblock') {
        $block_sql = "UPDATE `messenger_users` SET `status` = 'block', `main_block` = ? WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_two` = ? AND `nik_one` = ?)";
    } elseif ($user_status_resolt == 'block') {
        $block_sql = "UPDATE `messenger_users` SET `status` = 'unblock', `main_block` = '' WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_two` = ? AND `nik_one` = ?)";
    }

    $block_query = mysqli_prepare($bd_connect, $block_sql);
    mysqli_stmt_bind_param($block_query, "sssss", $my_nik, $my_nik, $blocking_user_resolt, $my_nik, $blocking_user_resolt);
    if (mysqli_stmt_execute($block_query)) {
        header("Location: ../../pages/user_page.php?user_id=$user_id");
        exit;
    } else {
        exit("Ошибка! Обратитесь в службу поддержки.");
    }
} else {
    header("Location: ../../pages/home.php");
    exit;
}
?>