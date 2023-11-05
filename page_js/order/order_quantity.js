//order_quantity
function order_quantity(){
    const get_orders = document.querySelectorAll(".orders .order");
    const get_warning_text = document.querySelector(".tasks_container p.no_orders");
    if (get_orders.length === 0){
        get_warning_text.style.display = "block";
        document.querySelector(".orders .pagination").remove();
    }
}
order_quantity();