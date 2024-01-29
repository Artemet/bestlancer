<?php
    session_start();
    include "../database_connect.php";
    if (isset($_GET['news_id']) && is_numeric($_GET['news_id'])) {
        $user_nik = $_SESSION["nik"];
        $news_id = $_GET['news_id'];
        $sql = "SELECT * FROM news WHERE id = $news_id";
        $query = mysqli_query($bd_connect, $sql);
        $news = mysqli_fetch_assoc($query);
        //line_script
        $nik_array = array();
        $likes = $news["likes"]+1;
        $likes = mysqli_real_escape_string($bd_connect, $likes);
        $likes_sql = "UPDATE `news` SET `likes` = $likes WHERE `id` = $news_id";
        $likes_query = mysqli_query($bd_connect, $likes_sql);
        array_push($nik_array, $user_nik);
        print_r($nik_array);
    }
?>