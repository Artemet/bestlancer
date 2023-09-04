//email_value
function order_email_value(){
    const get_input = document.querySelector(".make_order_container .email_input");
    const get_user_email = document.querySelector(".make_order_container .email_information").innerHTML;
    get_input.value = get_user_email;
}
order_email_value();