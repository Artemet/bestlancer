//screen_menu
const get_icon = document.querySelector(".header_line .mobile_menu img");
const get_menu_sub = document.querySelector(".header_line .mobile_menu .menu_sub");
function menu_open(){
    get_icon.classList.add("animation");
    get_menu_sub.classList.add("menu_sub_animation");
    setTimeout( () => {
        get_menu_sub.style.opacity = 1;
    }, 100);
}
function menu_close(){
    get_icon.classList.remove("animation");
    get_menu_sub.style.opacity = 0;
    setTimeout( () => {
        get_menu_sub.classList.remove("menu_sub_animation");
    }, 500);
}