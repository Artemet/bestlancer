//country_menu
function registor_country_menu(){
    const get_input = document.querySelector(".registor_container .country .right_in");
    const get_registor_number = document.querySelector(".registor_container p.registor_part_number").innerHTML;
    const registor_number = parseInt(get_registor_number, 10);
    //open_menu
    if (registor_number === 2){
        get_input.addEventListener("click", function (){
            const get_menu = document.querySelector(".registor_container .country .menu");
            get_menu.classList.toggle("menu_animation");
        });
    }
    //click_script
    const get_options = document.querySelectorAll(".registor_container .country .menu p");
    get_options.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_input = document.querySelector(".registor_container .country .right_in");
            get_options.forEach( (item) => {
                item.classList.add("color_white");
                item.classList.remove("color_black");
            });
            item.classList.remove("color_white");
            item.classList.add("color_black");
            get_input.value = item.innerHTML;
        });
        if (item.innerHTML === "Россия"){
            item.click();
        }
    });
}
registor_country_menu();