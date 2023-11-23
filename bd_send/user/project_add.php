<?php
session_start();
include "../database_connect.php";
$previous_page = null;
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = $_SERVER['HTTP_REFERER'];
} else {
    $previous_page = "../../pages/home.php";
    exit;
}
function back_page()
{
    $previous_page = $_SERVER['HTTP_REFERER'];
    if (stripos($previous_page, "add_project") !== false) {
        header("Location: ../../pages/add_project.php");
    } elseif (stripos($previous_page, "project_page") !== false) {
        header("Location: $previous_page");
    }
}
if (!isset($_SESSION["nik"])) {
    header("Location: ../../pages/home.php");
    exit;
}
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
$project_old_file = null;
if (stripos($previous_page, "project_page") !== false) {
    $project_old_file = $_POST["old_file"];
}
if (!empty($_FILES['file_name']) && $_FILES['file_name']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['file_name'];
    $file_name = $file['name'];
    $pathFile = __DIR__ . '/project_cover/' . $file_name;

    if (move_uploaded_file($file['tmp_name'], $pathFile)) {
    } else {
        $file_name = "no-photo-available.png";
    }
} else {
    if (stripos($previous_page, "project_page") !== false) {
        $file_name = $project_old_file;
    } else {
        $file_name = "no-photo-available.png";
    }
}
$user_nik = $_SESSION["nik"];
$project_name = $_POST["project_name"];
$project_link = $_POST["project_link"];
$project_youtube = $_POST["project_youtube"];
$project_context = $_POST["project_context"];
if (empty($project_name) || empty($project_link) || empty($project_context)) {
    back_page();
    exit;
}
$project_sql = null;
if (stripos($previous_page, "add_project") !== false) {
    $project_sql = "INSERT INTO `project_cover` (`id`, `cover_href`, `project_name`, `project_link`, `project_video`, `project_context`, `nik`, `date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
    if ($project_query = mysqli_prepare($bd_connect, $project_sql)) {
        mysqli_stmt_bind_param($project_query, "sssssss", $file_name, $project_name, $project_link, $project_youtube, $project_context, $user_nik, $date_resolt);
        if (mysqli_stmt_execute($project_query)) {
            header("Location: ../../pages/user.php");
        } else {
            echo "Ошибка, обратитесь в службу поддержки!";
        }
        mysqli_stmt_close($project_query);
    } else {
        echo "Ошибка, обратитесь в службу поддержки!";
    }
} elseif (stripos($previous_page, "project_page") !== false) {
    $project_id = $_GET['project_id'];
    $project_id_sql = "SELECT * FROM project_cover WHERE id = $project_id";
    $project_id_query = mysqli_query($bd_connect, $project_id_sql);
    $project_id = mysqli_fetch_assoc($project_id_query);

    $project_name = mysqli_real_escape_string($bd_connect, $project_name);
    $project_link = mysqli_real_escape_string($bd_connect, $project_link);
    $project_youtube = mysqli_real_escape_string($bd_connect, $project_youtube);
    $project_context = mysqli_real_escape_string($bd_connect, $project_context);
    $stmt = $bd_connect->prepare("UPDATE `project_cover` SET `cover_href` = ?, `project_name` = ?, `project_link` = ?, `project_video` = ?, `project_context` = ? WHERE `nik` = ? AND `id` = ?");
    $stmt->bind_param("sssssss", $file_name, $project_name, $project_link, $project_youtube, $project_context, $user_nik, $project_id['id']);
    if ($stmt->execute()) {
        echo "Update successful";
        back_page();
    } else {
        echo "Ошибка, обратитесь в службу поддержки!";
    }
    $stmt->close();
    $bd_connect->close();
}
header("Location: $previous_page");
?>