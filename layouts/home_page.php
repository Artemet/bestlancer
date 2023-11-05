<?php 
    include "../layouts/header.php";
    echo "<title>Bestlancer</title>";
?>
</head>
<body>
<?php
    include "modal/registor.php";
    include "modal/sing_in.php";
    include "modal/modal_up.php";
?>
<div class="header_line">
    <div class="line_wrapper">
        <div class="header_part header_part_one">
            <div><h1><a href="../bd_send/user_sing_in.php"><p>best</p>lancer</a></h1></div>
            <div class="links">
                <?php
                    $link_temp = -1;
                    $links_text = array("Заказы", "Фрилансеры", "Портфолио", "Форум", "Блог");
                    $links_href = array("#", "#", "#", "#", "#");
                    foreach ($links_text as $link){
                        $link_temp++;
                        echo "<a href='$links_href[$link_temp]'>$link</a>";
                    }
                ?>
            </div>
        </div>
        <div class="mobile_menu">
                <div class="img" onclick="menu_open()">
                    <img src="../res/burger_menu.png" alt="">
                </div>
                <div class="menu_sub">
                    <div class="cross" onclick="menu_close()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#d08e0b !important}</style><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                    </div>
                    <?php 
                        foreach ($links_text as $link){
                            echo "<a href='$links_href[$link_temp]' class='mobile_links'>$link</a>";
                        }
                    ?>
                    <div class="buttons">
                        <div class="registor" onclick="open_form_one()"><button>Регистрация</button></div>
                        <div class="login" onclick="open_form_two()"><button>Вход</button></div>
                    </div>
                </div>
            </div>
            <div class="user_panel">
                <div class="user" title="Мой профиль" style="display: block;">
                    <a href="">
                        <p class="user_name">
                            <?php
                                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                                    echo $_SESSION["nik"]; // Показывать имя пользователя, если вход выполнен
                                } else {
                                    echo "Гость"; // Показывать "Гость", если вход не выполнен
                                }
                            ?>
                        </p>
                        <div class="img">
                            <img src="../res/user.png" alt="" draggable="false">
                        </div>
                    </a>
                </div>
                <div class="messages" title="Чаты">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#d08e0b}</style><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                </div>
                <div class="accaunt_change" title="Прочее">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 128 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#d08e0b}</style><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/></svg>
                </div>
            </div>
    </div>
</div>
<link rel="stylesheet" href="../page_css/home.css">
<link rel="stylesheet" href="../page_css/media/home_media.css">
<div class="freelance_container container">
    <div class="title_part">
        <div class="part_one">
            <h2>Фриланс Биржа</h2>
            <div class="text_container">
                <a href="../pages/make_order.php">Разместите ваш заказ</a>
                <span>-</span>
                <p>Работайте с лучшими фрилансерами</p>
            </div>
            <form action="../bd_send/task_text_bd.php" id="task_send_form" method="post">
                <div>
                    <textarea name="task_text" onclick="sub_reaction()" placeholder="Опишите что вы хотите сделать" id="" cols="30" rows="10"></textarea>
                    <div class="textarea_sub">
                        <input type="text" name="task_email" placeholder="Напишите вас email">
                    </div>
                </div>
                <div>
                    <button onclick="" onmouseover="textarea_value_mouse()">Заказать</button>
                </div>
            </form>
            <p class="error_message">Введите вашу задачу в поле!</p>
        </div>
        <div class="part_two">
            <img src="../res/logo_page.png" alt="" draggable="false">
        </div>
    </div>
    <div class="movement_number">
        <div class="instruction">
            <div class="movement">
                <div class="img">
                    <img src="../res/steps-choose.png" alt="" draggable="false">
                </div>
                <div>
                    <div>
                        <span>1</span>
                        <h3>Найди Фрилансера</h3>
                    </div>
                    <p>Откройте для себя тысячи профессиональных услуг на любой бюджет.</p>
                </div>
            </div>
            <div class="movement">
                <div class="img">
                    <img src="../res/steps-pay-en.png" alt="" draggable="false">
                </div>
                <div>
                    <div>
                        <span>2</span>
                        <h3>Делайте покупки с уверенностью</h3>
                    </div>
                    <p>Всегда заранее узнавайте цены и сроки. Ваш платеж не будет разблокирован, пока вы не одобрите работу.</p>
                </div>
            </div>
            <div class="movement">
                <div class="img">
                    <img src="../res/steps-result.png" alt="" draggable="false">
                </div>
                <div>
                    <div>
                        <span>3</span>
                        <h3>Получите качественный результат</h3>
                    </div>
                    <p>100% горантируем возврат денег.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="repitation_container header">
        <div class="header_repitation header_title">
            <h2>Наша репутация</h2>
        </div>
        <div class="main_reoitation">
            <div class="repitation">
                <div class="number">
                    <span>0</span>
                    <b>1062</b>
                </div>
                <p>Зарегестрированных аккаунтов</p>
            </div>
            <div class="repitation">
                <div class="number">
                    <span>0</span>
                    <b>821</b>
                </div>
                <p>Положительных отзывов</p>
            </div>
            <div class="repitation">
                <div class="number">
                    <span>0</span>
                    <b>123</b>
                </div>
                <p>Заказов на бирже</p>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="work_resolt">
        <h2>Топ примеров работ наших фрилансеров</h2>
        <div class="works">
            <div class="arrow arrow_left">
                <span>&#8249;</span>
            </div>
            <div class="arrow arrow_right">
                <span onclick="click_right(this)">&#8250;</span>
            </div>
            <div class="slide">
            <div class="work">
                <div class="img">
                            <img src="../res/location.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynM</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/cup.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynM</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/web.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynM</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/cup.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynM</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/web.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynA</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/web.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynM</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/cup.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynB</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/web.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynM</a>
                        </div>
                    </div>
                    <div class="work">
                        <div class="img">
                            <img src="../res/location.jpg" class="work_img" alt="">
                        </div>
                        <div class="worker_information">
                            <div class="img">
                                <img src="../res/freelancer_logo.jpg" alt="">
                            </div>
                            <p>Freelancer: </p>
                            <a href="">ValentynC</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="catalog_container">
        <h2>Выберите вашу категорию</h2>
        <div class="categorys">
            <div class="category category_it">
                <h4>Разработка и IT</h4>
            </div>
            <div class="category category_art">
                <h4>Дизайн</h4>
            </div>
            <div class="category category_network">
                <h4>Соцсети и реклама</h4>
            </div>
            <div class="category category_seo">
                <h4>SEO и трафик</h4>
            </div>
            <div class="category category_stanza">
                <h4>Тексты и переводы</h4>
            </div>
            <div class="category category_bisnes">
                <h4>Бизнес и жизнь</h4>
            </div>
            <div class="category category_studio">
                <h4>Аудио, видео монтирование</h4>
            </div>
            <div class="category category_study">
                <h4>Учеба и репетиторство</h4>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="about_us">
        <h2>О Нас (<a href="">BestLancer</a>)</h2>
        <div class="about">
            <p class="about_text">Добро пожаловать на BestLancer - лучшую фриланс-биржу для воплощения ваших проектных идей в реальность!</p>
            <p class="about_text">У нас вы найдете идеальное место для размещения ваших заказов и привлечения талантливых и опытных <br> фрилансеров со всего мира. Мы стремимся создать комфортную и продуктивную платформу, где заказчики могут <br> получить высококачественные услуги, а фрилансеры могут найти интересные проекты и развиваться профессионально.</p>
            <h3>Вот почему вы должны выбрать <a href="">BestLancer</a>:</h3>
            <div class="why_question">
                <div class="anser">
                    <div><span>1</span></div>
                    <p>Мировое сообщество талантов</p>
                </div>
                <div class="anser">
                    <div><span>2</span></div>
                    <p>Легкость использования</p>
                </div>
                <div class="anser">
                    <div><span>3</span></div>
                    <p>Качество и безопасность</p>
                </div>
                <div class="anser">
                    <div><span>4</span></div>
                    <p>Поддержка и коммуникация</p>
                </div>
                <div class="anser">
                    <div><span>5</span></div>
                    <p>Гибкие возможности</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="work_subsequence header">
        <div class="header_title">
            <h2>Как работать?</h2>
        </div>
        <div class="subsequence_container">
            <div class="subsequence">
                <div class="subsequence_number">
                    <div class="number"><span>1</span></div>
                    <p class="who">Заказчик</p>
                </div>
                <div>
                    <p>Размещает свой заказ за минуту</p>
                </div>
            </div>
            <div class="subsequence">
                <div class="subsequence_number">
                    <div class="number"><span>2</span></div>
                    <p class="who">Фрилансеры</p>
                </div>
                <div>
                    <p>Предлагают услуги, цены и сроки</p>
                </div>
            </div>
            <div class="subsequence">
                <div class="subsequence_number">
                    <div class="number"><span>3</span></div>
                    <p class="who">Заказчик</p>
                </div>
                <div>
                    <p>Выбирает подходящего исполнителя</p>
                </div>
            </div>
            <div class="subsequence">
                <div class="subsequence_number">
                    <div class="number"><span>4</span></div>
                    <p class="who">Исполнитель</p>
                </div>
                <div>
                    <p>Выполняет работу и получает оплату</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="bestlancer_about">
        <div class="header_about">
            <h2><div class="bestlancer_text"><p>BEST</p>LANCER</div> Профессиональные услуги</h2>
            <p class="under_header">Доводить дело до конца еще никогда не было так просто.</p>
        </div>
        <div class="about">
            <div>
                <p>
                    <b>Хотите сэкономить время и деньги без ущерба для качества?</b>
                    Вот для чего мы здесь.
                    Мы создали Kwork, чтобы помочь таким независимым и ориентированным на результат предпринимателям, как вы, найти талантливых фрилансеров для всех нужд вашего бизнеса.
                    На Kwork тысячи талантливых фрилансеров соревнуются за ваш бизнес, размещая свои услуги в Каталоге. Эти услуги продаются как удобные товары навынос в реальном магазине. На нашей платформе нет запутанных и дорогостоящих почасовых ставок.
                    Также больше не нужно торговаться по цене и срокам. Цены, сроки и включенные услуги оговариваются заранее, что экономит ваше время, деньги и энергию.
                    Вы можете с уверенностью покупать услуги фрилансера на Kwork. Если что-то пойдет не так, вы защищены нашей <b>100% гарантией возврата денег , единственной в своем роде Программой защиты покупателей</b> и невероятной службой поддержки.
                    Зачем ждать? Сделай все сегодня!
                </p>
            </div>
            <div>
                <p>
                    <b>У вас уникальная работа или вы слишком заняты, чтобы искать фрилансеров?</b>
                    <p>Разместите запрос покупателя в специально созданном разделе «Обмен»!
                    Просто предоставьте описание, время доставки и бюджет. Опытные фрилансеры Kwork отправят индивидуальные предложения, адаптированные к вашей задаче. Лучше всего подходит для сложных или крупных проектов.
                    Качество предложений на Kwork уникально. Благодаря запатентованной функции нашей платформы вам не нужно просматривать море общих предложений, которые вы могли бы получить на других платформах для фрилансеров. Поскольку профессионалы Kwork вознаграждаются за то, что они вкладывают в каждое предложение особую мысль и усилия, вы можете выбирать из лучших вариантов .
                    У вас есть проект, который нужно отметить? Разместите заявку сегодня!</p>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
    include "../layouts/footer.php";
?>
<script src="../page_js/home/textarea_check.js"></script>
<script src="../page_js/home/input_sub.js"></script>
<script src="../page_js/home/scroll_home.js"></script>
<script src="../page_js/home/slider_home.js"></script>
</body>
</html>