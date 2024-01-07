<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$price = $_POST["price"];
$time = $_POST["time"];
$payment_option = $_POST["payment_option"];
$payment_choice = $_POST["payment_choice"];
$user_message = $_POST["user_message"];
//application_date
$date = date("Y.m.d");
$date_resolt = null;
list($year, $month, $day) = explode(".", $date);
$date_array = array($year, $month, $day);
for ($i = 0; $i < count($date_array); $i++) {
    if ($i >= 1) {
        $date_resolt .= ".";
    }
    $date_resolt .= $date_array[$i];
}
$nik = $_SESSION["nik"];
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT * FROM orders WHERE id = $order_id";
    $query = mysqli_query($bd_connect, $sql);
    $order = mysqli_fetch_assoc($query);
    $order_name = $order['order_name'];
    $orderer_nik = $order['nik'];

    //block_check
    $user_blocked = false;
    $blocking_orderer = $order['nik'];
    $block_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = '$nik' AND `nik_two` = '$message_user') OR (`nik_one` = '$message_user' AND `nik_two` = '$nik')) AND `status` = 'block'";
    $block_query = mysqli_query($bd_connect, $block_sql);
    while ($block_resolt = mysqli_fetch_assoc($block_query)) {
        $user_blocked = true;
    }
    if ($user_blocked == true) {
        header("Location: ../../pages/make_application.php?order_id=$order_id");
        exit;
    }

    $existingResponseQuery = "SELECT * FROM `orders_responses` WHERE `order_name` = '$order_name' AND `nik` = '$nik'";
    $existingResponseResult = mysqli_query($bd_connect, $existingResponseQuery);

    //price_check
    $price_id_sql = "SELECT * FROM `orders` WHERE `id` = '$order_id'";
    $price_id_query = mysqli_query($bd_connect, $price_id_sql);
    $price_id_row = mysqli_fetch_assoc($price_id_query);
    if ($price_id_row['order_price'] >= 1) {
        if ($price_id_row['order_price'] < $price || $price == 0) {
            header("Location: ../../pages/make_application.php?order_id=$order_id");
            exit;
        }
    }
    if (preg_match('/[a-zA-Z]/', $price)) {
        header("Location: ../../pages/make_application.php?order_id=$order_id");
        exit;
    }
    if (mysqli_num_rows($existingResponseResult) === 0) {
        //max_date_push
        $max_date_sql = "SELECT `application_date` FROM `user_registoring` WHERE `nik` = '$nik'";
        $max_date_query = mysqli_query($bd_connect, $max_date_sql);
        $max_date_resolt = mysqli_fetch_assoc($max_date_query)['application_date'];

        $sql = "INSERT INTO `orders_responses` (`id`, `order_id`, `price`, `time`, `payment_option`, `payment_choice`, `user_message`, `nik`, `orderer_nik`, `order_name`, `response_date`, `max_date`) VALUES (NULL, '$order_id', '$price', '$time', '$payment_option', '$payment_choice', '$user_message', '$nik', '$orderer_nik', '$order_name', '$date', '$max_date_resolt')";
        $order_query = mysqli_query($bd_connect, $sql);
        if ($order_query) {
            $notification_add = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `type`) VALUES (NULL, '$order_name', '$order_id', '', '$orderer_nik', '$nik', 'application')";
            $notification_query = mysqli_query($bd_connect, $notification_add);
        }
    }

    //user_notification
    $notification_row = false;
    $notification_check = "SELECT `nik` FROM `user_notification` WHERE `nik` = '$orderer_nik'";
    $notification_check_query = mysqli_query($bd_connect, $notification_check);
    while ($notification_system = mysqli_fetch_assoc($notification_check_query)) {
        $notification_row = true;
    }
    if ($notification_row == false) {
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, 0, 1, '$orderer_nik')";
    } elseif ($notification_row == true) {
        $old_notification = "SELECT `bell` FROM `user_notification` WHERE `nik` = '$orderer_nik'";
        $old_notification_query = mysqli_query($bd_connect, $old_notification);
        $old_notification_resolt = mysqli_fetch_assoc($old_notification_query)['bell'] + 1;
        $old_notification_resolt = mysqli_real_escape_string($bd_connect, $old_notification_resolt);
        $notification_sql = "UPDATE `user_notification` SET `bell` = '$old_notification_resolt' WHERE `nik` = '$orderer_nik'";
    }
    $notification_query = mysqli_query($bd_connect, $notification_sql);
} else {
    $order_name = "Заказ не найден!";
}
header("Location: ../../pages/my_responses.php");
?>