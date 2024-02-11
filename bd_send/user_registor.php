<?php
include "database_connect.php";

$duplicate_count = 0;

if (!isset($_GET["main_registor"]) && !isset($_GET["email_check"])) {
    $nik = $_POST["checking_user_nik"];
    $check_duplicate_sql = "SELECT COUNT(*) FROM `user_registoring` WHERE `nik` = '$nik'";
    $check_duplicate_query = mysqli_query($bd_connect, $check_duplicate_sql);
    $duplicate_count = mysqli_fetch_row($check_duplicate_query)[0];
}

if ($duplicate_count > 0) {
    echo 'duplicate';
    exit;
}
if (isset($_GET["main_registor"]) && is_numeric($_GET["main_registor"])) {
    $role = $_POST["user_role"];
    $name = $_POST["user_name"];
    $family = $_POST["user_family"];
    $email = $_POST["user_email"];
    $password = $_POST["user_password"];
    $country = $_POST["user_country"];
    $my_nik = $_POST["user_nik"];

    function check_registor()
    {
        global $bd_connect, $my_nik;
        $user_catch = false;
        $registor_sql = "SELECT * FROM `user_registoring` WHERE `nik` = '$my_nik'";
        $registor_query = mysqli_query($bd_connect, $registor_sql);
        while (mysqli_fetch_assoc($registor_query)) {
            $user_catch = true;
        }
        return $user_catch;
    }
    if (check_registor() == true) {
        exit;
    }
    //value_check
    if (empty($role) || empty($name) || empty($email) || empty($password) || empty($country) || empty($my_nik)) {
        exit;
    } elseif ($role != "seller" && $role != "buyer") {
        exit;
    }
    if (
        strlen($password) <= 7 ||
        strpos($password, "&") == false &&
        strpos($password, "$") == false &&
        strpos($password, "_") == false &&
        strpos($password, "-") == false &&
        strpos($password, "#") == false &&
        strpos($password, "!") == false &&
        strpos($password, "@") == false &&
        preg_match('/[a-zA-Z]/', $password) &&
        preg_match('/\d/', $password)
    ) {
        exit;
    }
    if (strlen($my_nik) <= 4) {
        exit;
    }
    $registor_sql = "INSERT INTO `user_registoring` (`id`, `email`, `name`, `family`, `nik`, `password`, `country`, `age`, `skills`, `about`, `projects`, `filter`, `application_date`, `payment_methods`, `chat_bg`, `work_time`, `price`, `icon_path`, `orders`, `status`, `role`) VALUES (NULL, '$email', '$name', '$family', '$my_nik', '$password', '$country', 23, '', '', '', '', '', '', 'http://localhost/bestlancer/bd_send/user/messanger/chat_background/normal_backgroud.jpg', '10:00', 800, 'user.png', 0, 'offline', '$role')";
    $registor_query = mysqli_query($bd_connect, $registor_sql);

    //notification_make
    if ($registor_query) {
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, 0, 0, '$my_nik')";
        $notification_query = mysqli_query($bd_connect, $notification_sql);
    }
} elseif (isset($_GET["email_check"])) {
    $my_code = null;
    for ($i = 0; $i < 4; $i++) {
        $my_code .= rand(0, 9);
    }
    echo $my_code;
}
?>