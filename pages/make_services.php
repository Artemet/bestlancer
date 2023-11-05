<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/make_services.css'>";
echo "<title>Создание услуги</title>";
include "../layouts/modal/change_information.php";
include "../layouts/header_line.php";
?>
<div class="container make_service">
    <div class="header">
        <div class="header_title">
            <h2>Создание услуги</h2>
        </div>
        <form action="../bd_send/services/send_service.php" method="post" enctype="multipart/form-data">
            <div class="form_part">
                <b class="input_name">Выбирите категорию</b>
                <input type="text" name="category" class="category_menu right_in" placeholder="Выбирите категорию"
                    readonly>
                <div class="category_sub">
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
                    <div class="category_option">
                        <p>Учеба и репетиторство</p>
                    </div>
                </div>
            </div>
            <div class="form_part">
                <b class="input_name">Превью услуги</b>
                <input type="file" name="file_send" class="right_in" accept=".jpg,.png,.jpeg">
            </div>
            <div class="form_part">
                <b class="input_name">Название услуги</b>
                <input type="text" name="service_name" class="right_in" placeholder="Введите название услуги">
            </div>
            <div class="form_part">
                <b class="input_name">Описание услуги</b>
                <textarea name="service_information" class="right_in" placeholder="Опишите свою услугу" id="" cols="30"
                    rows="10"></textarea>
            </div>
            <div class="form_part money_part">
                <b class="input_name">Цена услуги</b>
                <div>
                    <input type="number" name="service_price" class="right_in" min="5"
                        placeholder="Введите среднию цену услуги">
                    <span class="dolar">$</span>
                </div>
            </div>
            <div class="button_wrapper">
                <button>Разместить услугу</button>
            </div>
        </form>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/service/category_menu.js"></script>
</body>

</html>