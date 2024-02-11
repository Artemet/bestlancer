//time
window.addEventListener("load", function (){
    document.querySelector(".arrow_up").remove();
});
function message_time() {
    const messageTime = document.querySelectorAll(".chat_row .message_infrmation p");
    messageTime.forEach((item) => {
        const content = item.innerHTML;
        item.innerHTML = content.slice(0, -3);
    });
}
message_time();
//chat_reaload
export function chat_reaload(){
    const get_reaload_element = document.querySelector(".chat_reload");
    if (get_reaload_element !== null){
        get_reaload_element.addEventListener("click", function (){
            document.querySelector(".messanger_users .message_user_active").click();
        });
    }
    //reload_files
    const get_files = document.querySelectorAll(".file_download");
    get_files.forEach( (item) => {
        item.closest("a").setAttribute("download", "");
    });
}
chat_reaload();
//chat_attach
export function chat_attach(){
    const get_attach = document.querySelector(".attach");
    const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
    get_attach.addEventListener("click", function (){
        const attach_id = parseInt(this.id, 10);
        if (attach_id === 0){
            this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" class="none_save" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"/></svg>';
            this.id = 1;
        } else if (attach_id === 1){
            this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" class="none_save" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"/></svg>';
            this.id = 0;
        }
        $.ajax({
            url: '../bd_send/user/message_users.php?user_attach=' + get_chat_id,
        });
    });
}
//message_attach
export function message_attach(){
    const get_message_options = document.querySelectorAll(".message_attach");
    const get_cross_icon = document.querySelectorAll(".user_chat .attach_line .cross_icon");
    get_message_options.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_agree = confirm("Вы уверины что хотите закрепить сообщение?");
            if (get_agree){
                const message_id = parseInt(item.closest(".chat_row").id, 10);
                try {
                    if (item.closest(".chat_row").hasAttribute("id")){
                        $.ajax({
                            method: "POST",
                            url: "../bd_send/user/message_system.php?message_attach_id=" + message_id,
                            data: { message_attach_id: message_id },
                        })
                            .done(function (){
                                document.querySelector(".messanger_users .message_user_active").click();
                            });
                    } else{
                        throw "У данного сообщения нету id!";
                    }
                } catch (e){
                    console.error(e);
                }
            }
        });
    });
    //delete_attach
    if (get_cross_icon.length >= 1){
        get_cross_icon[0].addEventListener("click", function (){
            const get_agree = confirm("Вы уверины что хотите открепить сообщение?");
            const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
            if (get_agree){
                $.ajax({
                    method: "POST",
                    url: "../bd_send/user/message_system.php?chat_id=" + get_chat_id,
                    data: { attach_command: "delete_message" }
                })
                    .done(function (){
                        document.querySelector(".messanger_users .message_user_active").click();
                    });
            }
        });
        //attach_length
        const attachMessageElement = document.querySelector(".user_chat .attach_line p.attach_message");
        let messageContent = attachMessageElement.textContent.trim();
        if (messageContent.length >= 50) {
            messageContent = messageContent.substring(0, 50) + "...";
        }
        attachMessageElement.textContent = messageContent;
    }
}
export function mute_chat(){
    let remove_icon = true;
    const get_mute = document.querySelector(".mute");
    const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
    get_mute.addEventListener("click", function (){
        $.ajax({
            url: "../bd_send/user/message_users.php?mute_chat=" + get_chat_id,
        })
            .done(function (){
                const get_message_user = document.querySelector(".messanger_users .message_user_active");
                const bell_parent = get_mute.querySelector("svg").parentNode;
                const text_element = get_mute.querySelector("p");
                if (!get_mute.className.includes("muted")){
                    text_element.innerHTML = "Включить";
                    get_mute.classList.add("muted");
                    bell_parent.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/></svg>';
                    const create_wrapper = document.createElement("div");
                    create_wrapper.classList = "chat_icon";
                    create_wrapper.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7l-90.2-70.7c.2-.4 .4-.9 .6-1.3c5.2-11.5 3.1-25-5.3-34.4l-7.4-8.3C497.3 319.2 480 273.9 480 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V51.2c-42.6 8.6-79 34.2-102 69.3L38.8 5.1zM406.2 416L160 222.1v4.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S115.4 416 128 416H406.2zm-40.9 77.3c12-12 18.7-28.3 18.7-45.3H320 256c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/></svg>';
                    if (get_message_user.querySelectorAll(".chat_icon").length === 0){
                        get_message_user.appendChild(create_wrapper);
                    } else{
                        remove_icon = false;
                    }
                } else{
                    text_element.innerHTML = "Отключить";
                    bell_parent.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L542.6 400c2.7-7.8 1.3-16.5-3.9-23l-14.9-18.6C495.5 322.9 480 278.8 480 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V51.2c-42.6 8.6-79 34.2-102 69.3L38.8 5.1zM224 150.3C243.6 117.7 279.3 96 320 96c61.9 0 112 50.1 112 112v25.4c0 32.7 6.4 64.8 18.7 94.5L224 150.3zM406.2 416l-60.9-48H168.3c21.2-32.8 34.4-70.3 38.4-109.1L160 222.1v11.4c0 45.4-15.5 89.5-43.8 124.9L101.3 377c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6H406.2zM384 448H320 256c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/></svg>';
                    get_mute.classList.remove("muted");
                    if (remove_icon === true){
                        get_message_user.querySelector(".chat_icon").remove();
                    }
                }
            });
    });
}
export function block_user(){
    let do_text = null;
    const get_option = document.querySelector(".user_block");
    try{
        const block_status = document.querySelector(".user_block p").classList[0];
        if (block_status === "block"){
            do_text = "разблокировать";
        } else if (block_status === "unblock"){
            do_text = "заблокировать";
        }
    } catch (e){
        return;
    }
    const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
    if (get_option !== null){
        get_option.addEventListener("click", function (){
            const get_agree = confirm("Вы уверины, что хотите " + do_text + " данный чат?");
            if (get_agree){
                $.ajax({
                    url: "../bd_send/user/message_system.php?user_block=" + get_chat_id,
                })
                    .done(function (){
                        document.querySelector(".messanger_users .message_user_active").click();
                    });
            }
        });
    }
}
export function complaint_chat(){
    const get_option = document.querySelector(".chat_complaint");
    const get_close_icon = document.querySelector(".report_container .cross_icon");
    const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
    get_option.addEventListener("click", function (){
        const get_modal = document.querySelector(".report_container");
        get_modal.style.display = "block";
        setTimeout( () => {
            get_modal.style.opacity = 1;
        }, 100);
    });
    get_close_icon.addEventListener("click", function (){
        const get_modal = document.querySelector(".report_container");
        get_modal.style.opacity = 0;
        setTimeout( () => {
            get_modal.style.display = "none";
        }, 500);
    });
    //menu_open
    const report_option_input = document.querySelector("input.report_option");
    report_option_input.addEventListener("click", function (){
        const get_sub_menu = document.querySelector(".make_report .option_choice .sub_input");
        get_sub_menu.classList.toggle("sub_input_animation");
    });
    //sub_option_choice
    const get_sub_options = document.querySelectorAll(".make_report .option_choice .sub_input p");
    get_sub_options.forEach( (item) => {
        item.addEventListener("click", function (){
            const item_value = item.innerHTML;
            report_option_input.value = item_value;
        });
    });
    get_sub_options[0].click();
    //server_send
    let send_temp = 0; // Добавленная переменная для отслеживания количества нажатий
    let send_agree = false; // Переменная, которую вы уже используете

    document.querySelector(".make_report button").addEventListener("click", function () {
        const get_textarea = document.querySelector(".make_report textarea");
        const get_warning = document.querySelector(".make_report u.warning");
        
        if (get_textarea.value === "") {
            get_warning.innerHTML = "Напишите причину жалобы";
            send_agree = false;
        } else {
            get_warning.innerHTML = "";
            send_agree = true;
        }
        
        // main_ajax
        if (send_agree === true && send_temp === 0) {
            send_temp++;
            
            const report_option_value = $('.report_option').val();
            const report_description_value = $('.report_description').val();

            if (send_temp === 1){
                $.ajax({
                    method: "POST",
                    url: "../bd_send/report_send.php?chat_id=" + get_chat_id,
                    data: { report_option: report_option_value, report_description: report_description_value },
                }).done(function () {
                    document.querySelectorAll(".make_report .option_choice .sub_input p")[0].click();
                    document.querySelector(".make_report textarea").value = "";
                    
                    const modal = document.querySelector(".report_container");
                    modal.style.opacity = 0;
                    
                    setTimeout(() => {
                        modal.style.display = "none";
                        const information_know = alert("Жалоба успешно отправлена! Вскоре мы вам дадим обратную связь на почту.");
                        
                        if (information_know) {
                            send_temp = 0;
                        }
                    }, 500);
                });
            }
        } else{
            alert("За переписку жалоба уже была успешно отправленна, ожидайте.");
        }
    });
}
export function delete_chat(){
    const get_option = document.querySelector(".delete_chat");
    const get_chat_id = parseInt(document.querySelector(".chat_number").innerHTML.trim(), 10);
    get_option.addEventListener("click", function (){
        const get_agree = confirm("Вы уверины, что хотите удалить данный чат?");
        if (get_agree){
            $.ajax({
                url: "../bd_send/user/message_system.php?chat_delete=" + get_chat_id,
            })
                .done(function (){
                    document.querySelector(".messanger_users .message_user_active").remove();
                    if (document.querySelectorAll(".attached_user").length === 0){
                        
                        try{
                            document.querySelectorAll(".messanger_users .information_line")[0].remove();
                            throw document.querySelectorAll(".messanger_users .information_line").length;
                        } catch (item_length){
                            if (item_length === 0){
                                document.querySelector(".messanger_users").innerHTML = "<div class='no_companions'><p>Нет собеседников</p></div>";
                            }
                        }
                    }
                });
        }
    });
}
//chat_media
function chat_media(){
    let back_link_temp = 0;
    const screen_width = window.innerWidth;
    if (screen_width <= 594){
        const get_content = document.querySelector(".content");
        const get_options_wrapper = document.querySelector(".messanger_users");
        const get_users = get_options_wrapper.querySelectorAll(".message_user");
        const get_user_chat = document.querySelector(".user_chat");
        get_users.forEach( (item) => {
            item.addEventListener("click", function (){
                get_options_wrapper.style.opacity = 0;
                setTimeout( () => {
                    get_options_wrapper.classList.add("messanger_users_hide");
                    get_user_chat.classList.add("user_chat_active");
                    setTimeout( () => {
                        get_user_chat.style.opacity = 1;
                    }, 100);
                }, 300);
                back_link();
            });
        });
        function back_link(){
            back_link_temp++;
            const create_wrapper = document.createElement("div");
            const html_arr = ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>', '<a>Назад</a>'];
            create_wrapper.classList = "back_link";
            if (back_link_temp >= 2){
                return;
            }
            get_user_chat.insertBefore(create_wrapper, get_content);
            for (let i = 0; i < 2; i++){
                const create_part = document.createElement("div");
                create_wrapper.appendChild(create_part);
                create_part.innerHTML = html_arr[i];
                
            }
            //click_logic
            create_wrapper.addEventListener("click", function (){
                get_user_chat.style.opacity = 0;
                setTimeout( () => {
                    get_options_wrapper.classList.remove("messanger_users_hide");
                    get_user_chat.classList.remove("user_chat_active");
                    setTimeout( () => {
                        get_options_wrapper.style.opacity = 1;
                        get_users.forEach( (item) => {
                            item.classList.remove("message_user_active");
                        });
                    }, 100);
                }, 300);
            });
        }
    }
}
chat_media();