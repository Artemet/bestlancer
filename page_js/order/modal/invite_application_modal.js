//invite_application_modal
function invite_application_modal(){
    //modal_open
    const get_icon = document.querySelector(".order_page .add_person svg");
    const get_close_icon = document.querySelector(".invite_modal .close_icon");
    get_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".invite_modal");
        get_modal.style.display = "block";
        setTimeout( () => {get_modal.style.opacity = 1;}, 100);
    });
    get_close_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".invite_modal");
        get_modal.style.opacity = 0;
        setTimeout( () => {get_modal.style.display = "none";}, 500);
    });
    //click_script
    const get_users = document.querySelectorAll(".invite_modal .user_row");
    const get_button = document.querySelector(".invite_modal button");
    get_users.forEach( (item) => {
        item.addEventListener("click", function (){
            get_users.forEach( (item) => {
                item.classList.remove("user_row_active");
            });
            item.classList.add("user_row_active");
            get_button.classList.add("active");
            document.querySelector(".invite_modal input.acquaintance_nik").value = item.querySelector("p").innerHTML.trim();
        });
    });
}
invite_application_modal();