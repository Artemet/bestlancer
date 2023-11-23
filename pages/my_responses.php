<?php
session_start();
if (!isset($_SESSION["nik"])){
    header("Location: home.php");
}
include "../bd_send/database_connect.php";
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/order_information.css'>";
echo "<link rel='stylesheet' href='../page_css/my_responses.css'>";
echo "<link rel='stylesheet' href='../page_css/media/my_responses_media.css'>";
echo "<title>Мои отклики</title>";
include "../layouts/header_line.php";
?>
<div class="my_responses order_information container">
    <div class="page_choice">
        <div>
            <a href="my_responses.php" class="active">Мои отклики</a>
            <div class="under_line"></div>
        </div>
        <div>
            <a href="my_orders.php">Мои заказы</a>
            <div class="under_line"></div>
        </div>
    </div>
    <div class="header">
        <div class="header_title">
            <h2>Мои отклики</h2>
            <div class="loading_line"></div>
        </div>
        <div class="content">
            <div class="response_container">
                <?php
                $user_nik = $_SESSION["nik"];
                $response_temp = 0;
                $sql = "SELECT * FROM orders_responses WHERE nik = '$user_nik'";
                $query = mysqli_query($bd_connect, $sql);
                //page
                $responses_per_page = 8;

                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                $offset = ($page - 1) * $responses_per_page;

                $sql = "SELECT * FROM orders_responses WHERE nik = '$user_nik' LIMIT $offset, $responses_per_page";
                $query = mysqli_query($bd_connect, $sql);

                if ($page >= 1):
                    while ($row = mysqli_fetch_assoc($query)):
                        //max_price
                        $order_id = $row["id"];
                        $max_price_sql = "SELECT `order_price` FROM `orders` WHERE `id` = '$order_id'";
                        $max_price_query = mysqli_query($bd_connect, $max_price_sql);
                        $max_price_resolt = mysqli_fetch_assoc($max_price_query)['order_price'];
                        //users_nik
                        $response_temp++;
                        $orderer_nik = $row['order_name'];
                        $order_sql = "SELECT * FROM orders WHERE order_name = '$orderer_nik'";
                        $order_niks = array();
                        $order_query = mysqli_query($bd_connect, $order_sql);
                        $order_row = mysqli_fetch_assoc($order_query);
                        $row_nik_content = $order_row['nik'];
                        $nik = $row_nik_content;
                        //users_id
                        $id_query = "SELECT id FROM user_registoring WHERE nik = '$nik'";
                        $id_result = mysqli_query($bd_connect, $id_query);
                        $id_row = mysqli_fetch_assoc($id_result);
                        $user_id = $id_row['id'];
                        //users_icons
                        $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$nik'";
                        $icon_resolt = mysqli_query($bd_connect, $icon_query);
                        $icon_row = mysqli_fetch_assoc($icon_resolt);
                        $user_icon = $icon_row['icon_path'];
                        ?>
                        <div class="response">
                            <span class="response_id">
                                <?= $order_id ?>
                            </span>
                            <div class="top_part">
                                <div class="users_order">
                                    <div class="img">
                                        <img src="../bd_send/user/user_icons/<?= $user_icon ?>" alt="" draggable="false">
                                    </div>
                                    <div>
                                        <a href="user_page.php?user_id=<?= $user_id ?>">
                                            <?= $row_nik_content ?>
                                        </a>
                                    </div>
                                    <?php
                                    if ($max_price_resolt != 0) {
                                        echo "<p class='max_price'>Максимальная цена: <b>$max_price_resolt$</b></p>";
                                    } else {
                                        echo "<p class='max_price'>Договорная цена</p>";
                                    }
                                    ?>
                                </div>
                                <div>
                                    <h3>
                                        <?= $row['order_name'] ?>
                                    </h3>
                                </div>
                                <div class="change_order_button">
                                    <button><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                                        </svg></button>
                                </div>
                            </div>
                            <div class="response_sub">
                                <div>
                                    <?php
                                    if (!empty($row['user_message'])) {
                                        echo '<p class="comment">' . $row['user_message'] . '</p>';
                                    } else {
                                        echo '<p class="comment none_comment">Нет сообщения</p>';
                                    }
                                    echo '
                    
                    </div>
                        <div>
                            <span class="main_information">' . $row['price'] . '$</span>
                            <p class="main_information">' . $row['time'] . ' суток</p>
                        </div>
                    </div>
                </div>';
                    endwhile;
                endif;
                if ($response_temp == 0) {
                    echo '<p>Нет откликов</p>';
                }

                // Pagination links
                $total_responses_sql = "SELECT COUNT(*) as total FROM orders_responses WHERE nik = '$user_nik'";
                $total_responses_query = mysqli_query($bd_connect, $total_responses_sql);
                $total_responses = mysqli_fetch_assoc($total_responses_query)['total'];
                $total_pages = ceil($total_responses / $responses_per_page);
                if ($total_pages !== 1 && $total_pages >= 2):
                ?>
                            <div class="pagination">
                                <div class="arrow"><a href="?page=<?= $page - 1 ?>"><svg
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
                                    <div><b class="page_number">
                                            <?= $total_pages ?>
                                        </b></div>
                                </div>
                                <div class="arrow"><a href="?page=<?= $page + 1 ?>"><svg
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
            <script src="../page_js/user/change_response.js"></script>
            <script src="../page_js/user/project/change_page.js"></script>
            </body>

            </html>