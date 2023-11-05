<div class="user_container user_account">
    <div class="close_icon" onclick="close_form()" title="Закрыть форму">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#d08e0b}</style><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
    </div>
    <div class="come_in">
        <h2>Регистрация</h2>
        <div class="line"></div>
        <form action="../bd_send/user_registor.php" method="post" class="registor_form">
            <div class="registor_blocks">
                <div>
                    <p>Ваш email:</p>
                    <u class="warning"></u>
                    <input type="email" class="right_in email" name="user_email" placeholder="Напишите ваш email">
                </div>
                <div>
                    <p>Ваше имя:</p>
                    <u class="warning"></u>
                    <input type="text" class="right_in name" name="user_name" placeholder="Напишите ваше имя">
                </div>
                <div>
                    <p>Ваша фамилия:</p>
                    <u class="warning"></u>
                    <input type="text" class="right_in family" name="user_family" placeholder="Напишите вашу фамилию">
                </div>
                <div>
                    <p>Ваш ник-нейм:</p>
                    <u class="warning"></u>
                    <input type="text" class="right_in nik" name="user_nik" placeholder="Напишите ваш ник">
                </div>
                <div>
                    <p>Ваш Пароль:</p>
                    <div class="password">
                        <u class="warning"></u>
                        <input type="password" class="right_in password_input" name="user_password" placeholder="Напишите ваш Пароль">
                        <div class="eye" onclick="password_consequences()">
                            <svg class="show" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#4f8203}</style><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zm151 118.3C226 97.7 269.5 80 320 80c65.2 0 118.8 29.6 159.9 67.7C518.4 183.5 545 226 558.6 256c-12.6 28-36.6 66.8-70.9 100.9l-53.8-42.2c9.1-17.6 14.2-37.5 14.2-58.7c0-70.7-57.3-128-128-128c-32.2 0-61.7 11.9-84.2 31.5l-46.1-36.1zM394.9 284.2l-81.5-63.9c4.2-8.5 6.6-18.2 6.6-28.3c0-5.5-.7-10.9-2-16c.7 0 1.3 0 2 0c44.2 0 80 35.8 80 80c0 9.9-1.8 19.4-5.1 28.2zm9.4 130.3C378.8 425.4 350.7 432 320 432c-65.2 0-118.8-29.6-159.9-67.7C121.6 328.5 95 286 81.4 256c8.3-18.4 21.5-41.5 39.4-64.8L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5l-41.9-33zM192 256c0 70.7 57.3 128 128 128c13.3 0 26.1-2 38.2-5.8L302 334c-23.5-5.4-43.1-21.2-53.7-42.3l-56.1-44.2c-.2 2.8-.3 5.6-.3 8.5z"/></svg>
                            <svg class="show_none" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#4f8203}</style><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Ваше кодовое слово:</p>
                    <u class="warning"></u>
                    <input type="password" name="user_code_word" class="right_in code_word" placeholder="Введите ваше кодовое слово">
                </div>
                <div>
                    <p>Ваша страна:</p>
                    <div class="country">
                        <u class="warning"></u>
                        <input type="text" readonly class="right_in country" name="user_country" placeholder="Напишите вашу страну">
                        <div class="menu">
                            <div><p>Абхазия</p></div>
                            <div><p>Австралия</p></div>
                            <div><p>Австрия</p></div>
                            <div><p>Азербайджан</p></div>
                            <div><p>Албания</p></div>
                            <div><p>Алжир</p></div>
                            <div><p>Ам. Виргинские острова</p></div>
                            <div><p>Американское Самоа</p></div>
                            <div><p>Ангола</p></div>
                            <div><p>Андорра</p></div>
                            <div><p>Антигуа и Барбуда</p></div>
                            <div><p>Аргентина</p></div>
                            <div><p>Армения</p></div>
                            <div><p>Аруба</p></div>
                            <div><p>Афганистан</p></div>
                            <div><p>Багамы</p></div>
                            <div><p>Бангладеш</p></div>
                            <div><p>Барбадос</p></div>
                            <div><p>Бахрейн</p></div>
                            <div><p>Белиз</p></div>
                            <div><p>Белоруссия</p></div>
                            <div><p>Бельгия</p></div>
                            <div><p>Бенин</p></div>
                            <div><p>Бермудские Острова</p></div>
                            <div><p>Болгария</p></div>
                            <div><p>Боливия</p></div>
                            <div><p>Бонэйр</p></div>
                            <div><p>Босния и Герцеговина</p></div>
                            <div><p>Ботсвана</p></div>
                            <div><p>Бразилия</p></div>
                            <div><p>Бр. Виргинские острова</p></div>
                            <div><p>Бруней</p></div>
                            <div><p>Буркина-Фасо</p></div>
                            <div><p>Бурунди</p></div>
                            <div><p>Бутан</p></div>
                            <div><p>Вануату</p></div>
                            <div><p>Ватикан</p></div>
                            <div><p>Великобритания</p></div>
                            <div><p>Венгрия</p></div>
                            <div><p>Венесуэла</p></div>
                            <div><p>Восточный Тимор</p></div>
                            <div><p>Вьетнам</p></div>
                            <div><p>Габон</p></div>
                            <div><p>Гаити</p></div>
                            <div><p>Гайана</p></div>
                            <div><p>Гамбия</p></div>
                            <div><p>Гана</p></div>
                            <div><p>Гватемала</p></div>
                            <div><p>Гвинея</p></div>
                            <div><p>Гвинея-Бисау</p></div>
                            <div><p>Германия</p></div>
                            <div><p>Гондурас</p></div>
                            <div><p>Гонконг</p></div>
                            <div><p>Гренада</p></div>
                            <div><p>Греция</p></div>
                            <div><p>Грузия</p></div>
                            <div><p>Дания</p></div>
                            <div><p>Д.Р. Конго</p></div>
                            <div><p>Джерси</p></div>
                            <div><p>Джибути</p></div>
                            <div><p>Доминика</p></div>
                            <div><p>Доминикана</p></div>
                            <div><p>Египет</p></div>
                            <div><p>Замбия</p></div>
                            <div><p>Зимбабве</p></div>
                            <div><p>Израиль</p></div>
                            <div><p>Индия</p></div>
                            <div><p>Индонезия</p></div>
                            <div><p>Иордания</p></div>
                            <div><p>Ирак</p></div>
                            <div><p>Иран</p></div>
                            <div><p>Ирландия</p></div>
                            <div><p>Исландия</p></div>
                            <div><p>Испания</p></div>
                            <div><p>Италия</p></div>
                            <div><p>Йемен</p></div>
                            <div><p>Кабо-Верде</p></div>
                            <div><p>Казахстан</p></div>
                            <div><p>Камбоджа</p></div>
                            <div><p>Камерун</p></div>
                            <div><p>Канада</p></div>
                            <div><p>Катар</p></div>
                            <div><p>Кения</p></div>
                            <div><p>Кипр</p></div>
                            <div><p>Киргизия</p></div>
                            <div><p>Кирибати</p></div>
                            <div><p>Китай</p></div>
                            <div><p>Колумбия</p></div>
                            <div><p>Кокосовые острова</p></div>
                            <div><p>Коморские Острова</p></div>
                            <div><p>Конго</p></div>
                            <div><p>КНДР</p></div>
                            <div><p>Корея</p></div>
                            <div><p>Коста-Рика</p></div>
                            <div><p>Кот-д'Ивуар</p></div>
                            <div><p>Куба</p></div>
                            <div><p>Кувейт</p></div>
                            <div><p>Кюрасао</p></div>
                            <div><p>Лаос</p></div>
                            <div><p>Латвия</p></div>
                            <div><p>Лесото</p></div>
                            <div><p>Либерия</p></div>
                            <div><p>Ливан</p></div>
                            <div><p>Ливия</p></div>
                            <div><p>Литва</p></div>
                            <div><p>Лихтенштейн</p></div>
                            <div><p>Люксембург</p></div>
                            <div><p>Маврикий</p></div>
                            <div><p>Мавритания</p></div>
                            <div><p>Мадагаскар</p></div>
                            <div><p>Македония</p></div>
                            <div><p>Малави</p></div>
                            <div><p>Малайзия</p></div>
                            <div><p>Мали</p></div>
                            <div><p>Мальта</p></div>
                            <div><p>Мальдивы</p></div>
                            <div><p>Марокко</p></div>
                            <div><p>Маршалловы Острова</p></div>
                            <div><p>Мексика</p></div>
                            <div><p>Мозамбик</p></div>
                            <div><p>Молдавия (Молдова)</p></div>
                            <div><p>Монако</p></div>
                            <div><p>Монголия</p></div>
                            <div><p>Мьянма</p></div>
                            <div><p>Намибия</p></div>
                            <div><p>Науру</p></div>
                            <div><p>Непал</p></div>
                            <div><p>Нигер</p></div>
                            <div><p>Нигерия</p></div>
                            <div><p>Нидерланды</p></div>
                            <div><p>Никарагуа</p></div>
                            <div><p>Новая Зеландия</p></div>
                            <div><p>Норвегия</p></div>
                            <div><p>ОАЭ</p></div>
                            <div><p>Оман</p></div>
                            <div><p>Острова Кука</p></div>
                            <div><p>Пакистан</p></div>
                            <div><p>Палау</p></div>
                            <div><p>Панама</p></div>
                            <div><p>Папуа-Новая Гвинея</p></div>
                            <div><p>Парагвай</p></div>
                            <div><p>Перу</p></div>
                            <div><p>Пуэрто-Рико</p></div>
                            <div><p>Польша</p></div>
                            <div><p>Португалия</p></div>
                            <div><p>Россия</p></div>
                            <div><p>Руанда</p></div>
                            <div><p>Румыния</p></div>
                            <div><p>Саба</p></div>
                            <div><p>Сальвадор</p></div>
                            <div><p>Самоа</p></div>
                            <div><p>Сан-Марино</p></div>
                            <div><p>Сан-Томе и Принсипи</p></div>
                            <div><p>Саудовская Аравия</p></div>
                            <div><p>Свазиленд</p></div>
                            <div><p>Сейшелы</p></div>
                            <div><p>Сенегал</p></div>
                            <div><p>Сент-Винсент и Гренадины</p></div>
                            <div><p>Сент-Китс и Невис</p></div>
                            <div><p>Сент-Люсия</p></div>
                            <div><p>Сен-Мартен</p></div>
                            <div><p>Сербия</p></div>
                            <div><p>Сингапур</p></div>
                            <div><p>Синт-Эстатиус</p></div>
                            <div><p>Сирия</p></div>
                            <div><p>Словакия</p></div>
                            <div><p>Словения</p></div>
                            <div><p>США</p></div>
                            <div><p>Соломоновы Острова</p></div>
                            <div><p>Сомали</p></div>
                            <div><p>Судан</p></div>
                            <div><p>Суринам</p></div>
                            <div><p>Сьерра-Леоне</p></div>
                            <div><p>Таджикистан</p></div>
                            <div><p>Таиланд</p></div>
                            <div><p>Танзания</p></div>
                            <div><p>Того</p></div>
                            <div><p>Токелау</p></div>
                            <div><p>Тонга</p></div>
                            <div><p>Тринидад и Тобаго</p></div>
                            <div><p>Тувалу</p></div>
                            <div><p>Тунис</p></div>
                            <div><p>Туркменистан</p></div>
                            <div><p>Турция</p></div>
                            <div><p>Уганда</p></div>
                            <div><p>Узбекистан</p></div>
                            <div><p>Украина</p></div>
                            <div><p>Уоллис и Футуна</p></div>
                            <div><p>Уругвай</p></div>
                            <div><p>Фарерские острова</p></div>
                            <div><p>Фед. Штаты Микронезии</p></div>
                            <div><p>Фиджи</p></div>
                            <div><p>Филиппины</p></div>
                            <div><p>Финляндия</p></div>
                            <div><p>Фолклендские острова</p></div>
                            <div><p>Франция</p></div>
                            <div><p>Французская Полинезия</p></div>
                            <div><p>Хорватия</p></div>
                            <div><p>ЦАР</p></div>
                            <div><p>Чад</p></div>
                            <div><p>Черногория</p></div>
                            <div><p>Чехия</p></div>
                            <div><p>Чили</p></div>
                            <div><p>Швейцария</p></div>
                            <div><p>Швеция</p></div>
                            <div><p>Шри-Ланка</p></div>
                            <div><p>Эквадор</p></div>
                            <div><p>Экваториальная Гвинея</p></div>
                            <div><p>Эритрея</p></div>
                            <div><p>Эстония</p></div>
                            <div><p>Эфиопия</p></div>
                            <div><p>ЮАР</p></div>
                            <div><p>Южный Судан</p></div>
                            <div><p>Ямайка</p></div>
                            <div><p>Япония</p></div>
                        </div>
                        <div class="burger_menu_icon">
                            <img src="../res/burger_menu.png" alt="">
                        </div>
                    </div>
                </div>
                <div>
                    <p>Ваш возраст:</p>
                    <div class="age">
                        <u class="warning"></u>
                        <input type="number" name="user_age" class="right_in age_input" value="20" readonly placeholder="Напишите ваш возраст">
                        <div class="age_change">
                            <span>-</span>
                            <span>+</span>
                        </div>
                    </div>
                </div>
                <div class="line"></div>
                <div>
                    <p>Ваши Глобальные скиллы:</p>
                    <div class="skills">
                        <u class="warning"></u>
                        <input type="text" name="user_skills" readonly class="right_in skills" placeholder="Выберите ваши умения">
                        <div class="menu">
                            <div><p>Дизайн-интерьера</p></div>
                            <div><p>Дизайн-веб-сайтов</p></div>
                            <div><p>Дизайн-одежды</p></div>
                            <div><p>Транспортный-дизайнер</p></div>
                            <div><p>Изготовитель-моделей</p></div>
                            <div><p>Продуктовый-дизайнер</p></div>
                            <div><p>Дизайнер-мобильных-приложений</p></div>
                            <div><p>Графический-дизайнер</p></div>
                            <div><p>Архитектор</p></div>
                            <div><p>SEO-трафик</p></div>
                            <div><p>Фронтенд-разработчик</p></div>
                            <div><p>Бэкенд-разработчик</p></div>
                            <div><p>Фулстек-разработчик</p></div>
                            <div><p>Разработчик-игр</p></div>
                            <div><p>Разработчик-мобильных-приложений</p></div>
                            <div><p>1С-разработчик</p></div>
                            <div><p>DevOps-инженер</p></div>
                            <div><p>Видео-монтаж</p></div>
                            <div><p>Аудио-редакция</p></div>
                            <div><p>фото-редакция</p></div>
                            <div><p>Производственный-бизнес</p></div>
                            <div><p>Коммерческий-бизнес</p></div>
                            <div><p>Финансовый-бизнес</p></div>
                            <div><p>Посреднический-бизнес</p></div>
                            <div><p>Страховой-бизнес</p></div>
                            <div><p>Домашнее-обучение</p></div>
                            <div><p>Репетитор-на-полный-день</p></div>
                            <div><p>Репетитор-на-неполный-день</p></div>
                            <div><p>Написание-продающих-текстов</p></div>
                            <div><p>Имиджевый-копирайтинг</p></div>
                            <div><p>SEO-копирайтинг</p></div>
                            <div><p>Контекстная-реклама</p></div>
                            <div><p>Таргетированная-реклама</p></div>
                            <div><p>Ремаркетинг-и-ретаргетинг</p></div>
                            <div><p>Email-рассылки</p></div>
                            <div><p>Тизерная-реклама</p></div>
                            <div><p>Нативная-реклама</p></div>
                            <div><p>Видеореклама</p></div>
                        </div>
                        <div class="cross" title="закрыть меню">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" ><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#d08e0b}</style><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
                        </div>
                        <div class="bin" title="отчистить выбраное">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M49.7 32c-10.5 0-19.8 6.9-22.9 16.9L.9 133c-.6 2-.9 4.1-.9 6.1C0 150.7 9.3 160 20.9 160h94L140.5 32H49.7zM272 160V32H173.1L147.5 160H272zm32 0H428.5L402.9 32H304V160zm157.1 0h94c11.5 0 20.9-9.3 20.9-20.9c0-2.1-.3-4.1-.9-6.1L549.2 48.9C546.1 38.9 536.8 32 526.3 32H435.5l25.6 128zM32 192l4 32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H44L64 448c0 17.7 14.3 32 32 32s32-14.3 32-32H448c0 17.7 14.3 32 32 32s32-14.3 32-32l20-160h12c17.7 0 32-14.3 32-32s-14.3-32-32-32h-4l4-32H32z"/></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Расскажите о себе и опыте работы</p>
                    <textarea name="about_user" placeholder="Расскажите о себе и опыте работы" class="right_in" cols="30" rows="10"></textarea>
                </div>
                <div class="users_works">
                    <div class="add_works">
                        <div><p class="title">Добавьте примеры работ</p></div>
                        <div class="delite none_press project_function" title="удалить работу"><span>-</span></div>
                        <div class="add project_function" title="Добавить работу"><span>+</span></div>
                    </div>
                    <u class="warning"></u>
                    <div class="projects"></div>
                    <div class="line"></div>
                    <b>Загрузить данные из указанных примеров</b>
                    <textarea name="user_projects" readonly placeholder="Итоговые работы" class="final_resolt right_in" cols="30" rows="10"></textarea>
                </div>
                <div class="user_money">
                    <p>Время началы работы</p>
                    <input type="time" name="user_time" class="right_in">
                </div>
                <div class="user_money">
                    <p>Часовая ставка</p>
                    <u class="warning"></u>
                    <div class="hour_money">
                        <div><input type="number" name="user_price" min="5" value="5" class="right_in money" placeholder="Введите суму"></div>
                        <div class="dollar"><span>$</span></div>
                    </div>
                </div>
            </div>
            <div class="button" onclick="value_check()">
                <button class="buttons">Зарегестрироваться</button>
            </div>
            <div class="button" onclick="value_check()">
                <p class="buttons">Зарегестрироваться</p>
            </div>
        </form>
    </div>
</div>