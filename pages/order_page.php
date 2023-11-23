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
    if ($order["nik"] === $nik) {
        echo "<link rel='stylesheet' href='../page_css/modal_css/invite_application.css'>";
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
if ($order["nik"] === $nik) {
    include "../layouts/modal/invite_application.php";
}
$row = mysqli_fetch_assoc($query);
include "../layouts/header_line.php";
?>
<div class="order_page container">
    <p class="order_id">
        <?= $order_id ?>
    </p>
    <div class="header">
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
                    if (isset($_SESSION["nik"]) && $_SESSION["role"] == "seller") {
                        echo '<div class="button_choice">
                                <div class="' . $response_class . '">
                                    <a href="make_application.php?order_id=' . $order_id . '"><button>Добавить заявку</button></a>
                                </div>
                                <div><a href="rates.php"><button>Тарифный план</button></a></div>
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
                <b>$</b>
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
                                            <div class="user_price"><span>' . $row["price"] . '$</span></div>
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
                        $invite_sql = "SELECT `type` FROM `notifications` WHERE `order_nik` = '$application_nik_assoc' AND `type` = 'invite'";
                        $invite_query = mysqli_query($bd_connect, $invite_sql);
                        while ($invite_resolt = mysqli_fetch_assoc($invite_query)) {
                            $invite_user_temp++;
                        }
                        echo '<div class="application"><div class="application_part"><div><img src="../bd_send/user/user_icons/' . $user_icon . '" alt="" draggable="false"></div><div>';
                        if ($invite_user_temp >= 1) {
                            echo '<div class="invite_text"><p>Приглашён в заказ</p></div>';
                        }
                        echo '<a href="user_page.php?user_id=' . $user_id . '">' . mysqli_fetch_assoc($user_nik_query)['name'] . '</a>';
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
if ($order["nik"] === $_SESSION["nik"]) {
    echo '<script src="../page_js/order/modal/invite_application_modal.js"></script>';
}
?>
</body>

</html>