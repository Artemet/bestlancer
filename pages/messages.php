<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
    exit;
}
$user_nik = $_SESSION["nik"];
include "../bd_send/database_connect.php";
$chat_bg = $user_resolt['chat_bg'];
//notification_remove
$user_nik = $_SESSION["nik"];
$notification_sql = "UPDATE `user_notification` SET `messages` = 0 WHERE `nik` = ?";
$notification_stmt = mysqli_prepare($bd_connect, $notification_sql);
mysqli_stmt_bind_param($notification_stmt, "s", $user_nik);
mysqli_stmt_execute($notification_stmt);

include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/messages.css'>";
echo "<link rel='stylesheet' href='../page_css/media/messages_media.css'>";
echo "<link rel='stylesheet' href='../page_css/modal_css/report_modal.css'>";
echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital@1&display=swap" rel="stylesheet">';
echo "<title>Мессенджер</title>";
include "../layouts/header_line.php";
include "../layouts/modal/messanger/complaint_modal.php";
if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
    $chat_id = $_GET["chat_id"];
    echo "<noscript class='chat_id'>$chat_id</noscript>";
}
?>
<div class="container messanger_container">
    <div class="messanger_users">
        <?php
        $attach_temp = 0;
        $attach_index = 1;
        $deleted_index = 0;
        $attach_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `attach` = ? AND `deleted` = ?";
        $stmt = mysqli_prepare($bd_connect, $attach_sql);
        mysqli_stmt_bind_param($stmt, "ssii", $user_nik, $user_nik, $attach_index, $deleted_index);
        mysqli_stmt_execute($stmt);
        $attach_query = mysqli_stmt_get_result($stmt);
        while ($user_row = mysqli_fetch_assoc($attach_query)):
            $attach_temp++;
            if ($attach_temp == 1):
                ?>
                <div class="information_line">
                    <p>Закрепленные чаты</p>
                </div>
                <?php
            endif;
            ?>
            <a href="?chat_id=<?= $user_row['chat_id'] ?>" id="<?= $user_row['chat_id'] ?>" class="chat_link">
                <div class="message_user attached_user">
                    <?php
                    $interlocutor_nik = null;
                    if ($_SESSION["nik"] === $user_row["nik_two"]) {
                        $interlocutor_nik = $user_row["nik_one"];
                    } else {
                        $interlocutor_nik = $user_row["nik_two"];
                    }
                    $interlocutor_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $interlocutor_sql);
                    mysqli_stmt_bind_param($stmt, "s", $interlocutor_nik);
                    mysqli_stmt_execute($stmt);
                    $interlocutor_query = mysqli_stmt_get_result($stmt);
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
                    $chat_number = $user_row["chat_id"];
                    $eye_index = 0;
                    $none_see_message_sql = "SELECT * FROM `messages` WHERE `eye` = ? AND `message_nik` = ? AND `chat_id` = ?";
                    $stmt = mysqli_prepare($bd_connect, $none_see_message_sql);
                    mysqli_stmt_bind_param($stmt, "iss", $eye_index, $user_nik, $chat_number);
                    mysqli_stmt_execute($stmt);
                    $none_see_message_query = mysqli_stmt_get_result($stmt);
                    while ($none_see_resolt = mysqli_fetch_assoc($none_see_message_query)) {
                        $message_count++;
                    }
                    if ($message_count >= 1 && $user_row["mute"] == 0):
                        ?>
                        <div class="notification_number">
                            <p>
                                <?= $message_count ?>
                            </p>
                        </div>
                        <?php
                    endif;
                    ?>
                    <div class="chat_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                            viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path
                                d="M32 32C32 14.3 46.3 0 64 0H320c17.7 0 32 14.3 32 32s-14.3 32-32 32H290.5l11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3H32c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64H64C46.3 64 32 49.7 32 32zM160 384h64v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V384z" />
                        </svg>
                    </div>
                </div>
            </a>
            <?php
        endwhile;
        $users_temp = 0;
        $attach_index = 0;
        $deleted_index = 0;
        $user_sql = "SELECT * FROM `messenger_users` WHERE (`nik_one` = ? OR `nik_two` = ?) AND `attach` = ? AND `deleted` = ?";
        $stmt = mysqli_prepare($bd_connect, $user_sql);
        mysqli_stmt_bind_param($stmt, "ssii", $user_nik, $user_nik, $attach_index, $deleted_index);
        mysqli_stmt_execute($stmt);
        $user_query = mysqli_stmt_get_result($stmt);
        while ($user_row = mysqli_fetch_assoc($user_query)):
            $users_temp++;

            if ($users_temp == 1):
                ?>
                <div class="information_line">
                    <p>Все чаты</p>
                </div>
                <?php
            endif;
            ?>
            <a href="?chat_id=<?= $user_row['chat_id'] ?>" id="<?= $user_row['chat_id'] ?>" class="chat_link">
                <div class="message_user">
                    <?php
                    $interlocutor_nik = null;
                    if ($_SESSION["nik"] === $user_row["nik_two"]) {
                        $interlocutor_nik = $user_row["nik_one"];
                    } else {
                        $interlocutor_nik = $user_row["nik_two"];
                    }
                    $interlocutor_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
                    $stmt = mysqli_prepare($bd_connect, $interlocutor_sql);
                    mysqli_stmt_bind_param($stmt, "s", $interlocutor_nik);
                    mysqli_stmt_execute($stmt);
                    $interlocutor_query = mysqli_stmt_get_result($stmt);
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
                    $chat_number = $user_row["chat_id"];
                    $eye_index = 0;
                    $none_see_message_sql = "SELECT * FROM `messages` WHERE `eye` = ? AND `message_nik` = ? AND `chat_id` = ?";
                    $none_see_message_stmt = mysqli_prepare($bd_connect, $none_see_message_sql);
                    mysqli_stmt_bind_param($none_see_message_stmt, "iss", $eye_index, $user_nik, $chat_number);
                    mysqli_stmt_execute($none_see_message_stmt);
                    $none_see_message_query = mysqli_stmt_get_result($none_see_message_stmt);
                    while ($none_see_resolt = mysqli_fetch_assoc($none_see_message_query)) {
                        $message_count++;
                    }
                    if ($message_count >= 1 && $user_row["mute"] == 0):
                        ?>
                        <div class="notification_number">
                            <p>
                                <?= $message_count ?>
                            </p>
                        </div>
                        <?php
                    endif;
                    if ($user_row["mute"] >= 1):
                        ?>
                        <div class="chat_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                <path
                                    d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7l-90.2-70.7c.2-.4 .4-.9 .6-1.3c5.2-11.5 3.1-25-5.3-34.4l-7.4-8.3C497.3 319.2 480 273.9 480 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V51.2c-42.6 8.6-79 34.2-102 69.3L38.8 5.1zM406.2 416L160 222.1v4.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S115.4 416 128 416H406.2zm-40.9 77.3c12-12 18.7-28.3 18.7-45.3H320 256c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                            </svg>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </a>
            <?php
        endwhile;
        if ($users_temp <= 0 && $attach_temp <= 0) {
            echo "<div class='no_companions'><p>Нет собеседников</p></div>";
        }
        ?>
    </div>
    <div class="user_chat">
        <?php
        if (isset($_GET["chat_id"]) && is_numeric($_GET["chat_id"])) {
            $chat_id = $_GET['chat_id'];
            echo '<script src="../page_js/messanger/chat_choice.js" type="module"></script>';
            echo '<script src="../page_js/messanger/chat.js" type="module"></script>';
            echo '<script src="../local_js/account_menu.js"></script>';
        } else {
            echo "<div class='companion_choice'><p>Выбирите собеседника</p></div>";
            echo "<div class='content'></div>";
            echo '<script src="../page_js/messanger/chat_choice.js" type="module"></script>';
            echo '<script src="../page_js/messanger/chat.js" type="module"></script>';
            echo '<script src="../local_js/account_menu.js"></script>';
            exit;
        }
        $companion_nik = null;
        $companion_sql = "SELECT * FROM `messenger_users` WHERE `chat_id` = ?";
        $companion_stmt = mysqli_prepare($bd_connect, $companion_sql);
        mysqli_stmt_bind_param($companion_stmt, "i", $chat_id);
        mysqli_stmt_execute($companion_stmt);
        $companion_query = mysqli_stmt_get_result($companion_stmt);
        $companion_resolt = mysqli_fetch_assoc($companion_query);
        if ($companion_resolt == null) {
            echo "<div class='companion_choice'><p>Выбирите собеседника</p></div>";
            echo "<div class='content'></div>";
            echo '<script src="../page_js/messanger/chat_choice.js" type="module"></script>';
            echo '<script src="../page_js/messanger/chat.js" type="module"></script>';
            echo '<script src="../local_js/account_menu.js"></script>';
            exit;
        }
        if ($companion_resolt["nik_one"] == $_SESSION["nik"]) {
            $companion_nik = $companion_resolt["nik_two"];
        } elseif ($companion_resolt["nik_two"] == $_SESSION["nik"]) {
            $companion_nik = $companion_resolt["nik_one"];
        } else {
            echo "<div class='companion_choice'><p>Выбирите собеседника</p></div>";
            echo "<div class='content'></div>";
            echo '<script src="../page_js/messanger/chat_choice.js" type="module"></script>';
            echo '<script src="../page_js/messanger/chat.js" type="module"></script>';
            echo '<script src="../local_js/account_menu.js"></script>';
            exit;
        }
        //user_find
        $user_find_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
        $user_find_stmt = mysqli_prepare($bd_connect, $user_find_sql);
        mysqli_stmt_bind_param($user_find_stmt, "s", $companion_nik);
        mysqli_stmt_execute($user_find_stmt);
        $user_find_query = mysqli_stmt_get_result($user_find_stmt);
        $user_find_resolt = mysqli_fetch_assoc($user_find_query);
        //user_block
        $user_block = false;
        $blocking_id = null;
        $block_class = null;
        $user_block_sql = "SELECT * FROM `messenger_users` WHERE `main_block` = ? OR `main_block` = ?";
        $user_block_stmt = mysqli_prepare($bd_connect, $user_block_sql);
        mysqli_stmt_bind_param($user_block_stmt, "ss", $user_nik, $companion_nik);
        mysqli_stmt_execute($user_block_stmt);
        $user_block_query = mysqli_stmt_get_result($user_block_stmt);
        while ($user_block_resolt = mysqli_fetch_assoc($user_block_query)) {
            $blocking_id = $user_block_resolt['chat_id'];
            if ($_GET['chat_id'] == $blocking_id) {
                $user_block = true;
                $block_class = "blocked_chat";
            }
        }
        ?>
        <div class="content">
            <div class="companion_options">
                <div title="Закрепить пользователя" class="attach" id="<?= $companion_resolt["attach"] ?>">
                    <?php
                    if ($companion_resolt["attach"] == 0):
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="none_save" title="Сохранить" height="1em"
                            viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z">
                            </path>
                        </svg>
                        <?php
                    endif;
                    if ($companion_resolt["attach"] == 1):
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" class="none_save"
                            viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path
                                d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                        </svg>
                        <?php
                    endif;
                    ?>
                </div>
                <div title="Перезагрузить чат" class="chat_reload">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                    </svg>
                </div>
                <div class="more_options">
                    <div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path
                                d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                        </svg></div>
                    <div class="sub_menu">
                        <?php
                        if ($companion_resolt["mute"] == 0) {
                            echo '<div class="option mute"><div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L542.6 400c2.7-7.8 1.3-16.5-3.9-23l-14.9-18.6C495.5 322.9 480 278.8 480 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V51.2c-42.6 8.6-79 34.2-102 69.3L38.8 5.1zM224 150.3C243.6 117.7 279.3 96 320 96c61.9 0 112 50.1 112 112v25.4c0 32.7 6.4 64.8 18.7 94.5L224 150.3zM406.2 416l-60.9-48H168.3c21.2-32.8 34.4-70.3 38.4-109.1L160 222.1v11.4c0 45.4-15.5 89.5-43.8 124.9L101.3 377c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6H406.2zM384 448H320 256c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/></svg></div>
                            <div><p>Отключить</p></div></div>';
                        } else {
                            echo '<div class="option mute muted"><div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/></svg></div>
                            <div><p>Включить</p></div></div>';
                        }
                        ?>
                        <div class="option chat_complaint">
                            <div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                    <path
                                        d="M48 24C48 10.7 37.3 0 24 0S0 10.7 0 24V64 350.5 400v88c0 13.3 10.7 24 24 24s24-10.7 24-24V388l80.3-20.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L48 52V24zm0 77.5l96.6-24.2c27-6.7 55.5-3.6 80.4 8.8c54.9 27.4 118.7 29.7 175 6.8V334.7l-24.4 9.1c-33.7 12.6-71.2 10.7-103.4-5.4c-48.2-24.1-103.3-30.1-155.6-17.1L48 338.5v-237z" />
                                </svg></div>
                            <div>
                                <p>Пожаловаться</p>
                            </div>
                        </div>
                        <?php
                        if (empty($companion_resolt["main_block"]) || $companion_resolt["main_block"] == $user_nik):
                            ?>
                            <div class="option user_block">
                                <?php
                                $block_information = null;
                                if ($companion_resolt["main_block"] == $user_nik) {
                                    $block_information = "Разблокировать";
                                } else {
                                    $block_information = "Заблокировать";
                                }
                                ?>
                                <div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path
                                            d="M256 0c-25.3 0-47.2 14.7-57.6 36c-7-2.6-14.5-4-22.4-4c-35.3 0-64 28.7-64 64V261.5l-2.7-2.7c-25-25-65.5-25-90.5 0s-25 65.5 0 90.5L106.5 437c48 48 113.1 75 181 75H296h8c1.5 0 3-.1 4.5-.4c91.7-6.2 165-79.4 171.1-171.1c.3-1.5 .4-3 .4-4.5V160c0-35.3-28.7-64-64-64c-5.5 0-10.9 .7-16 2V96c0-35.3-28.7-64-64-64c-7.9 0-15.4 1.4-22.4 4C303.2 14.7 281.3 0 256 0zM240 96.1c0 0 0-.1 0-.1V64c0-8.8 7.2-16 16-16s16 7.2 16 16V95.9c0 0 0 .1 0 .1V232c0 13.3 10.7 24 24 24s24-10.7 24-24V96c0 0 0 0 0-.1c0-8.8 7.2-16 16-16s16 7.2 16 16v55.9c0 0 0 .1 0 .1v80c0 13.3 10.7 24 24 24s24-10.7 24-24V160.1c0 0 0-.1 0-.1c0-8.8 7.2-16 16-16s16 7.2 16 16V332.9c-.1 .6-.1 1.3-.2 1.9c-3.4 69.7-59.3 125.6-129 129c-.6 0-1.3 .1-1.9 .2H296h-8.5c-55.2 0-108.1-21.9-147.1-60.9L52.7 315.3c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L119 336.4c6.9 6.9 17.2 8.9 26.2 5.2s14.8-12.5 14.8-22.2V96c0-8.8 7.2-16 16-16c8.8 0 16 7.1 16 15.9V232c0 13.3 10.7 24 24 24s24-10.7 24-24V96.1z" />
                                    </svg></div>
                                <div>
                                    <p class="<?= $companion_resolt["status"] ?>">
                                        <?= $block_information ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div class="special_line"></div>
                        <div class="option special_option delete_chat">
                            <div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                    <path
                                        d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                                </svg></div>
                            <div>
                                <p>Удалить</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <?php
                            $user_id_sql = "SELECT `id` FROM `user_registoring` WHERE `nik` = ?";
                            $user_id_stmt = mysqli_prepare($bd_connect, $user_id_sql);
                            mysqli_stmt_bind_param($user_id_stmt, "s", $companion_nik);
                            mysqli_stmt_execute($user_id_stmt);
                            $user_id_query = mysqli_stmt_get_result($user_id_stmt);
                            $user_id_resolt = mysqli_fetch_assoc($user_id_query)['id'];
                            ?>
                            <a href="user_page.php?user_id=<?= $user_id_resolt ?>" target="_blank">
                                <?= $companion_nik ?>
                            </a>
                            <div class="chat_number">
                                <?php
                                $chat_id_sql = "SELECT `chat_id` FROM `messenger_users` WHERE (`nik_one` = ? AND `nik_two` = ?) OR (`nik_one` = ? AND `nik_two` = ?)";
                                $chat_id_stmt = mysqli_prepare($bd_connect, $chat_id_sql);
                                mysqli_stmt_bind_param($chat_id_stmt, "ssss", $user_nik, $companion_nik, $companion_nik, $user_nik);
                                mysqli_stmt_execute($chat_id_stmt);
                                $chat_id_query = mysqli_stmt_get_result($chat_id_stmt);
                                $chat_id_resolt = mysqli_fetch_assoc($chat_id_query)['chat_id'];
                                echo "$chat_id_resolt";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($companion_resolt['message_attach'] >= 1 && $user_block == false):
                    $message_attach_id = $companion_resolt['message_attach'];
                    $message_attach_sql = "SELECT * FROM `messages` WHERE `id` = ?";
                    $stmt = mysqli_prepare($bd_connect, $message_attach_sql);
                    mysqli_stmt_bind_param($stmt, "i", $message_attach_id);
                    mysqli_stmt_execute($stmt);
                    $message_attach_query = mysqli_stmt_get_result($stmt);
                    $message_attach_resolt = mysqli_fetch_assoc($message_attach_query);
                    ?>
                    <a href="#<?= $message_attach_resolt['id'] ?>" class="attach_link scroll_control">
                        <div class="attach_line">
                            <div class="message_wrapper">
                                <p class="informing">Закрепленное сообщение</p>
                                <div>
                                    <p class="attach_message">
                                        <?php
                                        if (empty($message_attach_resolt['message_value']) && $message_attach_resolt['file'] == 1) {
                                            echo "Файл";
                                        } else {
                                            echo $message_attach_resolt['message_value'];
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="cross_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                    <path
                                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <?php
                endif;
                ?>
            </div>
            <div class="chat <?= $block_class ?>" style='background-image: url("<?= $chat_bg ?>");'>
                <div class="chat_wrapper">
                    <?php
                    if (isset($_SESSION["nik"])):
                        $message_sql = "SELECT * FROM `messages` WHERE `chat_id` = ?";
                        $stmt = mysqli_prepare($bd_connect, $message_sql);
                        mysqli_stmt_bind_param($stmt, "s", $chat_id);
                        mysqli_stmt_execute($stmt);
                        $message_query = mysqli_stmt_get_result($stmt);
                        $lastDisplayedDate = null;
                        $task_message_temp = 0;
                        while ($message_resolt = mysqli_fetch_assoc($message_query)):
                            $message_class = null;
                            $recipient_user = $message_resolt['message_nik'];

                            if ($message_resolt['task'] == 1) {
                                $task_message_temp++;
                            } elseif ($message_resolt['task'] == 2) {
                                $task_message_temp = 2;
                            } elseif ($message_resolt['task'] == 3) {
                                $task_message_temp = 3;
                            } else {
                                $task_message_temp = 0;
                            }

                            if ($_SESSION["nik"] == $recipient_user) {
                                //delete_notification_reminder
                                $reminder_sql = "UPDATE `messages` SET `eye` = 1 WHERE `chat_id` = ? AND `message_nik` = ?";
                                $stmt = mysqli_prepare($bd_connect, $reminder_sql);
                                mysqli_stmt_bind_param($stmt, "ss", $chat_id, $recipient_user);
                                mysqli_stmt_execute($stmt);
                            }
                            if ($recipient_user == $_SESSION["nik"]) {
                                $message_class = "other_user";
                            } else {
                                $message_class = "my_user";
                            }

                            if (($message_resolt['deleted'] == 1 && $message_class == "other_user") || ($message_resolt['deleted'] == 0 && $message_class == "my_user") || ($message_resolt['deleted'] == 0 && $message_class == "other_user")):
                                if ($message_resolt['deleted'] == 1) {
                                    $message_class .= " deleted_row";
                                }
                                if (!empty($message_resolt['message_value']) || $message_resolt['file'] >= 1):
                                    if ($task_message_temp == 1 || $task_message_temp == 2 || $task_message_temp == 3):
                                        ?>
                                        <div class="order_line">
                                            <div>
                                                <?php
                                                if ($task_message_temp == 1) {
                                                    echo "<p>Выполнение заказа</p>";
                                                } elseif ($task_message_temp == 2) {
                                                    echo "<p>Заказ завершён</p>";
                                                } elseif ($task_message_temp == 3) {
                                                    echo "<p>Заказ отменён</p>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    endif;
                                    ?>
                                    <div class="chat_row" id="<?= $message_resolt['id'] ?>">
                                        <?php
                                        if ($lastDisplayedDate != $message_resolt['date']):
                                            ?>
                                            <div class="date_wrapper">
                                                <div class="date"><b>
                                                        <?php
                                                        $moment_date = date('d.m.Y');
                                                        if ($moment_date == $message_resolt['date']) {
                                                            echo "Сегодня";
                                                        } else {
                                                            echo $message_resolt['date'];
                                                        }
                                                        ?>
                                                    </b></div>
                                            </div>
                                            <?php
                                            $lastDisplayedDate = $message_resolt['date'];
                                        endif;
                                        ?>
                                        <div class="<?= $message_class ?> message arrow_stay">
                                            <?php
                                            if ($message_resolt['deleted'] == 0):
                                                ?>
                                                <div class="message_menu">
                                                    <?php
                                                    if ($message_class == "my_user") {
                                                        if (!empty($message_resolt['message_value'])) {
                                                            echo '<div><p class="delete">Удалить</p></div>
                                                            <div><p class="change last_option">Изменить</p></div>
                                                            <div><p class="answer last_option">Ответить</p></div>
                                                            <div><p class="message_attach last_option">Закрепить</p></div>
                                                            ';
                                                        } else {
                                                            echo '<div><p class="delete">Удалить</p></div>
                                                            <div><p class="answer last_option">Ответить</p></div>
                                                            <div><p class="message_attach last_option">Закрепить</p></div>
                                                            ';
                                                        }
                                                    } else {
                                                        echo '
                                            <div><p class="answer">Ответить</p></div>
                                            <div><p class="message_attach last_option">Закрепить</p></div>
                                            ';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="arrow_options">
                                                    <div class="arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                            <path
                                                                d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <?php
                                            endif;
                                            if ($message_resolt['answer'] >= 1 && $message_resolt['deleted'] == 0):
                                                $answerd_id = $message_resolt['answer'];
                                                $answerd_sql = "SELECT * FROM `messages` WHERE `id` = ?";
                                                $answerd_stmt = mysqli_prepare($bd_connect, $answerd_sql);
                                                mysqli_stmt_bind_param($answerd_stmt, "i", $answerd_id);
                                                mysqli_stmt_execute($answerd_stmt);
                                                $answerd_query = mysqli_stmt_get_result($answerd_stmt);
                                                $answerd_resolt = mysqli_fetch_assoc($answerd_query);
                                                ?>
                                                <div class="answer_wrapper">
                                                    <a href="#<?= $answerd_resolt['id'] ?>" class="scroll_control">
                                                        <div class="information">
                                                            <div><b>Сообщение</b></div>
                                                            <div>
                                                                <p class="message_value">
                                                                    <?php
                                                                    if (!empty($answerd_resolt['message_value'])) {
                                                                        echo $answerd_resolt['message_value'];
                                                                    } else {
                                                                        echo $answerd_resolt['file_path'];
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php
                                            endif;
                                            if ($message_resolt['file'] >= 1):
                                                ?>
                                                <div class="file_wrapper">
                                                    <a href="../bd_send/user/messanger_files/<?= $message_resolt['file_path'] ?>"
                                                        target="_blank">
                                                        <?php
                                                        $file_class = null;
                                                        $file_title = null;
                                                        if ($message_resolt['deleted'] == 0):
                                                            if (strpos($message_resolt['file_path'], ".zip") == true || strpos($message_resolt['file_path'], ".txt") == true || strpos($message_resolt['file_path'], ".pdf") == true) {
                                                                $file_class = "file_download";
                                                                $file_title = "Скачать";
                                                            }
                                                            ?>
                                                            <div class="file_object <?= $file_class ?>" title="<?= $file_title ?>">
                                                                <?php
                                                                $fileSize = null;
                                                                if (strpos($message_resolt['file_path'], ".png") == false && strpos($message_resolt['file_path'], ".jpg") == false) {
                                                                    $my_file = $message_resolt['file_path'];
                                                                    $fileSize = round(filesize("../bd_send/user/messanger_files/$my_file") / 1024);
                                                                }
                                                                if (strpos($message_resolt['file_path'], ".png") == true || strpos($message_resolt['file_path'], ".jpg") == true) {
                                                                    echo '<img src="../bd_send/user/messanger_files/' . $message_resolt['file_path'] . '"
                                                                    alt="" draggable="false">';
                                                                } elseif (strpos($message_resolt['file_path'], ".zip") == true) {
                                                                    echo '<div class="file_wrapper_object">
                                                                        <div><svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM96 48c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm-6.3 71.8c3.7-14 16.4-23.8 30.9-23.8h14.8c14.5 0 27.2 9.7 30.9 23.8l23.5 88.2c1.4 5.4 2.1 10.9 2.1 16.4c0 35.2-28.8 63.7-64 63.7s-64-28.5-64-63.7c0-5.5 .7-11.1 2.1-16.4l23.5-88.2zM112 336c-8.8 0-16 7.2-16 16s7.2 16 16 16h32c8.8 0 16-7.2 16-16s-7.2-16-16-16H112z"/></svg></div>
                                                                        <div class="file_information">
                                                                            <div><b>' . $message_resolt['file_path'] . '</b></div>
                                                                            <div><p>' . $fileSize . ' Кб</p></div>
                                                                        </div>
                                                                    </div>';
                                                                } elseif (strpos($message_resolt['file_path'], ".txt") == true) {
                                                                    echo '<div class="file_wrapper_object">
                                                                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg></div>
                                                                        <div class="file_information">
                                                                            <div><b>' . $message_resolt['file_path'] . '</b></div>
                                                                            <div><p>' . $fileSize . ' Кб</p></div>
                                                                        </div>
                                                                    </div>';
                                                                } elseif (strpos($message_resolt['file_path'], ".pdf") == true) {
                                                                    echo '<div class="file_wrapper_object">
                                                                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 144-208 0c-35.3 0-64 28.7-64 64l0 144-48 0c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"/></svg></div>
                                                                        <div class="file_information">
                                                                            <div><b>' . $message_resolt['file_path'] . '</b></div>
                                                                            <div><p>' . $fileSize . ' Кб</p></div>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php
                                                        endif;
                                                        ?>
                                                    </a>
                                                </div>
                                                <?php
                                            endif;
                                            ?>
                                            <p class="message_value main_value" title="<?= $message_resolt['message_value'] ?>">
                                                <?= $message_resolt['message_value'] ?>
                                            </p>
                                            <div class="message_infrmation">
                                                <?php
                                                if ($message_resolt['changeable'] >= 1 && $message_class == "other_user") {
                                                    echo "<div class='changeable_text'><p>изменено</p></div>";
                                                }
                                                ?>
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
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            endif;
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
            <?php
            if ($user_block !== true):
                ?>
                <div class="answer_line">
                    <div class="answer_message">
                        <b>Ответ на сообщение</b>
                        <div>
                            <p>Сообщение на которое хочу ответить...</p>
                        </div>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                            viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </div>
                </div>
                <div class="file_line"></div>
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
                        <input type="file" name="file" id="icon_choice">
                        <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                <path
                                    d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z" />
                            </svg></div>
                    </div>
                    <div class="value_wrapper">
                        <input type="text" name="message_value" id="" class="right_in message_right"
                            placeholder="Ваше сообщение...">
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
                <?php
            endif;
            if ($user_block == true) {
                echo "<div class='chat_block_information'><p>Данный чат заблокирован пользователем</p></div>";
            }
            ?>
        </div>
    </div>
</div>
<script src="../page_js/messanger/chat_choice.js" type="module"></script>
<script src="../page_js/messanger/chat.js"></script>
<script src="../page_js/messanger/smile_add.js" type="module"></script>
<script src="../page_js/messanger/answer.js" type="module"></script>
<script src="../page_js/messanger/file_choice.js" type="module"></script>

<script src="../local_js/scroll.js"></script>
<script src="../local_js/menu.js"></script>
<script src="../local_js/app.js"></script>
<script src="../local_js/scroll_time.js"></script>
</body>

</html>