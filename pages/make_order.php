<?php
    session_start();
    if (!isset($_SESSION["nik"])){
        header("Location: home.php");
    }
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/make_order.css'>";
    echo "<link rel='stylesheet' href='../page_css/media/make_order_media.css'>";
    echo "<title>Размещение заказа на бирже Bestlancer</title>";
    include "../layouts/header_line.php";
?>
<div class="make_order_container container">
    <div class="header">
        <div class="header_title">
            <h2>Разместите вашу задачу</h2>
        </div>
        <div class="main_make">
            <form action="../bd_send/order/send_order.php" method="post" enctype="multipart/form-data">
                <div class="form_part">
                    <b class="input_name">Название заказа</b>
                    <input type="text" name="order_name" class="check_value right_order"
                        placeholder="Введите название вашего заказа">
                </div>
                <div class="form_part">
                    <b class="input_name">Описание</b>
                    <textarea name="order_information" class="check_value right_order"
                        placeholder="Введите описание вашего заказа" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="form_part">
                    <b class="input_name">Файл</b>
                    <input type="file" name="file_send" class="right_order">
                </div>
                <div class="form_part">
                    <b class="input_name">Бюджет</b>
                    <div class="checkbox_wrapper">
                        <div class="checkbox_block">
                            <div class="wrapper"><input type="checkbox"></div>
                            <p>Фрилансеры предложат цены</p>
                        </div>
                        <div>
                            <div class="checkbox_block">
                                <div class="wrapper"><input type="checkbox"></div>
                                <p>Я хочу указать бюджет</p>
                            </div>
                            <div class="checkbox_sub">
                                <input type="number" placeholder="Введите сумму" name="order_price"
                                    class="right_order money_right sub_element">
                                <span class="sub_element">$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_part email_part">
                    <b class="input_name">Email</b>
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        $user_email_send = $_SESSION["email"];
                        echo "<div class='email_information'>$user_email_send</div>";
                    } else {
                        echo "";
                    }
                    ?>
                    <input type="text" name="order_email" class="right_order email_input" class="email_input" readonly>
                </div>
                <div class="form_part category_part">
                    <b class="input_name">Категория</b>
                    <input type="text" name="order_category" class="right_order category_input"
                        placeholder="Выбирите категорию" readonly>
                    <div class="category_choice">
                        <div class="close_menu">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <style>
                                    svg {
                                        fill: #d08e0b
                                    }
                                </style>
                                <path
                                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                            </svg>
                        </div>
                        <div class="category_option">
                            <p>Без категорий</p>
                        </div>
                        <div class="category_option">
                            <p>Администрирование сайтов</p>
                        </div>
                        <div class="category_option">
                            <p>Архитектура и Инжиниринг</p>
                        </div>
                        <div class="category_option">
                            <p>Веб-дизайн и Интерфейсы</p>
                        </div>
                        <div class="category_option">
                            <p>Аудио и Видео</p>
                        </div>
                        <div class="category_option">
                            <p>Веб-сайты</p>
                        </div>
                        <div class="category_option">
                            <p>Графика и Фотография</p>
                        </div>
                        <div class="category_option">
                            <p>Программирование ПО</p>
                        </div>
                        <div class="category_option">
                            <p>Продвижение сайтов (SEO)</p>
                        </div>
                        <div class="category_option">
                            <p>Программирование ПО</p>
                        </div>
                        <div class="category_option">
                            <p>Управление и Менеджмент</p>
                        </div>
                        <div class="category_option">
                            <p>Тексты и Переводы</p>
                        </div>
                        <div class="category_option">
                            <p>Экономика и Право</p>
                        </div>
                        <div class="category_option last_option">
                            <p>Учеба и репетиторство</p>
                        </div>
                    </div>
                </div>
                <div class="button_wrapper" onmouseover="value_order_check()">
                    <button>Разместить задачу</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../page_js/order/user_email.js"></script>
<script src="../page_js/order/checkbox_choice.js"></script>
<script src="../page_js/order/category_menu.js"></script>
<script src="../page_js/order/value_information.js"></script>
<?php
include "../layouts/footer.php";
?>