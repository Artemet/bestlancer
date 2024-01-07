<?php
    session_start();
    include "../database_connect.php";
    if (!isset($_SESSION["nik"])) {
        header("Location: ../../pages/home.php");
        exit();
    }
    $my_nik = $_SESSION["nik"];
    $notification_arr = $_POST["notification_arr"]; 
    for ($array_temp = 0; $array_temp < count($notification_arr); $array_temp++){
        $active_index = $notification_arr[$array_temp];
        $delete_sql = "DELETE FROM `notifications` WHERE `id` = $active_index AND (`order_nik` = '$my_nik' OR `nik` = '$my_nik')";
        $delete_query = mysqli_query($bd_connect, $delete_sql);
    }
?>