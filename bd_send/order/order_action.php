<?php
session_start();
include "../database_connect.php";

if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
$my_nik = $_SESSION["nik"];
$my_id = $_SESSION["id"];

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
    $order_id = intval($_GET["order_id"]);
    $stmt = mysqli_prepare($bd_connect, "SELECT * FROM orders WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $application = mysqli_fetch_assoc($result);

    if ($application) {
        $order_application_name = $application['order_name'];
        $responsible_id = $application['responsible_id'];
    } else {
        header("Location: ../warnings/application_not_found.php");
        exit();
    }

    $check_sql = "SELECT * FROM notifications WHERE order_information = ? AND order_nik = ?";
    $stmt = mysqli_prepare($bd_connect, $check_sql);
    mysqli_stmt_bind_param($stmt, "is", $order_id, $my_nik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $check_resolt = false;
    while (mysqli_fetch_assoc($result)) {
        $check_resolt = true;
    }

    if ($check_resolt == true) {
        $active_progress = 2;
        $order_sql = "UPDATE orders SET responsible_id = ?, progress = ? WHERE id = ?";
        $stmt = mysqli_prepare($bd_connect, $order_sql);
        mysqli_stmt_bind_param($stmt, "iii", $my_id, $active_progress, $order_id);
        $order_query = mysqli_stmt_execute($stmt);

        if ($order_query) {
            $order_name = $application['order_name'];
            $customers_nik = $application['nik'];

            //offer_notification_remove
            function offer_notification_remove()
            {
                global $bd_connect;
                $order_info = "1";
                $notification_type = "application";
                $delete_sql = "DELETE FROM `notifications` WHERE `order_information` = ? AND `type` = ?";
                $stmt = mysqli_prepare($bd_connect, $delete_sql);
                mysqli_stmt_bind_param($stmt, "ss", $order_info, $notification_type);
                mysqli_stmt_execute($stmt);
            }
            offer_notification_remove();

            $notification_time = date('H:i');

            $notification_sql = "INSERT INTO notifications (id, order_name, order_information, order_file, order_nik, nik, time, date, payment_sum, type) VALUES (NULL, ?, ?, '', ?, ?, ?, ?, 0, 'order_start')";
            $stmt = mysqli_prepare($bd_connect, $notification_sql);
            mysqli_stmt_bind_param($stmt, "sississ", $order_name, $order_id, $customers_nik, $my_nik, $notification_time, $resolt_date);
            $notification_query = mysqli_stmt_execute($stmt);

            if ($notification_query) {
                $old_bell_sql = "SELECT bell FROM user_notification WHERE nik = ?";
                $stmt = mysqli_prepare($bd_connect, $old_bell_sql);
                mysqli_stmt_bind_param($stmt, "s", $customers_nik);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $old_bell_resolt = intval(mysqli_fetch_assoc($result)['bell']);

                $final_bell = $old_bell_resolt;
                $bell_sql = "UPDATE user_notification SET bell = ? WHERE nik = ?";
                $stmt = mysqli_prepare($bd_connect, $bell_sql);
                mysqli_stmt_bind_param($stmt, "is", $final_bell, $customers_nik);
                mysqli_stmt_execute($stmt);

                $notification_sql = "DELETE FROM notifications WHERE order_information = ? AND order_nik = ?";
                $stmt = mysqli_prepare($bd_connect, $notification_sql);
                mysqli_stmt_bind_param($stmt, "is", $order_id, $my_nik);
                mysqli_stmt_execute($stmt);
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
        // order_check
        $order_sql = "SELECT * FROM `orders` WHERE `id` = ?";
        $stmt = mysqli_prepare($bd_connect, $order_sql);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $order_query = mysqli_stmt_get_result($stmt);

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
        $user_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = ?";
        $stmt = mysqli_prepare($bd_connect, $user_sql);
        mysqli_stmt_bind_param($stmt, "i", $responsible_id);
        mysqli_stmt_execute($stmt);
        $user_query = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($user_query);
        return $result['nik'];
    }

    function bell_number()
    {
        global $bd_connect, $orderer_nik, $my_nik, $responsible_id;

        $nik_resolt = null;
        if ($orderer_nik != $my_nik) {
            $nik_resolt = $orderer_nik;
        } else {
            $nik_resolt = responsible_convert();
        }

        $old_bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $old_bell_sql);
        mysqli_stmt_bind_param($stmt, "s", $nik_resolt);
        mysqli_stmt_execute($stmt);
        $old_bell_query = mysqli_stmt_get_result($stmt);
        $old_bell_resolt = mysqli_fetch_assoc($old_bell_query)['bell'];

        $old_bell = intval($old_bell_resolt) + 1;
        $bell_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $bell_sql);
        mysqli_stmt_bind_param($stmt, "is", $old_bell, $nik_resolt);
        mysqli_stmt_execute($stmt);
    }
    $notification_type = order_type();
    $nik_resolt = responsible_convert();
    //time
    $notification_time = date('H:i');

    $notification_value = $order_id;
    $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, '', ?, ?, ?, ?, 0, ?)";
    $notification_stmt = mysqli_prepare($bd_connect, $notification_sql);
    if ($orderer_nik != $my_nik) {
        mysqli_stmt_bind_param($notification_stmt, "sssssss", $order_name, $order_id, $orderer_nik, $nik_resolt, $notification_time, $resolt_date, $notification_type);
    } else {
        mysqli_stmt_bind_param($notification_stmt, "sssssss", $order_name, $order_id, $nik_resolt, $orderer_nik, $notification_time, $resolt_date, $notification_type);
    }

    function order_pause($index)
    {
        global $bd_connect, $order_id, $notification_sql, $my_nik, $notification_stmt, $order_name, $notification_time, $resolt_date, $notification_type, $orderer_nik;

        if ($notification_type == "payment_ask") {
            $notification_query = true;
        } else {
            $notification_query = mysqli_stmt_execute($notification_stmt);
        }
        if ($notification_query) {
            bell_number();
            //time_stop
            $time_sql = null;
            if ($index == 0) {
                $time_sql = "UPDATE `orders` SET `time` = 3 WHERE `id` = ? AND `nik` != ?";
            } else if ($index == 4) {
                $time_sql = "UPDATE `orders` SET `time` = 2 WHERE `id` = ? AND `nik` != ?";
            }
            $stmt = mysqli_prepare($bd_connect, $time_sql);
            mysqli_stmt_bind_param($stmt, "is", $order_id, $my_nik);
            $time_query = mysqli_stmt_execute($stmt);

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

            $response_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ? AND `nik` = ?";
            $stmt = mysqli_prepare($bd_connect, $response_sql);
            mysqli_stmt_bind_param($stmt, "is", $order_id, $my_nik);
            mysqli_stmt_execute($stmt);
            $response_query = mysqli_stmt_get_result($stmt);
            $result = mysqli_fetch_assoc($response_query);

            return $result[$table];
        }
        $limit_price = intval(response_bd('price'));
        if ($money_sum >= $limit_price + 1) {
            echo "limit";
        } else {
            $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, '', ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($bd_connect, $notification_sql);
            mysqli_stmt_bind_param($stmt, "ssssssds", $order_name, $order_id, $orderer_nik, $nik_resolt, $notification_time, $resolt_date, $money_sum, $notification_type);
            mysqli_stmt_execute($stmt);
            order_pause(4);
        }
    } elseif ($action_id == 3) {
        $time_sql = "UPDATE `orders` SET `time` = 1 WHERE `id` = ? AND `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $time_sql);
        mysqli_stmt_bind_param($stmt, "is", $order_id, $my_nik);
        mysqli_stmt_execute($stmt);
        $notification_query = mysqli_stmt_execute($notification_stmt);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 6) {
        function last_amount()
        {
            global $bd_connect, $order_id;

            $amount_sql = "SELECT `payment_sum` FROM `notifications` WHERE `order_information` = ? AND `type` = 'payment_check' ORDER BY `id` DESC LIMIT 1";
            $stmt = mysqli_prepare($bd_connect, $amount_sql);
            mysqli_stmt_bind_param($stmt, "s", $order_id);
            mysqli_stmt_execute($stmt);
            $amount_query = mysqli_stmt_get_result($stmt);
            $result = mysqli_fetch_assoc($amount_query);

            return $result['payment_sum'];
        }
        $money_sum = last_amount();
        $time_sql = "UPDATE `orders` SET `time` = 1 WHERE `id` = ? AND `nik` != ?";
        $time_stmt = mysqli_prepare($bd_connect, $time_sql);
        mysqli_stmt_bind_param($time_stmt, "is", $order_id, $my_nik);
        mysqli_stmt_execute($time_stmt);
        if ($time_stmt) {
            //change_sum
            function old_order_amount()
            {
                global $bd_connect, $order_id, $my_nik;

                $order_sql = "SELECT `price` FROM `orders_responses` WHERE `order_id` = ? AND `nik` = ?";
                $stmt = mysqli_prepare($bd_connect, $order_sql);
                mysqli_stmt_bind_param($stmt, "is", $order_id, $my_nik);
                mysqli_stmt_execute($stmt);
                $order_query = mysqli_stmt_get_result($stmt);
                $result = mysqli_fetch_assoc($order_query);

                return $result['price'];
            }
            $limit_price = intval(old_order_amount());
            $final_sum = $limit_price - $money_sum;
            $update_response_sql = "UPDATE `orders_responses` SET `price` = ? WHERE `order_id` = ? AND `nik` = ?";
            $stmt = mysqli_prepare($bd_connect, $update_response_sql);
            mysqli_stmt_bind_param($stmt, "iis", $final_sum, $order_id, $my_nik);
            mysqli_stmt_execute($stmt);
        }
        $notification_query = mysqli_stmt_execute($notification_stmt);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 5) {
        $money_sum = intval($_POST["money_sum"]);
        $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, ?, ?, '', ?, ?, ?, ?, ?, ?)";
        $stmt_notification = mysqli_prepare($bd_connect, $notification_sql);
        mysqli_stmt_bind_param($stmt_notification, "ssssssis", $order_name, $order_id, $nik_resolt, $orderer_nik, $notification_time, $resolt_date, $money_sum, $notification_type);
        mysqli_stmt_execute($stmt_notification);

        $time_sql = "UPDATE `orders` SET `time` = 4 WHERE `id` = ?";
        $stmt_time = mysqli_prepare($bd_connect, $time_sql);
        mysqli_stmt_bind_param($stmt_time, "i", $order_id);
        mysqli_stmt_execute($stmt_time);

        if ($stmt_notification) {
            bell_number();
        }
    } elseif ($action_id == 1) {
        $notification_query = mysqli_stmt_execute($notification_stmt);
        if ($notification_query) {
            bell_number();
        }
    } elseif ($action_id == 7) {
        $time_sql = "UPDATE `orders` SET `time` = 5 WHERE `id` = ?";
        $stmt = mysqli_prepare($bd_connect, $time_sql);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $notification_query = mysqli_stmt_execute($notification_stmt);
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

                $id_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)";
                $stmt = mysqli_prepare($bd_connect, $id_sql);
                mysqli_stmt_bind_param($stmt, "ssss", $nik_resolt, $orderer_nik, $orderer_nik, $nik_resolt);
                mysqli_stmt_execute($stmt);
                $id_query = mysqli_stmt_get_result($stmt);
                $result = mysqli_fetch_assoc($id_query);

                return $result['chat_id'];
            }

            $chat_id = chat_id();

            $message_sql = "INSERT INTO `messages` (`id`, `chat_id`, `date`, `message_value`, `file_path`, `time`, `eye`, `changeable`, `deleted`, `answer`, `task`, `file`, `nik`, `message_nik`) VALUES (NULL, ?, ?, ?, '', ?, 0, 0, 0, 0, 2, 0, ?, ?)";
            $stmt = mysqli_prepare($bd_connect, $message_sql);
            mysqli_stmt_bind_param($stmt, "ississ", $chat_id, $formattedDate, $value, $message_time, $orderer_nik, $nik_resolt);
            $message_query = mysqli_stmt_execute($stmt);
            function chat_notification()
            {
                global $bd_connect, $nik_resolt, $orderer_nik;

                function old_message_length()
                {
                    global $bd_connect, $nik_resolt, $orderer_nik;
                    $responsable_nik = responsible_convert();
                    $length_sql = "SELECT `messages` FROM `user_notification` WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $length_sql);
                    mysqli_stmt_bind_param($stmt, "s", $responsable_nik);
                    mysqli_stmt_execute($stmt);
                    $length_query = mysqli_stmt_get_result($stmt);
                    $resolt = intval(mysqli_fetch_assoc($length_query)['messages']);
                    return $resolt + 1;
                }

                $new_length = old_message_length();
                $notification_sql = "UPDATE `user_notification` SET `messages` = ? WHERE `nik` = ?";
                $stmt = mysqli_prepare($bd_connect, $notification_sql);
                mysqli_stmt_bind_param($stmt, "is", $new_length, $nik_resolt);
                mysqli_stmt_execute($stmt);
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
            global $bd_connect, $orderer_nik, $nik_resolt, $order_id, $notification_sql, $notification_stmt;

            $order_sql = "UPDATE `orders` SET `progress` = 3, `time` = 6 WHERE `id` = ?";
            $stmt_order = mysqli_prepare($bd_connect, $order_sql);
            mysqli_stmt_bind_param($stmt_order, "i", $order_id);
            $order_query = mysqli_stmt_execute($stmt_order);

            if ($order_query) {
                //notification_send
                $notification_query = mysqli_stmt_execute($notification_stmt);
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
                        $order_length_sql = "SELECT `orders` FROM `user_registoring` WHERE `nik` = ?";
                        $stmt_length = mysqli_prepare($bd_connect, $order_length_sql);
                        mysqli_stmt_bind_param($stmt_length, "s", $nik_resolt);
                        mysqli_stmt_execute($stmt_length);
                        $order_length_query = mysqli_stmt_get_result($stmt_length);
                        return intval(mysqli_fetch_assoc($order_length_query)['orders']);
                    }
                    $order_length_resolt = old_order_length() + 1;
                    $level_sql = "UPDATE `user_registoring` SET `orders` = ? WHERE `nik` = ?";
                    $stmt_level = mysqli_prepare($bd_connect, $level_sql);
                    mysqli_stmt_bind_param($stmt_level, "is", $order_length_resolt, $nik_resolt);
                    mysqli_stmt_execute($stmt_level);
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
            $order_sql = "SELECT * FROM `orders` WHERE `id` = ?";
            $stmt_order = mysqli_prepare($bd_connect, $order_sql);
            mysqli_stmt_bind_param($stmt_order, "i", $order_id);
            mysqli_stmt_execute($stmt_order);
            $order_query = mysqli_stmt_get_result($stmt_order);
            return mysqli_fetch_assoc($order_query)[$table];
        }
        function orderer_id()
        {
            global $bd_connect, $order_id;
            $orderers_nik = users_order('nik');
            $id_sql = "SELECT `id` FROM `user_registoring` WHERE `nik` = ?";
            $stmt_id = mysqli_prepare($bd_connect, $id_sql);
            mysqli_stmt_bind_param($stmt_id, "s", $orderers_nik);
            mysqli_stmt_execute($stmt_id);
            $id_query = mysqli_stmt_get_result($stmt_id);
            return mysqli_fetch_assoc($id_query)['id'];
        }
        function id_filter()
        {
            global $bd_connect, $user_id, $my_id;
            if (users_order('responsible_id') == $my_id) {
                $user_id = orderer_id();
                return true;
            } else {
                $user_id = users_order('responsible_id');
            }
        }
        if (id_filter()) {
            return users_order('order_email');
        }

        $email_sql = "SELECT `email` FROM `user_registoring` WHERE `id` = ?";
        $stmt_email = mysqli_prepare($bd_connect, $email_sql);
        mysqli_stmt_bind_param($stmt_email, "i", $user_id);
        mysqli_stmt_execute($stmt_email);
        $email_query = mysqli_stmt_get_result($stmt_email);
        if ($user_id == $my_id) {
            return users_order('order_email');
        } else {
            return mysqli_fetch_assoc($email_query)['email'];
        }
    }
    $email_resolt = reviewers_email();
    if (strlen($review) >= 50) {
        //date
        $date_resolt = date("Y.m.d");
        //role
        $role = $_SESSION["role"];
        $review_type = "user";
        $review_sql = "INSERT INTO `reviews` (`id`, `nik`, `email`, `review`, `role`, `star`, `type`, `date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_review = mysqli_prepare($bd_connect, $review_sql);
        mysqli_stmt_bind_param($stmt_review, "sssissi", $my_nik, $email_resolt, $review, $role, $smile_index, $review_type, $date_resolt);
        $review_query = mysqli_stmt_execute($stmt_review);
        if ($review_query) {
            //time
            $notification_time = date('H:i');
            function sending_nik()
            {
                global $bd_connect, $user_id;
                $nik_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = ?";
                $stmt_nik = mysqli_prepare($bd_connect, $nik_sql);
                mysqli_stmt_bind_param($stmt_nik, "i", $user_id);
                mysqli_stmt_execute($stmt_nik);
                $nik_query = mysqli_stmt_get_result($stmt_nik);
                return mysqli_fetch_assoc($nik_query)['nik'];
            }
            $sending_nik = sending_nik();
            //notification_send
            $notification_sql = "INSERT INTO `notifications` (`id`, `order_name`, `order_information`, `order_file`, `order_nik`, `nik`, `time`, `date`, `payment_sum`, `type`) VALUES (NULL, 'Поступил отзыв', 'Пользователь написал отзыв о сотрудничестве', '', ?, ?, ?, ?, 0, 'review')";
            $stmt_notification = mysqli_prepare($bd_connect, $notification_sql);
            if ($user_id == $my_id) {
                mysqli_stmt_bind_param($stmt_notification, "ssss", $my_nik, $sending_nik, $notification_time, $resolt_date);
            } else {
                mysqli_stmt_bind_param($stmt_notification, "ssss", $sending_nik, $my_nik, $notification_time, $resolt_date);
            }
            $notification_query = mysqli_stmt_execute($stmt_notification);
            if ($notification_query) {
                function old_bell_number()
                {
                    global $bd_connect, $sending_nik;
                    $old_bell_sql = "SELECT `bell` FROM `user_notification` WHERE `nik` = ?";
                    $stmt_bell = mysqli_prepare($bd_connect, $old_bell_sql);
                    mysqli_stmt_bind_param($stmt_bell, "s", $sending_nik);
                    mysqli_stmt_execute($stmt_bell);
                    $old_bell_query = mysqli_stmt_get_result($stmt_bell);
                    return intval(mysqli_fetch_assoc($old_bell_query)['bell']);
                }
                $bell_resolt = old_bell_number() + 1;
                $add_bell_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
                $stmt_add_bell = mysqli_prepare($bd_connect, $add_bell_sql);
                mysqli_stmt_bind_param($stmt_add_bell, "is", $bell_resolt, $sending_nik);
                mysqli_stmt_execute($stmt_add_bell);
            }
        }
    }
}
?>