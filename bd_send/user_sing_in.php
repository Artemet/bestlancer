<?php
session_start();

include "database_connect.php";

// $sing_information = [
//     "nik" => $_POST["nik_name"],
//     "password" => $_POST["password"]
// ];
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = $_SERVER['HTTP_REFERER'];
}
$nik = $_POST["nik_name"];
$password = $_POST["password"];
$status = "online";

$query = "SELECT * FROM user_registoring WHERE nik = ? AND password = ?";
$stmt = mysqli_prepare($bd_connect, $query);

mysqli_stmt_bind_param($stmt, "ss", $nik, $password);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION["id"] = $row["id"];
    $_SESSION["nik"] = $nik;
    $_SESSION["email"] = $row["email"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["family"] = $row["family"];
    $_SESSION["country"] = $row["country"];
    $_SESSION["age"] = $row["age"];
    $_SESSION["about"] = $row["about"];
    $_SESSION["skills"] = $row["skills"];
    $_SESSION["projects"] = $row["projects"];
    $_SESSION["payment_methods"] = $row["payment_methods"];
    $_SESSION["work_time"] = $row["work_time"];
    $_SESSION["price"] = $row["price"];
    $_SESSION["icon_path"] = $row["icon_path"];
    $_SESSION["notification"] = $row["notification"];
    $_SESSION["role"] = $row["role"];
    $status = mysqli_real_escape_string($bd_connect, $status);

    $status_sql = "UPDATE `user_registoring` SET `status` = ? WHERE `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $status_sql);

    mysqli_stmt_bind_param($stmt, "ss", $status, $nik);

    mysqli_stmt_execute($stmt);

    $_SESSION["loggedin"] = true;

    header("Location: $previous_page");
    exit();
} else {
    include "warnings/rong_sing_in.php";
}
?>