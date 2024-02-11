<?php
session_start();
include "../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$my_nik = $_SESSION["nik"];
$my_id = $_SESSION["id"];
//date
function formatRussianDate($dateString)
{
    $date = DateTime::createFromFormat('Y.m.d', $dateString);
    if ($date instanceof DateTime) {
        $monthsTranslation = [
            'January' => 'января',
            'February' => 'февраля',
            'March' => 'марта',
            'April' => 'апреля',
            'May' => 'мая',
            'June' => 'июня',
            'July' => 'июля',
            'August' => 'августа',
            'September' => 'сентября',
            'October' => 'октября',
            'November' => 'ноября',
            'December' => 'декабря'
        ];
        $formattedDate = $date->format('j') . ' ' . $monthsTranslation[$date->format('F')];
        return $formattedDate;
    } else {
        return "Invalid date format";
    }
}
$normal_date = date("Y.m.d");
$resolt_date = formatRussianDate($normal_date);


if (isset($_GET["order_id"]) && is_numeric($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    function order_bd($table)
    {
        global $bd_connect, $order_id;
        $order_sql = "SELECT * FROM `orders` WHERE `id` = $order_id";
        $order_query = mysqli_query($bd_connect, $order_sql);
        $order_resolt = mysqli_fetch_assoc($order_query);
        return $order_resolt[$table];
    }
    $responsible_id = order_bd("responsible_id");
    function responsible_nik()
    {
        global $bd_connect, $responsible_id;
        $user_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = $responsible_id";
        $user_query = mysqli_query($bd_connect, $user_sql);
        return mysqli_fetch_assoc($user_query)['nik'];
    }
    function order_check()
    {
        global $bd_connect, $my_nik, $order_id;
        $check_resolt = false;
        $check_sql = "SELECT * FROM `notifications` WHERE `order_information` = '$order_id' AND `order_nik` = '$my_nik'";
        $check_query = mysqli_query($bd_connect, $check_sql);
        while (mysqli_fetch_assoc($check_query)) {
            $check_resolt = true;
        }
        return $check_resolt;
    }
    if (order_check() == true) {
        $order_sql = "UPDATE `orders` SET `responsible_id` = $my_id, `progress` = 2, `time` = 1 WHERE `id` = $order_id";
        $order_query = mysqli_query($bd_connect, $order_sql);
        if ($order_query) {
            //send_notification
            $order_name = order_bd("order_name");
            $customers_nik = order_bd("nik");
            $responsible_nik = responsible_nik();

            //time
            $notification_time = date('H:i');

            $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, '$order_name', '$order_id', '', '$customers_nik', '$responsible_nik', '$notification_time', '$resolt_date', 0, 'order_start')";
            $notification_query = mysqli_query($bd_connect, $notification_sql);
            if ($notification_query) {
                function old_bell_length()
                {
                    global $bd_connect, $responsible_nik, $customers_nik;
                    $old_bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = '$customers_nik'";
                    $old_bell_query = mysqli_query($bd_connect, $old_bell_sql);
                    $old_bell_resolt = mysqli_fetch_assoc($old_bell_query);
                    return intval($old_bell_resolt);
                }
                $final_bell = old_bell_length();
                //add_bell
                $bell_sql = "UPDATE `user_notification` SET `bell` = $final_bell WHERE `nik` = '$customers_nik'";
                mysqli_query($bd_connect, $bell_sql);
                //delete_unsensable_nutification
                function delete_notification()
                {
                    global $bd_connect, $responsible_nik, $order_id;
                    $notification_sql = "DELETE FROM `notifications` WHERE `order_information` = $order_id AND `order_nik` = '$responsible_nik'";
                    mysqli_query($bd_connect, $notification_sql);
                }
                delete_notification();
            }
        }
    }
} elseif (isset($_GET["action_order_id"]) && is_numeric($_GET["action_order_id"])) {
    $order_id = $_GET["action_order_id"];
    $action_id = intval($_POST["action_id"]);
    function order_information($table, $in_check)
    {
        global $bd_connect, $my_nik, $my_id, $action_id, $order_id;
        $order_resolt = null;
        //order_check
        $order_sql = "SELECT * FROM `orders` WHERE `id` = $order_id";
        $order_query = mysqli_query($bd_connect, $order_sql);
        if (empty($table) && $in_check == 1) {
            $order_resolt = mysqli_fetch_assoc($order_query);
            if ($order_resolt['responsible_id'] != $my_id && $action_id == 0) {
                exit("Это не ваш заказ!");
            }
        } else {
            $order_resolt = mysqli_fetch_assoc($order_query)[$table];
            return $order_resolt;
        }

    }
    order_information("", 1);
    $orderer_nik = order_information("nik", 0);
    $responsible_id = order_information("responsible_id", 0);
    $order_name = order_information("order_name", 0);
    function order_type()
    {
        global $action_id;
        $type_arr = array("order_check", "order_ask", "order_finish", "order_return", "payment_ask", "payment_check", "payment_agree", "payment_disagree");
        return $type_arr[$action_id];
    }
    function responsible_convert()
    {
        global $bd_connect, $responsible_id;
        $user_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = $responsible_id";
        $user_query = mysqli_query($bd_connect, $user_sql);
        return mysqli_fetch_assoc($user_query)['nik'];
    }
    function bell_number()
    {
        global $bd_connect, $orderer_nik, $my_nik, $responsible_id;
        //resolt_nik
        $nik_resolt = null;
        if ($orderer_nik != $my_nik) {
            $nik_resolt = $orderer_nik;
        } else {
            $nik_resolt = responsible_convert();
        }

        $old_bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = '$nik_resolt'";
        $old_bell_query = mysqli_query($bd_connect, $old_bell_sql);
        $old_bell_resolt = mysqli_fetch_assoc($old_bell_query)['bell'];

        $old_bell = intval($old_bell_resolt) + 1;
        $bell_sql = "UPDATE `user_notification` SET `bell` = $old_bell WHERE `nik` = '$nik_resolt'";
        mysqli_query($bd_connect, $bell_sql);
    }
    $notification_type = order_type();
    $nik_resolt = responsible_convert();
    $notification_sql = null;
    //time
    $notification_time = date('H:i');

    $notification_value = $order_id;
    if ($orderer_nik != $my_nik) {
        $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, '$order_name', '$order_id', '', '$orderer_nik', '$nik_resolt', '$notification_time', '$resolt_date', 0, '$notification_type')";
    } else {
        $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, '$order_name', '$order_id', '', '$nik_resolt', '$orderer_nik', '$notification_time', '$resolt_date', 0, '$notification_type')";
    }

    function order_pause($index)
    {
        global $bd_connect, $order_id, $notification_sql, $my_nik;
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            bell_number();
            //time_stop
            $time_sql = null;
            if ($index == 0) {
                $time_sql = "UPDATE `orders` SET `time` = 3 WHERE `id` = $order_id AND `nik` != '$my_nik'";
            } else if ($index == 4) {
                $time_sql = "UPDATE `orders` SET `time` = 2 WHERE `id` = $order_id AND `nik` != '$my_nik'";
            }
            $time_query = mysqli_query($bd_connect, $time_sql);
            if ($time_query) {
                //time code
            }
        }
    }
    if ($action_id == 0) {
        order_pause(0);
    } elseif ($action_id == 4) {
        $money_sum = intval($_POST["money_sum"]);
        function response_bd($table)
        {
            global $bd_connect, $order_id, $my_nik;
            $response_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = $order_id AND `nik` = '$my_nik'";
            $response_query = mysqli_query($bd_connect, $response_sql);
            return mysqli_fetch_assoc($response_query)[$table];
        }
        $limit_price = intval(response_bd('price'));
        if ($money_sum >= $limit_price + 1) {
            echo "limit";
        } else {
            $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, '$order_name', '$order_id', '', '$orderer_nik', '$nik_resolt', '$notification_time', '$resolt_date', $money_sum, '$notification_type')";
            order_pause(4);
        }
    } elseif ($action_id == 3) {
        $time_sql = "UPDATE `orders` SET `time` = 1 WHERE `id` = $order_id AND `nik` = '$my_nik'";
        mysqli_query($bd_connect, $time_sql);
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 6) {
        function last_amount()
        {
            global $bd_connect, $order_id;
            $amount_sql = "SELECT `payment_sum` FROM `notifications` WHERE `order_information` = '$order_id' AND `type` = 'payment_check' ORDER BY `id` DESC LIMIT 1";
            $amount_query = mysqli_query($bd_connect, $amount_sql);
            return mysqli_fetch_assoc($amount_query)['payment_sum'];
        }
        $money_sum = intval(last_amount());
        $time_sql = "UPDATE `orders` SET `time` = 1 WHERE `id` = $order_id AND `nik` != '$my_nik'";
        $time_query = mysqli_query($bd_connect, $time_sql);
        if ($time_query) {
            //change_sum
            function old_order_amount()
            {
                global $bd_connect, $order_id, $my_nik;
                $order_sql = "SELECT `price` FROM `orders_responses` WHERE `order_id` = $order_id AND `nik` = '$my_nik'";
                $order_query = mysqli_query($bd_connect, $order_sql);
                return mysqli_fetch_assoc($order_query)['price'];
            }
            $limit_price = intval(old_order_amount());
            $final_sum = $limit_price - $money_sum;
            $update_response_sql = "UPDATE `orders_responses` SET `price` = $final_sum WHERE `order_id` = $order_id AND `nik` = '$my_nik'";
            mysqli_query($bd_connect, $update_response_sql);
        }
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 5) {
        $money_sum = intval($_POST["money_sum"]);
        $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, '$order_name', '$order_id', '', '$nik_resolt', '$orderer_nik', '$notification_time', '$resolt_date', $money_sum, '$notification_type')";
        $time_sql = "UPDATE `orders` SET `time` = 4 WHERE `id` = $order_id";
        mysqli_query($bd_connect, $time_sql);
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 1) {
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 7) {
        $time_sql = "UPDATE `orders` SET `time` = 5 WHERE `id` = $order_id";
        mysqli_query($bd_connect, $time_sql);
        $notification_query = mysqli_query($bd_connect, $notification_sql);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 2) {
        $message_value = $_POST["message_value"];
        function chat_send($value)
        {
            global $bd_connect, $nik_resolt, $orderer_nik, $order_id;
            //date
            setlocale(LC_TIME, 'ru_RU.utf8');
            $date = time();
            $dateTime = new DateTime();
            $dateTime->setTimestamp($date);
            $formattedDate = date('d.m.Y');

            //time
            $message_time = date('Y-m-d H:i');

            //chat_id
            function chat_id()
            {
                global $bd_connect, $nik_resolt, $orderer_nik;
                $id_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = '$nik_resolt' AND `nik_two` = '$orderer_nik') OR (`nik_one` = '$orderer_nik' AND `nik_two` = '$nik_resolt')";
                $id_query = mysqli_query($bd_connect, $id_sql);
                return mysqli_fetch_assoc($id_query)['chat_id'];
            }
            $chat_id = chat_id();

            $message_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `task`, `file`, `nik`, `message_nik`) VALUES (NULL, $chat_id, '$formattedDate', '$value', '', '$message_time', 0, 0, 0, 0, 2, 0, '$orderer_nik', '$nik_resolt')";
            $message_query = mysqli_query($bd_connect, $message_sql);
            function chat_notification()
            {
                global $bd_connect, $nik_resolt, $orderer_nik;
                function old_message_length()
                {
                    global $bd_connect, $nik_resolt, $orderer_nik;
                    $responsable_nik = responsible_convert();
                    $length_sql = "SELECT `messages` FROM `user_notification` WHERE `nik` = '$responsable_nik'";
                    $length_query = mysqli_query($bd_connect, $length_sql);
                    $resolt = intval(mysqli_fetch_assoc($length_query)['messages']);
                    return $resolt + 1;
                }
                $new_length = old_message_length();
                $notification_sql = "UPDATE `user_notification` SET `messages` = $new_length WHERE `nik` = '$nik_resolt'";
                mysqli_query($bd_connect, $notification_sql);
            }
            if ($message_query) {
                echo "done";
                chat_notification();
            } else {
                echo "warning";
            }
        }

        if (!empty($message_value)) {
            chat_send($message_value);
        } else {
            chat_send("Заказ завершён.");
        }

        //end_order
        function end_order()
        {
            global $bd_connect, $orderer_nik, $nik_resolt, $order_id, $notification_sql;
            $order_sql = "UPDATE `orders` SET `progress` = 3, `time` = 4 WHERE `id` = $order_id";
            $order_query = mysqli_query($bd_connect, $order_sql);
            if ($order_query) {
                //notification_send
                $notification_query = mysqli_query($bd_connect, $notification_sql);
                if ($notification_query) {
                    bell_number();
                }
                //level_update
                function level_update()
                {
                    global $bd_connect, $nik_resolt;
                    function old_order_length()
                    {
                        global $bd_connect, $nik_resolt;
                        $order_length_sql = "SELECT `orders` FROM `user_registoring` WHERE `nik` = '$nik_resolt'";
                        $order_length_query = mysqli_query($bd_connect, $order_length_sql);
                        return intval(mysqli_fetch_assoc($order_length_query)['orders']);
                    }
                    $order_length_resolt = old_order_length() + 1;
                    $level_sql = "UPDATE `user_registoring` SET `orders` = $order_length_resolt WHERE `nik` = '$nik_resolt'";
                    mysqli_query($bd_connect, $level_sql);
                }
                level_update();

                //payment_transfer
            }
        }
        end_order();
    }
} elseif (isset($_GET["review_order_id"]) && is_numeric($_GET["review_order_id"])) {
    $order_id = $_GET["review_order_id"];
    $smile_index = $_POST["smile_index"];
    $review = $_POST["review"];
    //worker_email
    $user_id = null;
    function reviewers_email()
    {
        global $bd_connect, $order_id, $user_id;
        $my_id = $_SESSION["id"];
        function users_order($table)
        {
            global $bd_connect, $order_id, $user_id;
            $order_sql = "SELECT * FROM `orders` WHERE `responsible_id` = $order_id";
            $order_query = mysqli_query($bd_connect, $order_sql);
            return mysqli_fetch_assoc($order_query)[$table];
        }
        $user_id = users_order('responsible_id');
        $email_sql = "SELECT `email` FROM `user_registoring` WHERE `id` = $user_id";
        $email_query = mysqli_query($bd_connect, $email_sql);
        if ($user_id == $my_id) {
            return users_order('order_email');
        } else {
            return mysqli_fetch_assoc($email_query)['email'];
        }

    }
    $email_resolt = reviewers_email();
    if (strlen($review) >= 50) {
        //date
        $date = date("Y-m-d");
        $date_resolt = null;
        list($year, $month, $day) = explode("-", $date);
        $date_array = array($year, $month, $day);
        for ($i = 0; $i < count($date_array); $i++) {
            if ($i >= 1) {
                $date_resolt .= ".";
            }
            $date_resolt .= $date_array[$i];
        }
        //role
        $role = $_SESSION["role"];
        $review_sql = "INSERT INTO `reviews` (`id`, `nik`, `email`, `review`, `role`, `star`, `type`, `date`) VALUES (NULL, '$my_nik', '$email_resolt', '$review', '$role', $smile_index, 'user', '$date_resolt')";
        $review_query = mysqli_query($bd_connect, $review_sql);
        if ($review_query) {
            //time
            $notification_time = date('H:i');
            function sending_nik()
            {
                global $bd_connect, $user_id;
                $nik_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = $user_id";
                $nik_query = mysqli_query($bd_connect, $nik_sql);
                return mysqli_fetch_assoc($nik_query)['nik'];
            }
            $sending_nik = sending_nik();
            //notification_send
            $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, 'Поступил отзыв', 'Пользователь написал отзыв о сотрудничестве', '', '$sending_nik', '$my_nik', '$notification_time', '$resolt_date', 0, 'review')";
            $notification_query = mysqli_query($bd_connect, $notification_sql);
            if ($notification_query) {
                function old_bell_number()
                {
                    global $bd_connect, $sending_nik;
                    $old_bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = '$sending_nik'";
                    $old_bell_query = mysqli_query($bd_connect, $old_bell_sql);
                    return intval(mysqli_fetch_assoc($old_bell_query));
                }
                $bell_resolt = old_bell_number();
                $add_bell_sql = "UPDATE `user_notification` SET `bell` = $bell_resolt WHERE `nik` = '$sending_nik'";
                mysqli_query($bd_connect, $add_bell_sql);
            }
        }
    }
}
?>