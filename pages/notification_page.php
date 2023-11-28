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
            <div><h2>Мои уведомления</h2></div>
            <div class="notification_options">
                <div class="delite_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M49.7 32c-10.5 0-19.8 6.9-22.9 16.9L.9 133c-.6 2-.9 4.1-.9 6.1C0 150.7 9.3 160 20.9 160h94L140.5 32H49.7zM272 160V32H173.1L147.5 160H272zm32 0H428.5L402.9 32H304V160zm157.1 0h94c11.5 0 20.9-9.3 20.9-20.9c0-2.1-.3-4.1-.9-6.1L549.2 48.9C546.1 38.9 536.8 32 526.3 32H435.5l25.6 128zM32 192l4 32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H44L64 448c0 17.7 14.3 32 32 32s32-14.3 32-32H448c0 17.7 14.3 32 32 32s32-14.3 32-32l20-160h12c17.7 0 32-14.3 32-32s-14.3-32-32-32h-4l4-32H32z"/></svg>
                </div>
            </div>
        </div>
        <div class="notifications">
            <?php
            $sql = "SELECT * FROM `notifications` WHERE `order_nik` = '$user_nik'";
            $query = mysqli_query($bd_connect, $sql);
            $notificationBlocks = array();

            while ($row = mysqli_fetch_assoc($query)):
                $order_id = $row['id'];
                $nik = $row['nik'];
                $order_type = $row['type'];

                //user_id
                $id_query = "SELECT id FROM user_registoring WHERE nik = '$nik'";
                $id_result = mysqli_query($bd_connect, $id_query);
                $id_row = mysqli_fetch_assoc($id_result);
                $user_id = $id_row['id'];

                //user_icon
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                $icon_resolt = mysqli_query($bd_connect, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];

                if ($order_type == 'invite' || $order_type == 'personal'):
                ?>
                <div class="notification" id="<?= $row['id'] ?>">
                    <div class="notification_wrapper">
                        <input type="checkbox" class="checkbox">
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
                </div>
                <?php
                endif;
                if ($order_type == 'application'):
                ?>
                <div class="notification">
                    <div class="notification_wrapper">
                        <input type="checkbox" class="checkbox">
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
                </div>
                <?php
                endif;
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
<script src="../page_js/notification/icon_choice.js"></script>
</body>

</html>