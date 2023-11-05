//prject_change_modal
function prject_change_modal(){
    const get_icon = document.querySelector(".change_icon");
    const get_close_icon = document.querySelector(".user_container .close_icon svg");
    //open_modal
    get_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".change_project");
        get_modal.style.display = "block";
        setTimeout( () => {get_modal.classList.add("user_container_opacity");}, 100);
    });
    //close_modal
    get_close_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".change_project");
        get_modal.classList.remove("user_container_opacity");
        setTimeout( () => {get_modal.style.display = "none";}, 500);
    });
    //textarea_value
    const about_text = document.querySelector(".about .in_cover").innerHTML;
    const resolt_text = about_text.trim().replace(/\s+/g, ' ');
    document.querySelector(".user_container form textarea").value = resolt_text;
}
prject_change_modal();