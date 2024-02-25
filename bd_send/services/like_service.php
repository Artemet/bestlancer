<?php
session_start();
include "../database_connect.php";
$like_repetition = 0;
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$user_nik = $_SESSION["nik"];
if (isset($_GET['like_id']) && is_numeric($_GET['like_id'])) {
    $like_id = $_GET['like_id'];
} else {
    exit("Услуга не найдена!");
}

$repetition_check = "SELECT * FROM `service_likes` WHERE `nik` = ? AND `service_id` = ?";
$stmt = mysqli_prepare($bd_connect, $repetition_check);
mysqli_stmt_bind_param($stmt, "si", $user_nik, $like_id);
mysqli_stmt_execute($stmt);
$repetition_result = mysqli_stmt_get_result($stmt);

while ($repetition_row = mysqli_fetch_assoc($repetition_result)) {
    $like_repetition++;
    if ($like_repetition == 1) {
        $delete_sql = "DELETE FROM `service_likes` WHERE `nik` = ? AND `service_id` = ?";
        $delete_stmt = mysqli_prepare($bd_connect, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "si", $user_nik, $like_id);
        mysqli_stmt_execute($delete_stmt);

        if (!$delete_stmt) {
            header("Location: ../warnings/web_error.php");
        } else {
            header("Location: ../../pages/service_page.php?service_id=$like_id");
        }
        exit;
    }
}

$like_sql = "INSERT INTO `service_likes` (`id`, `service_id`, `nik`) VALUES (NULL, ?, ?)";
$like_stmt = mysqli_prepare($bd_connect, $like_sql);
mysqli_stmt_bind_param($like_stmt, "is", $like_id, $user_nik);
$like_query = mysqli_stmt_execute($like_stmt);

if (!$like_query) {
    header("Location: ../warnings/web_error.php");
} else {
    header("Location: ../../pages/service_page.php?service_id=$like_id");
}
?>