//order_check
const get_link_container = document.querySelector(".freelance_container .title_part .part_one .text_container");
const get_link = document.querySelector(".freelance_container .title_part .part_one .text_container a");
function order_check(){
    const get_user = document.querySelector(".user p.user_name");
    if (get_user.innerHTML.includes("Гость")){
        get_link.style.pointerEvents = "none";
        create_click_wrapper();
    }
}
order_check();
function create_click_wrapper(){
    const create_wrapper = document.createElement("div");
    create_wrapper.classList = "click_wrapper";
    create_wrapper.style.cursor = "pointer";
    get_link_container.appendChild(create_wrapper);
    create_wrapper.appendChild(get_link);
    create_wrapper.addEventListener('click', function (){
        const get_registor_button = document.querySelector(".header_line .header_part_two .registor");
        get_registor_button.click();
    });
    const get_links_parts = document.querySelectorAll(".freelance_container .title_part .part_one .text_container .link_part");
    get_links_parts.forEach( (item) => {
        get_link_container.appendChild(item);
    });
}