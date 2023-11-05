<?php
session_start();
include "../bd_send/database_connect.php";
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/order_information.css'>";
echo "<link rel='stylesheet' href='../page_css/my_orders.css'>";
echo "<title>Мои заказы</title>";
include "../layouts/header_line.php";
?>
<div class="my_orders order_information container">
    <div class="page_choice">
        <div>
            <a href="my_responses.php">Мои отклики</a>
            <div class="under_line"></div>
        </div>
        <div>
            <a href="my_orders.php" class="active">Мои заказы</a>
            <div class="under_line"></div>
        </div>
    </div>
    <div class="header">
        <div class="header_title">
            <h2>Мои заказы</h2>
        </div>
        <div class="orders">
            <?php
            $user_nik = $_SESSION["nik"];
            $order_temp = 0;
            $sql = "SELECT * FROM orders WHERE nik = '$user_nik'";
            $query = mysqli_query($bd_connect, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $order_temp++;
                $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                $order_id = $row['id'];
                echo '<div class="order">
                            <div>
                                <h3 title="перейти на страницу заказа"><a href="order_page.php?order_id=' . $order_id . '">' . $row['order_name'] . '</a></h3>
                            </div>
                            <div>
                                <p>' . $row['order_information'] . '</p>
                            </div>
                            <div class="price">';
                if ($row['order_price'] <= 0) {
                    echo '<p>Цена договорная</p>';
                } else {
                    echo '<span>' . $row['order_price'] . '$</span>';
                }
                echo '</div>
                        </div>';
            }
            if ($order_temp == 0) {
                echo "<p>Нет заказов</p>";
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