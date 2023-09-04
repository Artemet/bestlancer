<?php 
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../local_css/positive.css'>";
    echo "<title>Успешная регистрация</title>";
    include "../layouts/header_line.php";
?>
<div class="container">
    <div class="header">
        <div class="positive header_title">
            <h2>Поздравляем <u><?php $name = $_POST["user_name"]; echo $name;?></u>! <br> Вы успешно зарегестрировались на <u>Bestlancer</u></h2>
        </div>
        <div class="positive_text text">
            <b>Тепрь войдите в ваш аккаунт, <br> и начните дополнять и развивать его. <br> Удачи!</b>
        </div>
    </div>
</div>
<script src="../local_js/app.js"></script>
<script src='../local_js/come_in_form.js'></script>