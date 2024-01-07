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
    $messenger_sql = "INSERT INTO `messenger_users` (`id`, `chat_id`, `nik_one`, `nik_two`, `status`, `main_block`, `attach`, `message_attach`, `deleted` `mute`) VALUES (NULL, 0, '$nik', '$message_user', 'unblock', '', 0, 0, 0, 0)";
    $messenger_query = mysqli_query($bd_connect, $messenger_sql);

    $chat_id_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = '$nik' AND `nik_two` = '$message_user') OR (`nik_one` = '$message_user' AND `nik_two` = '$nik'))";
    $chat_id_query = mysqli_query($bd_connect, $chat_id_sql);
    $chat_id_resolt = mysqli_fetch_assoc($chat_id_query)['id'];

    //date
    setlocale(LC_TIME, 'ru_RU.utf8');
    $date = time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($date);
    $formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL, null, null, 'd MMMM y г');
    $formattedDate = $formatter->format($dateTime);
    //time
    date_default_timezone_set('Europe/Moscow');
    $current_time = date('H:i:s');
    $chat_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `file`, `nik`, `message_nik`) VALUES (NULL, '$chat_id_resolt', '$formattedDate', '$thirst_message', '', '$current_time', 0, 0, 0, 0, 0, '$nik', '$message_user')";
    $chat_query = mysqli_query($bd_connect, $chat_sql);

    //new_chat_id
    $new_id_sql = "UPDATE `messenger_users` SET `chat_id` = $chat_id_resolt WHERE `id` = $chat_id_resolt";
    $new_id_query = mysqli_query($bd_connect, $new_id_sql);

    header("Location: ../../pages/messages.php");
} else if (isset($_GET['user_attach']) && is_numeric($_GET['user_attach'])){
    $attach_id = $_GET['user_attach'];
    $attach_change = null;

    //user_check
    function user_check(){
        global $nik, $attach_id, $bd_connect;
        $check_resolt = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = '$nik' OR `nik_two` = '$nik' AND `chat_id` = $attach_id";
        $check_query = mysqli_query($bd_connect, $check_sql);
        while ($check_progress = mysqli_fetch_assoc($check_query)){
            $check_resolt = true;
        }
        return $check_resolt;
    }
    if (user_check() == false){
        exit("Ошибка!");
    }
    //user_attach
    $attach_check = "SELECT `attach` FROM `messenger_users` WHERE `chat_id` = $attach_id";
    $attach_check_query = mysqli_query($bd_connect, $attach_check);
    $attach_check_resolt = mysqli_fetch_assoc($attach_check_query)['attach'];
    if ($attach_check_resolt == 0){
        $attach_change = 1;
    } else{
        $attach_change = 0;
    }
    //attach_update
    $attach_update = "UPDATE `messenger_users` SET `attach` = $attach_change WHERE `chat_id` = $attach_id";
    $attach_update_query = mysqli_query($bd_connect, $attach_update);
} else if (isset($_GET["mute_chat"]) && is_numeric($_GET["mute_chat"])){
    $mute_id = $_GET["mute_chat"];
    $last_mute = null;
    function muted_id_check(){
        global $nik, $mute_id, $bd_connect, $last_mute;
        $check = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$nik' OR `nik_two` = '$nik') AND `chat_id` = $mute_id";
        $chat_query = mysqli_query($bd_connect, $check_sql);
        while ($chat_resolt = mysqli_fetch_assoc($chat_query)){
            if ($chat_resolt['mute'] == 0){
                $last_mute = 1;
            } else{
                $last_mute = 0;
            }
            $check = true;
        }
        return $check;
    }
    if (muted_id_check() == false){
        header("Location: ../../pages/home.php");
        exit;
    }
    $update_mute_sql = "UPDATE `messenger_users` SET `mute` = $last_mute WHERE `chat_id` = '$mute_id'";
    mysqli_query($bd_connect, $update_mute_sql);
} else {
    header("Location: ../../pages/home.php");
    exit;
}
?>