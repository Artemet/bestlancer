//menu
function user_menu(){
    let menu_temp = 0;
    const get_menu_icon = document.querySelectorAll(".user_account .burger_menu");
    const get_menu = document.querySelectorAll(".user_account .sub_menu");
    const get_include_block = document.querySelector(".user_account .menu_include");
    const get_menu_include = document.querySelectorAll(".user_account .sub_menu .include");
    //icon_animation
    get_menu_icon.forEach( (item) => {
        item.addEventListener('click', function (){
            menu_temp++;
            console.log(item);
            item.classList.toggle("burger_menu_animation");
            //main_menu_code
            if (menu_temp === 1){
                get_include_block.style.marginBottom = 0;
                get_menu.forEach( (item) => {
                    item.classList.add("sub_menu_animation");
                });
                get_menu_include.forEach( (item) => {
                    setTimeout( () => {item.style.opacity = 0;}, 500);
                });
            } else{
                get_include_block.style.marginBottom = 100 + "px";
                get_menu.forEach( (item) => {
                    item.classList.remove("sub_menu_animation");
                });
                get_menu_include.forEach( (item) => {
                    setTimeout( () => {item.style.opacity = 1;}, 500);
                });
                menu_temp = 0;
            }
        });
    });
}
user_menu();