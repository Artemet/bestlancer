//form_js
const get_body = document.querySelector("body");
const get_buttons = document.querySelector(".header_line .header_part_two");
const get_user_container = document.querySelectorAll(".user_account");
const get_inputs = document.querySelectorAll(".user_container form input");
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
//sing_in
function sing_in(){
  const get_sing_button = document.querySelector(".sing_in button");
  const get_inputs = document.querySelectorAll(".sing_in input.right_in");
  get_inputs[1].addEventListener("input", function (){
    if (get_inputs[0].value.length !== 0 && get_inputs[1].value.length >= 8){
      get_sing_button.classList.remove("buttons_none");
    } else{
      get_sing_button.classList.add("buttons_none");
    }
  });

  get_sing_button.addEventListener("click", function (){
    const get_inputs = document.querySelectorAll(".sing_in input.right_in");
    $.ajax({
      method: "POST",
      url: "../bd_send/user_sing_in.php",
      data: { nik_name: get_inputs[0].value, password: get_inputs[1].value, },
    })
      .done(function (response){
        const get_warning = document.querySelector(".sing_in u.warning");
        if (response === "error"){
          get_warning.innerHTML = "Неправильный ник-нейм или пароль";
        } else{
          location.reload();
          get_warning.innerHTML = "";
        }
      });
  });
}
sing_in();