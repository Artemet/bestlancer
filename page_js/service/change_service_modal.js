//change_modal
function change_service_modal(){
    //open_modal
    document.querySelector(".change_icon").addEventListener("click", function (){
        const get_modal = document.querySelector(".change_service");
        get_modal.style.display = "block";
        setTimeout( () => {
            get_modal.style.opacity = 1;
        }, 100);
    });
    //clode_modal
    document.querySelector(".user_container .close_icon").addEventListener("click", function (){
        const get_modal = document.querySelector(".change_service");
        get_modal.style.opacity = 0;
        setTimeout( () => {
            get_modal.style.display = "none";
        }, 500);
    });
    //textarea_value
    const get_textarea = document.querySelector(".change_service textarea");
    get_textarea.value = document.querySelector(".service_page .service_information p").innerHTML.trim();
}
change_service_modal();