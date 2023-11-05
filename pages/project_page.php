<?php
session_start();
include "../bd_send/database_connect.php";
$project_id = $_GET['project_id'];
$sql = "SELECT * FROM project_cover WHERE id = $project_id";
$query = mysqli_query($bd_connect, $sql);
$project_cover = mysqli_fetch_assoc($query);
$project_nik = $project_cover['nik'];
$project_name = $project_cover['project_name'];
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/project_page.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/change_project.css'>";
echo "<title>$project_nik: $project_name</title>";
if ($_SESSION["nik"] == $project_nik) {
    include "../layouts/modal/change_project.php";
}
include "../layouts/header_line.php";
?>
<div class="project_container container">
    <div class="header">
        <div class="header_title"
            style="background-image: url('../bd_send/user/project_cover/<?= $project_cover['cover_href']; ?>');">
            <?php
            if ($_SESSION["nik"] == $project_nik) {
                include "../layouts/change_pencil.php";
            }
            ?>
            <h2>
                <?= $project_name ?>
            </h2>
        </div>
        <h4>
            Проект
            <p>
                <?= $project_nik ?>
            </p>
        </h4>
        <?php
        if (!empty($project_cover['project_video']) && strpos($project_cover['project_video'], "http") !== false):
            ?>
            <div class="video_part">
                <p class="video_link">
                    <?= $project_cover['project_video'] ?>
                </p>
            </div>
            <?php
        endif;
        ?>
        <div class="line" style="width: 100%;"></div>
        <div class="cover_part about">
            <b>О проекте</b>
            <p class="in_cover">
                <?= $project_cover['project_context'] ?>
            </p>
        </div>
        <div class="line" style="width: 100%;"></div>
        <div class="cover_part">
            <b>Ссылка</b>
            <a href="<?= $project_cover['project_link'] ?>" target="_blank" class="in_cover"><span>
                    <?= $project_cover['project_link'] ?>
                </span></a>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
if (!empty($project_cover['project_video'])) {
    echo "<script src='../page_js/user/project/video_get.js'></script>";
}
if ($_SESSION["nik"] == $project_nik) {
    echo "<script src='../page_js/user/project/project_change.js'></script>";
}
?>
</body>

</html>