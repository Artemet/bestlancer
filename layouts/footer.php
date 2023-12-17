<div class="footer_container">
    <div class="footer_links">
        <div class="support_block">
            <h2>
                <div class="bestlancer_text">
                    <p>BEST</p>LANCER
                </div>
            </h2>
            <div class="email">
                <a href="../pages/support_user.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <style>
                            svg {
                                fill: #4f8203
                            }
                        </style>
                        <path
                            d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                    </svg>
                    <div>bestlancer320@gmail.com</div>
                </a>
            </div>
            <p>Ежедневно с 8:00 до 22:00</p>
        </div>
        <div class="links_block">
            <div class="page_links">
                <h3>О сервисе</h3>
                <div class="links">
                    <a href="../pages/about_company.php">О бирже</a>
                    <a href="">Контакты</a>
                    <a href="../pages/reviews.php">Отзывы</a>
                </div>
            </div>
            <div class="page_links">
                <h3>Пользователям</h3>
                <div class="links">
                    <a href="../pages/rates.php">Тарифы</a>
                    <a href="../pages/services.php">Услуги</a>
                    <a href="<?= $project_filter_resolt ?>">Фриланс заказы</a>
                </div>
            </div>
            <div class="page_links">
                <h3>Помощь</h3>
                <div class="links">
                    <a href="../pages/help.php">Помощь</a>
                    <a href="../pages/rules.php">Правила сервиса</a>
                    <a href="../pages/support_user.php">Служба поддержки</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../local_js/scroll.js"></script>
<script src="../local_js/menu.js"></script>
<script src="../local_js/come_in_form.js"></script>
<script src="../local_js/app.js"></script>
<script src="../local_js/scroll_time.js"></script>
<?php
if (isset($_SESSION["nik"])):
    ?>
    <script src="../local_js/account_menu.js"></script>
    <?php
endif;
if (!isset($_SESSION["nik"])):
    ?>
    <script src="../local_js/sing_in/value_save.js"></script>
    <?php
endif;
?>