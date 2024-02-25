<div class="user_container change_profile_container">
    <div class="change_profile">
        <div class="close">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <style>
                    svg {
                        fill: #4f8203
                    }
                </style>
                <path
                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
            </svg>
        </div>
        <div>
            <h2>Изменение профиля</h2>
        </div>
        <form action="../bd_send/user/user_information.php" class="change_information_form" id="userForm" method="post"
            enctype="multipart/form-data">
            <div class="img_change">
                <div>
                    <div class="file_part">
                        <div class="img" id="selectedIcon">
                            <img src="../bd_send/user/user_icons/<?= $user_resolt["icon_path"] ?>" draggable="false">
                        </div>

                        <div>
                            <div>
                                <input type="file" id="icon_choice" name="icon_choice" class="choose_file"
                                    accept=".jpg,.png,.jpeg">
                                <svg xmlns="http://www.w3.org/2000/svg" title="Выбрать изображение" class="file_choice"
                                    height="1em"
                                    viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <style>
                                        svg {
                                            fill: #4f8203
                                        }
                                    </style>
                                    <path
                                        d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z" />
                                </svg>
                            </div>
                            <div>
                                <!-- <a href="../bd_send/user/delete_icon.php"> -->
                                <div title="Удалить изображение">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="delite_icon" height="1em"
                                        viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z">
                                        </path>
                                    </svg>
                                </div>
                                <!-- </a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                <div class="account_information">
                    <div class="country_wrapper">
                        <h3>Страна</h3>
                        <u class="warning"></u>
                        <input type="text" value="<?= $user_resolt["country"] ?>" name="country"
                            class="country_input right_in" placeholder="Ваш вашу страну" readonly>
                        <div class="country_sub">
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
                    <div>
                        <h3>Возраст</h3>
                        <u class="warning"></u>
                        <input type="number" value="<?= $user_resolt["age"] ?>" name="age" class="age right_in"
                            placeholder="Ваш возраст">
                    </div>
                    <?php
                    if ($user_resolt["role"] == "seller"):
                        ?>
                        <div>
                            <h3>Ставка</h3>
                            <u class="warning"></u>
                            <div class="price_input">
                                <input type="number" name="hour_price" value="<?= $user_resolt["price"] ?>" class="right_in"
                                    placeholder="Ваша часовая ставка">
                                <span>₽</span>
                            </div>
                        </div>
                        <div>
                            <h3>Начало работы</h3>
                            <u class="warning"></u>
                            <input type="time" name="start_time" value="<?= $user_resolt["work_time"] ?>" class="right_in"
                                placeholder="Время началы работы">
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
                <div>
                    <h3>Обо мне</h3>
                    <textarea name="about_me" class="right_in about_user" id="" cols="30" rows="10"
                        placeholder="Измините информацию о себе"></textarea>
                </div>
                <div class="my_knowledge">
                    <div class="title_wrapper">
                        <div>
                            <h3>Мои умения</h3>
                        </div>
                        <div title="Добавить навык">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>
                        </div>
                    </div>
                    <div class="knowledges_wrapper">
                        <input type="text" name="knowledges" class="final_value" readonly>
                    </div>
                </div>
            </div>
            <p class="click">Сохранить</p>
            <button class="click">Сохранить</button>
        </form>
    </div>
</div>