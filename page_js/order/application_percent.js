//application_percent
function application_percent(){
    const get_application_numbers = document.querySelectorAll(".tasks_container .application_left_information .number_application");
    const get_in_line = document.querySelector(".tasks_container .user_order_information .in_line");
    const percent = (parseInt(get_application_numbers[0].innerHTML.trim(), 10) / parseInt(get_application_numbers[1].innerHTML.trim(), 10)) * 100;
    get_in_line.style.width = percent + "%";
    if (parseInt(get_application_numbers[0].innerHTML.trim(), 10) <= 0){
        document.querySelector(".application_level").classList.add("application_level_end");
    }
}
application_percent();