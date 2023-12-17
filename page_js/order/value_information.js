//value_check
function value_order_check(){
    let warning_include = false;
    const get_inputs = document.querySelectorAll(".make_order_container .check_value");
    const get_button_wrapper = document.querySelector(".make_order_container .button_wrapper");
    const get_button = document.querySelector(".make_order_container button");

    //warning_give
    const get_warnings = document.querySelectorAll("u.warning");
    function check_position(){
        const get_inputs = document.querySelectorAll(".make_order_container .warning_checkable");
        get_inputs.forEach( (item) => {
            if (item.value.length >= 5){
                item.classList.add("can_check");
            } else{
                item.classList.remove("can_check");
            }
        });
        const get_checkable_inputs = document.querySelectorAll(".make_order_container .can_check");
        if (get_inputs.length === get_checkable_inputs.length){
            document.querySelector(".make_order_container button").classList.remove("none_active");
        } else{
            document.querySelector(".make_order_container button").classList.add("none_active");
        }
    }
    check_position();
    get_inputs.forEach( (item) => {
        item.addEventListener("input", function (){
            check_position();
        });
    });
    document.querySelector(".button_wrapper").addEventListener("click", function (){
        warning_give();
    });
    function warning_give(){
        //price_check
        const get_price_value = document.querySelector(".make_order_container .money_right");
        const get_price_checkbox = document.querySelectorAll(".make_order_container .checkbox_block input");
        const price_convert = parseInt(get_price_value.value, 10);

        if (get_price_checkbox[1].checked === true){
            if (get_price_value.value.trim() === "") {
                get_price_value.closest(".checkbox_sub").querySelector("u.warning").innerHTML = "Введите сумму";
                warning_include = true;
                document.querySelector(".make_order_container button").classList.add("none_active");
            } else if (isNaN(price_convert) || price_convert <= 399) {
                get_price_value.closest(".checkbox_sub").querySelector("u.warning").innerHTML = "Минимальная цена 400 ₽";
                warning_include = true;
                document.querySelector(".make_order_container button").classList.add("none_active");
            } else if (price_convert >= 1000001) {
                get_price_value.closest(".checkbox_sub").querySelector("u.warning").innerHTML = "Максимальная цена 1 000 000 ₽";
                warning_include = true;
                document.querySelector(".make_order_container button").classList.add("none_active");
            } else {
                get_price_value.closest(".checkbox_sub").querySelector("u.warning").innerHTML = "";
                warning_include = false;
                document.querySelector(".make_order_container button").classList.remove("none_active");
            }
        } else{
            warning_include = false;
            document.querySelector(".make_order_container button").classList.remove("none_active");
        }

        //category_check
        const get_category_value = document.querySelectorAll(".make_order_container .category_part input");
        get_category_value.forEach( (item) => {
            const get_closest_warning = item.closest(".form_part").querySelector("u.warning");
            if (item.value === ""){
                get_closest_warning.innerHTML = "Выбирите категорию";
                warning_include = true;
                document.querySelector(".make_order_container button").classList.add("none_active");
            } else{
                warning_include = false;
                document.querySelector(".make_order_container button").classList.remove("none_active");
            }
        });

        //description_check
        const get_description_value = document.querySelector(".make_order_container textarea");
        //name_check
        const get_name_value = document.querySelector(".make_order_container input.order_name");
        if (get_description_value.value === ""){
            get_description_value.parentNode.querySelector("u.warning").innerHTML = "Введите описание";
            warning_include = true;
            document.querySelector(".make_order_container button").classList.add("none_active");
        } else if (get_description_value.value.length <= 50){
            get_description_value.parentNode.querySelector("u.warning").innerHTML = "Слишком короткое описание задачи";
            warning_include = true;
            document.querySelector(".make_order_container button").classList.add("none_active");
        } else if (get_description_value.value.length >= 1200){
            get_description_value.parentNode.querySelector("u.warning").innerHTML = "Слишком длинное описание задачи";
            warning_include = true;
            document.querySelector(".make_order_container button").classList.add("none_active");
        } else if (get_name_value.value === ""){
            get_name_value.parentNode.querySelector("u.warning").innerHTML = "Введите название заказа";
            warning_include = true;
        } else if (get_name_value.value.length <= 5){
            get_name_value.parentNode.querySelector("u.warning").innerHTML = "Слишком короткое название";
            warning_include = true;
        } else{
            warning_include = false;
            document.querySelector(".make_order_container button").classList.remove("none_active");
        }

        // //name_check
        // const get_name_value = document.querySelector(".make_order_container input.order_name");
        // if (get_name_value.value === ""){
        //     get_name_value.parentNode.querySelector("u.warning").innerHTML = "Введите название заказа";
        //     warning_include = true;
        // } else if (get_name_value.value.length <= 5){
        //     get_name_value.parentNode.querySelector("u.warning").innerHTML = "Слишком короткое название";
        //     warning_include = true;
        // }

    }
}
value_order_check();
function order_value_warning(){
    alert("Введите все поля чтоб разместить заказ на бирже!");
}