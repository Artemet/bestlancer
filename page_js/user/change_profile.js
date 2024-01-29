//check_profile
function modal_include(){
    const get_modal = document.querySelectorAll(".change_profile_container");
    if (get_modal.length >= 1){
        return true;
    } else{
        return false;
    }
}

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
//delite_icon
function delite_icon(){
    $('svg.delite_icon').on("click", function (){
        const confirm_ask = confirm("Вы действительно хотите удалить аватарку?");
        if (confirm_ask){
            $.ajax({
                url: "../bd_send/user/delete_icon.php",
            })
                .done(function (response){
                    console.log(response);
                    $('.change_profile .img_change img').attr("src", "../bd_send/user/user_icons/user.png");
                });
        }
    });
}
//script_resolt
if (modal_include() === true){
    check_profile();
    delite_icon();
}