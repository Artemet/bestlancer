//registor_script
function registor_script(){
    const get_resolt_input = document.querySelectorAll(".resolt_input input");
    const get_header_button = document.querySelector(".header_line .header_part_two .registor");
    const get_registor_part = document.querySelector("p.registor_part_number").innerHTML;
    const part_convert = parseInt(get_registor_part, 10);
    get_header_button.remove();
    if (part_convert === 1){
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
    } else if (part_convert === 2 || part_convert === 3){
        //main_registor_question
        let checkbox_click = false;
        function main_registor(){
            const get_checkbox_block = document.querySelectorAll(".registor_container .main_registor_question .checkbox_choice");
            setTimeout( () => {
                document.querySelectorAll(".registor_container .main_registor_question").forEach( (item) => {
                    item.style.opacity = 1;
                });
            }, 500);
            const get_button = document.querySelector(".registor_container .post_button");
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
            get_button.addEventListener("click", function (){
                if (part_convert === 2){
                    const get_values = document.querySelectorAll(".main_registration input.right_in");
                    get_values.forEach( (item) => {
                        if (!item.closest("div").className.includes("country")){
                            const get_checkbox_option = document.querySelectorAll(".registor_container .checkbox_choice p")[1];
                            if (checkbox_click === false){
                                get_checkbox_option.style.color = "tomato";
                            } else if (checkbox_click === true){
                                get_checkbox_option.style.color = "black";
                            }
                        }
                    });
                }
            });
        }
        main_registor();
    }
    //button_press
    const get_continue_button = document.querySelector(".registor_container button");
    get_continue_button.addEventListener("click", function (){
        if (part_convert === 1){
            setTimeout( () => {
                window.location.href = "registor.php?registor_part=2";
            }, 500);
        } else if (part_convert === 2){
            setTimeout( () => {
                window.location.href = "registor.php?registor_part=3";
            }, 500);
        }
    });
    //resolt_input
    if (localStorage.getItem("role")) {
        get_resolt_input[0].value = localStorage.getItem("role");
    }
    get_resolt_input[0].addEventListener("input", function () {
        localStorage.setItem("role", get_resolt_input[0].value);
    });
}
registor_script();