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
            get_sub.classList.toggle("setting_sub_active");
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
    //requisites_change
    function requisites_change(){
        let value_include = false;
        const get_values = document.querySelectorAll(".settings_container .payment_value input");
        const get_button = document.querySelector(".settings_container .payment_option button");

        get_button.addEventListener("click", function (){
            //value_check
            get_values.forEach( (item) => {
                if (item.value !== ""){
                    value_include = true;
                }
            });

            if (!value_include){
                alert("Введите, как минимум один реквизит для перевода средств покупателей.");
                return;
            }
            $.ajax({
                method: "POST",
                url: "../bd_send/settings/payment_option.php",
                data: {qiwi: get_values[0].value.trim(), bank_card: get_values[1].value.trim()},
            })
                .done(function (){
                    const get_wrapper = document.querySelector(".settings_container .requisites_wrapper");
                    const get_overlay = document.querySelector(".payment_option .overlay");
                    get_overlay.classList.add("overlay_active");
                    get_wrapper.classList.add("requisites_wrapper_load");
                    setTimeout( () => {
                        alert("Реквизиты были успешно добавлены. Теперь продавцы будут знать куда переводить средства.");
                        setTimeout( () => {
                            get_overlay.classList.remove("overlay_active");
                            get_wrapper.classList.remove("requisites_wrapper_load");
                        }, 100);
                    }, 800);
                });
        });
    }
    requisites_change();
}
window.addEventListener("DOMContentLoaded", function (){
    setting_menu();
});