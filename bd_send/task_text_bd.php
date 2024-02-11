<?php
    include "database_connect.php";
    $task_description = $_POST["task_text"];
    $task_email = $_POST["task_email"];
    $sql = "INSERT INTO `task_text` (`id`, `task_description`, `task_email`) VALUES (NULL, '$task_description', '$task_email')";
    $query = mysqli_query($bd_connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../page_css/message_sended_timer.css">
    <title>Заявка на Bestlancer успешно отправлена!</title>
</head>
<body>
    <div class="timer_container">
        <div>
            <h2>Ваша заява успешно отправлена!</h2>
            <p>Вскоре мы ответим вам на 
                <b>
                    <?php
                        $task_email = $_POST["task_email"];
                        echo $task_email;
                    ?>
                </b>
            </p>
        </div>
        <div class="timer">
            <span>5</span>
        </div>
        <div class="page_back">
            <?php
                // Код PHP для перенаправления
                header("refresh: 5; url=http://localhost/bestlncer/"); // Перенаправляем через пять секунд
            ?>
        </div>
    </div>
    <script src="../page_js/message_sended_timer.js"></script>
</body>
</html>