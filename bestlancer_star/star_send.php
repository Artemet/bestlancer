<?php
session_start();
function email_warning()
{
    include "../database_connect.php";
    $email = $_SESSION["email"];
    $email_sql = "SELECT `email` FROM `reviews` WHERE `email` = ?";
    $stmt = mysqli_prepare($bd_connect, $email_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $email_query = mysqli_stmt_get_result($stmt);
    $email_row = mysqli_fetch_assoc($email_query);
    if ($email_row) {
        header("Location: ../../pages/home.php");
        exit;
    } else {
        $email_row = false;
    }
}
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
} else {
    include "../database_connect.php";
    $email = $_SESSION["email"];
    $my_nik = $_SESSION["nik"];
    $role = $_SESSION["role"];
    email_warning();
    $review = $_POST["user_review"];
    $stars = $_POST["star_number"];
    $type = "exchange";
    $date = date("Y-m-d");
    $date_resolt = null;
    list($year, $month, $day) = explode("-", $date);
    $date_array = array($year, $month, $day);
    for ($i = 0; $i < count($date_array); $i++) {
        if ($i >= 1) {
            $date_resolt .= ".";
        }
        $date_resolt .= $date_array[$i];
    }

    $sql = "INSERT INTO `reviews` (`id`, `nik`, `email`, `review`, `role`, `star`, `type`, `date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($bd_connect, $sql);
    mysqli_stmt_bind_param($stmt, "ssssiss", $my_nik, $email, $review, $role, $stars, $type, $date_resolt);
    mysqli_stmt_execute($stmt);


    header("Location: ../../pages/reviews.php");
}
?>