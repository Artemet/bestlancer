<?php
session_start();
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/rates.css'>";
echo "<title>Тарифы для фрилансеров</title>";
include "../layouts/header_line.php";
?>
<div class="rules_container container">
    <div class="header">
        <div class="header_title">
            <h2>Правила сервиса</h2>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/rates/rates_logic.js"></script>
</body>

</html>