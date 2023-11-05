<?php
session_start();
include "../bd_send/database_connect.php";
$user_nik = $_SESSION["nik"];
if (!isset($user_nik)) {
    header("Location: home.php");
} else {
    //notification_clean
    $none_notification = mysqli_real_escape_string($bd_connect, 0);
    $none_notification_sql = "UPDATE `user_notification` SET `bell` = '$none_notification' WHERE `nik` = '$user_nik'";
    $none_notification_query = mysqli_query($bd_connect, $none_notification_sql);
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/notification_page.css'>";
echo "<title>Мои увидомления</title>";
include "../layouts/header_line.php";
?>
<div class="container notification_container">
    <div class="header">
        <div class="header_title">
            <h2>Мои увидомления</h2>
        </div>
        <div class="notifications">
            <?php
            $sql = "SELECT * FROM personal_orders WHERE order_nik = '$user_nik'";
            $query = mysqli_query($bd_connect, $sql);
            $notificationBlocks = array();

            while ($row = mysqli_fetch_assoc($query)) {
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $order_id = $row['id'];
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

                $notificationBlocks[] = '<div class="notification">
                    <div class="top_part">
                        <div class="user_notification">
                            <div class="img">
                                <img src="../bd_send/user/user_icons/' . $user_icon . '" alt="" draggable="false">
                            </div>
                            <div>
                            <a href="user_page.php?user_id=' . $user_id . '">' . $row['nik'] . '</a>
                            </div>
                        </div>
                        <div>
                            <h3>Личный заказ</h3>
                        </div>
                    </div>
                    <div class="main_notification">
                        <div>
                            <div>
                                <h4>' . $row['order_name'] . '</h4>
                            </div>
                            <div>
                                <p>' . $row['order_information'] . '</p>
                            </div>
                        </div>
                        <div class="order_files">
                            <div><h4>Файлы</h4></div>
                            <div class="files">
                                <a href="../bd_send/order/personal_order_files/' . $row['order_file'] . '" download>Скачать документ</a>
                            </div>
                        </div>
                        <div>
                            <div><a href=""><button>Взять задачу</button></a></div>
                            <div><a href="../bd_send/order/remove_personal_order.php?personal_order_id=' . $order_id . '"><button>Отказаться</button></a></div>
                        </div>
                    </div>
                </div>';
            }
            foreach (array_reverse($notificationBlocks) as $block) {
                echo $block;
            }
            ?>
            <?php
            $sql_response = "SELECT * FROM `orders_responses` WHERE orderer_nik = '$user_nik'";
            $query_response = mysqli_query($bd_connect, $sql_response);
            while ($row = mysqli_fetch_assoc($query_response)):
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $order_id = $row['id'];
                $nik = $row['nik'];
                //user_id
                $id_query = "SELECT id FROM `user_registoring` WHERE nik = '$nik'";
                $id_result = mysqli_query($connection, $id_query);
                $id_row = mysqli_fetch_assoc($id_result);
                $user_id = $id_row['id'];
                //user_icon
                $icon_query = "SELECT icon_path FROM `user_registoring` WHERE nik = '$nik'";
                $icon_resolt = mysqli_query($connection, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                mysqli_close($connection);
                ?>
                <div class="notification">
                    <div class="top_part">
                        <div class="user_notification">
                            <div class="img">
                                <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false">
                            </div>
                            <div>
                                <a href="order_page.php?order_id=<?= $row['order_id']; ?>"
                                    title="Заявка к заказу №<?= $row['order_id']; ?>">
                                    <?= $nik ?>
                                </a>
                            </div>
                        </div>
                        <div>
                            <h3>Отправил заявку</h3>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            ?>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/user/personal_order.js"></script>
<script src="../page_js/user/notification_length.js"></script>
</body>

</html>