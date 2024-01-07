//option_text
function option_text(){
    const get_options = document.querySelectorAll(".user_account .menu_include span");
    get_options.forEach( (item) => {
        if (!item.innerHTML.includes("-") && !item.innerHTML.includes("/") && item.innerHTML.length === 0){
            item.remove();
        }
    });
}
option_text();
function link_text(){
    const get_option_link = document.querySelectorAll(".user_account .menu_include a");
    get_option_link.forEach( (item) => {
        if (item.innerHTML.includes("none")){
            item.remove();
        }
    });
}
link_text();
//chat_open
function chat_open_user(){
    const get_chat_button = document.querySelectorAll(".user_account .button_choice button.chat_button");
    if (get_chat_button.length >= 1){
        get_chat_button[0].addEventListener("click", function (){
            const get_chat_id = document.querySelector("noscript.chat_id").innerHTML.trim();
            $.ajax({
                method: "POST",
                url: "../bd_send/user/message_system.php?chat_delete=" + get_chat_id,
                data: { add_command: "add" },
            });
        });
    }
}
chat_open_user();