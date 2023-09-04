//category_menu
function category_menu(){
    let menu_temp = 0;
    const get_input = document.querySelector(".make_order_container .category_input");
    const get_sub_menu = document.querySelector(".make_order_container .category_choice");
    const get_close_icon = document.querySelector(".make_order_container .category_choice svg");
    get_input.addEventListener('click', function (){
        menu_temp++;
        if (menu_temp === 1){
            get_sub_menu.style.display = "block";
            setTimeout( () => {
                get_sub_menu.classList.add("category_choice_animation");
            }, 100);
        } else{
            get_sub_menu.classList = "category_choice";
            setTimeout( () => {
                get_sub_menu.style.display = "none";
            }, 500);
            menu_temp = 0;
        }
    });
    get_close_icon.addEventListener('click', function (){
        get_sub_menu.classList = "category_choice";
        setTimeout( () => {
            get_sub_menu.style.display = "none";
        }, 500);
        menu_temp = 0;
    });
    //click_logic
    const get_options = document.querySelectorAll(".make_order_container .category_choice p");
    get_options.forEach( (item) => {
        item.addEventListener('click', function (){
            get_input.value = item.innerHTML;
            if (item.innerHTML === "Без категорий"){
                get_input.value = "";
            }
        });
    });
}
category_menu();