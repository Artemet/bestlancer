<?php
session_start();
include "../bd_send/database_connect.php";
if ($user_resolt["role"] == "buyer") {
    header("Location: home.php");
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/make_application.css'>";
$nik = $_SESSION["nik"];
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT * FROM `orders` WHERE id = $order_id";
    $query = mysqli_query($bd_connect, $sql);
    $order = mysqli_fetch_assoc($query);

    if ($order) {
        $order_name = $order['order_name'];
        $order_price = $order['order_price'];
        $user_nik = $order['nik'];
        echo "<title>$user_nik: $order_name</title>";

        $user_responses = 0;
        $existingApplicationSql = "SELECT * FROM `orders_responses` WHERE `order_id` = $order_id AND `nik` = '$nik'";
        $existingApplicationQuery = mysqli_query($bd_connect, $existingApplicationSql);
        while ($existingApplication = mysqli_fetch_assoc($existingApplicationQuery)) {
            $user_responses++;
        }
        if ($user_responses >= 1) {
            header("Location: home.php");
            exit();
        }
    } else {
        $order_name = "<title>Заказ не найден</title>";
    }
} else {
    $order_name = "<title>Заказ не найден</title>";
}
include "../layouts/header_line.php";
?>
<div class="application_page container">
    <p class="order_id_number">
        <?= $order_id ?>
    </p>
    <div class="header">
        <div class="header_title">
            <h2>Ваша заявка к заказу №
                <?= $order_id ?>
            </h2>
        </div>
        <div class="make_application">
            <?php
            //block_check
            $user_blocked = false;
            $blocking_orderer = $order['nik'];
            $block_sql = "SELECT * FROM `messenger_users` WHERE ((`nik_one` = '$nik' AND `nik_two` = '$blocking_orderer') OR (`nik_one` = '$blocking_orderer' AND `nik_two` = '$nik')) AND `status` = 'block'";
            $block_query = mysqli_query($bd_connect, $block_sql);
            while ($block_resolt = mysqli_fetch_assoc($block_query)) {
                $user_blocked = true;
            }
            if ($user_blocked == true) {
                echo "<p>Заказ недоступен</p>";
            }
            if ($user_blocked == false):
                ?>
                <form action="<?= "../bd_send/order/send_application.php?order_id=" . $order_id . "" ?>" method="post">
                    <u class="warning"></u>
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
                                <div>
                                    <?php
                                    if ($order_price == 0) {
                                        echo "<input type='number' name='price' min='5' class='right_in'
                                        placeholder='Цена'>";
                                    } else {
                                        echo "<input type='number' name='price' min='5' max='$order_price' class='right_in'
                                        placeholder='Цена'>";
                                    }
                                    ?>
                                </div>
                                <div>
                                    <span>₽</span>
                                </div>
                            </div>
                            <div class="application_time application_information">
                                <div>
                                    <input type="number" name="time" min="1" class="right_in" placeholder="Сроки">
                                </div>
                                <div>
                                    <p>суток</p>
                                </div>
                            </div>
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
                            <div class="payment_choice">
                                <div><input type="checkbox"></div>
                                <div>
                                    <p>Безопасный платеж обязателен</p>
                                </div>
                                <input type="text" name="payment_choice" class="bd_information" readonly>
                            </div>
                        </div>
                    </div>
                    <textarea name="user_message" class="right_in" placeholder="Сообщение заказчику..." id="" cols="30"
                        rows="10"></textarea>
                    <div class="form_send_block">
                        <!-- <p class="form_send">Отправить</p> -->
                        <button class="form_send">Отправить</button>
                    </div>
                </form>
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