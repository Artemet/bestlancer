<?php
session_start();
include "../bd_send/database_connect.php";
include "../layouts/header.php";
?>
<link rel="stylesheet" href="../page_css/home.css">
<link rel="stylesheet" href="../page_css/media/home_media.css">
<link rel="stylesheet" href="../page_css/modal_css/star_modal.css">
<link rel="stylesheet" href="../local_css/media/star_modal_media.css">
<?php
echo "<title>Фриланс биржа Bestlancer</title>";
include "../layouts/modal/star_option.php";
include "../layouts/header_line.php";
?>
<div class="freelance_container container">
    <div class="title_part">
        <div class="part_one">
            <h2>Фриланс Биржа</h2>
            <div class="start_system">
                <?php
                if (isset($_SESSION["nik"])) {
                    $user_email = $_SESSION["email"];
                    $email_contain = false;
                    $email_sql = "SELECT `email` FROM `reviews` WHERE `type` = 'exchange' AND `email` LIKE ?";
                    $email_stmt = mysqli_prepare($bd_connect, $email_sql);
                    $email_param = "%$user_email%";
                    mysqli_stmt_bind_param($email_stmt, "s", $email_param);
                    mysqli_stmt_execute($email_stmt);
                    $email_query = mysqli_stmt_get_result($email_stmt);
                    while ($email_row = mysqli_fetch_assoc($email_query)) {
                        $email_contain = true;
                    }
                    for ($i = 1; $i < 6; $i++) {
                        if ($email_contain == false) {
                            echo '<div class="star"><svg class="' . $i . '" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#acafb4}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg></div>';
                        } elseif ($email_contain == true) {
                            $star_type = "exchange";
                            $user_star = "SELECT `star` FROM `reviews` WHERE `email` = ? AND `type` = ?";
                            $star_stmt = mysqli_prepare($bd_connect, $user_star);
                            mysqli_stmt_bind_param($star_stmt, "ss", $user_email, $star_type);
                            mysqli_stmt_execute($star_stmt);
                            $star_query = mysqli_stmt_get_result($star_stmt);
                            $star_row = mysqli_fetch_assoc($star_query);
                            if ($i <= $star_row['star']) {
                                echo '<div class="star" onclick="alert(`Спасибо за отзыв на Bestlancer!`);"><svg class="fill none_click ' . $i . '" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#acafb4}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg></div>';
                            } else {
                                echo '<div class="star" onclick="alert(`Спасибо за отзыв на Bestlancer!`);"><svg class="none_click ' . $i . '" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#acafb4}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg></div>';
                            }
                        }
                    }
                } else {
                    for ($i = 1; $i < 6; $i++) {
                        echo '<div class="star" onclick="none_user_sing()"><svg class="none" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#acafb4}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg></div>';
                    }
                }
                ?>
            </div>
            <div class="text_container">
                <?php
                if (!isset($_SESSION["nik"])) {
                    echo "";
                } else {
                    echo '<a href="../pages/make_order.php">Разместите ваш заказ</a>
                                <span class="link_part">-</span>';
                }
                ?>
                <p class="link_part">Работайте с лучшими фрилансерами</p>
            </div>
            <form action="" id="task_send_form" method="post">
                <div>
                    <textarea name="task_text" onclick="sub_reaction()" placeholder="Опишите что вы хотите сделать"
                        cols="30" rows="10"></textarea>
                    <div class="textarea_sub">
                        <?php
                        if (isset($_SESSION["nik"])) {
                            $user_email = $_SESSION["email"];
                        } else {
                            $user_email = "";
                        }
                        ?>
                        <input type="text" value="<?= $user_email ?>" name="task_email"
                            placeholder="Напишите вас email">
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
                        <h3>Поручайте заказы с уверенностью</h3>
                    </div>
                    <p>Всегда заранее узнавайте цены и сроки. Ваш платеж не будет разблокирован, пока вы не одобрите
                        работу.</p>
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
        <?php
        //orders_number
        $sql_orders = "SELECT * FROM `orders` ORDER BY `id`";
        $order_query = mysqli_query($bd_connect, $sql_orders);
        $order_row = mysqli_fetch_assoc($order_query);
        if (mysqli_num_rows($order_query) == 0) {
            $last_order = 0;
        } else {
            $last_order = $order_row['id'];
        }
        //review_number
        $sql_review = "SELECT * FROM `reviews` ORDER BY `id`";
        $review_query = mysqli_query($bd_connect, $sql_review);
        $review_row = mysqli_fetch_assoc($review_query);
        if (mysqli_num_rows($review_query) == 0) {
            $last_review = 0;
        } else {
            $last_review = $review_row['id'];
        }
        //account_number
        $sql_accounts = "SELECT * FROM `user_registoring` ORDER BY `id`";
        $account_query = mysqli_query($bd_connect, $sql_accounts);
        $accoun_row = mysqli_fetch_assoc($account_query);
        if (mysqli_num_rows($account_query) == 0) {
            $last_account = 0;
        } else {
            $last_account = $accoun_row['id'];
        }
        ?>
        <div class="main_reoitation">
            <div class="repitation">
                <div class="number">
                    <span class="active">0</span>
                    <b>
                        <?= $last_account ?>
                    </b>
                </div>
                <p>Зарегестрированных аккаунтов</p>
            </div>
            <div class="repitation">
                <div class="number">
                    <span class="active">0</span>
                    <b>
                        <?= $last_review ?>
                    </b>
                </div>
                <p>Отзывов на бирже</p>
            </div>
            <div class="repitation">
                <div class="number">
                    <span class="active">0</span>
                    <b>
                        <?= $last_order ?>
                    </b>
                </div>
                <p>Заказов на бирже</p>
            </div>
        </div>
    </div>
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
                <div class="slide_part">
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
                </div>
                <div class="slide_part">
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
                </div>
                <div class="slide_part">
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
    </div>
    <div class="line"></div>
    <div class="catalog_container">
        <h2>Выберите вашу категорию</h2>
        <div class="categorys">
            <a href="tasks.php?filter=2">
                <div class="category category_it">
                    <h4>Разработка и IT</h4>
                </div>
            </a>
            <a href="tasks.php?filter=1">
                <div class="category category_art">
                    <h4>Дизайн</h4>
                </div>
            </a>
            <a href="tasks.php?filter=5">
                <div class="category category_network">
                    <h4>Соцсети и реклама</h4>
                </div>
            </a>
            <a href="tasks.php?filter=4">
                <div class="category category_seo">
                    <h4>SEO и трафик</h4>
                </div>
            </a>
            <a href="tasks.php?filter=3">
                <div class="category category_stanza">
                    <h4>Тексты и переводы</h4>
                </div>
            </a>
            <a href="tasks.php?filter=7">
                <div class="category category_bisnes">
                    <h4>Бизнес и жизнь</h4>
                </div>
            </a>
            <a href="tasks.php?filter=6">
                <div class="category category_studio">
                    <h4>Аудио, видео монтирование</h4>
                </div>
            </a>
            <a href="tasks.php?filter=8">
                <div class="category category_study">
                    <h4>Учеба и репетиторство</h4>
                </div>
            </a>
        </div>
    </div>
    <div class="line"></div>
    <div class="about_us">
        <h2>О Нас (<a href="about_company.php">BestLancer</a>)</h2>
        <div class="about">
            <p class="about_text">Добро пожаловать на BestLancer - лучшую фриланс-биржу для воплощения ваших проектных
                идей в реальность!</p>
            <p class="about_text">У нас вы найдете идеальное место для размещения ваших заказов и привлечения
                талантливых и опытных <br> фрилансеров со всего мира. Мы стремимся создать комфортную и продуктивную
                платформу, где заказчики могут <br> получить высококачественные услуги, а фрилансеры могут найти
                интересные проекты и развиваться профессионально.</p>
            <h3>Вот почему вы должны выбрать <a href="about_company.php">BestLancer</a>:</h3>
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
            <h2>
                <div class="bestlancer_text">
                    <p>BEST</p>LANCER
                </div> Новая биржа
            </h2>
            <p class="under_header">Доводить дело до конца еще никогда не было так просто.</p>
        </div>
        <div class="about">
            <div>
                <p>
                    <b>Хотите получить огромное удовольствие и качественную работу?</b>
                    Вот для чего мы здесь. Мы представляем вам Bestlancer - новую фриланс-биржу, созданную, чтобы помочь
                    независимым и ориентированным на результат предпринимателям, как вы, найти талантливых фрилансеров
                    для всех нужд вашего бизнеса.

                    На Bestlancer вы найдете опытных специалистов, готовых предоставить свои услуги в нашем каталоге.
                    Эти услуги представлены как удобные товары в магазине, и у нас нет запутанных и дорогостоящих
                    почасовых ставок. Мы стремимся сделать процесс найма фрилансеров максимально простым и прозрачным
                    для вас.

                    Забудьте о необходимости торговаться по цене и срокам. На Bestlancer вы можете с уверенностью
                    выбирать фрилансеров, зная, что все условия сотрудничества оговариваются четко. И если возникнут
                    вопросы или затруднения, наша служба поддержки всегда готова вам помочь.

                    Зачем ждать? Начните сотрудничество с Bestlancer уже сегодня и достигайте новых высот в развитии
                    своего бизнеса!
                </p>
            </div>
            <div>
                <p>
                    Мы предоставляем четкие цены, сроки и детали услуги заранее, что позволяет вам экономить время,
                    деньги и энергию. На нашей платформе нет необходимости торговаться по цене и срокам. Вы можете с
                    уверенностью выбирать фрилансеров на Bestlancer, зная, что все условия сотрудничества оговариваются
                    четко.

                    Кроме того, наша цель - сделать ваш бизнес более эффективным и успешным. Мы предоставляем надежную
                    службу поддержки, готовую помочь вам в любое время. Наша платформа призвана упростить процесс найма
                    фрилансеров и помочь вам добиться желаемых результатов без лишних хлопот.

                    Начните сотрудничество с Bestlancer и достигайте успеха в своем бизнесе! С
                    Bestlancer вы получаете доступ к талантливым специалистам и инструментам, которые помогут вам расти
                    и развиваться. Мы готовы поддержать вас на каждом этапе вашего проекта и сделать вашу работу более
                    продуктивной и прибыльной.
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
<script src="../page_js/home/user_order_check.js"></script>
<script src="../page_js/home/star_system.js"></script>
</body>

</html>