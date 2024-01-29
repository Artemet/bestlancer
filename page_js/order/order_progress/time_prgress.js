//time_progress
function time_progress(){
    let time_arr = [];
    const get_in_bar = document.querySelector(".order_progress .progress_bar .in_bar");
    const get_time_options = document.querySelectorAll(".time_information span");
    get_time_options.forEach( (item) => {
        const push_resolt = parseInt(item.innerHTML.trim(), 10);
        time_arr.push(push_resolt);
    });
    const formula = time_arr[0] / time_arr[1] * 100;
    get_in_bar.style.width = formula + "%";
}
window.addEventListener("load", function (){
    time_progress();
});