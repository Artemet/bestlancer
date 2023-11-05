<?php
session_start();
include "../layouts/header.php";
include "../bd_send/database_connect.php";
echo "<link rel='stylesheet' href='../page_css/reviews.css'>";
echo "<title>Отзывы о компании Bestlancer</title>";
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
        $sql = "SELECT * FROM reviews";
        $query = mysqli_query($bd_connect, $sql);

        $loggedInEmail = "";
        if (isset($_SESSION["nik"])) {
            $loggedInEmail = $_SESSION["email"];
        }
        $hasMatchingEmail = false;

        while ($row = mysqli_fetch_assoc($query)) {
            $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
            $email = $row['email'];
            $date = $row['date'];
            $emailsCount[$email] = isset($emailsCount[$email]) ? $emailsCount[$email] + 1 : 1;

            if ($emailsCount[$email] <= 1) {
                echo '
                    <div class="review">
                        <div class="review_user">
                            <p class="email">' . $email . '</p>
                        </div>
                        <div class="line" style="width:100%;"></div>
                        <div class="review_part">
                            <p>' . $row['review'] . '</p>
                        </div>
                        <div class="line" style="width:100%; background: rgb(79, 130, 3);"></div>
                        <div class="star_number">
                            <p><span>' . $row['star'] . '</span> звезд(а)</p>
                        </div>
                        <div class="time"><p>' . $date . '</p></div>
                    </div>';

                if ($email === $loggedInEmail) {
                    $hasMatchingEmail = true;
                }
            }
        }

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