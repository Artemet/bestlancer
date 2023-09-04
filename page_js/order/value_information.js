//value_check
function value_order_check(){
    const get_inputs = document.querySelectorAll(".make_order_container .check_value");
    const get_button_wrapper = document.querySelector(".make_order_container .button_wrapper");
    const get_button = document.querySelector(".make_order_container button");
    get_inputs.forEach( (item) => {
        if (item.value === "" || get_inputs[0].value === ""){
            get_button.style.pointerEvents = "none";
            get_button_wrapper.onclick = order_value_warning;
        } else {
            get_button.style.pointerEvents = "all";
        }
    });
    const get_money_input = document.querySelector(".make_order_container .money_right");
    if (get_money_input.value === ""){
        get_money_input.classList.add("check_value");
    } else{
        get_money_input.classList.remove("check_value");
    }
}
function order_value_warning(){
    alert("Введите все поля чтоб разместить заказ на бирже!");
}