<?php
    session_start();
    if (!isset($_SESSION["nik"])){
        //header("Location: home.php");
    } 
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/services.css'>";
    echo "<link rel='stylesheet' href='../page_css/media/services_media.css'>";
    echo "<title>Услуги фрилансеров</title>";
    include "../layouts/header_line.php";
?>
<div class="container">
    <div class="service_filter">
        <h4>Все услуги</h4>
        <div>
            <p>Администрирование сайтов</p>
            <p>Архитектура и Инжиниринг</p>
            <p>Аудио и Видео</p>
            <p>Веб-дизайн и Интерфейсы</p>
            <p>Веб-сайты</p>
            <p>Графика и Фотография</p>
            <p>Полиграфия и Айдентика</p>
            <p>Программирование ПО</p>
            <p>Продвижение сайтов (SEO)</p>
            <p>Тексты и Переводы</p>
            <p>Управление и Менеджмент</p>
            <p>Экономика и Право</p>
            <p>Без категорий</p>
        </div>
    </div>
    <div class="line" style="width: 100%;"></div>
    <div class="service_container">
        <?php
            include "../bd_send/database_connect.php";
            $sql = "SELECT * FROM services";
            $query = mysqli_query($bd_connect, $sql);
            $warning_tag = "<b>Нет услуг</b>";
            while ($row = mysqli_fetch_assoc($query)) {
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $nik = $row['nik'];
                //user_icon
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                $icon_resolt = mysqli_query($connection, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                mysqli_close($connection);
                echo '<div class="service">
                        <a href="service_page.php?service_id='.$row['id'].'">
                            <div class="img">
                                <img src="../bd_send/services/service_files/'.$row['file_path'].'" alt="" class="services_image" draggable="false">
                            </div>
                            <div class="service_information">
                                <div class="user_information">
                                    <div>
                                        <img src="../bd_send/user/user_icons/'. $user_icon .'" alt="" draggable="false">
                                    </div>
                                    <b class="user_name">'.$nik.'</b>
                                </div>
                                <div class="under_line"></div>
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
                if (!empty($row['id'])){
                    $warning_tag = "";
                }
            }
            echo $warning_tag;
        ?>
    </div>
    <div class="line" style="width: 100%;"></div>
</div>
<?php
    include "../layouts/footer.php";
?>