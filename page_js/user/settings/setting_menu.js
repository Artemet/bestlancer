//setting_menu
function setting_menu(){
    const get_menus = document.querySelectorAll(".settings_container .menu_header");
    const sub_heights = [218, 218, 260];
    for (let i = 0; i < get_menus.length; i++){
        get_menus[i].id = i;
    }
    get_menus.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_sub = document.querySelectorAll(".settings_container .setting_sub")[item.id];
            get_sub.style.height = sub_heights[item.id] + "px";
            const get_arrow = item.querySelector("svg");
            get_sub.classList.toggle("setting_sub_none");
            get_arrow.classList.toggle("animation");
        });
    });
}
setting_menu();