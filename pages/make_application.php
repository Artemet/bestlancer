<?php
session_start();
include "../bd_send/database_connect.php";
if ($user_resolt["role"] == "buyer") {
    header("Location: home.php");
} elseif (!isset($_SESSION["nik"])) {
    header("Location: home.php");
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/make_application.css'>";
$nik = $_SESSION["nik"];
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT * FROM `orders` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($query);

    if ($order) {
        $order_name = $order['order_name'];
        $order_price = $order['order_price'];
        $user_nik = $order['nik'];
        echo "<title>$user_nik: $order_name</title>";

        $user_responses = 0;
        $existingApplicationSql = "SELECT * FROM `orders_responses` WHERE `order_id` = ? AND `nik` = ?";
        $stmt = mysqli_prepare($bd_connect, $existingApplicationSql);
        mysqli_stmt_bind_param($stmt, "is", $order_id, $nik);
        mysqli_stmt_execute($stmt);
        $existingApplicationQuery = mysqli_stmt_get_result($stmt);
        while ($existingApplication = mysqli_fetch_assoc($existingApplicationQuery)) {
            $user_responses++;
        }
        if ($user_responses >= 1) {
            header("Location: home.php");
            exit;
        }
    } else {
        $order_name = "<title>Заказ не найден</title>";
    }
} else {
    $order_name = "<title>Заказ не найден</title>";
}

$available_class = null;
function application_filter_check()
{
    global $order, $user_resolt, $available_class, $nik, $user_nik;
    $users_legvel = intval($user_resolt['orders']);

    $good_application = intval($order['good_application']);
    $familiar_application = intval($order['familiar_application']);
    if ($good_application == 1) {
        if ($users_legvel >= 16) {
            return true;
        } else {
            $available_class = "unavailable_header";
            return false;
        }
    } elseif ($familiar_application == 1) {
        function familiar_checking()
        {
            global $bd_connect, $user_nik, $nik, $available_class, $order;
            $orderers_nik = $order["nik"];
            $checking_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = ? AND `nik_two` = ?";
            $stmt = mysqli_prepare($bd_connect, $checking_sql);
            mysqli_stmt_bind_param($stmt, "ss", $orderers_nik, $nik);
            mysqli_stmt_execute($stmt);
            $checking_query = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($checking_query) >= 1) {
                return true;
            } else {
                $available_class = "unavailable_header";
                return false;
            }
        }

        return familiar_checking();
    } else {
        return true;
    }
}
include "../layouts/header_line.php";
?>
<div class="application_page container">
    <noscript class="order_id_number">
        <?= $order_id ?>
    </noscript>
    <noscript class="order_type">
        <?= $order["type"] ?>
    </noscript>
    <?php
    if (!application_filter_check()):
        ?>
        <div class="unavailable">
            <p>К данному заказу стоит сортировка по которой вы не проходите!</p>
        </div>
        <?php
    endif;
    ?>
    <div class="header <?= $available_class ?>">
        <div class="header_title">
            <?php
            if ($order["type"] == 1) {
                echo "<h2>Ваша заявка к вакансии № $order_id</h2>";
            } else {
                echo "<h2>Ваша заявка к заказу № $order_id</h2>";
            }
            ?>
        </div>
        <div class="make_application">
            <?php
            //block_check
            $user_blocked = false;
            $blocking_orderer = $order['nik'];
            $block_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)) AND `status` = 'block'";
            $stmt = mysqli_prepare($bd_connect, $block_sql);
            mysqli_stmt_bind_param($stmt, "ssss", $nik, $blocking_orderer, $blocking_orderer, $nik);
            mysqli_stmt_execute($stmt);
            $block_query = mysqli_stmt_get_result($stmt);
            while ($block_resolt = mysqli_fetch_assoc($block_query)) {
                $user_blocked = true;
            }
            if ($user_blocked == true) {
                echo "<p>Заказ недоступен</p>";
            }
            if ($user_blocked == false):
                ?>
                <div class="overlay">
                    <div class="loader"></div>
                </div>
                <div class="wrapper">
                    <?php
                    if ($order_price == 0) {
                        echo "<p class='max_price'>Заказчик поставил договорную цену</p>";
                    } else {
                        echo "<p class='max_price'>Заказчик указал бюджет: <b class='price'>$order_price</b><b>₽</b></p>";
                    }
                    ?>
                    <div class="part_wrapper">
                        <div>
                            <div class="application_price application_information">
                                <div class="value_wrapper">
                                    <u class="warning"></u>
                                    <?php
                                    if ($order_price == 0) {
                                        echo "<input type='number' name='price' min='300' class='right_in checkable'
                                        placeholder='Цена'>";
                                    } else {
                                        echo "<input type='number' name='price' min='300' max='$order_price' class='right_in checkable'
                                        placeholder='Цена'>";
                                    }
                                    ?>
                                </div>
                                <div>
                                    <span>₽</span>
                                </div>
                            </div>
                            <?php
                            if ($order["type"] == 0):
                                ?>
                                <div class="application_time application_information">
                                    <div class="value_wrapper">
                                        <u class="warning"></u>
                                        <input type="number" name="time" min="1" class="right_in checkable" placeholder="Сроки">
                                    </div>
                                    <div>
                                        <p>суток</p>
                                    </div>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                        <div>
                            <div class="payment_option_choice">
                                <p>Выберете способ оплаты <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg"
                                            height="1em"
                                            viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z" />
                                        </svg></span></p>
                                <div class="option_sub">
                                    <div class="option">
                                        <input type="checkbox">
                                        <p>QIWI Кошелек</p>
                                    </div>
                                    <div class="option">
                                        <input type="checkbox">
                                        <p>На рублевую карту Visa/Mastercard/Мир</p>
                                    </div>
                                    <div class="option">
                                        <input type="checkbox">
                                        <p>На крипто-кошелек USDT TRC20</p>
                                    </div>
                                    <input type="text" name="payment_option" class="option_resolt" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <?php
                        if ($order["type"] == 1) {
                            echo '<textarea name="user_message" class="right_in" placeholder="Сообщение работодателю..." id="" cols="30"
                            rows="10"></textarea>';
                        } else {
                            echo '<textarea name="user_message" class="right_in" placeholder="Сообщение заказчику..." id="" cols="30"
                            rows="10"></textarea>';
                        }
                        ?>
                    </div>
                    <div class="form_send_block">
                        <button class="form_send none_ready">Отправить</button>
                    </div>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/order/payment_option.js"></script>
<script src="../page_js/order/order_values/make_application_value.js"></script>
</body>

</html>