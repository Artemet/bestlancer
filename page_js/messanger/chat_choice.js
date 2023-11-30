//chat_choice_ajax
document.addEventListener("DOMContentLoaded", function (){
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
        const get_chat_id = parseInt($('.chat_id').html().trim(), 10);
        const reload_link = $('a.reload_page_icon');
        reload_link.prop("href", "?chat_id=" + get_chat_id);

        const updated_links = document.querySelectorAll(".messanger_users a.chat_link");
        updated_links.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const url = item.href;
                load_page(url);

                message_option();
                console.log(false);
            });
        });
        //message_options
        function message_option(){
            const get_arrow = document.querySelectorAll(".arrow_options");
            get_arrow.forEach( (item) => {
                console.log(item.parentNode);
                item.addEventListener("click", function (){
                    this.classList.toggle("arrow_options_active");
                });
            });
        }
    };

    get_chats.forEach((item) => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
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
    $('.user_chat button').on('click', function (){
        const message_value = $('.user_chat textarea').val();
        const get_chat_id = parseInt(document.querySelector(".chat_id").innerHTML.trim(), 10);
        if (message_value.length !== 0){
            $.ajax({
                method: "POST",
                url: "../bd_send/user/message_system.php?chat_id=" + get_chat_id,
                data: { message_value: message_value }
            })
                .done(function () {
                    const currentTime = new Date().toLocaleTimeString('ru-RU', { timeZone: 'Europe/Moscow' }).slice(0, -3);
                    const chat_wrapper = $('.user_chat .chat');
                    $('.user_chat textarea').val("");
                    //message_create
                    rotate_animation = false;
                    document.querySelector("a.reload_page_icon").click();
                });
        }
    });
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
    // setInterval( () => {
    //     rotate_animation = false;
    //     document.querySelector("a.reload_page_icon").click();
    //     console.log(true);
    // }, 5000);
}
chat_print_ajax();