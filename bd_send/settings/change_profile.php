<?php
    session_start();
    $user_id = "";
    if (isset($_SESSION["nik"])){
        $user_id = $_SESSION["id"];
    } else{
        header("Location: ../../pages/home.php");
        exit();
    }
    include "../database_connect.php";
    //posts
    $email = $_POST["email"];
    $role = $_POST["role"];
    //main_change
    $role_arr = array("Продавец", "Покупатель");
    if (!in_array($role, $role_arr)){
        header("Location: ../../pages/home.php");
        exit();
    } elseif ($role == $role_arr[0]){
        $role = "seller";
    } elseif ($role == $role_arr[1]){
        $role = "buyer";
    }
    $email = mysqli_real_escape_string($bd_connect, $email);
    $role = mysqli_real_escape_string($bd_connect, $role);
    $update_sql = "UPDATE `user_registoring` SET `email` = '$email', `role` = '$role' WHERE `id` = '$user_id'";
    $update_query = mysqli_query($bd_connect, $update_sql);
    if (!$update_query){
        header("Location: ../warnings/web_error.php");
    } else{
        header("Location: ../../pages/home.php");
        session_destroy();
    }
?>