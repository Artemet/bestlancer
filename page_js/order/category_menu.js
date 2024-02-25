//type_menu
function type_menu() {
  const get_input = document.querySelector("input.type_input");
  //open_script
  get_input.addEventListener("click", function () {
    document
      .querySelector(".make_order_container .type_sub")
      .classList.toggle("active");
  });
  //close_script
  const get_close_icon = document.querySelector(
    ".make_order_container .type_sub svg"
  );
  get_close_icon.addEventListener("click", function () {
    document
      .querySelector(".make_order_container .type_sub")
      .classList.remove("active");
  });
  //choice_script
  const get_menu_options = document.querySelectorAll(
    ".make_order_container .type_sub p"
  );
  let option_call_temp = 0;
  get_menu_options.forEach((item) => {
    item.addEventListener("click", function () {
      const item_id = parseInt(item.id, 10);
      const sum_add = (movement) => {
        const get_order_sum = document.querySelector(
          ".order_double_container p.pay_sum"
        );
        if (get_order_sum.innerHTML.match(/\d/g) !== null) {
          if (movement === "add") {
            let result_sum =
              parseInt(get_order_sum.innerHTML.match(/\d/g).join("")) + 250;
            get_order_sum.innerHTML = result_sum + "₽";
          } else if (movement === "minus" && option_call_temp >= 1) {
            let result_sum =
              parseInt(get_order_sum.innerHTML.match(/\d/g).join("")) - 250;
            get_order_sum.innerHTML = result_sum + "₽";
            option_call_temp = 0;
          }
        }
      };
      if (item_id === 1) {
        option_call_temp++;
        sum_add("add");
      } else {
        sum_add("minus");
      }
      get_menu_options.forEach((item) => {
        item.style.color = "white";
      });
      item.style.color = "#d08e0b";
      get_input.value = item.innerHTML;
    });
  });
  get_menu_options[0].click();
}
type_menu();
//category_menu
function category_menu() {
  let menu_temp = 0;
  let local_block_id = null;
  const category_block = document.querySelector(
    ".make_order_container .category_part"
  );
  const category_html = category_block.innerHTML;
  const get_input = document.querySelectorAll(
    ".make_order_container .category_input"
  );
  const get_all_inputs = document.querySelectorAll(
    ".make_order_container .category_part .input_block"
  );
  const get_sub_menu = document.querySelector(
    ".make_order_container .category_choice"
  );
  const get_close_icon = document.querySelectorAll(
    ".make_order_container .category_choice svg"
  )[1];
  const get_main_bin = document.querySelector(
    ".make_order_container .category_header .restart"
  );
  get_input.forEach((item) => {
    item.addEventListener("click", function () {
      get_sub_menu.classList.toggle("category_choice_animation");
    });
  });
  get_close_icon.addEventListener("click", function () {
    document
      .querySelector(".make_order_container .category_part input")
      .click();
  });
  get_main_bin.addEventListener("click", function () {
    document
      .querySelector(".make_order_container .category_choice .close_menu svg")
      .click();
    //ДОДЕЛАТЬ!!!!
  });
  //click_logic
  let input_temp = 0;

  //input_options
  const options_two = [];

  //second_option
  const design_options = [
    "Арт и иллюстрации",
    "Веб и мобильный дизайн",
    "Интерьер и экстерьер",
    "Логотип и брендинг",
    "Маркетплейсы и соцсети",
    "Наружная реклама",
    "Обработка и редактирование",
    "Полиграфия",
    "Презентации и инфографика",
    "Промышленный дизайн",
  ];
  const it_options = [
    "Верстка",
    "Десктоп программирование",
    "Доработка и настройка сайта",
    "Игры",
    "Мобильные приложения",
    "Сервера и хостинг",
    "Скрипты и боты",
    "Создание сайта",
    "Юзабилити, тесты и помощь",
  ];
  const text_options = [
    "Набор текста",
    "Переводы",
    "Продающие и бизнес-тексты",
    "Тексты и наполнение сайта",
  ];
  const seo_options = [
    "SEO аудиты, консультации",
    "Внутренняя оптимизация",
    "Продвижение сайта в топ",
    "Семантическое ядро",
    "Ссылки",
    "Статистика и аналитика",
    "Трафик",
  ];
  const internet_options = [
    "E-mail маркетинг и рассылки",
    "Базы данных и клиентов",
    "Контекстная реклама",
    "Маркетплейсы и доски объявлений",
    "Реклама и PR",
    "Соцсети и SMM",
  ];
  const audio_options = [
    "Аудиозапись и озвучка",
    "Видеоролики",
    "Видеосъемка и монтаж",
    "Интро и анимация логотипа",
    "Музыка и песни",
    "Редактирование аудио",
  ];
  const buisness_options = [
    "Бухгалтерия и налоги",
    "Обзвоны и продажи",
    "Обучение и консалтинг",
    "Персональный помощник",
    "Подбор персонала",
    "Продажа сайтов",
    "Стройка и ремонт",
    "Юридическая помощь",
  ];
  const teacher_options = [
    "репетитор на дом",
    "репетитор онлайн",
    "школьный репетитор",
    "репетитор в университете",
  ];

  //third_option_design
  const art_design_options = [
    "Иллюстрации и рисунки",
    "Тату, принты",
    "Дизайн игр",
    "Готовые шаблоны и рисунки",
    "Портрет, шарж, карикатура",
    "Стикеры",
    "NFT арт",
  ];
  const web_design_options = [
    "Мобильный дизайн",
    "Email-дизайн",
    "Веб-дизайн",
    "Баннеры и иконки",
  ];
  const intier_design_options = [
    "Интерьер",
    "Дизайн домов и сооружений",
    "Ландшафтный дизайн",
    "Дизайн мебели",
  ];
  const logo_design_options = [
    "Логотипы",
    "Фирменный стиль",
    "Брендирование и сувенирка",
    "Визитки",
  ];
  const martet_design_options = [
    "Дизайн в соцсетях",
    "Дизайн для маркетплейсов",
  ];
  const add_design_options = ["Билборды и стенды", "Витрины и вывески"];
  const redact_design_options = [
    "Отрисовка в векторе",
    "3D-графика",
    "Фотомонтаж и обработка",
  ];
  const poligraphic_design_options = [
    "Брошюра и буклет",
    "Листовка и флаер",
    "Плакат и афиша",
    "Календарь и открытка",
    "Каталог, меню, книга",
    "Грамота и сертификат",
  ];
  const presintation_design_options = [
    "Презентации",
    "Инфографика",
    "Карта и схема",
  ];
  const promish_design_options = [
    "Упаковка и этикетка",
    "Электроника и устройства",
    "Предметы и аксессуары",
  ];

  //third_option_it
  const bild_it_options = [
    "Верстка по макету",
    "Доработка и адаптация верстки",
  ];
  const desk_it_options = [
    "Программы на заказ",
    "Макросы для Office",
    "1С",
    "Готовые программы",
  ];
  const webfinish_it_options = [
    "Доработка сайта",
    "Исправление ошибок",
    "Защита и лечение сайта",
    "Настройка сайта",
    "Плагины и темы",
    "Ускорение сайта",
  ];
  const game_it_options = ["Разработка игр", "Готовые игры", "Игровой сервер"];
  const mobile_it_options = ["iOS", "Android"];
  const server_it_options = ["Администрирование сервера", "Домены", "Хостинг"];
  const bots_it_options = ["Парсеры", "Чат-боты", "Скрипты"];
  const web_it_options = ["Новый сайт", "Копия сайта"];
  const test_it_options = [
    "Юзабилити-аудит",
    "Тестирование на ошибки",
    "Компьютерная и IT помощь",
  ];

  //third_option_texts
  const select_text_options = ["С аудио/видео", "С изображений"];
  const translate_text_options = [
    "С аудио/видео",
    "С текста",
    "С изображения",
    "Переводы устные",
  ];
  const buisness_texts_options = [
    "Продающие тексты",
    "Реклама и email",
    "Авто и мото",
    "Работа, карьера",
    "Юридическая",
    "Медицина и здоровье",
    "Интернет и технологии",
    "Кулинария",
    "Электроника, гаджеты",
    "Красота и мода",
    "Культура и искусство",
    "Недвижимость",
    "Образование и наука",
    "Семья, дети",
    "Отдых и развлечения",
    "Спорт",
    "Строительство",
    "Другое",
    "Туризм и путешествия",
    "Финансы, банки",
    "Хобби и увлечения",
    "Коммерческие предложения",
    "Скрипты продаж и выступлений",
    "Посты для соцсетей",
  ];
  const webtext_texts_options = [
    "Художественные тексты",
    "Сценарии",
    "Комментарии",
    "Корректура",
    "SEO-тексты",
    "Карточки товаров",
    "Статьи",
  ];

  //third_option_seo
  const seoaudit_seo_options = ["SEO аудит", "Консультация"];
  const optimisation_seo_options = [
    "Полная оптимизация",
    "Оптимизация страниц",
    "Robots и sitemap",
    "Теги",
    "Перелинковка",
    "Микроразметка",
  ];
  const webtop_seo_options = ["Продвижение поисковой выдачи"];
  const yadro_seo_options = ["С нуля", "По сайту", "Готовое ядро"];
  const links_seo_options = [
    "В профилях",
    "В соцсетях",
    "В комментариях",
    "Каталоги сайтов",
    "Форумные",
    "Статейные и крауд",
  ];
  const statistic_seo_options = ["Метрики и счетчики", "Анализ сайтов, рынка"];
  const trafic_seo_options = ["Посетители на сайт", "Поведенческие факторы"];

  //third_option_network
  const emailmarketing_network_options = [
    "Отправка рассылки",
    "Почтовые ящики",
  ];
  const database_network_options = [
    "Сбор данных",
    "Готовые базы",
    "Проверка, чистка базы",
  ];
  const context_network_options = ["Яндекс Директ", "Google Ads"];
  const marketpace_network_options = [
    "Справочники и каталоги",
    "Маркетплейсы",
    "Доски объявлений",
  ];
  const reclam_network_options = [
    "Размещение рекламы",
    "Контент-маркетинг",
    "Продвижение музыки",
  ];
  const smm_network_options = [
    "ВКонтакте",
    "Facebook",
    "Instagram",
    "Youtube",
    "Одноклассники",
    "Telegram",
    "Twitter",
    "Другие",
    "Дзен",
    "TikTok",
  ];

  //third_option_audio
  const automicro_audio_options = ["Озвучка и дикторы", "Аудиоролик"];
  const video_audio_options = [
    "Дудл-видео",
    "Анимационный ролик",
    "Проморолик",
    "3D анимация",
    "Скринкасты и видеообзоры",
    "Кинетическая типографика",
    "Слайд-шоу",
    "Видео с ведущим",
    "Видеопрезентация",
    "Ролики для соцсетей",
  ];
  const videoredactor_audio_options = [
    "Видеосъемка",
    "Монтаж и обработка видео",
    "Фотосъемка",
  ];
  const intro_audio_options = [
    "Анимация логотипа",
    "Интро и заставки",
    "GIF-анимация",
  ];
  const music_audio_options = [
    "Написание музыки",
    "Запись вокала",
    "Аранжировка",
    "Тексты песен",
    "Песня (музыка + текст + вокал)",
  ];
  const redactor_audio_options = [
    "Обработка звука",
    "Выделение звука из видео",
  ];

  //third_option_buisnes
  const bugalter_buisnes_options = ["Для физлиц", "Для юрлиц и ИП"];
  const call_buisnes_options = [
    "Продажи по телефону",
    "Телефонный опрос",
    "Прием звонков",
  ];
  const learn_buisnes_options = [
    "Онлайн курсы",
    "Консалтинг",
    "Оформление по ГОСТу",
    "Репетиторы",
  ];
  const helper_buisnes_options = [
    "Поиск информации",
    "Работа в MS Office",
    "Анализ информации",
    "Любая интеллектуальная работа",
    "Любая рутинная работа",
    "Менеджмент проектов",
  ];
  const personal_buisnes_options = ["Подбор резюме", "Найм специалиста"];
  const websale_buisnes_options = [
    "Сайт без домена",
    "Сайт с доменом",
    "Соцсети, домен, приложение",
    "Аудит, оценка, помощь",
  ];
  const bild_buisnes_options = [
    "Строительство",
    "Проектирование объекта",
    "Машиностроение",
    "Предметы и аксессуары",
  ];
  const uridict_buisnes_options = [
    "Договор и доверенность",
    "Судебный документ",
    "Юридическая консультация",
    "Ведение ООО и ИП",
    "Интернет-право",
    "Визы",
  ];

  //third_option_teacher
  const house_teacher_options = ["Дом ученика", "Дом репетитора"];
  const online_teacher_options = ["видеозвонок"];
  const school_teacher_options = ["Найм", "Временно"];
  const collage_teacher_options = ["Найм", "Временно"];

  //final_options
  const options = [
    design_options,
    it_options,
    text_options,
    seo_options,
    internet_options,
    audio_options,
    buisness_options,
    teacher_options,
  ];
  const designt_options = [
    art_design_options,
    web_design_options,
    intier_design_options,
    logo_design_options,
    martet_design_options,
    add_design_options,
    redact_design_options,
    poligraphic_design_options,
    presintation_design_options,
    promish_design_options,
  ];
  const programmer_options = [
    bild_it_options,
    desk_it_options,
    webfinish_it_options,
    game_it_options,
    mobile_it_options,
    server_it_options,
    bots_it_options,
    web_it_options,
    test_it_options,
  ];
  const texts_options = [
    select_text_options,
    translate_text_options,
    buisness_texts_options,
    webtext_texts_options,
  ];
  const seos_options = [
    seoaudit_seo_options,
    optimisation_seo_options,
    webtop_seo_options,
    yadro_seo_options,
    links_seo_options,
    statistic_seo_options,
    trafic_seo_options,
  ];
  const network_options = [
    emailmarketing_network_options,
    database_network_options,
    context_network_options,
    marketpace_network_options,
    reclam_network_options,
    smm_network_options,
  ];
  const audios_options = [
    automicro_audio_options,
    video_audio_options,
    videoredactor_audio_options,
    intro_audio_options,
    music_audio_options,
    redactor_audio_options,
  ];
  const buisnes_options = [
    bugalter_buisnes_options,
    call_buisnes_options,
    learn_buisnes_options,
    helper_buisnes_options,
    personal_buisnes_options,
    websale_buisnes_options,
    bild_buisnes_options,
    uridict_buisnes_options,
  ];
  const teachers_options = [
    house_teacher_options,
    online_teacher_options,
    school_teacher_options,
    collage_teacher_options,
  ];

  let main_value = null;
  let resolt_category_id = null;
  get_all_inputs.forEach((item) => {
    const arr_three = [];
    item.addEventListener("click", function () {
      if (item.id != 0) {
        local_block_id = item.id;
        if (local_block_id === "2") {
          const uniqueValues = new Set();
          const get_option_block = document.querySelector(".category_options");
          const get_options = document.querySelectorAll(
            ".make_order_container .category_choice p"
          );
          if (main_value === "Дизайн") {
            arr_three.push(...designt_options[resolt_category_id]);
          } else if (main_value === "Разработка и IT") {
            arr_three.push(...programmer_options[resolt_category_id]);
          } else if (main_value === "Тексты и переводы") {
            arr_three.push(...texts_options[resolt_category_id]);
          } else if (main_value === "SEO и трафик") {
            arr_three.push(...seos_options[resolt_category_id]);
          } else if (main_value === "Соцсети и реклама") {
            arr_three.push(...network_options[resolt_category_id]);
          } else if (main_value === "Аудио, видео, съемка") {
            arr_three.push(...audios_options[resolt_category_id]);
          } else if (main_value === "Бизнес и жизнь") {
            arr_three.push(...buisnes_options[resolt_category_id]);
          } else if (main_value === "Учеба и репетиторство") {
            arr_three.push(...teachers_options[resolt_category_id]);
          }
          get_options.forEach((item) => {
            item.closest(".category_option").remove();
          });
          for (let i = 0; i < arr_three.length; i++) {
            const currentValue = arr_three[i];
            if (!uniqueValues.has(currentValue)) {
              const create_option_block = document.createElement("div");
              create_option_block.classList = "category_option";
              create_option_block.innerHTML =
                "<p class=" + i + ">" + currentValue + "</p>";
              get_option_block.appendChild(create_option_block);
              uniqueValues.add(currentValue);
            }
          }
          const get_new_options = document.querySelectorAll(
            ".make_order_container .category_choice p"
          );
          get_new_options.forEach((item) => {
            item.addEventListener("click", function () {
              const get_close_icon = document.querySelectorAll(
                ".make_order_container .category_choice svg"
              )[1];
              get_close_icon.addEventListener("click", function () {
                const get_restart_block = document.querySelector(
                  ".make_order_container .category_header .restart"
                );
                get_restart_block.classList.add("restart_active");
              });
              const get_inputs = document.querySelectorAll(
                ".make_order_container .category_part input"
              );
              const last_input = get_inputs.length - 1;
              get_inputs[last_input].value = item.innerHTML;
              get_inputs[last_input].style.opacity = 0.5;
              get_inputs[last_input].style.pointerEvents = "none";
            });
          });
        }
      }
    });
  });

  function input() {
    const get_final_category = document.querySelectorAll(
      ".make_order_container .final_category"
    );
    const create_input = document.createElement("input");
    create_input.type = "text";
    create_input.classList = "check_value right_order input_" + input_temp;
    create_input.id = input_temp;
    create_input.placeholder = "Выбирите категорию";
    create_input.setAttribute("readonly", "");
    if (input_temp === 1) {
      create_input.name = "medium_order_category";
      get_final_category[0].appendChild(create_input);
    } else {
      create_input.name = "final_order_category";
      get_final_category[1].appendChild(create_input);
    }
    const get_last_input = document.querySelectorAll(
      ".make_order_container .category_part input.input_2"
    );
    if (get_last_input.length >= 1) {
      get_last_input[0].addEventListener("click", function () {
        document
          .querySelector(".make_order_container .category_part input")
          .click();
        document.querySelector(".category_options").id = get_last_input[0].id;
      });
    }
    get_final_category.forEach((item) => {
      const get_final_inputs = item.querySelectorAll("input");
      if (get_final_inputs.length >= 2) {
        get_final_inputs[1].remove();
      }
    });
  }
  function new_input() {
    input_temp++;
    document.querySelector(
      ".make_order_container .category_choice svg.rubbish"
    ).style.display = "block";
    document
      .querySelector(".make_order_container .category_choice svg.rubbish")
      .addEventListener("click", function () {
        category_block.innerHTML = category_html;
        category_menu();
      });
    const get_inputs_block = document.querySelector(
      ".make_order_container .category_part .inputs"
    );
    const get_all_inputs = get_inputs_block.querySelectorAll("input");
    get_all_inputs[0].style.opacity = 0.5;
    get_all_inputs[0].style.pointerEvents = "none";
    input();
    if (input_temp === 1) {
      get_inputs_block.style.display = "grid";
    }
    const get_inputs = document.querySelectorAll(
      ".make_order_container .category_part .final_category input"
    );
    if (get_inputs[0].value.length === 0 && get_inputs.length >= 2) {
      get_inputs[1].remove();
    }
    if (get_inputs.length >= 3) {
      get_inputs[2].remove();
    }
    //menu_script
    input_click();
  }
  function input_click() {
    let choice_option = null;
    const get_category_inputs = document.querySelectorAll(
      ".final_category input"
    );
    get_category_inputs.forEach((item) => {
      let input_id = null;
      item.addEventListener("click", function () {
        input_id = item.id;
        const get_option_block = document.querySelector(".category_options");
        const get_options =
          get_option_block.querySelectorAll(".category_option");
        document
          .querySelector(
            ".make_order_container .category_part input.category_input"
          )
          .click();
        get_options.forEach((item) => {
          item.remove();
        });
        if (input_id === "1") {
          choice_option = options_two;
        }
        option_create();
        if (choice_option.length === options_two.length) {
          get_option_block.id = 1;
        } else {
          get_option_block.id = 2;
        }
        function option_create() {
          for (let i = 0; i < choice_option.length; i++) {
            const create_option_block = document.createElement("div");
            create_option_block.classList = "category_option";
            create_option_block.innerHTML =
              "<p id=" + i + ">" + choice_option[i] + "</p>";
            get_option_block.appendChild(create_option_block);
          }
          let input_temp = 0;
          const get_options = document.querySelectorAll(
            ".make_order_container .category_choice p"
          );
          get_options.forEach((item) => {
            item.addEventListener("click", function () {
              input_temp = 2;
              new_input();
              input();
              if (local_block_id === "1") {
                resolt_category_id = item.id;
                const get_input = document.querySelectorAll(
                  ".make_order_container .category_part input"
                )[1];
                get_input.value = item.innerHTML;
                get_input.style.opacity = 0.5;
                get_input.style.pointerEvents = "none";
                setTimeout(() => {
                  document
                    .querySelectorAll(
                      ".make_order_container .category_part input"
                    )[2]
                    .click();
                }, 1);
              } else if (local_block_id === "2") {
                const get_input = document.querySelectorAll(
                  ".make_order_container .category_part input"
                )[2];
                get_input.value = item.innerHTML;
                get_input.style.opacity = 0.5;
                get_input.style.pointerEvents = "none";
              }
              get_sub_menu.classList.remove("category_choice_animation");
              menu_temp = 0;
            });
          });
        }
      });
    });
  }
  const get_options = document.querySelectorAll(
    ".make_order_container .category_choice p"
  );
  for (let i = 0; i < get_options.length; i++) {
    get_options[i].id = i;
  }
  get_options.forEach((item) => {
    item.addEventListener("click", function () {
      let item_id = item.id;
      options_two.push(...options[item_id]);
      new_input();
      get_input[0].value = item.innerHTML;
      main_value = get_input[0].value;
      get_sub_menu.classList.remove("category_choice_animation");
      menu_temp = 0;
      document
        .querySelectorAll(".make_order_container .category_part input")[1]
        .click();
    });
  });
}
category_menu();
//payment_choice
function payment_choice() {
  const get_options = document.querySelectorAll(
    ".make_order_container .option"
  );
  get_options.forEach((item) => {
    item.addEventListener("click", function () {
      const get_input = document.querySelector("input.payment_option");
      get_input.value = item.querySelector("p").innerHTML;
      const item_id = parseInt(item.id, 10);
      get_options.forEach((item) => {
        item.classList.remove("option_active");
      });
      item.classList.add("option_active");
      item.classList.remove("hover_active");
      if (item_id === 1) {
        get_options[0].classList.add("hover_active");
      } else {
        get_options[1].classList.add("hover_active");
      }
    });
  });
  get_options[0].click();
}
payment_choice();
