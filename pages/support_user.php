<?php
    session_start();
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/support_user.css'>";
    echo "<link rel='stylesheet' href='../page_css/media/support_user_media.css'>";
    echo "<title>Служба Поддержки Bestlancer</title>";
    include "../layouts/header_line.php";
?>
<div class="support_container container header">
    <div class="header_title">
        <h2>Служба поддержки</h2>
    </div>
    <div class="support_part">
        <form action="../email_send/support_email.php" method="post" enctype="multipart/form-data">
            <div>
                <p>Ваш email</p>
                <?php
                    if (isset($_SESSION["nik"])){
                        echo '<input type="text" value="'.$_SESSION["email"].'" name="email" class="right_in none_right">';
                    } else{
                        echo '<input type="text" name="email" class="right_in" placeholder="Email для обратной связи">';
                    }
                ?>
            </div>
            <div>
                <p>Сообщение</p>
                <textarea name="message" class="right_in" cols="30" placeholder="Текст сообщения для службы поддержки" rows="10"></textarea>
            </div>
            <div>
                <p>Прикрепите файл</p>
                <input type="file" name="attachment" class="right_in" title="Прикрепите ваш файл">
            </div>
            <div><button type="submit">Отправить</button></div>
        </form>
    </div>
</div>
<?php
    include "../layouts/footer.php";
?>