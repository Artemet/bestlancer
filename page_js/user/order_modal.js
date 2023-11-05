//order_modal
function order_modal(){
    const get_order_button = document.querySelectorAll(".button_choice button.personal_order");
    const get_close_icon = document.querySelector(".personal_order_container .close");
    //open_modal
    get_order_button.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_modal = document.querySelector(".personal_order_container");
            get_modal.classList.add("personal_order_container_open");
            setTimeout( () => {get_modal.style.opacity = 1;}, 100);
        });
    });
    //close_modal
    get_close_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".personal_order_container");
        get_modal.style.opacity = 0;
        setTimeout( () => {get_modal.classList.remove("personal_order_container_open");}, 500);
    });
}
order_modal();