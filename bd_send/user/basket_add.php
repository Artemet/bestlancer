<?php
    session_start(); 
    include "../../bd_send/database_connect.php";
    $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
    if (isset($_GET['service_id']) && is_numeric($_GET['service_id'])) {
        if (isset($_SESSION["nik"])) {
            $basket_sql_check = "SELECT * FROM basket WHERE nik = ? AND product_name = ?";
            $basket_statement = mysqli_prepare($bd_connect, $basket_sql_check);
            mysqli_stmt_bind_param($basket_statement, "ss", $_SESSION["nik"], $service["name"]);
            mysqli_stmt_execute($basket_statement);
            $query_result = mysqli_stmt_get_result($basket_statement);
    
            if (mysqli_num_rows($query_result) > 0) {
                exit();
            } else{
                //sql_service
                $service_id = $_GET['service_id'];
                $sql = "SELECT * FROM services WHERE id = $service_id";
                $query = mysqli_query($bd_connect, $sql);
                $service = mysqli_fetch_assoc($query);
                //sql_basket
                $service_id_number = $service_id;
                $service_name = $service["name"];
                $author_nik = $service["nik"];
                $user_nik = $_SESSION["nik"];
                $basket_sql = "INSERT INTO `basket` (`id`, `product_name`, `service_id`, `nik`, `author_nik`) VALUES (NULL, '$service_name', '$service_id_number', '$user_nik', '$author_nik')";
                $basket_query = mysqli_query($bd_connect, $basket_sql);
            }
        }
    }
    mysqli_close($connection);
    header("Location: ../../pages/basket.php");
?>