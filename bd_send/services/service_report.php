<?php
    session_start();
    include "../database_connect.php";
    $report_options = array("Оскарбление", "Мошенничество", "Обман", "Угрозы", "Другое");
    if (isset($_SESSION["nik"])){
        //page_id
        $service_id = $_GET['service_id'];
        $service_sql = "SELECT * FROM services WHERE id = $service_id";
        $service_query = mysqli_query($bd_connect, $service_sql);
        $service = mysqli_fetch_assoc($service_query);
        //posts
        $report_option = $_POST["report_option"];
        $report_description = $_POST["report_description"];
        if (!in_array($report_option, $report_options)){
            header("Location: ../../pages/service_page.php?service_id=$service_id");
            exit();
        }
        $sql = "INSERT INTO `service_report` (`id`, `report_option`, `report_description`, `service_id`) VALUES (NULL, '$report_option', '$report_description', '$service_id')";
        $query = mysqli_query($bd_connect, $sql);
        header("Location: ../positive/correct_report.php");
    } else{
        header("Location: ../../pages/home.php");
    }
?>