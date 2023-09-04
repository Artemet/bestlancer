<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Адрес, на который отправляется письмо
    $toEmail = 'asharapov976@gmail.com';

    // Тема письма
    $subject = 'Письмо с формы обратной связи';

    // Получение данных из формы
    $email = $_POST['email'];
    $message = $_POST['message'];
    $attachment = $_FILES['attachment'];

    // Создаем уникальную границу для разделения частей письма
    $boundary = md5(uniqid());

    // Создаем заголовки письма
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Создаем тело письма
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= $message . "\r\n\r\n";

    if ($attachment['error'] === UPLOAD_ERR_OK) {
        // Если файл прикреплен успешно, добавляем его к письму
        $fileName = $attachment['name'];
        $fileContent = file_get_contents($attachment['tmp_name']);
        $fileEncoded = base64_encode($fileContent);

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"$fileName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
        $body .= chunk_split($fileEncoded) . "\r\n";
    }

    $body .= "--$boundary--";

    // Отправляем письмо
    if (mail($toEmail, $subject, $body, $headers)) {
        echo 'Письмо успешно отправлено!';
    } else {
        echo 'Ошибка при отправке письма.';
    }
}
header("location: ../pages/support_user.php");
?>
