import { smile_add } from './smile_add.js';
import { user_answer } from './answer.js';
import { file_choice } from './file_choice.js';

import { chat_reaload } from './chat.js';
import { chat_attach } from './chat.js';
import { message_attach } from './chat.js';
import { mute_chat } from './chat.js';
import { block_user } from './chat.js';
import { delete_chat } from './chat.js';
import { complaint_chat } from './chat.js';

//chat_choice_ajax
const get_companion_infromation = document.querySelectorAll(".companion_choice").length;
//text_hide
function text_hide(){
    const get_values = document.querySelectorAll(".chat_row .message p.message_value");
    get_values.forEach( (element) => {
        const text = element.innerHTML.trim();
        if (text.length >= 1000) {
            if (element.parentNode.hasAttribute("class")){
                element.innerHTML = text.substring(0, 1000) + '... <b class="more_text text_function" id="0">Далее</b>';
            } else{
                element.innerHTML = text.substring(0, 1000) + '...';
            }
            function more_text(){
                const more_text = element.querySelectorAll(".chat_row b.more_text");
                more_text.forEach( (item) => {
                    item.addEventListener("click", function (){
                        this.remove();
                        const item_id = parseInt(item.id, 10);
                        if (item_id === 0){
                            element.innerHTML = text + '<b class="less_text text_function" id="1"> Скрыть</b>';
                            less_text();
                        } else{
                            element.innerHTML = text.substring(0, 1000) + '... <b class="more_text" id="0">Далее</b>';
                        }
                    });
                });
            }
            function less_text(){
                const get_less_text = element.querySelector(".chat_row b.less_text");
                get_less_text.addEventListener("click", function (){
                    element.innerHTML = text.substring(0, 1000) + '... <b class="more_text text_function" id="0">Далее</b>';
                    more_text();
                });
            }
            more_text();
        }
    });
}
//link_mark
function link_mark() {
    const getValues = document.querySelectorAll("p.main_value");
    getValues.forEach((element) => {
        const text = element.innerText;
        if (text.match(/http(s)?:\/\/\S+/)) {
            element.innerHTML = text.replace(
                /(http(s)?:\/\/\S+)/g,
                "<a href='$1' class='message_link' target='_blank'>$1</a>"
            );
        }
    });
}
document.addEventListener("DOMContentLoaded", function (){
    let chat_load = false;
    let error_count = 0;
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
                error_count++;
                //chat_options
                const menu_icon = document.querySelectorAll(".more_options div")[0];
                menu_icon.addEventListener("click", function (){
                    this.querySelector("svg").classList.toggle("active");
                    const get_sub_menu = document.querySelector(".user_chat .more_options .sub_menu");
                    get_sub_menu.classList.toggle("sub_menu_active");
                });
                //chat_functions when blocked
                chat_reaload();
                mute_chat();
                block_user();
                delete_chat();
                complaint_chat();
                text_hide();
                chat_attach();
                link_mark();
                if (error_count >= 2){
                    return;
                }
                console.error("Данный чат недоступен!");
            }); 
    }
    const setupEventListeners = () => {
        //chat_functions when active
        smile_add();
        user_answer();
        file_choice();
        chat_attach();
        message_attach();
        chat_reaload();
        mute_chat();
        block_user();
        delete_chat();
        complaint_chat();
        text_hide();
        link_mark();
        
        let request_link = null;
        let final_option = null;
        //message_option
        let menu_temp = 0;
        const get_arrows = document.querySelectorAll(".chat_row .message .arrow");
        const get_messages = document.querySelectorAll(".chat_row .message");
        for (let i = 0; i < get_arrows.length; i++){
            get_arrows[i].id = i;
        }
        get_arrows.forEach( (item) => {
            item.addEventListener("click", function (){
                menu_temp++;
                const main_parent = item.closest(".chat_row .message");
                const get_value_tag = main_parent.querySelector("p.main_value");
                const message_option = main_parent.querySelectorAll(".message_menu p");
                get_value_tag.classList.toggle("main_value_wait");
                for (let i = 0; i < message_option.length; i++){
                    message_option[i].id = i;
                }
                message_option.forEach( (item) => {
                    item.addEventListener("click", function (){
                        const item_class = item.className;
                        const row_id = parseInt(item.closest(".chat_row").id, 10);
                        if (item_class.includes("delete")){
                            final_option = "delete";
                        } else if (item_class.includes("change")){
                            final_option = "change";
                            const message_value = item.closest(".chat_row .message").querySelector("p.main_value").textContent.trim();
                            const get_message_input = document.querySelector(".user_chat input.message_right");
                            const get_button = document.querySelector(".user_chat button");
                            get_message_input.value = message_value;
                            get_message_input.id = item.closest(".chat_row").id;
                            get_button.innerHTML = "Сохранить";
                            request_link = "../bd_send/user/messanger/message_change.php";
                            get_message_input.addEventListener("input", function (){
                                if (get_message_input.value === ""){
                                    const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
                                    get_message_input.removeAttribute("id");
                                    get_button.innerHTML = "Отправить";
                                    request_link = "../bd_send/user/message_system.php?chat_id=" + get_chat_id;
                                }
                            });
                        }
                        if (final_option === "delete"){
                            $.ajax({
                                method: "POST",
                                url: "../bd_send/user/messanger/message_change.php",
                                data: { message_option: final_option, message_id: row_id }
                            })
                                .done(function () {
                                    if (final_option === "delete"){
                                        document.querySelector(".messanger_users .message_user_active").click();
                                    }
                                });
                        }
                    });
                });

                const item_id = parseInt(item.id, 10);
                const item_menu = item.closest(".message").querySelector(".message_menu");
                get_arrows.forEach( (item) => {
                    const check_item_id = parseInt(item.id, 10);
                    if (check_item_id !== item_id){
                        item.closest(".message").classList.add("message_none");
                        item.classList.remove("arrow_active");
                    }
                });
                if (menu_temp === 1){
                    item_menu.style.display = "block";
                    setTimeout( () => {
                        item_menu.classList.add("message_menu_active");
                    }, 50);
                } else{
                    get_messages.forEach( (item) => {
                        item.classList.remove("message_none");
                    });
                    item_menu.classList.remove("message_menu_active");
                    setTimeout( () => {
                        item_menu.removeAttribute("style");
                    }, 300);
                    menu_temp = 0;
                }
                item.closest(".message").classList.toggle("arrow_stay");
                item.parentNode.classList.toggle("arrow_opacity_active");
                item.classList.toggle("arrow_active");
            });
        });
        //message_post
        $('.user_chat button').on('click', function (){
            const message_value = $('.user_chat input.message_right').val();
            const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
            let message_id = document.querySelector(".user_chat input.message_right").id.trim();
            if (message_id.length === 0){
                message_id = 0;
            }
            if (request_link === null){
                request_link = "../bd_send/user/message_system.php?chat_id=" + get_chat_id;
            }
            //message_type
            let answer_id = null;
            let file_add = 0;
            const get_answer_line = document.querySelector(".user_chat .answer_line");
            const get_files = document.querySelectorAll(".user_chat .file_line .file");
            if (get_answer_line.hasAttribute("id")){
                answer_id = parseInt(get_answer_line.id, 10);
            } else{
                answer_id = 0;
            }
            if (get_files.length >= 1){
                file_add = 1;
            }
            if (message_value.length !== 0 || get_files.length !== 0){
                const formData = new FormData();
                const fileInput = document.getElementById('icon_choice');
                formData.append('file', fileInput.files[0]);
                formData.append('message_option', final_option);
                formData.append('message_id', message_id);
                formData.append('answer_id', answer_id);
                formData.append('message_value', message_value);

                $.ajax({
                    method: "POST",
                    url: request_link,
                    contentType: false,
                    processData: false,
                    data: formData,
                })
                    .done(function () {
                        const inputValue = $('.user_chat input.message_right').val();
                        const containsHtmlTags = /<[a-z][\s\S]*>/i.test(inputValue);
                        if (containsHtmlTags) {
                            alert("В сообщении не может присутствоваться HTML код!");
                        } else {
                            $('.user_chat input.message_right').val("");
                            document.querySelector(".messanger_users .message_user_active").click();
                        }
                    });                
            }
        });
        //chat_options
        const menu_icon = document.querySelectorAll(".more_options div")[0];
        menu_icon.addEventListener("click", function (){
            this.querySelector("svg").classList.toggle("active");
            const get_sub_menu = document.querySelector(".user_chat .more_options .sub_menu");
            get_sub_menu.classList.toggle("sub_menu_active");
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
            const get_choice_text = document.querySelectorAll(".companion_choice");
            if (get_choice_text.length >= 1){
                get_choice_text[0].remove();
            }
            const get_notification_information = item.querySelectorAll(".notification_number");
            if (get_notification_information.length >= 1){
                get_notification_information[0].remove();
            }
            //deleted_message_check
            setTimeout( () => {
                const deleted_messages = document.querySelectorAll(".deleted_row");
                deleted_messages.forEach( (item) => {
                    item.parentNode.removeAttribute("id");
                });
            }, 100);
            document.querySelector(".user_chat").classList.remove("content");
            if (get_companion_infromation === 0){
                setTimeout( () => {
                    if (document.querySelector(".user_chat .companion_options a.reload_page_icon") !== null){
                        document.querySelector(".user_chat .companion_options a.reload_page_icon").href = "?chat_id=" + document.querySelector(".chat_number").innerHTML.trim();
                    }
                }, 100);
            }
            document.querySelectorAll(".messanger_users .message_user").forEach( (item) => {
                item.classList.remove("message_user_active");
            });
            item.children[0].classList.add("message_user_active");
            const url = e.currentTarget.getAttribute('href');
            load_page(url);
        });
    });
    const active_chat_id = document.querySelectorAll("noscript.chat_id");
    active_chat_id.forEach( (item) => {
        const active_id = parseInt(item.innerHTML, 10);
        const get_chat_options = document.querySelectorAll("a.chat_link");
        get_chat_options.forEach( (item) => {
            const chat_option_id = parseInt(item.id, 10);
            if (chat_option_id === active_id){
                item.click();
            }
        });
    });
});
//enter_send
function enter_send(){
    function handleKeyPress(event) {
        if (event.keyCode === 13) {
            document.querySelector(".user_chat button").click();
        }
    }
    document.addEventListener('keydown', handleKeyPress);
}
enter_send();
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
            get_link.addEventListener('click', function (e){
                document.querySelector(".messanger_users .message_user_active").click();
            });
        };
    });
}
if (get_companion_infromation === 0){
    chat_print_ajax();
}