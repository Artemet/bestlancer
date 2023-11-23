<?php
session_start();
if (!isset($_SESSION["nik"])) {
    header("Location: home.php");
}
include "../layouts/header.php";
echo "<link rel='stylesheet' href='../page_css/settings.css'>";
echo "<title>О бирже Bestlancer</title>";
include "../layouts/header_line.php";
?>
<div class="settings_container container">
    <div class="header">
        <div class="header_title">
            <h2>Настройки</h2>
        </div>
        <div class="settings_wrapper">
            <div class="setting_option normal_option menu_option">
                <div class="menu_header">
                    <div>
                        <a>Смена пароля</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M182.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                        </svg>
                    </div>
                </div>
                <div class="setting_sub setting_sub_none">
                    <form action="../bd_send/settings/change_password.php" method="post">
                        <div>
                            <h3>Старый пароль</h3>
                            <input type="password" name="old_password" class="right_in"
                                placeholder="Введите старый пароль">
                        </div>
                        <div>
                            <h3>Новый пароль</h3>
                            <input type="password" name="new_password" class="right_in"
                                placeholder="Введите новый пароль">
                        </div>
                        <button>Сохранить</button>
                    </form>
                </div>
            </div>
            <div class="setting_option normal_option menu_option">
                <div class="menu_header">
                    <div>
                        <a>Профиль</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M182.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                        </svg>
                    </div>
                </div>
                <div class="setting_sub setting_sub_none">
                    <form action="../bd_send/settings/change_profile.php" method="post">
                        <div>
                            <h3>Email</h3>
                            <input type="text" name="email" value="<?= $_SESSION["email"]; ?>" class="right_in"
                                placeholder="Введите ваш email">
                        </div>
                        <div class="role_input">
                            <h3>Роли</h3>
                            <?php
                            $role_resolt = "";
                            $role_arr = array("seller", "buyer");
                            if ($_SESSION["role"] == $role_arr[0]) {
                                $role_resolt = "Продавец";
                            } elseif ($_SESSION["role"] == $role_arr[1]) {
                                $role_resolt = "Покупатель";
                            }
                            ?>
                            <input type="text" name="role" value="<?= $role_resolt ?>" class="right_in" readonly>
                            <div class="sub_wrapper">
                                <div class="sub_menu">
                                    <div class="sub_option"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z" />
                                        </svg>
                                        <p>Продавец</p>
                                    </div>
                                    <div class="sub_option"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                        </svg>
                                        <p>Покупатель</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button>Сохранить</button>
                    </form>
                </div>
            </div>
            <div class="setting_option normal_option menu_option">
                <div class="menu_header">
                    <div>
                        <a>Реквизиты оплаты</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M182.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                        </svg>
                    </div>
                </div>
                <div class="setting_sub setting_sub_none">
                    <form action="../bd_send/settings/payment_option.php" method="post">
                        <?php
                        $payment_information_arr = array("", "");
                        if (!empty($_SESSION["payment_methods"])) {
                            $payment_information_arr[0] = explode(',', $_SESSION["payment_methods"])[0];
                            $payment_information_arr[1] = explode(',', $_SESSION["payment_methods"])[1];
                        }
                        ?>
                        <div class="payment_value">
                            <div>
                                <svg width="29" height="30" viewBox="0 0 29 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M25.6462 20.1511C26.3083 20.4358 26.5921 21.3849 26.5921 21.8594C26.6867 22.6187 26.4975 22.9984 26.2137 22.9984C25.93 22.9984 25.5516 22.7136 25.1733 22.0493C24.7949 21.3849 24.6057 20.7205 24.7949 20.3409C25.0787 20.1511 25.3624 20.0562 25.6462 20.1511Z"
                                        fill="#F28A1A"></path>
                                    <path
                                        d="M21.7682 23.0933C22.1465 23.0933 22.6195 23.2831 23.0924 23.6627C23.8491 24.3271 24.1329 25.0864 23.7545 25.6558C23.5653 25.9405 23.0924 26.1304 22.7141 26.1304C22.2411 26.1304 21.7682 25.9405 21.4844 25.6558C20.7277 24.9915 20.5386 24.0424 21.0115 23.4729C21.1061 23.2831 21.3898 23.0933 21.7682 23.0933Z"
                                        fill="#F28A1A"></path>
                                    <path
                                        d="M13.2228 26.6933C5.90805 26.6933 0 20.714 0 13.3823C0 6.05049 5.90805 0 13.2228 0C20.5375 0 26.4455 5.97931 26.4455 13.3823C26.4455 15.8736 25.7422 18.2226 24.6169 20.2157C24.5465 20.2869 24.4762 20.2869 24.4762 20.1446C23.9839 16.8702 22.0145 15.0906 19.2011 14.5212C18.9198 14.45 18.9198 14.3076 19.2715 14.3076C20.1858 14.2364 21.3815 14.2364 22.0848 14.3788C22.1552 14.0229 22.1552 13.667 22.1552 13.3823C22.1552 8.54187 18.2165 4.55566 13.4338 4.55566C8.65107 4.55566 4.71237 8.54187 4.71237 13.3823C4.71237 18.2226 8.65107 22.2089 13.4338 22.2089H13.8558C13.7151 21.4258 13.6448 20.6428 13.7151 19.7887C13.7151 19.2192 13.8558 19.148 14.0668 19.5751C15.2625 21.7106 17.0208 23.5613 20.3968 24.3443C23.1398 24.985 25.8829 25.6968 28.9072 29.4694C29.1886 29.8254 28.7666 30.1813 28.4852 29.8965C25.4609 27.1916 22.7178 26.2662 20.1858 26.2662C17.0208 26.3374 15.1218 26.6933 13.2228 26.6933Z"
                                        fill="#F28A1A"></path>
                                </svg>
                            </div>
                            <div>
                                <h3>Кошелек Qiwi</h3>
                                <input type="text" value="<?= $payment_information_arr[0] ?>" name="qiwi"
                                    class="tel right_in" placeholder="Номер телефона">
                            </div>
                        </div>
                        <div class="payment_value">
                            <div>
                                <svg width="29" height="36" viewBox="0 0 29 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.7322 8.45689H9.58447L10.9278 0.150574H13.0755L11.7322 8.45689Z"
                                        fill="#00579F"></path>
                                    <path
                                        d="M19.5179 0.353633C19.0942 0.185566 18.4223 0 17.5915 0C15.4705 0 13.977 1.13101 13.9678 2.74802C13.9502 3.94105 15.0371 4.60368 15.8501 5.00148C16.681 5.40796 16.9635 5.67327 16.9635 6.03559C16.9551 6.59206 16.2921 6.84856 15.6737 6.84856C14.8162 6.84856 14.3568 6.71632 13.6586 6.40673L13.3757 6.27401L13.0752 8.1386C13.5789 8.36809 14.507 8.57174 15.4705 8.58067C17.7241 8.58067 19.1912 7.46716 19.2086 5.74398C19.2172 4.79841 18.6432 4.07388 17.4058 3.48183C16.6546 3.10177 16.1946 2.8455 16.1946 2.45664C16.2034 2.10312 16.5837 1.74103 17.4317 1.74103C18.1299 1.7233 18.6429 1.89113 19.0315 2.05908L19.2258 2.14728L19.5179 0.353633Z"
                                        fill="#00579F"></path>
                                    <path
                                        d="M22.3725 5.51426C22.5494 5.03707 23.23 3.19022 23.23 3.19022C23.221 3.20795 23.4065 2.70422 23.5125 2.39498L23.6626 3.1107C23.6626 3.1107 24.0694 5.09896 24.1577 5.51426C23.822 5.51426 22.7967 5.51426 22.3725 5.51426ZM25.0236 0.150574H23.3623C22.85 0.150574 22.4608 0.300671 22.2398 0.839752L19.0496 8.45677H21.3031C21.3031 8.45677 21.6741 7.43158 21.7539 7.21077C22.0011 7.21077 24.1934 7.21077 24.5114 7.21077C24.5731 7.5024 24.7677 8.45677 24.7677 8.45677H26.7563L25.0236 0.150574Z"
                                        fill="#00579F"></path>
                                    <path
                                        d="M7.79052 0.150574L5.68717 5.81468L5.45732 4.66594C5.06846 3.34043 3.84889 1.9003 2.48792 1.18422L4.41451 8.44808H6.6857L10.0616 0.150574H7.79052Z"
                                        fill="#00579F"></path>
                                    <path
                                        d="M3.73404 0.150574H0.278515L0.243164 0.318405C2.93869 1.0077 4.72388 2.66922 5.45733 4.66629L4.70615 0.848795C4.58247 0.318288 4.20242 0.168073 3.73404 0.150574Z"
                                        fill="#FAA61A"></path>
                                    <g clip-path="url(#clip0_56501_94691)">
                                        <path d="M18.5272 12.9901H12.7615V23.3488H18.5272V12.9901Z" fill="#FF5A00">
                                        </path>
                                        <path
                                            d="M13.1454 18.1695C13.1454 16.0649 14.1348 14.197 15.653 12.9901C14.5357 12.1116 13.1262 11.5807 11.5888 11.5807C7.94684 11.5807 5 14.5275 5 18.1695C5 21.8115 7.94684 24.7583 11.5888 24.7583C13.1262 24.7583 14.5357 24.2274 15.653 23.3488C14.1327 22.159 13.1454 20.2741 13.1454 18.1695Z"
                                            fill="#EB001B"></path>
                                        <path
                                            d="M26.3061 18.1695C26.3061 21.8115 23.3592 24.7583 19.7172 24.7583C18.1799 24.7583 16.7704 24.2274 15.6531 23.3488C17.1905 22.1398 18.1607 20.2741 18.1607 18.1695C18.1607 16.0649 17.1713 14.197 15.6531 12.9901C16.7683 12.1116 18.1777 11.5807 19.7151 11.5807C23.3592 11.5807 26.3061 14.5467 26.3061 18.1695Z"
                                            fill="#F79E1B"></path>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.6959 27.8192C4.93276 27.8178 5.63671 27.7544 5.93489 28.7608C6.13575 29.4387 6.45571 30.5491 6.89475 32.092H7.07356C7.5444 30.4653 7.86785 29.3549 8.0439 28.7608C8.34518 27.7439 9.0984 27.8192 9.39968 27.8192L11.7242 27.8193V35.0501H9.35499V30.7888H9.19612L7.87541 35.0501H6.0929L4.7722 30.7857H4.61333V35.0501H2.24414V27.8193L4.6959 27.8192ZM15.1263 27.8193V32.0837H15.3153L16.9218 28.5771C17.2337 27.8792 17.8983 27.8193 17.8983 27.8193H20.191V35.0501H17.7723V30.7857H17.5833L16.0083 34.2923C15.6964 34.987 15.0003 35.0501 15.0003 35.0501H12.7076V27.8193H15.1263ZM28.551 31.2554C28.2136 32.2115 27.1541 32.8962 25.9811 32.8962H23.4446V35.0501H21.1446V31.2554H28.551Z"
                                        fill="#0F754E"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.0919 27.8192H21.0239C21.1445 29.429 22.5309 30.8072 23.966 30.8072H28.7107C28.9845 29.4692 28.0419 27.8192 26.0919 27.8192Z"
                                        fill="url(#paint0_linear_56501_94691)"></path>
                                    <defs>
                                        <linearGradient id="paint0_linear_56501_94691" x1="794.355" y1="215.775"
                                            x2="21.0239" y2="215.775" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#1F5CD7"></stop>
                                            <stop offset="1" stop-color="#02AEFF"></stop>
                                        </linearGradient>
                                        <clipPath id="clip0_56501_94691">
                                            <rect width="21.5107" height="13.2373" fill="white"
                                                transform="translate(5 11.5807)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div>
                                <h3>Банковская карта</h3>
                                <input type="text" value="<?= $payment_information_arr[1] ?>" name="bank_card"
                                    class="bank_card right_in" placeholder="Номер карты">
                            </div>
                        </div>
                        <button>Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "../layouts/footer.php";
?>
<script src="../page_js/user/settings/setting_menu.js"></script>
<script src="../page_js/user/settings/role_menu.js"></script>
<script src="../page_js/user/settings/phone_mask.js"></script>
<script src="../page_js/user/settings/card_mask.js"></script>
</body>

</html>