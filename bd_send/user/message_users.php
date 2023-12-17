<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$nik = $_SESSION["nik"];
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM `user_registoring` WHERE `id` = $user_id";
    $query = mysqli_query($bd_connect, $sql);
    $user = mysqli_fetch_assoc($query);
    //posts
    $thirst_message = $_POST["thirst_message"];
    if (empty($thirst_message)) {
        header("Location: ../../pages/home.php");
        exit;
    }
    $message_user = $user['nik'];
    $message_user_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = '$nik' OR `nik_two` = '$nik'";
    $message_user_query = mysqli_query($bd_connect, $message_user_sql);
    while ($message_user_row = mysqli_fetch_assoc($message_user_query)) {
        if ($message_user_row['nik_one'] == $message_user || $message_user_row['nik_two'] == $message_user) {
            header("Location: ../../pages/home.php");
            exit;
        }
    }
    if (empty($thirst_message)) {
        header("Location: ../../pages/user_page.php?user_id=$user_id");
        exit();
    }
    $messenger_sql = "INSERT INTO `messenger_users` (`id`, `nik_one`, `nik_two`, `status`, `main_block`) VALUES (NULL, '$nik', '$message_user', 'unblock', '')";
    $messenger_query = mysqli_query($bd_connect, $messenger_sql);

    $chat_id_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = '$nik' AND `nik_two` = '$message_user') OR (`nik_one` = '$message_user' AND `nik_two` = '$nik'))";
    $chat_id_query = mysqli_query($bd_connect, $chat_id_sql);
    $chat_id_resolt = mysqli_fetch_assoc($chat_id_query)['id'];

    $chat_date = date("j F, Y");
    date_default_timezone_set('Europe/Moscow');
    $current_time = date('H:i:s');
    $chat_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `nik`, `message_nik`) VALUES (NULL, '$chat_id_resolt', '$chat_date', '$thirst_message', '', '$current_time', 0, '$nik', '$message_user')";
    $chat_query = mysqli_query($bd_connect, $chat_sql);

    if (!$chat_query) {
        echo true;
    }


    //new_chat_id
    $new_id_sql = "UPDATE `messenger_users` SET `chat_id` = $chat_id_resolt WHERE `id` = $chat_id_resolt";
    $new_id_query = mysqli_query($bd_connect, $new_id_sql);

    header("Location: ../../pages/messages.php");
} else {
    header("Location: ../../pages/home.php");
    exit();
}
?>