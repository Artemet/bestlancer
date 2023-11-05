<?php
session_start();
include "../database_connect.php";
if (isset($_SESSION["nik"])) {
    $nik = $_SESSION["nik"];
    //date
    setlocale(LC_TIME, 'ru_RU.utf8');
    $date = time();
    $formattedDate = strftime('%e %B, %Y', $date);
    //time
    date_default_timezone_set('Europe/Moscow');
    $message_time = date('Y-m-d H:i');
    //posts
    if (!empty($_FILES['file_send'])) {
        $file = $_FILES['file_send'];
        $file_name = $file['name'];
        $pathFile = __DIR__ . '/messanger_files/' . $file_name;
        move_uploaded_file($file['tmp_name'], $pathFile);
    }
    $message_value = $_POST["message_value"];
    $message_nik = $_POST["message_nik"];
    $message_nik = str_replace(" ", "", $message_nik);
    if (empty($message_value)) {
        header("Location: ../../pages/messages.php");
        exit();
    }
    if ($nik === $message_nik) {
        header("Location: ../../pages/home.php");
        exit();
    }
    $sql = "INSERT INTO messages (`id`, `date`, `message_value`, `file_path`, `time`, `eye`, `nik`, `message_nik`) VALUES (NULL, '$formattedDate', '$message_value', '$file_name', '$message_time', 'NO', '$nik', '$message_nik')";
    $query = mysqli_query($bd_connect, $sql);
    header("Location: ../../pages/messages.php");
} else {
    header("Location: ../../pages/home.php");
}
?>