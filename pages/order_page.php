<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    session_start();
    $user_order = FALSE;
    include "../bd_send/database_connect.php";
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/order_page.css'>";
    include "../layouts/modal/change_information.php";

    if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $sql = "SELECT * FROM orders WHERE id = $order_id";
        $query = mysqli_query($bd_connect, $sql);
        $order = mysqli_fetch_assoc($query);

        if ($order) {
            $pageTitle = $order['order_name'];
        } else {
            echo "<link rel='stylesheet' href='../local_css/error.css'>";
            echo "<title>Заказ не найден</title>";
            include "../bd_send/warnings/rong_order.php";
            exit;
        }
    } else {
        exit;
    }
    echo "<title>$pageTitle</title>";

    $row = mysqli_fetch_assoc($query);
    include "../layouts/header_line.php";
?>
<div class="order_page container">
    <div class="header">
        <div class="header_title">
            <div class="header_wrapper">
                <?php
                    //icon_connect
                    $query = mysqli_query($bd_connect, $sql);
                    $row = mysqli_fetch_assoc($query);
                    $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                    $nik = $row['nik'];
                    $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                    $icon_resolt = mysqli_query($connection, $icon_query);
                    $icon_row = mysqli_fetch_assoc($icon_resolt);
                    $user_icon = $icon_row['icon_path'];
                    mysqli_close($connection);
                ?>
                <div class="user_information">
                    <div><img src="../bd_send/user/user_icons/<?=$user_icon?>" alt="" draggable="false"></div>
                    <div>
                    <?php
                        $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                        $nik = $order['nik'];
                        $query = "SELECT id FROM user_registoring WHERE nik = '$nik'";
                        $result = mysqli_query($connection, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                        }
                        echo '<a href="user_page.php?user_id='.$row['id'].'">'. $order['nik'] .'</a>';
                        mysqli_close($connection);
                    ?>
                    </div>
                </div>
                <?php
                    $nik = $_SESSION["nik"];
                    $order_name = $order['order_name'];
                    $sql = "SELECT * FROM orders_responses";
                    $query = mysqli_query($bd_connect, $sql);
                    if ($order['nik'] === $nik){
                        $user_order = TRUE;
                    } else{
                        $user_order = FALSE;
                    }
                    if ($user_order === FALSE){
                        echo '<div class="button_choice">
                                <div>
                                    <a href="make_application.php?order_id='.$order_id.'"><button>Добавить заявку</button></a>
                                </div>
                                <div><a href=""><button>Тарифный план</button></a></div>
                        </div>';
                    }
                ?>
            </div>
            <h2>
                <?= $order['order_name'] ?>
            </h2>
        </div>
        <p class="order_information">
            <?= $order['order_information'] ?>
        </p>
        <?php if (!empty($order['file_path'])): ?>
            <div class="files">
                <a href="../bd_send/order/order_files/<?= $order['file_path'] ?>" title="<?= $order['file_path'] ?>" download>Скачать документ</a>
            </div>
        <?php endif; ?>
        <div class="price">
            <span>
                <b class="order_price">
                    <?= $order['order_price'] ?>
                </b>
                <b>$</b>
            </span>
        </div>
    </div>
    <div class="line" style="width: 80%"></div>
    <div class="users_applications">
        <div class="application_number_wrapper">
            <div><h2>Заяки фрилансеров</h2></div>
            <div class="application_number"><span>0</span></div>
        </div>
        <div class="applications">
            <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                    $nik = $row['nik'];
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
                    if ($row['order_name'] === $order_name) {
                        if ($user_order === TRUE) {
                            echo '
                                <div class="application user_order">
                                    <div class="application_part">
                                        <div><img src="../bd_send/user/user_icons/'. $user_icon .'" alt="" draggable="false"></div>
                                        <div>
                                            <a href="user_page.php?user_id=' . $user_id . '">' . $row["nik"] . '</a>
                                        </div>
                                        <div class="arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="sub_information">
                                        <div class="part_one">
                                            <div><p>' . $row["user_message"] . '</p></div>
                                            <div><span>' . $row["price"] . '$</span></div>
                                        </div>
                                        <div class="part_two">
                                            <div><p>' . $row["time"] . ' дня</p></div>
                                            <div><p>' . $row["payment_option"] . '</p></div>
                                            <div class="button_option">
                                                <button>Назначить исполнителем</button>
                                                <button>Связаться с исполнителем</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        } else {

                            echo '
                                <div class="application">
                                    <div class="application_part">
                                        <div><img src="../bd_send/user/user_icons/'. $user_icon .'" alt="" draggable="false"></div>
                                        <div>
                                            <a href="user_page.php?user_id=' . $user_id . '">' . $row["nik"] . '</a>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>
<script src="../page_js/order/account_check.js"></script>
<script src="../page_js/order/order_price_check.js"></script>
<script src="../page_js/order/application_number.js"></script>
<?php
    if ($user_order === TRUE){
        echo '<script src="../page_js/order/application_menu.js"></script>';
    }
    include "../layouts/footer.php";
?>