<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
    exit;
}
$my_nik = $_SESSION["nik"];
include "../layouts/header.php";
include "../bd_send/database_connect.php";
echo "<link rel='stylesheet' href='../page_css/modal_css/order_done.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/payment_ask.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/pay.css'>";
echo "<link rel='stylesheet' href='../page_css/order_progress.css'>";
echo "<link rel='stylesheet' href='../page_css/media/order_progress_media.css'>";
//order_check
$order_id = null;
if (isset($_GET["order_id"]) && is_numeric($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    function order_check()
    {
        global $bd_connect, $order_id, $my_nik;
        $order_sql = "SELECT * FROM `orders` WHERE `id` = ?";
        $stmt_order = mysqli_prepare($bd_connect, $order_sql);
        mysqli_stmt_bind_param($stmt_order, "i", $order_id);
        mysqli_stmt_execute($stmt_order);
        $order_query = mysqli_stmt_get_result($stmt_order);
        $order_resolt = mysqli_fetch_assoc($order_query);
        if ($order_resolt == null) {
            header("Location: home.php");
        } else {
            if ($order_resolt["nik"] == $my_nik || $order_resolt["responsible_id"] == $_SESSION["id"]) {
                echo "<title>Выполнение заказа: " . $order_resolt["order_name"] . "</title>";
            } else {
                header("Location: home.php");
                exit;
            }
        }
    }
    order_check();
} else {
    header("Location: home.php");
    exit;
}
function order_bd($table)
{
    global $bd_connect, $order_id;
    $order_sql = "SELECT `$table` FROM `orders` WHERE `id` = ?";
    $stmt_order = mysqli_prepare($bd_connect, $order_sql);
    mysqli_stmt_bind_param($stmt_order, "i", $order_id);
    mysqli_stmt_execute($stmt_order);
    $order_query = mysqli_stmt_get_result($stmt_order);
    $order_resolt = mysqli_fetch_assoc($order_query)[$table];
    return $order_resolt;
}
if (order_bd('progress') <= 1) {
    header("Location: home.php");
}
if (order_bd('time') == 0) {
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
    $date_sql = "UPDATE `orders` SET `date` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $date_sql);
    mysqli_stmt_bind_param($stmt, "si", $date_resolt, $order_id);
    mysqli_stmt_execute($stmt);
}

$responsible_id = order_bd('responsible_id');

function responsible_nik()
{
    global $bd_connect, $responsible_id;
    $nik_sql = "SELECT `nik` FROM `user_registoring` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $nik_sql);
    mysqli_stmt_bind_param($stmt, "i", $responsible_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result)['nik'];
}

$responsible_nik = responsible_nik();

$responsible_sql = "SELECT * FROM `user_registoring` WHERE `id` = ?";
$stmt = mysqli_prepare($bd_connect, $responsible_sql);
mysqli_stmt_bind_param($stmt, "i", $responsible_id);
mysqli_stmt_execute($stmt);
$responsible_query = mysqli_stmt_get_result($stmt);
$responsible_resolt = mysqli_fetch_assoc($responsible_query);
$responsible_nik = $responsible_resolt["nik"];

$orderer_nik = order_bd('nik');
$orderer_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
$stmt = mysqli_prepare($bd_connect, $orderer_sql);
mysqli_stmt_bind_param($stmt, "s", $orderer_nik);
mysqli_stmt_execute($stmt);
$orderer_query = mysqli_stmt_get_result($stmt);
$orderer_resolt = mysqli_fetch_assoc($orderer_query);

function response_bd($table)
{
    global $bd_connect, $order_id, $orderer_nik;

    $order_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ? AND `orderer_nik` = ? ORDER BY `id` DESC LIMIT 1";
    $stmt = mysqli_prepare($bd_connect, $order_sql);
    mysqli_stmt_bind_param($stmt, "is", $order_id, $orderer_nik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $order_resolt = $row[$table];

    return $order_resolt;
}

if ($my_nik == $orderer_nik) {
    //modal_connect
    include "../layouts/modal/order/order_done.php";
    include "../layouts/modal/order/pay.php";
} else {
    include "../layouts/modal/order/payment_ask.php";
}
include "../layouts/header_line.php";
?>
<div class="order_progress container">
    <?php
    ?>
    <noscript class="order_id">
        <?= order_bd('id') ?>
    </noscript>
    <div class="header">
        <div class="overlay">
            <div class="loader"></div>
        </div>
        <div class="header_title">
            <h2>Заказ №
                <?= order_bd('id') ?>
            </h2>
        </div>
        <div class="order_users">
            <div>
                <b>Заказчик:</b>
                <div class="user_row">
                    <div class="user_icon">
                        <img src="../bd_send/user/user_icons/<?= $orderer_resolt['icon_path'] ?>" alt=""
                            draggable="false">
                    </div>
                    <div>
                        <a href="user_page.php?user_id=<?= $orderer_resolt['id'] ?>" target="_blank">
                            <?= $orderer_resolt['name'] ?>
                            <?= $orderer_resolt['family'] ?>
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <b>Исполнитель:</b>
                <div class="user_row">
                    <div class="user_icon">
                        <img src="../bd_send/user/user_icons/<?= $responsible_resolt['icon_path'] ?>" alt=""
                            draggable="false">
                    </div>
                    <div>
                        <a href="user_page.php?user_id=<?= $responsible_resolt['id'] ?>" target="_blank">
                            <?= $responsible_resolt['name'] ?>
                            <?= $responsible_resolt['family'] ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="order_line">
            <div class="link_line">
                <div>
                    <?php
                    if ($orderer_resolt['nik'] == $my_nik) {
                        echo '<a href="my_orders.php" target="_blank">Мои заказы</a>';
                    } else {
                        echo '<a href="my_responses.php" target="_blank">Мои отклики</a>';
                    }
                    ?>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                    </svg>
                </div>
                <div>
                    <a href="order_page.php?order_id=<?= order_bd('id') ?>" target="_blank" class="order_link">
                        <p>Заказ №
                            <?= order_bd('id') ?>
                        </p>
                    </a>
                </div>
            </div>
            <div class="date">
                <p>
                    <?= order_bd('date') ?>
                </p>
            </div>
        </div>
        <div class="information_wrapper">
            <?php
            //application_information
            $application_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ? AND `nik` = ?";
            $stmt_application = mysqli_prepare($bd_connect, $application_sql);
            mysqli_stmt_bind_param($stmt_application, "ss", $order_id, $responsible_nik);
            mysqli_stmt_execute($stmt_application);
            $application_query = mysqli_stmt_get_result($stmt_application);
            $application_resolt = mysqli_fetch_assoc($application_query);
            $category_arr = array("Без категорий", "Дизайн", "Разработка и IT", "Тексты и переводы", "SEO и трафик", "Соцсети и реклама", "Аудио, видео, съемка", "Бизнес и жизнь", "Учеба и репетиторство");
            ?>
            <div class="information_part part_one">
                <div>
                    <p>Сфера</p>
                </div>
                <div>
                    <p>Срок</p>
                </div>
                <div>
                    <p>Остаток цены</p>
                </div>
            </div>
            <div class="information_part">
                <div>
                    <p><a href="tasks.php?filter=<?= order_bd('main_category') ?>" target="_blank">
                            <?= $category_arr[order_bd('main_category')] ?>
                        </a></p>
                </div>
                <div>
                    <p>
                        <?= $application_resolt['time'] ?> д.
                    </p>
                </div>
                <div>
                    <p class="price">
                        <?= $application_resolt['price'] ?> ₽
                    </p>
                </div>
            </div>
        </div>
        <div class="time_progress">
            <div>
                <b>Прогресс срока</b>
            </div>
            <?php
            $order_date = order_bd('date');
            function days_since_order_date()
            {
                global $order_date;
                $start_date = DateTime::createFromFormat('Y.m.d', $order_date);
                $current_date = new DateTime();
                $interval = $current_date->diff($start_date);
                return $interval->days;
            }
            ?>
            <div class="time_information">
                <div>
                    <p>
                        <span>
                            <?= days_since_order_date() ?>
                        </span> д.
                    </p>
                </div>
                <div>
                    <p>
                        <span>
                            <?= $application_resolt['time'] ?>
                        </span> д.
                    </p>
                </div>
            </div>
            <div class="progress_bar">
                <div class="in_bar"></div>
            </div>
        </div>
        <div class="order_progress_container">
            <div>
                <b class="title">Прогресс заказа</b>
            </div>
            <div class="progress_wrapper">
                <?php
                function formatRussianDate($dateString)
                {
                    global $order_date;
                    $date = DateTime::createFromFormat('Y.m.d', $dateString);
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
                }
                $dateString = $order_date;
                ?>
                <div class="date_row">
                    <div class="date">
                        <p>
                            <?= formatRussianDate($dateString) ?>
                        </p>
                    </div>
                    <div class="date_line"></div>
                </div>
                <div class="progress_row">
                    <div>
                        <img src="../bd_send/user/user_icons/<?= $responsible_resolt['icon_path'] ?>" alt=""
                            draggable="false">
                    </div>
                    <div>
                        <div class="progress_information">
                            <div>
                                <b>Подтверждение заказа</b>
                            </div>
                            <div>
                                <?php
                                $first_time_sql = "SELECT `time` FROM `notifications` WHERE `order_information` = ?";
                                $stmt_first_time = mysqli_prepare($bd_connect, $first_time_sql);
                                mysqli_stmt_bind_param($stmt_first_time, "s", $order_id);
                                mysqli_stmt_execute($stmt_first_time);
                                $first_time_query = mysqli_stmt_get_result($stmt_first_time);
                                $first_time_resolt = substr(mysqli_fetch_assoc($first_time_query)['time'], 0, 5);
                                ?>
                                <p class="time">
                                    <?= $first_time_resolt ?>
                                </p>
                            </div>
                        </div>
                        <div>
                            <p class="main_information">Продавец получил увидомление о заказе, как только продавец
                                приступит к заказу, статус заказа смениться на рабочий.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $is_first_iteration = true;
            $previous_date = null;

            $notification_sql = "SELECT * FROM `notifications` WHERE (`order_nik` = ? OR `order_nik` = ?) AND (`nik` = ? OR `nik` = ?) AND `order_information` = ?";
            $stmt_notification = mysqli_prepare($bd_connect, $notification_sql);
            mysqli_stmt_bind_param($stmt_notification, "sssss", $orderer_nik, $responsible_nik, $orderer_nik, $responsible_nik, $order_id);
            mysqli_stmt_execute($stmt_notification);
            $notification_query = mysqli_stmt_get_result($stmt_notification);

            while ($notification_resolt = mysqli_fetch_assoc($notification_query)):
                $current_date = $notification_resolt["date"];

                $previous_date = $current_date;

                if (strpos($notification_resolt['type'], "order") !== false || strpos($notification_resolt['type'], "payment") !== false):
                    $notification_nik = $notification_resolt['nik'];
                    $user_information_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
                    $stmt_user_information = mysqli_prepare($bd_connect, $user_information_sql);
                    mysqli_stmt_bind_param($stmt_user_information, "s", $notification_nik);
                    mysqli_stmt_execute($stmt_user_information);
                    $user_information_query = mysqli_stmt_get_result($stmt_user_information);
                    $user_information_resolt = mysqli_fetch_assoc($user_information_query);
                    ?>
                    <div class="date_row">
                        <div class="date">
                            <p>
                                <?= $previous_date ?>
                            </p>
                        </div>
                        <div class="date_line"></div>
                    </div>
                    <div class="progress_row">
                        <div>
                            <img src="../bd_send/user/user_icons/<?= $user_information_resolt['icon_path'] ?>" alt=""
                                draggable="false">
                        </div>
                        <div>
                            <div class="progress_information">
                                <div>
                                    <?php
                                    if ($notification_resolt['type'] == "order_check") {
                                        echo "<b>Сдача работы</b>";
                                    } elseif ($notification_resolt['type'] == "order_return") {
                                        echo "<b>Возврат работы на доработку</b>";
                                    } elseif ($notification_resolt['type'] == "order_ask") {
                                        echo "<b>Запрос работы</b>";
                                    } elseif ($notification_resolt['type'] == "order_finish") {
                                        echo "<b>Завершение заказа</b>";
                                    } elseif ($notification_resolt['type'] == "order_start") {
                                        echo "<b>Приступление к заказу</b>";
                                    } elseif ($notification_resolt['type'] == "payment_ask") {
                                        echo "<b>Сдача на оплату</b>";
                                    } elseif ($notification_resolt['type'] == "payment_check") {
                                        echo "<b>Оплата за пройденный этап</b>";
                                    } elseif ($notification_resolt['type'] == "payment_agree") {
                                        echo "<b>Подтверждение оплаты за пройденный этап</b>";
                                    } elseif ($notification_resolt['type'] == "payment_disagree") {
                                        echo "<b>Ожидание оплаты</b>";
                                    }
                                    ?>
                                </div>
                                <div>
                                    <p class="time">
                                        <?php
                                        $time = $notification_resolt["time"];
                                        $time = substr($time, 0, 5);
                                        ?>
                                        <?= $time ?>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <?php
                                if ($notification_resolt['type'] == "order_check") {
                                    echo '<p class="main_information">Продавец сдал работу на проверку. Вскоре покупатель проверит работу и примит решение. Срок будет увеличен на время проверки работы.</p>';
                                    if ($orderer_resolt['nik'] != $my_nik) {
                                        echo '<p class="main_information under_information">Если ' . $orderer_resolt['name'], ' ', $orderer_resolt['family'] . ' не будет давать обратную связь в течении суток или больше, обратитесь в <a href="support_user.php">службу поддержки</a></p>';
                                    }
                                } elseif ($notification_resolt['type'] == "order_return") {
                                    echo '<p class="main_information">Покупатель вернул заказ на доработку.</p>';
                                } elseif ($notification_resolt['type'] == "order_ask") {
                                    echo '<p class="main_information">Покупатель запросил результат работы</p>';
                                } elseif ($notification_resolt['type'] == "order_finish") {
                                    echo '<p class="main_information">Покупатель завершил заказ</p>';
                                } elseif ($notification_resolt['type'] == "order_start") {
                                    echo '<p class="main_information">Продавец одобрил условия заказа и уже приступил к работе над заказом.</p>';
                                } elseif ($notification_resolt['type'] == "payment_ask") {
                                    echo '<p class="main_information">Продавец выполнил определённый этап работы, и создал запрос на сумму ' . $notification_resolt['payment_sum'] . '₽ от заказа.</p>';
                                } elseif ($notification_resolt['type'] == "payment_check") {
                                    echo '<p class="main_information">Покупатель адобрил этап работы, и оплатил часть суммы продавцу на кошелек.</p>';
                                } elseif ($notification_resolt['type'] == "payment_agree") {
                                    echo '<p class="main_information">Продавец подтвердил приход средств на кошелёк, и уже продолжает работу над заказом. Пришедшая сумма снялась состатка цены в заказе. Как только остаток дойдёт до нуля, можно будет падать заявление покупателю на завершение заказа.</p>';
                                } elseif ($notification_resolt['type'] == "payment_disagree") {
                                    echo '<p class="main_information">Продавцу не пришли средства за выполненый этап работы, пока оплата не будет
                                    сделана и подтверждена продавцом, заказ будет приостановлен.</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
            endwhile;
            ?>
        </div>
        <?php
        if (order_bd('progress') == 3):
            function review_check()
            {
                global $bd_connect, $orderer_resolt, $responsible_resolt, $order_id, $my_nik;
                $resolt = false;
                $orderer_nik = $orderer_resolt["nik"];
                $orderer_email = $orderer_resolt["email"];

                $responsible_nik = $responsible_resolt["nik"];
                $responsible_email = $responsible_resolt["email"];
                $review_sql = "SELECT * FROM `reviews` WHERE (`nik` = ? AND `email` = ?) OR (`nik` = ? AND `email` = ?)";
                $stmt_review = mysqli_prepare($bd_connect, $review_sql);
                mysqli_stmt_bind_param($stmt_review, "ssss", $orderer_nik, $responsible_email, $responsible_nik, $orderer_email);
                mysqli_stmt_execute($stmt_review);
                $review_query = mysqli_stmt_get_result($stmt_review);
                while ($review_resolt = mysqli_fetch_assoc($review_query)) {
                    if ($review_resolt['nik'] == $my_nik) {
                        $resolt = true;
                    }
                }

                return $resolt;
            }
            if (review_check() == false):
                ?>
                <div class="review_write" id="review">
                    <div class="overlay">
                        <div class="loader"></div>
                    </div>
                    <h3>Заказ выполнен, вы можете оставить отзыв</h3>
                    <div class="review_wrapper">
                        <div class="smiles">
                            <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="good_smile"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg></div>
                            <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="bad_smile"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg></div>
                        </div>
                        <div class="review">
                            <div>
                                <u class="warning"></u>
                                <?php
                                if (order_bd('nik') == $my_nik) {
                                    echo '<textarea name="" placeholder="Напишите отзыв продавцу, это поможет облегчить выбор другим покупателям." id="" cols="30" rows="10" class="right_in" maxlength="500"></textarea>';
                                } else {
                                    echo '<textarea name="" placeholder="Напишите отзыв заказчику, это поможет облегчить выбор другим исполнителям." id="" cols="30" rows="10" class="right_in" maxlength="500"></textarea>';
                                }
                                ?>
                            </div>
                            <div class="length_controll">
                                <p><span>0</span>/500</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="none_ready">Отправить отзыв</button>
                    </div>
                </div>
                <?php
            endif;
        endif;
        ?>
    </div>
    <div class="double_information">
        <div class="main_information">
            <div class="information_part">
                <div>
                    <p class="information_name">Статус заказа:</p>
                </div>
                <div class="resolt status">
                    <?php
                    if (order_bd('time') == 0 && order_bd('progress') == 2) {
                        echo "<p title='Исполнитель должен приступить к выполнению' class='waiting'>Ожидание</p>";
                    } elseif (order_bd('time') == 1) {
                        echo "<p title='Исполнитель уже работает над заказом'>В работе</p>";
                    } elseif (order_bd('time') == 2 || order_bd('time') == 3) {
                        echo "<p title='Исполнитель ждёт вашу проверку' class='waiting'>На проверке</p>";
                    } elseif (order_bd('time') == 4) {
                        echo "<p title='Исполнитель подтверждает вашу оплату' class='waiting'>Проверка оплаты</p>";
                    } elseif (order_bd('time') == 5) {
                        echo "<p title='Исполнитель ждёт вашу оплату' class='waiting'>Ожидание оплаты</p>";
                    } else {
                        echo "<p>Завершён</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="information_part">
                <div>
                    <p class="information_name">Остаток цены:</p>
                </div>
                <div class="resolt">
                    <p>
                        <?= $application_resolt['price'] ?> ₽
                    </p>
                </div>
            </div>
        </div>
        <div class="double_objects">
            <?php
            if (!empty(order_bd('file_path'))):
                ?>
                <div class="object">
                    <div class="object_wrapper">
                        <div class="object_icon"><svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z" />
                            </svg></div>
                        <div>
                            <p class="double_name">Файлы заказа</p>
                        </div>
                        <div class="object_sub">
                            <div class="file">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="../bd_send/order/order_files/<?= order_bd('file_path') ?>" download>
                                        <p>
                                            <?= order_bd('file_path') ?>
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="arrow">
                        <button><svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                            </svg></button>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <div class="object">
                <div class="object_wrapper">
                    <div class="object_icon"><svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z" />
                        </svg></div>
                    <div>
                        <p class="double_name">Помощь</p>
                    </div>
                    <div class="object_sub help">
                        <div>
                            <b>Продавец не отвечает на мои сообщения</b>
                            <p>Ответ некоторых продавцов может занять большее время, чем вы ожидали из-за разницы во
                                времени или выходных. Если вы чувствуете, что продавец отвечает слишком долго, вы можете
                                создать запрос на отмену заказа.</p>
                        </div>
                        <div>
                            <b>Работа, которую сдал продавец, отличалась от того, какой он её описывал</b>
                            <p>Скажите продовцу что вы не это хотели, и чтоб он переделал работу. Если в ответ вы
                                получаете отказ то обратитесь в <a href="support_user.php">службу поддержки</a> для
                                решения данной
                                проблемы.</p>
                        </div>
                    </div>
                </div>
                <div class="arrow">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="button_option">
                <?php
                if (order_bd('progress') == 2):
                    if ($orderer_resolt['nik'] !== $my_nik) {
                        if (order_bd('time') == 1) {
                            if (response_bd('price') == 0) {
                                echo '<button id="0">Завершить заказ</button>';
                            } else {
                                echo '<button class="none_active" title="Завершить работу можно только после того, как весь заказ будет выполнен и цена в остатке будет 0 рублей">Завершить заказ</button>';
                                echo '<button id="4">Сдать этап работы</button>';
                            }
                        } else if (order_bd('time') == 4) {
                            echo '<button id="6">Получил оплату</button>';
                            echo '<button id="7">Не получал средств</button>';
                        } else if (order_bd('time') == 5) {
                            echo '<button id="6">Получил оплату</button>';
                        }
                    }
                    if ($orderer_resolt['nik'] == $my_nik) {
                        if (order_bd('time') == 1) {
                            echo '<button id="1">Запросить работу</button>';
                        } else if (order_bd('time') == 3) {
                            echo '<button id="2">Принять работу</button>';
                            echo '<button id="3">Отправить на доработку</button>';
                        } else if (order_bd('time') == 2) {
                            echo '<button id="5">Оплатить</button>';
                            echo '<button id="1">Запросить этап</button>';
                            echo '<button id="3">Отправить на доработку</button>';
                        } else if (order_bd('time') == 5) {
                            echo '<button id="5">Оплатить</button>';
                        }
                    }
                    ?>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/order/order_progress/time_prgress.js"></script>
<script src="../page_js/order/order_progress/order_include.js"></script>
</body>

</html>