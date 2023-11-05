<div class="user_container change_project">
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
            Смена проекта №
            <?= $project_id ?>
        </h2>
        <div class="line"></div>
        <form action="../bd_send/user/project_add.php?project_id=<?= $project_id ?>" method="post"
            enctype="multipart/form-data">
            <div class="information_wraper">
                <div>
                    <p>Ваша обложка:</p>
                    <div class="cover"
                        style="background-image: url('../bd_send/user/project_cover/<?= $project_cover['cover_href']; ?>');">
                        <div class="fon"></div>
                        <input type="text" name="old_file" readonly value="<?= $project_cover['cover_href'] ?>"
                            style="display: none;">
                        <input type="file" name="file_name" class="file_choice">
                        <div class="plus"><span>+</span></div>
                    </div>
                </div>
                <div>
                    <p>Ваше название:</p>
                    <input type="text" name="project_name" class="right_in" value="<?= $project_name ?>"
                        placeholder="Введите название проекта">
                </div>
                <div>
                    <p>О проекте:</p>
                    <textarea id="" name="project_context" placeholder="Расскажите о проекте" class="right_in" cols="30"
                        rows="10"></textarea>
                </div>
                <div>
                    <p>Ваша ссылка:</p>
                    <input type="text" name="project_link" class="right_in"
                        value="<?= $project_cover['project_link'] ?>" placeholder="Вставьте ссылку на проект">
                </div>
                <div>
                    <p>Ссылка на YouTube:</p>
                    <div class="input_wrapper"><input type="text" name="project_youtube"
                            value="<?= $project_cover['project_video'] ?>" class="right_in"
                            placeholder="Вставтье ссылку на YouTube (по желанию)"></div>
                </div>
            </div>
            <button>Сохранить</button>
        </form>
    </div>
</div>