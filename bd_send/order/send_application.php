<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$price = intval($_POST["price"]);
$payment_option = "";
$payment_choice = "";
$user_message = $_POST["user_message"];
//application_date
$date = date("Y.m.d");
$date_resolt = null;
list($year, $month, $day) = explode(".", $date);
$date_array = array($year, $month, $day);
for ($i = 0; $i < count($date_array); $i++) {
    if ($i >= 1) {
        $date_resolt .= ".";
    }
    $date_resolt .= $date_array[$i];
}
$nik = $_SESSION["nik"];

//vacancy
$order_id = null;
function vacancy_application_check()
{
    global $bd_connect, $order_id, $price, $user_message;
    $sql = "SELECT * FROM `orders` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);
    //main_logic
    if ($order["type"] == 1) {
        return true;
    } else {
        return false;
    }
}

//order
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    if (vacancy_application_check() == false) {
        $time = intval($_POST["time"]);
    }
    $sql = "SELECT * FROM `orders` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);
    $order_name = $order['order_name'];
    $orderer_nik = $order['nik'];

    //available_application_check
    function available_application_check()
    {
        global $order, $user_resolt, $orderer_nik;
        $good_application = $order['good_application'];
        $familiar_application = $order['familiar_application'];
        $users_level = $user_resolt['orders'];
        if ($good_application == 1) {
            if ($users_level <= 15) {
                exit;
            }
        } elseif ($familiar_application == 1) {
            function familiar_checking()
            {
                global $bd_connect, $orderer_nik, $nik, $available_class;
                $checking_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = ? AND `nik_two` = ?";
                $stmt = mysqli_prepare($bd_connect, $checking_sql);
                mysqli_stmt_bind_param($stmt, "ss", $orderer_nik, $nik);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 0) {
                    exit;
                }
            }
            familiar_checking();
        }
    }
    available_application_check();

    //block_check
    $user_blocked = false;
    $blocking_orderer = $order['nik'];
    $block_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)) AND `status` = 'block'";
    $stmt = mysqli_prepare($bd_connect, $block_sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nik, $orderer_nik, $orderer_nik, $nik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($block_resolt = mysqli_fetch_assoc($result)) {
        $user_blocked = true;
    }
    if ($user_blocked == true) {
        header("Location: ../../pages/make_application.php?order_id=$order_id");
        exit;
    }

    $existingResponseQuery = "SELECT * FROM `orders_responses` WHERE `order_name` = ? AND `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $existingResponseQuery);
    mysqli_stmt_bind_param($stmt, "ss", $order_name, $nik);
    mysqli_stmt_execute($stmt);
    $existingResponseResult = mysqli_stmt_get_result($stmt);

    //price_check
    $price_id_sql = "SELECT * FROM `orders` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $price_id_sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $price_id_row = mysqli_fetch_assoc($result);
    if ($price_id_row['order_price'] >= 1) {
        if ($price_id_row['order_price'] < $price || $price == 0) {
            header("Location: ../../pages/make_application.php?order_id=$order_id");
            exit;
        }
    }
    if (preg_match('/[a-zA-Z]/', $price)) {
        header("Location: ../../pages/make_application.php?order_id=$order_id");
        exit;
    }
    if (mysqli_num_rows($existingResponseResult) === 0) {
        //max_date_push
        $max_date_sql = "SELECT `application_date` FROM `user_registoring` WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $max_date_sql);
        mysqli_stmt_bind_param($stmt, "s", $nik);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $max_date_resolt = mysqli_fetch_assoc($result)['application_date'];

        function requisites_check()
        {
            global $bd_connect, $user_resolt;
            if (empty($user_resolt["payment_methods"])) {
                echo "no_method";
                exit;
            }
        }
        requisites_check();

        if (vacancy_application_check() == false) {
            $sql = "INSERT INTO `orders_responses` (`id`, `order_id`, `price`, `time`, `payment_option`, `payment_choice`, `user_message`, `nik`, `orderer_nik`, `order_name`, `response_date`, `max_date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($bd_connect, $sql);
            mysqli_stmt_bind_param($stmt, "iiissssssss", $order_id, $price, $time, $payment_option, $payment_choice, $user_message, $nik, $orderer_nik, $order_name, $date, $max_date_resolt);
        } else {
            $sql = "INSERT INTO `orders_responses` (`id`, `order_id`, `price`, `time`, `payment_option`, `payment_choice`, `user_message`, `nik`, `orderer_nik`, `order_name`, `response_date`, `max_date`) VALUES (NULL, ?, ?, 0, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($bd_connect, $sql);
            mysqli_stmt_bind_param($stmt, "iiisssssss", $order_id, $price, $payment_option, $payment_choice, $user_message, $nik, $orderer_nik, $order_name, $date, $max_date_resolt);
        }
        mysqli_stmt_execute($stmt);
        echo mysqli_error($bd_connect);
        if ($stmt) {
            //time
            $notification_time = date('H:i');
            $date = "16 апреля";
            $notification_file = '';
            $notification_sum = 0;
            $notification_type = "application";
            $notification_add = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($bd_connect, $notification_add);
            mysqli_stmt_bind_param($stmt, "sssssssis", $order_name, $order_id, $notification_file, $orderer_nik, $nik, $notification_time, $date, $notification_sum, $notification_type);
            mysqli_stmt_execute($stmt);
        }
    }

    //user_notification
    $notification_row = false;
    $notification_check = "SELECT `nik` FROM `user_notification` WHERE `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $notification_check);
    mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($notification_system = mysqli_fetch_assoc($result)) {
        $notification_row = true;
    }
    if ($notification_row == false) {
        $notification_sql = "INSERT INTO `user_notification` (`id`, `messages`, `bell`, `nik`) VALUES (NULL, 0, 1, ?)";
        $stmt = mysqli_prepare($bd_connect, $notification_sql);
        mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
        mysqli_stmt_execute($stmt);
    } elseif ($notification_row == true) {
        $old_notification = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $old_notification);
        mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $old_notification_resolt = mysqli_fetch_assoc($result)['bell'] + 1;
        $old_notification_resolt = mysqli_real_escape_string($bd_connect, $old_notification_resolt);
        $notification_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $notification_sql);
        mysqli_stmt_bind_param($stmt, "is", $old_notification_resolt, $orderer_nik);
        mysqli_stmt_execute($stmt);
    }
} else {
    $order_name = "Заказ не найден!";
}
?>