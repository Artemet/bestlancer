//chat_scroll
function chat_scroll(){
    const get_chat = document.querySelector(".user_chat .chat");
    get_chat.scrollTop = get_chat.scrollHeight;
}
document.addEventListener("DOMContentLoaded", function() {
    chat_scroll();
});
//time
function message_time() {
    const messageTime = document.querySelectorAll(".chat_row .message_infrmation p");
    messageTime.forEach((item) => {
        const content = item.innerHTML;
        item.innerHTML = content.slice(0, -3);
    });
}
message_time();