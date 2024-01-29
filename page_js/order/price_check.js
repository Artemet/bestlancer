//freelancer_choice
function freelancer_choice(){
    const get_order = document.querySelectorAll(".tasks_container div");
    const get_price_block = document.querySelectorAll(".tasks_container .price_part");
    const get_price = document.querySelectorAll(".tasks_container p.price");
    get_price.forEach( (item) => {
        if (item.innerHTML.includes(0) && item.innerHTML.length === 2){
            item.remove();
        }
    });
    get_price_block.forEach( (item) => {
        if (!item.innerHTML.includes("$")){
            item.classList = "none_price";
        }
    });
    get_order.forEach( (item) => {
        if (item.innerHTML.includes("class") && item.innerHTML.includes("none_price")){
            const get_task_part = item.querySelector(".tasks_container .order_part");
            const get_block_price = item.querySelectorAll(".tasks_container p.price");
            get_task_part.style.width = "auto";
            get_block_price.forEach( (item) => {
                if (item.innerHTML != "0$"){
                    get_task_part.style.width = "";
                }
            });
        }
    });
}
freelancer_choice();