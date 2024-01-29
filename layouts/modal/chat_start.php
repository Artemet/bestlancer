<div class="user_container start_chat_container">
    <div class="start_chat">
        <div class="close">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <style>
                    svg {
                        fill: #4f8203
                    }
                </style>
                <path
                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
            </svg>
        </div>
        <div>
            <h2>Чат с <u>
                    <?= $user['nik'] ?>
                </u></h2>
        </div>
        <div>
            <h4>Сообщение</h4>
            <textarea name="thirst_message" class="right_in" id="" cols="30" rows="10"
                placeholder="Введите ваше сообщение"></textarea>
        </div>
        <button>Отправить</button>
        <script>
            $('.start_chat_container button').on('click', function () {
                const message_value = $('.start_chat_container textarea').val();
                $.ajax({
                    method: "POST",
                    url: "../bd_send/user/message_users.php?user_id=<?= $user_id ?>",
                    data: { thirst_message: message_value }
                })
                    .done(function () {
                        $('button.chat_start').html('Открыть чат');
                        $('button.chat_start').addClass('chat_link');
                        $('.start_chat_container')[0].style.opacity = 0;
                        setTimeout(() => {
                            $('.start_chat_container')[0].style.display = "none";
                            alert("Вы успешно начали чат с <?= $user['nik'] ?>");
                        }, 500);
                        $('button.chat_start').on('click', function () {
                            window.location.href = "messages.php";
                        });
                    });
            });
        </script>
    </div>
</div>