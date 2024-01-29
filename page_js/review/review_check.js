//review_check
function review_check(){
    //review_length
    const get_reviews = document.querySelectorAll(".reviews_company .review");
    const get_review_warning = document.querySelector(".reviews_company .no_review");
    if (get_reviews.length === 0){
        get_review_warning.style.display = "block";
    }
    //user_review_check
    const get_warning = document.querySelector(".reviews_company .length_warning");
    const get_close_icon = document.querySelector(".reviews_company .length_warning .close_warning");
    setTimeout( () => {get_warning.classList.remove("length_warning_close");}, 500);
    get_close_icon.addEventListener("click", function (){
        get_warning.classList.add("length_warning_close");
        setTimeout( () => {get_warning.remove();}, 500);
    });
}
review_check();