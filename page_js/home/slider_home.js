//slider_buttons
const get_slide = document.querySelector(".work_resolt .slide");
const get_left_arrow = document.querySelector(".work_resolt .arrow_left span");
const get_right_arrow = document.querySelector(".work_resolt .arrow_right span");
let slide_position = 0;
function click_right(){
    slide_position += 79;
    get_left_arrow.style.opacity = 1;
    get_left_arrow.onclick = click_left;
    get_slide.style.right = slide_position + "vw";
    if (slide_position === 158){
        get_right_arrow.style.opacity = 50 + "%";
        slide_position = 79;
    }
}
function click_left(){
    slide_position -= 79;
    get_right_arrow.style.opacity = 1;
    get_slide.style.right = slide_position + "vw";
    if (slide_position === 0){
        get_left_arrow.onclick = "";
        get_left_arrow.style.opacity = 50 + "%";
    }
}