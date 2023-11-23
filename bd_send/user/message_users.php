<?php
session_start();
include "../database_connect.php";
$nik = $_SESSION["nik"];
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM `user_registoring` WHERE `id` = $user_id";
    $query = mysqli_query($bd_connect, $sql);
    $user = mysqli_fetch_assoc($query);
    //posts
    $thirst_message = $_POST["thirst_message"];
    $message_user = $user['nik'];
    $message_user_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = '$nik' OR `nik_two` = '$nik'";
    $message_user_query = mysqli_query($bd_connect, $message_user_sql);
    while ($message_user_row = mysqli_fetch_assoc($message_user_query)) {
        if ($message_user_row['nik_one'] == $message_user || $message_user_row['nik_two'] == $message_user) {
            header("Location: ../../pages/home.php");
            exit();
        }
    }
    if (empty($thirst_message)) {
        header("Location: ../../pages/user_page.php?user_id=$user_id");
        exit();
    }
    $messenger_sql = "INSERT INTO `messenger_users` (`id`, `nik_one`, `nik_two`, `status`, `main_block`) VALUES (NULL, '$nik', '$message_user', 'unblock', '')";
    $messenger_query = mysqli_query($bd_connect, $messenger_sql);
    header("Location: ../../pages/messages.php");
} else {
    header("Location: ../../pages/home.php");
    exit();
}
?>