//value_check
function value_check(){
    const get_values = document.querySelectorAll(".main_registration .right_in");
    const get_resolt_input = document.querySelectorAll(".resolt_input input");
    const get_post_button = document.querySelector(".main_registration .post_button");
    const get_registor_number = document.querySelector(".registor_container p.registor_part_number").innerHTML;
    const registor_number = parseInt(get_registor_number, 10);
    for (let i = 0; i < get_values.length; i++){
        get_values[i].id = i;
    }
    function registor_part_one(){
        let warnings = false;
        const warning_text_one = ["Введите Имя", "Введите Фамилию", "Введите Email", "Введите пароль", "Выбирите страну"];
        const warning_text_two = ["Выбирите возраст", "Выбирите часы работы", "Расскажите о себе", "Впишите начальную ставку"];
        const warning_lenght = ["Слишком короткий. Используйте не менее 6 символов", "Слишком короткий. Используйте не менее 8 символов"];
        const get_values = document.querySelectorAll(".main_registration .right_in");
        let value_id = null;
        get_values.forEach((item) => {
            item.addEventListener("click", function (){
                value_id = this.id;
            });
            item.addEventListener("input", value_print_check);
        });
        function warning(){
            const get_all_warnings = document.querySelectorAll(".main_registration u.warning");
            get_values.forEach( (item) => {
                let element_find = null;
                if (registor_number === 2){
                    element_find = item.closest("div").querySelector("u.warning");
                } else if (registor_number === 3){
                    element_find = item.closest(".input_part").querySelector("u.warning");
                }
                const get_warning = element_find;
                if (item.value.length <= 0){
                    if (registor_number === 2){
                        get_warning.innerHTML = warning_text_one[item.id];
                    } else if (registor_number === 3){
                        get_warning.innerHTML = warning_text_two[item.id];
                    }
                    warnings = true;
                } else{
                    get_warning.innerHTML = "";
                    if (registor_number === 2){
                        if (item.id === '2' && item.value.length <= 5){
                            item.closest("div").querySelector("u.warning").innerHTML = warning_lenght[0];
                        } else if (item.id === '3' && item.value.length <= 7){
                            item.closest("div").querySelector("u.warning").innerHTML = warning_lenght[1];
                        }
                    }
                }
            });
            let final_warning_number = [];
            const warnings_length = get_all_warnings.length;
            for (let i = 0; i < warnings_length; i++){
                if (get_all_warnings[i].innerHTML.length === 0){
                    final_warning_number.push(get_all_warnings[i]);
                    if (final_warning_number.length === warnings_length){
                        get_post_button.querySelector("button").classList.add("active_click");
                    } else{
                        get_post_button.querySelector("button").classList.remove("active_click");
                    }
                }
            }
        }
        function value_print_check() {
            warning();
            get_values.forEach( (item) => {
                if (item.id === value_id){
                    console.log(item);
                }
            });
        }
        get_post_button.addEventListener("click", function (){
            warning();
        });
    }
    registor_part_one();
    //input_Storage
    if (registor_number === 2){
        const get_page_one_values = document.querySelectorAll(".thirst_part .right_in");
        if (localStorage.getItem("name")) {
            get_page_one_values[0].value = localStorage.getItem("name");
        }
        if (localStorage.getItem("surname")) {
            get_page_one_values[1].value = localStorage.getItem("surname");
        }
        if (localStorage.getItem("email")) {
            get_page_one_values[2].value = localStorage.getItem("email");
        }
        get_page_one_values[0].addEventListener("input", function () {
            localStorage.setItem("name", get_page_one_values[0].value);
        });
        get_page_one_values[1].addEventListener("input", function () {
            localStorage.setItem("surname", get_page_one_values[1].value);
        });
        get_page_one_values[2].addEventListener("input", function () {
            localStorage.setItem("email", get_page_one_values[2].value);
        });
    } else if (registor_number === 3){
        const get_page_two_values = document.querySelectorAll(".second_part .right_in");
        if (localStorage.getItem("age")) {
            get_page_two_values[0].value = localStorage.getItem("age");
        }
        if (localStorage.getItem("time")) {
            get_page_two_values[1].value = localStorage.getItem("time");
        }
        if (localStorage.getItem("about_user")) {
            get_page_two_values[2].value = localStorage.getItem("about_user");
        }
        if (localStorage.getItem("price")) {
            get_page_two_values[3].value = localStorage.getItem("price");
        }
        get_page_two_values[0].addEventListener("input", function () {
            localStorage.setItem("age", get_page_two_values[0].value);
        });
        get_page_two_values[1].addEventListener("input", function () {
            localStorage.setItem("time", get_page_two_values[1].value);
        });
        get_page_two_values[2].addEventListener("input", function () {
            localStorage.setItem("about_user", get_page_two_values[2].value);
        });
        get_page_two_values[3].addEventListener("input", function () {
            localStorage.setItem("price", get_page_two_values[3].value);
        });
    }
}
value_check();