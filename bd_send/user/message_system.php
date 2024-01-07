<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])){
    header("Location: ../../pages/home.php");
    exit;
}
//chat_id
if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
    $chat_id = $_GET["chat_id"];
    $message_attach_command = $_POST["attach_command"];
    function delete_attach(){
        global $chat_id, $bd_connect;
        $my_nik = $_SESSION["nik"];
        function attach_check(){
            global $my_nik, $bd_connect, $chat_id;
            $id_find = false;
            $chat_id_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$my_nik' OR `nik_two` = '$my_nik') AND `chat_id` = $chat_id";
            $chat_id_query = mysqli_query($bd_connect, $chat_id_sql);
            while (mysqli_fetch_assoc($chat_id_query)){
                $id_find = true;
            }
            return $id_find;
        }
        if (attach_check() == true){
            $delite_attach_sql = "UPDATE `messenger_users` SET `message_attach` = 0 WHERE `chat_id` = $chat_id";
            mysqli_query($bd_connect, $delite_attach_sql);
        }
    }
    if (!empty($message_attach_command)){
        delete_attach();
    }
} else if (isset($_GET["message_attach_id"]) && is_numeric($_GET["message_attach_id"])) {
    //message_attach
    $attaching_chat_id = null;
    $message_attach_id = $_POST["message_attach_id"];
    function attach_id_check(){
        global $attaching_chat_id, $message_attach_id, $bd_connect;
        if (!isset($_SESSION["nik"])){
            return false;
        }
        $my_nik = $_SESSION["nik"];
        //message_check
        $user_find = false;
        $message_sql = "SELECT * FROM `messages` WHERE (`nik` = '$my_nik' OR `message_nik` = '$my_nik') AND `id` = $message_attach_id";
        $message_query = mysqli_query($bd_connect, $message_sql);
        while ($message_find = mysqli_fetch_assoc($message_query)){
            $attaching_chat_id = $message_find['chat_id'];
            $user_find = true;
        }
        if ($user_find == true){
            return true;
        }
    }
    if (attach_id_check() == true){
        $attach_update = "UPDATE `messenger_users` SET `message_attach` = $message_attach_id WHERE `chat_id` = $attaching_chat_id";
        $attach_query = mysqli_query($bd_connect, $attach_update);
    }
} else if (isset($_GET["user_block"]) && is_numeric($_GET["user_block"])){
    //user_block
    $chat_id = $_GET["user_block"];
    $my_nik = $_SESSION["nik"];
    function user_block_check(){
        global $chat_id, $my_nik, $bd_connect;
        $check = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$my_nik' OR `nik_two` = '$my_nik') AND `chat_id` = $chat_id";
        $check_query = mysqli_query($bd_connect, $check_sql);
        while ($check_resolt = mysqli_fetch_assoc($check_query)){
            $check = true;
        }
        return $check;
    }
    if (user_block_check() == true){
        $resolt_sql = null;
        $messanger_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$my_nik' OR `nik_two` = '$my_nik') AND `chat_id` = $chat_id";
        $messanger_query = mysqli_query($bd_connect, $messanger_sql);
        $messanger_resolt = mysqli_fetch_assoc($messanger_query);
        if (empty($messanger_resolt['main_block']) || $messanger_resolt['main_block'] == $my_nik){
            if ($messanger_resolt['status'] == "block"){
                $resolt_sql = "UPDATE `messenger_users` SET `status` = 'unblock', `main_block` = '' WHERE `chat_id` = $chat_id";
            } elseif ($messanger_resolt['status'] == "unblock"){
                $resolt_sql = "UPDATE `messenger_users` SET `status` = 'block', `main_block` = '$my_nik' WHERE `chat_id` = $chat_id";
            }
        }
        mysqli_query($bd_connect, $resolt_sql);
    }
} else if (isset($_GET["chat_delete"]) && is_numeric($_GET["chat_delete"])){
    //chat_delete
    $chat_id = $_GET["chat_delete"];
    $my_nik = $_SESSION["nik"];
    $command = $_POST["add_command"];
    function chat_delete_check(){
        global $chat_id, $my_nik, $bd_connect;
        $check = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$my_nik' OR `nik_two` = '$my_nik') AND `chat_id` = $chat_id";
        $check_query = mysqli_query($bd_connect, $check_sql);
        while (mysqli_fetch_assoc($check_query)){
            $check = true;
        }
        return $check;
    }
    if (chat_delete_check() == true){
        $value = null;
        if (empty($command)){
            $value = 1;
        } else{
            $value = 0;
        }
        $delete_sql = "UPDATE `messenger_users` SET `deleted` = $value WHERE `chat_id` = $chat_id";
        mysqli_query($bd_connect, $delete_sql);
    }
} else {
    header("Location: messages.php");
    exit;
}
if (isset($_SESSION["nik"])) {
    $nik = $_SESSION["nik"];
    //date
    setlocale(LC_TIME, 'ru_RU.utf8');
    $date = time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($date);
    $formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL, null, null, 'd MMMM y г');
    $formattedDate = $formatter->format($dateTime);
    //time
    date_default_timezone_set('Europe/Moscow');
    $message_time = date('Y-m-d H:i');
    //posts
    $answer_id = $_POST["answer_id"];
    $message_value = $_POST["message_value"];
    $stripped_value = strip_tags($message_value);

    if ($message_value !== $stripped_value) {
        exit("Недопустимые теги в сообщении");
    }
    
    $file = $_FILES['file'];
    $file_information = 0;
    if (!empty($file)){
        $file_information = 1;
        $file_name = $file['name'];
        $pathFile = __DIR__ . '/messanger_files/' . $file_name;
        move_uploaded_file($file['tmp_name'], $pathFile);
    }
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
    
    $sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `file`, `nik`, `message_nik`) VALUES (NULL, '$chat_id', '$formattedDate', '$message_value', '$file_name', '$message_time', 0, 0, 0, $answer_id, $file_information, '$nik', '$message_nik')";
    $query = mysqli_query($bd_connect, $sql);

    //notification
    $moment_notification = "SELECT `messages` FROM `user_notification` WHERE `nik` = '$message_nik'";
    $moment_notification_query = mysqli_query($bd_connect, $moment_notification);
    $resolt_message_num = mysqli_real_escape_string($bd_connect, mysqli_fetch_assoc($moment_notification_query)['messages'] + 1);
    $notification_sql = null;
    if ($get_user_resolt["mute"] == 0){
        $notification_sql = "UPDATE `user_notification` SET `messages` = $resolt_message_num WHERE `nik` = '$message_nik'";
    } else{
        $notification_sql = "UPDATE `user_notification` SET `messages` = 0 WHERE `nik` = '$message_nik'";
    }
    $notification_query = mysqli_query($bd_connect, $notification_sql);

    header("Location: ../../pages/messages.php?chat_id=$chat_id");
} else {
    header("Location: ../../pages/home.php");
}
?>