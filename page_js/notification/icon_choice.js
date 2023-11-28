//icon_choice
function icon_choice(){
    //delite_notification_script
    const get_bin_icon = document.querySelector(".delite_icon svg");
    get_bin_icon.addEventListener("click", function (){
        const get_checkbox = document.querySelectorAll(".notification_container .notification .checkbox");
        const get_wrapper = document.querySelectorAll(".notification_wrapper");
        this.classList.toggle("active");
        get_checkbox.forEach( (item) => {
            item.classList.toggle("checkbox_active");
        });
        get_wrapper.forEach( (item) => {
            item.classList.toggle("notification_wrapper_block");
        });
    });
    //checkbox_choice
    const get_notififcations = document.querySelectorAll(".notification_container .notification");
    get_notififcations.forEach( (item) => {
        //code
    });
}
icon_choice();