<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
    exit;
}
$user_nik = $_SESSION["nik"];
include "../bd_send/database_connect.php";
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
                ?>
                <div class="img">
                    <img src="../bd_send/user/user_icons/<?= $interlocutor_get['icon_path'] ?>" alt="">
                </div>
                <div class="user_information">
                    <b>
                        <?= $interlocutor_get['name'] ?>
                    </b>
                    <p>
                        <?= $interlocutor_get['nik'] ?>
                    </p>
                </div>
            </div>
            <?php
        endwhile;
        ?>
    </div>
    <div class="user_chat">
        <div class="user_line">
            <div class="message_user">
                <div class="img">
                    <img src="../res/user.png" alt="">
                </div>
                <div class="user_information">
                    <b></b>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="chat">
            <?php
            if (isset($_SESSION["nik"])) {

                $sql = "SELECT * FROM messages WHERE message_nik = ? OR nik = ? ORDER BY time ASC";
                $stmt = mysqli_prepare($bd_connect, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $user_nik, $user_nik);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $previous_date = null;

                while ($row = mysqli_fetch_assoc($result)):
                    $message_class = ($row['nik'] == $user_nik) ? 'my_user' : 'other_user';

                    if ($row['date'] !== $previous_date) {
                        echo '<div class="chat_row"><div class="date"><b>' . $row['date'] . '</b></div></div>';
                        $previous_date = $row['date'];
                    }

                    ?>
                    <div class="chat_row">
                        <div class="<?= $message_class ?> message">
                            <p>
                                <?= $row['message_value'] ?>
                            </p>
                            <div class="message_infrmation">
                                <p>
                                    <?= $row['time'] ?>
                                </p>
                                <?php
                                $message_check = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">';
                                if ($message_class != "other_user") {
                                    if ($_SESSION['nik'] == $row["message_nik"]) {
                                        $message_check .= '<path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>';
                                    } else {
                                        $message_check .= '<path d="M342.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 178.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l80 80c12.5 12.5 32.8 12.5 45.3 0l160-160zm96 128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 402.7 54.6 297.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l256-256z"/>';
                                    }
                                }
                                $message_check .= '</svg>';
                                echo $message_check;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
            }
            ?>
        </div>
        <form action="../bd_send/user/message_system.php" method="post" enctype="multipart/form-data">
            <div class="nik"><input type="text" readonly name="message_nik" value="<?= $user_nik ?>"></div>
            <div class="chat_menu">
                <div class="choice_menu">
                    <div class="file_add">
                        <p>Добавить файл</p>
                        <input type="file" class="file_send" name="file_send">
                    </div>
                    <div><p>Добавить смайл</p></div>
                </div>
                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg></div>
            </div>
            <div><textarea name="message_value" id="" class="right_in" placeholder="Ваше сообщение" cols="30"
                    rows="10"></textarea></div>
            <div><button>Отправить</button></div>
        </form>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/messanger/chat_choice.js"></script>
<script src="../page_js/messanger/chat.js"></script>
<script src="../page_js/messanger/send_menu.js"></script>
</body>

</html>