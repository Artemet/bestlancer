<?php
session_start();
include "../bd_send/database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
} else {
    if ($user_resolt["role"] !== "seller") {
        header("Location: home.php");
    }
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/add_project.css'>";
echo "<title>Добавка проекта</title>";
include "../layouts/header_line.php";
?>
<div class="project_add_container container">
    <div class="header">
        <div class="header_title">
            <h2>Добавте проект</h2>
        </div>
        <div class="overlay">
            <div class="loader"></div>
        </div>
        <!-- <form action="../bd_send/user/project_add.php" method="post" enctype="multipart/form-data"> -->
        <div class="form_wrapper">
            <div class="cover_add" id="selectedIcon">
                <div class="cover_child" id="midle_value">
                    <div class="plus"><span>+</span></div>
                    <p>Выбирите изображение</p>
                </div>
                <div class="background_cover"></div>
                <div class="input_wrapper"><input type="file" id="icon_choice" name="file_name" class="file_choice"
                        accept="image/png, image/jpeg, image/jpg"></div>
            </div>
            <div class="inputs_part">
                <div>
                    <b>Название проекта</b>
                    <div class="input_wrapper">
                        <u class="warning"></u>
                        <input type="text" name="project_name" class="right_in checkable"
                            placeholder="Введите название проекта">
                    </div>
                </div>
                <div>
                    <b>Ссылка на проект</b>
                    <div class="input_wrapper">
                        <u class="warning"></u>
                        <input type="text" name="project_link" class="right_in checkable"
                            placeholder="Вставтье ссылку на проект">
                    </div>
                </div>
                <div>
                    <b>Ссылка на YouTube</b>
                    <div class="input_wrapper">
                        <input type="text" name="project_youtube" class="right_in"
                            placeholder="Вставтье ссылку на YouTube (по желанию)">
                    </div>
                </div>
                <div>
                    <b>О проекте</b>
                    <u class="warning"></u>
                    <textarea placeholder="Расскажите о проекте" name="project_context" class="right_in checkable" id=""
                        cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="button">
                <button>Добавить</button>
            </div>
        </div>
        <!-- </form> -->
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/add_project/add_project.js"></script>
</body>

</html>