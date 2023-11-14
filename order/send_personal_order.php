<?php
session_start();
include "../database_connect.php";
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $user_sql = "SELECT * FROM user_registoring WHERE id = $user_id";
    $user_query = mysqli_query($bd_connect, $user_sql);
    $user = mysqli_fetch_assoc($user_query);
}
$order_name = $_POST["order_name"];
$order_information = $_POST["order_information"];
$order_nik = $user['nik'];
$nik = $_SESSION['nik'];
//file_send
if (!empty($_FILES['file_send'])) {
    $file = $_FILES['file_send'];
    $file_name = $file['name'];
    $pathFile = __DIR__ . '/personal_order_files/' . $file_name;
    if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
        header("Location: ../positive/positive_order_send.php");
    } else {
        header("Location: ../positive/positive_order_send.php");
    }
}
$order_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `type`) VALUES (NULL, '$order_name', '$order_information', '$file_name', '$order_nik', '$nik', 'personal')";
$order_query = mysqli_query($bd_connect, $order_sql);
if ($order_query) {
    $notification_row = false;
    $notification_check = "SELECT `nik` FROM `user_notification` WHERE `nik` = '$order_nik'";
    $notification_check_query = mysqli_query($bd_connect, $notification_check);
    while ($notification_system = mysqli_fetch_assoc($notification_check_query)) {
        $notification_row = true;
    }
    if ($notification_row == false) {
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, 0, 1, '$order_nik')";
    } elseif ($notification_row == true) {
        $old_notification = "SELECT `bell` FROM `user_notification` WHERE `nik` = '$order_nik'";
        $old_notification_query = mysqli_query($bd_connect, $old_notification);
        $old_notification_resolt = mysqli_fetch_assoc($old_notification_query)['bell'] + 1;
        $old_notification_resolt = mysqli_real_escape_string($bd_connect, $old_notification_resolt);
        $notification_sql = "UPDATE `user_notification` SET `bell` = '$old_notification_resolt' WHERE `nik` = '$order_nik'";
    }
    $notification_query = mysqli_query($bd_connect, $notification_sql);
}
?>