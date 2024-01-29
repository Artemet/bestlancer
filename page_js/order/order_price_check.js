//order_price_check
function order_price_check(){
    const get_price = document.querySelector(".order_page .price span");
    const get_price_text = document.querySelector(".order_page .price b.order_price");
    const price_number = get_price_text.innerHTML;
    const price_filter = price_number.replace(/[^\w\d]/g, "");
    get_price_text.innerHTML = price_filter;
    if (get_price_text.innerHTML.includes(0) && get_price_text.innerHTML.length === 1){
        get_price.remove();
        const get_price_block = document.querySelector(".order_page .price");
        const create_p = document.createElement("p");
        create_p.innerHTML = "Цена договорная";
        get_price_block.appendChild(create_p);
    }
}
order_price_check();