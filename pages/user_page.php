<?php
    session_start();
    $account_login = FALSE;
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
        $sql = "SELECT * FROM user_registoring WHERE id = $user_id";
        $query = mysqli_query($bd_connect, $sql);
        $user = mysqli_fetch_assoc($query);
        if ($user) {
            if ($_SESSION["nik"] === $user["nik"]){
                header("Location: user.php");
            }
            echo "<title>Профиль " . $user['nik'] . "</title>";
            include "../layouts/modal/change_information.php";
            include "../layouts/modal/personal_order.php";
            include "../layouts/modal/chat_start.php";
            include "../layouts/header_line.php";
        } else {
            echo "<link rel='stylesheet' href='../local_css/error.css'>";
            echo "<title>Пользователь не найден!</title>";
            include "../layouts/header_line.php";
            include "../bd_send/warnings/rong_user.php";
            exit();
        }
    } else {
        echo "<title>Пользователь не найден!</title>";
        exit();
    }
?>
<div class="container">
<div class="user_account">
    <div class="user_information other_account">
        <div class="img">
            <img src="../bd_send/user/user_icons/<?=$user['icon_path'];?>" alt="" draggable="false">
        </div>
        <div class="information">
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
                $user_nik = $user['nik'];
                $status_sql = "SELECT status FROM user_registoring WHERE nik = ?";
                $status_query = mysqli_prepare($bd_connect, $status_sql);
                mysqli_stmt_bind_param($status_query, "s", $user_nik);
                mysqli_stmt_execute($status_query);
                $result = mysqli_stmt_get_result($status_query);
                $row = mysqli_fetch_assoc($result);
                if ($row['status'] == "online") {
                    echo '<div class="circle online"></div>
                    <p>в сети</p>';
                } else{
                    echo '<div class="circle not_online"></div>
                    <p>не в сети</p>';
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
            <div>
                <b>
                    <?php
                        echo $user['price'];
                        echo "$ час";
                    ?>
                </b>
                /
                <b>
                    <?php
                        echo "начало работы с ", "<span class='time'>", $user['work_time'], "</span>";
                    ?>
                </b>
            </div>
            <div>
                <b class="level">Уровень 1</b>
                <div class="level_line"><div class="level"></div></div>
            </div>
            <b class="reviews">0 отзывов</b>
        </div>
        <?php
            if (isset($_SESSION["nik"])){
                $account_login = TRUE;
                $nik = $_SESSION["nik"];
                $message_user_sql = "SELECT * FROM messenger_users WHERE nik_one = '$nik' OR nik_two = '$nik'";
                $message_user_query = mysqli_query($bd_connect, $message_user_sql);
                $choice_html = '<div class="button_choice"><div><button class="personal_order">Предложить заказ</button></div><div><button class="chat_start">Связаться</button></div></div>';
                while ($message_user_row = mysqli_fetch_assoc($message_user_query)){
                    if ($message_user_row['nik_one'] == $user['nik'] || $message_user_row['nik_two'] == $user['nik']){
                        $choice_html = '<div class="button_choice"><div><button class="personal_order">Предложить заказ</button></div></div>';
                    }
                }
                echo $choice_html;
            }
        ?>
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
            <p>
                <?php
                    echo $user['about'];
                ?>
            </p>
        </div>
    </div>
    <div class="user_skills menu_include user_block">
        <div class="menu_block">
            <div>
                <h2>Мои умения</h2>
            </div>
            <div><img src="../res/burger_menu2.png" alt="" draggable="false" class="burger_menu"></div>
        </div>
        <div class="skill_wrapper sub_menu">
            <div class="include">
                <p class="skill_text">
                    <?php
                        $skills = explode(" ", $user['skills']);
                        foreach ($skills as $skill) {
                            echo "<span>$skill</span> ";
                        }
                    ?>
                </p>
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
                <p class="project_text">
                    <?php
                        $projects = explode(" ", $user['projects']); // Разбить строку на массив по пробелам
                        foreach ($projects as $projects) {
                            echo "<a href='$projects' target='_blank'><span>$projects</span></a> "; // Поместить каждый элемент массива в отдельный тег <span>
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="user_services user_block">
        <?php
            $nik = $user['nik'];

            $bd_connect = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);

            if (!$bd_connect) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM services WHERE nik = '$nik'";
            $query = mysqli_query($bd_connect, $sql);

            if (!$query) {
                die("Query failed: " . mysqli_error($bd_connect));
            }

            if (mysqli_num_rows($query) > 0) {
                echo '<div>
                        <h2>Мои услуги</h2>
                    </div>';
                echo '<div class="service_container">';
                while ($row = mysqli_fetch_assoc($query)) {
                    $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                    $service_nik = $row['nik'];
                    $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$service_nik'";
                    $icon_result = mysqli_query($connection, $icon_query);

                    if (!$icon_result) {
                        die("Query failed: " . mysqli_error($connection));
                    }

                    $icon_row = mysqli_fetch_assoc($icon_result);
                    $user_icon = $icon_row['icon_path'];
                    mysqli_close($connection);

                    echo '
                        <div class="service">
                            <a href="service_page.php?service_id='.$row['id'].'">
                                <div class="img">
                                    <img src="../bd_send/services/service_files/'.$row['file_path'].'" alt="" class="services_image" draggable="false">
                                </div>
                                <div class="service_information">
                                    <div class="user_information">
                                        <div>
                                            <img src="../bd_send/user/user_icons/'. $user_icon .'" alt="" draggable="false">
                                        </div>
                                        <b class="user_name">'.$service_nik.'</b>
                                    </div>
                                    <div>
                                        <p class="category">'.$row['category'].'</p>
                                    </div>
                                    <div class="under_line"></div>
                                    <div>
                                        <span class="price">'.$row['price'].'$</span>
                                    </div>
                                </div>
                            </a>
                        </div>';
                }
                echo '</div>';
            } else {
                echo '';
            }
            mysqli_close($bd_connect);
        ?>
</div>
</div>
</div>
<script src="../page_js/user/edit_menu.js"></script>
<script src="../page_js/user/change_profile.js"></script>
<script src="../page_js/user/option_script.js"></script>
<script src="../page_js/user/menu.js"></script>
<script src="../page_js/user/time_script.js"></script>
<?php
    if ($account_login === TRUE){
        echo '<script src="../page_js/user/order_modal.js"></script>';
        echo '<script src="../page_js/user/chat_modal.js"></script>';
    }
    include "../layouts/footer.php";
?>