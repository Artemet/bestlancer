//chat_background
function chat_background(){
    const get_options = document.querySelectorAll(".settings_container .background_options .option");
    const get_active_option = document.querySelector("p.active_bg").innerHTML.trim();
    const get_images_options = document.querySelectorAll(".settings_container .option img");
    get_options.forEach( (item) => {
        item.addEventListener("click", function (){
            const background_src = item.querySelector("img").src;
            //ajax_send
            $.ajax({
                method: 'POST',
                url: '../bd_send/user/messanger/change_background.php',
                data: { new_bg: background_src }
            });

            get_options.forEach( (item) => {
                item.querySelector("input").checked = false;
                item.classList.remove("active_option");
            });
            item.classList.add("active_option");
            if (item.className.includes("active_option")){
                item.querySelector("input").checked = true;
            } else{
                item.querySelector("input").checked = false;
            }
        });
    });
    get_images_options.forEach( (item) => {
        if (item.src.trim() === get_active_option){
            item.closest(".option").click();
        }
    });
}
chat_background();