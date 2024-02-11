<?php
session_start();
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/rule.css'>";
echo "<title>Тарифы для фрилансеров</title>";
include "../layouts/header_line.php";
?>
<div class="rules_container container">
    <div class="header">
        <div class="header_title">
            <h2>Правила сервиса</h2>
        </div>
        <div class="rules_wrapper">
            <div class="rule">
                <div class="rule_number">
                    <b>1</b>
                </div>
                <div>
                    <div>
                        <h3>Учетные записи пользователей</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Каждый пользователь обязан создавать только одну учетную запись.</li>
                            <li>Предоставление достоверной информации при регистрации обязательно.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>2</b>
                </div>
                <div>
                    <div>
                        <h3>Поведение пользователей</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Вежливое общение и уважение к другим пользователям обязательны.</li>
                            <li>Запрещено использование оскорбительных, дискриминационных или непристойных выражений.
                            </li>
                            <li>Запрещена нелегальная или вредоносная деятельность.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>3</b>
                </div>
                <div>
                    <div>
                        <h3>Публикация проектов и откликов</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Запрещено размещение проектов или откликов, нарушающих законы или правила сервиса.</li>
                            <li>Проекты и отклики должны быть четкими и понятными для всех участников.
                            </li>
                            <li>Публикация контента должна соответствовать тематике и целям платформы.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>4</b>
                </div>
                <div>
                    <div>
                        <h3>Финансовые вопросы</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Оплата на бирже должа производиться по этапно, по заявкам через биржу.</li>
                            <li>Заранее перед откликами надо указывать реквезиты оплаты в настройках биржи. Для перевода
                                средств покупателям.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>5</b>
                </div>
                <div>
                    <div>
                        <h3>Конфиденциальность</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Пользователям рекамендуеться никуму не довать данные от аккаунта и держать их в
                                безопасном месте. Пример: txt документ на компьютере.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>6</b>
                </div>
                <div>
                    <div>
                        <h3>Контроль качества</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Сервис оставляет за собой право проверять качество работ и принимать меры в случае
                                несоответствия стандартам.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>7</b>
                </div>
                <div>
                    <div>
                        <h3>Обратная связь</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Пользователи могут оценивать друг друга после выполнения работ для обеспечения
                                прозрачности и доверия.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>8</b>
                </div>
                <div>
                    <div>
                        <h3>Споры и разрешение конфликтов</h3>
                    </div>
                    <div>
                        <ul>
                            <li>В случае возникновения споров между пользователями, сервис может выступать в роли
                                посредника для разрешения конфликта.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="rule">
                <div class="rule_number">
                    <b>9</b>
                </div>
                <div>
                    <div>
                        <h3>Заключительные положения</h3>
                    </div>
                    <div>
                        <ul>
                            <li>Правила сервиса могут меняться, и пользователям рекамендуеться следить за обновлениями.
                            </li>
                            <li>Нарушение правил может привести к блокировке аккаунта или другим мерам дисциплинарного
                                характера.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/rates/rates_logic.js"></script>
</body>

</html>