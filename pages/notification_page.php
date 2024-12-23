<?php
session_start();
include "../bd_send/database_connect.php";
$user_nik = $_SESSION["nik"];
if (!isset($user_nik)) {
    header("Location: home.php");
} else {
    //notification_clean
    $none_notification = 0;
    $none_notification_sql = "UPDATE `user_notification` SET `bell` = ? WHERE `nik` = ?";
    $stmt_none_notification = mysqli_prepare($bd_connect, $none_notification_sql);
    mysqli_stmt_bind_param($stmt_none_notification, "is", $none_notification, $user_nik);
    mysqli_stmt_execute($stmt_none_notification);
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/notification_page.css'>";
echo "<title>Мои уведомления</title>";
include "../layouts/header_line.php";

//page_system
$notifications_per_page = 15;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $notifications_per_page;
$page_sql = "SELECT * FROM `notifications` WHERE `order_nik` = ? LIMIT ?, ?";
$stmt_page = mysqli_prepare($bd_connect, $page_sql);
mysqli_stmt_bind_param($stmt_page, "sii", $user_nik, $offset, $notifications_per_page);
mysqli_stmt_execute($stmt_page);
$page_query = mysqli_stmt_get_result($stmt_page);

$sql_count = "SELECT COUNT(*) as total FROM `notifications` WHERE `order_nik` = ?";
$stmt_count = mysqli_prepare($bd_connect, $sql_count);
mysqli_stmt_bind_param($stmt_count, "s", $user_nik);
mysqli_stmt_execute($stmt_count);
$count_query = mysqli_stmt_get_result($stmt_count);
$count_row = mysqli_fetch_assoc($count_query);
$total_notifications = $count_row['total'];
$total_pages = ceil($total_notifications / $notifications_per_page);
?>
<div class="container notification_container">
    <div class="header">
        <div class="header_title">
            <div>
                <h2>Мои уведомления</h2>
            </div>
            <div class="notification_options">
                <?php
                if ($total_pages >= 2):
                    ?>
                    <div class="pagination">
                        <div class="arrow left_arrow">
                            <?php
                            if ($page == 1) {
                                echo '<a href="?page=' . ($page - 1) . '" class="none_active">';
                            } else {
                                echo '<a href="?page=' . ($page - 1) . '">';
                            }
                            ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                            </svg></a>
                        </div>
                        <div class="number_part">
                            <div><b class="page_number">
                                    <?= $page ?>
                                </b></div>
                            <div><b class="slash">/</b></div>
                            <div><b class="page_number end_page">
                                    <?= $total_pages ?>
                                </b></div>
                        </div>
                        <div class="arrow right_arrow">
                            <?php
                            if ($page == $total_pages) {
                                echo '<a href="?page=' . ($page + 1) . '" class="none_active">';
                            } else {
                                echo '<a href="?page=' . ($page + 1) . '">';
                            }
                            ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                            </svg></a>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <div class="delite_number">
                    <p>Выбрано: <b>0</b></p>
                    <div class="button">
                        <input type="text" class="notification_id" readonly>
                        <button>Удалить</button>
                    </div>
                </div>
                <div class="delite_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="delite" height="1em"
                        viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="notifications">
            <div class="content">
                <p class="page">
                    <?= $_GET["page"]; ?>
                </p>
                <div class="notifications_wrapper">
                    <?php
                    $notification_temp = 0;
                    $sql = "SELECT * FROM `notifications` WHERE `order_nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $user_nik);
                    mysqli_stmt_execute($stmt);
                    $query = mysqli_stmt_get_result($stmt);
                    $notificationBlocks = array();

                    if ($page >= 1):
                        function messenger_contact($value)
                        {
                            global $bd_connect, $user_nik, $row;
                            $companion_nik = $row['nik'];
                            $chat_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)";
                            $stmt_chat = mysqli_prepare($bd_connect, $chat_sql);
                            mysqli_stmt_bind_param($stmt_chat, "ssss", $user_nik, $companion_nik, $companion_nik, $user_nik);
                            mysqli_stmt_execute($stmt_chat);
                            $chat_query = mysqli_stmt_get_result($stmt_chat);
                            if ($value == 1) {
                                return mysqli_fetch_assoc($chat_query)['chat_id'];
                            }
                        }
                        while ($row = mysqli_fetch_assoc($query)):
                            $notification_temp++;
                            $order_id = $row['id'];
                            $nik = $row['nik'];
                            $order_type = $row['type'];

                            //user_id
                            $id_query = "SELECT id FROM user_registoring WHERE nik = ?";
                            $stmt_id = mysqli_prepare($bd_connect, $id_query);
                            mysqli_stmt_bind_param($stmt_id, "s", $nik);
                            mysqli_stmt_execute($stmt_id);
                            $id_result = mysqli_stmt_get_result($stmt_id);
                            $id_row = mysqli_fetch_assoc($id_result);
                            $user_id = $id_row['id'];

                            //user_icon
                            $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = ?";
                            $stmt_icon = mysqli_prepare($bd_connect, $icon_query);
                            mysqli_stmt_bind_param($stmt_icon, "s", $nik);
                            mysqli_stmt_execute($stmt_icon);
                            $icon_resolt = mysqli_stmt_get_result($stmt_icon);
                            $icon_row = mysqli_fetch_assoc($icon_resolt);
                            $user_icon = $icon_row['icon_path'];


                            if ($order_type == 'invite' || $order_type == 'personal'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <?php
                                                if ($row['type'] == 'personal') {
                                                    echo "<h3>Личный заказ</h3>";
                                                } else {
                                                    echo "<h3>Приглашение в заказ</h3>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $notification_file_class = null;
                                        if (empty($row["order_file"])) {
                                            $notification_file_class = "no_file";
                                        }
                                        ?>
                                        <div class="main_notification <?= $notification_file_class ?>">
                                            <div>
                                                <div>
                                                    <h4>
                                                        <?= $row['order_name'] ?>
                                                    </h4>
                                                </div>
                                                <?php
                                                if ($row['type'] == 'personal'):
                                                    ?>
                                                    <div>
                                                        <p>
                                                            <?= $row['order_information'] ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                endif;
                                                ?>
                                            </div>
                                            <div class="order_files">
                                                <div>
                                                    <h4>Файлы</h4>
                                                </div>
                                                <div class="files">
                                                    <a href="../bd_send/order/personal_order_files/<?= $row['order_file'] ?>"
                                                        download>Скачать
                                                        документ</a>
                                                </div>
                                            </div>
                                            <div>
                                                <?php
                                                if ($row['type'] == 'personal') {
                                                    echo '<div><a href=""><button>Взять задачу</button></a></div>';
                                                } else {
                                                    echo '<div><a href="order_page.php?order_id=' . $row['order_information'] . '"><button>Посмотреть заказ</button></a></div>';
                                                }
                                                ?>
                                                <div><button class="remove_order">Отказаться</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'application'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="order_page.php?order_id=<?= $row['order_information'] ?>"
                                                        title="Заявка к заказу №<?= $row['order_information'] ?>">
                                                        <?= $nik ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Отправил(а) заявку</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'review'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $nik ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Написал(а) отзыв</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'execution'):
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Исполнение заказа</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Вы наняты исполнителем заказа.</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><button class="start_order">Приступить</button></a></div>
                                                <div><button class="remove_order">Отказаться</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'refusal'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Отказ от заказа</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>
                                                        <?= $row['order_information'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'payment_ask'):
                                messenger_contact(0);
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Запрос оплаты</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Исполнитель сделал определённую часть работы и показал вам результат.
                                                        Так же исполнитель создал запрос на сумму
                                                        <?= $row['payment_sum'] ?>₽. Как только часть работы будет вами
                                                        проверина и
                                                        оплачена,
                                                        исполнитель продолжит выполнение.
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><a href="order_progress.php?order_id=<?= $row['order_information'] ?>"><button>Перейти
                                                            в заказ</button></a></div>
                                                <div><a href="messages.php?chat_id=<?= messenger_contact(1); ?>"><button>Открыть
                                                            чат</button></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'payment_disagree'):
                                messenger_contact(0);
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Ожидание оплаты</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Продовцу не пришли средства за выполненый этап работы, пока оплата не будет
                                                        сделана и подтверждена продавцом, заказ будет приостановлен.</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><a href="order_progress.php?order_id=<?= $row['order_information'] ?>"><button>Перейти
                                                            в заказ</button></a></div>
                                                <div><a href="messages.php?chat_id=<?= messenger_contact(1); ?>"><button>Открыть
                                                            чат</button></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'payment_check'):
                                messenger_contact(0);
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Проверка оплаты</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Заказчик проверил ваш этап работы и перевёл вам сумму на указанные в
                                                        настройках реквезиты в размере
                                                        <?= $row['payment_sum'] ?>₽. Подтвердите действие в заказе.
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><a href="order_progress.php?order_id=<?= $row['order_information'] ?>"><button>Перейти
                                                            в заказ</button></a></div>
                                                <div><a href="messages.php?chat_id=<?= messenger_contact(1); ?>"><button>Открыть
                                                            чат</button></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'order_finish'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Завершение заказа</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Покупатель успешно одобрил и оплатил выполнение заказа. Напишите <a
                                                            href="order_progress.php?order_id=<?= $row['order_information'] ?>#review">отзыв
                                                            о сотрудничестве</a>.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'payment_agree'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Подтверждение оплаты</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Продавец успешно подтвердил приход средств на кошелёк, и уже продолжает
                                                        работу над заказом.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'order_start'):
                                ?>
                                <div class="notification" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Приступление к заказу</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Исполнитель приступил к работе над заказом. Вскоре продавец скринит вам
                                                        первые результаты работы которые вы должны проверить и оплатить.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'order_check'):
                                messenger_contact(0);
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Сдача работы</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Продовец сдал работу на проверку</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><a href="order_progress.php?order_id=<?= $row['order_information'] ?>"><button>Перейти
                                                            в заказ</button></a></div>
                                                <div><a href="messages.php?chat_id=<?= messenger_contact(1); ?>"><button>Открыть
                                                            чат</button></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'order_return'):
                                messenger_contact(0);
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Возврат на доработку</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Покупатель вернул заказ на доработку</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><a href="order_progress.php?order_id=<?= $row['order_information'] ?>"><button>Перейти
                                                            в заказ</button></a></div>
                                                <div><a href="messages.php?chat_id=<?= messenger_contact(1); ?>"><button>Открыть
                                                            чат</button></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            if ($order_type == 'order_ask'):
                                messenger_contact(0);
                                ?>
                                <div class="notification execution" id="<?= $row['id'] ?>">
                                    <noscript class="execution_id">
                                        <?= $row['order_information'] ?>
                                    </noscript>
                                    <div class="overlay">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="notification_wrapper">
                                        <input type="checkbox" class="checkbox">
                                        <div class="top_part">
                                            <div class="user_notification">
                                                <div class="img">
                                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <div>
                                                    <a href="user_page.php?user_id=<?= $user_id ?>">
                                                        <?= $row['nik'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <h3>Запрос работы</h3>
                                            </div>
                                        </div>
                                        <div class="main_notification">
                                            <div>
                                                <div>
                                                    <h3>
                                                        <?= $row['order_name'] ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <p>Покупатель запросил у вас работу, дайте ему обратную связь. Будте осторожны,
                                                        не давайте покупателю работу без его оплаты. Подтвердите и докажите, что
                                                        определённый этап работы был сделан, но не давайте всю работу на руки без
                                                        оплаты.</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div><a href="order_progress.php?order_id=<?= $row['order_information'] ?>"><button>Перейти
                                                            в заказ</button></a></div>
                                                <div><a href="messages.php?chat_id=<?= messenger_contact(1); ?>"><button>Открыть
                                                            чат</button></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endwhile;
                    endif;
                    if ($notification_temp == 0) {
                        echo "<p>Нет увидомлений</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/user/personal_order.js"></script>
<script src="../page_js/user/notification_length.js"></script>
<script src="../page_js/notification/icon_choice.js"></script>
</body>

</html>