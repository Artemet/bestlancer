<?php
include "database_connect.php";

$nik = $_POST["user_nik"];
$check_duplicate_sql = "SELECT COUNT(*) FROM `user_registoring` WHERE `nik` = '$nik'";
$check_duplicate_query = mysqli_query($bd_connect, $check_duplicate_sql);
$duplicate_count = mysqli_fetch_row($check_duplicate_query)[0];

if ($duplicate_count > 0) {
    echo 'duplicate';
    exit;
} else{
    $role = $_POST["user_role"];
    $name = $_POST["user_name"];
    $family = $_POST["user_family"];
    $email = $_POST["user_email"];
    $password = $_POST["user_password"];
    $country = $_POST["user_country"];
    $nik = $_POST["user_nik"];

    //value_check
    if (empty($role) || empty($name) || empty($email) || empty($password) || empty($country) || empty($user_nik)){
        exit;
    }

    if ($role != "seller" && $role != "buyer"){
        exit;
    }

    if (strlen($password) <= 7 ||
        strpos($password, "&") === false &&
        strpos($password, "$") === false &&
        strpos($password, "_") === false &&
        strpos($password, "-") === false &&
        strpos($password, "#") === false &&
        preg_match('/[a-zA-Z]/', $password) &&
        preg_match('/\d/', $password)) {
        exit;
    }

    if (strlen($nik) <= 4){
        exit;
    }

    $registor_sql = "INSERT INTO `user_registoring` (`id`, `email`, `name`, `family`, `nik`, `password`, `country`, `age`, `skills`, `about`, `projects`, `filter`, `application_date`, `payment_methods`, `chat_bg`, `work_time`, `price`, `icon_path`, `status`, `role`) VALUES (NULL, '$email', '$name', '$family', '$nik', '$password', '$country', 23, '', '', '', '', '', '', 'http://localhost/bestlancer/bd_send/user/messanger/chat_background/normal_background.jpg', '10:00', 800, 'user.png', 'offline', '$role')";
    $registor_query = mysqli_query($bd_connect, $registor_sql);
}
?>