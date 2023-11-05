<?php
session_start();
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/balance.css'>";
echo "<title>Мой кошелёк</title>";
include "../layouts/header_line.php";
?>
<div class="balance_container container">
    <div class="header">
        <div class="header_title">
            <h2>Мой кошелёк</h2>
        </div>
        <p class="balance">400$</p>
        <div class="button_choice">
            <div><button title="Пополнить свой кошелёк">Пополнить</button></div>
            <div><button title="Вывести средства со своего кошелёка">Вывести</button></div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
</body>

</html>