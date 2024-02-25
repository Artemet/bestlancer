<?php
session_start();
$account_login = FALSE;
$friend_find = false;
include "../bd_send/database_connect.php";
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/user.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/user_modal.css'>";
echo "<link rel='stylesheet' href='../local_css/modal_css/make_order.css'>";
echo "<link rel='stylesheet' href='../page_css/media/user_media.css'>";
echo "<link rel='stylesheet' href='../page_css/services.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/chat_start_modal.css'>";
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM `user_registoring` WHERE `id` = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($query);
    if ($stmt) {
        if (isset($_SESSION["nik"])) {
            if ($_SESSION["nik"] == $user["nik"]) {
                echo "<script>window.location.href = 'user.php';</script>";
            }
        }
        echo "<title>Профиль " . $user['nik'] . "</title>";
        include "../layouts/modal/personal_order.php";
        include "../layouts/modal/chat_start.php";
        include "../layouts/header_line.php";
    } else {
        echo "<link rel='stylesheet' href='../local_css/error.css'>";
        echo "<title>Пользователь не найден!</title>";
        include "../layouts/header_line.php";
        include "../bd_send/warnings/rong_user.php";
        exit;
    }
    $user_nik = $user['nik'];
    $user_email = $user["email"];
    $user_block_resolt = null;
    if (isset($_SESSION['nik'])) {
        $my_nik = $_SESSION["nik"];
        //friend_find
        $friend_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_two` = ? AND `nik_one` = ?)";
        $stmt = mysqli_prepare($bd_connect, $friend_sql);
        mysqli_stmt_bind_param($stmt, "ssss", $my_nik, $user_nik, $my_nik, $user_nik);
        mysqli_stmt_execute($stmt);
        $friend_query = mysqli_stmt_get_result($stmt);
        while ($friend_resolt = mysqli_fetch_assoc($friend_query)) {
            $friend_find = true;
        }
        //user_status
        if ($friend_find == true) {
            $status_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_two` = ? AND `nik_one` = ?)";
            $stmt = mysqli_prepare($bd_connect, $status_sql);
            mysqli_stmt_bind_param($stmt, "ssss", $my_nik, $user_nik, $my_nik, $user_nik);
            mysqli_stmt_execute($stmt);
            $status_query = mysqli_stmt_get_result($stmt);
            $status_resolt = mysqli_fetch_assoc($status_query)['status'];
            $user_block_resolt = mysqli_fetch_assoc($status_query)['main_block'];
        }
    }
} else {
    echo "<title>Пользователь не найден!</title>";
    exit;
}
?>
<div class="container">
    <div class="user_account">
        <div class="user_information other_account">
            <div class="img">
                <?php
                if ($friend_find == true) {
                    if ($user_block_resolt == $user_nik) {
                        echo '<img src="../bd_send/user/user_icons/user.png" alt="" draggable="false">';
                    } else {
                        echo '<img src="../bd_send/user/user_icons/' . $user['icon_path'] . '" alt="" draggable="false">';
                    }
                } else {
                    echo '<img src="../bd_send/user/user_icons/' . $user['icon_path'] . '" alt="" draggable="false">';
                }
                ?>
            </div>
            <?php
            $role_option = "seller";
            if ($user["role"] == "buyer") {
                $role_option = "buyer";
            }
            ?>
            <div class="information <?= $role_option ?>">
                <div class="name">
                    <p class="first_name">
                        <?php
                        echo $user['name'];
                        ?>
                    </p>
                    <p class="second_name">
                        <?php
                        echo $user['family'];
                        ?>
                    </p>
                    <span class="nik">
                        <?php
                        echo $user['nik'];
                        ?>
                    </span>
                </div>
                <div class="online_information">
                    <?php
                    $status_sql = "SELECT status FROM user_registoring WHERE nik = ?";
                    $status_query = mysqli_prepare($bd_connect, $status_sql);
                    mysqli_stmt_bind_param($status_query, "s", $user_nik);
                    mysqli_stmt_execute($status_query);
                    $result = mysqli_stmt_get_result($status_query);
                    $row = mysqli_fetch_assoc($result);
                    if (isset($_SESSION["nik"])) {
                        if ($friend_find == true) {
                            if ($user_block_resolt == $user_nik) {
                                echo '<div class="circle not_online"></div>
                                    <p>недоступен</p>';
                            } else {
                                if ($user['status'] == "online") {
                                    echo '<div class="circle online"></div>
                                    <p>в сети</p>';
                                } else {
                                    echo '<div class="circle not_online"></div>
                                    <p>не в сети</p>';
                                }
                            }
                        } else {
                            if ($user['status'] == "online") {
                                echo '<div class="circle online"></div>
                                <p>в сети</p>';
                            } else {
                                echo '<div class="circle not_online"></div>
                                <p>не в сети</p>';
                            }
                        }
                    } else {
                        if ($user['status'] == "online") {
                            echo '<div class="circle online"></div>
                            <p>в сети</p>';
                        } else {
                            echo '<div class="circle not_online"></div>
                            <p>не в сети</p>';
                        }
                    }
                    ?>
                </div>
                <u>
                    <?php
                    echo $user['country'];
                    ?>
                    /
                    <?php
                    echo $user['age'];
                    echo " лет";
                    ?>
                </u>
                <?php
                if ($user["role"] == "seller"):
                    ?>
                    <div>
                        <b>
                            <?php
                            echo $user['price'];
                            echo "₽ час";
                            ?>
                        </b>
                        /
                        <b>
                            <?php
                            echo "начало работы с ", "<span class='time'>", $user['work_time'], "</span>";
                            ?>
                        </b>
                    </div>
                    <?php
                    $level_count = 1;
                    $order_length = $user['orders'];
                    if ($order_length <= 3) {
                        $level_count = 1;
                    } elseif ($order_length <= 6) {
                        $level_count = 2;
                    } elseif ($order_length <= 11) {
                        $level_count = 3;
                    } elseif ($order_length <= 16) {
                        $level_count = 4;
                    } elseif ($order_length <= 21) {
                        $level_count = 5;
                    } elseif ($order_length <= 26) {
                        $level_count = 6;
                    } elseif ($order_length <= 31) {
                        $level_count = 7;
                    } elseif ($order_length <= 36) {
                        $level_count = 8;
                    } elseif ($order_length <= 41) {
                        $level_count = 9;
                    } elseif ($order_length <= 46) {
                        $level_count = 10;
                    } elseif ($order_length <= 51) {
                        $level_count = 11;
                    } elseif ($order_length <= 56) {
                        $level_count = 12;
                    } elseif ($order_length <= 61) {
                        $level_count = 13;
                    } elseif ($order_length <= 66) {
                        $level_count = 14;
                    } elseif ($order_length <= 71) {
                        $level_count = 15;
                    }
                    ?>
                    <div>
                        <b class="level">Уровень
                            <span>
                                <?= $level_count ?>
                            </span>
                        </b>
                        <div class="level_line">
                            <div class="level"></div>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <b class="reviews">
                    <?php
                    if ($role_option == "buyer") {
                        echo "<br>";
                    }
                    function review_length()
                    {
                        global $bd_connect, $user_email;
                        $length = 0;
                        $review_type = "user";
                        $review_sql = "SELECT * FROM `reviews` WHERE `email` = ? AND `type` = ?";
                        $review_stmt = mysqli_prepare($bd_connect, $review_sql);
                        mysqli_stmt_bind_param($review_stmt, "ss", $user_email, $review_type);
                        mysqli_stmt_execute($review_stmt);

                        $review_query = mysqli_stmt_get_result($review_stmt);
                        while (mysqli_fetch_assoc($review_query)) {
                            $length++;
                        }

                        if ($length == 0 || $length >= 10) {
                            return $length .= " отзывов";
                        } elseif ($length == 1) {
                            return $length .= " отзыв";
                        } elseif ($length >= 2) {
                            return $length .= " отзыва";
                        }
                    }
                    ?>
                    <?= review_length() ?>
                </b>
            </div>
            <?php
            if (isset($_SESSION["nik"])):
                ?>
                <div class="button_choice">
                    <?php
                    if ($friend_find == true) {
                        if ($user_block_resolt !== $user_nik) {
                            if ($user['role'] == 'seller') {
                                echo '<div><button class="personal_order">Предложить заказ</button></div>';
                            }
                        }
                    } else {
                        if ($user['role'] == 'seller') {
                            echo '<div><button class="personal_order">Предложить заказ</button></div>';
                        }
                    }
                    ?>
                    <?php
                    //block_button
                    if ($friend_find == false) {
                        echo '<div><button class="chat_start" title="Связаться с ' . $user_nik . '">Связаться</button></div>';
                    } else {
                        function chat_id_get()
                        {
                            global $bd_connect, $user_nik, $my_nik;
                            $chat_id_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND (`nik_one` = ? OR `nik_two` = ?)";
                            $stmt = mysqli_prepare($bd_connect, $chat_id_sql);
                            mysqli_stmt_bind_param($stmt, "ssss", $user_nik, $user_nik, $my_nik, $my_nik);
                            mysqli_stmt_execute($stmt);
                            $chat_id_query = mysqli_stmt_get_result($stmt);
                            return mysqli_fetch_assoc($chat_id_query)['chat_id'];
                        }
                        echo "<noscript class='chat_id'>" . chat_id_get() . "</noscript>";
                        echo '<div><a href="messages.php?chat_id=' . chat_id_get() . '"><button title="Открыть чат с ' . $user_nik . '" class="chat_button">Открыть чат</button></a></div>';
                    }
                    ?>
                    <?php
                    if ($friend_find == true):
                        //user_status
                        $status_text = "Заблокировать";
                        if ($status_resolt == "block") {
                            $status_text = "Разблокировать";
                        }
                        if ($user_block_resolt == $_SESSION["nik"] || empty($user_block_resolt)):
                            ?>
                            <div><button class="user_block block_button" title="Заблокировать <?= $user_nik ?>">
                                    <?= $status_text ?>
                                </button></div>
                            <script>
                                $('button.block_button').on('click', function () {
                                    if (this.innerHTML.trim() === 'Заблокировать') {
                                        this.innerHTML = 'Разблокировать';
                                        setTimeout(() => { alert("Вы зaблокировали пользователя <?= $user_nik ?>"); }, 500);
                                    } else {
                                        this.innerHTML = 'Заблокировать';
                                        setTimeout(() => { alert("Вы разблокировали пользователя <?= $user_nik ?>"); }, 500);
                                    }
                                    $.ajax({
                                        url: "../bd_send/user/user_block.php?user_id=<?= $user_id ?>",
                                    });
                                });
                            </script>
                            <?php
                        endif;
                    endif;
                    ?>
                </div>
                <?php
            endif;
            ?>
        </div>
        <div class="button_choice mobile_choice">
            <?php
            if ($friend_find == true) {
                if ($user_block_resolt == $user_nik) {
                    if ($user['role'] !== 'seller') {
                        echo '<div><button class="personal_order">Предложить заказ</button></div>';
                    }
                }
            } else {
                if ($user['role'] == 'seller') {
                    echo '<div><button class="personal_order">Предложить заказ</button></div>';
                }
            }
            ?>
            <div><button class="chat_start">Связаться</button></div>
        </div>
        <div class="user_work">
            <div>
                <span>--</span>
                <p>недостаточно оценок</p>
            </div>
            <div>
                <span>--</span>
                <p>недостаточно рекомендаций</p>
            </div>
            <div>
                <span>--</span>
                <p>средняя цена заказа</p>
            </div>
            <div>
                <span>--</span>
                <p>нет постоянных заказчиков</p>
            </div>
            <div>
                <span>--</span>
                <p>нет безопасных платежей</p>
            </div>
        </div>
        <div class="about_user user_block">
            <h2>Обо мне</h2>
            <div>
                <?php
                if (!empty($user["about"])) {
                    echo "<p>" . $user["about"] . "</p>";
                } else {
                    echo "<p class='no_information'>Нет информации</p>";
                }
                ?>
            </div>
        </div>
        <?php
        if ($user_block_resolt !== $user_nik):
            ?>
            <div class="user_skills menu_include user_block">
                <div class="menu_block">
                    <div>
                        <h2>Мои умения</h2>
                    </div>
                </div>
                <div class="skill_wrapper sub_menu">
                    <div class="include">
                        <?php
                        $skills = explode(" ", $user["skills"]);
                        if (!empty($user["skills"])) {
                            echo "<p class='skill_text'>";
                            foreach ($skills as $skill) {
                                echo "<span>$skill</span> ";
                            }
                            echo "</p>";
                        } else {
                            echo "<p class='no_information'>Нет информации</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="user_projects menu_include user_block">
                <div class="menu_block">
                    <div>
                        <h2>Мои проекты</h2>
                    </div>
                </div>
                <div class="projects_wrapper sub_menu">
                    <div class="include">
                        <div class="project_covers card_container">
                            <?php
                            $cover_temp = 0;
                            $cover_sql = "SELECT * FROM `project_cover` WHERE nik = ?";
                            $cover_query = mysqli_prepare($bd_connect, $cover_sql);
                            mysqli_stmt_bind_param($cover_query, "s", $user_nik);
                            mysqli_stmt_execute($cover_query);
                            $result = mysqli_stmt_get_result($cover_query);
                            while ($row = mysqli_fetch_assoc($result)):
                                $cover_temp++;
                                ?>
                                <a href='project_page.php?project_id=<?= $row['id'] ?>'>
                                    <div class="project">
                                        <div class="img">
                                            <img src="../bd_send/user/project_cover/<?= $row["cover_href"] ?>" alt=""
                                                draggable="false">
                                        </div>
                                        <div>
                                            <div class="user_information">
                                                <div>
                                                    <img src="../bd_send/user/user_icons/<?= $user['icon_path']; ?>" alt=""
                                                        draggable="false">
                                                </div>
                                                <b class="user_name">
                                                    <?= $row["nik"] ?>
                                                </b>
                                            </div>
                                        </div>
                                        <p class="date">
                                            <?= $row["date"] ?>
                                        </p>
                                    </div>
                                </a>
                                <?php
                            endwhile;
                            if ($cover_temp === 0) {
                                echo "<p class='no_project_text'>Нет проектов</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user_services user_block">
                <?php
                $nik = $user['nik'];

                $sql = "SELECT * FROM `services` WHERE `nik` = ?";
                $query = mysqli_prepare($bd_connect, $sql);
                mysqli_stmt_bind_param($query, "s", $nik);
                mysqli_stmt_execute($query);
                $resolt = mysqli_stmt_get_result($query);

                if (!$query) {
                    die("Query failed: " . mysqli_error($bd_connect));
                }

                if (mysqli_num_rows($resolt) > 0) {
                    echo '<div>
                        <h2>Мои услуги</h2>
                    </div>';
                    echo '<div class="service_container">';
                    while ($row = mysqli_fetch_assoc($resolt)) {
                        $service_nik = $row['nik'];
                        $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = ?";
                        $icon_stmt = mysqli_prepare($bd_connect, $icon_query);
                        mysqli_stmt_bind_param($icon_stmt, "s", $service_nik);
                        $icon_resolt = mysqli_stmt_execute($icon_stmt);

                        if (!$icon_result) {
                            die("Query failed: " . mysqli_error($bd_connect));
                        }

                        $icon_information = mysqli_stmt_get_result($icon_stmt);
                        $icon_row = mysqli_fetch_assoc($icon_information);
                        $user_icon = $icon_row['icon_path'];

                        echo '
                        <div class="service">
                            <a href="service_page.php?service_id=' . $row['id'] . '">
                                <div class="img">
                                    <img src="../bd_send/services/service_files/' . $row['file_path'] . '" alt="" class="services_image" draggable="false">
                                </div>
                                <div class="service_information">
                                    <div class="user_information">
                                        <div>
                                            <img src="../bd_send/user/user_icons/' . $user_icon . '" alt="" draggable="false">
                                        </div>
                                        <b class="user_name">' . $service_nik . '</b>
                                    </div>
                                    <div>
                                        <p class="category">' . $row['category'] . '</p>
                                    </div>
                                    <div class="under_line"></div>
                                    <div>
                                        <span class="price">' . $row['price'] . '₽</span>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    }
                    echo '</div>';
                } else {
                    echo '';
                }
                ?>
            </div>
            <?php
            function review_check()
            {
                global $bd_connect, $user_email;
                $review_include = false;
                $review_type = "user";
                $review_sql = "SELECT * FROM `reviews` WHERE `email` = ? AND `type` = ?";
                $stmt = mysqli_prepare($bd_connect, $review_sql);
                mysqli_stmt_bind_param($stmt, "ss", $user_email, $review_type);
                mysqli_stmt_execute($stmt);
                $review_query = mysqli_stmt_get_result($stmt);
                while (mysqli_fetch_assoc($review_query)) {
                    $review_include = true;
                }
                return $review_include;
            }
            if (review_check() == true):
                ?>
                <div class="user_reviews user_block">
                    <h2>Мои отзывы</h2>
                    <div class="reviews_wrapper">
                        <?php
                        $review_type = "user";
                        $review_sql = "SELECT * FROM `reviews` WHERE `email` = ? AND `type` = ?";
                        $review_stmt = mysqli_prepare($bd_connect, $review_sql);
                        mysqli_stmt_bind_param($review_stmt, "ss", $user_email, $review_type);
                        mysqli_stmt_execute($review_stmt);
                        $review_query = mysqli_stmt_get_result($review_stmt);
                        function buyer_bd($buyer_nik, $table)
                        {
                            global $bd_connect;
                            $user_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
                            $stmt = mysqli_prepare($bd_connect, $user_sql);
                            mysqli_stmt_bind_param($stmt, "s", $buyer_nik);
                            mysqli_stmt_execute($stmt);
                            $user_query = mysqli_stmt_get_result($stmt);
                            $user_row = mysqli_fetch_assoc($user_query);
                            return $user_row[$table];
                        }
                        while ($review_resolt = mysqli_fetch_assoc($review_query)):
                            ?>
                            <div class="review ">
                                <div class="review_user">
                                    <div class="user_icon">
                                        <img src="../bd_send/user/user_icons/<?= buyer_bd($review_resolt['nik'], 'icon_path') ?>"
                                            alt="" draggable="false">
                                    </div>
                                    <div>
                                        <p class="name">
                                            <?= buyer_bd($review_resolt['nik'], 'name') ?>
                                            <?= buyer_bd($review_resolt['nik'], 'family') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="review_date">
                                    <p>
                                        <?= $review_resolt['date'] ?>
                                    </p>
                                </div>
                                <div class="review_part">
                                    <p>
                                        <?= $review_resolt['review'] ?>
                                    </p>
                                </div>
                                <div class="line line_no_animation" style="width:100%; background: rgb(79, 130, 3);"></div>
                                <div class="review_quality">
                                    <?php
                                    if ($review_resolt["star"] == 0):
                                        ?>
                                        <div class="circle good"></div>
                                        <div>
                                            <p>Позитивный</p>
                                        </div>
                                        <?php
                                    endif;
                                    if ($review_resolt["star"] == 1):
                                        ?>
                                        <div class="circle bad"></div>
                                        <div>
                                            <p>Негативный</p>
                                        </div>
                                        <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                </div>
                <?php
            endif;
        endif;
        ?>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/user/edit_menu.js"></script>
<script src="../page_js/user/change_profile.js"></script>
<script src="../page_js/user/option_script.js"></script>
<script src="../page_js/user/time_script.js"></script>
<?php
if ($user['role'] == "seller") {
    echo '<script src="../page_js/user/order_modal.js"></script>';
}
?>
<script src="../page_js/user/chat_modal.js"></script>
</body>

</html>