//notification_length
function notification_length(){
    const get_notification_container = document.querySelector(".notification_container .notifications");
    if (!get_notification_container.innerHTML.includes("div")){
        const create_warning = document.createElement("p");
        create_warning.innerHTML = "Нет увидомлений";
        create_warning.classList = "notification_warning";
        get_notification_container.appendChild(create_warning);
    }
}
notification_length();
//remove_notification
function remove_notification(){
    let refusal_temp = 0;
    let final_url = null;
    document.querySelectorAll("button.start_order").forEach( (item) => {
        item.addEventListener("click", function (){
            const get_parent_notification = item.closest(".notification");
            const get_execution_id = get_parent_notification.querySelector("noscript.execution_id").innerHTML.trim();
            const ask = confirm("Вы уверины, что хотите приступить к выполнению (отказ будет невозможен)?");
            if (ask){
                $.ajax({
                    url: "../bd_send/order/order_action.php?order_id=" + get_execution_id,
                })
                    .done(function (response){
                        console.log(response);
                        const get_overlay = get_parent_notification.querySelector(".overlay");
                        const get_wrapper = get_parent_notification.querySelector(".notification_wrapper");
                        get_overlay.classList.add("overlay_active");
                        get_wrapper.classList.add("notification_loader");
                        setTimeout( () => {
                            window.location.href = "../pages/order_progress.php?order_id=" + get_execution_id;
                        }, 700);
                    });
            }
        });
    });
    document.querySelectorAll("button.remove_order").forEach( (item) => {
        item.addEventListener("click", function () {
            refusal_temp++;
            const get_parent_notification = item.closest(".notification");
            const notification_id = parseInt(get_parent_notification.id, 10);
            if (get_parent_notification.className.includes("execution")){
                const get_execution_id = get_parent_notification.querySelector("noscript.execution_id").innerHTML.trim();
                const ask = confirm("Вы уверины, что хотите отказаться от заказа?");
                final_url = "../bd_send/order/remove_order.php?order_id=" + get_execution_id;
                if (!ask){
                    return;
                }
            } else{
                const get_item_id = item.closest(".notification").id;
                final_url = "../bd_send/order/remove_order.php?personal_order_id=" + get_item_id;
            }
            $.ajax({
                method: "POST",
                url: final_url,
                data: { notification_id: notification_id },
            })
                .done(function (response) {
                    get_parent_notification.remove();
                    console.log(response);
                    if (refusal_temp === 1) {
                        setTimeout(() => {
                            alert("Вы успешно отказались от заказа!");
                        }, 500);
                    }
                });
        });
    });
}
remove_notification();