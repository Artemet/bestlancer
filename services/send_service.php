<?php
session_start();
include "../database_connect.php";
$category = $_POST["category"];
$service_name = $_POST["service_name"];
$service_information = $_POST["service_information"];
$service_price = $_POST["service_price"];
$user_nik = $_SESSION["nik"];
$category_arr = array("Дизайн", "Разработка и IT", "Тексты и переводы", "SEO и трафик", "Соцсети и реклама", "Аудио, видео, съемка", "Бизнес и жизнь", "Учеба и репетиторство");
if (!empty($_FILES['file_send'])) {
    $file = $_FILES['file_send'];
    $file_name = $file['name'];
    $pathFile = __DIR__ . '/service_files/' . $file_name;
    if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
        echo 'Ошибка';
    }
}
if (empty($file_name)) {
    $file_name = "no-photo-available.png";
} else {
    $allowed_formats = array("jpg", "jpeg", "png");
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_formats)) {
        $file_name = "no-photo-available.png";
    }
}
if (empty($service_name) || empty($service_information) || empty($service_price) || !in_array($category, $category_arr)) {
    header("location: ../../pages/make_services.php");
    exit();
} else {
    $sql = "INSERT INTO `services` (`id`, `category`, `file_path`, `name`, `information`, `price`, `nik`) VALUES (NULL, '$category', '$file_name', '$service_name', '$service_information', '$service_price', '$user_nik')";
    $query = mysqli_query($bd_connect, $sql);
    header("location: ../../pages/services.php");
}
?>