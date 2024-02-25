<?php
session_start();
include "../../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../../pages/home.php");
    exit;
}
$my_nik = $_SESSION["nik"];
if (isset($_GET['order_id']) && is_numeric($_GET['order_id']) && isset($_SESSION["nik"])) {
    $order_id = $_GET['order_id'];
    $order_sql = "SELECT * FROM `orders` WHERE `id` = ?";
    $order_query = mysqli_prepare($bd_connect, $order_sql);
    mysqli_stmt_bind_param($order_query, "i", $order_id);
    mysqli_stmt_execute($order_query);
    $order_result = mysqli_stmt_get_result($order_query);

    $data = [
        "user_name" => mysqli_fetch_assoc($order_result)['order_name'],
        "order_id" => $_GET['order_id'],
        "invited_user" => $_POST["user_nik"],
        "my_user" => $_SESSION["nik"]
    ];

    //double_send_check
    $invites_count = 0;
    $invite_check = "SELECT * FROM `notifications` WHERE `type` = 'invite' AND `order_information` = ? AND `nik` = ?";
    $invite_query = mysqli_prepare($bd_connect, $invite_check);
    mysqli_stmt_bind_param($invite_query, "is", $order_id, $my_nik);
    mysqli_stmt_execute($invite_query);
    $invite_result = mysqli_stmt_get_result($invite_query);
    while ($invite_resolt = mysqli_fetch_assoc($invite_result)) {
        $invites_count++;
    }
    if ($invites_count >= 2) {
        header("Location: ../../../pages/home.php");
        exit;
    }

    $invite_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, '', ?, ?, '00:00:00', '9 октября', 0, 'invite')";
    $invite_query = mysqli_prepare($bd_connect, $invite_sql);

    mysqli_stmt_bind_param($invite_query, "ssss", $data["user_name"], $data["order_id"], $data["invited_user"], $data["my_user"]);
    mysqli_stmt_execute($invite_query);
    mysqli_stmt_close($invite_query);

    //notification_call
    $user = $data["invited_user"];
    $old_notification = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
    $old_notification_query = mysqli_prepare($bd_connect, $old_notification);
    mysqli_stmt_bind_param($old_notification_query, "s", $user);
    mysqli_stmt_execute($old_notification_query);
    $old_notification_result = mysqli_stmt_get_result($old_notification_query);
    $old_notification_resolt = mysqli_fetch_assoc($old_notification_result)['bell'] + 1;
    $old_notification_resolt = mysqli_real_escape_string($bd_connect, $old_notification_resolt);
    $notification_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
    $notification_query = mysqli_prepare($bd_connect, $notification_sql);
    mysqli_stmt_bind_param($notification_query, "is", $old_notification_resolt, $user);
    mysqli_stmt_execute($notification_query);
} else {
    header("Location: ../../../pages/home.php");
}
?>