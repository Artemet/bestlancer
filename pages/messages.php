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
            <div class="file">
                <input type="file" name="file_send">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                    viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z" />
                </svg>
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
</body>

</html>