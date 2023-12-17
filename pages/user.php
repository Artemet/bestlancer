<?php
session_start();
include "../bd_send/database_connect.php";
if (!isset($_SESSION['nik'])) {
    header("Location: home.php");
    exit;
}
$user_nik = $_SESSION["nik"];
$user_id = $_SESSION["id"];

include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/user.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/user_modal.css'>";
echo "<link rel='stylesheet' href='../page_css/media/user_media.css'>";
echo "<link rel='stylesheet' href='../page_css/services.css'>";
echo "<title>Мой профиль</title>";
include "../layouts/modal/change_information.php";
include "../layouts/header_line.php";
?>
<div class="container">
    <div class="user_account">
        <div class="account_redactor mobile_redactor">
            <button onclick="sub_choice()">Редактировать профель <div class="arrow">&#9660;</div></button>
            <div class="sub_menu">
                <div class="menu_wrapper">
                    <p onclick="change_information(this)">Изменить информацию о себе</p>
                    <a href="add_project.php">
                        <p>Добавить работы в портфолио</p>
                    </a>
                    <a href="make_services.php">
                        <p>Добавить свою услугу</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="user_information">
            <div class="img">
                <img src="../bd_send/user/user_icons/<?= $user_resolt["icon_path"]; ?>" alt="" draggable="false">
            </div>
            <div class="information">
                <div class="name">
                    <p class="first_name">
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            echo $_SESSION["name"]; // Отобразить имя пользователя, если вход выполнен
                        } else {
                            echo "Гость"; // Отобразить "Гость", если вход не выполнен
                        }
                        ?>
                    </p>
                    <p class="second_name">
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            echo $_SESSION["family"]; // Отобразить имя пользователя, если вход выполнен
                        } else {
                            echo ""; // Отобразить "Гость", если вход не выполнен
                        }
                        ?>
                    </p>
                    <span class="nik">
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            echo $_SESSION["nik"]; // Показывать логин пользователя, если вход выполнен
                        } else {
                            echo ""; // Показывать "Гость", если вход не выполнен
                        }
                        ?>
                    </span>
                </div>
                <u>
                    <?php
                    echo $user_resolt["country"];
                    ?>
                    /
                    <?php
                    echo $user_resolt["age"];
                    ?>
                    лет
                </u>
                <?php
                if ($user_resolt == "seller"):
                    ?>
                    <div class="main_information">
                        <b>
                            <?php
                            echo $user_resolt["price"], "$ час";
                            ?>
                        </b>
                        /
                        <b>
                            <?php
                            echo "начало работы с ", "<span class='time'>", $user_resolt["work_time"], "</span>";
                            ?>
                        </b>
                    </div>
                    <div>
                        <b class="level">Уровень 1</b>
                        <div class="level_line">
                            <div class="level"></div>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <b class="reviews">0 отзывов</b>
            </div>
            <div class="account_redactor">
                <button onclick="sub_choice()">Редактировать профиль <div class="arrow">&#9660;</div></button>
                <div class="sub_menu">
                    <p onclick="change_information(this)">Изменить информацию о себе</p>
                    <?php
                    if ($user_resolt["role"] == "seller"):
                        ?>
                        <a href="add_project.php">
                            <p>Добавить работы в портфолио</p>
                        </a>
                        <a href="make_services.php">
                            <p>Добавить свою услугу</p>
                        </a>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
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
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        echo $user_resolt["about"]; // Показывать логин пользователя, если вход выполнен
                    } else {
                        echo "нет информации"; // Показывать "Гость", если вход не выполнен
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class="user_skills menu_include user_block">
            <div class="menu_block">
                <div>
                    <h2>Мои умения</h2>
                </div>
            </div>
            <div class="skill_wrapper sub_menu">
                <div class="include">
                    <p class="skill_text">
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            $skills = explode(" ", $user_resolt["skills"]);
                            foreach ($skills as $skill) {
                                echo "<span>$skill</span> ";
                            }
                        } else {
                            echo "нет информации";
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
                    <div class="project_covers card_container">
                        <?php
                        $project_temp = 0;
                        $cover_sql = "SELECT * FROM `project_cover` WHERE nik = '$user_nik'";
                        $cover_query = mysqli_query($bd_connect, $cover_sql);
                        while ($row = mysqli_fetch_assoc($cover_query)):
                            $project_temp++;
                            $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                            ?>
                            <a href="project_page.php?project_id=<?= $row['id'] ?>" id="<?= $row['id'] ?>">
                                <div class="project">
                                    <div class="img">
                                        <img src="../bd_send/user/project_cover/<?= $row["cover_href"] ?>" alt=""
                                            draggable="false">
                                    </div>
                                    <div>
                                        <div class="user_information">
                                            <div>
                                                <img src="../bd_send/user/user_icons/<?= $user_resolt["icon_path"] ?>"
                                                    alt="" draggable="false">
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
                        if ($project_temp === 0 && $user_resolt["role"] == "buyer") {
                            echo "Нет проектов";
                        }
                        if ($user_resolt["role"] !== "buyer"):
                            ?>
                            <a href="add_project.php" title="Добавить проект" class="add_project_link">
                                <div class="project add_project">
                                    <div class="plus"><b>+</b></div>
                                </div>
                            </a>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="user_services user_block">
            <div>
                <h2>Мои услуги</h2>
            </div>
            <div class="service_container card_container">
                <?php
                $nik = $_SESSION['nik'];

                $sql = "SELECT * FROM services WHERE nik = '$nik'";
                $query = mysqli_query($bd_connect, $sql);

                if (!$query) {
                    die("Query failed: " . mysqli_error($bd_connect));
                }

                if (mysqli_num_rows($query) > 0) {
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

                        echo '<div class="service">
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
                } else {
                    echo '<a href="make_services.php" class="make_service" title="Создать свою услугу">Создать услугу</a>';
                }

                mysqli_close($bd_connect);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/user/edit_menu.js"></script>
<script src="../page_js/user/change_profile.js"></script>
<script src="../page_js/user/option_script.js"></script>
<script src="../page_js/user/time_script.js"></script>
<script src="../page_js/user/modal_information.js"></script>
<script src="../page_js/user/project/project_page.js"></script>
<script src="../page_js/user/icon_store.js"></script>
</body>

</html>