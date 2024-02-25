<?php
session_start();
include "../database_connect.php";

if (isset($_GET['application_id']) && is_numeric($_GET['application_id'])) {
    $application_id = intval($_GET['application_id']);
    echo $application_id;
    exit;
    $sql = "SELECT * FROM orders_responses WHERE id = ?";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $application_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    if (!$query) {
        header("Location: ../warnings/web_error.php");
        die('Ошибка выполнения запроса: ' . mysqli_error($bd_connect));
    }

    $application = mysqli_fetch_assoc($query);

    if (!$application) {
        header("Location: ../warnings/application_not_found.php");
        exit();
    }

    $order_application_name = $application['order_name'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["message"]) && isset($_POST["price"]) && isset($_POST["time"])) {
        $user_message = $_POST["message"];
        $price = $_POST["price"];
        $time = $_POST["time"];
        $user_nik = $_SESSION["nik"];
        $stmt = mysqli_prepare($bd_connect, "UPDATE orders_responses SET user_message = ?, price = ?, time = ? WHERE order_name = ? AND nik = ?");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $user_message, $price, $time, $order_application_name, $user_nik);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                header("Location: ../warnings/web_error.php");
                die('Ошибка выполнения запроса: ' . mysqli_error($bd_connect));
            } else {
                header("Location: ../../pages/my_responses.php");
            }

            mysqli_stmt_close($stmt);
            exit();
        } else {
            header("Location: ../warnings/web_error.php");
            die('Ошибка подготовки запроса: ' . mysqli_error($bd_connect));
        }
    }
}
?>