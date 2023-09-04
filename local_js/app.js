function header_check(){
    const get_header_two = document.querySelector(".header_line .header_part_two");
    const get_user_panel = document.querySelector(".user_panel");
    const get_user_name = document.querySelector(".user p.user_name");
    if(get_user_name.innerHTML.includes("Гость")){
        get_user_panel.remove();
    }
    else{
        get_user_panel.style.display = "flex";
        get_header_two.remove();
    }
}
//none_user_sing
function none_user_sing(){
    const get_sing_button = document.querySelectorAll(".header_line .header_part_two .button")[1];
    get_sing_button.click();
}