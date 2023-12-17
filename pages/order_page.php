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
    $sql = "SELECT * FROM orders WHERE id = $order_id";
    $query = mysqli_query($bd_connect, $sql);
    $order = mysqli_fetch_assoc($query);
    if (isset($_SESSION["nik"])) {
        if ($order["nik"] === $nik) {
            echo "<link rel='stylesheet' href='../page_css/modal_css/invite_application.css'>";
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
                $query = mysqli_query($bd_connect, $sql);
                $row = mysqli_fetch_assoc($query);
                $nik = $row['nik'];
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                $icon_resolt = mysqli_query($bd_connect, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                ?>
                <div class="user_information">
                    <div><img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false"></div>
                    <div>
                        <?php
                        $nik = $order['nik'];
                        $query = "SELECT id FROM user_registoring WHERE nik = '$nik'";
                        $result = mysqli_query($bd_connect, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                        }
                        echo '<a href="user_page.php?user_id=' . $row['id'] . '">' . $order['nik'] . '</a>';
                        ?>
                    </div>
                </div>
                <?php
                $order_name = $order['order_name'];
                $sql = "SELECT * FROM `orders_responses` WHERE `order_id` = '$order_id'";
                $query = mysqli_query($bd_connect, $sql);
                if (isset($_SESSION["nik"])) {
                    if ($order['nik'] === $_SESSION["nik"]) {
                        $user_order = TRUE;
                    } else {
                        $user_order = FALSE;
                    }
                }

                if (isset($_SESSION["nik"])) {
                    $user_responses = 0;
                    $response_class = null;
                    $response_nik = $_SESSION["nik"];
                    $existingApplicationSql = "SELECT * FROM orders_responses WHERE order_id = $order_id AND nik = '$response_nik'";
                    $existingApplicationQuery = mysqli_query($bd_connect, $existingApplicationSql);
                    while ($existingApplication = mysqli_fetch_assoc($existingApplicationQuery)) {
                        $user_responses++;
                    }
                    if ($user_responses >= 1) {
                        $response_class = "ready_application";
                    }
                }

                if ($user_order === FALSE) {
                    if (isset($_SESSION["nik"]) && $user_resolt["role"] == "seller") {
                        //block_check
                        $my_nik = $_SESSION["nik"];
                        $user_blocked = false;
                        $block_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = '$my_nik' AND `nik_two` = '$orderer_nik') OR (`nik_one` = '$orderer_nik' AND `nik_two` = '$my_nik')) AND `status` = 'block'";
                        $block_query = mysqli_query($bd_connect, $block_sql);
                        while ($block_resolt = mysqli_fetch_assoc($block_query)) {
                            $user_blocked = true;
                            $response_class = "ready_application";
                        }
                        echo '<div class="button_choice">
                                <div class="' . $response_class . '">';
                        if ($user_blocked == false) {
                            //max_date_push
                            $max_date_sql = "SELECT `application_date` FROM `user_registoring` WHERE `nik` = '$my_nik'";
                            $max_date_query = mysqli_query($bd_connect, $max_date_sql);
                            $max_date_resolt = mysqli_fetch_assoc($max_date_query)['application_date'];

                            //application_limit_check
                            $limit_temp = 0;
                            $limit_sql = "SELECT * FROM `orders_responses` WHERE `nik` = '$my_nik' AND `max_date` = '$max_date_resolt'";
                            $limit_query = mysqli_query($bd_connect, $limit_sql);
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
        <div class="application_number_wrapper">
            <div>
                <h2>Заявки фрилансеров</h2>
            </div>
            <?php
            if (isset($_SESSION["nik"])):
                if ($order['nik'] === $_SESSION["nik"]):
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
            ?>
            <div class="application_number"><span>0</span></div>
        </div>
        <div class="applications">
            <?php
            while ($row = mysqli_fetch_assoc($query)) {
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $nik = $row['nik'];
                $id_query = "SELECT id FROM user_registoring WHERE nik = '$nik'";
                $id_result = mysqli_query($connection, $id_query);
                $id_row = mysqli_fetch_assoc($id_result);
                $user_id = $id_row['id'];
                //user_icon
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                $icon_resolt = mysqli_query($connection, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                mysqli_close($connection);
                $web_payment = "";
                $user_message = $row["user_message"];
                if (empty($user_message)) {
                    $user_message = "<b class='no_message'>Нет сообщения</b>";
                }
                if ($row['order_name'] === $order_name) {
                    $payment_text = $row["payment_choice"];
                    $application_nik = $row["nik"];
                    $user_nik_sql = "SELECT `name` FROM `user_registoring` WHERE `nik` = '$application_nik'";
                    $user_nik_query = mysqli_query($bd_connect, $user_nik_sql);
                    $user_application_name = mysqli_fetch_assoc($user_nik_query)['name'];
                    if (!empty($row["payment_choice"])) {
                        $web_payment = "| $payment_text";
                    }
                    if ($user_order === TRUE) {
                        echo '

                                <div class="application user_order">
                                    <div class="application_part">
                                        <div><img src="../bd_send/user/user_icons/' . $user_icon . '" alt="" draggable="false"></div>
                                        <div>
                                            <a href="user_page.php?user_id=' . $user_id . '">' . $row["nik"] . '</a>
                                        </div>
                                        <div class="arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="sub_information">
                                        <div class="part_one part">
                                            <div><p>' . $user_message . '</p></div>
                                            <div class="user_price"><span>' . $row["price"] . '₽</span></div>
                                        </div>
                                        <div class="part_two part">
                                            <div><p>' . $row["time"] . ' суток</p></div>
                                            <div><p>' . $row["payment_option"] . '' . $web_payment . '</p></div>
                                            <div class="button_option">
                                                <button>Назначить исполнителем</button>
                                                <a href="user_page.php?user_id=' . $user_id . '"><button>Посмотреть профиль</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    } else {
                        $application_nik_assoc = $row['nik'];
                        $invite_user_temp = 0;
                        $invite_sql = "SELECT `type` FROM `notifications` WHERE `order_nik` = '$application_nik_assoc' AND `type` = 'invite' AND `order_information` = '$order_id'";
                        $invite_query = mysqli_query($bd_connect, $invite_sql);
                        while ($invite_resolt = mysqli_fetch_assoc($invite_query)) {
                            $invite_user_temp++;
                        }
                        echo '<div class="application"><div class="application_part"><div><img src="../bd_send/user/user_icons/' . $user_icon . '" alt="" draggable="false"></div><div>';
                        if ($invite_user_temp >= 1) {
                            echo '<div class="invite_text"><p>Приглашён в заказ</p></div>';
                        }
                        if (isset($_SESSION["nik"])) {
                            if ($user_application_name == $_SESSION["name"]) {
                                echo '<a href="user_page.php?user_id=' . $user_id . '">' . $user_application_name . ' <b class="my_order_mark">(вы)</b></a>';
                            } else {
                                echo '<a href="user_page.php?user_id=' . $user_id . '">' . $user_application_name . '</a>';
                            }
                        } else {
                            echo '<a href="user_page.php?user_id=' . $user_id . '">' . $user_application_name . '</a>';
                        }
                        echo '</div></div></div>';
                    }
                }
            }
            ?>
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
    }
}
?>
</body>

</html>