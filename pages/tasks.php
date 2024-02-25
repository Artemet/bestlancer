<?php
session_start();
$filter = null;
$filter_number = null;
$filter_reset = null;
$pagination_href = "tasks.php?";
if (isset($_GET['filter']) && is_numeric($_GET['filter'])) {
    $filter = $_GET['filter'];
    $filter_number = intval($filter);
    $filter_reset = "<a href='tasks.php' class='filter_none' style='visibility: unset; opacity: 1;'>Сбросить фильтор</a>";
    $pagination_href = "tasks.php?filter=$filter_number&";
}
if (isset($_GET['medium_category']) && is_numeric($_GET['medium_category'])) {
    $medium_category = $_GET['medium_category'];
    $filter_number = intval($medium_category);
    $filter_reset = "<a href='tasks.php' class='filter_none' style='visibility: unset; opacity: 1;'>Сбросить фильтор</a>";
    $pagination_href = "tasks.php?medium_category=$medium_category&";
}
if (isset($_GET['final_category']) && is_numeric($_GET['final_category'])) {
    $final_category = $_GET['final_category'];
    $filter_number = intval($final_category);
    $filter_reset = "<a href='tasks.php' class='filter_none' style='visibility: unset; opacity: 1;'>Сбросить фильтор</a>";
    $pagination_href = "tasks.php?final_category=$final_category&";
}
if (isset($_GET["type"])) {
    $type = $_GET['type'];
}
$arr_temp = -1;
include "../bd_send/database_connect.php";
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/tasks.css'>";
echo "<link rel='stylesheet' href='../page_css/media/tasks_media.css'>";
echo "<title>Биржа заказов</title>";
include "../layouts/header_line.php";
include "../layouts/modal/corect_order.php";
?>
<div class="tasks_container container">
    <div class="tasks_wrapper">
        <div class="tasks">
            <?php
            if (isset($_SESSION["nik"])):
                ?>
                <div class="page_choice">
                    <?php
                    $active_order_arr = array();
                    function active_order_length($type)
                    {
                        global $bd_connect, $active_order_arr;
                        $order_length_temp = 0;
                        $application_length_temp = 0;
                        $my_id = $_SESSION["id"];
                        $my_nik = $_SESSION["nik"];

                        //order
                        $order_progress = 2;
                        $order_sql = "SELECT * FROM `orders` WHERE `nik` = ? AND `progress` = ?";
                        $order_stmt = mysqli_prepare($bd_connect, $order_sql);
                        mysqli_stmt_bind_param($order_stmt, "si", $my_nik, $order_progress);
                        mysqli_stmt_execute($order_stmt);
                        $order_query = mysqli_stmt_get_result($order_stmt);

                        $order_length_temp = 0;
                        while (mysqli_fetch_assoc($order_query)) {
                            $order_length_temp++;
                        }
                        array_push($active_order_arr, $order_length_temp);

                        //application
                        $application_progress = 2;
                        $application_sql = "SELECT * FROM `orders` WHERE `responsible_id` = ? AND `progress` = ?";
                        $application_stmt = mysqli_prepare($bd_connect, $application_sql);
                        mysqli_stmt_bind_param($application_stmt, "si", $my_id, $application_progress);
                        mysqli_stmt_execute($application_stmt);
                        $application_query = mysqli_stmt_get_result($application_stmt);

                        while (mysqli_fetch_assoc($application_query)) {
                            $application_length_temp++;
                        }

                        array_push($active_order_arr, $application_length_temp);

                        if ($type == "order") {
                            return $active_order_arr[0];
                        } elseif ($type == "application") {
                            return $active_order_arr[1];
                        }
                    }
                    ?>
                    <div class="order_link">
                        <?php
                        if (active_order_length("order") >= 1):
                            ?>
                            <div class="active_order">
                                <span>
                                    <?= active_order_length("order") ?>
                                </span>
                            </div>
                            <?php
                        endif;
                        ?>
                        <a href="my_orders.php" target="_blank">Мои заказы</a>
                    </div>
                    <div class="order_link">
                        <?php
                        if (active_order_length("application") >= 1):
                            ?>
                            <div class="active_order">
                                <span>
                                    <?= active_order_length("application") ?>
                                </span>
                            </div>
                            <?php
                        endif;
                        ?>
                        <a href="my_responses.php" target="_blank">Мои отклики</a>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <div class="block_part make_order">
                <div class="wrapper">
                    <div class="size"></div>
                    <?php
                    if (isset($_SESSION["nik"])) {
                        if ($user_resolt["role"] == "buyer") {
                            if (!isset($_SESSION["nik"])) {
                                echo '<div class="order_button" onclick="none_user_sing()">
                                        <a href="make_order.php" class="none_sign order_page_link"><button>Разместить заказ</button></a>
                                    </div>';
                            } else {
                                echo '<div class="order_button">
                                        <a href="make_order.php" class="order_page_link"><button>Разместить заказ</button></a>
                                    </div>';
                            }
                        } elseif ($user_resolt["role"] == "seller") {
                            echo '<div class="order_button">
                                        <a href="my_responses.php" class="order_page_link"><button>Мои отклики</button></a>
                                </div>';
                        }
                    }
                    ?>
                    <div class="links_wrapper">
                        <div class="icon_options">
                            <div class="icon order_filter">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                    viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                                </svg>
                                <div class="type_sub">
                                    <div class="thirst_option type_option none_use"><a
                                            href="<?= $pagination_href ?>type=orders">Заказы</a></div>
                                    <div class="type_option none_use"><a
                                            href="<?= $pagination_href ?>type=vacancies">Вакансии</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION["nik"])):
                                ?>
                                <div class="icon save_filter">
                                    <div class="icon_svg">
                                        <?php
                                        $project_filter_resolt = null;
                                        $project_filter = "SELECT `filter` FROM `user_registoring` WHERE `nik` = ?";
                                        $stmt = mysqli_prepare($bd_connect, $project_filter);
                                        mysqli_stmt_bind_param($stmt, "s", $my_nik);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $project_filter_resolt = $row['filter'];
                                        }
                                        if (empty($project_filter_resolt)):
                                            ?>
                                            <div title="Сохранить" class="none_use">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="none_save" title="Сохранить"
                                                    height="1em"
                                                    viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z" />
                                                </svg>
                                            </div>
                                            <?php
                                        endif;
                                        if (!empty($project_filter_resolt)):
                                            ?>
                                            <div title="Убрать сохранение" class="none_use">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="save active_save" height="1em"
                                                    viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                                </svg>
                                            </div>
                                            <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <script>
                                    $('.save_filter').on('click', function () {
                                        $.ajax({
                                            url: '../bd_send/order/save_page.php',
                                        })
                                            .done(function () {
                                                if ($('.save_filter svg').hasClass("none_save")) {
                                                    $('.save_filter').html('<div class="icon_svg"><div title="Убрать сохранение" class="none_use"><svg xmlns="http://www.w3.org/2000/svg" class="save" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" /></svg></div></div>');
                                                } else {
                                                    $('.save_filter').html('<div class="icon_svg"><div title="Сохранить" class="none_use"><svg xmlns="http://www.w3.org/2000/svg" class="active_save none_save" title="Сохранить" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z" /></svg></div></div>');
                                                }
                                                const get_save_icon = $('.save_filter svg');
                                                get_save_icon.toggleClass("active_save");
                                            });
                                    });
                                </script>
                                <?php
                            endif;
                            ?>
                            <div class="icon reaload_icon">
                                <?php
                                $curant_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                ?>
                                <a href="<?= $curant_link ?>"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z" />
                                    </svg></a>
                            </div>
                        </div>
                        <b class='filter_title'>Все заказы</b>
                        <div class="link_part">
                            <div><a href="tasks.php?filter=1" class="main_category">
                                    <p>Дизайн</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=0" class="medium_category">
                                            Арт и иллюстрации
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=1">Иллюстрации и рисунки</a>
                                            <a href="?final_category=2">Тату, принты</a>
                                            <a href="?final_category=3">Дизайн игр</a>
                                            <a href="?final_category=4">Готовые шаблоны и рисунки</a>
                                            <a href="?final_category=5">Портрет, шарж, карикатура</a>
                                            <a href="?final_category=6">Стикеры</a>
                                            <a href="?final_category=7">NFT арт</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=1" class="medium_category">
                                            Веб и мобильный дизайн
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=8">Мобильный дизайн</a>
                                            <a href="?final_category=9">Email-дизайн</a>
                                            <a href="?final_category=10">Веб-дизайн</a>
                                            <a href="?final_category=11">Баннеры и иконки</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=2" class="medium_category">
                                            Интерьер и экстерьер
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=12">Интерьер</a>
                                            <a href="?final_category=13">Дизайн домов и сооружений</a>
                                            <a href="?final_category=14">Ландшафтный дизайн</a>
                                            <a href="?final_category=15">Дизайн мебели</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=3" class="medium_category">
                                            Логотип и брендинг
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=16">Логотипы</a>
                                            <a href="?final_category=17">Фирменный стиль</a>
                                            <a href="?final_category=18">Брендирование и сувенирка</a>
                                            <a href="?final_category=19">Визитки</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=4" class="medium_category">
                                            Маркетплейсы и соцсети
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=20">Дизайн в соцсетях</a>
                                            <a href="?final_category=21">Дизайн для маркетплейсов</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=5" class="medium_category">
                                            Наружная реклама
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=22">Билборды и стенды</a>
                                            <a href="?final_category=23">Витрины и вывески</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=6" class="medium_category">
                                            Обработка и редактирование
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=24">Отрисовка в векторе</a>
                                            <a href="?final_category=25">3D-графика</a>
                                            <a href="?final_category=26">Фотомонтаж и обработка</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=7" class="medium_category">
                                            Полиграфия
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=27">Брошюра и буклет</a>
                                            <a href="?final_category=28">Листовка и флаер</a>
                                            <a href="?final_category=29">Плакат и афиша</a>
                                            <a href="?final_category=30">Календарь и открытка</a>
                                            <a href="?final_category=31">Каталог, меню, книга</a>
                                            <a href="?final_category=32">Грамота и сертификат</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=8" class="medium_category">
                                            Презентации и инфографика
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=33">Презентации</a>
                                            <a href="?final_category=34">Инфографика</a>
                                            <a href="?final_category=35">Карта и схема</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=9" class="medium_category">
                                            Промышленный дизайн
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=36">Упаковка и этикетка</a>
                                            <a href="?final_category=37">Электроника и устройства</a>
                                            <a href="?final_category=38">Предметы и аксессуары</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=2" class="main_category">
                                    <p>Разработка и IT</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=10" class="medium_category">
                                            Верстка
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=39">Верстка по макету</a>
                                            <a href="?final_category=40">Доработка и адаптация
                                                верстки</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=11" class="medium_category">
                                            Десктоп программирование
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=41">Программы на заказ</a>
                                            <a href="?final_category=42">Макросы для Office</a>
                                            <a href="?final_category=43">1С</a>
                                            <a href="?final_category=44">Готовые программы</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=12" class="medium_category">
                                            Доработка и настройка сайта
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=45">Доработка сайта</a>
                                            <a href="?final_category=46">Исправление ошибок</a>
                                            <a href="?final_category=47">Защита и лечение сайта</a>
                                            <a href="?final_category=48">Настройка сайта</a>
                                            <a href="?final_category=49">Плагины и темы</a>
                                            <a href="?final_category=50">Ускорение сайта</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=13" class="medium_category">
                                            Игры
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=51">Разработка игр</a>
                                            <a href="?final_category=52">Готовые игры</a>
                                            <a href="?final_category=53">Игровой сервер</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=14" class="medium_category">
                                            Мобильные приложения
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=54">iOS</a>
                                            <a href="?final_category=55">Android</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=15" class="medium_category">
                                            Сервера и хостинг
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=56">Администрированиесервера</a>
                                            <a href="?final_category=57">Домены</a>
                                            <a href="?final_category=58">Хостинг</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=16" class="medium_category">
                                            Скрипты и боты
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=59">Парсеры</a>
                                            <a href="?final_category=60">Чат-боты</a>
                                            <a href="?final_category=61">Скрипты</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=17" class="medium_category">
                                            Создание сайта
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=62">Новый сайт</a>
                                            <a href="?final_category=63">Копия сайта</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=18" class="medium_category">
                                            Юзабилити, тесты и помощь
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=64">Юзабилити-аудит</a>
                                            <a href="?final_category=65">Тестирование на ошибки</a>
                                            <a href="?final_category=66">Компьютерная и IT
                                                помощь</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=3" class="main_category">
                                    <p>Тексты и переводы</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=19" class="medium_category">
                                            Набор текста
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=67">С аудио/видео</a>
                                            <a href="?final_category=68">С изображений</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=20" class="medium_category">
                                            Переводы
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=69">С аудио/видео</a>
                                            <a href="?final_category=70">С текста</a>
                                            <a href="?final_category=71">С изображения</a>
                                            <a href="?final_category=72">Переводы устные</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=21" class="medium_category">
                                            Продающие и бизнес-тексты
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=73">Продающие тексты</a>
                                            <a href="?final_category=74">Реклама и email</a>
                                            <a href="?final_category=75">Авто и мото</a>
                                            <a href="?final_category=76">Работа, карьера</a>
                                            <a href="?final_category=77">Юридическая</a>
                                            <a href="?final_category=78">Медицина и здоровье</a>
                                            <a href="?final_category=79">Интернет и технологии</a>
                                            <a href="?final_category=80">Кулинария</a>
                                            <a href="?final_category=81">Электроника, гаджеты</a>
                                            <a href="?final_category=82">Красота и мода</a>
                                            <a href="?final_category=83">Культура и искусство</a>
                                            <a href="?final_category=84">Недвижимость</a>
                                            <a href="?final_category=85">Образование и наука</a>
                                            <a href="?final_category=86">Семья, дети</a>
                                            <a href="?final_category=87">Отдых и развлечения</a>
                                            <a href="?final_category=88">Спорт</a>
                                            <a href="?final_category=89">Строительство</a>
                                            <a href="?final_category=90">Другое</a>
                                            <a href="?final_category=91">Туризм и путешествия</a>
                                            <a href="?final_category=92">Финансы, банки</a>
                                            <a href="?final_category=93">Хобби и увлечения</a>
                                            <a href="?final_category=94">Коммерческие предложения</a>
                                            <a href="?final_category=95">Скрипты продаж и выступлений</a>
                                            <a href="?final_category=96">Посты для соцсетей</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=22" class="medium_category">
                                            Тексты и наполнение сайта
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=97">Художественные тексты</a>
                                            <a href="?final_category=98">Сценарии</a>
                                            <a href="?final_category=99">Комментарии</a>
                                            <a href="?final_category=100">Корректура</a>
                                            <a href="?final_category=101">SEO-тексты</a>
                                            <a href="?final_category=102">Карточки товаров</a>
                                            <a href="?final_category=103">Статьи</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=4" class="main_category">
                                    <p>SEO и трафик</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=23" class="medium_category">
                                            SEO аудиты, консультации
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=104">SEO аудит</a>
                                            <a href="?final_category=105">Консультация</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=24" class="medium_category">
                                            Внутренняя оптимизация
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=106">Полная оптимизация</a>
                                            <a href="?final_category=107">Оптимизация страниц</a>
                                            <a href="?final_category=108">Robots и sitemap</a>
                                            <a href="?final_category=109">Теги</a>
                                            <a href="?final_category=110">Перелинковка</a>
                                            <a href="?final_category=111">Микроразметка</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=25" class="medium_category">
                                            Продвижение сайта в топ
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=112">Продвижение поисковой выдачи</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=26" class="medium_category">
                                            Семантическое ядро
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=113">С нуля</a>
                                            <a href="?final_category=114">По сайту</a>
                                            <a href="?final_category=115">Готовое ядро</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=27" class="medium_category">
                                            Ссылки
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=116">В профилях</a>
                                            <a href="?final_category=117">В соцсетях</a>
                                            <a href="?final_category=118">В комментариях</a>
                                            <a href="?final_category=119">Каталоги сайтов</a>
                                            <a href="?final_category=120">Форумные</a>
                                            <a href="?final_category=121">Статейные и крауд</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=28" class="medium_category">
                                            Статистика и аналитика
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=122">Метрики и счетчики</a>
                                            <a href="?final_category=123">Анализ сайтов, рынка</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=29" class="medium_category">
                                            Трафик
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=124">Посетители на сайт</a>
                                            <a href="?final_category=125">Поведенческие факторы</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=5" class="main_category">
                                    <p>Соцсети и реклама</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=30" class="medium_category">
                                            E-mail маркетинг и рассылки
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=126">Отправка рассылки</a>
                                            <a href="?final_category=127">Почтовые ящики</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=31" class="medium_category">
                                            Базы данных и клиентов
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=128">Сбор данных</a>
                                            <a href="?final_category=129">Готовые базы</a>
                                            <a href="?final_category=130">Проверка, чистка базы</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=32" class="medium_category">
                                            Контекстная реклама
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=131">Яндекс Директ</a>
                                            <a href="?final_category=132">Google Ads</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=33" class="medium_category">
                                            Маркетплейсы и доски объявлений
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=133">Справочники и каталоги</a>
                                            <a href="?final_category=134">Маркетплейсы</a>
                                            <a href="?final_category=135">Доски объявлений</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=34" class="medium_category">
                                            Реклама и PR
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=136">Размещение рекламы</a>
                                            <a href="?final_category=137">Контент-маркетинг</a>
                                            <a href="?final_category=138">Продвижение музыки</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=35" class="medium_category">
                                            Соцсети и SMM
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=139">ВКонтакте</a>
                                            <a href="?final_category=140">Facebook</a>
                                            <a href="?final_category=141">Instagram</a>
                                            <a href="?final_category=142">Youtube</a>
                                            <a href="?final_category=143">Одноклассники</a>
                                            <a href="?final_category=144">Telegram</a>
                                            <a href="?final_category=145">Twitter</a>
                                            <a href="?final_category=146">Другие</a>
                                            <a href="?final_category=147">Дзен</a>
                                            <a href="?final_category=148">TikTok</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=6" class="main_category">
                                    <p>Аудио, видео, съемка</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=36" class="medium_category">
                                            Аудиозапись и озвучка
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=149">Озвучка и дикторы</a>
                                            <a href="?final_category=150">Аудиоролик</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=37" class="medium_category">
                                            Видеоролики
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=151">Дудл-видео</a>
                                            <a href="?final_category=152">Анимационный ролик</a>
                                            <a href="?final_category=153">Проморолик</a>
                                            <a href="?final_category=154">3D анимация</a>
                                            <a href="?final_category=155">Скринкасты и видеообзоры</a>
                                            <a href="?final_category=156">Кинетическая типографика</a>
                                            <a href="?final_category=157">Слайд-шоу</a>
                                            <a href="?final_category=158">Видео с ведущим</a>
                                            <a href="?final_category=159">Видеопрезентация</a>
                                            <a href="?final_category=160">Ролики для соцсетей</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=38" class="medium_category">
                                            Видеосъемка и монтаж
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=161">Видеосъемка</a>
                                            <a href="?final_category=162">Монтаж и обработка видео</a>
                                            <a href="?final_category=163">Фотосъемка</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=39" class="medium_category">
                                            Интро и анимация логотипа
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=164">Анимация логотипа</a>
                                            <a href="?final_category=165">Интро и заставки</a>
                                            <a href="?final_category=166">GIF-анимация</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=40" class="medium_category">
                                            Музыка и песни
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=167">Написание музыки</a>
                                            <a href="?final_category=168">Запись вокала</a>
                                            <a href="?final_category=169">Аранжировка</a>
                                            <a href="?final_category=170">Тексты песен</a>
                                            <a href="?final_category=171">Песня (музыка + текст + вокал)</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=41" class="medium_category">
                                            Редактирование аудио
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=172">Обработка звука</a>
                                            <a href="?final_category=173">Выделение звука из видео</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=7" class="main_category">
                                    <p>Бизнес и жизнь</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=42" class="medium_category">
                                            Бухгалтерия и налоги
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=174">Для физлиц</a>
                                            <a href="?final_category=175">Для юрлиц и ИП</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=43" class="medium_category">
                                            Обзвоны и продажи
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=176">Продажи по телефону</a>
                                            <a href="?final_category=177">Телефонный опрос</a>
                                            <a href="?final_category=178">Прием звонков</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=44" class="medium_category">
                                            Обучение и консалтинг
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=179">Онлайн курсы</a>
                                            <a href="?final_category=180">Консалтинг</a>
                                            <a href="?final_category=181">Оформление по ГОСТу</a>
                                            <a href="?final_category=182">Репетиторы</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=45" class="medium_category">
                                            Персональный помощник
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=183">Поиск информации</a>
                                            <a href="?final_category=184">Работа в MS Office</a>
                                            <a href="?final_category=185">Анализ информации</a>
                                            <a href="?final_category=186">Любая интеллектуальная работа</a>
                                            <a href="?final_category=187">Любая рутинная работа</a>
                                            <a href="?final_category=188">Менеджмент проектов</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=46" class="medium_category">
                                            Подбор персонала
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=189">Подбор резюме</a>
                                            <a href="?final_category=190">Найм специалиста</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=47" class="medium_category">
                                            Продажа сайтов
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=191">Сайт без домена</a>
                                            <a href="?final_category=192">Сайт с доменом</a>
                                            <a href="?final_category=193">Соцсети, домен, приложение</a>
                                            <a href="?final_category=194">Аудит, оценка, помощь</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=48" class="medium_category">
                                            Стройка и ремонт
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=195">Строительство</a>
                                            <a href="?final_category=196">Проектирование объекта</a>
                                            <a href="?final_category=197">Машиностроение</a>
                                            <a href="?final_category=198">Предметы и аксессуары</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=49" class="medium_category">
                                            Юридическая помощь
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=199">Договор и доверенность</a>
                                            <a href="?final_category=200">Судебный документ</a>
                                            <a href="?final_category=201">Юридическая консультация</a>
                                            <a href="?final_category=202">Ведение ООО и ИП</a>
                                            <a href="?final_category=203">Интернет-право</a>
                                            <a href="?final_category=204">Визы</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><a href="tasks.php?filter=8" class="main_category">
                                    <p>Учеба и репетиторство</p>
                                </a>
                                <div class="link_sub">
                                    <div><a href="?medium_category=50" class="medium_category">
                                            репетитор на дом
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=205">Дом ученика</a>
                                            <a href="?final_category=206">Дом репетитора</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=51" class="medium_category">
                                            репетитор онлайн
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=207">видеозвонок</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=52" class="medium_category">
                                            школьный репетитор
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=208">Найм</a>
                                            <a href="?final_category=209">Временно</a>
                                        </div>
                                    </div>
                                    <div><a href="?medium_category=53" class="medium_category">
                                            репетитор в университете
                                        </a>
                                        <div class="final_filter_sub">
                                            <a href="?final_category=210">Найм</a>
                                            <a href="?final_category=211">Временно</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $filter_reset ?>
                        <a href='tasks.php' class='filter_none'>Сбросить фильтор</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            echo "<p class='type_option type'>$type</p>";
        }
        ?>
        <div class="orders">
            <?php
            if (isset($_SESSION["nik"])):
                if ($user_resolt["role"] == "seller"):
                    $max_date_resolt = null;

                    //max_date_push
                    $max_date_sql = "SELECT `application_date` FROM `user_registoring` WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $max_date_sql);
                    mysqli_stmt_bind_param($stmt, "s", $my_nik);
                    mysqli_stmt_execute($stmt);
                    $max_date_result = mysqli_stmt_get_result($stmt);

                    if ($max_date_result && mysqli_num_rows($max_date_result) > 0) {
                        $max_date_resolt = mysqli_fetch_assoc($max_date_result)['application_date'];
                    }

                    // application_count
                    $application_limit = false;
                    $application_count_sql = "SELECT * FROM `orders_responses` WHERE `nik` = ? AND `max_date` = ?";
                    $stmt = mysqli_prepare($bd_connect, $application_count_sql);
                    mysqli_stmt_bind_param($stmt, "ss", $my_nik, $max_date_resolt);
                    mysqli_stmt_execute($stmt);
                    $application_count_result = mysqli_stmt_get_result($stmt);

                    $occurrences_count = 0;

                    //moment_date
                    $date_result = date("Y.m");

                    if ($application_count_result) {
                        while ($application_count = mysqli_fetch_assoc($application_count_result)) {
                            $occurrences_count += substr_count($application_count['response_date'], $date_result);
                            if ($occurrences_count >= 30) {
                                $application_limit = true;
                                break;
                            }
                        }
                    }

                    setlocale(LC_TIME, 'ru_RU.utf8');

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

                    $currentDate = time();
                    $futureDate = strtotime('+30 days', $currentDate);

                    $formattedDate = strftime('%e %B', $futureDate);

                    list($day, $month) = sscanf($formattedDate, '%d %s');

                    $rusMonth = $monthsTranslation[$month];
                    $updatedFormattedDate = "{$day} {$rusMonth}";


                    if ($occurrences_count == 0) {
                        //date_push
                        $new_application_date = "UPDATE `user_registoring` SET `application_date` = ? WHERE `nik` = ?";
                        $new_application_stmt = mysqli_prepare($bd_connect, $new_application_date);
                        mysqli_stmt_bind_param($new_application_stmt, "ss", $updatedFormattedDate, $my_nik);
                        mysqli_stmt_execute($new_application_stmt);
                    }
                    ?>
                    <div class="user_order_information">
                        <div class="application_level">
                            <div class="application_infromation">
                                <div>
                                    <p>Заявки</p>
                                </div>
                                <div class="application_left_information">
                                    <p>Осталось
                                    <p class="number_application">
                                        <?= 30 - $occurrences_count ?>
                                    </p> из <p class="number_application">30</p>
                                    </p>
                                </div>
                            </div>
                            <div class="application_line">
                                <div class="in_line"></div>
                            </div>
                        </div>
                        <div class="return_date">
                            <p>Дата пополнения</p>
                            <?php
                            $new_date_resolt = null;
                            $new_date_sql = "SELECT `application_date` FROM `user_registoring` WHERE `nik` = ?";
                            $stmt = mysqli_prepare($bd_connect, $new_date_sql);
                            mysqli_stmt_bind_param($stmt, "s", $my_nik);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $new_date_resolt = mysqli_fetch_assoc($result)['application_date'];
                            }
                            if (!empty($new_date_resolt)) {
                                echo "<b>$new_date_resolt</b>";
                            } else {
                                echo "<b>(в ожидании)</b>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
            ?>
            <div class="overlay">
                <div class="loader"></div>
            </div>
            <div class="order_wrappers content">
                <?php
                $ordersPerPage = 18;
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $startFrom = ($page - 1) * $ordersPerPage;
                $orders = array();
                $sql = null;

                $pin_exceptions = 1;
                $table_category = null;
                $order_num = 0;
                if ($filter_number == null) {
                    $sql = "SELECT * FROM `orders` ORDER BY CASE WHEN `pin` = ? THEN 0 ELSE 1 END, id DESC LIMIT $startFrom, $ordersPerPage";
                } else {
                    $table_category = "main_category";
                }

                if (isset($_GET['medium_category']) && is_numeric($_GET['medium_category'])) {
                    $table_category = "medium_category";
                    echo "<p class='medium_number category_number'>$medium_category</p>";
                } elseif (isset($_GET['final_category']) && is_numeric($_GET['final_category'])) {
                    $table_category = "final_category";
                    echo "<p class='final_number category_number'>$final_category</p>";
                }

                if (isset($_GET['filter']) || isset($_GET['medium_category']) || isset($_GET['final_category'])) {
                    $sql = "SELECT * FROM `orders` WHERE `$table_category` = ? AND `pin` != ? ORDER BY id DESC LIMIT $startFrom, $ordersPerPage";
                    //page_sql
                    $page_sql = "SELECT `final_category` FROM `orders` WHERE `$table_category` = ? AND `pin` != ?";
                    $page_stmt = mysqli_prepare($bd_connect, $page_sql);
                    mysqli_stmt_bind_param($page_stmt, "ii", $filter_number, $pin_exceptions);
                    mysqli_stmt_execute($page_stmt);
                    $page_resolt = mysqli_stmt_get_result($page_stmt);
                    while ($page_row = mysqli_fetch_assoc($page_resolt)) {
                        $order_num++;
                    }
                }

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

                $category_stmt = mysqli_prepare($bd_connect, $sql);
                if ($filter_number == null) {
                    mysqli_stmt_bind_param($category_stmt, "i", $pin_exceptions);
                } else {
                    mysqli_stmt_bind_param($category_stmt, "ii", $filter_number, $pin_exceptions);
                }
                mysqli_stmt_execute($category_stmt);
                $category_resolt = mysqli_stmt_get_result($category_stmt);

                $all_order_sql = "SELECT * FROM `orders`";
                if (!isset($_GET["filter"]) && !isset($_GET["medium_category"]) && !isset($_GET["final_category"])) {
                    $all_order_query = mysqli_query($bd_connect, $all_order_sql);
                    while ($order_row = mysqli_fetch_assoc($all_order_query)) {
                        $order_num++;
                    }
                }
                $totalPages = ceil($order_num / $ordersPerPage);

                while ($row = mysqli_fetch_assoc($category_resolt)) {
                    $nik = $row['nik'];
                    $order_num++;
                    $row_resolt = null;
                    $row_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
                    $row_stmt = mysqli_prepare($bd_connect, $row_sql);
                    mysqli_stmt_bind_param($row_stmt, "s", $nik);
                    mysqli_stmt_execute($row_stmt);
                    $result = mysqli_stmt_get_result($row_stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row_resolt = mysqli_fetch_assoc($result);
                    }
                    $user_id = $row_resolt['id'];
                    $user_icon = $row_resolt['icon_path'];
                    $category_arr = array("Без категорий", "Дизайн", "Разработка и IT", "Тексты и переводы", "SEO и трафик", "Соцсети и реклама", "Аудио, видео, съемка", "Бизнес и жизнь", "Учеба и репетиторство");

                    $orders[] = [
                        'row' => $row,
                        'user_id' => $user_id,
                        'user_icon' => $user_icon,
                    ];
                }
                $order_temp = 0;
                foreach ($orders as $order):
                    $order_temp++;
                    $row = $order['row'];
                    $my_order = null;
                    $user_id = $order['user_id'];
                    $user_icon = $order['user_icon'];
                    $category_arr = array("Без категорий", "Дизайн", "Разработка и IT", "Тексты и переводы", "SEO и трафик", "Соцсети и реклама", "Аудио, видео, съемка", "Бизнес и жизнь", "Учеба и репетиторство");
                    if (isset($_SESSION["nik"])) {
                        if ($_SESSION["id"] == $user_id) {
                            $my_order = "my_order";
                        }
                    }
                    //block_user_system
                    $block_nik = null;
                    $final_assoc = null;
                    if (!isset($_SESSION["nik"])) {
                        $my_nik = "Guest";
                    }
                    $unblock_resolt = null;
                    $unblock_sql = "SELECT * FROM `messenger_users` WHERE `main_block` = ?";
                    $unblock_stmt = mysqli_prepare($bd_connect, $unblock_sql);
                    mysqli_stmt_bind_param($unblock_stmt, "s", $my_nik);
                    mysqli_stmt_execute($unblock_stmt);
                    $result = mysqli_stmt_get_result($unblock_stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $unblock_resolt = mysqli_fetch_assoc($result);
                    }
                    if (!empty($unblock_resolt['main_block'])) {
                        if ($unblock_resolt['nik_one'] == $unblock_resolt['main_block']) {
                            $final_assoc = $unblock_resolt['nik_two'];
                        } elseif ($unblock_resolt['nik_two'] == $unblock_resolt['main_block']) {
                            $final_assoc = $unblock_resolt['nik_one'];
                        }
                    }
                    if ($final_assoc !== $row['nik']):
                        ?>
                        <div class="order <?= $my_order ?>">
                            <?php
                            if (isset($_GET['type'])) {
                                $order_final_type = $row['type'];
                                echo "<p class='type'>$order_final_type</p>";
                            }
                            if ($row['date'] == $date):
                                ?>
                                <div class="cover new_cover">
                                    <p>НОВЫЙ</p>
                                </div>
                                <?php
                            endif;
                            if ($row['date'] != $date && $row['type'] == 1):
                                ?>
                                <div class="cover vacancy_cover">
                                    <p>Вакансия</p>
                                </div>
                                <?php
                            endif;
                            if ($row['pin'] == 1):
                                ?>
                                <div class="pin_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                    </svg>
                                </div>
                                <?php
                            endif;
                            ?>
                            <div class="order_part">
                                <a href="order_page.php?order_id=<?= $row['id'] ?>" class="order_page_link">
                                    <h3>
                                        <?= $row["order_name"] ?>
                                    </h3>
                                </a>
                                <p class="user_order_tz task_tag">
                                    <?= $row['order_information'] ?>
                                </p>
                                <div class="user_information task_tag">
                                    <img src="../bd_send/user/user_icons/<?= $user_icon ?>" class="user_image"
                                        draggable="false">
                                    <a href="user_page.php?user_id=<?= $user_id ?>" target="_blank">
                                        <p>
                                            <?= $row['nik'] ?>
                                        </p>
                                    </a>
                                </div>
                                <div class="payment task_tag">
                                    <p>Оплата:</p>
                                    <svg class="payed_false" xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 384 512">
                                        <style>
                                            svg {
                                                fill: #d08e0b
                                            }
                                        </style>
                                        <path
                                            d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s-32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s-12.5 32.8 0-45.3L237.3 256 342.6 150.6z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="category task_tag">
                                    <p>Категория: <b>
                                            <?= $category_arr[$row['main_category']] ?>
                                        </b></p>
                                </div>
                            </div>
                            <div class="price_part">
                                <?php
                                if ($row['order_price'] != 0):
                                    ?>
                                    <p class="price">
                                        <?= $row['order_price'] ?>₽
                                    </p>
                                    <?php
                                endif;
                                ?>
                            </div>
                            <div class="date">
                                <p>
                                    <?= $row['date'] ?>
                                </p>
                            </div>
                            <div class="application_number">
                                <?php
                                $application_number = 0;
                                $order_id = $row["id"];
                                $application_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ?";
                                $application_stmt = mysqli_prepare($bd_connect, $application_sql);
                                mysqli_stmt_bind_param($application_stmt, "s", $order_id);
                                mysqli_stmt_execute($application_stmt);
                                $application_query = mysqli_stmt_get_result($application_stmt);

                                while ($application_resolt = mysqli_fetch_assoc($application_query)) {
                                    $application_number++;
                                }
                                if ($application_number !== 0):
                                    //application_check
                                    $application_check_count = false;
                                    $application_check_sql = "SELECT * FROM `orders_responses` WHERE `order_id` = ? AND `nik` = ?";
                                    $application_stmt = mysqli_prepare($bd_connect, $application_check_sql);
                                    mysqli_stmt_bind_param($application_stmt, "ss", $order_id, $my_nik);
                                    mysqli_stmt_execute($application_stmt);
                                    $application_check_query = mysqli_stmt_get_result($application_stmt);

                                    while ($application_check_resolt = mysqli_fetch_assoc($application_check_query)) {
                                        $application_check_count = true;
                                    }
                                    if ($application_check_count == false) {
                                        if ($row['progress'] == 1) {
                                            echo '<p>Заявок: ' . $application_number . '</p>';
                                        } else {
                                            echo "<p class='ready_choice'>1 исполнитель</p>";
                                        }
                                    }
                                    if ($application_check_count == true):
                                        ?>
                                        <div class="applicated_wrapper">
                                            <div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                                    <path
                                                        d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                </svg></div>
                                            <div>
                                                <p>Подано</p>
                                            </div>
                                        </div>
                                        <?php
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                    endif;
                endforeach;
                if ($order_temp == 0) {
                    echo "<p class='no_orders'>Нет заказов</p>";
                }
                ?>
                <div class="medium_category_number">
                    <?= $medium_filter_number ?>
                </div>
                <div class="pagination" id="pagination">
                    <?php
                    if ($totalPages >= 2):
                        $startPage = max($page - 2, 1);
                        $endPage = min($page + 2, $totalPages);

                        if ($startPage > 1) {
                            echo "<div class='page_link_wrapper'><a class='page-link' href='{$pagination_href}page=1'>1</a></div>";

                            if ($startPage > 2) {
                                echo "<b>...</b>";
                            }
                        }

                        for ($i = $startPage; $i <= $endPage; $i++) {
                            $isActive = $i === $page ? 'active' : '';
                            echo "<div class='page_link_wrapper'><a class='page-link {$isActive}' href='{$pagination_href}page={$i}'>{$i}</a></div>";
                        }

                        if ($endPage < $totalPages - 1) {
                            echo "<b>...</b>";
                        }

                        if ($endPage < $totalPages) {
                            echo "<div class='page_link_wrapper'><a class='page-link' href='{$pagination_href}page={$totalPages}'>{$totalPages}</a></div>";
                        }
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/order/user_check.js"></script>
<script src="../page_js/order/tz_length.js"></script>
<script src="../page_js/order/price_check.js"></script>
<script src="../page_js/order/order_type.js"></script>
<?php
if (isset($_GET['filter']) || isset($_GET['medium_category']) || isset($_GET['final_category'])) {
    echo '<script src="../page_js/order/task_category.js"></script>';
}
if (isset($_SESSION["nik"])) {
    if ($user_resolt["role"] == "seller") {
        echo '<script src="../page_js/order/application_percent.js"></script>';
    }
}
?>
</body>

</html>