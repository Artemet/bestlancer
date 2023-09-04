//chat_choice
function chat_choice() {
    let chat_click = parseInt(localStorage.getItem("chatClickCount")) || 0;
    const get_users = document.querySelectorAll(".messanger_users .message_user");
    const selectedChat = localStorage.getItem("selectedChat");
    if (selectedChat) {
        const [selectedImage, selectedName, selectedNik] = selectedChat.split('|');
        const get_chat_image = document.querySelector(".user_chat .message_user img");
        const get_chat_name = document.querySelector(".user_chat .message_user .user_information b");
        const get_chat_nik = document.querySelector(".user_chat .message_user .user_information p");
        get_chat_image.src = selectedImage;
        get_chat_name.innerHTML = selectedName;
        get_chat_nik.innerHTML = selectedNik;
    }
    
    get_users.forEach((item) => {
        item.addEventListener("click", function () {
            chat_click++;
            if (chat_click === 1) {
                item.style.backgroundColor = "#d08e0b44";
            } else {
                get_users.forEach((user) => {
                    user.style.backgroundColor = "white";
                });
                item.style.backgroundColor = "#d08e0b44";
                chat_click = 1;
            }
            const get_nik_input = document.querySelector(".user_chat .nik input");
            const get_chat_image = document.querySelector(".user_chat .message_user img");
            const get_chat_name = document.querySelector(".user_chat .message_user .user_information b");
            const get_chat_nik = document.querySelector(".user_chat .message_user .user_information p");
            const get_image = item.querySelector("img").src;
            const get_name = item.querySelector(".user_information b").innerHTML;
            const get_nik = item.querySelector(".user_information p").innerHTML;
            get_chat_image.src = get_image;
            get_chat_name.innerHTML = get_name;
            get_chat_nik.innerHTML = get_nik;
            get_nik_input.value = get_nik;
            const selectedChatData = `${get_image}|${get_name}|${get_nik}`;
            localStorage.setItem("selectedChat", selectedChatData);
            
            localStorage.setItem("chatClickCount", chat_click.toString());
        });
    });
    const get_name = document.querySelector(".user_chat .message_user .user_information b");
    get_users.forEach( (item) => {
        if (item.querySelector(".user_information b").innerHTML === get_name.innerHTML){
            item.click();
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    chat_choice();
});