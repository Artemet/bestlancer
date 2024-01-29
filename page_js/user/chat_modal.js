//chat_modal
function chat_modal(){
    const get_chat_button = document.querySelectorAll("button.chat_start");
    const get_close_icon = document.querySelector(".start_chat_container .close svg");
    //open_modal
    get_chat_button.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_modal = document.querySelector(".start_chat_container");
            get_modal.style.display = "block";
            setTimeout( () => {get_modal.style.opacity = 1;}, 100);
        });
    });
    //close_modal
    get_close_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".start_chat_container");
        get_modal.style.opacity = 0;
        setTimeout( () => {get_modal.style.display = "none";}, 500);
    });
}
chat_modal();