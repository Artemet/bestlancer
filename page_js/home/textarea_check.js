//textarea_value_check
const get_error_message = document.querySelector(".freelance_container .title_part p.error_message");
const get_form = document.querySelector("#task_send_form");
function textarea_value_mouse(){
    const get_textarea = document.querySelector(".freelance_container .title_part textarea");
    const get_button = document.querySelector(".freelance_container .title_part button");
    if (get_textarea.value === ""){
        get_form.removeAttribute("action");
        get_form.removeAttribute("method");
        get_button.onclick = textarea_value_click;
    }
    else{
        get_form.action = "../bd_send/task_text_bd.php";
        get_form.method = "post";
        get_button.onclick = "";
    }
}
function textarea_value_click(){
    get_form.removeAttribute("action");
    get_form.removeAttribute("method");
    get_error_message.style.display = "block";
}