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
            <h2>Мои уведомления</h2>
        </div>
        <div class="notifications">
            <?php
            $sql = "SELECT * FROM notifications WHERE order_nik = '$user_nik'";
            $query = mysqli_query($bd_connect, $sql);
            $notificationBlocks = array();

            while ($row = mysqli_fetch_assoc($query)):
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
                ?>
                <div class="notification" id="<?= $row['id'] ?>">
                    <div class="top_part">
                        <div class="user_notification">
                            <div class="img">
                                <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false">
                            </div>
                            <div>
                                <a href="user_page.php?user_id=<?= $user_id ?>">
                                    <?= $row['nik'] ?>
                                </a>
                            </div>
                        </div>
                        <div>
                            <?php
                            if ($row['type'] == 'personal') {
                                echo "<h3>Личный заказ</h3>";
                            } else {
                                echo "<h3>Приглашение в заказ</h3>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="main_notification">
                        <div>
                            <div>
                                <h4>
                                    <?= $row['order_name'] ?>
                                </h4>
                            </div>
                            <?php
                            if ($row['type'] == 'personal'):
                                ?>
                                <div>
                                    <p>
                                        <?= $row['order_information'] ?>
                                    </p>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                        <div class="order_files">
                            <div>
                                <h4>Файлы</h4>
                            </div>
                            <div class="files">
                                <a href="../bd_send/order/personal_order_files/<?= $row['order_file'] ?>" download>Скачать
                                    документ</a>
                            </div>
                        </div>
                        <div>
                            <?php
                            if ($row['type'] == 'personal') {
                                echo '<div><a href=""><button>Взять задачу</button></a></div>';
                            } else {
                                echo '<div><a href="order_page.php?order_id=' . $row['order_information'] . '"><button>Посмотреть заказ</button></a></div>';
                            }
                            ?>
                            <!-- ../bd_send/order/remove_personal_order.php?personal_order_id=<?= $order_id ?> -->
                            <div><button class="remove_order">Отказаться</button></div>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
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
            <script>
                let refusal_temp = 0;
                document.querySelectorAll("button.remove_order").forEach((item) => {
                    item.addEventListener("click", function () {
                        refusal_temp++;
                        const get_item_id = item.closest(".notification").id;
                        $.ajax({
                            url: "../bd_send/order/remove_personal_order.php?personal_order_id=" + get_item_id,
                        })
                            .done(function () {
                                item.closest(".notification").remove();
                                if (refusal_temp === 1) {
                                    setTimeout(() => {
                                        alert("Вы успешно отказались от заказа!");
                                    }, 500);
                                }
                            });
                    });
                });
            </script>
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