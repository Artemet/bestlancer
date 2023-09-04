//account_check
function account_check(){
    const get_user_name = document.querySelector(".user p.user_name");
    const get_order_user_name = document.querySelector(".order_page .user_information a");
    const user_text = get_user_name.innerHTML;
    const user_order_text = get_order_user_name.innerHTML;
    const filter_name = user_text.replace(/[^\w\d]/g, "");
    const filter_order_name = user_order_text.replace(/[^\w\d]/g, "")
    get_user_name.innerHTML = filter_name;
    get_order_user_name.innerHTML = filter_order_name;
    if (get_order_user_name.innerHTML === get_user_name.innerHTML){
        get_order_user_name.href = "user.php";
        get_order_user_name.innerHTML = user_order_text + "<span> (Вы)</span>";
    }
}
account_check();