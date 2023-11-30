<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
    exit;
}
$user_nik = $_SESSION["nik"];
include "../bd_send/database_connect.php";
//notification_remove
$notification_sql = "UPDATE `user_notification` SET `messages` = 0 WHERE `nik` = '$user_nik'";
$notification_query = mysqli_query($bd_connect, $notification_sql);

include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/messages.css'>";
echo "<title>Мессенджер</title>";
include "../layouts/header_line.php";
?>
<div class="container messanger_container">
    <div class="messanger_users">
        <?php
        $user_sql = "SELECT * FROM `messenger_users` WHERE `nik_one` = '$user_nik' OR `nik_two` = '$user_nik'";
        $user_query = mysqli_query($bd_connect, $user_sql);
        while ($user_row = mysqli_fetch_assoc($user_query)):
            ?>
            <a href="?chat_id=<?= $user_row['chat_id'] ?>" class="chat_link">
                <div class="message_user">
                    <?php
                    $interlocutor_nik = null;
                    if ($_SESSION["nik"] === $user_row["nik_two"]) {
                        $interlocutor_nik = $user_row["nik_one"];
                    } else {
                        $interlocutor_nik = $user_row["nik_two"];
                    }
                    $interlocutor_sql = "SELECT * FROM `user_registoring` WHERE `nik` = '$interlocutor_nik'";
                    $interlocutor_query = mysqli_query($bd_connect, $interlocutor_sql);
                    $interlocutor_get = mysqli_fetch_assoc($interlocutor_query);
                    $interlocutor_resolt_nik = $interlocutor_get['nik'];
                    ?>
                    <div class="img">
                        <img src="../bd_send/user/user_icons/<?= $interlocutor_get['icon_path'] ?>" alt="">
                    </div>
                    <div class="user_information">
                        <b>
                            <?= $interlocutor_get['name'] ?>
                        </b>
                        <p>
                            <?= $interlocutor_resolt_nik ?>
                        </p>
                    </div>
                    <?php
                    $message_count = 0;
                    $none_see_message_sql = "SELECT * FROM `messages` WHERE `eye` = 0 AND `nik` = '$interlocutor_resolt_nik'";
                    $none_see_message_query = mysqli_query($bd_connect, $none_see_message_sql);
                    while ($none_see_resolt = mysqli_fetch_assoc($none_see_message_query)) {
                        $message_count++;
                    }
                    if ($message_count >= 1):
                        ?>
                        <div class="notification_number">
                            <p>
                                <?= $message_count ?>
                            </p>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </a>
            <?php
        endwhile;
        ?>
    </div>
    <div class="user_chat">
        <?php
        if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
            $chat_id = $_GET['chat_id'];
        } else {
            echo "<div class='companion_choice'><p>Выбирите собеседника</p></div>";
            exit;
        }
        $companion_nik = null;
        $companion_sql = "SELECT * FROM `messenger_users` WHERE `chat_id` = '$chat_id'";
        $companion_query = mysqli_query($bd_connect, $companion_sql);
        $companion_resolt = mysqli_fetch_assoc($companion_query);
        if ($companion_resolt == null) {
            echo "<div class='companion_choice'><p>Выбирите собеседника</p></div>";
            exit;
        }
        if ($companion_resolt["nik_one"] == $_SESSION["nik"]) {
            $companion_nik = $companion_resolt["nik_two"];
        } elseif ($companion_resolt["nik_two"] == $_SESSION["nik"]) {
            $companion_nik = $companion_resolt["nik_one"];
        } else {
            echo "<div class='companion_choice'><p>Выбирите собеседника</p></div>";
            exit;
        }
        //user_find
        $user_find_sql = "SELECT * FROM `user_registoring` WHERE `nik` = '$companion_nik'";
        $user_find_query = mysqli_query($bd_connect, $user_find_sql);
        $user_find_resolt = mysqli_fetch_assoc($user_find_query);
        //user_block
        $user_block = false;
        $blocking_id = null;
        $block_class = null;
        $user_block_sql = "SELECT * FROM `messenger_users` WHERE `main_block` = '$user_nik' OR `main_block` = '$companion_nik'";
        $user_block_query = mysqli_query($bd_connect, $user_block_sql);
        while ($user_block_resolt = mysqli_fetch_assoc($user_block_query)) {
            $blocking_id = $user_block_resolt['chat_id'];
            if ($_GET['chat_id'] == $blocking_id) {
                $user_block = true;
                $block_class = "blocked_chat";
            }
        }
        ?>
        <div class="companion_options">
            <div title="Перезагрузить чат">
                <a href="?chat_id=<?= $chat_id ?>" class="reload_page_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                    </svg>
                </a>
            </div>
            <div title="Удалить пользователя">
                <svg xmlns="http://www.w3.org/2000/svg" class="delite" height="1em"
                    viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                </svg>
            </div>
        </div>
        <script>
            //delite_comformation
            $("svg.delite").on("click", function () {
                const user_confirm = confirm("Вы уверины что хотите удалить пользователя <?= $companion_nik ?>?");
                if (user_confirm) {
                    window.location.href = "../bd_send/user/messanger/delete_chat.php?chat_id=<?= $chat_id ?>";
                }
            });
        </script>
        <div class="content">
            <div class="chat_id">
                <?= $chat_id ?>
            </div>
            <div class="user_line">
                <div class="message_user">
                    <div class="user_child">
                        <div class="img">
                            <img src="../bd_send/user/user_icons/<?= $user_find_resolt["icon_path"] ?>" alt="">
                        </div>
                        <div class="user_information">
                            <b>
                                <?= $user_find_resolt["name"] ?>
                            </b>
                            <p>
                                <?= $companion_nik ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat <?= $block_class ?>">
                <div class="chat_wrapper">
                    <?php
                    if (isset($_SESSION["nik"])):
                        $message_sql = "SELECT * FROM `messages` WHERE `chat_id` = '$chat_id'";
                        $message_query = mysqli_query($bd_connect, $message_sql);
                        while ($message_resolt = mysqli_fetch_assoc($message_query)):
                            $message_class = null;
                            $recipient_user = $message_resolt['message_nik'];
                            if ($_SESSION["nik"] == $recipient_user) {
                                //delite_notification_reminder
                                $reminder_sql = "UPDATE `messages` SET `eye` = 1 WHERE `chat_id` = '$chat_id' AND `message_nik` = '$recipient_user'";
                                $reminder_query = mysqli_query($bd_connect, $reminder_sql);
                            }
                            if ($recipient_user == $_SESSION["nik"]) {
                                $message_class = "other_user";
                            } else {
                                $message_class = "my_user";
                            }
                            ?>
                            <div class="chat_row">
                                <div class="<?= $message_class ?> message">
                                    <div class="arrow_options">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p>
                                        <?= $message_resolt['message_value'] ?>
                                    </p>
                                    <div class="message_infrmation">
                                        <p>
                                            <?= substr($message_resolt['time'], 0, -3); ?>
                                        </p>
                                        <div class="tick">
                                            <?php
                                            if ($message_class == "my_user") {
                                                if ($message_resolt['eye'] == 0) {
                                                    echo '<img src="../res/send_tick.png" draggable="false" alt="">';
                                                } else {
                                                    echo '<img src="../res/eye_tick.png" draggable="false" alt="">';
                                                }
                                            } else {
                                                echo '<img src="../res/eye_tick.png" draggable="false" alt="">';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
            <?php
            if ($user_block !== true):
                ?>
                <!-- <form action="../bd_send/user/message_system.php?chat_id=<?= $_GET['chat_id'] ?>" method="post"
                enctype="multipart/form-data"> -->
                <div class="smile_choice">
                    <div class="smiles">
                        <div>😀</div>
                        <div>😃</div>
                        <div>😄</div>
                        <div>😁</div>
                        <div>😆</div>
                        <div>😅</div>
                        <div>😂</div>
                        <div>🤣</div>
                        <div>😊</div>
                        <div>😇</div>
                        <div>🙂</div>
                        <div>🙃</div>
                        <div>😉</div>
                        <div>😌</div>
                        <div>😍</div>
                        <div>🥰</div>
                        <div>😘</div>
                        <div>😗</div>
                        <div>😙</div>
                        <div>😚</div>
                        <div>😋</div>
                        <div>😛</div>
                        <div>😝</div>
                        <div>😜</div>
                        <div>🤪</div>
                        <div>🤨</div>
                        <div>🧐</div>
                        <div>🤓</div>
                        <div>😎</div>
                        <div>🤩</div>
                        <div>🥳</div>
                        <div>😏</div>
                        <div>😒</div>
                        <div>😞</div>
                        <div>😔</div>
                        <div>😟</div>
                        <div>😕</div>
                        <div>🙁</div>
                        <div>☹️</div>
                        <div>😣</div>
                        <div>😖</div>
                        <div>😫</div>
                        <div>😩</div>
                        <div>🥺</div>
                        <div>😢</div>
                        <div>😭</div>
                        <div>😮</div>
                        <div>😤</div>
                        <div>😠</div>
                        <div>😡</div>
                        <div>🤬</div>
                        <div>🤯</div>
                        <div>😳</div>
                        <div>🥵</div>
                        <div>🥶</div>
                        <div>😱</div>
                        <div>😨</div>
                        <div>😰</div>
                        <div>😥</div>
                        <div>😓</div>
                        <div>🤗</div>
                        <div>🤔</div>
                        <div>🤭</div>
                        <div>🤫</div>
                        <div>🤥</div>
                        <div>😶</div>
                        <div>😶</div>
                        <div>😐</div>
                        <div>😑</div>
                        <div>😬</div>
                        <div>🙄</div>
                        <div>😯</div>
                        <div>😦</div>
                        <div>😧</div>
                        <div>😮</div>
                        <div>😲</div>
                        <div>🥱</div>
                        <div>😴</div>
                        <div>🤤</div>
                        <div>😪</div>
                        <div>😵</div>
                        <div>😵</div>
                        <div>🤐</div>
                        <div>🥴</div>
                        <div>🤢</div>
                        <div>🤮</div>
                        <div>🤧</div>
                        <div>😷</div>
                        <div>🤒</div>
                        <div>🤕</div>
                        <div>🤑</div>
                        <div>🤠</div>
                        <div>😈</div>
                        <div>👿</div>
                        <div>👹</div>
                        <div>👺</div>
                        <div>🤡</div>
                        <div>💩</div>
                        <div>👻</div>
                        <div>💀</div>
                        <div>☠️</div>
                        <div>👽</div>
                        <div>👾</div>
                        <div>🤖</div>
                        <div>🎃</div>
                        <div>😺</div>
                        <div>😸</div>
                        <div>😹</div>
                        <div>😻</div>
                        <div>😼</div>
                        <div>😽</div>
                        <div>🙀</div>
                        <div>😿</div>
                        <div>😾</div>
                        <div>👋</div>
                        <div>🤚</div>
                        <div>🖐</div>
                        <div>✋</div>
                        <div>🖖</div>
                        <div>👌</div>
                        <div>🤏</div>
                        <div>✌️</div>
                        <div>🤞</div>
                        <div>🤟</div>
                        <div>🤘</div>
                        <div>🤙</div>
                        <div>👈</div>
                        <div>👉</div>
                        <div>👆</div>
                        <div>🖕</div>
                        <div>👇</div>
                        <div>☝️</div>
                        <div>👍</div>
                        <div>👎</div>
                        <div>✊</div>
                        <div>👊</div>
                        <div>🤛</div>
                        <div>🤜</div>
                        <div>👏</div>
                        <div>🙌</div>
                        <div>👐</div>
                        <div>🤲</div>
                        <div>🤝</div>
                        <div>🙏</div>
                        <div>✍️</div>
                        <div>💅</div>
                        <div>🤳</div>
                        <div>💪</div>
                        <div>🦾</div>
                        <div>🦵</div>
                        <div>🦿</div>
                        <div>🦶</div>
                        <div>👣</div>
                        <div>👂</div>
                        <div>🦻</div>
                        <div>👃</div>
                        <div>🧠</div>
                        <div>🦷</div>
                        <div>🦴</div>
                        <div>👀</div>
                        <div>👁</div>
                        <div>👅</div>
                        <div>👄</div>
                        <div>💋</div>
                        <div>🩸</div>
                        <div>🧳</div>
                        <div>🌂</div>
                        <div>☂️</div>
                        <div>🧵</div>
                        <div>🧶</div>
                        <div>👓</div>
                        <div>🕶</div>
                        <div>🥽</div>
                        <div>🥼</div>
                        <div>🦺</div>
                        <div>👔</div>
                        <div>👕</div>
                        <div>👖</div>
                        <div>🧣</div>
                        <div>🧤</div>
                        <div>🧥</div>
                        <div>🧦</div>
                        <div>👗</div>
                        <div>👘</div>
                        <div>🥻</div>
                        <div>🩱</div>
                        <div>🩲</div>
                        <div>🩳</div>
                        <div>👙</div>
                        <div>👚</div>
                        <div>👛</div>
                        <div>👜</div>
                        <div>👝</div>
                        <div>🎒</div>
                        <div>👞</div>
                        <div>👟</div>
                        <div>🥾</div>
                        <div>🥿</div>
                        <div>👠</div>
                        <div>👡</div>
                        <div>🩰</div>
                        <div>👢</div>
                        <div>👑</div>
                        <div>👒</div>
                        <div>🎩</div>
                        <div>🎓</div>
                        <div>🧢</div>
                        <div>⛑</div>
                        <div>🪖</div>
                        <div>💄</div>
                        <div>💍</div>
                        <div>💼</div>

                    </div>
                </div>
                <div class="form_children_wrapper">
                    <div class="nik"><input type="text" readonly name="message_nik" value="<?= $user_nik ?>"></div>
                    <div class="chat_menu">
                        <div class="choice_menu">
                            <div class="file_add">
                                <p>Добавить файл</p>
                                <input type="file" class="file_send" name="file_send">
                            </div>
                        </div>
                        <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg></div>
                    </div>
                    <div class="value_wrapper">
                        <textarea name="message_value" id="" class="right_in" placeholder="Ваше сообщение" cols="30"
                            rows="10"></textarea>
                        <div class="smile">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                            </svg>
                        </div>
                    </div>
                    <div><button>Отправить</button></div>
                </div>
                <!-- </form> -->
                <?php
            endif;
            if ($user_block == true) {
                echo "<div class='chat_block_information'><p>Данный чат заблокирован пользователем</p></div>";
            }
            ?>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/messanger/chat_choice.js"></script>
<script src="../page_js/messanger/chat.js"></script>
<script src="../page_js/messanger/send_menu.js"></script>
<script src="../page_js/messanger/smile_add.js"></script>
</body>

</html>