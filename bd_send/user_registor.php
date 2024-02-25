<?php
include "database_connect.php";

$duplicate_count = 0;

if (!isset($_GET["main_registor"]) && !isset($_GET["email_check"])) {
    $nik = $_POST["checking_user_nik"];
    $check_duplicate_sql = "SELECT COUNT(*) FROM `user_registoring` WHERE `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $check_duplicate_sql);
    mysqli_stmt_bind_param($stmt, "s", $nik);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $duplicate_count);
    mysqli_stmt_fetch($stmt);
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
        $registor_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $registor_sql);
        mysqli_stmt_bind_param($stmt, "s", $my_nik);
        mysqli_stmt_execute($stmt);
        $registor_query = mysqli_stmt_get_result($stmt);
        while (mysqli_fetch_assoc($registor_query)) {
            $user_catch = true;
        }
        mysqli_stmt_close($stmt);
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

    $standart_int_index = 0;
    $hour_price = 800;
    $user_activity = "offline";
    $empty_table = "";
    $age = 23;
    $work_time = "10:00";
    $user_icon = "user.png";
    $chat_background = "http://localhost/bestlancer/bd_send/user/messanger/chat_background/normal_backgroud.jpg";
    $registor_sql = "INSERT INTO `user_registoring` (`id`, `email`, `name`, `family`, `wallet`, `nik`, `password`, `country`, `age`, `skills`, `about`, `projects`, `filter`, `application_date`, `payment_methods`, `chat_bg`, `work_time`, `price`, `icon_path`, `orders`, `status`, `role`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $registor_stmt = mysqli_prepare($bd_connect, $registor_sql);
    mysqli_stmt_bind_param($registor_stmt, "sssisssissssssssisiss", $email, $name, $family, $standart_int_index, $my_nik, $password, $country, $age, $empty_table, $empty_table, $empty_table, $empty_table, $empty_table, $empty_table, $chat_background, $work_time, $hour_price, $user_icon, $standart_int_index, $user_activity, $role);
    $registor_query = mysqli_stmt_execute($registor_stmt);

    //notification_make
    if ($registor_query) {
        $message_length = 0;
        $bell_length = 0;
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, ?, ?, ?)";
        $notification_stmt = mysqli_prepare($bd_connect, $notification_sql);
        mysqli_stmt_bind_param($notification_stmt, "iis", $message_length, $bell_length, $my_nik);
        $notification_query = mysqli_stmt_execute($notification_stmt);
    }
} elseif (isset($_GET["email_check"]) && is_numeric($_GET["email_check"])) {
    $my_code = null;
    $sending_email = $_POST["my_email"];
    for ($i = 0; $i < 4; $i++) {
        $my_code .= rand(0, 9);
    }
    echo $my_code;
    $code_send = mail("$sending_email", "Код проверки", "Ваш код: $my_code");
}
?>