<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
//chat_id
if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
    $chat_id = $_GET["chat_id"];
    $message_attach_command = $_POST["attach_command"];
    function delete_attach()
    {
        global $chat_id, $bd_connect;
        function attach_check()
        {
            global $my_nik, $bd_connect, $chat_id;
            $id_find = false;
            $chat_id_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
            $stmt_chat_id = mysqli_prepare($bd_connect, $chat_id_sql);
            mysqli_stmt_bind_param($stmt_chat_id, "sss", $my_nik, $my_nik, $chat_id);
            mysqli_stmt_execute($stmt_chat_id);
            $chat_id_query = mysqli_stmt_get_result($stmt_chat_id);
            while (mysqli_fetch_assoc($chat_id_query)) {
                $id_find = true;
            }
            return $id_find;
        }
        if (attach_check() == true) {
            $attach_number = 0;
            $delite_attach_sql = "UPDATE `messenger_users` SET `message_attach` = ? WHERE `chat_id` = ?";
            $stmt_delite_attach = mysqli_prepare($bd_connect, $delite_attach_sql);
            mysqli_stmt_bind_param($stmt_delite_attach, "ii", $attach_number, $chat_id);
            mysqli_stmt_execute($stmt_delite_attach);
        }
    }
    if (!empty($message_attach_command)) {
        delete_attach();
    }
} else if (isset($_GET["message_attach_id"]) && is_numeric($_GET["message_attach_id"])) {
    //message_attach
    $attaching_chat_id = null;
    $message_attach_id = $_POST["message_attach_id"];
    function attach_id_check()
    {
        global $attaching_chat_id, $message_attach_id, $bd_connect;
        if (!isset($_SESSION["nik"])) {
            return false;
        }
        $my_nik = $_SESSION["nik"];
        //message_check
        $user_find = false;
        $message_sql = "SELECT * FROM `messages` WHERE (`nik` = ? OR `message_nik` = ?) AND `id` = ?";
        $stmt_message = mysqli_prepare($bd_connect, $message_sql);
        mysqli_stmt_bind_param($stmt_message, "ssi", $my_nik, $my_nik, $message_attach_id);
        mysqli_stmt_execute($stmt_message);
        $message_query = mysqli_stmt_get_result($stmt_message);
        while ($message_find = mysqli_fetch_assoc($message_query)) {
            $attaching_chat_id = $message_find['chat_id'];
            $user_find = true;
        }
        if ($user_find == true) {
            return true;
        }
    }
    if (attach_id_check() == true) {
        $attach_update = "UPDATE `messenger_users` SET `message_attach` = ? WHERE `chat_id` = ?";
        $stmt_attach_update = mysqli_prepare($bd_connect, $attach_update);
        mysqli_stmt_bind_param($stmt_attach_update, "ii", $message_attach_id, $attaching_chat_id);
        mysqli_stmt_execute($stmt_attach_update);
    }
} else if (isset($_GET["user_block"]) && is_numeric($_GET["user_block"])) {
    //user_block
    $chat_id = $_GET["user_block"];
    $my_nik = $_SESSION["nik"];
    function user_block_check()
    {
        global $chat_id, $my_nik, $bd_connect;
        $check = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
        $stmt_check = mysqli_prepare($bd_connect, $check_sql);
        mysqli_stmt_bind_param($stmt_check, "ssi", $my_nik, $my_nik, $chat_id);
        mysqli_stmt_execute($stmt_check);
        $check_query = mysqli_stmt_get_result($stmt_check);
        while ($check_resolt = mysqli_fetch_assoc($check_query)) {
            $check = true;
        }
        return $check;
    }

    if (user_block_check() == true) {
        $resolt_sql = null;
        $messanger_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
        $stmt_messanger = mysqli_prepare($bd_connect, $messanger_sql);
        mysqli_stmt_bind_param($stmt_messanger, "ssi", $my_nik, $my_nik, $chat_id);
        mysqli_stmt_execute($stmt_messanger);
        $messanger_query = mysqli_stmt_get_result($stmt_messanger);
        $messanger_resolt = mysqli_fetch_assoc($messanger_query);

        $resolt_status = null;
        $resolt_main_block = null;
        $resolt_sql = "UPDATE `messenger_users` SET `status` = ?, `main_block` = ? WHERE `chat_id` = ?";
        $stmt_resolt = mysqli_prepare($bd_connect, $resolt_sql);
        if (empty($messanger_resolt['main_block']) || $messanger_resolt['main_block'] == $my_nik) {
            if ($messanger_resolt['status'] == "block") {
                $resolt_status = "unblock";
                $resolt_main_block = "";
                mysqli_stmt_bind_param($stmt_resolt, "ssi", $resolt_status, $resolt_main_block, $chat_id);
            } elseif ($messanger_resolt['status'] == "unblock") {
                $resolt_status = "block";
                $resolt_main_block = $my_nik;
                mysqli_stmt_bind_param($stmt_resolt, "ssi", $resolt_status, $resolt_main_block, $chat_id);
            }
        }
        mysqli_stmt_execute($stmt_resolt);
    }
} else if (isset($_GET["chat_delete"]) && is_numeric($_GET["chat_delete"])) {
    //chat_delete
    $chat_id = $_GET["chat_delete"];
    $my_nik = $_SESSION["nik"];
    $command = $_POST["add_command"];
    function chat_delete_check()
    {
        global $chat_id, $my_nik, $bd_connect;
        $check = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
        $stmt_check = mysqli_prepare($bd_connect, $check_sql);
        mysqli_stmt_bind_param($stmt_check, "sss", $my_nik, $my_nik, $chat_id);
        mysqli_stmt_execute($stmt_check);
        $check_query = mysqli_stmt_get_result($stmt_check);
        while (mysqli_fetch_assoc($check_query)) {
            $check = true;
        }
        return $check;
    }

    if (chat_delete_check() == true) {
        $value = null;
        if (empty($command)) {
            $value = 1;
        } else {
            $value = 0;
        }
        $delete_sql = "UPDATE `messenger_users` SET `deleted` = ? WHERE `chat_id` = ?";
        $stmt_delete = mysqli_prepare($bd_connect, $delete_sql);
        mysqli_stmt_bind_param($stmt_delete, "is", $value, $chat_id);
        mysqli_stmt_execute($stmt_delete);
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
    $formattedDate = date('d.m.Y');
    //time
    $message_time = date('Y-m-d H:i');
    //posts
    $answer_id = $_POST["answer_id"];
    $message_value = $_POST["message_value"];
    $stripped_value = strip_tags($message_value);

    if ($message_value !== $stripped_value) {
        exit("Недопустимые теги в сообщении");
    }

    $file_name = "";
    $file = $_FILES['file'];
    $file_information = 0;
    if (!empty($file)) {
        $file_information = 1;
        $file_name = $file['name'];
        $pathFile = __DIR__ . '/messanger_files/' . $file_name;
        move_uploaded_file($file['tmp_name'], $pathFile);
    }
    $message_nik = null;
    //get_user
    $get_user_sql = "SELECT * FROM `messenger_users` WHERE `chat_id` = ?";
    $stmt_get_user = mysqli_prepare($bd_connect, $get_user_sql);
    mysqli_stmt_bind_param($stmt_get_user, "s", $chat_id);
    mysqli_stmt_execute($stmt_get_user);
    $get_user_query = mysqli_stmt_get_result($stmt_get_user);
    $get_user_resolt = mysqli_fetch_assoc($get_user_query);
    if ($get_user_resolt["nik_one"] == $nik) {
        $message_nik = $get_user_resolt["nik_two"];
    } else {
        $message_nik = $get_user_resolt["nik_one"];
    }

    if (empty($message_value) && empty($file)) {
        header("Location: ../../pages/messages.php");
        exit;
    }

    $interval_catch = 0;
    function task_interval()
    {
        global $bd_connect, $nik, $interval_catch, $message_nik;
        $user_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
        $stmt_user = mysqli_prepare($bd_connect, $user_sql);
        mysqli_stmt_bind_param($stmt_user, "s", $message_nik);
        mysqli_stmt_execute($stmt_user);
        $user_query = mysqli_stmt_get_result($stmt_user);

        $order_progress = 2;
        $order_sql = "SELECT * FROM `orders` WHERE `progress` = ? AND (`nik` = ? OR `nik` = ?)";
        $stmt_order = mysqli_prepare($bd_connect, $order_sql);
        mysqli_stmt_bind_param($stmt_order, "iss", $order_progress, $nik, $message_nik);
        mysqli_stmt_execute($stmt_order);
        $order_query = mysqli_stmt_get_result($stmt_order);

        while ($order_resolt = mysqli_fetch_assoc($order_query)) {
            $user_row = mysqli_fetch_assoc($user_query);
            $user_id = $user_row['id'];
            if ($order_resolt['responsible_id'] == $user_id) {
                $interval_catch = 1;
            } else {
                $interval_catch = 0;
            }
        }
    }
    //task_interval();
    $eye = 0;
    $changeable = 0;
    $deleted = 0;
    $task_message = 0;
    $sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `task`, `file`, `nik`, `message_nik`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $message_stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($message_stmt, "issssiiiiiiss", $chat_id, $formattedDate, $message_value, $file_name, $message_time, $eye, $changeable, $deleted, $answer_id, $task_message, $file_information, $nik, $message_nik);
    mysqli_stmt_execute($message_stmt);

    //notification
    $moment_notification = "SELECT `messages` FROM `user_notification` WHERE `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $moment_notification);
    mysqli_stmt_bind_param($stmt, "s", $message_nik);
    mysqli_stmt_execute($stmt);
    $moment_notification_query = mysqli_stmt_get_result($stmt);
    $resolt_message_num = mysqli_real_escape_string($bd_connect, mysqli_fetch_assoc($moment_notification_query)['messages'] + 1);
    $notification_sql = null;

    $messages_num = null;
    $notification_sql = "UPDATE `user_notification` SET `messages` = ? WHERE `nik` = ?";
    if ($get_user_resolt["mute"] == 0) {
        $messages_num = $resolt_message_num;
    } else {
        $messages_num = 0;
    }
    $notification_stmt = mysqli_prepare($bd_connect, $notification_sql);
    mysqli_stmt_bind_param($notification_stmt, "is", $messages_num, $message_nik);
    mysqli_stmt_execute($notification_stmt);

    header("Location: ../../pages/messages.php?chat_id=$chat_id");
} else {
    header("Location: ../../pages/home.php");
}
?>