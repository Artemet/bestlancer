//change_response
function change_response(){
    const get_response_id = document.querySelectorAll("span.response_id");
    const get_change_button = document.querySelectorAll(".my_responses .change_order_button button");
    const get_response_sub = document.querySelectorAll(".my_responses .response_sub");
    const get_order_information = document.querySelectorAll(".my_responses .response_sub");
    for (let i = 0; i < get_response_sub.length; i++){
        get_change_button[i].classList = i;
    }
    let click_temp = 0;
    let button_number = null;
    get_change_button.forEach( (item) => {
        const icon_svg = item.innerHTML;
        item.addEventListener("click", function (){
            click_temp++;
            button_number = item.classList[0];
            let response_id = get_response_id[button_number].innerHTML;
            const get_comment = get_order_information[button_number].querySelector("p.comment");
            const get_price = get_order_information[button_number].querySelector("span");
            const get_time = get_order_information[button_number].querySelector("p.main_information");
            const get_comment_blocks = get_order_information[button_number].querySelectorAll(".my_responses .response_sub div");
            if (click_temp === 1){
                item.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>`;
                get_change_button.forEach( (item) => {
                    if (item.innerHTML === icon_svg){
                        item.classList.add("none_click");
                    }
                });
                get_comment.style.display = "none";
                get_comment_blocks[1].classList.add("display");
                const create_form = document.createElement("form");
                create_form.action = "../bd_send/order/change_order.php?application_id=" + response_id;
                create_form.method = "post";
                const create_button = document.createElement("button");
                create_button.classList = "change_information"
                create_button.innerHTML = "Сохранить";
                get_comment_blocks[0].appendChild(create_form);
                const input_types = ["text", "number", "number"];
                const input_placeholders = ["Введите ваше сообщение", "Введите вашу цену в долларах", "Введите сроки в сутках"];
                const input_names = ["message", "price", "time"];
                const input_icons = [`<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M160 0c17.7 0 32 14.3 32 32V67.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V445.1c-.4-.1-.9-.1-1.3-.2l-.2 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11V32c0-17.7 14.3-32 32-32z"/></svg>`, `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>`];
                const input_values = [get_comment.innerHTML, get_price.innerHTML.replace(/\D/g, ''), get_time.innerHTML.replace(/\D/g, '')];
                for (let i = 0; i < input_types.length; i++){
                    const create_input_wrapper = document.createElement("div");
                    create_input_wrapper.classList = "input_wrapper";
                    const create_input = document.createElement("input");
                    create_input.type = input_types[i];
                    create_input.placeholder = input_placeholders[i];
                    create_input.name = input_names[i];
                    create_input.value = input_values[i];
                    create_input.classList = "right_in";
                    create_form.appendChild(create_input_wrapper);
                    create_input_wrapper.appendChild(create_input);
                    if (i >= 1){
                        const create_icon = document.createElement("div");
                        create_icon.classList = "icon";
                        create_icon.id = "icon_" + i;
                        if (i === 1){
                            create_icon.innerHTML = input_icons[0];
                        } else if (i === 2){
                            create_icon.innerHTML = input_icons[1];
                        }
                        create_input_wrapper.appendChild(create_icon);
                    }
                }
                create_form.appendChild(create_button);
                const get_message_input = get_order_information[button_number].querySelectorAll(".my_responses .response_sub input")[0];
                if (get_message_input.value === "Нет сообщения"){
                    get_message_input.value = "";
                }
            } else if (click_temp === 2){
                item.innerHTML = icon_svg;
                get_change_button.forEach( (item) => {
                    item.classList.remove("none_click");
                });
                const get_form = document.querySelectorAll(".my_responses .response_sub form");
                const get_main_information_block = document.querySelector(".my_responses .response_sub .display");
                get_form.forEach( (item) => {
                    item.remove();
                });
                get_main_information_block.classList.remove("display");
                get_comment.style.display = "block";
                click_temp = 0;
            }
        });
    });
}
change_response();