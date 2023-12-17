<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
} else {
    include "../bd_send/database_connect.php";
    if ($user_resolt["role"] == "seller") {
        header("Location: tasks.php");
    }
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
                    <u class="warning"></u>
                    <input type="text" name="order_name" class="check_value warning_checkable order_name right_order"
                        placeholder="Введите название вашего заказа">
                </div>
                <div class="form_part">
                    <b class="input_name">Описание</b>
                    <u class="warning"></u>
                    <textarea name="order_information" class="check_value warning_checkable right_order"
                        placeholder="Введите описание вашего заказа" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="form_part">
                    <b class="input_name">Файл</b>
                    <input type="file" name="file_send" class="right_order">
                </div>
                <div class="form_part budget">
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
                                <u class="warning"></u>
                                <div>
                                    <input type="number" placeholder="Введите сумму" name="order_price"
                                        class="right_order money_right sub_element check_value">
                                    <span class="sub_element">₽</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_part">
                    <b class="input_name">Оплата</b>
                    <input type="text" name="payment_option" readonly class="payment_option">
                    <div class="option_choice">
                        <div class="option option_one" id="0" title="Оплатить заранее данный заказ">
                            <div><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                    viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                </svg></div>
                            <p>Оплата зарание</p>
                        </div>
                        <div class="option option_two hover_active" id="1"
                            title="Оплатить заказ после подтверждения о выполненой работе">
                            <div><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                    viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z" />
                                </svg></div>
                            <p>Оплата после выполнения</p>
                        </div>
                    </div>
                </div>
                <div class="form_part">
                    <b class="input_name">Тип</b>
                    <input type="text" name="order_type" class="right_order type_input" readonly>
                    <div class="type_sub">
                        <div class="close_menu">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <style>
                                    svg {
                                        fill: #d08e0b
                                    }
                                </style>
                                <path
                                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z">
                                </path>
                            </svg>
                        </div>
                        <div class="type_options">
                            <div class="type_options">
                                <p>Заказ</p>
                            </div>
                            <div class="type_options last_option">
                                <p>Вакансия</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_part category_part">
                    <div class="category_header">
                        <b class="input_name">Категория</b>
                        <u class="warning"></u>
                        <div class="restart" title="Очистить категорию">
                            <svg xmlns="http://www.w3.org/2000/svg" class="rubbish" height="1em"
                                viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M49.7 32c-10.5 0-19.8 6.9-22.9 16.9L.9 133c-.6 2-.9 4.1-.9 6.1C0 150.7 9.3 160 20.9 160h94L140.5 32H49.7zM272 160V32H173.1L147.5 160H272zm32 0H428.5L402.9 32H304V160zm157.1 0h94c11.5 0 20.9-9.3 20.9-20.9c0-2.1-.3-4.1-.9-6.1L549.2 48.9C546.1 38.9 536.8 32 526.3 32H435.5l25.6 128zM32 192l4 32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H44L64 448c0 17.7 14.3 32 32 32s32-14.3 32-32H448c0 17.7 14.3 32 32 32s32-14.3 32-32l20-160h12c17.7 0 32-14.3 32-32s-14.3-32-32-32h-4l4-32H32z" />
                            </svg>
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="main_category input_block" id="0"><input type="text" name="main_order_category"
                                id="0" class="right_order category_input" placeholder="Выбирите категорию" readonly>
                        </div>
                        <div class="final_category input_block" id="1"></div>
                        <div class="final_category input_block" id="2"></div>
                    </div>
                    <div class="category_choice">
                        <div class="close_menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="rubbish" height="1em"
                                viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M49.7 32c-10.5 0-19.8 6.9-22.9 16.9L.9 133c-.6 2-.9 4.1-.9 6.1C0 150.7 9.3 160 20.9 160h94L140.5 32H49.7zM272 160V32H173.1L147.5 160H272zm32 0H428.5L402.9 32H304V160zm157.1 0h94c11.5 0 20.9-9.3 20.9-20.9c0-2.1-.3-4.1-.9-6.1L549.2 48.9C546.1 38.9 536.8 32 526.3 32H435.5l25.6 128zM32 192l4 32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H44L64 448c0 17.7 14.3 32 32 32s32-14.3 32-32H448c0 17.7 14.3 32 32 32s32-14.3 32-32l20-160h12c17.7 0 32-14.3 32-32s-14.3-32-32-32h-4l4-32H32z" />
                            </svg>
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
                        <div class="category_options">
                            <div class="category_option">
                                <p>Дизайн</p>
                            </div>
                            <div class="category_option">
                                <p>Разработка и IT</p>
                            </div>
                            <div class="category_option">
                                <p>Тексты и переводы</p>
                            </div>
                            <div class="category_option">
                                <p>SEO и трафик</p>
                            </div>
                            <div class="category_option">
                                <p>Соцсети и реклама</p>
                            </div>
                            <div class="category_option">
                                <p>Аудио, видео, съемка</p>
                            </div>
                            <div class="category_option">
                                <p>Бизнес и жизнь</p>
                            </div>
                            <div class="category_option last_option">
                                <p>Учеба и репетиторство</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button_wrapper">
                    <button class="none_active">Разместить задачу</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/order/user_email.js"></script>
<script src="../page_js/order/checkbox_choice.js"></script>
<script src="../page_js/order/category_menu.js"></script>
<script src="../page_js/order/value_information.js"></script>
<script src="../page_js/order/order_values/value_save.js"></script>
</body>

</html>