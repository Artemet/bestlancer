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
    $result = mysqli_stmt_get_result($stmt);
    $news = mysqli_fetch_assoc($result);

    if ($news) {
        $likes = $news["likes"] + 1;
        $sql = "UPDATE news SET likes = ? WHERE id = ?";
        $stmt = mysqli_prepare($bd_connect, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $likes, $news_id);
        mysqli_stmt_execute($stmt);

        $nik_array = array($user_nik);
        print_r($nik_array);
    } else {
        echo "News not found.";
    }
}
?>