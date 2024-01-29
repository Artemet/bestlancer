//setting_menu
function setting_menu(){
    const get_menus = document.querySelectorAll(".settings_container .menu_header");
    const get_sub = document.querySelectorAll(".settings_container .setting_sub");
    let sub_heights = [];
    get_sub.forEach( (item) => {
        sub_heights.push(item.offsetHeight);
        item.classList.add("setting_sub_none");
    });
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
    //password_change
    function password_change(){
        const get_sub = document.querySelector(".password_sub");
        const get_button = get_sub.querySelector("button");
        const get_warning_line = get_sub.querySelector("u.warning");
        const get_inputs = get_sub.querySelectorAll(".right_in");
        get_button.addEventListener("click", function (){
            $.ajax({
                method: "POST",
                url: "../bd_send/settings/change_password.php",
                data: { old_password: get_inputs[0].value, new_password: get_inputs[1].value }
            })
                .done(function (response){
                    if (response.includes("Warning: ")){
                        get_warning_line.innerHTML = response;
                    } else{
                        window.location.href = "../bd_send/settings/change_password.php?final_change=1";
                    }
                });
        });
    }
    password_change();
}
window.addEventListener("DOMContentLoaded", function (){
    setting_menu();
});