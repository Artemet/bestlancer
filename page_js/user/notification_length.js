//notification_length
function notification_length(){
    const get_notification_container = document.querySelector(".notification_container .notifications");
    if (!get_notification_container.innerHTML.includes("div")){
        const create_warning = document.createElement("p");
        create_warning.innerHTML = "Нет увидомлений";
        create_warning.classList = "notification_warning";
        get_notification_container.appendChild(create_warning);
    }
}
notification_length();