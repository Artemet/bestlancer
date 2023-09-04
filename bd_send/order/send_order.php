<?php
    session_start();
    include "../database_connect.php";
    $order_name = $_POST["order_name"];
    $order_information = $_POST["order_information"];
    if (!empty($_FILES['file_send'])){
        $file = $_FILES['file_send'];
        $file_name = $file['name'];
        $pathFile = __DIR__.'/order_files/'.$file_name;
        if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
            echo 'Ошибка';
        }
    }
    $order_price = $_POST["order_price"];
    $order_email = $_SESSION["email"];
    $order_category = $_POST["order_category"];
    $nik = $_SESSION["nik"];
    $sql = "INSERT INTO `orders` (`id`, `order_name`, `order_information`, `file_path`, `order_price`, `order_email`, `order_category`, `nik`) VALUES (NULL, '$order_name', '$order_information', '$file_name', '$order_price', '$order_email', '$order_category', '$nik')";
    $query = mysqli_query($bd_connect, $sql);
    header("location: ../../pages/tasks.php");
?>