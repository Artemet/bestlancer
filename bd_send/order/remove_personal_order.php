<?php
    session_start();
    if (!isset($_SESSION["nik"])){
        header("Location: ../../pages/home.php");
        exit();
    }
    include "../database_connect.php";
    $nik = $_SESSION["nik"];
    if (isset($_GET['personal_order_id']) && is_numeric($_GET['personal_order_id'])) {
        $personal_order_id = $_GET['personal_order_id'];
        $sql = "DELETE FROM personal_orders WHERE id = ? AND nik = ?";
        $stmt = mysqli_prepare($bd_connect, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $personal_order_id, $nik);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        exit();
    }
    header("Location: ../../pages/notification_page.php");
?>