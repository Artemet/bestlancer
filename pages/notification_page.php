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
            <div>
                <h2>Мои уведомления</h2>
            </div>
            <div class="notification_options">
                <div class="delite_number">
                    <p>Выбрано: <b>0</b></p>
                </div>
                <div class="delite_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="delite" height="1em"
                        viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z">
                        </path>
                    </svg>
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
                                        <a href="../bd_send/order/personal_order_files/<?= $row['order_file'] ?>"
                                            download>Скачать
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
                                        <a href="order_page.php?order_id=<?= $row['order_information'] ?>"
                                            title="Заявка к заказу №<?= $row['order_information'] ?>">
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