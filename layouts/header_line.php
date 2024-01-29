</head>

<body>
    <?php
    include "modal/registor.php";
    include "modal/sing_in.php";
    include "../bd_send/database_connect.php";
    $currentURL = $_SERVER['REQUEST_URI'];

    $project_filter_resolt = "tasks.php";
    if (isset($_SESSION["nik"])) {
        include "modal/other.php";
        $my_nik = $_SESSION["nik"];
        $project_filter = "SELECT `filter` FROM `user_registoring` WHERE `nik` = '$my_nik'";
        $project_filter_query = mysqli_query($bd_connect, $project_filter);
        $project_filter_resolt = mysqli_fetch_assoc($project_filter_query)['filter'];
        if (empty($project_filter_resolt)) {
            $project_filter_resolt = "tasks.php";
        }
    }
    include "modal/modal_up.php";
    ?>
    <div class="header_line">
        <div class="line_wrapper">
            <div class="header_part header_part_one">
                <div class="">
                    <h1><a href="../pages/home.php">
                            <p>best</p>lancer
                        </a></h1>
                    <a href="../pages/home.php"><img src="../res/web_logo.png" alt="" class="logo_img"></a>
                </div>
                <?php
                if (strpos($currentURL, "registor") == false):
                ?>
                <div class="links">
                    <?php
                    $link_temp = -1;
                    $links_text = array("Заказы", "Фрилансеры", "Услуги", "Форум", "Новости");
                    $links_href = array("$project_filter_resolt", "#", "../pages/services.php", "#", "../pages/news.php");
                    foreach ($links_text as $link) {
                        $link_temp++;
                        echo "<a href='$links_href[$link_temp]'>$link</a>";
                    }
                    ?>
                </div>
                <?php
                endif;
                ?>
            </div>
            <div class="mobile_menu">
                <div class="img" onclick="menu_open()">
                    <img src="../res/burger_menu.png" alt="">
                </div>
                <div class="menu_sub">
                    <div class="cross" onclick="menu_close()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <style>
                                svg {
                                    fill: #d08e0b !important
                                }
                            </style>
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </div>
                    <?php
                    foreach ($links_text as $link) {
                        echo "<a href='$links_href[$link_temp]' class='mobile_links'>$link</a>";
                    }
                    if (!isset($_SESSION["nik"])) {
                        echo '<div class="buttons">
                                    <div class="registor" onclick="open_form_one()"><button>Регистрация</button></div>
                                    <div class="login" onclick="open_form_two()"><button>Вход</button></div>
                                </div>';
                    }
                    ?>
                </div>
            </div>

            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true):
                ?>
                <div class="user_panel">
                    <div class="user" title="Мой профиль" style="display: block;">
                        <a href="../pages/user.php">
                            <p class="user_name">
                                <?php
                                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                                    echo $_SESSION["nik"];
                                    $icon_path = $user_resolt["icon_path"];
                                } else {
                                    echo "Гость";
                                    $icon_path = "user.png";
                                }
                                ?>
                            </p>
                            <div class="img">
                                <img src="../bd_send/user/user_icons/<?= $icon_path ?>" alt="" draggable="false">
                            </div>
                        </a>
                    </div>
                    <?php
                    include "../bd_send/database_connect.php";
                    if (!isset($_SESSION["nik"])) {
                        $user_nik = "Гость";
                    } else {
                        $user_nik = $_SESSION["nik"];
                    }
                    $query = "SHOW TABLES LIKE 'notifications%'";
                    $result = mysqli_query($bd_connect, $query);
                    $none_notification = false;
                    if ($result) {
                        while ($row = mysqli_fetch_row($result)) {
                            $table_name = $row[0];
                            $count_query = "SELECT COUNT(*) AS total FROM $table_name WHERE order_nik = '$user_nik'";
                            $count_result = mysqli_query($bd_connect, $count_query);
                            $count_row = mysqli_fetch_assoc($count_result);
                            $total_rows = $count_row['total'];
                            if ($total_rows == 0) {
                                $none_notification = true;
                            }
                        }
                    }
                    //user_notification
                    $notification_temp = 0;
                    $notification_num = null;
                    $message_num = null;
                    $notification_sql = "SELECT * FROM `user_notification` WHERE `nik` = '$user_nik'";
                    $notification_query = mysqli_query($bd_connect, $notification_sql);
                    while ($notification_resolt = mysqli_fetch_assoc($notification_query)) {
                        $notification_temp++;
                        $message_num = (int) $notification_resolt['messages'];
                        $notification_num = (int) $notification_resolt['bell'];
                    }
                    ?>
                    <div class="messages notification" title="Чаты">
                        <?php
                        if ($message_num !== 0 && $message_num !== null):
                            if ($message_num >= 10) {
                                $message_num = "9+";
                            }
                            ?>
                            <div class="notification_number">
                                <span>
                                    <?= $message_num ?>
                                </span>
                            </div>
                            <?php
                        endif;
                        ?>
                        <a href="../pages/messages.php">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <style>
                                    svg {
                                        fill: #d08e0b
                                    }
                                </style>
                                <path
                                    d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                            </svg>
                        </a>
                    </div>
                    <div class="notification notification_sms">
                        <?php
                        if ($notification_num !== 0 && $notification_num !== null):
                            if ($notification_num >= 10) {
                                $notification_num = "9+";
                            }
                            ?>
                            <div class="notification_number">
                                <span>
                                    <?= $notification_num ?>
                                </span>
                            </div>
                            <?php
                        endif;
                        ?>
                        <a href="../pages/notification_page.php" title="Увидомления"><svg xmlns="http://www.w3.org/2000/svg"
                                height="1em"
                                viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <style>
                                    svg {
                                        fill: #d08e0b
                                    }
                                </style>
                                <path
                                    d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                            </svg></a>
                    </div>
                    <div class="accaunt_change" onclick="account_menu(this)" title="Прочее">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 128 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <style>
                                svg {
                                    fill: #d08e0b
                                }
                            </style>
                            <path
                                d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z" />
                        </svg>
                    </div>
                </div>
                <?php
            endif;
            if (!isset($_SESSION["nik"])):
                ?>
                <div class="header_part header_part_two">
                    <?php
                        if (strpos($currentURL, "registor") == false):
                    ?>
                    <div class="registor button" title="Пройдите регистрацию"><a
                            href="../pages/registor.php">Регистрация</a></div>
                    <?php
                        endif;
                    ?>
                    <div class="login button" onclick="open_form_two()" title="Зайдите в аккаунт">Вход</div>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>