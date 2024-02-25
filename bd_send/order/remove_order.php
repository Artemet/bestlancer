<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
include "../database_connect.php";
$my_nik = $_SESSION["nik"];
$my_name = $_SESSION["name"];
$deleted_id = $_POST["notification_id"];
function delete_notification()
{
    global $bd_connect, $my_nik, $deleted_id;
    $sql = "DELETE FROM notifications WHERE id = ? AND nik = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $deleted_id, $my_nik);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
//delete_notification();
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET["order_id"];
    function order_check()
    {
        global $bd_connect, $order_id, $my_nik, $deleted_id;
        $check_resolt = true;
        $order_sql = "SELECT * FROM `orders_responses` WHERE `nik` = ? AND `order_id` = ?";
        $order_stmt = mysqli_prepare($bd_connect, $order_sql);
        mysqli_stmt_bind_param($order_stmt, "si", $my_nik, $deleted_id);
        mysqli_stmt_execute($order_stmt);
        $order_query = mysqli_stmt_get_result($order_stmt);
        if (mysqli_num_rows($order_query) >= 1) {
            $check_resolt = false;
        }
        return $check_resolt;
    }
    function order_bd($table)
    {
        global $bd_connect, $order_id;
        $order_sql = "SELECT * FROM `orders` WHERE `id` = ?";
        $order_stmt = mysqli_prepare($bd_connect, $order_sql);
        mysqli_stmt_bind_param($order_stmt, "i", $order_id);
        mysqli_stmt_execute($order_stmt);
        $order_query = mysqli_stmt_get_result($order_stmt);
        $order_resolt = mysqli_fetch_assoc($order_query)[$table];
        return $order_resolt;
    }
    $remove_response_list = array(0, 1, $order_id);
    $remove_response_sql = "UPDATE `orders` SET `responsible_id` = ?, `progress` = ? WHERE `id` = ?";
    $remove_response_stmt = mysqli_prepare($bd_connect, $remove_response_sql);
    mysqli_stmt_bind_param($remove_response_stmt, "iii", $remove_response_list[0], $remove_response_list[1], $remove_response_list[2]);
    mysqli_stmt_execute($remove_response_stmt);
    mysqli_stmt_get_result($remove_response_stmt);
    //add_notification
    $orderer_nik = order_bd('nik');
    $order_name = order_bd('order_name');
    $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, '', ?, ?, '00:00:00', '29 ноября', 0, 'refusal')";
    $stmt = mysqli_prepare($bd_connect, $notification_sql);
    mysqli_stmt_bind_param($stmt, "ssss", $order_name, $notification_message, $orderer_nik, $my_nik);
    $notification_query = mysqli_stmt_execute($stmt);
    if ($notification_query) {
        //notification_number
        function bell_add()
        {
            global $bd_connect, $my_nik, $orderer_nik;
            $bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
            $stmt = mysqli_prepare($bd_connect, $bell_sql);
            mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $bell_resolt = mysqli_fetch_assoc($result)['bell'];
            return intval($bell_resolt) + 1;
        }
        $bell_resolt = bell_add();
        $bell_update_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $bell_update_sql);
        mysqli_stmt_bind_param($stmt, "is", $bell_resolt, $orderer_nik);
        mysqli_stmt_execute($stmt);
        //message_send
        function message_send()
        {
            global $bd_connect, $orderer_nik, $my_nik;
            function chat_id()
            {
                global $bd_connect, $orderer_nik, $my_nik;
                $chat_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)";

                $stmt = mysqli_prepare($bd_connect, $chat_sql);
                mysqli_stmt_bind_param($stmt, "ssss", $my_nik, $orderer_nik, $orderer_nik, $my_nik);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $chat_id = $row['chat_id'];
                mysqli_stmt_close($stmt);

                return $chat_id;
            }
            $chat_id = chat_id();

            //time
            $message_time = date('H:i');
            $formattedDate = date('d.m.Y');
            $message_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `task`, `file`, `nik`, `message_nik`) VALUES (NULL, ?, ?, 'Я отменил заказ', '', ?, 0, 0, 0, 0, 3, 0, ?, ?)";
            $stmt = mysqli_prepare($bd_connect, $message_sql);
            mysqli_stmt_bind_param($stmt, "sssss", $chat_id, $formattedDate, $message_time, $my_nik, $orderer_nik);
            $message_query = mysqli_stmt_execute($stmt);
            if ($message_query) {
                function old_message_length()
                {
                    global $bd_connect, $orderer_nik;
                    $length_sql = "SELECT `messages` FROM `user_notification` WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $length_sql);
                    mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    return $row['messages'];
                }
                $message_length = intval(old_message_length()) + 1;
                $length_notification_sql = "UPDATE `user_notification` SET `messages` = ? WHERE `nik` = ?";
                $stmt = mysqli_prepare($bd_connect, $length_notification_sql);
                mysqli_stmt_bind_param($stmt, "is", $message_length, $orderer_nik);
                mysqli_stmt_execute($stmt);

                //order_notifications_delete
                function notifications_delete()
                {
                    global $bd_connect, $order_id;
                    $notification_sql = "DELETE FROM `notifications` WHERE `order_information` = ?";
                    $stmt = mysqli_prepare($bd_connect, $notification_sql);
                    mysqli_stmt_bind_param($stmt, "s", $order_id);
                    mysqli_stmt_execute($stmt);
                }
                notifications_delete();
            }
        }
        message_send();
    }
}
?>