<?php
session_start();
include "../database_connect.php";

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $user_sql = "SELECT * FROM user_registoring WHERE id = ?";
    $stmt = mysqli_prepare($bd_connect, $user_sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $user_query = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($user_query);
}

$order_name = $_POST["order_name"];
$order_information = $_POST["order_information"];
$order_nik = $user['nik'];
$nik = $_SESSION['nik'];
$file_name = '';

if (!empty($_FILES['file_send'])) {
    $file = $_FILES['file_send'];
    $file_name = $file['name'];
    $pathFile = __DIR__ . '/personal_order_files/' . $file_name;
    if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
        header("Location: ../positive/positive_order_send.php");
        exit;
    }
}

$order_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, ?, ?, ?, '00:00:00', '5 сентября', 0, 'personal')";
$stmt = mysqli_prepare($bd_connect, $order_sql);
mysqli_stmt_bind_param($stmt, "ssssss", $order_name, $order_information, $file_name, $order_nik, $nik);
mysqli_stmt_execute($stmt);

if ($stmt) {
    $notification_row = false;
    $notification_check = "SELECT `nik` FROM `user_notification` WHERE `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $notification_check);
    mysqli_stmt_bind_param($stmt, "s", $order_nik);
    mysqli_stmt_execute($stmt);
    $notification_check_query = mysqli_stmt_get_result($stmt);
    while ($notification_system = mysqli_fetch_assoc($notification_check_query)) {
        $notification_row = true;
    }

    if ($notification_row == false) {
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, 0, 1, ?)";
    } elseif ($notification_row == true) {
        $old_notification = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $old_notification);
        mysqli_stmt_bind_param($stmt, "s", $order_nik);
        mysqli_stmt_execute($stmt);
        $old_notification_query = mysqli_stmt_get_result($stmt);
        $old_notification_resolt = mysqli_fetch_assoc($old_notification_query)['bell'] + 1;
        $notification_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
    }
    $stmt = mysqli_prepare($bd_connect, $notification_sql);
    mysqli_stmt_bind_param($stmt, "is", $old_notification_resolt, $order_nik);
    mysqli_stmt_execute($stmt);
}
?>