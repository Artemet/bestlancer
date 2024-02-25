<?php
session_start();
include "../../database_connect.php";
if (!isset($_SESSION["nik"])) {
    header("Location: ../../../pages/home.php");
    exit;
}
$user_include = false; //message_check
$my_nik = $_SESSION["nik"];
$message_option = $_POST["message_option"];
$message_id = $_POST["message_id"];

function message_check()
{
    global $bd_connect, $my_nik, $message_option, $user_include, $message_id;

    $check_sql = "SELECT * FROM `messages` WHERE `id` = ?";
    $check_query = mysqli_prepare($bd_connect, $check_sql);

    if ($check_query) {
        mysqli_stmt_bind_param($check_query, "i", $message_id);
        mysqli_stmt_execute($check_query);
        $check_resolt = mysqli_stmt_get_result($check_query);
        $row = mysqli_fetch_assoc($check_resolt);

        if ($row['nik'] == $my_nik) {
            $user_include = true;
            if ($message_option == "delete") {
                delete_message();
            } elseif ($message_option == "change" && $row['nik'] == $my_nik) {
                change_message();
            } else {
                die("Ошибка!");
            }
        } else {
            exit("Ошибка!");
        }
    } else {
        die("Ошибка при подготовке запроса: " . mysqli_error($bd_connect));
    }
}

function delete_message()
{
    global $bd_connect, $message_id;

    $delete_sql = "UPDATE `messages` SET `message_value` = '🚫 сообщение удалено', `deleted` = 1 WHERE `id` = ?";
    $delete_query = mysqli_prepare($bd_connect, $delete_sql);

    if ($delete_query) {
        mysqli_stmt_bind_param($delete_query, "i", $message_id);
        mysqli_stmt_execute($delete_query);
    } else {
        die("Ошибка при подготовке запроса: " . mysqli_error($bd_connect));
    }
}

function change_message()
{
    global $bd_connect, $message_id;

    $message_value = $_POST["message_value"];
    $stripped_value = strip_tags($message_value);

    if ($message_value !== $stripped_value) {
        exit("Недопустимые теги в сообщении");
    }

    $edit_sql = "UPDATE `messages` SET `message_value` = ?, `changeable` = 1 WHERE `id` = ?";
    $edit_query = mysqli_prepare($bd_connect, $edit_sql);

    if ($edit_query) {
        mysqli_stmt_bind_param($edit_query, "si", $message_value, $message_id);
        mysqli_stmt_execute($edit_query);
    } else {
        die("Ошибка при подготовке запроса: " . mysqli_error($bd_connect));
    }
}

message_check();
?>