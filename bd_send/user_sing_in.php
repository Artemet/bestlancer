<?php
    session_start();

    include "database_connect.php";

    $nik = $_POST["nik_name"];
    $password = $_POST["password"];
    $status = "online";

    $query = "SELECT * FROM user_registoring WHERE nik = '$nik' AND password = '$password'";
    $result = mysqli_query($bd_connect, $query);

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
        $_SESSION["work_time"] = $row["work_time"];
        $_SESSION["price"] = $row["price"];
        $_SESSION["icon_path"] = $row["icon_path"];
        $status = mysqli_real_escape_string($bd_connect, $status);
        $status_sql = "UPDATE `user_registoring` SET `status` = '$status' WHERE `nik` = '$nik'";
        $status_query = mysqli_query($bd_connect, $status_sql);
        $_SESSION["loggedin"] = true;

        // Email sender code (keep as is)

        // Redirect to user.php with the user's ID as a parameter
        header("Location: ../pages/user.php");
        exit(); // It's important to call exit() after the header redirection
    } else {
        include "warnings/rong_sing_in.php";
    }
?>
