//application_menu
function application_menu(){
    let menu_id = null;
    let menu_height = null;
    let menu_temp = 0;
    const get_wrappers = document.querySelectorAll(".order_page .user_order .application_part");
    const get_subs = document.querySelectorAll(".order_page .user_order .sub_information");
    for (let i = 0; i < get_wrappers.length; i++){
        get_wrappers[i].id = i;
        get_subs[i].id = i;
    }
    get_wrappers.forEach( (item) => {
        item.addEventListener("click", function (){
            menu_temp++;
            menu_id = item.id;
            let closest_wrapper = item.closest(".order_page .application");
            const get_sub = closest_wrapper.querySelector(".order_page .user_order .sub_information");
            const get_parts = get_sub.querySelectorAll(".order_page .user_order .part");
            menu_height = get_parts[0].clientHeight += get_parts[1].clientHeight;
            const get_arrow = closest_wrapper.querySelector(".order_page .user_order .arrow svg");
            get_arrow.classList.toggle("animation");
            if (menu_temp === 1){
                get_sub.style.height = menu_height + "px";
            } else{
                const get_subs = document.querySelectorAll(".order_page .user_order .sub_information");
                const get_arrows = document.querySelectorAll(".order_page .user_order .arrow svg");
                get_subs.forEach( (item) => {
                    item.style.height = 0;
                });
                get_arrows.forEach( (item) => {
                    item.classList.remove("animation");
                });
                get_sub.style.height = 0;
                menu_temp = 0;
            }
        });
    });
}
application_menu();