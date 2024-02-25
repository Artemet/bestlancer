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
$nik = $_SESSION["nik"];

if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    $stmt_order = mysqli_prepare($bd_connect, "SELECT `order_name`, `nik` FROM `orders` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt_order, "i", $order_id);
    mysqli_stmt_execute($stmt_order);
    $result_order = mysqli_stmt_get_result($stmt_order);
    $order = mysqli_fetch_assoc($result_order);
    $order_name = $order['order_name'];
    $orderer_nik = $order['nik'];

    $stmt_response_check = mysqli_prepare($bd_connect, "SELECT * FROM `orders_responses` WHERE `order_name` = ? AND `nik` = ?");
    mysqli_stmt_bind_param($stmt_response_check, "ss", $order_name, $nik);
    mysqli_stmt_execute($stmt_response_check);
    $existingResponseResult = mysqli_stmt_get_result($stmt_response_check);

    //price_check
    $stmt_price_check = mysqli_prepare($bd_connect, "SELECT `order_price` FROM `orders` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt_price_check, "i", $order_id);
    mysqli_stmt_execute($stmt_price_check);
    $result_price_check = mysqli_stmt_get_result($stmt_price_check);
    $price_id_row = mysqli_fetch_assoc($result_price_check);
    if ($price_id_row['order_price'] >= 1) {
        if ($price_id_row['order_price'] < $price || $price == 0 || preg_match('/[a-zA-Z]/', $price)) {
            header("Location: ../../pages/make_application.php?order_id=$order_id");
            exit;
        }
    }

    if (mysqli_num_rows($existingResponseResult) === 0) {
        $stmt_insert_response = mysqli_prepare($bd_connect, "INSERT INTO `orders_responses` (`id`, `order_id`, `price`, `time`, `payment_option`, `payment_choice`, `user_message`, `nik`, `orderer_nik`, `order_name`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_insert_response, "idsssssss", $order_id, $price, $time, $payment_option, $payment_choice, $user_message, $nik, $orderer_nik, $order_name);
        mysqli_stmt_execute($stmt_insert_response);

        //time
        $notification_time = date('H:i');

        $notification_add = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, '', ?, ?, ?, '3 октября', 0, 'application')";
        $stmt_notification_add = mysqli_prepare($bd_connect, $notification_add);
        mysqli_stmt_bind_param($stmt_notification_add, "ssiss", $order_name, $order_id, $orderer_nik, $nik, $notification_time);
        mysqli_stmt_execute($stmt_notification_add);
    }

    //user_notification
    $notification_row = false;
    $stmt_notification_check = mysqli_prepare($bd_connect, "SELECT `bell` FROM `user_notification` WHERE `nik` = ?");
    mysqli_stmt_bind_param($stmt_notification_check, "s", $orderer_nik);
    mysqli_stmt_execute($stmt_notification_check);
    $result_notification_check = mysqli_stmt_get_result($stmt_notification_check);
    $notification_system = mysqli_fetch_assoc($result_notification_check);
    if ($notification_system) {
        $notification_row = true;
    }

    if ($notification_row == false) {
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, 0, 1, ?)";
    } else {
        $old_notification_resolt = $notification_system['bell'] + 1;
        $notification_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
    }

    $stmt_notification_update = mysqli_prepare($bd_connect, $notification_sql);
    mysqli_stmt_bind_param($stmt_notification_update, "is", $old_notification_resolt, $orderer_nik);
    mysqli_stmt_execute($stmt_notification_update);
} else {
    $order_name = "Заказ не найден!";
}

header("Location: ../../pages/order_page.php?order_id=$order_id");
?>