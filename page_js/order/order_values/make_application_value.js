//application_value
function application_value(){
    const get_inputs = document.querySelectorAll(".application_page .application_information input");
    const get_max_price = document.querySelector(".application_page p.max_price b.price");
    if (get_max_price.innerHTML === "0"){
        const get_max_price_tag = document.querySelector(".application_page p.max_price");
        get_max_price_tag.remove();
        get_inputs[0].max = "";
    }
    //input_check
    const get_send_button = document.querySelector(".application_page form p.form_send");
    get_send_button.addEventListener("click", function (){
        const get_warning = document.querySelector(".application_page form u.warning");
        const get_inputs = document.querySelectorAll(".application_page .application_information input");
        if (get_inputs[0].value === "" && get_inputs[1].value === ""){
            get_warning.innerHTML = "Введите цену и сроки!";
        } else if (get_inputs[0].value === ""){
            get_warning.innerHTML = "Введите цену!";
        } else if (get_inputs[0].value < 5){
            get_warning.innerHTML = "Минимальная цена 5$";
        } else if (get_inputs[1].value === ""){
            get_warning.innerHTML = "Введите сроки!";
        } else if (get_inputs[0].value.includes("-") || get_inputs[1].value.includes("-")){
            get_warning.innerHTML = "Неальзя использовать минусовые цифры!";
        } else if (get_inputs[0].value.includes("e") || get_inputs[1].value.includes("e")){
            get_warning.innerHTML = "Неальзя использовать символы!";
        } else if (get_inputs[0].value.includes("+") || get_inputs[1].value.includes("+")){
            get_warning.innerHTML = "Неальзя использовать символы!";
        } else{
            get_warning.innerHTML = "";
            const get_button_block = document.querySelector(".application_page .form_send_block");
            const change_button = document.createElement("button");
            change_button.innerHTML = get_send_button.innerHTML;
            change_button.classList = get_send_button.classList;
            get_send_button.remove();
            get_button_block.appendChild(change_button);
            change_button.click();
        }
    });
}
application_value();