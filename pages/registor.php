<?php
session_start();
if (isset($_SESSION["nik"])) {
    header("Location: home.php");
    exit;
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/registor.css'>";
echo "<title>Создание Аккаунта - Bestlancer</title>";
include "../layouts/header_line.php";
?>
<div class="registor_container container">
    <div class="resolt_input">
        <form action="">
            <div>
                <input type="text" name="role" readonly>
            </div>
            <input type="text" readonly>
            <input type="text" readonly>
            <input type="text" readonly>
            <input type="text" readonly>
            <input type="text" readonly>
            <input type="text" readonly>
            <input type="text" readonly>
            <input type="text" readonly>
        </form>
    </div>
    <?php
    //echo "<p class='registor_part_number'>$registor_part</p>";
    ?>
        <div class="registor_question question">
            <h2>Присоединяйтесь в качестве клиента <br> или фрилансера</h2>
            <div class="role_options">
                <div class="role_option" id="0">
                    <div class="circle">
                        <div class="in_circle"></div>
                    </div>
                    <div>
                        <img src="../res/money.png" alt="" draggable="false">
                    </div>
                    <p>Я клиент, набираю сотрудников для проекта</p>
                </div>
                <div class="role_option" id="1">
                    <div class="circle">
                        <div class="in_circle"></div>
                    </div>
                    <div>
                        <img src="../res/money_take.png" alt="" draggable="false">
                    </div>
                    <p>Я фрилансер, ищу работу</p>
                </div>
            </div>
            <div class="button">
                <button class="none_click">Продолжить</button>
            </div>
        </div>
        <div class="main_registor_question thirst_part question">
            <h2>Регестрация аккаунта</h2>
            <div class="main_registration">

                <div class="line_block">
                    <div>
                        <h3>Имя</h3>
                        <u class="warning"></u>
                        <input type="text" name="user_name" placeholder="Имя" class="right_in" id="input_name">
                    </div>
                    <div>
                        <h3>Фамилия</h3>
                        <u class="warning"></u>
                        <input type="text" name="user_family" placeholder="Фамилия" class="right_in" id="input_surname">
                    </div>
                </div>
                <div class="input_part">
                    <h3>Email</h3>
                    <u class="warning"></u>
                    <input type="text" name="user_email" id="email" placeholder="Рабочий email адрес" class="right_in">
                </div>
                <div class="input_part">
                    <h3>Пароль</h3>
                    <u class="warning"></u>
                    <input type="password" name="user_password" placeholder="Пароль" class="right_in">
                </div>
                <div class="input_part country">
                    <h3>Страна</h3>
                    <u class="warning"></u>
                    <input type="text" name="user_country" readonly class="right_in">
                    <div class="menu">
                        <div>
                            <p>Абхазия</p>
                        </div>
                        <div>
                            <p>Австралия</p>
                        </div>
                        <div>
                            <p>Австрия</p>
                        </div>
                        <div>
                            <p>Азербайджан</p>
                        </div>
                        <div>
                            <p>Албания</p>
                        </div>
                        <div>
                            <p>Алжир</p>
                        </div>
                        <div>
                            <p>Ам. Виргинские острова</p>
                        </div>
                        <div>
                            <p>Американское Самоа</p>
                        </div>
                        <div>
                            <p>Ангола</p>
                        </div>
                        <div>
                            <p>Андорра</p>
                        </div>
                        <div>
                            <p>Антигуа и Барбуда</p>
                        </div>
                        <div>
                            <p>Аргентина</p>
                        </div>
                        <div>
                            <p>Армения</p>
                        </div>
                        <div>
                            <p>Аруба</p>
                        </div>
                        <div>
                            <p>Афганистан</p>
                        </div>
                        <div>
                            <p>Багамы</p>
                        </div>
                        <div>
                            <p>Бангладеш</p>
                        </div>
                        <div>
                            <p>Барбадос</p>
                        </div>
                        <div>
                            <p>Бахрейн</p>
                        </div>
                        <div>
                            <p>Белиз</p>
                        </div>
                        <div>
                            <p>Белоруссия</p>
                        </div>
                        <div>
                            <p>Бельгия</p>
                        </div>
                        <div>
                            <p>Бенин</p>
                        </div>
                        <div>
                            <p>Бермудские Острова</p>
                        </div>
                        <div>
                            <p>Болгария</p>
                        </div>
                        <div>
                            <p>Боливия</p>
                        </div>
                        <div>
                            <p>Бонэйр</p>
                        </div>
                        <div>
                            <p>Босния и Герцеговина</p>
                        </div>
                        <div>
                            <p>Ботсвана</p>
                        </div>
                        <div>
                            <p>Бразилия</p>
                        </div>
                        <div>
                            <p>Бр. Виргинские острова</p>
                        </div>
                        <div>
                            <p>Бруней</p>
                        </div>
                        <div>
                            <p>Буркина-Фасо</p>
                        </div>
                        <div>
                            <p>Бурунди</p>
                        </div>
                        <div>
                            <p>Бутан</p>
                        </div>
                        <div>
                            <p>Вануату</p>
                        </div>
                        <div>
                            <p>Ватикан</p>
                        </div>
                        <div>
                            <p>Великобритания</p>
                        </div>
                        <div>
                            <p>Венгрия</p>
                        </div>
                        <div>
                            <p>Венесуэла</p>
                        </div>
                        <div>
                            <p>Восточный Тимор</p>
                        </div>
                        <div>
                            <p>Вьетнам</p>
                        </div>
                        <div>
                            <p>Габон</p>
                        </div>
                        <div>
                            <p>Гаити</p>
                        </div>
                        <div>
                            <p>Гайана</p>
                        </div>
                        <div>
                            <p>Гамбия</p>
                        </div>
                        <div>
                            <p>Гана</p>
                        </div>
                        <div>
                            <p>Гватемала</p>
                        </div>
                        <div>
                            <p>Гвинея</p>
                        </div>
                        <div>
                            <p>Гвинея-Бисау</p>
                        </div>
                        <div>
                            <p>Германия</p>
                        </div>
                        <div>
                            <p>Гондурас</p>
                        </div>
                        <div>
                            <p>Гонконг</p>
                        </div>
                        <div>
                            <p>Гренада</p>
                        </div>
                        <div>
                            <p>Греция</p>
                        </div>
                        <div>
                            <p>Грузия</p>
                        </div>
                        <div>
                            <p>Дания</p>
                        </div>
                        <div>
                            <p>Д.Р. Конго</p>
                        </div>
                        <div>
                            <p>Джерси</p>
                        </div>
                        <div>
                            <p>Джибути</p>
                        </div>
                        <div>
                            <p>Доминика</p>
                        </div>
                        <div>
                            <p>Доминикана</p>
                        </div>
                        <div>
                            <p>Египет</p>
                        </div>
                        <div>
                            <p>Замбия</p>
                        </div>
                        <div>
                            <p>Зимбабве</p>
                        </div>
                        <div>
                            <p>Израиль</p>
                        </div>
                        <div>
                            <p>Индия</p>
                        </div>
                        <div>
                            <p>Индонезия</p>
                        </div>
                        <div>
                            <p>Иордания</p>
                        </div>
                        <div>
                            <p>Ирак</p>
                        </div>
                        <div>
                            <p>Иран</p>
                        </div>
                        <div>
                            <p>Ирландия</p>
                        </div>
                        <div>
                            <p>Исландия</p>
                        </div>
                        <div>
                            <p>Испания</p>
                        </div>
                        <div>
                            <p>Италия</p>
                        </div>
                        <div>
                            <p>Йемен</p>
                        </div>
                        <div>
                            <p>Кабо-Верде</p>
                        </div>
                        <div>
                            <p>Казахстан</p>
                        </div>
                        <div>
                            <p>Камбоджа</p>
                        </div>
                        <div>
                            <p>Камерун</p>
                        </div>
                        <div>
                            <p>Канада</p>
                        </div>
                        <div>
                            <p>Катар</p>
                        </div>
                        <div>
                            <p>Кения</p>
                        </div>
                        <div>
                            <p>Кипр</p>
                        </div>
                        <div>
                            <p>Киргизия</p>
                        </div>
                        <div>
                            <p>Кирибати</p>
                        </div>
                        <div>
                            <p>Китай</p>
                        </div>
                        <div>
                            <p>Колумбия</p>
                        </div>
                        <div>
                            <p>Кокосовые острова</p>
                        </div>
                        <div>
                            <p>Коморские Острова</p>
                        </div>
                        <div>
                            <p>Конго</p>
                        </div>
                        <div>
                            <p>КНДР</p>
                        </div>
                        <div>
                            <p>Корея</p>
                        </div>
                        <div>
                            <p>Коста-Рика</p>
                        </div>
                        <div>
                            <p>Кот-д'Ивуар</p>
                        </div>
                        <div>
                            <p>Куба</p>
                        </div>
                        <div>
                            <p>Кувейт</p>
                        </div>
                        <div>
                            <p>Кюрасао</p>
                        </div>
                        <div>
                            <p>Лаос</p>
                        </div>
                        <div>
                            <p>Латвия</p>
                        </div>
                        <div>
                            <p>Лесото</p>
                        </div>
                        <div>
                            <p>Либерия</p>
                        </div>
                        <div>
                            <p>Ливан</p>
                        </div>
                        <div>
                            <p>Ливия</p>
                        </div>
                        <div>
                            <p>Литва</p>
                        </div>
                        <div>
                            <p>Лихтенштейн</p>
                        </div>
                        <div>
                            <p>Люксембург</p>
                        </div>
                        <div>
                            <p>Маврикий</p>
                        </div>
                        <div>
                            <p>Мавритания</p>
                        </div>
                        <div>
                            <p>Мадагаскар</p>
                        </div>
                        <div>
                            <p>Македония</p>
                        </div>
                        <div>
                            <p>Малави</p>
                        </div>
                        <div>
                            <p>Малайзия</p>
                        </div>
                        <div>
                            <p>Мали</p>
                        </div>
                        <div>
                            <p>Мальта</p>
                        </div>
                        <div>
                            <p>Мальдивы</p>
                        </div>
                        <div>
                            <p>Марокко</p>
                        </div>
                        <div>
                            <p>Маршалловы Острова</p>
                        </div>
                        <div>
                            <p>Мексика</p>
                        </div>
                        <div>
                            <p>Мозамбик</p>
                        </div>
                        <div>
                            <p>Молдавия (Молдова)</p>
                        </div>
                        <div>
                            <p>Монако</p>
                        </div>
                        <div>
                            <p>Монголия</p>
                        </div>
                        <div>
                            <p>Мьянма</p>
                        </div>
                        <div>
                            <p>Намибия</p>
                        </div>
                        <div>
                            <p>Науру</p>
                        </div>
                        <div>
                            <p>Непал</p>
                        </div>
                        <div>
                            <p>Нигер</p>
                        </div>
                        <div>
                            <p>Нигерия</p>
                        </div>
                        <div>
                            <p>Нидерланды</p>
                        </div>
                        <div>
                            <p>Никарагуа</p>
                        </div>
                        <div>
                            <p>Новая Зеландия</p>
                        </div>
                        <div>
                            <p>Норвегия</p>
                        </div>
                        <div>
                            <p>ОАЭ</p>
                        </div>
                        <div>
                            <p>Оман</p>
                        </div>
                        <div>
                            <p>Острова Кука</p>
                        </div>
                        <div>
                            <p>Пакистан</p>
                        </div>
                        <div>
                            <p>Палау</p>
                        </div>
                        <div>
                            <p>Панама</p>
                        </div>
                        <div>
                            <p>Папуа-Новая Гвинея</p>
                        </div>
                        <div>
                            <p>Парагвай</p>
                        </div>
                        <div>
                            <p>Перу</p>
                        </div>
                        <div>
                            <p>Пуэрто-Рико</p>
                        </div>
                        <div>
                            <p>Польша</p>
                        </div>
                        <div>
                            <p>Португалия</p>
                        </div>
                        <div>
                            <p>Россия</p>
                        </div>
                        <div>
                            <p>Руанда</p>
                        </div>
                        <div>
                            <p>Румыния</p>
                        </div>
                        <div>
                            <p>Саба</p>
                        </div>
                        <div>
                            <p>Сальвадор</p>
                        </div>
                        <div>
                            <p>Самоа</p>
                        </div>
                        <div>
                            <p>Сан-Марино</p>
                        </div>
                        <div>
                            <p>Сан-Томе и Принсипи</p>
                        </div>
                        <div>
                            <p>Саудовская Аравия</p>
                        </div>
                        <div>
                            <p>Свазиленд</p>
                        </div>
                        <div>
                            <p>Сейшелы</p>
                        </div>
                        <div>
                            <p>Сенегал</p>
                        </div>
                        <div>
                            <p>Сент-Винсент и Гренадины</p>
                        </div>
                        <div>
                            <p>Сент-Китс и Невис</p>
                        </div>
                        <div>
                            <p>Сент-Люсия</p>
                        </div>
                        <div>
                            <p>Сен-Мартен</p>
                        </div>
                        <div>
                            <p>Сербия</p>
                        </div>
                        <div>
                            <p>Сингапур</p>
                        </div>
                        <div>
                            <p>Синт-Эстатиус</p>
                        </div>
                        <div>
                            <p>Сирия</p>
                        </div>
                        <div>
                            <p>Словакия</p>
                        </div>
                        <div>
                            <p>Словения</p>
                        </div>
                        <div>
                            <p>США</p>
                        </div>
                        <div>
                            <p>Соломоновы Острова</p>
                        </div>
                        <div>
                            <p>Сомали</p>
                        </div>
                        <div>
                            <p>Судан</p>
                        </div>
                        <div>
                            <p>Суринам</p>
                        </div>
                        <div>
                            <p>Сьерра-Леоне</p>
                        </div>
                        <div>
                            <p>Таджикистан</p>
                        </div>
                        <div>
                            <p>Таиланд</p>
                        </div>
                        <div>
                            <p>Танзания</p>
                        </div>
                        <div>
                            <p>Того</p>
                        </div>
                        <div>
                            <p>Токелау</p>
                        </div>
                        <div>
                            <p>Тонга</p>
                        </div>
                        <div>
                            <p>Тринидад и Тобаго</p>
                        </div>
                        <div>
                            <p>Тувалу</p>
                        </div>
                        <div>
                            <p>Тунис</p>
                        </div>
                        <div>
                            <p>Туркменистан</p>
                        </div>
                        <div>
                            <p>Турция</p>
                        </div>
                        <div>
                            <p>Уганда</p>
                        </div>
                        <div>
                            <p>Узбекистан</p>
                        </div>
                        <div>
                            <p>Украина</p>
                        </div>
                        <div>
                            <p>Уоллис и Футуна</p>
                        </div>
                        <div>
                            <p>Уругвай</p>
                        </div>
                        <div>
                            <p>Фарерские острова</p>
                        </div>
                        <div>
                            <p>Фед. Штаты Микронезии</p>
                        </div>
                        <div>
                            <p>Фиджи</p>
                        </div>
                        <div>
                            <p>Филиппины</p>
                        </div>
                        <div>
                            <p>Финляндия</p>
                        </div>
                        <div>
                            <p>Фолклендские острова</p>
                        </div>
                        <div>
                            <p>Франция</p>
                        </div>
                        <div>
                            <p>Французская Полинезия</p>
                        </div>
                        <div>
                            <p>Хорватия</p>
                        </div>
                        <div>
                            <p>ЦАР</p>
                        </div>
                        <div>
                            <p>Чад</p>
                        </div>
                        <div>
                            <p>Черногория</p>
                        </div>
                        <div>
                            <p>Чехия</p>
                        </div>
                        <div>
                            <p>Чили</p>
                        </div>
                        <div>
                            <p>Швейцария</p>
                        </div>
                        <div>
                            <p>Швеция</p>
                        </div>
                        <div>
                            <p>Шри-Ланка</p>
                        </div>
                        <div>
                            <p>Эквадор</p>
                        </div>
                        <div>
                            <p>Экваториальная Гвинея</p>
                        </div>
                        <div>
                            <p>Эритрея</p>
                        </div>
                        <div>
                            <p>Эстония</p>
                        </div>
                        <div>
                            <p>Эфиопия</p>
                        </div>
                        <div>
                            <p>ЮАР</p>
                        </div>
                        <div>
                            <p>Южный Судан</p>
                        </div>
                        <div>
                            <p>Ямайка</p>
                        </div>
                        <div>
                            <p>Япония</p>
                        </div>
                    </div>
                </div>
                <div class="checkbox_part">
                    <div class="checkbox_choice">
                        <div><input type="checkbox"></div>
                        <div>
                            <p>Присылайте мне электронные письма с советами о том, <br> как найти талант,
                                соответствующий моим потребностям.</p>
                        </div>
                    </div>
                    <div class="checkbox_choice">
                        <div><input type="checkbox"></div>
                        <div>
                            <p>Да, я понимаю и согласен с Условиями обслуживания Bestlancer, <br> включая
                                Пользовательское соглашение и Политику конфиденциальности.</p>
                        </div>
                    </div>
                </div>
                <div class="post_button">
                    <button>Продолжить создание аккаунта</button>
                </div>

            </div>
        </div>
        <div class="main_registor_question second_part question">
            <h2>Продолжение регистрации</h2>
            <div class="main_registration">
                <form action="">
                    <div class="line_block">
                        <div class="input_part">
                            <h3>Возраст</h3>
                            <u class="warning"></u>
                            <input type="number" name="user_age" placeholder="Впишите возраст" class="right_in"
                                id="input_name">
                        </div>
                        <div class="input_part">
                            <h3>Начало работы</h3>
                            <u class="warning"></u>
                            <input type="time" name="user_time" class="right_in" id="input_surname">
                        </div>
                    </div>
                    <div class="input_part">
                        <h3>Расскажите о себе</h3>
                        <u class="warning"></u>
                        <textarea name="" placeholder="Расскажите о себе и о вашем опыте" class="right_in" id="" cols="30"
                            rows="10"></textarea>
                    </div>
                    <div class="input_part">
                        <h3>Начальная ставка</h3>
                        <u class="warning"></u>
                        <div class="price_input">
                            <input type="number" name="user_price" placeholder="Впишите цену" class="right_in">
                            <div><span>$</span></div>
                        </div>
                    </div>
                    <div class="post_button">
                        <button>Создать аккаунт</button>
                    </div>
                </form>
            </div>
        </div>
</div>
<script src="../page_js/registor/registor_script.js"></script>
<script src="../page_js/registor/value_check.js"></script>
<script src="../page_js/registor/country_menu.js"></script>
</body>

</html>