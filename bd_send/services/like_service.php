<?php
session_start();
include "../database_connect.php";
$like_repetition = 0;
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
}
$user_nik = $_SESSION["nik"];
if (isset($_GET['like_id']) && is_numeric($_GET['like_id'])) {
    $like_id = $_GET['like_id'];
} else {
    exit("Услуга не найдена!");
}
$repetition_check = "SELECT * FROM `service_likes` WHERE `nik` = '$user_nik' AND `service_id` = '$like_id'";
$repetition_query = mysqli_query($bd_connect, $repetition_check);
while ($repetition_row = mysqli_fetch_assoc($repetition_query)) {
    $like_repetition++;
    if ($like_repetition == 1) {
        $delete_sql = "DELETE FROM `service_likes` WHERE `nik` = '$user_nik' AND `service_id` = '$like_id'";
        $delete_query = mysqli_query($bd_connect, $delete_sql);

        if (!$delete_query) {
            header("Location: ../warnings/web_error.php");
        } else {
            header("Location: ../../pages/service_page.php?service_id=$like_id");
        }
        exit;
    }
}

$like_sql = "INSERT INTO `service_likes` (`id`, `service_id`, `nik`) VALUES (NULL, '$like_id', '$user_nik')";
$like_query = mysqli_query($bd_connect, $like_sql);
if (!$like_query) {
    header("Location: ../warnings/web_error.php");
} else {
    header("Location: ../../pages/service_page.php?service_id=$like_id");
}
?>