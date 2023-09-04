<?php
    session_start(); 
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/news.css'>";
    echo "<title>Новости фриланс биржи Bestlancer</title>";
    include "../layouts/header_line.php";
?>
<div class="news_container container">
    <h2>Новости<div class="bestlancer_text"><p>BEST</p>LANSER</div></h2>
    <div class="line" style="width: 100%;"></div>
    <div class="news_wrapper">
        <?php
            include "../bd_send/database_connect.php";
            $sql = "SELECT * FROM news";
            $query = mysqli_query($bd_connect, $sql);
            while ($row = mysqli_fetch_assoc($query)):
        ?>
        <div class="news_part">
            <div class="img">
                <img src="../res/<?=$row["news_image"]?>" alt="" draggable="false">
            </div>
            <a href="news_page.php?news_id=<?=$row["id"]?>"><h3><?=$row["news_name"]?></h3></a>
        </div>
        <?php
            endwhile;
        ?>
    </div>
</div>
<?php
    include "../layouts/footer.php";
?>