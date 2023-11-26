<?php
session_start();
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/help.css'>";
echo "<title>Помощь</title>";
include "../layouts/header_line.php";
?>
<div class="help_company container">
    <h2>
        <div class="bestlancer_text">
            <p>BEST</p>LANCER
        </div>
    </h2>
    <div class="line" style="width: 100%;"></div>
    <div class="help_options">
        <?php
        $option_text = array("Как найти исполнителя?", "Как найти удаленную работу?", "Регистрация и активация учетной записи.");
        $option_href = array("helper_find", "work_find", "registration");
        for ($i = 0; $i < count($option_text); $i++):
            ?>
            <div class="option"><a href="#<?= $option_href[$i] ?>">
                    <?= $option_text[$i] ?>
                </a></div>
            <?php
        endfor;
        ?>
    </div>
    <div class="header">
        <h2 id="helper_find">Как найти исполнителя?</h2>
        <div class="line" style="width: 100%;"></div>
        <div class="instruction_container">
            <div class="instruction">
                <div class="number"><span>1</span></div>
                <h4>Добавьте проект, вакансию или личный заказ</h4>
                <p>Размещение заказа займет всего несколько минут.
                    Добавьте <a href="make_order.php">проект</a>, если Ваш заказ носит разовый характер.
                    Если Вам необходим исполнитель на определенную должность, разместите вакансию. Если вы хотите
                    предложить определённому исполнителю заказ то перейдите на его страницу и нажмите кнопку
                    <b>"Предложить
                        заказ"</b>.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>2</span></div>
                <h4>Принимайте предложения от фрилансеров</h4>
                <p>Фрилансеры, желающие выполнить Ваш заказ, будут размещать заявки непосредственно на странице заказа.
                    Изучайте предложения фрилансеров, свободно общайтесь с ними с помощью приватных сообщений или других
                    средств связи.
                    Обращайте внимание на портфолио фрилансеров и отзывы, оставленные другими заказчиками.
                    Немаловажными характеристиками также являются рейтинг фрилансеров и продолжительность их работы в
                    сервисе.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>3</span></div>
                <h4>Укажите выбранного исполнителя</h4>
                <p>Перед началом сотрудничества обязательно укажите выбранного исполнителя на странице заказа!
                    Только указав выбранного исполнителя Вы сможете в дальнейшем опубликовать отзыв в его адрес.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>4</span></div>
                <h4>Начните сотрудничество с исполнителем</h4>
                <p>После выбора исполнителя приступайте к сотрудничеству по Вашему заказу.
                    Если исполнитель требует предоплату, будьте предельно внимательны и осторожны!
                    Не переводите предоплату исполнителям без отзывов, рейтинга и небольшим периодом работы в сервисе.
                    Чтобы исключить возможные риски при оплате используйте безопасные платежи.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>5</span></div>
                <h4>Оставьте отзыв о сотрудничестве</h4>
                <p>По окончании сотрудничества оставьте отзыв об исполнителе на странице заказа.
                    Положительный — только после полного выполнения исполнителем всех обязательств перед Вами.
                    Отрицательный — только в случае, если принятые обязательства не были выполнены.
                    Кратко опишите процесс сотрудничества и оцените профессиональные качества исполнителя.
                </p>
            </div>
        </div>
    </div>
    <div class="header">
        <h2 id="work_find">Как найти удаленную работу</h2>
        <div class="line" style="width: 100%;"></div>
        <div class="instruction_container">
            <div class="instruction">
                <div class="number"><span>1</span></div>
                <h4>Подготовьте свою персональную страницу</h4>
                <p>Составьте резюме и добавьте его в настройках профиля, загрузите фотографию или юзерпик.
                    Заполните перечень предоставляемых услуг, добавьте в портфолио примеры Ваших работ.
                    Укажите контактные данные, по которым с Вами смогут связываться заказчики.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>2</span></div>
                <h4>Выберите тарифный план</h4>
                <p>От тарифного плана зависит, какое число разделов Вы сможете указать в перечне своих услуг.
                    Для ознакомления с сервисом каждому фрилансеру при регистрации начисляются 5 бесплатных
                    универсальных заявок.
                    Если Вы заполните профиль и портфолио — вам будут начислены еще 50 заявок.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>3</span></div>
                <h4>Подавайте заявки к проектам, вакансиям или конкурсам</h4>
                <p>Просматривайте открытые заказы, соответствующие Вашим услугам, и оставляйте заявки к ним.
                    Свободно общайтесь с заказчиками с помощью приватных сообщений или других средств связи.
                    Обращайте внимание на отзывы, оставленные заказчикам другими фрилансерами.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>4</span></div>
                <h4>Ожидайте выбора исполнителем</h4>
                <p>Перед началом сотрудничества обязательно убедитесь, что Вы указаны в списке выбранных исполнителей на
                    странице заказа!
                    Только в этом случае Вы сможете в дальнейшем опубликовать отзыв в адрес заказчика.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>5</span></div>
                <h4>Выполняйте задания заказчиков</h4>
                <p>После выбора исполнителем приступайте к сотрудничеству с заказчиком.
                    Чтобы исключить возможные риски при оплате используйте безопасные платежи.
                </p>
            </div>
            <div class="instruction">
                <div class="number"><span>6</span></div>
                <h4>Оставляйте отзывы о сотрудничестве</h4>
                <p>По окончании сотрудничества оставьте отзыв о заказчике на странице заказа.
                    Положительный — только после полного выполнения заказчиком всех финансовых обязательств перед Вами.
                    Отрицательный — только в случае, если принятые обязательства не были выполнены.
                    Кратко опишите процесс сотрудничества и оцените профессиональные качества заказчика.
                </p>
            </div>
        </div>
    </div>
    <div class="header">
        <h2 id="registration">Регистрация и активация учетной записи</h2>
        <div class="line" style="width: 100%;"></div>
        <div class="instruction_container">
            <div class="instruction">
                <p>Регистрация и дальнейшая работа в сервисе осуществляется в соответствии с соглашением пользователя и
                    правилами ресурса.
                    В сервисе применяется универсальный тип учетной записи, что позволяет пользователю выступать как в
                    роли заказчика, так и в роли исполнителя (фрилансера).
                    Пользователь обладает правом регистрации только одной учетной записи.

                    Код активации учетной записи отправляется автоматически на адрес электронной почты, указанный
                    пользователем при регистрации.
                    Если по каким-либо причинам письмо с кодом не было доставлено, пользователь имеет возможность
                    отправить код повторно либо изменить адрес электронной почты.
                    Учетные записи, которые не были активированы в течение 10 календарных дней, подлежат автоматическому
                    удалению.
                </p>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
</body>

</html>