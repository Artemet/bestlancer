//check_profile
function check_profile(){
    const get_check_button = document.querySelector(".change_profile form p.click");
    get_check_button.addEventListener('click', function (){
        let warning_check = false;
        const get_warning = document.querySelectorAll(".change_profile form u");
        const get_age_input = document.querySelector(".user_container form input.age");
        const get_real_button = document.querySelector(".change_profile form button.click");
        //age
        if(get_age_input.value.length === 0){
            get_warning[1].innerHTML = "Введите ваш возраст";
            warning_check = true;
        } else if(get_age_input.value.length >= 4){
            get_warning[1].innerHTML = "Вы слишком старый";
            warning_check = true;
        } else if(get_age_input.value.includes("-")){
            get_warning[1].innerHTML = "Введите нормальный возраст";
            warning_check = true;
        } else{
            get_warning[1].innerHTML = "";
        }
        //warning_check
        if(!warning_check){
            get_check_button.classList.add("click_none");
            get_real_button.classList.add("click_block");
            setTimeout( () => {get_real_button.click();}, 300);
        }
    });
}
check_profile();