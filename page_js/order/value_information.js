import { clearLocalStorage } from "./order_values/value_save.js";
//value_check
function value_order_check(){
    const get_inputs = document.querySelectorAll(".make_order_container .check_value");
    //warning_give
    function check_position(){
        const get_inputs = document.querySelectorAll(".make_order_container .warning_checkable");
        const get_button = document.querySelector(".make_order_container button");
        get_inputs.forEach( (item) => {
            if (item.value.length !== 0){
                item.classList.add("can_check");
                get_button.classList.remove("none_active");
            } else{
                item.classList.remove("can_check");
                get_button.classList.add("none_active");
            }
        });
        const get_checkable_inputs = document.querySelectorAll(".make_order_container .can_check");
        if (get_inputs.length === get_checkable_inputs.length){
            document.querySelector(".make_order_container button").classList.remove("none_active");
        } else{
            document.querySelector(".make_order_container button").classList.add("none_active");
        }
    }
    window.addEventListener("load", function (){
        check_position();
    });
    get_inputs.forEach( (item) => {
        item.addEventListener("input", function (){
            check_position();
        });
    });
    document.querySelector(".button_wrapper").addEventListener("click", function (){
        warning_give();
    });
    function warning_give(){
        const get_inputs = document.querySelectorAll(".make_order_container .check_value");
        const get_warnings = document.querySelectorAll(".make_order_container u.warning");
        get_inputs.forEach( (item) => {
            //global_check
            const get_warning = item.closest(".form_part").querySelector("u.warning");
            if (item.name === "order_information" && item.value.length <= 49){
                get_warning.innerHTML = "Минимальная длина описания: 50";
            } else if (item.name === "order_price" && item.value.length === 0 && item.closest(".checkbox_sub").className.includes("checkbox_sub_open")){
                get_warning.innerHTML = "Предложите цену";
            } else if (item.name === "order_price" && parseInt(item.value, 10) <= 299 && item.closest(".checkbox_sub").className.includes("checkbox_sub_open")){
                get_warning.innerHTML = "Минимальная цена: 300₽";
            } else if (item.name === "main_order_category" && item.value.length === 0){
                get_warning.innerHTML = "Выбирите оснавную категорию";
            } else if (item.name === "medium_order_category" && item.value.length === 0){
                get_warning.innerHTML = "Выбирите среднию категорию";
            } else if (item.name === "final_order_category" && item.value.length === 0){
                get_warning.innerHTML = "Выбирите финальную категорию";
            } else{
                get_warning.innerHTML = "";
            }
        });
        //warning_check
        function warning_find(){
            let find_temp = -1;
            while (find_temp !== get_warnings.length - 1){
                find_temp++;
                if (get_warnings[find_temp].innerHTML.length !== 0){
                    return true;
                }
            }
            return false;
        }
        if (warning_find() === false){
            const formData = new FormData();
            const file_input = document.querySelector("input.file_choice");
            //order_appends
            formData.append('file_send', file_input.files[0]);
            formData.append('order_name', get_inputs[0].value.trim());
            formData.append('order_information', get_inputs[1].value.trim());
            formData.append('order_price', get_inputs[2].value.trim());
            formData.append('order_type', get_inputs[3].value.trim());
            formData.append('main_order_category', get_inputs[4].value.trim());
            formData.append('medium_order_category', get_inputs[5].value.trim());
            formData.append('final_order_category', get_inputs[6].value.trim())


            $.ajax({
                method: "POST",
                url: "../bd_send/order/send_order.php",
                contentType: false,
                processData: false,
                data: formData,
            })
                .done(function (response){
                    if (response.includes("Warning:")){
                        const agree = confirm(response);
                        if (agree){
                            window.location.reload();
                        }
                    } else{
                        clearLocalStorage();
                        window.location.href = "../pages/my_orders.php";
                    }
                });
        }
    }
}
value_order_check();