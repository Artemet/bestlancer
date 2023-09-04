<?php
    session_start();
    if (!isset($_SESSION["nik"])){
        header("Location:  ../../pages/home.php");
    } else{
        include "../database_connect.php";
        $email = $_POST["user_email_star"];
        $review = $_POST["user_review"];
        $stars = $_POST["star_number"];
        $sql = "INSERT INTO `reviews` (`id`, `email`, `review`, `star`) VALUES (NULL, '$email', '$review', '$stars')";
        $query = mysqli_query($bd_connect, $sql);
        header("location: ../../pages/reviews.php");
    }
?>