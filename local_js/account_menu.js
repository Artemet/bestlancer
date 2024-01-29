//account_menu
const get_body_account_menu = document.querySelector('body');
function account_menu(icon){
    icon.classList.add("account_icon_none");
    get_body_account_menu.style.overflow = "hidden";
    const get_modal_wrapper = document.querySelector(".other_modal");
    const get_modal = document.querySelector(".other_container");
    get_modal_wrapper.style.display = "block";
    setTimeout( () => {
        get_modal_wrapper.style.opacity = 1;
        get_modal.classList.add("other_container_open");
    }, 100);
    close_account_menu();
}
function close_account_menu(){
    const get_icon = document.querySelector(".header_line .account_icon_none");
    const get_modal_wrapper = document.querySelector(".other_modal");
    const get_cross = document.querySelector(".other_container .header_wrapper svg");
    const get_modal = document.querySelector(".other_container");
    get_cross.addEventListener("click", function (){
        get_icon.classList = "accaunt_change";
        get_modal.classList.remove("other_container_open");
        get_body_account_menu.style.overflow = "unset";
        get_modal_wrapper.style.opacity = 0;
        setTimeout( () => {get_modal_wrapper.style.display = "none";}, 500);
    });
}