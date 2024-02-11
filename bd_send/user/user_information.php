<?php
session_start();
include "../database_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["country"]) && isset($_POST["age"]) && isset($_SESSION["nik"])) {
        if (!empty($_FILES['icon_choice'])) {
            $file = $_FILES['icon_choice'];
            $file_name = $file['name'];
            if (empty($file_name)) {
                $file_name = $_SESSION["icon_path"];
            }
            $pathFile = __DIR__ . '/user_icons/' . $file_name;
            if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
                $icon_resolt = null;
                function icon_change()
                {
                    global $bd_connect, $icon_resolt;
                    $my_nik = $_SESSION["nik"];
                    $icon_sql = "SELECT * FROM `user_registoring` WHERE `nik` = '$my_nik'";
                    $icon_query = mysqli_query($bd_connect, $icon_sql);
                    $icon_resolt = mysqli_fetch_assoc($icon_query)['icon_path'];
                    if ($icon_resolt == "user.png") {
                        return false;
                    } else {
                        return true;
                    }
                }
                if (icon_change() == false) {
                    $file_name = "user.png";
                } else {
                    $file_name = $icon_resolt;
                }
            }
        }
        $user_country = $_POST["country"];
        $user_age = $_POST["age"];
        if ($user_resolt["role"] == "seller") {
            $user_price = $_POST["hour_price"];
            $user_time = $_POST["start_time"];
        }
        $about_user = $_POST["about_me"];
        $user_nik = $_SESSION["nik"];
        $user_country = mysqli_real_escape_string($bd_connect, $user_country);
        $user_age = mysqli_real_escape_string($bd_connect, $user_age);
        if ($user_resolt["role"] == "seller") {
            $user_price = mysqli_real_escape_string($bd_connect, $user_price);
            $user_time = mysqli_real_escape_string($bd_connect, $user_time);
        }
        $about_user = mysqli_real_escape_string($bd_connect, $about_user);
        $user_nik = mysqli_real_escape_string($bd_connect, $user_nik);

        $sql = null;
        if ($user_resolt["role"] == "seller") {
            $sql = "UPDATE `user_registoring` SET `country` = '$user_country', `age` = '$user_age', `work_time` = '$user_time', `price` = '$user_price', `about` = '$about_user', `icon_path` = '$file_name' WHERE `nik` = '$user_nik'";
        } else {
            $sql = "UPDATE `user_registoring` SET `country` = '$user_country', `age` = '$user_age', `about` = '$about_user', `icon_path` = '$file_name' WHERE `nik` = '$user_nik'";
        }

        $query = mysqli_query($bd_connect, $sql);

        if (!$query) {
            header("Location: ../warnings/web_error.php");
            die('Ошибка выполнения запроса: ' . mysqli_error($bd_connect));
        }
        header("Location: ../../pages/user.php");
        exit();
    }
}
?>