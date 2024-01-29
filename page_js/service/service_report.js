//service_report
function service_report(){
    //report_modal
    const get_report_icon = document.querySelector(".service_page .icon_choice .report_icon");
    const get_close_icon = document.querySelector(".make_report .cross_icon");
    const get_modal = document.querySelector(".make_report_container");
    get_report_icon.addEventListener("click", function (){
        get_modal.style.display = "block";
        setTimeout( () => {get_modal.style.opacity = 1;}, 100);
    });
    get_close_icon.addEventListener("click", function (){
        get_modal.style.opacity = 0;
        setTimeout( () => {get_modal.style.display = "none";}, 500);
    });
    //report_text_menu
    let color_temp = 0;
    const get_input = document.querySelector(".make_report .option_choice input");
    const get_sub_options = document.querySelectorAll(".make_report .option_choice .sub_input p");
    get_input.addEventListener("click", function (){
        const get_input_sub = document.querySelector(".make_report .option_choice .sub_input");
        get_input_sub.classList.toggle("sub_input_animation");
    });
    get_sub_options.forEach( (item) => {
        item.addEventListener("click", function (){
            color_temp++;
            get_input.value = item.innerHTML;
            item.style.color = "black";
            if (color_temp === 2){
                get_sub_options.forEach( (item) => {
                    item.style.color = "white";
                });
                item.style.color = "black";
                color_temp = 1;
            }
        });
    });
    get_sub_options[0].click();
}
service_report();