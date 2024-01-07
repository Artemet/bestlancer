//form_js
const get_body = document.querySelector("body");
const get_buttons = document.querySelector(".header_line .header_part_two");
const get_user_container = document.querySelectorAll(".user_account");
const get_inputs = document.querySelectorAll(".user_container form input");
//open_containers
function open_form_one(){
    get_buttons.style.opacity = 0;
    get_body.style.overflow = "hidden";
    get_user_container[0].style.display = "block";
    setTimeout( () => {
        get_buttons.style.display = "none";
        get_user_container[0].classList.add("user_container_opacity");
    }, 100);
}
function open_form_two(){
    get_buttons.style.opacity = 0;
    get_body.style.overflow = "hidden";
    get_user_container[1].style.display = "block";
    setTimeout( () => {
        get_buttons.style.display = "none";
        get_user_container[1].classList.add("user_container_opacity");
    }, 100);
}
//close_containers
function close_form(){
  get_buttons.style.display = "flex";
  get_body.style.overflow = "auto";
  get_user_container[1].classList.remove("user_container_opacity");
  setTimeout( () => {
      get_buttons.style.opacity = 1;
  }, 100);
  setTimeout( () => {
    get_user_container[1].style.display = "none";
  }, 500);
}
//form_need
let press_temp = 0;
function password_consequences(){
    press_temp++;
    const get_eye = document.querySelectorAll(".user_container .password .eye svg");
    const get_password = document.querySelectorAll(".user_container .password input");
    get_eye.forEach( (item) => {
        item.classList.toggle("show_none");
    });
    if (press_temp === 1){
        get_password.forEach( (item) => {
            item.type = "text";
        });
    }
    else{
        press_temp = 0;
        get_password.forEach( (item) => {
            item.type = "password";
        });
    }
}
//country_input
function country_value(){
  const get_input = document.querySelector(".user_container form input.country");
  get_input.value = "Россия";
  //berger_menu_animation
  let menu_temp = 0;
  const get_menu_icon = document.querySelector(".user_container .registor_form .country img");
  get_menu_icon.addEventListener('click', function (){
    menu_temp++;
    const get_country_input = document.querySelector(".user_container .registor_form input.country");
    const get_menu = document.querySelector(".user_container .registor_form .country .menu");
    get_country_input.classList.toggle("input_animation");
    get_menu_icon.classList.toggle("animation");
    if (menu_temp === 1){
      get_menu.style.display = "block";
      setTimeout( () => {get_menu.classList.add("menu_animation");}, 100);
    }
    else{
      get_menu.classList.remove("menu_animation");
      setTimeout( () => {get_menu.style.display = "none";}, 500);
      menu_temp = 0;
    }
  });
  //country_choice
  const get_country = document.querySelectorAll(".user_container .registor_form .country .menu p");
  get_country.forEach( (item) => {
    item.addEventListener('click', function (){
      get_input.value = item.innerHTML;
    });
  });
}
country_value();
//age_input
function age_value(){
  const get_warning = document.querySelector(".user_container .registor_form .age u.warning");
  const get_input = document.querySelector(".user_container form input.age_input");
  const get_button_block = document.querySelector(".user_container .registor_form .age .age_change");
  const get_buttons = document.querySelectorAll(".user_container .registor_form .age .age_change span");
  let value_temp = get_input.value;
  get_buttons[0].addEventListener('click', function (){
    value_temp--;
    get_input.value = value_temp;
    if (value_temp === 10){
      value_temp++;
      get_button_block.style.marginTop = 25 + "px";
      get_warning.innerHTML = "У вас слишком маленький возраст";
    }
    else if(value_temp === 98){
      get_input.value = value_temp+1;
      get_button_block.style.marginTop = 6 + "px";
      get_warning.innerHTML = "";
    }
    else{
      get_button_block.style.marginTop = 6 + "px";
      get_warning.innerHTML = "";
    }
  });
  get_buttons[1].addEventListener('click', function (){
    value_temp++;
    get_input.value = value_temp;
    if (value_temp === 12){
      get_input.value = value_temp-1;
      get_button_block.style.marginTop = 6 + "px";
      get_warning.innerHTML = "";
    }
    else if (value_temp === 100){
      value_temp--;
      get_button_block.style.marginTop = 25 + "px";
      get_warning.innerHTML = "Вы слишком старые";
    }
    else{
      get_button_block.style.marginTop = 6 + "px";
      get_warning.innerHTML = "";
    }
  });
}
age_value();
//skill_value
function skill_value(){
  let option_temp = 0;
  const get_warning = document.querySelector(".user_container .registor_form .skills u.warning");
  const get_input = document.querySelector(".user_container form input.skills");
  const get_all_svg = document.querySelectorAll(".user_container .registor_form .skills svg");
  const get_cross = document.querySelector(".user_container .registor_form .skills .cross");
  const get_bin = document.querySelector(".user_container .registor_form .skills .bin svg");
  const get_menu_option = document.querySelectorAll(".user_container .registor_form .skills .menu p");
  const get_all_option = document.querySelectorAll(".user_container .registor_form .skills .menu p");
  //open_menu
  get_input.addEventListener('click', function (){
    const get_menu = document.querySelector(".user_container .registor_form .skills .menu");
    get_menu.style.display = "block";
    setTimeout( () => {get_menu.classList.add("menu_animation");}, 100);
    get_input.classList.add("input_animation");
    get_all_svg.forEach( (item) => {
      item.style.display = "block";
      setTimeout( () => {item.classList.add("animation");}, 100);
    });
  });
  //close_menu
  get_cross.addEventListener('click', function (){
    const get_menu = document.querySelector(".user_container .registor_form .skills .menu");
    get_menu.classList.remove("menu_animation");
    setTimeout( () => {get_menu.style.display = "none";}, 500);
    get_input.classList.remove("input_animation");
    get_all_svg.forEach( (item) => {
      item.classList.remove("animation");
      setTimeout( () => {item.style.display = "none";}, 500);
    });
  });
  //menu_system
  get_menu_option.forEach( (item) => {
    item.innerHTML = item.innerHTML + "  ";
    item.addEventListener('click', function (){
      option_temp++;
      item.style.display = "none";
      get_bin.classList.add("bin_animation");
      const get_input = document.querySelector(".user_container form input.skills");
      get_input.value += item.innerHTML;
      if(option_temp === 10){
        get_warning.innerHTML = "Максимальное каличество скилов: 10";
        get_all_option.forEach( (item) => {
          item.style.pointerEvents = "none";
        });
      }
    });
  });
  get_bin.addEventListener('click', function (){
    get_input.value = "";
    option_temp = 0;
    get_warning.innerHTML = "";
    get_bin.classList.remove("bin_animation");
    get_menu_option.forEach( (item) => {
      item.style.display = "block";
    });
    get_all_option.forEach( (item) => {
      item.style.pointerEvents = "all";
    });
  });
}
skill_value();
//user_projects
function user_projects(){
  let project_temp = 0;
  //add_work
  const get_add_icon = document.querySelector(".user_container .users_works .add_works .add");
  get_add_icon.addEventListener('click', function (){
    project_temp++;
    const get_waning = document.querySelector(".user_container .users_works u.warning");
    if (project_temp === 30){
      get_add_icon.classList.add("none_press");
      get_waning.innerHTML = "Это максимальное каличество проектов";
    }
    const get_delite_icon = document.querySelector(".user_container .users_works .add_works .delite");
    get_delite_icon.classList.add("active_press");
    const get_project_block = document.querySelector(".user_container .users_works .projects");
    const create_project = document.createElement("div");
    create_project.classList = "project";
    const create_number = document.createElement("span");
    create_number.innerHTML = project_temp;
    const create_input = document.createElement("input");
    create_input.type = "text";
    create_input.classList = "right_in";
    create_input.placeholder = "Введите ссылку на проект";
    get_project_block.appendChild(create_project);
    create_project.appendChild(create_number);
    create_project.appendChild(create_input);
  });
  //delite_work
  const get_delite_icon = document.querySelector(".user_container .users_works .add_works .delite");
  get_delite_icon.addEventListener('click', function (){
    project_temp--;
    const get_waning = document.querySelector(".user_container .users_works u.warning");
    if (project_temp === 0){
      get_delite_icon.classList.remove("active_press");
    }
    else if (project_temp === 29){
      get_add_icon.classList.remove("none_press");
      get_waning.innerHTML = "";
    }
    const get_project = document.querySelectorAll(".user_container .users_works .project");
    get_project[get_project.length-1].remove();
  });
  //apload_projects
  let upload_temp = 0;
  const get_uploader = document.querySelector(".user_container .users_works b");
  get_uploader.addEventListener('click', function (){
    upload_temp++;
    const get_warning = document.querySelector(".user_container .users_works u.warning");
    const get_all_input = document.querySelectorAll(".user_container .users_works .project input");
    const get_final_resolt = document.querySelector(".user_container .users_works textarea");
    get_final_resolt.value = "";
    get_all_input.forEach( (item) => {
      get_final_resolt.value += item.value + " ";
      if (!item.value.includes("http")){
        get_warning.innerHTML = "Введите ссылку на проект";
        get_final_resolt.value = "";
      } else{
        get_warning.innerHTML = "";
      }
    });
  });
}
user_projects();
//user_money
const get_buttons_block = document.querySelectorAll(".user_container form .button");
const get_warning = document.querySelectorAll(".user_container u.warning");
const get_eye = document.querySelectorAll(".user_container .password .eye");
const get_button = document.querySelectorAll(".user_container form .buttons");
//regestration
get_buttons_block[0].style.display = "none";
function value_check() {
    const get_input_email = document.querySelector(".user_container form input.email");
    const get_input_name = document.querySelector(".user_container form input.name");
    const get_input_family = document.querySelector(".user_container form input.family");
    const get_input_nik = document.querySelector(".user_container form input.nik");
    const get_input_password = document.querySelector(".user_container form input.password_input");
    const get_input_price = document.querySelector(".user_container form input.money");
    let hasErrors = false;
    // email
    if (get_input_email.value.includes("@") && get_input_email.value.length >= 5 && get_input_email.value.includes(".")) {
      get_warning[0].innerHTML = "";
    } else if (get_input_email.value.length === 0) {
      get_warning[0].innerHTML = "Введите ваш email";
      hasErrors = true; // Error found, set the flag to true
    } else {
      get_warning[0].innerHTML = "введите существующий email";
      hasErrors = true;
    }
    
    // name
    if (get_input_name.value.length === 0) {
      get_warning[1].innerHTML = "Введите ваше имя";
      hasErrors = true;
    } else {
      get_warning[1].innerHTML = "";
    }
    
    // family
    if (get_input_family.value.length === 0) {
      get_warning[2].innerHTML = "Введите вашу фамилию";
      hasErrors = true;
    } else {
      get_warning[2].innerHTML = "";
    }
    
    // nik_name
    if (get_input_nik.value.length === 0) {
      get_warning[3].innerHTML = "Введите ваш ник";
      hasErrors = true;
    } else if (get_input_nik.value.length >= 20) {
      get_warning[3].innerHTML = "Максимальное количество символов: 20";
      hasErrors = true;
    } else if (get_input_nik.value.length <= 4) {
      get_warning[3].innerHTML = "Введите ник длинее";
      hasErrors = true;
    } else if (get_input_nik.value.includes(" ")) {
      get_warning[3].innerHTML = "Нельзя использовать пробелы";
      hasErrors = true;
    } else {
      get_warning[3].innerHTML = "";
    }
    
    // password
    if (get_input_password.value.length === 0) {
      get_warning[4].innerHTML = "Введите ваш Пароль";
      get_eye[0].style.marginTop = 30 + "px";
      hasErrors = true;
    } else if (get_input_password.value.length <= 8) {
      get_warning[4].innerHTML = "Введите пароль подлинее";
      get_eye[0].style.marginTop = 30 + "px";
      hasErrors = true;
    } else if (get_input_password.value.length >= 30) {
      get_warning[4].innerHTML = "Слишком длинный пароль";
      get_eye[0].style.marginTop = 30 + "px";
      hasErrors = true;
    } else if (get_input_password.value.includes(" ")) {
      get_warning[4].innerHTML = "Нельзя использовать пробелы";
      get_eye[0].style.marginTop = 30 + "px";
      hasErrors = true;
    } else {
      get_warning[4].innerHTML = "";
      get_eye[0].style.marginTop = 10 + "px";
    }

    //hour_price
    if (get_input_price.value.length === 0){
      get_warning[10].innerHTML = "Введите вашу часовую ставку";
      hasErrors = true;
    } else if (get_input_price.value.length >= 10){
      get_warning[10].innerHTML = "У вас слишком большая ставка";
      hasErrors = true;
    } else if (get_input_price.value.includes("-")){
      get_warning[10].innerHTML = "Нельзя использовать минусавую ставку";
      hasErrors = true;
    } else{
      get_warning[10].innerHTML = "";
    }

    //error_check
    if (!hasErrors) {
        get_buttons_block[0].style.display = "block";
        get_buttons_block[1].style.display = "none";
        setTimeout( () => {
            get_button[0].click();
        }, 500);
    }
  }
//sing_in
get_buttons_block[2].style.display = "none";
function value_check_two(){
  const get_nik = document.querySelector(".user_container form input.come_in_nik");
  const get_password = document.querySelector(".user_container form input.come_in_password");
  let hasErrors = false;
  //nik
  if(get_nik.value === ""){
    get_warning[5].innerHTML = "Введите ваш ник";
    hasErrors = true;
  } else{
    get_warning[5].innerHTML = "";
  }
  //password
  if(get_password.value === ""){
    get_warning[6].innerHTML = "Введите ваш пароль";
    get_eye[1].style.marginTop = 30 + "px";
    hasErrors = true;
  } else{
    get_warning[6].innerHTML = "";
    get_eye[1].style.marginTop = 10 + "px";
  }
  //error_check
  if (!hasErrors) {
    get_buttons_block[2].style.display = "block";
    get_buttons_block[3].style.display = "none";
    setTimeout( () => {
        get_button[2].click();
    }, 500);
}
}