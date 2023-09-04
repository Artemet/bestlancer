//notification_length
function notification_length(){
    const get_notification_container = document.querySelector(".notification_container .notifications");
    if (!get_notification_container.innerHTML.includes("div")){
        const create_warning = document.createElement("p");
        create_warning.innerHTML = "Нет увидомлений";
        create_warning.classList = "notification_warning";
        get_notification_container.appendChild(create_warning);
    } else{
        const get_header_title = document.querySelector(".header .header_title");
        const button_text = ["Просмотреть увидомления", "Очистить страницу"];
        const form_action = ["", "../bd_send/user/user_notification/notification_clean.php"];
        const create_button_wrapper = document.createElement("div");
        create_button_wrapper.classList = "button_choice";
        for (let i = 0; i < 2; i++){
            const create_form = document.createElement("form");
            create_form.action = form_action[i];
            create_form.method = "post";
            const create_button = document.createElement("button");
            create_button.innerHTML = button_text[i];
            create_button.classList = "page_choice";
            get_header_title.appendChild(create_button_wrapper);
            create_button_wrapper.appendChild(create_form);
            create_form.appendChild(create_button);
        }
        get_header_title.classList.add("header_title_notification");
    }
}
notification_length();