<?php
session_start();
include "../database_connect.php";
function warning_teleport()
{
    header("Location: ../../pages/home.php");
    exit;
}

if (!isset($_SESSION["nik"])) {
    warning_teleport();
} else {
    $my_nik = $_SESSION["nik"];
}
if (isset($_GET['service_id']) && is_numeric($_GET['service_id'])) {
    $service_id = $_GET['service_id'];
} else {
    warning_teleport();
}
//cheat_check
$cheat_sql = "SELECT `nik` FROM `services` WHERE `id` = ?";
$cheat_stmt = mysqli_prepare($bd_connect, $cheat_sql);
mysqli_stmt_bind_param($cheat_stmt, "i", $service_id);
mysqli_stmt_execute($cheat_stmt);
$cheat_result = mysqli_stmt_get_result($cheat_stmt);
$cheat_row = mysqli_fetch_assoc($cheat_result);
if (!$cheat_row || $my_nik !== $cheat_row['nik']) {
    warning_teleport();
}

//main_send
if (!empty($_FILES['file_name'])) {
    $file = $_FILES['file_name'];
    $file_name = $file['name'];
    $pathFile = __DIR__ . '/service_files/' . $file_name;
    if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
        echo 'Ошибка';
    }
}
$service_name = $_POST["service_name"];
$service_price = $_POST["service_price"];
$service_context = $_POST["service_context"];
if (empty($service_name) || empty($service_price) || empty($service_context) || $service_price <= 4) {
    header("Location: ../../pages/service_page.php?service_id=$service_id");
    exit;
}
$update_sql = "UPDATE `services` SET `name` = ?, `price` = ?, `information` = ? WHERE `id` = ?";
$update_stmt = mysqli_prepare($bd_connect, $update_sql);
mysqli_stmt_bind_param($update_stmt, "sdsi", $service_name, $service_price, $service_context, $service_id);
$update_result = mysqli_stmt_execute($update_stmt);
if (!$update_result) {
    warning_teleport();
}
header("Location: ../../pages/service_page.php?service_id=$service_id");
?>