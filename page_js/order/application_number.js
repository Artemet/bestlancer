//application_number
function application_number(){
    const get_applications = document.querySelectorAll(".order_page .application");
    const get_application_number = document.querySelector(".order_page .application_number_wrapper span");
    get_application_number.innerHTML = get_applications.length;
    //user_check
    let user_include = false;
    const get_header_nik = document.querySelector(".user p.user_name").innerText.trim();
    get_applications.forEach( (item) => {
        if (item.innerHTML.includes(get_header_nik)){
            user_include = true;
        }
    });
    if (user_include === true){
        const get_application_wrapper = document.querySelector(".order_page .application_number_wrapper");
        const get_wrapper_blocks = document.querySelectorAll(".order_page .application_number_wrapper div");
        const get_button_choices = document.querySelectorAll(".order_page .button_choice a");
        get_button_choices[0].classList = "ready_application";
        const create_link = document.createElement("a");
        create_link.innerHTML = "Мои заявки";
        create_link.href = "my_responses.php";
        get_application_wrapper.appendChild(get_wrapper_blocks[0]);
        get_application_wrapper.appendChild(create_link);
        get_application_wrapper.appendChild(get_wrapper_blocks[1]);
        get_application_wrapper.style.gridTemplateColumns = "1fr auto auto";
        get_application_wrapper.style.gridGap = 20 + "px";
    }
}
application_number();