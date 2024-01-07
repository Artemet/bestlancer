<?php
session_start();
include "../database_connect.php";
$report_options = array("Оскарбление", "Мошенничество", "Обман", "Угрозы", "Другое");
if (isset($_SESSION["nik"])) {
    //page_id
    $service_id = $_GET['service_id'];
    $service_sql = "SELECT * FROM services WHERE id = $service_id";
    $service_query = mysqli_query($bd_connect, $service_sql);
    $service = mysqli_fetch_assoc($service_query);
    //posts
    $report_nik = $_SESSION["nik"];
    $report_option = $_POST["report_option"];
    $report_description = $_POST["report_description"];
    if (!in_array($report_option, $report_options)) {
        header("Location: ../../pages/service_page.php?service_id=$service_id");
        exit;
    }
    //user_spam_resport_check
    $spam_temp = 0;
    $spam_sql = "SELECT `service_id` FROM `reports` WHERE `service_id` = '$service_id' AND `nik` = '$report_nik'";
    $spam_query = mysqli_query($bd_connect, $spam_sql);
    while (mysqli_fetch_assoc($spam_query)) {
        $spam_temp++;
    }
    if ($spam_temp >= 1) {
        exit;
    }

    $sql = "INSERT INTO `reports` (`id`, `report_option`, `report_description`, `service_id`, `nik`) VALUES (NULL, '$report_option', '$report_description', '$service_id', '$report_nik')";
    $query = mysqli_query($bd_connect, $sql);
    header("Location: ../positive/correct_report.php");
} else {
    header("Location: ../../pages/home.php");
}
?>