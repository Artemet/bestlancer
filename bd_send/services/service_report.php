<?php
session_start();
include "../database_connect.php";
$report_options = array("Оскарбление", "Мошенничество", "Обман", "Угрозы", "Другое");
if (isset($_SESSION["nik"])) {
    //page_id
    $service_id = $_GET['service_id'];
    $service_sql = "SELECT * FROM services WHERE id = ?";
    $stmt_service = mysqli_prepare($bd_connect, $service_sql);
    mysqli_stmt_bind_param($stmt_service, "i", $service_id);
    mysqli_stmt_execute($stmt_service);
    $service_query = mysqli_stmt_get_result($stmt_service);
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
    $spam_sql = "SELECT `service_id` FROM `service_report` WHERE `nik` = ?";
    $stmt_spam = mysqli_prepare($bd_connect, $spam_sql);
    mysqli_stmt_bind_param($stmt_spam, "s", $report_nik);
    mysqli_stmt_execute($stmt_spam);
    $spam_query = mysqli_stmt_get_result($stmt_spam);
    while (mysqli_fetch_assoc($spam_query)) {
        $spam_temp++;
    }
    if ($spam_temp >= 1) {
        exit;
    }

    $sql = "INSERT INTO `service_report` (`id`, `report_option`, `report_description`, `service_id`, `nik`) VALUES (NULL, ?, ?, ?, ?)";
    $stmt_report = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt_report, "ssis", $report_option, $report_description, $service_id, $report_nik);
    $query = mysqli_stmt_execute($stmt_report);
    header("Location: ../positive/correct_report.php");
} else {
    header("Location: ../../pages/home.php");
}
?>