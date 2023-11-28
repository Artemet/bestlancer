//icon_choice
function icon_choice(){
    //delite_notification_script
    let active_bin_choice = false;
    let choice_count = 0;
    const get_bin_icon = document.querySelector(".delite_icon svg");
    get_bin_icon.addEventListener("click", function (){
        const get_checkbox = document.querySelectorAll(".notification_container .notification input.checkbox");
        const get_wrapper = document.querySelectorAll(".notification_wrapper");
        document.querySelector(".notification_container .delite_number").classList.toggle("delite_number_active");
        this.classList.toggle("active");
        if (this.className.animVal.includes("active")){
            active_bin_choice = true;
        } else{
            active_bin_choice = false;
            document.querySelectorAll(".notification_container .notification").forEach( (item) => {
                item.classList.remove("notification_active");
            });
        }
        get_checkbox.forEach( (item) => {
            item.classList.toggle("checkbox_active");
        });
        get_wrapper.forEach( (item) => {
            item.parentNode.classList.toggle("notification_choice");
            item.classList.toggle("notification_wrapper_block");
        });
    });
    //checkbox_choice
    const get_notififcations = document.querySelectorAll(".notification_container .notification");
    get_notififcations.forEach( (item) => {
        item.addEventListener("click", function (){
            if (active_bin_choice === true){
                const get_checkbox = item.querySelector("input.checkbox");
                const get_choice_number = document.querySelector(".notification_container .delite_number b");
                get_checkbox.classList.toggle("checked");
                if (!get_checkbox.className.includes("checked")){
                    get_checkbox.checked = false;
                } else{
                    get_checkbox.checked = true;
                }
                get_choice_number.innerHTML = document.querySelectorAll("input.checked").length;
            }
        });
    });
}
icon_choice();