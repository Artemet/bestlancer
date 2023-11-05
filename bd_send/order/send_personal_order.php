<?php
    session_start();
    include "../database_connect.php";
    if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $user_sql = "SELECT * FROM user_registoring WHERE id = $user_id";
        $user_query = mysqli_query($bd_connect, $user_sql);
        $user = mysqli_fetch_assoc($user_query);
    }
    $order_name = $_POST["order_name"];
    $order_information = $_POST["order_information"];
    $order_nik = $user['nik'];
    $nik = $_SESSION['nik'];
    //file_send
    if (!empty($_FILES['file_send'])){
        $file = $_FILES['file_send'];
        $file_name = $file['name'];
        $pathFile = __DIR__.'/personal_order_files/'.$file_name;
        if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
            header("Location: ../positive/positive_order_send.php");
        } else{
            header("Location: ../positive/positive_order_send.php");
        }
    }
    $order_sql = "INSERT INTO `personal_orders` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`) VALUES (NULL, '$order_name', '$order_information', '$file_name', '$order_nik', '$nik')";
    $order_query = mysqli_query($bd_connect, $order_sql);
?>