<?php
    session_start();
    include "../database_connect.php";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["country"]) && isset($_POST["age"]) && isset($_SESSION["nik"])) {
            $user_country = $_POST["country"];
            $user_age = $_POST["age"];
            $user_price = $_POST["hour_price"];
            $user_time = $_POST["start_time"];
            $about_user = $_POST["about_me"];
            $user_nik = $_SESSION["nik"];
            $user_country = mysqli_real_escape_string($bd_connect, $user_country);
            $user_age = mysqli_real_escape_string($bd_connect, $user_age);
            $user_price = mysqli_real_escape_string($bd_connect, $user_price);
            $user_time = mysqli_real_escape_string($bd_connect, $user_time);
            $about_user = mysqli_real_escape_string($bd_connect, $about_user);
            $user_nik = mysqli_real_escape_string($bd_connect, $user_nik);
            
            $sql = "UPDATE `user_registoring` SET `country` = '$user_country', `age` = '$user_age', `work_time` = '$user_time', `price` = '$user_price', `about` = '$about_user' WHERE `nik` = '$user_nik'";
            $query = mysqli_query($bd_connect, $sql);
            
            if (!$query) {
                header("Location: ../warnings/web_error.php");
                die('Ошибка выполнения запроса: ' . mysqli_error($bd_connect));
            }
            header("Location: ../../index.php");
            session_destroy();
            exit();
        }
    }
?>