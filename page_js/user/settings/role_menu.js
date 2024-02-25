//role_menu
function role_menu(){
    const get_role_input = document.querySelector(".role_input input");
    const get_input_options = document.querySelectorAll(".settings_container .role_input .sub_option");
    let profile_height = 218;
    get_role_input.addEventListener("click", function (){
        const get_sub_wrapper = document.querySelector(".settings_container .role_input .sub_wrapper");
        get_sub_wrapper.classList.toggle("sub_wrapper_animation");
    });
    //option_click_script
    get_input_options.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_role_input = document.querySelector(".role_input input");
            const get_all_p = document.querySelectorAll(".settings_container .role_input .sub_option p");
            const get_option_text = item.querySelector("p");
            get_all_p.forEach( (item) => {
                item.classList.remove("active");
            });
            get_option_text.classList.add("active");
            get_role_input.value = get_option_text.innerHTML;

            const role_value = $('.profile_menu input.role_value').val();
            $.ajax({
                method: "POST",
                url: "../bd_send/settings/change_profile.php",
                data: { role: role_value }
            });
        });
        if (item.querySelector("p").innerHTML === get_role_input.value){
            item.click();
        }
    });
}
role_menu();