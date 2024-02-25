<link rel="icon" href="../../res/web_logo.png">
<link rel='stylesheet' href='../../local_css/app.css'>
<link rel='stylesheet' href='../../local_css/positive.css'>
<title>Успешная отправка</title>
<?php
session_start();
$user_name = $_SESSION["name"];
$user_family = $_SESSION["family"];
?>
<div class="container">
    <div class="header">
        <div class="positive header_title">
            <h2><a href="../../pages/user.php">
                    <?= $user_name ?>
                    <?= $user_family ?>
                </a>, ваш заказ успешно отправлен!</h2>
        </div>
        <div class="positive_text text">
            <b>В скоре пользователь даст обратную связь.</b>
        </div>
    </div>
</div>
<script src="../local_js/app.js"></script>