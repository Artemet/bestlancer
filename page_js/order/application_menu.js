//application_menu
function application_menu(){
    const get_wrappers = document.querySelectorAll(".order_page .user_order");
    get_wrappers.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_arrow = item.querySelector(".order_page .user_order .arrow svg");
            get_arrow.classList.toggle("animation");
            const get_sub = item.querySelector(".order_page .user_order .sub_information");
            get_sub.classList.toggle("sub_information_animation");
        });
    });
}
application_menu();