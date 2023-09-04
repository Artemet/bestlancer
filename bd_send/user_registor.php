<?php
    include "database_connect.php";
    $nik = $_POST["user_nik"];
    $check_duplicate_sql = "SELECT COUNT(*) FROM `user_registoring` WHERE `nik` = '$nik'";
    $check_duplicate_query = mysqli_query($bd_connect, $check_duplicate_sql);
    $duplicate_count = mysqli_fetch_row($check_duplicate_query)[0];
    if ($duplicate_count > 0) {
        include "warnings/rong_nik.php";
    } else {
        include "positive/correct_registor.php";
        $email = $_POST["user_email"];
        $name = $_POST["user_name"];
        $family = $_POST["user_family"];
        $password = $_POST["user_password"];
        $code_word = $_POST["user_code_word"];
        $country = $_POST["user_country"];
        $age = $_POST["user_age"];
        $skills = $_POST["user_skills"];
        $about = $_POST["about_user"];
        $projects = $_POST["user_projects"];
        $time = $_POST["user_time"];
        $price = $_POST["user_price"];
        $icon_path = "user.png";

        $sql = "INSERT INTO `user_registoring` (`id`, `email`, `name`, `family`, `nik`, `password`, `code_word`, `country`, `age`, `skills`, `about`, `projects`, `work_time`, `price`, `icon_path`, `status`) VALUES (NULL, '$email', '$name', '$family', '$nik', '$password', '$code_word', '$country', '$age', '$skills', '$about', '$projects', '$time', '$price', '$icon_path', 'offline')";
        $query = mysqli_query($bd_connect, $sql);

        $to = $email; // Замените на адрес получателя
        $subject = "Успешная регестрация!"; // Замените на тему письма
        $message = "$name, ваш аккаунт успешно зарегестрирован на фриланс бирже Bestlancer. Начинайте редокцировать свой профиль и зарабатывать деньги с заказов. Балагадорим за ваш выбор!"; // Замените на текст сообщения

        $headers = "From: asharapov976@gmail.com" . "\r\n" .
                "Reply-To: $email"  . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "<p class'email_information'>Более подробную информация по развитию мы отправили на email <a href='' class='email_link'>$email</a></p>";
        } else {
            echo "<p class'email_information'>Ваш email недоступен</p>";
        }
    }
?>