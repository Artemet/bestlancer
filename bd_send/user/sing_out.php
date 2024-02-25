<?php
session_start();
include "../database_connect.php";

if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = $_SERVER['HTTP_REFERER'];
}

$nik = $_SESSION["nik"];
$status = "offline";

$status = mysqli_real_escape_string($bd_connect, $status);
$nik = mysqli_real_escape_string($bd_connect, $nik);

$status_sql = "UPDATE `user_registoring` SET `status` = ? WHERE `nik` = ?";
$status_query = mysqli_prepare($bd_connect, $status_sql);
mysqli_stmt_bind_param($status_query, "ss", $status, $nik);

if (mysqli_stmt_execute($status_query)) {
    session_destroy();
    header("Location: $previous_page");
    exit;
} else {
    echo "Error updating status";
}

mysqli_stmt_close($status_query);
mysqli_close($bd_connect);
?>