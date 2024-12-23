<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION["nik"])) {
    $nik = $_SESSION["nik"];
}
$user_order = FALSE;
include "../bd_send/database_connect.php";
include "../layouts/header.php";
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT * FROM `orders` WHERE `id` = ?";
    $order_stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($order_stmt, "i", $order_id);
    mysqli_stmt_execute($order_stmt);
    $query = mysqli_stmt_get_result($order_stmt);
    $order = mysqli_fetch_assoc($query);
    if (isset($_SESSION["nik"])) {
        if ($order["nik"] === $nik) {
            echo "<link rel='stylesheet' href='../page_css/modal_css/invite_application.css'>";
            echo "<link rel='stylesheet' href='../page_css/modal_css/order_start.css'>";
        }
    }
    if ($order) {
        $pageTitle = $order['order_name'];
    } else {
        echo "<link rel='stylesheet' href='../local_css/error.css'>";
        echo "<title>Заказ не найден</title>";
        include "../bd_send/warnings/rong_order.php";
        exit;
    }
} else {
    header("Location: home.php");
    exit;
}

echo "<link rel='stylesheet' href='../page_css/order_page.css'>";
echo "<link rel='stylesheet' href='../page_css/media/order_page_media.css'>";
echo "<title>$pageTitle</title>";
include "../layouts/modal/change_information.php";
if (isset($_SESSION["nik"])) {
    if ($order["nik"] === $nik) {
        include "../layouts/modal/invite_application.php";
        include "../layouts/modal/order/order_start.php";
    }
}
$orderer_nik = $order["nik"];
$row = mysqli_fetch_assoc($query);
include "../layouts/header_line.php";
?>
<div class="order_page container">
    <p class="order_id">
        <?= $order_id ?>
    </p>
    <div class="header">
        <div class="copy_icon"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="18"
                viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                <path
                    d="M352 224H305.5c-45 0-81.5 36.5-81.5 81.5c0 22.3 10.3 34.3 19.2 40.5c6.8 4.7 12.8 12 12.8 20.3c0 9.8-8 17.8-17.8 17.8h-2.5c-2.4 0-4.8-.4-7.1-1.4C210.8 374.8 128 333.4 128 240c0-79.5 64.5-144 144-144h80V34.7C352 15.5 367.5 0 386.7 0c8.6 0 16.8 3.2 23.2 8.9L548.1 133.3c7.6 6.8 11.9 16.5 11.9 26.7s-4.3 19.9-11.9 26.7l-139 125.1c-5.9 5.3-13.5 8.2-21.4 8.2H384c-17.7 0-32-14.3-32-32V224zM80 96c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16H400c8.8 0 16-7.2 16-16V384c0-17.7 14.3-32 32-32s32 14.3 32 32v48c0 44.2-35.8 80-80 80H80c-44.2 0-80-35.8-80-80V112C0 67.8 35.8 32 80 32h48c17.7 0 32 14.3 32 32s-14.3 32-32 32H80z" />
            </svg></div>
        <script>
            $(document).ready(function () {
                $('.order_page .header .copy_icon svg').click(function () {
                    var tempTextarea = $('<textarea>');
                    tempTextarea.val(window.location.href);
                    $('body').append(tempTextarea);
                    tempTextarea.select();
                    document.execCommand('copy');
                    tempTextarea.remove();
                    alert("Ссылка скопирована!");
                });
            });
        </script>
        <div class="header_title">
            <?php
            if (isset($_SERVER['HTTP_REFERER'])):
                $previous_page = $_SERVER['HTTP_REFERER'];
                if (strpos($previous_page, 'tasks') !== false):
                    ?>
                    <a href="<?= $previous_page ?>" class="back_page">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                            </svg>
                        </div>
                        <div>
                            <p>Назад</p>
                        </div>
                    </a>
                    <?php
                endif;
            endif;
            ?>
            <div class="header_wrapper">
                <?php
                //icon_connect
                $nik = $order['nik'];
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = ?";
                $stmt = mysqli_prepare($bd_connect, $icon_query);
                mysqli_stmt_bind_param($stmt, "s", $nik);
                mysqli_stmt_execute($stmt);
                $icon_resolt = mysqli_stmt_get_result($stmt);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                ?>
                <div class="user_information">
                    <div><img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false"></div>
                    <div>
                        <?php
                        $nik = $order['nik'];
                        $query = "SELECT id FROM user_registoring WHERE nik = ?";
                        $stmt = mysqli_prepare($bd_connect, $query);
                        mysqli_stmt_bind_param($stmt, "s", $nik);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                        }
                        echo '<a href="user_page.php?user_id=' . $row['id'] . '">' . $order['nik'] . '</a>';
                        ?>
                    </div>
                </div>
                <?php
                $order_name = $order['order_name'];
                $sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ?";
                $stmt = mysqli_prepare($bd_connect, $sql);
                mysqli_stmt_bind_param($stmt, "i", $order_id);
                mysqli_stmt_execute($stmt);
                $query = mysqli_stmt_get_result($stmt);

                if (isset($_SESSION["nik"])) {
                    $user_order = false;
                    if ($order['nik'] === $_SESSION["nik"]) {
                        $user_order = true;
                    }
                }

                if (isset($_SESSION["nik"])) {
                    $user_responses = 0;
                    $response_class = null;
                    $response_nik = $_SESSION["nik"];
                    $existingApplicationSql = "SELECT * FROM orders_responses WHERE order_id = ? AND nik = ?";
                    $stmt = mysqli_prepare($bd_connect, $existingApplicationSql);
                    mysqli_stmt_bind_param($stmt, "is", $order_id, $response_nik);
                    mysqli_stmt_execute($stmt);
                    $existingApplicationQuery = mysqli_stmt_get_result($stmt);
                    while ($existingApplication = mysqli_fetch_assoc($existingApplicationQuery)) {
                        $user_responses++;
                    }
                    if ($user_responses >= 1) {
                        $response_class = "ready_application";
                    }
                }

                if ($user_order === FALSE && $order['progress'] == 1) {
                    if (isset($_SESSION["nik"]) && $user_resolt["role"] == "seller") {
                        //block_check
                        $my_nik = $_SESSION["nik"];
                        $user_blocked = false;
                        $block_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)) AND `status` = 'block'";
                        $stmt = mysqli_prepare($bd_connect, $block_sql);
                        mysqli_stmt_bind_param($stmt, "ssss", $my_nik, $orderer_nik, $orderer_nik, $my_nik);
                        mysqli_stmt_execute($stmt);
                        $block_query = mysqli_stmt_get_result($stmt);
                        while ($block_resolt = mysqli_fetch_assoc($block_query)) {
                            $user_blocked = true;
                            $response_class = "ready_application";
                        }
                        echo '<div class="button_choice">
                                <div class="' . $response_class . '">';
                        if ($user_blocked == false) {
                            //max_date_push
                            $max_date_sql = "SELECT `application_date` FROM `user_registoring` WHERE `nik` = ?";
                            $stmt = mysqli_prepare($bd_connect, $max_date_sql);
                            mysqli_stmt_bind_param($stmt, "s", $my_nik);
                            mysqli_stmt_execute($stmt);
                            $max_date_query = mysqli_stmt_get_result($stmt);
                            $max_date_resolt = mysqli_fetch_assoc($max_date_query)['application_date'];

                            //application_limit_check
                            $limit_temp = 0;
                            $limit_sql = "SELECT * FROM `orders_responses` WHERE `nik` = ? AND `max_date` = ?";
                            $stmt = mysqli_prepare($bd_connect, $limit_sql);
                            mysqli_stmt_bind_param($stmt, "ss", $my_nik, $max_date_resolt);
                            mysqli_stmt_execute($stmt);
                            $limit_query = mysqli_stmt_get_result($stmt);
                            //moment_date
                            $date = date("Y.m");
                            $date_result = null;
                            list($year, $month) = explode(".", $date);
                            $date_array = array($year, $month);

                            for ($i = 0; $i < count($date_array); $i++) {
                                if ($i >= 1) {
                                    $date_result .= ".";
                                }
                                $date_result .= sprintf("%02d", $date_array[$i]);
                            }
                            while ($limit_resolt = mysqli_fetch_assoc($limit_query)) {
                                $limit_temp += substr_count($limit_resolt['response_date'], $date_result);
                            }

                            if ($limit_temp <= 30) {
                                echo '<a href="make_application.php?order_id=' . $order_id . '"><button>Добавить заявку</button></a>';
                            } else {
                                echo '<a href="rates.php"><button>Добавить заявку</button></a>';
                            }
                        } else {
                            echo '<div><button>Добавить заявку</button></div>';
                            echo '<script>setTimeout( () => {alert("Данный пользователь заблокировал вас!");}, 800);</script>';
                        }
                        echo '
                                </div>
                                <div><a href="rates.php" target="_blank"><button>Тарифный план</button></a></div>
                            </div>';
                    }
                }
                ?>
            </div>
            <h2>
                <?= $order['order_name'] ?>
            </h2>
        </div>
        <p class="order_information">
            <?= $order['order_information'] ?>
        </p>
        <?php if (!empty($order['file_path'])): ?>
            <div class="files">
                <a href="../bd_send/order/order_files/<?= $order['file_path'] ?>" title="<?= $order['file_path'] ?>"
                    download>Скачать документ</a>
            </div>
        <?php endif; ?>
        <div class="price">
            <span>
                <b class="order_price">
                    <?= $order['order_price'] ?>
                </b>
                <b>₽</b>
            </span>
        </div>
    </div>
    <div class="line" style="width: 80%"></div>
    <div class="users_applications">
        <div class="type_information">
            <?php
            if ($order['type'] == 0) {
                echo "<p>Тип: Заказ</p>";
            } else if ($order['type'] == 1) {
                echo "<p>Тип: Вакансия</p>";
            }
            ?>
        </div>
        <div class="application_number_wrapper">
            <div>
                <?php
                if ($order['progress'] == 1) {
                    echo "<h2>Заявки фрилансеров</h2>";
                } else {
                    echo "<h2>Выбранный исполнитель</h2>";
                }
                ?>
            </div>
            <?php
            if (isset($_SESSION["nik"])):
                if ($order['nik'] === $_SESSION["nik"] && $order['progress'] == 1):
                    ?>
                    <div class="add_person" title="Пригласить в заказ">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                        </svg>
                    </div>
                    <?php
                endif;
            endif;
            if (isset($_SESSION["nik"])) {
                if ($user_responses >= 1) {
                    echo "<a href='my_responses.php'>Мои заявки</a>";
                }
            }
            if (isset($_SESSION["nik"])):
                if ($order['progress'] == 1):
                    ?>
                    <div class="application_number"><span>0</span></div>
                    <?php
                endif;
            endif;
            ?>
        </div>
        <div class="applications">
            <?php if ($order['progress'] == 1): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <?php
                    $nik = $row['nik'];
                    $user_information_sql = "SELECT * FROM `user_registoring` WHERE nik = ?";
                    $user_information_stmt = mysqli_prepare($bd_connect, $user_information_sql);
                    mysqli_stmt_bind_param($user_information_stmt, "s", $nik);
                    mysqli_stmt_execute($user_information_stmt);
                    $user_information_query = mysqli_stmt_get_result($user_information_stmt);
                    $user_information_row = mysqli_fetch_assoc($user_information_query);

                    $user_id = $user_information_row['id'];
                    $user_icon = $user_information_row["icon_path"];
                    //user_icon
                    $web_payment = "";
                    $user_message = $row["user_message"];
                    if (empty($user_message)) {
                        $user_message = "<b class='no_message'>Нет сообщения</b>";
                    }
                    if ($row['order_name'] === $order_name):
                        $payment_text = $row["payment_choice"];
                        $application_nik = $row["nik"];

                        $user_nik_sql = "SELECT `name` FROM `user_registoring` WHERE `nik` = ?";
                        $user_nik_stmt = mysqli_prepare($bd_connect, $user_nik_sql);
                        mysqli_stmt_bind_param($user_nik_stmt, "s", $application_nik);
                        mysqli_stmt_execute($user_nik_stmt);
                        $user_nik_query = mysqli_stmt_get_result($user_nik_stmt);

                        $user_application_name = mysqli_fetch_assoc($user_nik_query)['name'];
                        if (!empty($row["payment_choice"])) {
                            $web_payment = "| $payment_text";
                        }
                        if ($user_order === TRUE):
                            ?>
                            <div class="application user_order">
                                <noscript class="user_id">
                                    <?= $user_id ?>
                                </noscript>
                                <div class="application_part">
                                    <div><img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false"></div>
                                    <div>
                                        <a href="user_page.php?user_id=<?= $user_id ?>">
                                            <?= $row["nik"] ?>
                                        </a>
                                    </div>
                                    <div class="arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="sub_information">
                                    <div class="part_one part">
                                        <div>
                                            <p>
                                                <?= $user_message ?>
                                            </p>
                                        </div>
                                        <div class="user_price"><span>
                                                <?= $row["price"] ?>₽
                                            </span></div>
                                    </div>
                                    <div class="part_two part">
                                        <div>
                                            <?php
                                            if ($order["type"] == 0):
                                                ?>
                                                <p>
                                                    <?= $row["time"] ?> суток
                                                </p>
                                                <?php
                                            endif;
                                            ?>
                                        </div>
                                        <div>
                                            <p>
                                                <?= $row["payment_option"] ?>
                                                <?= $web_payment ?>
                                            </p>
                                        </div>
                                        <div class="button_option">
                                            <?php
                                            if ($order["type"] == 0):
                                                ?>
                                                <button class="start_order_button">Назначить исполнителем</button>
                                                <?php
                                            endif;
                                            ?>
                                            <a href="user_page.php?user_id=<?= $user_id ?>"><button>Посмотреть профиль</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else:
                            $application_nik_assoc = $row['nik'];
                            $invite_user_temp = 0;
                            $invite_type = "invite";

                            $invite_sql = "SELECT `type` FROM `notifications` WHERE `order_nik` = ? AND `type` = ? AND `order_information` = ?";
                            $stmt = mysqli_prepare($bd_connect, $invite_sql);
                            mysqli_stmt_bind_param($stmt, "sss", $application_nik_assoc, $invite_type, $order_id);
                            mysqli_stmt_execute($stmt);
                            $invite_query = mysqli_stmt_get_result($stmt);

                            while ($invite_resolt = mysqli_fetch_assoc($invite_query)) {
                                $invite_user_temp++;
                            }
                            ?>
                            <div class="application">
                                <div class="application_part">
                                    <div><img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false"></div>
                                    <div>
                                        <?php if ($invite_user_temp >= 1): ?>
                                            <div class="invite_text">
                                                <p>Приглашён в заказ</p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($_SESSION["nik"])): ?>
                                            <?php if ($user_application_name == $_SESSION["name"]): ?>
                                                <a href="user_page.php?user_id=<?= $user_id ?>">
                                                    <?= $user_application_name ?> <b class="my_order_mark">(вы)</b>
                                                </a>
                                            <?php else: ?>
                                                <a href="user_page.php?user_id=<?= $user_id ?>">
                                                    <?= $user_application_name ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="user_page.php?user_id=<?= $user_id ?>">
                                                <?= $user_application_name ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php
                function final_user($table, $place)
                {
                    global $bd_connect, $order, $order_id;
                    $responsible_id = $order['responsible_id'];
                    $user_sql = "SELECT * FROM `user_registoring` WHERE `id` = ?";

                    $stmt = mysqli_prepare($bd_connect, $user_sql);
                    mysqli_stmt_bind_param($stmt, "i", $responsible_id);
                    mysqli_stmt_execute($stmt);
                    $user_query = mysqli_stmt_get_result($stmt);

                    if ($place == "user") {
                        $user_resolt = mysqli_fetch_assoc($user_query)[$table];
                        return $user_resolt;
                    } elseif ($place == "application") {
                        $user_resolt = mysqli_fetch_assoc($user_query)['nik'];
                        $executor_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ? AND `nik` = ?";

                        $stmt = mysqli_prepare($bd_connect, $executor_sql);
                        mysqli_stmt_bind_param($stmt, "is", $order_id, $user_resolt);
                        mysqli_stmt_execute($stmt);

                        $executor_query = mysqli_stmt_get_result($stmt);
                        $executor_resolt = mysqli_fetch_assoc($executor_query)[$table];
                        return $executor_resolt;
                    }
                }

                echo '
        <div class="application user_order">
            <noscript class="user_id">' . final_user('id', 'user') . '</noscript>
            <div class="application_part resolt_application">
                <div><img src="../bd_send/user/user_icons/' . final_user('icon_path', 'user') . '" alt="" draggable="false"></div>
                <div>
                    <div><a href="user_page.php?user_id=' . final_user('id', 'user') . '" class="full_name" target="_blank">' . final_user('name', 'user') . ' ' . final_user('family', 'user') . '</a></div>
                    <div><p class="life_information">' . final_user('age', 'user') . ', ' . final_user('country', 'user') . '</p></div>
                    <div><p class="reviews">Выполненых заказов: <b>' . final_user('orders', 'user') . '</b></p></div>
                </div>
                <div>
                    <div><p class="price">' . final_user('price', 'application') . '₽</p></div>
                    <div><p class="time">' . final_user('time', 'application') . ' суток</p></div>
                </div>
            </div>
        </div>';
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/order/account_check.js"></script>
<script src="../page_js/order/order_price_check.js"></script>
<script src="../page_js/order/application_number.js"></script>
<script src="../page_js/order/modal/invite_ajax.js"></script>
<?php
if ($user_order === TRUE) {
    echo '<script src="../page_js/order/application_menu.js"></script>';
}
if (isset($_SESSION["nik"])) {
    if ($order["nik"] === $_SESSION["nik"]) {
        echo '<script src="../page_js/order/modal/invite_application_modal.js"></script>';
        echo '<script src="../page_js/order/modal/start_order.js"></script>';
    }
}
?>
</body>

</html>