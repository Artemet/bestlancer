<?php
    session_start();
    include "./database_connect.php";
    $report_options = array("Оскарбление", "Мошенничество", "Обман", "Угрозы", "Другое");
    if (isset($_SESSION["nik"])){
        $my_nik = $_SESSION["nik"];
        if (isset($_GET["service_id"]) && is_numeric($_GET["service_id"])){
            //page_id
            $service_id = $_GET['service_id'];
            $service_sql = "SELECT * FROM services WHERE id = $service_id";
            $service_query = mysqli_query($bd_connect, $service_sql);
            $service = mysqli_fetch_assoc($service_query);
            //posts
            $report_option = $_POST["report_option"];
            $report_description = $_POST["report_description"];
            if (!in_array($report_option, $report_options)){
                header("Location: ../pages/service_page.php?service_id=$service_id");
                exit;
            }
            //user_spam_resport_check
            $spam_temp = 0;
            $spam_sql = "SELECT `service_id` FROM `reports` WHERE `nik` = '$my_nik' AND `service_id` >= 1";
            $spam_query = mysqli_query($bd_connect, $spam_sql);
            while (mysqli_fetch_assoc($spam_query)){
                $spam_temp++;
            }
            if ($spam_temp >= 1){
                exit;
            }

            $sql = "INSERT INTO `reports` (`id`, `report_option`, `report_description`, `service_id`, `chat_id`, `nik`) VALUES (NULL, '$report_option', '$report_description', '$service_id', 0, '$my_nik')";
            $query = mysqli_query($bd_connect, $sql);
            header("Location: ../positive/correct_report.php");
        } elseif (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])){
            $chat_id = $_GET["chat_id"];
            function chat_check(){
                global $my_nik, $chat_id, $bd_connect;
                $check = false;
                $check_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = '$my_nik' OR `nik_two` = '$my_nik') AND `chat_id` = $chat_id";
                $check_query = mysqli_query($bd_connect, $check_sql);
                while (mysqli_fetch_assoc($check_query)){
                    $check = true;
                }
                return $check;
            }
            if (chat_check() == true){
                $report_option = $_POST["report_option"];
                $report_description = $_POST["report_description"];
                if (empty($report_option) || empty($report_description)){
                    exit("Ошибка, нельзя отправить пустые данные!");
                }
                if (in_array($report_option, $report_options)){
                    $report_make_sql = "INSERT INTO `reports` (`id`, `report_option`, `report_description`, `service_id`, `chat_id`, `nik`) VALUES (NULL, '$report_option', '$report_description', 0, $chat_id, '$my_nik')";
                    mysqli_query($bd_connect, $report_make_sql);
                }
            }
        }
    } else{
        header("Location: ../pages/home.php");
    }
?>