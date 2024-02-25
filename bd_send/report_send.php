<?php
session_start();
include "./database_connect.php";
$report_options = array("Оскарбление", "Мошенничество", "Обман", "Угрозы", "Другое");
if (isset($_SESSION["nik"])) {
    $my_nik = $_SESSION["nik"];
    if (isset($_GET["service_id"]) && is_numeric($_GET["service_id"])) {
        //page_id
        $service_id = $_GET['service_id'];
        $service_sql = "SELECT * FROM services WHERE id = ?";
        $service_query = mysqli_prepare($bd_connect, $service_sql);
        mysqli_stmt_bind_param($service_query, "i", $service_id);
        mysqli_stmt_execute($service_query);
        $service_result = mysqli_stmt_get_result($service_query);
        $service = mysqli_fetch_assoc($service_result);
        //posts
        $report_option = $_POST["report_option"];
        $report_description = $_POST["report_description"];
        if (!in_array($report_option, $report_options)) {
            header("Location: ../pages/service_page.php?service_id=$service_id");
            exit;
        }
        //user_spam_resport_check
        $spam_temp = 0;
        $spam_sql = "SELECT `service_id` FROM `reports` WHERE `nik` = ? AND `service_id` >= 1";
        $spam_query = mysqli_prepare($bd_connect, $spam_sql);
        mysqli_stmt_bind_param($spam_query, "s", $my_nik);
        mysqli_stmt_execute($spam_query);
        $spam_result = mysqli_stmt_get_result($spam_query);
        while (mysqli_fetch_assoc($spam_result)) {
            $spam_temp++;
        }
        if ($spam_temp >= 1) {
            exit;
        }

        $sql = "INSERT INTO `reports` (`id`, `report_option`, `report_description`, `service_id`, `chat_id`, `nik`) VALUES (NULL, ?, ?, ?, 0, ?)";
        $query = mysqli_prepare($bd_connect, $sql);
        mysqli_stmt_bind_param($query, "ssis", $report_option, $report_description, $service_id, $my_nik);
        mysqli_stmt_execute($query);
        header("Location: ../positive/correct_report.php");
    } elseif (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
        $chat_id = $_GET["chat_id"];
        function chat_check()
        {
            global $my_nik, $chat_id, $bd_connect;
            $check = false;
            $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `chat_id` = ?";
            $check_query = mysqli_prepare($bd_connect, $check_sql);
            mysqli_stmt_bind_param($check_query, "ssi", $my_nik, $my_nik, $chat_id);
            mysqli_stmt_execute($check_query);
            $check_result = mysqli_stmt_get_result($check_query);
            while (mysqli_fetch_assoc($check_result)) {
                $check = true;
            }
            return $check;
        }
        if (chat_check() == true) {
            $report_option = $_POST["report_option"];
            $report_description = $_POST["report_description"];
            if (empty($report_option) || empty($report_description)) {
                exit("Ошибка, нельзя отправить пустые данные!");
            }
            if (in_array($report_option, $report_options)) {
                $report_make_sql = "INSERT INTO `reports` (`id`, `report_option`, `report_description`, `service_id`, `chat_id`, `nik`) VALUES (NULL, ?, ?, 0, ?, ?)";
                $report_query = mysqli_prepare($bd_connect, $report_make_sql);
                mysqli_stmt_bind_param($report_query, "ssis", $report_option, $report_description, $chat_id, $my_nik);
                mysqli_stmt_execute($report_query);
            }
        }
    }
} else {
    header("Location: ../pages/home.php");
}
?>