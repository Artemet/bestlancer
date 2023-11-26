<?php
session_start();
include "../database_connect.php";
//chat_id
if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
    $chat_id = $_GET["chat_id"];
} else {
    header("Location: ../../pages/home.php");
    exit;
}
if (isset($_SESSION["nik"])) {
    $nik = $_SESSION["nik"];
    //date
    setlocale(LC_TIME, 'ru_RU.utf8');
    $date = time();
    $formattedDate = strftime('%e %B, %Y', $date);
    //time
    date_default_timezone_set('Europe/Moscow');
    $message_time = date('Y-m-d H:i');
    //posts
    if (!empty($_FILES['file_send'])) {
        $file = $_FILES['file_send'];
        $file_name = $file['name'];
        $pathFile = __DIR__ . '/messanger_files/' . $file_name;
        move_uploaded_file($file['tmp_name'], $pathFile);
    }
    $message_value = $_POST["message_value"];
    $message_nik = null;
    //get_user
    $get_user_sql = "SELECT * FROM `messenger_users` WHERE `chat_id` = '$chat_id'";
    $get_user_query = mysqli_query($bd_connect, $get_user_sql);
    $get_user_resolt = mysqli_fetch_assoc($get_user_query);
    if ($get_user_resolt["nik_one"] == $nik) {
        $message_nik = $get_user_resolt["nik_two"];
    } else {
        $message_nik = $get_user_resolt["nik_one"];
    }

    if (empty($message_value)) {
        header("Location: ../../pages/messages.php");
        exit;
    }
    // if ($nik === $message_nik) {
    //     header("Location: ../../pages/home.php");
    //     exit;
    // }
    $sql = "INSERT INTO messages (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `nik`, `message_nik`) VALUES (NULL, '$chat_id', '$formattedDate', '$message_value', '$file_name', '$message_time', 0, '$nik', '$message_nik')";
    $query = mysqli_query($bd_connect, $sql);

    //notification
    $moment_notification = "SELECT `messages` FROM `user_notification` WHERE `nik` = '$message_nik'";
    $moment_notification_query = mysqli_query($bd_connect, $moment_notification);
    $resolt_message_num = mysqli_real_escape_string($bd_connect, mysqli_fetch_assoc($moment_notification_query)['messages'] + 1);
    $notification_sql = "UPDATE `user_notification` SET `messages` = $resolt_message_num WHERE `nik` = '$message_nik'";
    $notification_query = mysqli_query($bd_connect, $notification_sql);

    header("Location: ../../pages/messages.php?chat_id=$chat_id");
} else {
    header("Location: ../../pages/home.php");
}
?>