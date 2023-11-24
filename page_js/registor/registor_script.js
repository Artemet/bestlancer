//registor_script
function registor_script(){
    let registor_warnings = false;
    let level_count = -1;
    const get_input_wrappers = document.querySelectorAll(".resolt_input div");
    for (let i = 0; i < get_input_wrappers.length; i++){
        get_input_wrappers[i].id = i;
    }
    const get_resolt_input = document.querySelectorAll(".resolt_input input");
    const get_continue_buttons = document.querySelectorAll(".registor_container button");
    for (let i = 0; i < get_continue_buttons.length; i++){
        get_continue_buttons[i].id = i;
    }
    //resolt_input
    if (localStorage.getItem("role")) {
        get_resolt_input[0].value = localStorage.getItem("role");
    }
    get_resolt_input[0].addEventListener("input", function () {
        localStorage.setItem("role", get_resolt_input[0].value);
    });

    get_resolt_input.forEach( (item) => {
        if (item.value.length >= 1){
            item.parentNode.classList = "active";
        }
    });
    while (true){
        level_count++;
        const active_level = document.querySelectorAll(".resolt_input .active")[level_count];
        if (active_level.className.includes("active")){
            const get_question = document.querySelectorAll(".question")[level_count];
            get_question.classList.add("question_active");
            setTimeout( () => {
                get_question.style.opacity = 1;
            }, 100);
            break;
        }
    }
    const get_header_part = document.querySelector(".header_line .header_part_two");
    get_header_part.remove();

    //starter_choice_animation
    window.addEventListener("load", function (){
        let option_timer = 0;
        let option_choice = false;
        const get_options = document.querySelectorAll(".registor_container .role_option");
        const get_button = document.querySelector(".registor_container .button button");
        for (let i = 0; i < 2; i++){
            option_timer += 500;
            get_options[i].style.pointerEvents = "none";
            setTimeout( () => {
                if (option_timer === 1000){
                    get_button.classList.add("animation");
                    setTimeout( () => {
                        get_options[i].style.pointerEvents = "all";
                    }, 500);
                }
                get_options[i].classList.add("role_option_animation");
            }, option_timer);
        }
        //option_click
        get_options.forEach( (item) => {
            item.addEventListener("click", function (){
                option_choice = true;
                const item_id = parseInt(item.id, 10);
                if (item_id === 0){
                    get_resolt_input[0].value = "buyer";
                } else if (item_id === 1){
                    get_resolt_input[0].value = "seller";
                }
                get_options.forEach( (item) => {
                    if (item.className.includes("role_option_click")){
                        const get_circle = item.querySelector(".in_circle");
                        get_circle.classList.remove("in_circle_animation");
                        item.classList.remove("role_option_click");
                    }
                });
                const get_circle = item.querySelector(".in_circle");
                get_circle.classList.add("in_circle_animation");
                item.classList.add("role_option_click");
                if (option_choice === true){
                    get_button.classList.remove("none_click");
                    get_button.style.opacity = 1;
                }
            });
        });
    });
    //main_registor_question
    let checkbox_click = false;
    function main_registor(){
        const get_checkbox_block = document.querySelectorAll(".registor_container .main_registor_question .checkbox_choice");
        get_checkbox_block.forEach( (item) => {
            const get_p = item.querySelector("p");
            const get_checkbox = item.querySelector("input");
            get_p.addEventListener("click", function (){
                get_p.classList.toggle("active");
                if (get_p.className.includes("active")){
                    checkbox_click = true;
                } else{
                    checkbox_click = false;
                }
                get_checkbox.click();
            });
        });
    }
    main_registor();
    //button_logic
    document.querySelectorAll(".question").forEach( (item) => {
        if (!item.className.includes("active")){
            item.style.opacity = 0;
            item.style.display = "none";
        }
    });
    get_continue_buttons.forEach( (item) => {
        item.addEventListener("click", function (){
            const item_id = parseInt(item.id, 10);
            const get_question = document.querySelectorAll(".question");
            get_question[item_id].style.opacity = 0;
            setTimeout( () => {
                get_question[item_id].classList.add("question_none");
                get_question[item_id+1].classList.add("question_active");
                setTimeout( () => {
                    get_question[item_id+1].style.opacity = 1;
                }, 500);
            }, 500);
        });
    });
    //main_regisot_warnings
    let block_count = 0;
    let warning_include = false;
    const get_inputs_block_thirst = document.querySelectorAll(".registor_container .thirst_part input");
    get_inputs_block_thirst.forEach( (item) => {
        block_count++;
        item.parentNode.id = block_count; 
        //click_logic
        item.closest(".thirst_part").querySelector("button").parentNode.addEventListener("click", function (){
            //global_check
            get_inputs_block_thirst.forEach( (item) => {
                if (item.value.length === 0){
                    item.parentNode.querySelector("u").innerHTML = "Впишите поле";
                }
                //email_check
                if (item.name === "user_email" && !item.value.includes("@") && !item.value.includes(".") && item.value.length >= 1){
                    item.parentNode.querySelector("u").innerHTML = "Введите настоящий email";
                }
            });
        });
        //print_logic
        item.addEventListener("input", function (){
            const get_warning = item.parentNode.querySelector("u");
            if (this.value.length !== 0){
                get_warning.innerHTML = "";
            }
            //password_check
            if (item.name === "user_password" && item.value.length <= 7){
                get_warning.innerHTML = "Длина пароля должна быть больше или ровно 8";
            }
            //button_active
            get_inputs_block_thirst.forEach( (item) => {
                if (item.value.length >= 2){
                    const get_button = item.closest(".main_registration").querySelector("button");
                    get_button.classList.add("button_active");
                }
            });
        });
    });
}
registor_script();