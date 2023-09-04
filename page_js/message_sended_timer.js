//timer
function timer(){
    const get_timer = document.querySelector(".timer_container .timer span");
    const get_page_back = document.querySelector(".timer_container .page_back");
    let timer_number = 5;
    setInterval( () => {
        timer_number--;
        get_timer.innerHTML = timer_number;
    }, 1000);
}
timer();
function countdown() {
    const timerElement = document.querySelector('.timer span');
    const count = parseInt(timerElement.textContent);
    if (count > 0) {
        count--;
        timerElement.textContent = count;
        setTimeout(countdown, 1000);
    }
    else {
        window.location.href = "http://localhost/bestlancer/";
    }
}

setTimeout(countdown, 5000);