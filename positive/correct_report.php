<?php
    session_start();
    if (isset($_SESSION["nik"])): 
?>
<link rel="icon" href="../../res/web_logo.png">
<link rel='stylesheet' href='../../local_css/positive.css'>
<link rel='stylesheet' href='../../local_css/app.css'>
<title>Жалоба успешно отправлена!</title>
<div class="container">
    <div class="header">
        <div class="positive header_title">
            <h2>Жалоба успешно отправлена!</u></h2>
        </div>
    </div>
</div>
<?php 
    endif;
    if (!isset($_SESSION["nik"])){
        header("Location: ../../pages/home.php");
    }
?>