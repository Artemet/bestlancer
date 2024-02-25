<?php
session_start();
include "../database_connect.php";
if (isset($_GET['news_id']) && is_numeric($_GET['news_id'])) {
    $user_nik = $_SESSION["nik"];
    $news_id = $_GET['news_id'];
    $sql = "SELECT * FROM news WHERE id = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $news_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $news = mysqli_fetch_assoc($query);
    //line_script
    $nik_array = array();
    $likes = $news["likes"] + 1;
    $likes_sql = "UPDATE `news` SET `likes` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $likes_sql);
    mysqli_stmt_bind_param($stmt, "ii", $likes, $news_id);
    mysqli_stmt_execute($stmt);
    array_push($nik_array, $user_nik);
    print_r($nik_array);
}
?>