//registor_script
function registor_script(){
    let data_information = []; 

    const get_continue_buttons = document.querySelectorAll(".registor_container button");
    for (let i = 0; i < get_continue_buttons.length; i++){
        get_continue_buttons[i].id = i;
    }

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
                //arr_logic
                if (data_information.length !== 0){
                    data_information.pop();
                }
                data_information.push(item.id);
                console.log(data_information);
            });
        });
        //button_continue
        get_button.addEventListener("click", function (){
            if (data_information[0] == "buyer" || data_information[0] == "seller"){
                const question = this.closest(".question");
                question.style.opacity = 0;
                setTimeout( () => {
                    question.style.display = "none";
                    const get_main_question = document.querySelector(".main_registor_question");
                    get_main_question.style.display = "block";
                    setTimeout( () => {
                        get_main_question.style.opacity = 1;
                        main_registor();
                    }, 100);
                }, 500);
            }
        });
        function main_registor(){
            let registor_call = 0;
            const get_button = document.querySelector(".main_registor_question button");
            const get_inputs = document.querySelectorAll(".main_registor_question input.checking_value");
            get_inputs.forEach( (item) => {
                function value_check(){
                    if (item.value.length >= 1){
                        get_button.classList.add("active_click");
                    } else{
                        get_button.classList.remove("active_click");
                    }
                }
                value_check();
                item.addEventListener("input", function (){
                    value_check();
                });
            });
            //password_see
            const get_eye = document.querySelector(".registor_container .password_value .eye");
            get_eye.addEventListener("click", function (){
                const password_input = this.parentNode.querySelector("input");
                this.classList.toggle("eye_see");
                password_input.classList.toggle("active_see");
                if (!this.className.includes("eye_see")){
                    this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zm151 118.3C226 97.7 269.5 80 320 80c65.2 0 118.8 29.6 159.9 67.7C518.4 183.5 545 226 558.6 256c-12.6 28-36.6 66.8-70.9 100.9l-53.8-42.2c9.1-17.6 14.2-37.5 14.2-58.7c0-70.7-57.3-128-128-128c-32.2 0-61.7 11.9-84.2 31.5l-46.1-36.1zM394.9 284.2l-81.5-63.9c4.2-8.5 6.6-18.2 6.6-28.3c0-5.5-.7-10.9-2-16c.7 0 1.3 0 2 0c44.2 0 80 35.8 80 80c0 9.9-1.8 19.4-5.1 28.2zm51.3 163.3l-41.9-33C378.8 425.4 350.7 432 320 432c-65.2 0-118.8-29.6-159.9-67.7C121.6 328.5 95 286 81.4 256c8.3-18.4 21.5-41.5 39.4-64.8L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5zm-88-69.3L302 334c-23.5-5.4-43.1-21.2-53.7-42.3l-56.1-44.2c-.2 2.8-.3 5.6-.3 8.5c0 70.7 57.3 128 128 128c13.3 0 26.1-2 38.2-5.8z"/></svg>';
                } else{
                    this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>';
                }
                if (!password_input.className.includes("active_see")){
                    password_input.type = "password";
                } else{
                    password_input.type = "text";
                }
            });

            let enter_button_count = 0;
            get_button.addEventListener("click", function (){
                enter_button_count++;
                const get_all_warnings = document.querySelectorAll(".main_registor_question u.warning");
                function warning_check(){
                    let warning_catch = -1;
                    while (true){
                        warning_catch++;
                        if (get_all_warnings[warning_catch].innerHTML.length !== 0){
                            let warning_number = 0;
                            const warning_html = document.querySelectorAll(".main_registor_question u.warning");
                            warning_html.forEach( (item) => {
                                if (item.innerHTML.length !== 0){
                                    warning_number++;
                                }
                            });
                            setTimeout( () => {
                                if (warning_number === 1){
                                    alert("Испрвьте " + warning_number + " ошибку в форме!");
                                } else if (warning_number >= 2){
                                    alert("Испрвьте " + warning_number + " ошибки в форме!");
                                }
                                warning_number = 0;
                            }, 100);
                            break;
                        }
                        if (warning_catch + 1 >= get_all_warnings.length){
                            break;
                        }
                    }
                }
                if (enter_button_count === 1){
                    warning_check();
                }
                get_inputs.forEach( (item) => {
                    const get_warning = item.parentNode.querySelector("u.warning");
                    if (item.value === ""){
                        get_warning.innerHTML = "Введите поле";
                    } else if (item.name === "user_email" && !item.value.includes("@") && !item.value.includes(".")){
                        item.parentNode.querySelector("u.warning").innerHTML = "Введите сушествующий Email";
                    } else if (item.name === "user_password" && item.value.length <= 7){
                        item.parentNode.querySelector("u.warning").innerHTML = "Пароль должен содержать как минимум 8 символов";
                    } else if (
                        item.name === "user_password" &&
                        (!item.value.includes("!") &&
                          !item.value.includes("&") &&
                          !item.value.includes("$") &&
                          !item.value.includes("_") &&
                          !item.value.includes("-") &&
                          !item.value.includes("#") &&
                          !item.value.includes("@"))
                      ) {
                        item.parentNode.querySelector("u.warning").style.textDecoration = "auto";
                        item.parentNode.querySelector("u.warning").innerHTML =
                          "Пароль должен содержать один из символов (&, $, _, -, #, @, !)";
                      } else if (item.name === "user_password" && /\d/.test(item.value) === false) {
                        item.parentNode.querySelector("u.warning").innerHTML = "Пароль должен содержать в себе цифры";
                      } else if (item.name === "user_password" && /[a-zA-Z]/.test(item.value) === false) {
                        item.parentNode.querySelector("u.warning").innerHTML = "Пароль должен содержать в себе латинские буквы";
                      } else{
                        get_warning.innerHTML = "";
                        let warning_catch = 0;
                        const get_all_warnings = document.querySelectorAll(".registor_container .main_registor_question u.warning");
                        while (warning_catch < get_all_warnings.length){
                            warning_catch++;
                            if (get_all_warnings[warning_catch - 1].innerHTML.length !== 0){
                                break;
                            }
                        }
                        if (warning_catch === get_all_warnings.length){
                            const get_choice = document.querySelector(".important_agree_choice");
                            if (get_choice.querySelector("input").checked === false){
                                get_choice.querySelector("p").style.color = "tomato";
                            } else{
                                get_choice.querySelector("p").removeAttribute("style");
                                let end_call_temp = -1;
                                let end_register = true;
                                const get_warnings = document.querySelectorAll(".main_registor_question u.warning");
                                setTimeout( () => {
                                    while (end_call_temp <= get_warnings.length - 2){
                                        end_call_temp++;
                                        if (get_warnings[end_call_temp].innerHTML.length !== 0){
                                            end_register = false;
                                            break;
                                        }
    
                                    }
                                    if (end_register === true){
                                        const get_old_level = document.querySelector(".registor_container .main_registor_question");
                                        const get_new_level = document.querySelector(".registor_container .end_registor_question");
                                        const get_button = document.querySelector(".registor_container .end_registor_question button");
                                        get_old_level.style.opacity = 0;
                                        setTimeout( () => {
                                            get_old_level.style.display = "none";
                                            get_new_level.style.display = "block";
                                            setTimeout( () => {
                                                get_new_level.style.opacity = 1;
                                            }, 100);
                                        }, 500);
                                        //main_logic
                                        const get_nik_input = get_new_level.querySelector(".right_in");
                                        get_nik_input.addEventListener("input", function (){
                                            const get_button = this.closest(".question").querySelector(".post_button button");
                                            if (this.value.length >= 5){
                                                get_button.classList.add("active_click");
                                            } else{
                                                get_button.classList.remove("active_click");
                                            }
                                        });
                                        get_button.addEventListener("click", function (){
                                            registering();
                                        });
                                    }
                                }, 50);
                            }
                        }
                    }
                });
                function registering() {
                    registor_call++;
                    if (registor_call === 1) {
                        const my_nik = document.querySelector(".end_registor_question input").value.trim();
                        function make_registor(){
                            const get_main_value = document.querySelectorAll(".main_registor_question input.right_in");
                            data_information.splice(1, data_information.length);
                            get_main_value.forEach( (item) => {
                                data_information.push(item.value.trim());
                            });
                            const role = data_information[0];
                            const name = data_information[1];
                            const family = data_information[2];
                            const email = data_information[3];
                            const password = data_information[4];
                            const country = data_information[5];
                            const nik = my_nik;
                            console.log(true);
                            $.ajax({
                                method: "POST",
                                url: "../bd_send/user_registor.php",
                                data: { user_role: role, user_name: name, user_family: family, user_email: email, user_password: password, user_country: country, user_nik: nik },
                            });
                        }
                        function finish_window(){
                            //open_window
                            const get_window = document.querySelector(".finish_window");
                            get_window.style.display = "block";
                            setTimeout( () => {
                                get_window.style.opacity = 1;
                            }, 100);
                            //name_paste
                            const get_paste_place = document.querySelector(".finish_window p.do_information");
                            get_paste_place.innerHTML = data_information[1] + ", поздравляем! Ваш аккаунт успешно был создан на фриланс бирже Bestlancer. Теперь вы смело можете заходить в ваш аккаунт и развивать его. Благодорим вас, за выбранный вами выбор!";
                            //button_click
                            const get_button = document.querySelector(".finish_window button");
                            get_button.addEventListener("click", function (){
                                const get_sing_button = document.querySelector(".header_line .header_part_two .button");
                                get_sing_button.click();
                            });
                        }
                        $.ajax({
                            method: "POST",
                            url: "../bd_send/user_registor.php",
                            data: { user_nik: my_nik },
                        })
                            .done(function (response) {
                                const get_warning = document.querySelector(".end_registor_question u.warning");
                                if (response === 'duplicate') {
                                    get_warning.innerHTML = "Данный никнейм уже занят";
                                } else {
                                    get_warning.innerHTML = "";
                                    const get_overlay = document.querySelector(".end_registor_question .overlay");
                                    const get_level = document.querySelector(".end_registor_question .end_registration");
                                    const get_button = document.querySelector(".registor_container .end_registor_question button");
                                    get_overlay.classList.add("overlay_active");
                                    get_level.classList.add("end_registration_load");
                                    get_button.classList.remove("active_click");
                                    setTimeout( () => {
                                        get_level.parentNode.style.opacity = 0;
                                        setTimeout( () => {
                                            const get_questions = document.querySelectorAll(".question");
                                            get_questions.forEach( (item) => {
                                                if (!item.className.includes("finish_window")){
                                                    item.remove();
                                                }
                                            });
                                            finish_window();
                                        }, 500);
                                    }, 700);
                                    make_registor();
                                }
                            });
                        registor_call = 0;
                    }
                }
                if (enter_button_count >= 2){
                    warning_check();
                }
            });
            function checkbox_choice(){
                const get_options = document.querySelectorAll(".registor_container .checkbox_choice p");
                const get_checkbox = document.querySelectorAll(".registor_container .checkbox_choice input");
                get_checkbox.forEach( (item) => {
                    item.addEventListener("click", function (){
                        item.closest(".checkbox_choice").classList.toggle("active_box");
                    });
                });
                get_options.forEach( (item) => {
                    item.addEventListener("click", function (){
                        item.closest(".checkbox_choice").classList.toggle("active_box");
                        if (!item.closest(".checkbox_choice").className.includes("active_box")){
                            item.closest(".checkbox_choice").querySelector("input").checked = false;
                        } else{
                            item.closest(".checkbox_choice").querySelector("input").checked = true;
                        }
                    });
                });
            }
            checkbox_choice();
        }
    });
    //main_regisot_warnings
    let block_count = 0;
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
        });
    });
    function back_page(){
        const get_back_element = document.querySelectorAll(".registor_container .back_move");
        get_back_element.forEach( (item) => {
            item.addEventListener("click", function (){
                const question = this.closest(".question");
                const get_beafore_question = document.querySelectorAll(".question")[parseInt(question.id, 10) - 1];
                question.style.opacity = 0;
                setTimeout( () => {
                    question.removeAttribute("style");
                    get_beafore_question.style.display = "block";
                    setTimeout( () => {
                        get_beafore_question.style.opacity = 1;
                    }, 100);
                }, 500);
            });
        });
    }
    back_page();
}
registor_script();
//storage
function local_storage_save() {
    const inputs = document.querySelectorAll(".main_registor_question input");
    inputs.forEach(input => {
        input.addEventListener("input", function () {
            localStorage.setItem(input.id, input.value);
        });
        const savedValue = localStorage.getItem(input.id);
        if (savedValue) {
            input.value = savedValue;
        }
    });
}
local_storage_save();