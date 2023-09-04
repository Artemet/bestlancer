<?php
    session_start();
    include "../database_connect.php";
    $price = $_POST["price"];
    $time = $_POST["time"];
    $payment_option = $_POST["payment_option"];
    $payment_choice = $_POST["payment_choice"];
    $user_message = $_POST["user_message"];
    $nik = $_SESSION["nik"];
    if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $sql = "SELECT * FROM orders WHERE id = $order_id";
        $query = mysqli_query($bd_connect, $sql);
        $order = mysqli_fetch_assoc($query);
        $order_name = $order['order_name'];
        $orderer_nik = $order['nik'];
        
        // Проверяем, существует ли уже заказ от этого пользователя для данного заказа
        $existingResponseQuery = "SELECT * FROM `orders_responses` WHERE `order_name` = '$order_name' AND `nik` = '$nik'";
        $existingResponseResult = mysqli_query($bd_connect, $existingResponseQuery);
        
        if (mysqli_num_rows($existingResponseResult) === 0) {
            $sql = "INSERT INTO `orders_responses` (`id`, `price`, `time`, `payment_option`, `payment_choice`, `user_message`, `nik`, `orderer_nik`, `order_name`) VALUES (NULL, '$price', '$time', '$payment_option', '$payment_choice', '$user_message', '$nik', '$orderer_nik', '$order_name')";
            $query = mysqli_query($bd_connect, $sql);
        }
    } else {
        $order_name = "Заказ не найден!";
    }
    header("Location: ../../pages/order_page.php?order_id=$order_id");
?>