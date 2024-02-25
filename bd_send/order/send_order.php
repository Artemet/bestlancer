<?php
session_start();
include "../database_connect.php";
$my_nik = $_SESSION["nik"];

$total_sum = 0;
$pin = 0;
$good_application = 0;
$familiar_application = 0;

$order_name = $_POST["order_name"];
$order_information = $_POST["order_information"];

$additions = $_POST["addition_list"];
$addition_price_list = array(300, 250, 200);
$addition_list = array(...explode(",", $additions));

function addition_add($balance)
{
    global $bd_connect, $pin, $total_sum, $my_nik, $addition_price_list, $addition_list, $user_resolt;
    $user_balance = $balance;
    function balance_check()
    {
        global $addition_price_list, $addition_list;
        $list_temp = -1;
        $addition_price = 0;
        while ($list_temp != count($addition_list) - 1) {
            $list_temp++;
            if (count($addition_list) == 0) {
                break;
            }
            $addition_moment = intval($addition_list[$list_temp]);
            $addition_price += $addition_price_list[$addition_moment];
        }
        return $addition_price;
    }
    function paid_do()
    {
        global $bd_connect, $pin, $addition_list, $familiar_application, $good_application;
        for ($i = 0; $i < count($addition_list); $i++) {
            $addition_moment = intval($addition_list[$i]);
            if ($addition_moment == 0) {
                $pin = 1;
            } else if ($addition_moment == 1) {
                $good_application = 1;
            } else if ($addition_moment == 2) {
                $familiar_application = 1;
            }
        }
    }
    function take_balance($balance)
    {
        global $bd_connect, $total_sum, $my_nik, $user_resolt, $addition_list;
        if ($user_resolt["wallet"] >= balance_check()) {
            $remainder = $user_resolt["wallet"] - balance_check();
            if (balance_check() >= 1) {
                if ($user_resolt["wallet"] >= balance_check()) {
                    $total_sum += balance_check();
                    paid_do();
                } else {
                    echo "addition_pay_need";
                    exit;
                }
            }
        } else {
            echo "addition_pay_need";
            exit;
        }
    }
    take_balance($user_balance);
}

if (empty($order_name) || empty($order_information)) {
    header("Location: ../../pages/make_order.php");
    exit;
}

$file_name = "";
if (!empty($_FILES['file_send'])) {
    $file = $_FILES['file_send'];
    $file_name = $file['name'];
    echo $file_name;
    $pathFile = __DIR__ . '/order_files/' . $file_name;
    if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
        //no file script
    }
}
$order_price = $_POST["order_price"];
$order_email = $_SESSION["email"];
$order_type = $_POST["order_type"];
$wallet_withdraw = 0;
if ($order_type != 0 && $order_type != 1) {
    echo "Warning: Ошибка с поля, перезагрузите страницу!";
    exit;
} elseif ($order_type == 1) {
    $user_balance = intval($user_resolt["wallet"]);
    if ($user_balance >= $vacancy_pay) {
        $wallet_withdraw = $user_balance - $vacancy_pay;
        $total_sum += $vacancy_pay;
    } else {
        echo "vacancy_pay_need";
        exit;
    }
}
if ($additions != 'false') {
    addition_add($wallet_withdraw);
}
$main_order_category = $_POST["main_order_category"];
$medium_order_category = $_POST["medium_order_category"];
$final_order_category = $_POST["final_order_category"];
//main_option_check
$main_options = array("Дизайн", "Разработка и IT", "Тексты и переводы", "SEO и трафик", "Соцсети и реклама", "Аудио, видео, съемка", "Бизнес и жизнь", "Учеба и репетиторство");
$main_category_resolt = array_search($main_order_category, $main_options) + 1;
//medium_category_option_check
$medium_options = array("Арт и иллюстрации", "Веб и мобильный дизайн", "Интерьер и экстерьер", "Логотип и брендинг", "Маркетплейсы и соцсети", "Наружная реклама", "Обработка и редактирование", "Полиграфия", "Презентации и инфографика", "Промышленный дизайн", "Верстка", "Десктоп программирование", "Доработка и настройка сайта", "Игры", "Мобильные приложения", "Сервера и хостинг", "Скрипты и боты", "Создание сайта", "Юзабилити, тесты и помощь", "Переводы", "Продающие и бизнес-тексты", "Тексты и наполнение сайта", "SEO аудиты, консультации", "Внутренняя оптимизация", "Продвижение сайта в топ", "Семантическое ядро", "Ссылки", "Статистика и аналитика", "Трафик", "E-mail маркетинг и рассылки", "Базы данных и клиентов", "Контекстная реклама", "Маркетплейсы и доски объявлений", "Реклама и PR", "Соцсети и SMM", "Аудиозапись и озвучка", "Видеоролики", "Видеосъемка и монтаж", "Интро и анимация логотипа", "Музыка и песни", "Редактирование аудио", "Бухгалтерия и налоги", "Обзвоны и продажи", "Обучение и консалтинг", "Персональный помощник", "Подбор персонала", "Продажа сайтов", "Стройка и ремонт", "Юридическая помощь", "репетитор на дом", "репетитор онлайн", "школьный репетитор", "репетитор в университете");
$medium_options_resolt = array_search($medium_order_category, $medium_options) + 1;
//final_option_check
$final_options = array("Иллюстрации и рисунки", "Тату, принты", "Дизайн игр", "Готовые шаблоны и рисунки", "Портрет, шарж, карикатура", "Стикеры", "NFT арт", "Мобильный дизайн", "Email-дизайн", "Веб-дизайн", "Баннеры и иконки", "Интерьер", "Дизайн домов и сооружений", "Ландшафтный дизайн", "Дизайн мебели", "Логотипы", "Фирменный стиль", "Брендирование и сувенирка", "Визитки", "Дизайн в соцсетях", "Дизайн для маркетплейсов", "Билборды и стенды", "Витрины и вывески", "Отрисовка в векторе", "3D-графика", "Фотомонтаж и обработка", "Брошюра и буклет", "Листовка и флаер", "Плакат и афиша", "Календарь и открытка", "Каталог, меню, книга", "Грамота и сертификат", "Презентации", "Инфографика", "Карта и схема", "Упаковка и этикетка", "Электроника и устройства", "Предметы и аксессуары", "Верстка по макету", "Доработка и адаптация верстки", "Программы на заказ", "Макросы для Office", "1С", "Готовые программы", "Доработка сайта", "Исправление ошибок", "Защита и лечение сайта", "Настройка сайта", "Плагины и темы", "Ускорение сайта", "Разработка игр", "Готовые игры", "Игровой сервер", "iOS", "Android", "Администрирование сервера", "Домены", "Хостинг", "Парсеры", "Чат-боты", "Скрипты", "Новый сайт", "Копия сайта", "Юзабилити-аудит", "Тестирование на ошибки", "Компьютерная и IT помощь", "С аудио/видео", "С изображений", "С аудио/видео", "С текста", "С изображения", "Переводы устные", "Продающие тексты", "Реклама и email", "Авто и мото", "Работа, карьера", "Юридическая", "Медицина и здоровье", "Интернет и технологии", "Кулинария", "Электроника, гаджеты", "Красота и мода", "Культура и искусство", "Недвижимость", "Образование и наука", "Семья, дети", "Отдых и развлечения", "Спорт", "Строительство", "Другое", "Туризм и путешествия", "Финансы, банки", "Хобби и увлечения", "Коммерческие предложения", "Скрипты продаж и выступлений", "Посты для соцсетей", "Художественные тексты", "Сценарии", "Комментарии", "Корректура", "SEO-тексты", "Карточки товаров", "Статьи", "SEO аудит", "Консультация", "Полная оптимизация", "Оптимизация страниц", "Robots и sitemap", "Теги", "Перелинковка", "Микроразметка", "Продвижение поисковой выдачи", "С нуля", "По сайту", "Готовое ядро", "В профилях", "В соцсетях", "В комментариях", "Каталоги сайтов", "Форумные", "Статейные и крауд", "Метрики и счетчики", "Анализ сайтов, рынка", "Посетители на сайт", "Поведенческие факторы", "Отправка рассылки", "Почтовые ящики", "Сбор данных", "Готовые базы", "Проверка, чистка базы", "Яндекс Директ", "Google Ads", "Справочники и каталоги", "Маркетплейсы", "Доски объявлений", "Размещение рекламы", "Контент-маркетинг", "Продвижение музыки", "ВКонтакте", "Facebook", "Instagram", "Youtube", "Одноклассники", "Telegram", "Twitter", "Другие", "Дзен", "TikTok", "Озвучка и дикторы", "Аудиоролик", "Дудл-видео", "Анимационный ролик", "Проморолик", "3D анимация", "Скринкасты и видеообзоры", "Кинетическая типографика", "Слайд-шоу", "Видео с ведущим", "Видеопрезентация", "Ролики для соцсетей", "Видеосъемка", "Монтаж и обработка видео", "Фотосъемка", "Анимация логотипа", "Интро и заставки", "GIF-анимация", "Написание музыки", "Запись вокала", "Аранжировка", "Тексты песен", "Песня (музыка + текст + вокал)", "Обработка звука", "Выделение звука из видео", "Для физлиц", "Для юрлиц и ИП", "Продажи по телефону", "Телефонный опрос", "Прием звонков", "Онлайн курсы", "Консалтинг", "Оформление по ГОСТу", "Репетиторы", "Поиск информации", "Работа в MS Office", "Анализ информации", "Любая интеллектуальная работа", "Любая рутинная работа", "Менеджмент проектов", "Подбор резюме", "Найм специалиста", "Сайт без домена", "Сайт с доменом", "Соцсети, домен, приложение", "Аудит, оценка, помощь", "Строительство", "Проектирование объекта", "Машиностроение", "Предметы и аксессуары", "Договор и доверенность", "Судебный документ", "Юридическая консультация", "Ведение ООО и ИП", "Интернет-право", "Визы", "Дом ученика", "Дом репетитора", "видеозвонок", "Найм", "Временно", "Найм", "Временно");
$final_options_resolt = array_search($final_order_category, $final_options) + 1;

$nik = $_SESSION["nik"];
$responsible_id = 0;
$progress = 1;
$date = date("Y.m.d");
$time = 0;
$sql = "INSERT INTO `orders` (`id`, `order_name`, `order_information`, `file_path`, `order_price`, `pin`, `good_application`, `familiar_application`, `order_email`, `type`, `main_category`, `medium_category`, `final_category`, `date`, `responsible_id`, `progress`, `time`, `nik`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($bd_connect, $sql);
mysqli_stmt_bind_param($stmt, "sssiiiisiiiiiiiss", $order_name, $order_information, $file_name, $order_price, $pin, $good_application, $familiar_application, $order_email, $order_type, $main_category_resolt, $medium_options_resolt, $final_options_resolt, $date, $responsible_id, $progress, $time, $nik);
$query = mysqli_stmt_execute($stmt);
if (!$query) {
    printf("Ошибка: %s\n", mysqli_error($bd_connect));
}
if ($query && $total_sum >= 1) {
    $wallet_sum = $user_resolt["wallet"] - $total_sum;
    $wallet_update_sql = "UPDATE `user_registoring` SET `wallet` = ? WHERE `nik` = ?";
    $stmt = mysqli_prepare($bd_connect, $wallet_update_sql);
    mysqli_stmt_bind_param($stmt, "ds", $wallet_sum, $my_nik);
    mysqli_stmt_execute($stmt);
}
?>