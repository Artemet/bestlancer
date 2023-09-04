//textarea_click
function sub_reaction(){
    const get_input_block = document.querySelector(".freelance_container .title_part .textarea_sub");
    const get_button = document.querySelector(".freelance_container .title_part button");
    get_input_block.style.display = "block";
    get_button.style.height = 100 + "%";
    setTimeout( () => {
        get_input_block.style.opacity = 1;
    }, 300);
}