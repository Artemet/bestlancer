//sing_in_check
const get_user_buttons = document.querySelectorAll(".header_line .header_part_two .button");
function sing_in_check(){
    //none_press_order
    const get_wrapper = document.querySelector(".tasks_container .order_button");
    const get_button_link = document.querySelector(".tasks_container a.order_page_link");
    const get_button = document.querySelector(".tasks_container button");
    const get_user_panel = document.querySelector(".user p.user_name");
    if (get_user_panel.innerHTML.includes("Гость")){
        get_wrapper.title = "Войдите в ваш аккаунт!";
        get_button_link.style.pointerEvents = "none";
        get_button.classList.add("none_press");
    } else{
        get_button_link.style.pointerEvents = "all";
        get_wrapper.title = "Разместить заказ";
        get_button.classList.remove("none_press");
    }
    //none_see_order
    let login_warning = false;
    const get_order_part = document.querySelectorAll(".tasks_container .order_part");
    const get_order_link = document.querySelectorAll(".tasks_container a.order_page_link");
    const get_task_tag = document.querySelectorAll(".tasks_container .order_part .task_tag");
    get_order_link.forEach( (item) => {
        item.addEventListener("mouseover", function (){
            if (get_user_panel.innerHTML.includes("Гость")){
                let link_tag = item.innerHTML;
                item.remove();
                const create_wrapper = document.createElement("div");
                create_wrapper.innerHTML = link_tag;
                create_wrapper.classList = "name_wrapper";
                get_order_part.forEach( (item) => {
                    item.appendChild(create_wrapper);
                    let main_block = item;
                    get_task_tag.forEach( (item) => {
                        main_block.appendChild(item);
                    });
                });
                login_warning = true;
            }
            if (login_warning === true){
                const get_wrappers = document.querySelectorAll(".tasks_container .order_part .name_wrapper");
                get_wrappers.forEach( (item) => {
                    item.addEventListener("click", function (){
                        get_user_buttons[1].click();
                    });
                });
            }
        });
    });
}
// sing_in_check();