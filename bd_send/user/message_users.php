<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$nik = $_SESSION["nik"];
$task_message = 0;

//date
function formatRussianDate($dateString)
{
    $date = DateTime::createFromFormat('Y.m.d', $dateString);
    if ($date instanceof DateTime) {
        $monthsTranslation = [
            'January' => 'января',
            'February' => 'февраля',
            'March' => 'марта',
            'April' => 'апреля',
            'May' => 'мая',
            'June' => 'июня',
            'July' => 'июля',
            'August' => 'августа',
            'September' => 'сентября',
            'October' => 'октября',
            'November' => 'ноября',
            'December' => 'декабря'
        ];
        $formattedDate = $date->format('j') . ' ' . $monthsTranslation[$date->format('F')];
        return $formattedDate;
    } else {
        return "Invalid date format";
    }
}
$normal_date = date("Y.m.d");
$resolt_date = formatRussianDate($normal_date);
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $previous_page = null;
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous_page = $_SERVER['HTTP_REFERER'];
    }
    $sql = "SELECT * FROM `user_registoring` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($query);
    //posts
    $thirst_message = $_POST["thirst_message"];
    if (empty($thirst_message) && strpos($previous_page, "user_id") == true) {
        header("Location: ../../pages/home.php");
        exit;
    } elseif (strpos($previous_page, "order_id") == true) {
        $order_id = intval($_POST["order_id"]);
        if (empty($thirst_message)) {
            $thirst_message = "Привет! Тебе поступил заказ.";
        }
        function order_check()
        {
            global $bd_connect, $order_id, $nik;
            $check_sql = "SELECT `nik` FROM `orders` WHERE `id` = ?";
            $stmt = mysqli_prepare($bd_connect, $check_sql);
            mysqli_stmt_bind_param($stmt, "i", $order_id);
            mysqli_stmt_execute($stmt);
            $check_query = mysqli_stmt_get_result($stmt);
            $resolt_nik = mysqli_fetch_assoc($check_query)['nik'];
            if ($nik == $resolt_nik) {
                return true;
            } else {
                return false;
            }
        }
        function order_bd($table)
        {
            global $bd_connect, $order_id;
            $order_sql = "SELECT * FROM `orders` WHERE `id` = ?";
            $stmt = mysqli_prepare($bd_connect, $order_sql);
            mysqli_stmt_bind_param($stmt, "i", $order_id);
            mysqli_stmt_execute($stmt);
            $order_query = mysqli_stmt_get_result($stmt);
            $order_resolt = mysqli_fetch_assoc($order_query)[$table];
            return $order_resolt;
        }
        if (order_check() == true) {
            //money is ok == true
            $user_id = $user['id'];
            $user_nik = $user['nik'];
            $order_progress = 2;
            $change_progress = "UPDATE `orders` SET `responsible_id` = ?, `progress` = ? WHERE `id` = ?";
            $stmt = mysqli_prepare($bd_connect, $change_progress);
            mysqli_stmt_bind_param($stmt, "iii", $user_id, $order_progress, $order_id);
            mysqli_stmt_execute($stmt);

            if ($change_progress_query) {
                $task_message = 1;
                //notification
                $orderer_person = null;
                $orderer_nik = order_bd('nik');
                $order_name = order_bd('order_name');
                function orderer_name()
                {
                    global $bd_connect, $orderer_person, $orderer_nik;
                    $name_sql = "SELECT `name` FROM `user_registoring` WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $name_sql);
                    mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
                    mysqli_stmt_execute($stmt);
                    $name_query = mysqli_stmt_get_result($stmt);
                    $orderer_person = mysqli_fetch_assoc($name_query)['name'];
                }
                orderer_name();
                //time
                $notification_time = date('H:i');

                $notification_file = "";
                $notification_sum = 0;
                $notification_type = "execution";
                $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $notification_stmt = mysqli_prepare($bd_connect, $notification_sql);
                mysqli_stmt_bind_param($notification_stmt, "sssssssis", $order_name, $order_id, $notification_file, $user_nik, $orderer_nik, $notification_time, $resolt_date, $notification_sum, $notification_type);
                $notification_query = mysqli_stmt_execute($notification_stmt);
                //notification_add
                if ($notification_query) {
                    function notification_add()
                    {
                        global $bd_connect, $user_nik;
                        $bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
                        $stmt = mysqli_prepare($bd_connect, $bell_sql);
                        mysqli_stmt_bind_param($stmt, "s", $user_nik);
                        mysqli_stmt_execute($stmt);
                        $bell_query = mysqli_stmt_get_result($stmt);
                        $bells = mysqli_fetch_assoc($bell_query)['bell'];
                        return intval($bells) + 1;
                    }
                    $bell_resolt = notification_add();
                    $add_bell_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $add_bell_sql);
                    mysqli_stmt_bind_param($stmt, "is", $bell_resolt, $user_nik);
                    mysqli_stmt_execute($stmt);
                }
            }
            function chat_id_response()
            {
                global $bd_connect, $nik, $user_nik;
                $chat_sql = "SELECT `chat_id` FROM `messenger_users` WHERE ((`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?))";
                try {
                    $stmt = mysqli_prepare($bd_connect, $chat_sql);
                    mysqli_stmt_bind_param($stmt, "ssss", $nik, $user_nik, $user_nik, $nik);
                    mysqli_stmt_execute($stmt);
                    $chat_query = mysqli_stmt_get_result($stmt);
                    if ($chat_query) {
                        $chat_resolt = mysqli_fetch_assoc($chat_query);
                        if ($chat_resolt !== null && isset($chat_resolt['chat_id'])) {
                            return $chat_resolt['chat_id'];
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                } catch (Exception $e) {
                    return 0;
                }
            }
            echo chat_id_response();
        }
    }
    $message_user = $user['nik'];
    $message_user_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = ? OR `nik_two` = ?";
    $stmt = mysqli_prepare($bd_connect, $message_user_sql);
    mysqli_stmt_bind_param($stmt, "ss", $nik, $nik);
    mysqli_stmt_execute($stmt);
    $message_user_query = mysqli_stmt_get_result($stmt);
    $add_user = true;
    if (strpos($previous_page, "user_id") == true || strpos($previous_page, "order_id") == true) {
        while ($message_user_row = mysqli_fetch_assoc($message_user_query)) {
            if ($message_user_row['nik_one'] == $message_user || $message_user_row['nik_two'] == $message_user) {
                $add_user = false;
            }
        }
        $messenger_id = 0;
        $messenger_statud = "unblock";
        $messenger_main_block = "";
        $messenger_int_index = 0;
        $messenger_sql = "INSERT INTO `messenger_users` (`id`, `chat_id`, `nik_one`, `nik_two`, `status`, `main_block`, `attach`, `message_attach`, `deleted`, `mute`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($add_user) {
            $messenger_stmt = mysqli_prepare($bd_connect, $messenger_sql);
            mysqli_stmt_bind_param($messenger_stmt, "issssiiii", $messenger_id, $nik, $message_user, $messenger_statud, $messenger_main_block, $messenger_int_index, $messenger_int_index, $messenger_int_index, $messenger_int_index);
            mysqli_stmt_execute($messenger_stmt);
        }
    }

    $chat_id_sql = "SELECT id FROM `messenger_users` WHERE ((`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?))";
    $stmt = mysqli_prepare($bd_connect, $chat_id_sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nik, $message_user, $message_user, $nik);
    mysqli_stmt_execute($stmt);
    $chat_id_query = mysqli_stmt_get_result($stmt);
    $chat_id_resolt = mysqli_fetch_assoc($chat_id_query)['id'];
    //date
    setlocale(LC_TIME, 'ru_RU.utf8');
    $date = time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($date);
    $formattedDate = date('d.m.Y');
    //time
    $current_time = date('H:i:s');
    $message_file = "";
    $messages_classic_index = 0;
    $chat_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `task`, `file`, `nik`, `message_nik`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $chat_stmt = mysqli_prepare($bd_connect, $chat_sql);
    mysqli_stmt_bind_param($chat_stmt, "issssiiiiiiss", $chat_id_resolt, $formattedDate, $thirst_message, $message_file, $current_time, $messages_classic_index, $messages_classic_index, $messages_classic_index, $messages_classic_index, $task_message, $messages_classic_index, $nik, $message_user);
    $chat_query = mysqli_stmt_execute($chat_stmt);
    if ($chat_query) {
        function old_message_length()
        {
            global $bd_connect, $message_user;
            $messages_sql = "SELECT `messages` FROM `user_notification` WHERE `nik` = ?";
            $stmt = mysqli_prepare($bd_connect, $messages_sql);
            mysqli_stmt_bind_param($stmt, "s", $message_user);
            mysqli_stmt_execute($stmt);
            $messages_query = mysqli_stmt_get_result($stmt);
            $messages_resolt = mysqli_fetch_assoc($messages_query);
            return intval($messages_resolt['messages']);
        }
        $message_length_resolt = old_message_length();
        $message_add_sql = "UPDATE `user_notification` SET `messages` = ? WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $message_add_sql);
        mysqli_stmt_bind_param($stmt, "is", $message_length_resolt, $message_user);
        mysqli_stmt_execute($stmt);
    }

    //new_chat_id
    $new_id_sql = "UPDATE `messenger_users` SET `chat_id` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $new_id_sql);
    mysqli_stmt_bind_param($stmt, "ii", $chat_id_resolt, $chat_id_resolt);
    mysqli_stmt_execute($stmt);

} else if (isset($_GET['user_attach']) && is_numeric($_GET['user_attach'])) {
    $attach_id = $_GET['user_attach'];
    $attach_change = null;

    // user_check
    function user_check()
    {
        global $nik, $attach_id, $bd_connect;
        $check_resolt = false;
        $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";

        $stmt = mysqli_prepare($bd_connect, $check_sql);
        mysqli_stmt_bind_param($stmt, "ssi", $nik, $nik, $attach_id);
        mysqli_stmt_execute($stmt);
        $check_query = mysqli_stmt_get_result($stmt);

        if (mysqli_fetch_assoc($check_query)) {
            $check_resolt = true;
        }

        return $check_resolt;
    }
    if (user_check() == false) {
        exit("Ошибка!");
    }
    //user_attach
    $attach_check_sql = "SELECT `attach` FROM `messenger_users` WHERE `chat_id` = ?";
    $stmt = mysqli_prepare($bd_connect, $attach_check_sql);
    mysqli_stmt_bind_param($stmt, "i", $attach_id);
    mysqli_stmt_execute($stmt);
    $attach_check_query = mysqli_stmt_get_result($stmt);
    $attach_check_resolt = mysqli_fetch_assoc($attach_check_query)['attach'];

    if ($attach_check_resolt == 0) {
        $attach_change = 1;
    } else {
        $attach_change = 0;
    }
    //attach_update
    $attach_update_sql = "UPDATE `messenger_users` SET `attach` = ? WHERE `chat_id` = ?";
    $stmt = mysqli_prepare($bd_connect, $attach_update_sql);
    mysqli_stmt_bind_param($stmt, "ii", $attach_change, $attach_id);
    mysqli_stmt_execute($stmt);
} else if (isset($_GET["mute_chat"]) && is_numeric($_GET["mute_chat"])) {
    $mute_id = $_GET["mute_chat"];
    $last_mute = null;
    function muted_id_check()
    {
        global $nik, $mute_id, $bd_connect, $last_mute;
        $check = false;
        $check_sql = "SELECT `mute` FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
        $stmt = mysqli_prepare($bd_connect, $check_sql);
        mysqli_stmt_bind_param($stmt, "ssi", $nik, $nik, $mute_id);
        mysqli_stmt_execute($stmt);
        $chat_query = mysqli_stmt_get_result($stmt);
        while ($chat_resolt = mysqli_fetch_assoc($chat_query)) {
            if ($chat_resolt['mute'] == 0) {
                $last_mute = 1;
            } else {
                $last_mute = 0;
            }
            $check = true;
        }
        return $check;
    }

    if (muted_id_check() == false) {
        header("Location: ../../pages/home.php");
        exit;
    }
    $update_mute_sql = "UPDATE `messenger_users` SET `mute` = ? WHERE `chat_id` = ?";
    $stmt = mysqli_prepare($bd_connect, $update_mute_sql);
    mysqli_stmt_bind_param($stmt, "ii", $last_mute, $mute_id);
    mysqli_stmt_execute($stmt);
} else {
    header("Location: ../../pages/home.php");
    exit;
}
?>