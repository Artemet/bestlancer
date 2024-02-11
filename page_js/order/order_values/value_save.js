//order_value_save
function order_value_save(){
    const get_value = document.querySelectorAll(".make_order_container .right_order");
    if (localStorage.getItem("order_name")) {
        get_value[0].value = localStorage.getItem("order_name");
    }
    if (localStorage.getItem("order_describe")) {
        get_value[1].value = localStorage.getItem("order_describe");
    }
    get_value[0].addEventListener("input", function () {
        localStorage.setItem("order_name", get_value[0].value);
    });
    get_value[1].addEventListener("input", function () {
        localStorage.setItem("order_describe", get_value[1].value);
    });
}
order_value_save();
//clear_storage
export function clearLocalStorage() {
    localStorage.clear();
}