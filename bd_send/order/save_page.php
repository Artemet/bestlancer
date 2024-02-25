<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
//send_page
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = $_SERVER['HTTP_REFERER'];
    $my_nik = $_SESSION["nik"];
    //old_filter
    $sql_old = "SELECT `filter` FROM `user_registoring` WHERE `nik` = ?";
    $stmt_old = mysqli_prepare($bd_connect, $sql_old);
    mysqli_stmt_bind_param($stmt_old, "s", $my_nik);
    mysqli_stmt_execute($stmt_old);
    $result_old = mysqli_stmt_get_result($stmt_old);
    $row_old = mysqli_fetch_assoc($result_old);
    $resolt = $row_old['filter'];

    //new_filter
    if (!empty($resolt)) {
        $sql_update = "UPDATE `user_registoring` SET `filter` = '' WHERE `nik` = ?";
        $stmt_update = mysqli_prepare($bd_connect, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "s", $my_nik);
    } else {
        $sql_update = "UPDATE `user_registoring` SET `filter` = ? WHERE `nik` = ?";
        $stmt_update = mysqli_prepare($bd_connect, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ss", $previous_page, $my_nik);
    }

    mysqli_stmt_execute($stmt_update);
} else {
    header("Location: ../../pages/home.php");
}
?>