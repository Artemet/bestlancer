<?php
session_start();
include "../../bd_send/database_connect.php";
if (isset($_GET['service_id']) && is_numeric($_GET['service_id'])) {
    if (isset($_SESSION["nik"])) {
        $basket_sql_check = "SELECT * FROM basket WHERE nik = ? AND product_name = ?";
        $basket_statement = mysqli_prepare($bd_connect, $basket_sql_check);
        mysqli_stmt_bind_param($basket_statement, "ss", $_SESSION["nik"], $service["name"]);
        mysqli_stmt_execute($basket_statement);
        $query_result = mysqli_stmt_get_result($basket_statement);

        if (mysqli_num_rows($query_result) > 0) {
            exit();
        } else {
            //sql_service
            $service_id = $_GET['service_id'];
            $sql = "SELECT * FROM services WHERE id = ?";
            $query = mysqli_prepare($bd_connect, $sql);
            mysqli_stmt_bind_param($query, "i", $service_id);
            mysqli_stmt_execute($query);
            $service = mysqli_stmt_get_result($query);
            $service_row = mysqli_fetch_assoc($service);

            //sql_basket
            $service_id_number = $service_id;
            $service_name = $service_row["name"];
            $author_nik = $service_row["nik"];
            $user_nik = $_SESSION["nik"];
            $basket_sql = "INSERT INTO `basket` (`id`, `product_name`, `service_id`, `nik`, `author_nik`) VALUES (NULL, ?, ?, ?, ?)";
            $basket_query = mysqli_prepare($bd_connect, $basket_sql);
            mysqli_stmt_bind_param($basket_query, "siis", $service_name, $service_id_number, $user_nik, $author_nik);
            mysqli_stmt_execute($basket_query);
        }
    }
}
header("Location: ../../pages/basket.php");
?>