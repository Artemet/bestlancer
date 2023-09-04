<?php 
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../local_css/error.css'>";
    echo "<title>Неверный ник или пароль</title>";
    include "../layouts/header_line.php";
?>
<div class="container">
    <div class="error header">
        <div class="error header_title">
            <h2>Ошибка!</h2>
        </div>
        <div class="text">
            <b class="error_text">Неверный ник или пароль.</b>
        </div>
    </div>
</div>
<script src="../local_js/come_back.js"></script>
<script src="../local_js/app.js"></script>