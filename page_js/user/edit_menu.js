//redactor_menu
let change_information_temp = 0;
let edit_menu_temp = 0;
function sub_choice(){
    edit_menu_temp++;
    const get_button = document.querySelectorAll(".user_account .account_redactor button");
    const get_arrow = document.querySelectorAll(".user_account .account_redactor .arrow");
    const get_sub_menu = document.querySelectorAll(".user_account .account_redactor .sub_menu");
    get_button.forEach( (item) => {
        item.classList.toggle("animation");
    });
    get_arrow.forEach( (item) => {
        item.classList.toggle("arrow_rotate");
    });
    if(edit_menu_temp === 1){
        get_sub_menu.forEach( (item) => {
            item.classList.add("sub_menu_block");
        });
        setTimeout( () => {
            get_sub_menu.forEach( (item) => {
                item.classList.add("sub_menu_open");
            });
        }, 100);
    }
    else if(edit_menu_temp === 2){
        get_sub_menu.forEach( (item) => {
            item.classList.remove("sub_menu_open");
        });
        setTimeout( () => {
            get_sub_menu.forEach( (item) => {
                item.classList.remove("sub_menu_block");
            });
        }, 500);
        edit_menu_temp = 0;
    }
}
function change_information(item){
    change_information_temp++;
    const get_modals = document.querySelectorAll(".change_profile_container");
    const get_close_icon = document.querySelectorAll(".change_profile .close svg");
    //open_modals
    if (change_information_temp === 1){
        item.classList.add("animation_color");
        get_modals[0].style.display = "block";
        setTimeout( () => {
            get_modals[0].classList.add("change_profile_container_animation");
        }, 100);
    }
    //close_modals
    get_close_icon.forEach( (item) => {
        item.addEventListener("click", function (){
            item_click();
            get_modals[0].classList.remove("change_profile_container_animation");
            setTimeout( () => {
                get_modals[0].style.display = "none";
            }, 500);
            change_information_temp = 0;
        });
    });
    function item_click(){
        item.classList.remove("animation_color");
    }
}