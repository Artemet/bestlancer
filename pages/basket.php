<?php
    session_start(); 
    include "../layouts/header.php";
    echo "<link rel='stylesheet' href='../page_css/basket.css'>";
    echo "<title>Моя корзина</title>";
    include "../layouts/header_line.php";
?>
<div class="container">
    <div class="header">
        <div class="header_title">
            <h2>Моя корзина</h2>
        </div>
        <div class="basket_wrapper">
            <?php
                $user_nik = $_SESSION["nik"];
                $sql = "SELECT * FROM basket WHERE nik = '$user_nik'";
                $query = mysqli_query($bd_connect, $sql);
                while ($row = mysqli_fetch_assoc($query)){
                    $connection = mysqli_connect("localhost", $bd_login, $bd_password, $bd_name);
                    $author_nik = $row['author_nik'];
                    //users_icons
                    $icon_query = "SELECT icon_path FROM user_registoring WHERE nik = '$author_nik'";
                    $icon_resolt = mysqli_query($connection, $icon_query);
                    $icon_row = mysqli_fetch_assoc($icon_resolt);
                    $user_icon = $icon_row['icon_path'];
                    mysqli_close($connection);
                    echo '<div class="basket_product">
                            <div class="product_information">
                                <div class="img">
                                    <img src="../bd_send/user/user_icons/'. $user_icon .'" alt="" draggable="false">
                                </div>
                                <div>
                                    <a href="service_page.php?service_id='.$row['service_id'].'"><b>'.$row['product_name'].'</b></a>
                                </div>
                            </div>
                            <div>
                                <a href="" title="Купить услугу"><button>Купить</button></a>
                            </div>
                        </div>';
                }
            ?>
        </div>
    </div>
</div>
<?php
    include "../layouts/footer.php";
?>