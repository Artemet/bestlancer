<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/basket.css'>";
echo "<title>Моя корзина</title>";
include "../layouts/header_line.php";
?>
<div class="container">
    <div class="header">
        <div class="header_title">
            <h2>Моя корзина</h2>
        </div>
        <div class="basket_wrapper">
            <?php
            $user_nik = $_SESSION["nik"];
            $sql = "SELECT * FROM basket WHERE nik = '$user_nik'";
            $query = mysqli_query($bd_connect, $sql);
            $basket_length = 0;
            while ($row = mysqli_fetch_assoc($query)) {
                $basket_length++;
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $author_nik = $row['author_nik'];
                //users_icons
                $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$author_nik'";
                $icon_resolt = mysqli_query($connection, $icon_query);
                $icon_row = mysqli_fetch_assoc($icon_resolt);
                $user_icon = $icon_row['icon_path'];
                mysqli_close($connection);
                echo '<div class="basket_product">
                            <div class="cross" title="Удалить из корзины"><a href="../bd_send/user/basket_remove.php?basket_service_id=' . $row['service_id'] . '"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></a></div>
                            <div class="product_information">
                                <div class="delite_icon"></div>
                                <div class="img">
                                    <img src="../bd_send/user/user_icons/' . $user_icon . '" alt="" draggable="false">
                                </div>
                                <div>
                                    <a href="service_page.php?service_id=' . $row['service_id'] . '"><b>' . $row['product_name'] . '</b></a>
                                </div>
                            </div>
                            <div>
                                <a href="" title="Заказать услугу"><button>Заказать</button></a>
                            </div>
                        </div>';
            }
            if ($basket_length == 0) {
                echo "<div class='none_product_wrapper'><b class='none_product'>Корзина пустая</b></div>";
            }
            ?>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
</body>

</html>