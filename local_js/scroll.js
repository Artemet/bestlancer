const get_line = document.querySelectorAll(".line");
get_line.forEach( (item) => {
    item.classList.add("line_no_animation");
});
window.addEventListener('scroll', function (){
    const display_height = window.innerHeight;
    function arrow_up_scroll(){
        const get_arrow = document.querySelector(".arrow_up");
        get_arrow.addEventListener('click', function (){
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
        if(pageYOffset > 0){
            get_arrow.style.opacity = 1;
        }
        else{
            get_arrow.style.opacity = 0;
        }
    }
    arrow_up_scroll();
    function line_animation(){
        get_line.forEach( (item) => {
            if(pageYOffset > item.offsetTop-display_height){
                item.classList.remove("line_no_animation");
            }
        });
    }
    line_animation();
});