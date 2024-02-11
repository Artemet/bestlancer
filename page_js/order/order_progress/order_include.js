//order_include
function order_include(){
    const get_arrow = document.querySelectorAll(".order_progress .arrow button");
    get_arrow.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_object = item.closest(".object");
            item.querySelector("svg").classList.toggle("active");
            get_object.querySelector(".object_sub").classList.toggle("object_sub_active");
        });
    });
}
order_include();
//button_solution
function button_solution(){
    let order_pause = false;
    const get_button = document.querySelectorAll(".order_progress .button_option button");
    const get_order_id = document.querySelector("noscript.order_id").innerHTML.trim();
    get_button.forEach( (item) => {
        item.addEventListener("click", function () {
            let action = null;
            const button_id = parseInt(this.id, 10);
            if (button_id === 0){
                action = "сдать";
            } else if (button_id === 1){
                action = "запросить";
            } else if (button_id === 2){
                order_pause = true;
            } else if (button_id === 3){
                action = "отправить на доработку";
            } else if (button_id === 4){
                order_pause = true;
            } else if (button_id === 5){
                user_pay();
                order_pause = true;
            } else if (button_id === 6){
                action = "Вы действительно подтверждаете пришедшую сумму на ваш кошелёк и готовы работать дальше с заказчиком?";
            } else if (button_id === 7){
                action = "Вы выполнили этап работы, и заказчик сказал, что оплатил вам работу. Вы уверины, что средства не пришли на ваши реквезиты?";
            } else{
                alert("Ошибка! Перезагрузите страницу.");
                return;
            }

            let ask = null;
            if (!order_pause){
                if (button_id !== 6 && button_id !== 7){
                    ask = confirm("Вы уверины, что хотите " + action + " работу?");
                } else{
                    ask = confirm(action);
                }
            }
            if (ask || order_pause === true){
                //done_pause
                const done_order = () => {
                    const get_modal = document.querySelector(".finish_order_container");
                    get_modal.classList.add("finish_order_container_active");
                    setTimeout( () => {
                        modal_logic();
                        get_modal.style.opacity = 1;
                    }, 100);

                    const modal_logic = () => {
                        const get_button = document.querySelector(".finish_order_container button");
                        
                        //checkbox_click
                        let checkbox_temp = 0;
                        const get_checkbox_line = document.querySelector(".finish_order_container .checkbox_agree");
                        get_checkbox_line.addEventListener("click", function (){
                            checkbox_temp++;
                            const get_checkbox = this.querySelector("input");
                            get_button.classList.toggle("ready");
                            if (checkbox_temp === 1){
                                get_checkbox.checked = true;
                            } else{
                                get_checkbox.checked = false;
                                checkbox_temp = 0;
                            }
                        });
                        //modal_close
                        const get_cross = document.querySelector(".finish_order_container .close");
                        get_cross.addEventListener("click", function (){
                            get_modal.style.opacity = 0;
                            setTimeout( () => {
                                get_modal.classList.remove("finish_order_container_active");
                                get_modal.removeAttribute("style");
                            }, 500);
                        });
                        //button_post
                        get_button.addEventListener("click", function (){
                            const get_message = document.querySelector(".finish_order_container textarea").value.trim();
                            $.ajax({
                                method: "POST",
                                url: "../bd_send/order/order_action.php?action_order_id=" + get_order_id,
                                data: {action_id: 2, message_value: get_message},
                            })
                                .done(function (response){
                                    console.log(response);
                                    get_button.classList.remove("ready");
                                    get_modal.querySelectorAll(".overlay")[0].classList.add("overlay_active");
                                    get_modal.querySelector(".finish_wrapper").classList.add("finish_wrapper_load");
                                    setTimeout( () => {
                                        window.location.reload();
                                    }, 800);
                                });
                        });
                    }
                    order_pause = false;
                }
                //payment_pause
                const payment_ask = () => {
                    const get_modal = document.querySelector(".payment_ask_container");
                    //modal_open
                    get_modal.classList.add("payment_ask_container_active");
                    setTimeout( () => {
                        get_modal.style.opacity = 1;
                    }, 100);
                    //modal_close
                    const get_cross = document.querySelector(".payment_ask_container .close");
                    get_cross.addEventListener("click", function (){
                        get_modal.removeAttribute("style");
                        setTimeout( () => {
                            get_modal.classList.remove("payment_ask_container_active");
                        }, 500);
                    });

                    //value_check
                    const get_button = document.querySelector(".payment_ask_container button");
                    const get_input = document.querySelector(".payment_ask_container input.right_in");
                    get_input.addEventListener("input", function (){
                        if (get_input.value.length >= 1){
                            get_button.classList.add("ready");
                        } else{
                            get_button.classList.remove("ready");
                        }
                    });

                    //sum_post
                    get_button.addEventListener("click", function (){
                        const get_warning = document.querySelector(".payment_ask_container u.warning");
                        const money_value = get_input.value;
                        $.ajax({
                            method: "POST",
                            url: "../bd_send/order/order_action.php?action_order_id=" + get_order_id,
                            data: {action_id: 4, money_sum: money_value},
                        })
                            .done(function (response){
                                console.log(response);
                                const get_overlay = document.querySelector(".payment_ask_container .overlay");
                                const get_wrapper = document.querySelector(".payment_ask_container .payment_ask");
                                if (response === "limit"){
                                    get_warning.innerHTML = "Вы привысили лимит";
                                    return;
                                } else{
                                    get_warning.innerHTML = "";
                                }
                                get_overlay.classList.add("overlay_active");
                                get_wrapper.classList.add("payment_ask_load");
                                get_button.classList.remove("ready");
                                setTimeout( () => {
                                    window.location.reload();
                                }, 800);
                            });
                    });
                }

                if (order_pause){
                    if (button_id === 2){
                        done_order();
                    } else if (button_id === 4){
                        payment_ask();
                    }
                    return;
                }
                $.ajax({
                    method: "POST",
                    url: "../bd_send/order/order_action.php?action_order_id=" + get_order_id,
                    data: { action_id: button_id },
                })
                    .done(function (response){
                        console.log(response);
                        const get_header = document.querySelector(".order_progress .header");
                        const get_overlay = document.querySelector(".overlay");
                        get_header.classList.add("header_load");
                        get_overlay.classList.add("overlay_active");
                        setTimeout( () => {
                            if (button_id !== 1){
                                window.location.reload();
                            } else{
                                get_header.classList.remove("header_load");
                                get_overlay.classList.remove("overlay_active");
                                alert("Пользователь успешно получил ваше увидомление!");
                            }
                        }, 800);
                    });
            }
        });
    });
}
button_solution();
//review_write
function review_write(){
    const get_container = document.querySelector(".order_progress .review_write");
    const get_order_id = document.querySelector("noscript.order_id").innerHTML.trim();
    if (get_container !== null){
        let smile_arr = [];
        let class_list = null;
        let active_smile = null;
        const get_smiles = get_container.querySelectorAll("svg");
        for (let i = 0; i < get_smiles.length; i++){
            get_smiles[i].parentNode.id = i;
        }
        //smile_click
        const get_smile_wrappers = document.querySelectorAll(".review_write .smiles div");
        get_smiles.forEach( (item) => {
            const smile_parent = item.parentNode;
            smile_parent.addEventListener("click", function (){
                const smile_index = parseInt(this.id, 10);
                active_smile = smile_index;
                if (get_smile_wrappers.length == smile_arr.length){
                    smile_arr.splice(0, 1);
                }

                if (smile_index == 0){
                    item.classList.add("good_smile_active");
                    class_list = "bad_smile";
                } else{
                    item.classList.add("bad_smile_active");
                    class_list = "good_smile";
                }
                smile_arr.push(smile_index);
                if (smile_index !== smile_arr[0]){
                    get_smiles[smile_arr[0]].classList = class_list;
                }
            });
        });
        get_smile_wrappers[0].click();

        //textarea_value_send
        const get_textarea = document.querySelector(".review_write textarea");
        const get_value_button = document.querySelector(".review_write button");
        get_textarea.addEventListener("input", function (){
            const get_length_tag = document.querySelector(".review_write .length_controll span");
            const value_length = this.value.length;
            get_length_tag.innerHTML = value_length;
            if (value_length === 500){
                get_length_tag.closest("p").classList.add("max_length");
            } else if (value_length >= 1){
                get_value_button.classList.remove("none_ready");
            } else{
                get_length_tag.closest("p").classList.remove("max_length");
                get_value_button.classList.add("none_ready");
            }
        });
        //value_send
        get_value_button.addEventListener("click", function (){
            const get_textarea = document.querySelector(".review_write textarea");
            const get_warning = document.querySelector(".review_write u.warning");
            const get_loader = document.querySelector(".review_write .overlay");
            if (get_textarea.value.length <= 49){
                get_warning.innerHTML = "Минимальное количество символов: 50";
            } else{
                get_warning.innerHTML = "";
                const review_value = get_textarea.value.trim();
                $.ajax({
                    method: "POST",
                    url: "../bd_send/order/order_action.php?review_order_id=" + get_order_id,
                    data: { smile_index: active_smile, review: review_value },
                })
                    .done(function (response){
                        console.log(response);
                        get_loader.style.display = "flex";
                        document.querySelector(".order_progress .review_wrapper").classList.add("review_wrapper_load");
                        get_value_button.classList.add("none_ready");
                        setTimeout( () => {
                            get_loader.closest(".review_write").remove();
                            setTimeout( () => {
                                alert("Отзыв был успешно добавлен на страницу продавца!");
                            }, 100);
                        }, 800);
                    });
            }
        });
    }
}
review_write();
//user_pay
let pay_call_temp = 0;
function user_pay(){
    pay_call_temp++;
    const get_order_id = document.querySelector("noscript.order_id").innerHTML.trim();
    const get_sum = document.querySelector("noscript.sum_amount").innerHTML.trim();

    const get_modal = document.querySelector(".pay_container");
    const get_cross = get_modal.querySelector(".close");
    const get_requisitions = get_modal.querySelectorAll("p.requisition");
    const get_button = get_modal.querySelector("button");
    //modal_open
    get_modal.classList.add("pay_container_active");
    setTimeout( () => {
        get_modal.style.opacity = 1;
    }, 100);
    //modal_close
    get_cross.addEventListener("click", function (){
        get_modal.removeAttribute("style");
        setTimeout( () => {
            get_modal.classList.remove("pay_container_active");
        }, 500);
    });
    //requisition_copy
    if (pay_call_temp === 1){
        get_requisitions.forEach( (item) => {
            item.addEventListener("click", function (){
                const requisition = item.innerHTML.trim();
                navigator.clipboard.writeText(requisition).then(function (){
                    alert("Реквизит успешно скопирован.");
                });
            });
        });
    }
    //pay_agree
    get_button.addEventListener("click", function (){
        $.ajax({
            method: "POST",
            url: "../bd_send/order/order_action.php?action_order_id=" + get_order_id,
            data: {action_id: 5, money_sum: get_sum},
        })
            .done(function (response){
                console.log(response);
                get_button.classList.add("load");
                get_modal.querySelector(".overlay").classList.add("overlay_active");
                get_modal.querySelector(".pay_ask").classList.add("pay_ask_load");
                setTimeout( () => {
                    window.location.reload();
                }, 800);
            });
    });
}