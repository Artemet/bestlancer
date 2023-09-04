//chechbox_choice
let input_temp = 0;
let input_value_temp = 0;
const get_price_input = document.querySelector(".make_order_container .money_right");
function chechbox_choice(){
    let click_temp = 0;
    get_price_input.value = 0;
    const get_checkbox = document.querySelectorAll(".make_order_container .checkbox_block input");
    get_checkbox[0].click();
    get_checkbox[0].addEventListener('click', function (){
        input_value_temp++;
        if (input_value_temp === 1){
            get_price_input.value = "";
        } else{
            get_price_input.value = 0;
            input_value_temp = 0;
        }
        click_temp++;
        if (click_temp === 1){
            get_checkbox[0].click();
            get_checkbox[1].click();
            if (click_temp === 2){
                get_checkbox[1].click();
            } else{
                click_temp = 0;
            }
        }
    });
    get_checkbox[1].addEventListener('click', function (){
        click_temp = -1;
        get_checkbox[0].click();
        open_checkbox_menu();
    });
}
chechbox_choice();
function open_checkbox_menu(){
    const get_checkbox_sub = document.querySelector(".make_order_container .checkbox_sub");
    get_checkbox_sub.classList.toggle("checkbox_sub_open");
}