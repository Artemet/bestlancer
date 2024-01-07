<?php
session_start();
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/services.css'>";
echo "<link rel='stylesheet' href='../page_css/media/services_media.css'>";
echo "<title>Услуги фрилансеров</title>";
include "../layouts/header_line.php";
$category_arr = array("Дизайн", "Разработка и IT", "Тексты и переводы", "SEO и трафик", "Соцсети и реклама", "Аудио, видео, съемка", "Бизнес и жизнь", "Учеба и репетиторство");
?>
<div class="container">
    <div class="service_search">
        <div><input type="text" class="right_in" placeholder="Поиск"></div>
        <div><button>Поиск</button></div>
    </div>
    <div class="service_filter">
        <h4>Все услуги</h4>
        <div>
            <?php
            for ($i = 0; $i < count($category_arr); $i++){
                $category_value = $category_arr[$i];
                echo "<a href='?filter=$i' class='filter_link'><p>$category_value</p></a>";
            }
            ?>
        </div>
    </div>
    <div class="line" style="width: 100%;"></div>
    <div class="overlay">
        <div class="loader"></div>
    </div>
    <div class="service_container content">
        <?php
        include "../bd_send/database_connect.php";
        $sql = "SELECT * FROM `services`";
        function sql_convert(){
            global $sql;
            if (isset($_GET["filter"]) && is_numeric($_GET["filter"])){
                $filter_index = $_GET["filter"];
                $sql = "SELECT * FROM `services` WHERE `category` = $filter_index";
            }
        }
        sql_convert();
        $query = mysqli_query($bd_connect, $sql);
        $warning_tag = "<b>Нет услуг</b>";
        while ($row = mysqli_fetch_assoc($query)):
            $nik = $row['nik'];
            //user_icon
            $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
            $icon_resolt = mysqli_query($bd_connect, $icon_query);
            $icon_row = mysqli_fetch_assoc($icon_resolt);
            $user_icon = $icon_row['icon_path'];
            ?>
            <div class="service">
                <a href="service_page.php?service_id=<?= $row['id'] ?>">
                    <div class="img">
                        <img src="../bd_send/services/service_files/<?= $row['file_path'] ?>" alt="" class="services_image"
                            draggable="false">
                    </div>
                    <div class="service_information">
                        <div class="user_information">
                            <div>
                                <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false">
                            </div>
                            <b class="user_name">
                                <?= $nik ?>
                            </b>
                        </div>
                        <div class="under_line"></div>
                        <div>
                            <p class="category">
                                <?=$category_arr[$row['category']]?>
                            </p>
                        </div>
                        <div class="under_line"></div>
                        <div>
                            <span class="price">
                                <?= $row['price'] ?> ₽
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            <?php
            if (!empty($row['id'])) {
                $warning_tag = "";
            }
        endwhile;
        echo $warning_tag;
        ?>
    </div>
    <div class="line" style="width: 100%;"></div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/service/category_choice.js"></script>
</body>

</html>