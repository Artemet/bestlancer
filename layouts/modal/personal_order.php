<div class="user_container personal_order_container">
    <!-- style="display: block; opacity: 1;" -->
    <div class="make_order">
        <div class="close">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#4f8203}</style><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        </div>
        <div>
            <h2>Заказ для <u class="user_nik"><?= $user['nik'] ?></u></h2>
        </div>
        <div class="line"></div>
        <form action="../bd_send/order/send_personal_order.php?user_id=<?= $user['id'] ?>" method="post" enctype="multipart/form-data">
            <div class="value_information">
                <div>
                    <h3>Название заказа</h3>
                    <input type="text" name="order_name" class="right_in" placeholder="Введите название заказа">
                </div>
                <div>
                    <h3>Описание</h3>
                    <textarea name="order_information" id="" cols="30" rows="10" class="right_in" placeholder="Введите название заказа"></textarea>
                </div>
                <div>
                    <h3>Приктрепите файлы</h3>
                    <input type="file" name="file_send" class="right_in file_choice">
                </div>
            </div>
            <button title="Отправить личный заказ пользователю <?= $user['nik'] ?>">Отправить</button>
        </form>
    </div>
</div>