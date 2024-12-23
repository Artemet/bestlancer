<?php
session_start();
include "../layouts/header.php";
include "../bd_send/database_connect.php";
echo "<link rel='stylesheet' href='../page_css/reviews.css'>";
echo "<title>Отзывы о бирже Bestlancer</title>";
include "../layouts/header_line.php";
?>
<div class="reviews_company container">
    <h2 class="header_title">отзывы<div class="bestlancer_text">
            <p>BEST</p>LANCER
        </div>
    </h2>
    <div class="line" style="width: 100%;"></div>
    <div class="reviews">
        <div class="no_review">
            <p>нет отзывов</p>
        </div>
        <?php
        $emailsCount = array();
        $review_type = "exchange";
        $sql = "SELECT * FROM `reviews` WHERE `type` = ?";
        $stmt = mysqli_prepare($bd_connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $review_type);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);

        $loggedInEmail = "";
        if (isset($_SESSION["nik"])) {
            $loggedInEmail = $_SESSION["email"];
        }
        $hasMatchingEmail = false;

        while ($row = mysqli_fetch_assoc($query)):
            $email = $row['email'];

            $info_sql = "SELECT * FROM `user_registoring` WHERE `email` = ?";
            $info_stmt = mysqli_prepare($bd_connect, $info_sql);
            mysqli_stmt_bind_param($info_stmt, "s", $email);
            mysqli_stmt_execute($info_stmt);
            $info_query = mysqli_stmt_get_result($info_stmt);

            $info_resolt = mysqli_fetch_assoc($info_query);

            $review_class = null;
            if (isset($_SESSION["nik"])) {
                if ($_SESSION["email"] == $email) {
                    $review_class = "my_review";
                }
            }
            $date = $row['date'];
            $emailsCount[$email] = isset($emailsCount[$email]) ? $emailsCount[$email] + 1 : 1;

            if ($emailsCount[$email] <= 1):
                ?>
                <div class="review <?= $review_class ?>">
                    <div class="review_user">
                        <div class="user_icon">
                            <img src="../bd_send/user/user_icons/<?= $info_resolt['icon_path'] ?>" alt="" draggable="false">
                        </div>
                        <div>
                            <p class="name">
                                <?= $info_resolt['name'] ?>
                                <?= $info_resolt['family'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="line" style="width:100%;"></div>
                    <div class="review_part">
                        <p>
                            <?= $row['review'] ?>
                        </p>
                    </div>
                    <div class="line" style="width:100%; background: rgb(79, 130, 3);"></div>
                    <div class="star_number">
                        <p><span>
                                <?= $row['star'] ?>
                            </span> звезд(а)</p>
                    </div>
                    <div class="time">
                        <p>
                            <?= $date ?>
                        </p>
                    </div>
                </div>
                <?php
                if ($email === $loggedInEmail) {
                    $hasMatchingEmail = true;
                }
            endif;
        endwhile;

        if ($hasMatchingEmail && $emailsCount[$loggedInEmail] > 1) {
            echo '<div class="length_warning length_warning_close">
                <div>
                    <p>Вы уже отправили отзыв</p>
                </div>
                <div class="close_warning" title="Закрыть предупреждение">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#d08e0b}</style><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
                </div>
                </div>';
        } else {
            echo '';
        }
        ?>

    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/review/review_check.js"></script>
</body>

</html>