<div class="star_option_modal">
    <div class="star_option">
        <b>Вы уверены что хотите поставиь Bestlancer <span class="star_number"></span> звезд(ы)?</b>
        <div class="count_number"><p class="moveing_number">напишите отзыв и выберете оптицию</p></div>
        <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                $email_get = $_SESSION["email"];
                echo "<p class='email_information'>$email_get</p>"; // Показывать логин пользователя, если вход выполнен
            } else {
                echo "<p class='email_information'>Гость</p>"; // Показывать "Гость", если вход не выполнен
            }
        ?>
        <div class="buttons">
            <button title="отменить отправку">нет</button>
            <form action="../bd_send/bestlancer_star/star_send.php" method="post">
                <input type="text" class="email" name="user_email_star" readonly>
                <div class="review_send">
                    <textarea name="user_review" placeholder="напишите ваш отзыв" id="" cols="30" rows="10"></textarea>
                </div>
                <input type="number" class="number" name="star_number" readonly>
                <button title="отправить">да</button>
            </form>
        </div>
    </div>
</div>