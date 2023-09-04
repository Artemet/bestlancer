<?php
    session_start();
    include __DIR__.'/icon_db.php';
    $user_nik = $_SESSION["nik"];
    if (!empty($_FILES['user_icon'])){
        $file = $_FILES['user_icon'];
        $name = $file['name'];
        if (empty($name)){
            $name = "user.png";
        }
        $pathFile = __DIR__.'/user_icons/'.$name;
        if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
            echo 'Ошибка';
        }
        $updateData = $db->prepare("UPDATE `user_registoring` SET `icon_path` = ? WHERE `nik` = ?");
        $updateData->execute([$name, $user_nik]);
    }
    header("Location: ../../pages/user.php");
    session_destroy();
?>