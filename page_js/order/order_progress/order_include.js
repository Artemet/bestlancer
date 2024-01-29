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
            } else if (button_id === 3){
                action = "отправить на доработку";
            } else{
                alert("Ошибка! Перезагрузите страницу.");
                return;
            }
    
            const ask = confirm("Вы уверины, что хотите " + action + " работу?");
            if (ask){
                $.ajax({
                    method: "POST",
                    url: "../bd_send/order/order_action.php?action_order_id=" + get_order_id,
                    data: { action_id: button_id },
                })
                    .done(function (response){
                        console.log(response);
                    });
            }
        });
    });
}
button_solution();