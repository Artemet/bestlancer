// service_category_menu
function category_menu(){
    const get_category_input = document.querySelector(".make_service input.category_menu");
    const get_close_icon = document.querySelector(".make_service .category_sub svg");
    const get_category_sub = document.querySelector(".make_service .category_sub");
    const get_categorys = document.querySelectorAll(".make_service .category_sub p");
    //open_script
    get_category_input.addEventListener("click", function (){
        get_category_sub.classList.toggle("category_sub_animation");
    });
    //close_script
    get_close_icon.addEventListener("click", function (){
        get_category_sub.classList.remove("category_sub_animation");
    });
    //category_click_script
    let color_temp = 0;
    get_categorys.forEach( (item) => {
        item.addEventListener("click", function (){
            color_temp++;
            if (color_temp === 1){
                item.style.color = "black";
            } else{
                get_categorys.forEach( (item) => {
                    item.style.color = "";
                });
                item.style.color = "black";
                color_temp = -1;
            }
            get_category_input.value = item.innerHTML;
        });
    });
    get_categorys[0].click();
}
category_menu();