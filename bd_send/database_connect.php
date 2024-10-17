<?php
//local_server
$bd_login = "root";
$bd_password = "";
$bd_name = "bestlancer";
$bd_connect = new mysqli("localhost", $bd_login, $bd_password, $bd_name);
date_default_timezone_set('Europe/Moscow');

//net_server
// $bd_login = bestlancer;
// $bd_password = "empty;
// $bd_name = "bes5104177_bestlancer";
// $bd_connect = new mysqli("bes5104177.mysql", $bd_login, $bd_password, $bd_name);
// date_default_timezone_set('Europe/Moscow');

//user_connect
if (isset($_SESSION["nik"])) {
    $my_nik = $_SESSION["nik"];
    $user_sql = "SELECT * FROM `user_registoring` WHERE `nik` = ?";
    $stmt = $bd_connect->prepare($user_sql);
    $stmt->bind_param("s", $my_nik);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user_resolt = $user_result->fetch_assoc();
    }

    $stmt->close();
}

//payment_prices
$vacancy_pay = 250;
?>
