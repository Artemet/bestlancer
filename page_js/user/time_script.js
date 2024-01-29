//time_text
function time_text() {
    const get_time = document.querySelector(".user_information .time");
    get_time.innerHTML = get_time.innerHTML.replace(':00', '');
}
time_text();