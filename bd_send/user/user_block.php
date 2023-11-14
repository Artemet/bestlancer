<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])){
    header("Location: ../../pages/home.php");
    exit;
}
$my_nik = $_SESSION["nik"];
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    //blockeg_user_take
    $blocking_user_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = '$user_id'";
    $blocking_user_query = mysqli_query($bd_connect, $blocking_user_sql);
    $blocking_user_resolt = mysqli_fetch_assoc($blocking_user_query)['nik'];
    //blocking_user_status
    $user_status_sql = "SELECT `status` FROM `messenger_users` WHERE `nik_one` = '$my_nik' OR `nik_two` = '$my_nik' AND `nik_one` = '$blocking_user_resolt' OR `nik_two` = '$blocking_user_resolt'";
    $user_block_sql = "SELECT `main_block` FROM `messenger_users` WHERE `nik_one` = '$my_nik' OR `nik_two` = '$my_nik' AND `nik_one` = '$blocking_user_resolt' OR `nik_two` = '$blocking_user_resolt'";
    $user_status_query = mysqli_query($bd_connect, $user_status_sql);
    $user_block_query = mysqli_query($bd_connect, $user_block_sql);
    $user_status_resolt = mysqli_fetch_assoc($user_status_query)['status'];
    $user_block_resolt = mysqli_fetch_assoc($user_block_query)['main_block'];
    if ($user_block_resolt !== $my_nik && $user_status_resolt !== "unblock"){
        exit("Ошибка пользователя!");
    }
    //blocking_user_block
    $block_sql = null;
    $status_resolt = mysqli_real_escape_string($bd_connect, $user_status_resolt);
    if ($user_status_resolt == 'unblock'){
        $block_sql = "UPDATE `messenger_users` SET `status` = 'block', `main_block` = '$my_nik'";
    } elseif ($user_status_resolt == 'block'){
        $block_sql = "UPDATE `messenger_users` SET `status` = 'unblock', `main_block` = ''";
    }
    $block_query = mysqli_query($bd_connect, $block_sql);
    if (!$block_query){
        exit("Ошибка! Обратитесь в службу поддержки.");
    } else{
        header("Location: ../../pages/user_page.php?user_id=$user_id");
    }
} else{
    header("Location: ../../pages/home.php");
}
?>