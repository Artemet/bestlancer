<?php
    session_start();
    include "../../database_connect.php";
    if (!isset($_SESSION["nik"])){
        header("Location: ../../../pages/home.php");
        exit;
    }
    $user_include = false; //message_check
    $my_nik = $_SESSION["nik"];
    $message_option = $_POST["message_option"];
    $message_id = $_POST["message_id"];
    function message_check(){
        global $bd_connect, $my_nik, $message_option, $user_include, $message_id;
        $check_sql = "SELECT * FROM `messages` WHERE `id` = '$message_id'";
        $check_query = mysqli_query($bd_connect, $check_sql);
        $check_resolt = mysqli_fetch_assoc($check_query);
        if ($check_resolt['nik'] == $my_nik){
            $user_include = true;
            if ($message_option == "delete"){
                delete_message();
            } elseif ($message_option == "change" && $check_resolt['nik'] == $my_nik){
                change_message();
            } else{
                die("Ошибка!");
            }
        } else{
            exit("Ошибка!");
        }
    }
    message_check();
    //delete_message
    function delete_message(){
        global $bd_connect, $message_id;
        $delete_sql = "UPDATE `messages` SET `message_value` = '🚫 сообщение удалено', `deleted` = 1 WHERE `id` = '$message_id'";
        $delite_query = mysqli_query($bd_connect, $delete_sql);
    }
    //change_message
    function change_message(){
        global $bd_connect, $message_id;
        $message_value = $_POST["message_value"];
        $stripped_value = strip_tags($message_value);

        if ($message_value !== $stripped_value) {
            exit("Недопустимые теги в сообщении");
        }
        $edit_sql = "UPDATE `messages` SET `message_value` = '$message_value', `changeable` = 1 WHERE `id` = '$message_id'";
        $edit_query = mysqli_query($bd_connect, $edit_sql);
    }
?>