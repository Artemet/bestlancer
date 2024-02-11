<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit();
}

$nik = $_SESSION["nik"];
include "../database_connect.php";

if (isset($_GET['basket_service_id']) && is_numeric($_GET['basket_service_id'])) {
    $basket_service_id = $_GET['basket_service_id'];
    $sql = "DELETE FROM basket WHERE service_id = ? AND nik = ?";
    if ($stmt = mysqli_prepare($bd_connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "is", $basket_service_id, $nik);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../pages/basket.php");
        } else {
            echo "Ошибка выполнения запроса: " . mysqli_error($bd_connect);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Ошибка подготовки запроса: " . mysqli_error($bd_connect);
    }
} else {
    exit;
}
?>