//change_information_menu
function user_country_menu(){
    let sub_temp = 0;
    const get_country_input = document.querySelector(".change_profile input.country_input");
    get_country_input.addEventListener("click", function (){
        sub_temp++;
        const get_sub = document.querySelector(".change_profile .country_sub");
        if (sub_temp === 1){
            get_sub.classList.add("country_sub_open");
            setTimeout( () => {get_sub.style.opacity = 1;}, 100);
        } else{
            get_sub.style.opacity = 0;
            setTimeout( () => {get_sub.classList.remove("country_sub_open");}, 500);
            sub_temp = 0;
        }
    });
    //country_value
    const get_input_values = document.querySelectorAll(".change_profile .country_sub p");
    get_input_values.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_country_input = document.querySelector(".change_profile input.country_input");
            get_country_input.value = item.innerHTML;
        });
    });
    //textarea_value
    const get_textarea = document.querySelector(".user_container form textarea");
    const get_about_text = document.querySelector(".user_account .about_user p").innerHTML.trim();
    if (get_about_text !== "Нет информации"){
        get_textarea.value = get_about_text;
    }
}
user_country_menu();