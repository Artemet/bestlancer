import { smile_add } from './smile_add.js';

//chat_choice_ajax
document.addEventListener("DOMContentLoaded", function (){
    let chat_load = false;
    const get_content = document.querySelector(".content");
    const get_chats = document.querySelectorAll(".messanger_users a.chat_link");
    const load_page = (url) => {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const new_content = doc.querySelector(".content");
                if (new_content){
                    get_content.innerHTML = new_content.innerHTML;
                    history.pushState({}, '', 'messages.php');
                    setupEventListeners();
                } else{
                    console.error("Content not found in the loaded page.");
                }
            }) .catch(error => {
                console.error("Error during fetch:", error);
            });
    }
    const setupEventListeners = () => {
        smile_add();
        //message_post
        $('.user_chat button').on('click', function (){
            const message_value = $('.user_chat textarea').val();
            const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
            if (message_value.length !== 0){
                $.ajax({
                    method: "POST",
                    url: "../bd_send/user/message_system.php?chat_id=" + get_chat_id,
                    data: { message_value: message_value }
                })
                    .done(function () {
                        $('.user_chat textarea').val("");
                        document.querySelector("a.reload_page_icon").click();
                    });
            }
        });
        //delite_comformation
        $("svg.delite").on("click", function () {
            const nik_information = $('.user_chat .message_user .user_information p').html().trim();
            const user_confirm = confirm("Вы уверины что хотите удалить пользователя " + nik_information + "?");
            // if (user_confirm) {
            //     window.location.href = "../bd_send/user/messanger/delete_chat.php?chat_id=1";
            // }
        });
        if (chat_load) {
            return;
        }
        const get_chat_id = parseInt($('.chat_number').html().trim(), 10);
        const reload_link = $('a.reload_page_icon');
        reload_link.prop("href", "?chat_id=" + get_chat_id);
        
        const updated_links = document.querySelectorAll(".messanger_users a.chat_link");
        updated_links.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const url = item.href;
                load_page(url);

                message_option();
            });
        });
        //message_options
        function message_option(){
            const get_arrow = document.querySelectorAll(".arrow_options");
            get_arrow.forEach( (item) => {
                item.addEventListener("click", function (){
                    this.classList.toggle("arrow_options_active");
                });
            });
        }
        chat_load = true;
    };

    get_chats.forEach( (item) => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            setTimeout( () => {
                document.querySelector(".user_chat .companion_options a.reload_page_icon").href = "?chat_id=" + document.querySelector(".chat_number").innerHTML.trim();
            }, 100);
            document.querySelectorAll(".messanger_users .message_user").forEach( (item) => {
                item.classList.remove("message_user_active");
            });
            item.children[0].classList.add("message_user_active");
            const url = e.currentTarget.getAttribute('href');
            load_page(url);
        });
    });
});
//chat_print_ajax
function chat_print_ajax(){
    let rotate_animation = true;
    window.addEventListener("DOMContentLoaded", function (){
        let rotate_temp = 0;
        const get_content = document.querySelector(".content");
        const get_link = document.querySelector("a.reload_page_icon");
        const load_page = (url) => {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const new_content = doc.querySelector(".content");
                    if (new_content){
                        get_content.innerHTML = new_content.innerHTML;
                        history.pushState({}, '', 'messages.php');
                        setupEventListeners();
                    } else{
                        console.error("Content not found in the loaded page.");
                    }
                });
        }
    
        const setupEventListeners = () => {
            const get_link = document.querySelector("a.reload_page_icon");
            get_link.addEventListener('click', (e) => {
                e.preventDefault();
                const url = get_link.href;
                load_page(url);
            });
        };
    
        get_link.addEventListener('click', (e) => {
            if (rotate_animation === true){
                rotate_temp += 360;
                document.querySelector(".reload_page_icon svg").style.transform = "rotate(" + rotate_temp + "deg)";
            }
            e.preventDefault();
            const url = e.currentTarget.getAttribute('href');
            load_page(url);
        });
    });
}
chat_print_ajax();