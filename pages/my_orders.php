<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
}
include "../bd_send/database_connect.php";
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/order_information.css'>";
echo "<link rel='stylesheet' href='../page_css/my_orders.css'>";
echo "<link rel='stylesheet' href='../page_css/media/my_orders_media.css'>";
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
    <div class="mobile_page_choice">
        <div><a href="my_responses.php">Мои отклики</a></div>
        <div><a href="my_orders.php">Мои заказы</a></div>
    </div>
    <div class="header">
        <div class="header_title">
            <h2>Мои заказы</h2>
            <div class="loading_line"></div>
        </div>
        <div class="content">
            <div class="orders">
                <?php
                $user_nik = $_SESSION["nik"];
                $order_temp = 0;
                $orders_per_page = 8;
                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

                $start_from = ($page - 1) * $orders_per_page;

                $sql = "SELECT * FROM orders WHERE nik = ? ORDER BY id DESC LIMIT ?, ?";
                $stmt = mysqli_prepare($bd_connect, $sql);
                mysqli_stmt_bind_param($stmt, "sii", $user_nik, $start_from, $orders_per_page);
                mysqli_stmt_execute($stmt);
                $query = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($query)):
                    $order_temp++;
                    $order_class = null;
                    $order_id = $row['id'];

                    //order_time
                    $date = date("Y.m.d");
                    $date_resolt = null;
                    list($year, $month, $day) = explode(".", $date);
                    $date_array = array($year, $month, $day);
                    for ($i = 0; $i < count($date_array); $i++) {
                        if ($i >= 1) {
                            $date_resolt .= ".";
                        }
                        $date_resolt .= $date_array[$i];
                    }

                    //order_progress
                    if ($row['progress'] == 2) {
                        $order_class = "active_order";
                    }
                    ?>
                    <div class="order <?= $order_class ?>">
                        <?php
                        if ($row['date'] == $date):
                            ?>
                            <div class="new_cover">
                                <p>НОВЫЙ</p>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div>
                            <h3 title="перейти на страницу заказа">
                                <a href="order_page.php?order_id=<?= $order_id ?>">
                                    <?= $row['order_name'] ?>
                                </a>
                            </h3>
                            <?php
                            if ($row['progress'] == 2):
                                ?>
                                <div class="progress_link">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path
                                                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <a href="order_progress.php?order_id=<?= $order_id ?>">Заказ №
                                            <?= $row['id'] ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                        <div>
                            <p>
                                <?= $row['order_information'] ?>
                            </p>
                        </div>
                        <div class="price">
                            <?php
                            if ($row['order_price'] <= 0) {
                                echo '<p>Цена договорная</p>';
                            } else {
                                echo '<span>' . $row['order_price'] . '₽</span>';
                            }
                            echo '</div>
                </div>';
                endwhile;

                if ($order_temp == 0) {
                    echo "<p>Нет заказов</p>";
                }

                // Pagination links
                $sql_count = "SELECT COUNT(*) as total FROM orders WHERE nik = ?";
                $stmt_count = mysqli_prepare($bd_connect, $sql_count);
                mysqli_stmt_bind_param($stmt_count, "s", $user_nik);
                mysqli_stmt_execute($stmt_count);
                $count_query = mysqli_stmt_get_result($stmt_count);
                $count_row = mysqli_fetch_assoc($count_query);
                $total_orders = $count_row['total'];
                $total_pages = ceil($total_orders / $orders_per_page);
                if ($total_pages >= 2):
                    ?>
                            <div class="pagination">
                                <div class="arrow left_arrow"><a href="?page=<?= $page - 1 ?>"><svg
                                            xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                                        </svg></a></div>
                                <div class="number_part">
                                    <div><b class="page_number">
                                            <?= $page ?>
                                        </b></div>
                                    <div><b class="slash">/</b></div>
                                    <div><b class="page_number end_page">
                                            <?= $total_pages ?>
                                        </b></div>
                                </div>
                                <div class="arrow right_arrow"><a href="?page=<?= $page + 1 ?>"><svg
                                            xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                                        </svg></a></div>
                            </div>
                            <?php
                endif;
                ?>
                    </div>

                </div>
            </div>
        </div>
        <?php
        include "../layouts/footer.php";
        ?>
        <script src="../page_js/user/project/change_page.js"></script>
        </body>

        </html>