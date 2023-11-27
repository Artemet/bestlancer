function send_menu_logic(){
    //menu_open
    let open_temp = 0;
    const get_icon = document.querySelector(".user_chat svg");
    get_icon.addEventListener("click", function (){
        open_temp++;
        const get_chat_menu = document.querySelector(".user_chat .choice_menu");
        if (open_temp === 1){
            this.classList.add("active");
            get_chat_menu.style.display = "block";
            setTimeout( () => {
                get_chat_menu.classList.add("choice_menu_animation");
            }, 100);
        } else{
            this.classList.remove("active");
            get_chat_menu.classList.remove("choice_menu_animation");
            setTimeout( () => {
                get_chat_menu.removeAttribute("style");
            }, 500);
            open_temp = 0;
        }
    });
    //send_options
    const get_chat_options = document.querySelectorAll(".user_chat .choice_menu p");
    const get_file_input = document.querySelector(".user_chat input.file_send");
    get_file_input.addEventListener("mouseover", function (){
        get_chat_options[0].classList.add("mouse");
    });
    get_file_input.addEventListener("mouseleave", function (){
        get_chat_options[0].classList.remove("mouse");
    });
}
send_menu_logic();