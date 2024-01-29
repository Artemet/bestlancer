<?php
session_start();
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/news.css'>";
echo "<title>Новости фриланс биржи Bestlancer</title>";
include "../layouts/header_line.php";
?>
<div class="news_container container">
    <h2>Новости<div class="bestlancer_text">
            <p>BEST</p>LANCER
        </div>
    </h2>
    <div class="line" style="width: 100%;"></div>
    <div class="news_wrapper">
        <div class="news_part">
            <div class="img">
                <img src="../res/logo_page.png" alt="" draggable="false">
            </div>
            <a href="news_page.php?news_id=0">
                <h3>Первый день биржи!</h3>
            </a>
            <div class="date">
                <p>2023.10.29</p>
            </div>
        </div>
        <!-- <b class='no_news'>Нет новостей</b> -->
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
</body>

</html>