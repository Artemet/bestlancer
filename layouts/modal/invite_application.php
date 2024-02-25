<div class="user_container user_account invite_modal">
    <div class="close_icon" title="Закрыть">
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
    <div class="come_in sing_in">
        <h2>Приглашение в заказ</h2>
        <div class="line"></div>
        <input type="text" name="user_nik" readonly class="acquaintance_nik">
        <div>
            <p>Выбирите знакомого:</p>
            <div class="acquaintance_users">
                <?php
                $resolt_icon_path = null;
                $resolt_nik = null;
                $acquaintance_temp = 0;
                $acquaintance_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = ? OR `nik_two` = ?";
                $acquaintance_stmt = mysqli_prepare($bd_connect, $acquaintance_sql);
                mysqli_stmt_bind_param($acquaintance_stmt, "ss", $nik, $nik);
                mysqli_stmt_execute($acquaintance_stmt);
                $acquaintance_result = mysqli_stmt_get_result($acquaintance_stmt);

                while ($acquaintance_resolt = mysqli_fetch_assoc($acquaintance_result)):
                    $acquaintance_temp++;
                    if ($acquaintance_resolt["nik_one"] == $nik) {
                        $resolt_nik = $acquaintance_resolt["nik_two"];
                    } else {
                        $resolt_nik = $acquaintance_resolt["nik_one"];
                    }
                    $icon_sql = "SELECT `icon_path` FROM `user_registoring` WHERE `nik` = ?";
                    $icon_stmt = mysqli_prepare($bd_connect, $icon_sql);
                    mysqli_stmt_bind_param($icon_stmt, "s", $resolt_nik);
                    mysqli_stmt_execute($icon_stmt);
                    $icon_result = mysqli_stmt_get_result($icon_stmt);
                    $resolt_icon_path = mysqli_fetch_assoc($icon_result)["icon_path"];
                    //past_acquaintance
                    $row_class = null;
                    $past_acquaintance_repeat = false;
                    $past_acquaintance = "SELECT * FROM `notifications` WHERE `order_nik` = ? AND `nik` = ? AND `order_information` = ?";
                    $past_stmt = mysqli_prepare($bd_connect, $past_acquaintance);
                    mysqli_stmt_bind_param($past_stmt, "sss", $resolt_nik, $nik, $order_id);
                    mysqli_stmt_execute($past_stmt);
                    $past_acquaintance_query = mysqli_stmt_get_result($past_stmt);

                    while ($past_acquaintance_resolt = mysqli_fetch_assoc($past_acquaintance_query)) {
                        $past_acquaintance_repeat = true;
                    }
                    if ($past_acquaintance_repeat == true) {
                        $row_class = "none_user";
                    }

                    if (empty($acquaintance_resolt["main_block"])):
                        ?>
                        <div class="row_wrapper">
                            <div class="user_row <?= $row_class ?>">
                                <div class="user_icon">
                                    <img src="../bd_send/user/user_icons/<?= $resolt_icon_path ?>" draggable="false" alt="">
                                </div>
                                <div class="user_nik">
                                    <p>
                                        <?= $resolt_nik ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                            if ($past_acquaintance_repeat == true) {
                                echo "<div class='invited_text'><p>Приглашён</p></div>";
                            }
                            ?>
                        </div>
                        <?php
                    endif;
                endwhile;
                if ($acquaintance_temp == 0) {
                    echo "<div class='none_acquaintance'><b>У вас нет знакомых пользователей!</b></div>";
                }
                ?>
            </div>
        </div>
        <button class="invite_send">Пригласить</button>
    </div>
</div>