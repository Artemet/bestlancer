<?php
session_start();
include "../bd_send/database_connect.php";
include "../layouts/header.php";
?>
<link rel="stylesheet" href="../page_css/home.css?version=2">
<link rel="stylesheet" href="../page_css/media/home_media.css?version=2">
<link rel="stylesheet" href="../page_css/modal_css/star_modal.css">
<link rel="stylesheet" href="../page_css/modal_css/bonuse_catch.css">
<link rel="stylesheet" href="../local_css/media/star_modal_media.css">
<?php
echo "<title>Фриланс биржа Bestlancer - надежные услуги</title>";
include "../layouts/modal/star_option.php";
include "../layouts/modal/bonuse_catch.php";
include "../layouts/header_line.php";
?>
<div class="freelance_container container">
    <div class="title_part">
        <div class="part_one">
            <h1>Фриланс Биржа</h1>
            <p class="under_title">Фриланс для всех!</p>
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
                            mysqli_stmt_close($star_stmt);
                        }
                    }
                    mysqli_stmt_close($email_stmt);
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
                    if ($user_resolt["role"] == "buyer") {
                        echo '<a href="../pages/make_order.php">Разместите ваш заказ</a>
                                <span class="link_part">-</span>';
                    } else {
                        echo "";
                    }
                }
                ?>
                <p class="link_part">На Фриланс бирже Bestlancer, <br> вы найдете гарантированного исполнителя.</p>
            </div>
            <div class="form_wrapper">
                <div>
                    <textarea name="task_text" placeholder="Расскажите, исполнитель какого направления вам требуется..."
                        cols="30" rows="10"></textarea>
                    <div class="textarea_sub">
                        <?php
                        if (isset($_SESSION["nik"])) {
                            $user_email = $_SESSION["email"];
                        } else {
                            $user_email = "";
                        }
                        ?>
                    </div>
                </div>
                <div>
                    <button>Продолжить</button>
                </div>
            </div>
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
                        <h3>Найди исполнителя</h3>
                    </div>
                    <p>Откройте для себя профессиональные услуги на любой бюджет.</p>
                </div>
            </div>
            <div class="movement">
                <div class="img">
                    <img src="../res/steps-pay-en.png" alt="" draggable="false">
                </div>
                <div>
                    <div>
                        <span>2</span>
                        <h3>Доверяйте выполнение заказов с уверенностью. </h3>
                    </div>
                    <p>Обсудите все детали выполнения заказа до назначения исполнителя.</p>
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
                    <p>Оставляйте отзывы для следующих покупателей.</p>
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
        function orders_count($index)
        {
            global $bd_connect;
            $sql_orders = null;
            if ($index == 0) {
                $sql_orders = "SELECT * FROM `orders`";
            } else {
                $sql_orders = "SELECT * FROM `services`";
            }
            $order_query = mysqli_query($bd_connect, $sql_orders);
            return mysqli_num_rows($order_query);
        }
        if (orders_count(0) == 0 && orders_count(1) == 0) {
            $last_order = 0;
        } else {
            $last_order = 0;
            for ($i = 0; $i < 2; $i++) {
                $last_order += orders_count($i);
            }
        }
        //review_number
        $review_type = "exchange";
        $sql_review = "SELECT * FROM `reviews` WHERE `type` = ? ORDER BY `id`";
        $review_stmt = mysqli_prepare($bd_connect, $sql_review);

        if ($review_stmt) {
            mysqli_stmt_bind_param($review_stmt, "s", $review_type);
            $review_query = mysqli_stmt_execute($review_stmt);

            if ($review_query) {
                $review_resolt = mysqli_stmt_get_result($review_stmt);
                $review_row = mysqli_fetch_assoc($review_resolt);
                if (mysqli_num_rows($review_resolt) == 0) {
                    $last_review = 0;
                } else {
                    $last_review = mysqli_num_rows($review_resolt);
                }
            } else {
                $last_review = 0;
            }
        } else {
            $last_review = 0;
        }
        mysqli_stmt_close($review_stmt);

        //account_number
        $sql_accounts = "SELECT * FROM `user_registoring` ORDER BY `id`";
        $account_query = mysqli_query($bd_connect, $sql_accounts);
        $accoun_row = mysqli_fetch_assoc($account_query);
        if (mysqli_num_rows($account_query) == 0) {
            $last_account = 0;
        } else {
            $last_account = mysqli_num_rows($account_query);
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
                <p>Созданных аккаунтов</p>
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
                <p>Работ на бирже</p>
            </div>
        </div>
    </div>
    <div class="work_resolt">
        <h2>Примеры работ наших фрилансеров</h2>
        <?php
        $project_exception = "no-photo-available.png";
        function user_info_get($table, $nik)
        {
            global $bd_connect;
            $user_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
            $user_stmt = mysqli_prepare($bd_connect, $user_sql);
            mysqli_stmt_bind_param($user_stmt, "s", $nik);
            mysqli_stmt_execute($user_stmt);
            $user_result = mysqli_stmt_get_result($user_stmt);
            $users_row = mysqli_fetch_assoc($user_result)[$table];
            return $users_row;
        }
        $project_cover_sql = "SELECT * FROM (SELECT * FROM `project_cover` WHERE `cover_href` != ? ORDER BY `id` DESC LIMIT 20) AS sub ORDER BY RAND()";
        $project_cover_stmt = mysqli_prepare($bd_connect, $project_cover_sql);
        mysqli_stmt_bind_param($project_cover_stmt, "s", $project_exception);
        mysqli_stmt_execute($project_cover_stmt);
        $project_cover_result = mysqli_stmt_get_result($project_cover_stmt);
        ?>
        <div class="works">
            <div class="slide">
                <?php
                while ($cover_row = mysqli_fetch_assoc($project_cover_result)):
                    ?>
                    <div class="slide_part">
                        <div class="work">
                            <div class="img image_cover">
                                <a href="project_page.php?project_id=<?= $cover_row["id"] ?>">
                                    <img src="../bd_send/user/project_cover/<?= $cover_row["cover_href"] ?>"
                                        class="work_img" alt="" loading="lazy" draggable="false">
                                </a>
                            </div>
                            <div class="worker_information">
                                <div class="img">
                                    <img src="../bd_send/user/user_icons/<?= user_info_get("icon_path", $cover_row["nik"]) ?>"
                                        alt="" loading="lazy" draggable="false">
                                </div>
                                <div>
                                    <a href="user_page.php?user_id=<?= user_info_get('id', $cover_row['nik']) ?>">
                                        <?= htmlspecialchars(strlen($cover_row['nik']) > 15 ? substr($cover_row['nik'], 0, 15) . "..." : $cover_row['nik']) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
        </div>
    </div>
    <div class=" line">
    </div>
    <div class="catalog_container">
        <h2>Выберите вашу категорию</h2>
        <?php
        $category_address = "tasks";
        if (isset($_SESSION["nik"])) {
            if ($user_resolt['role'] == "buyer") {
                $category_address = "services";
            }
        } else {
            $category_address = "services";
        }
        function filter_reject($index, $address)
        {
            if ($address == "services") {
                $index_decrease = $index - 1;
                return $index_decrease;
            }
            return $index;
        }
        ?>
        <div class="categorys">
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(2, $category_address) ?>">
                <div class="category category_it">
                    <h4>Разработка и IT</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(1, $category_address) ?>">
                <div class="category category_art">
                    <h4>Дизайн</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(5, $category_address) ?>">
                <div class="category category_network">
                    <h4>Соцсети и реклама</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(4, $category_address) ?>">
                <div class="category category_seo">
                    <h4>SEO и трафик</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(3, $category_address) ?>">
                <div class="category category_stanza">
                    <h4>Тексты и переводы</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(7, $category_address) ?>">
                <div class="category category_bisnes">
                    <h4>Бизнес и жизнь</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(6, $category_address) ?>">
                <div class="category category_studio">
                    <h4>Аудио, видео монтирование</h4>
                </div>
            </a>
            <a href="<?= $category_address ?>.php?filter=<?= filter_reject(8, $category_address) ?>">
                <div class="category category_study">
                    <h4>Учеба и репетиторство</h4>
                </div>
            </a>
        </div>
    </div>
    <div class="line"></div>
    <div class="about_us">
        <h2>О Нас</h2>
        <div class="about">
            <p class="about_text">BestLancer – ваш надежный партнер в мире фриланса, где мечты о
                великолепных проектах
                становятся реальностью!</p>
            <p class="about_text">Мастера своего дела(наши фрилансеры), готовые вдохнуть жизнь
                в самые смелые идеи. На
                BestLancer мы ценим качество, инновации и удобство сотрудничества, объединяя
                заказчиков и выдающихся
                фрилансеров со всех уголков планеты.</p>
            <h3>Причины выбрать <a href="about_company.php">BestLancer</a>!</h3>
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
            <h2>Как начать работать?</h2>
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
                    <p class="who">Исполнитель</p>
                </div>
                <div>
                    <p>Предлагает услуги, цены и сроки</p>
                </div>
            </div>
            <div class="subsequence">
                <div class="subsequence_number">
                    <div class="number"><span>3</span></div>
                    <p class="who">Заказчик</p>
                </div>
                <div>
                    <p>Выберает подходящего исполнителя</p>
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
                </div>
            </h2>
        </div>
        <div class="about">
            <div>
                <p>
                    Bestlancer – ваш новый надежный компаньон в мире фриланса, где удовольствие
                    от работы и качество
                    исполнения идут рука об руку. Мы здесь, чтобы облегчить жизнь амбициозным
                    предпринимателям, таким
                    как вы, предоставляя легкий доступ к морю талантливых фрилансеров, готовых
                    воплотить в жизнь любой
                    ваш проект. Bestlancer как уютный рынок, где каждый сервис – это уникальный
                    лот, ждущий своего
                    покупателя. У нас нет сложных систем расчета или ошеломляющих почасовых
                    тарифов. Наша цель – сделать
                    ваш поиск идеального исполнителя максимально простым и понятным.
                </p>
            </div>
            <div>
                <p>
                    Забудьте о долгих переговорах и утомительном выборе. На Bestlancer каждый
                    шаг сотрудничества
                    прописан ясно и прозрачно, позволяя вам выберать исполнителей без малейших
                    сомнений в их
                    квалификации и условиях работы. И если у вас возникнут вопросы или нужда в
                    поддержке, наша команда
                    всегда на страже, готовая прийти на помощь. Почему стоит отложить все
                    сомнения и начать
                    сотрудничество с Bestlancer уже сейчас? Потому что мы верим, что поиск
                    талантов и работа с ними
                    должны приносить радость и удовлетворение. Присоединяйтесь к нам сегодня, и
                    позвольте вашему бизнесу
                    расправить крылья и взмыть на новые высоты успеха вместе с Bestlancer!
                </p>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/home/task_post.js" type="module"></script>
<script src="../page_js/home/scroll_home.js"></script>
<script src="../page_js/home/slider_home.js"></script>
<script src="../page_js/home/user_order_check.js"></script>
<script src="../page_js/home/star_system.js"></script>
<?php
function modal_ip_check()
{
    global $bd_connect;
    $moment_ip = $_SERVER['REMOTE_ADDR'];
    $ip_sql = "SELECT COUNT(*) FROM `user_registoring` WHERE `ip` = ?";
    $ip_stmt = mysqli_prepare($bd_connect, $ip_sql);
    mysqli_stmt_bind_param($ip_stmt, "s", $moment_ip);
    mysqli_stmt_execute($ip_stmt);
    $ip_result = mysqli_stmt_get_result($ip_stmt);
    return mysqli_num_rows($ip_result);
}
$modal_rendom = rand(1, 2);
if (modal_ip_check() == 0 || $modal_rendom == 1):
    ?>
    <script src="../page_js/home/bonus_modal.js"></script>
    <?php
endif;
?>
</body>

</html>