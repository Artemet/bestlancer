//star_system
let star_modal_temp = 0;
let star_click = false;
let review_click = false;
const get_star_icon = document.querySelectorAll(".freelance_container .start_system svg");
const get_review_textarea = document.querySelector(".star_option textarea");
function star_system(){
    let star_temp = 0;
    let star_number = 0;
    get_review_textarea.addEventListener("click", function (){
        review_click = true;
    });
    get_star_icon.forEach( (item) => {
        //mouse_script
        item.addEventListener("mouseover", function (){
            if (star_click === false){
                for (let i = 0; i < get_star_icon.length; i++){
                    get_star_icon[i].classList.add("fill");
                    if (item.classList[0] < get_star_icon[i].classList[0]){
                        get_star_icon[i].classList.remove("fill");
                    }
                }
            }
        });
        item.addEventListener("mouseleave", function (){
            if (star_click === false){
                for (let i = 0; i < get_star_icon.length; i++){
                    get_star_icon[i].classList.remove("fill");
                }
            }
        });
        //click_script
        item.addEventListener("click", function (){
            star_temp++;
            star_click = true;
            star_number = item.classList[0];
            const get_star_option = document.querySelector(".star_option");
            const get_modal_number = document.querySelector(".star_option_modal span.star_number");
            const get_star_email_input = document.querySelector(".star_option .buttons input.email");
            const get_star_number_input = document.querySelector(".star_option .buttons input.number");
            get_modal_number.innerHTML = star_number;
            get_star_number_input.value = star_number;
            if (get_star_option.innerHTML.includes("Гость")){
                get_star_email_input.value = "Гость";
            } else{
                const get_email = document.querySelector("p.email_information");
                get_star_email_input.value = get_email.innerHTML;
            }
            if (star_temp === 2){
                star_click = false;
                star_temp = 0;
            }
            for (let i = 0; i < get_star_icon.length; i++){
                get_star_icon[i].classList.add("fill");
                if (item.classList[0] < get_star_icon[i].classList[0]){
                    get_star_icon[i].classList.remove("fill");
                }
            }
            star_modal_temp = 1;
            setTimeout( () => {star_modal();}, 1250);
        });
    });
}
star_system();
function star_modal(){
    let modal_button_temp = 0;
    const get_modal = document.querySelector(".star_option_modal");
    const get_back_number = document.querySelector(".star_option .count_number span.moveing_number");
    const get_buttons = document.querySelectorAll(".star_option button");
    //buttons_choice
    get_buttons[0].addEventListener("click", function (){
        modal_button_temp++;
        star_modal_temp = 2;
        if (get_review_textarea.value === ""){
            review_click = false;
        }
        setTimeout( () => {get_back_number.innerHTML = 8;}, 500);
        star_modal();
        star_elements();
    });
    if (star_modal_temp === 1){
        get_modal.style.display = "block";
        setTimeout( () => {get_modal.style.opacity = 1;}, 100);
        setTimeout( () => {
            if (review_click === false){
                get_buttons[0].click();
            }
        }, 10000);
    } else{
        get_modal.style.opacity = 0;
        setTimeout( () => {get_modal.style.display = "none";}, 100);
        star_modal_temp = 0;
    }
    get_buttons[1].addEventListener("click", function (){
        if (get_review_textarea.value === ""){
            get_review_textarea.value = "нет отзыва";
        }
    });
}
function star_elements(){
    star_click = true;
    star_system();
}