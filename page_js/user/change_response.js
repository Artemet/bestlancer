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
                get_comment_blocks[1].style.display = "none";
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
                const input_values = [get_comment.innerHTML, get_price.innerHTML.replace(/\D/g, ''), get_time.innerHTML.replace(/\D/g, '')];
                for (let i = 0; i < input_types.length; i++){
                    const create_input = document.createElement("input");
                    create_input.type = input_types[i];
                    create_input.placeholder = input_placeholders[i];
                    create_input.name = input_names[i];
                    create_input.value = input_values[i];
                    create_input.classList = "right_in";
                    create_form.appendChild(create_input);
                }
                create_form.appendChild(create_button);
                const get_message_input = get_order_information[button_number].querySelectorAll(".my_responses .response_sub input")[0];
                if (get_message_input.value === "Нет сообщения"){
                    get_message_input.value = "";
                }
            } else{
                item.innerHTML = icon_svg;
                get_change_button.forEach( (item) => {
                    item.classList.remove("none_click");
                });
                const get_form = document.querySelectorAll(".my_responses .response_sub form");
                get_form.forEach( (item) => {
                    item.remove();
                });
                get_comment.style.display = "block";
                get_comment_blocks[1].style.display = "block";
                click_temp = 0;
            }
        });
    });
}
change_response();