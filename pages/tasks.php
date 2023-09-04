<?php
    session_start();
    $arr_temp = -1;
    include "../bd_send/database_connect.php";
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/tasks.css'>";
    echo "<link rel='stylesheet' href='../page_css/media/tasks_media.css'>";
    echo "<title>Биржа заказов</title>";
    include "../layouts/header_line.php";
    include "../layouts/modal/corect_order.php";
?>
<div class="tasks_container container">
    <div class="tasks">
        <div class="block_part make_order">
            <div class="wrapper">
                <div class="size"></div>
                <?php
                    if (!isset($_SESSION["nik"])){
                        echo '<div class="order_button" onclick="none_user_sing()">
                                <a href="make_order.php" class="none_sign order_page_link"><button>Разместить заказ</button></a>
                            </div>';
                    } else{
                        echo '<div class="order_button">
                                <a href="make_order.php" class="order_page_link"><button>Разместить заказ</button></a>
                            </div>';
                    }
                ?>
                <div>
                    <b class='filter_title'>Все заказы</b>
                    <div class="link_part">
                        <?php
                        $all_tasks = array("Администрирование сайтов", "Архитектура и Инжиниринг", "Аудио и Видео", "Веб-дизайн и Интерфейсы", "Веб-сайты", "Графика и Фотография", "Полиграфия и Айдентика", "Программирование ПО", "Продвижение сайтов (SEO)", "Тексты и Переводы", "Управление и Менеджмент", "Экономика и Право", "Без категорий");
                        foreach ($all_tasks as $all) {
                            $arr_temp++;
                            echo "<p>$all_tasks[$arr_temp]</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="no_orders">Нет заказов</p>
    <div class="orders">
        <?php
            $sql = "SELECT * FROM orders";
            $query = mysqli_query($bd_connect, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $nik = $row['nik'];
                //user_id
                $id_query = "SELECT id FROM user_registoring WHERE nik = '$nik'";
                $id_result = mysqli_query($connection, $id_query);
                $id_row = mysqli_fetch_assoc($id_result);
                $user_id = $id_row['id'];
                //user_icon
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                $icon_resolt = mysqli_query($connection, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                mysqli_close($connection);
                echo '
                        <div class="order">
                            <div class="order_part">
                                <a href="order_page.php?order_id=' . $row['id'] . '" class="order_page_link"><h3>' . $row["order_name"] . '</h3></a>
                                <p class="user_order_tz task_tag">' . $row['order_information'] . '</p>
                                <div class="user_information task_tag">
                                    <img src="../bd_send/user/user_icons/'. $user_icon .'" class="user_image" draggable="false">
                                    <a href="user_page.php?user_id=' . $user_id . '"><p>' . $row['nik'] . '</p></a>
                                </div>
                                <div class="payment task_tag"><p>Оплата:</p> <svg class="payed_false" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><style>svg{fill:#d08e0b}</style><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg></div>
                                <div class="category task_tag"><p>Категория: <b>' . $row['order_category'] . '</b></p></div>
                            </div>
                            <div class="price_part">
                                <p class="price">' . $row['order_price'] . '$</p>
                            </div>
                        </div>';
            }
        ?>
    </div>
</div>
<script src="../page_js/order/user_check.js"></script>
<script src="../page_js/order/order_quantity.js"></script>
<script src="../page_js/order/tz_length.js"></script>
<script src="../page_js/order/price_check.js"></script>
<script src="../page_js/order/task_category.js"></script>
<?php
include "../layouts/footer.php";
?>