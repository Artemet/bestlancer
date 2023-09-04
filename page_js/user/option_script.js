//option_text
function option_text(){
    const get_options = document.querySelectorAll(".user_account .menu_include span");
    get_options.forEach( (item) => {
        if (!item.innerHTML.includes("-") && !item.innerHTML.includes("/") && item.innerHTML.length === 0){
            item.remove();
        }
    });
}
option_text();
function link_text(){
    const get_option_link = document.querySelectorAll(".user_account .menu_include a");
    get_option_link.forEach( (item) => {
        if (item.innerHTML.includes("none")){
            item.remove();
        }
    });
}
link_text();