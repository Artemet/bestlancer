//start_order
function start_order(){
    let user_id = null;
    const get_button = document.querySelectorAll("button.start_order_button");
    const get_cross = document.querySelector(".start_order_container .close");
    get_button.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_modal = document.querySelector(".start_order_container");
            user_id = parseInt(item.closest(".application").querySelector("noscript.user_id").innerHTML.trim(), 10);
            get_modal.style.display = "block";
            setTimeout( () => {
                get_modal.style.opacity = 1;
            }, 100);
        });
    });
    //form_scripts
    let option_temp = 0;
    const get_checkbox_option = document.querySelector(".start_order_container .checkbox_agree");
    const get_final_button = document.querySelector(".start_order_container button");
    get_cross.addEventListener("click", function (){
        const get_modal = document.querySelector(".start_order_container");
        get_modal.style.opacity = 0;
        setTimeout( () => {
            get_modal.removeAttribute("style");
        }, 500);
    });
    get_checkbox_option.addEventListener("click", function (){
        option_temp++;
        if (option_temp === 1){
            get_checkbox_option.querySelector("input").checked = true;
            get_final_button.classList.add("ready");
        } else{
            get_checkbox_option.querySelector("input").checked = false;
            get_final_button.classList.remove("ready");
            option_temp = 0;
        }
    });
    //final_start
    get_final_button.addEventListener("click", function (){
        this.classList.remove("ready");
        const get_value = document.querySelector(".start_order_container textarea").value.trim();
        const get_order_id = document.querySelector(".order_page p.order_id").innerHTML.trim();
        $.ajax({
            method: "POST",
            url: "../bd_send/user/message_users.php?user_id=" + user_id,
            data: { thirst_message: get_value, order_id: get_order_id }
        })
            .done(function (response){
                console.log(response);
                document.querySelector(".start_wrapper").classList.add("start_wrapper_load");
                document.querySelector(".start_order_container .overlay").classList.add("overlay_active");
                setTimeout( () => {
                    window.location.href = "../pages/order_progress.php?order_id=" + get_order_id;
                }, 1000);
            });
    });
}
start_order();