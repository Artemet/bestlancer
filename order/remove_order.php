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
        $order_sql = "SELECT * FROM `orders_responses` WHERE `nik` = '$my_nik' AND `order_id` = $deleted_id";
        $order_query = mysqli_query($bd_connect, $order_sql);
        while (mysqli_fetch_assoc($order_query)) {
            $check_resolt = false;
        }
        return $check_resolt;
    }
    function order_bd($table)
    {
        global $bd_connect, $order_id;
        $order_sql = "SELECT * FROM `orders` WHERE `id` = $order_id";
        $order_query = mysqli_query($bd_connect, $order_sql);
        $order_resolt = mysqli_fetch_assoc($order_query)[$table];
        return $order_resolt;
    }
    if (true) {
        $remove_response_sql = "UPDATE `orders` SET `responsible_id` = 0, `progress` = 1 WHERE `id` = $order_id";
        $remove_response_query = mysqli_query($bd_connect, $remove_response_sql);
        //add_notification
        $orderer_nik = order_bd('nik');
        $order_name = order_bd('order_name');
        $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, '$order_name', '$my_name отказался(лась) от заказа', '', '$orderer_nik', '$my_nik', '00:00:00', '29 ноября', 0, 'refusal')";
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            //notification_number
            function bell_add()
            {
                global $bd_connect, $my_nik, $orderer_nik;
                $bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = '$orderer_nik'";
                $bell_query = mysqli_query($bd_connect, $bell_sql);
                $bell_resolt = mysqli_fetch_assoc($bell_query)['bell'];
                return intval($bell_resolt) + 1;
            }
            $bell_resolt = bell_add();
            $bell_update_sql = "UPDATE `user_notification` SET `bell` = $bell_resolt WHERE `nik` = '$orderer_nik'";
            $bell_update_query = mysqli_query($bd_connect, $bell_update_sql);
            //message_send
            function message_send()
            {
                global $bd_connect, $orderer_nik, $my_nik;
                function chat_id()
                {
                    global $bd_connect, $orderer_nik, $my_nik;
                    $chat_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = '$my_nik' AND `nik_two` = '$orderer_nik') OR (`nik_one` = '$orderer_nik' AND `nik_two` = '$my_nik')";
                    $chat_query = mysqli_query($bd_connect, $chat_sql);
                    return mysqli_fetch_assoc($chat_query)['chat_id'];
                }
                $chat_id = chat_id();

                //time
                $message_time = date('H:i');
                $formattedDate = date('d.m.Y');
                $message_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `task`, `file`, `nik`, `message_nik`) VALUES (NULL, $chat_id, '$formattedDate', 'Я отменил заказ', '', '$message_time', 0, 0, 0, 0, 3, 0, '$my_nik', '$orderer_nik')";
                $message_query = mysqli_query($bd_connect, $message_sql);
                echo mysqli_error($bd_connect);
                if ($message_query) {
                    function old_message_length()
                    {
                        global $bd_connect, $orderer_nik;
                        $length_sql = "SELECT `messages` FROM `user_notification` WHERE `nik` = '$orderer_nik'";
                        $length_query = mysqli_query($bd_connect, $length_sql);
                        return mysqli_fetch_assoc($length_query)['messages'];
                    }
                    $message_length = intval(old_message_length()) + 1;
                    $length_notification_sql = "UPDATE `user_notification` SET `messages` = $message_length WHERE `nik` = '$orderer_nik'";
                    mysqli_query($bd_connect, $length_notification_sql);

                    //order_notifications_delete
                    function notifications_delete()
                    {
                        global $bd_connect, $order_id;
                        $notification_sql = "DELETE FROM `notifications` WHERE `order_information` = '$order_id'";
                        mysqli_query($bd_connect, $notification_sql);
                    }
                    notifications_delete();
                }
            }
            message_send();
        }
    }
}
?>