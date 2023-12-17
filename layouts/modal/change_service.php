<div class="user_container change_service">
    <div class="close_icon" title="Закрыть форму">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
            viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <style>
                svg {
                    fill: #d08e0b
                }
            </style>
            <path
                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
        </svg>
    </div>
    <div class="come_in">
        <h2>
            Смена услуги №
            <?= $service_id ?>
        </h2>
        <div class="line"></div>
        <form action="../bd_send/services/change_service.php?service_id=<?= $service_id ?>" method="post"
            enctype="multipart/form-data">
            <div class="information_wraper">
                <div>
                    <p>Ваша обложка:</p>
                    <div class="cover"
                        style="background-image: url('../bd_send/user/project_cover/<?= $service['file_path']; ?>');">
                        <div class="fon" id="selectedIcon"></div>
                        <input type="file" name="file_name" class="file_choice">
                        <div class="plus"><span>+</span></div>
                    </div>
                </div>
                <div>
                    <p>Название услуги:</p>
                    <input type="text" name="service_name" class="right_in" value="<?= $service['name'] ?>"
                        placeholder="Введите название Услуги">
                </div>
                <div>
                    <p>Начальная ставка:</p>
                    <div class="starting_price">
                        <div><input type="number" min="5" name="service_price" value="<?= $service['price'] ?>"
                                class="right_in" placeholder="Введите начальную ставку"></div>
                        <div class="money_icon"><span>₽</span></div>
                    </div>
                </div>
                <div>
                    <p>Об услуге:</p>
                    <textarea id="" name="service_context" placeholder="Расскажите о услуге" class="right_in" cols="30"
                        rows="10"></textarea>
                </div>
            </div>
            <button>Сохранить</button>
        </form>
    </div>
</div>