// payment_option_menu
function payment_option(){
    let click_temp = 0;
    const get_options = document.querySelectorAll(".application_page .option_sub .option");
    const get_icon = document.querySelector(".application_page span.arrow svg");
    const get_input = document.querySelector(".application_page .option_sub input.option_resolt");
    get_icon.addEventListener("click", function (){
        const get_options = document.querySelector(".application_page .option_sub");
        get_options.classList.toggle("option_sub_animation");
        get_icon.classList.toggle("animation");
    });
    //option_value
    get_options.forEach( (item) => {
        item.addEventListener("click", function (){
            click_temp++;
            const get_chckbox = item.querySelector("input");
            const get_option_text = item.querySelector("p");
            let option_text = get_option_text.innerHTML;
            get_chckbox.click();
            if (click_temp === 2){
                get_input.value += option_text + " ";
                click_temp = 0;
            }
            item.style.pointerEvents = "none";
            item.style.opacity = 0.5;
        });
    });
}
payment_option();