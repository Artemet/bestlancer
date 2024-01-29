//personal_order
function personal_order(){
    const get_notification_block = document.querySelectorAll(".notification_container .main_notification");
    const get_file_block = document.querySelectorAll(".notification_container .order_files");
    const get_file_link = document.querySelectorAll(".notification_container .order_files a");
    for (let i = 0; i < get_file_link.length; i++){
        get_file_link[i].classList = i;
    }
    get_file_link.forEach( (item) => {
        if (item.href.includes("none") || item.href.length <= "63"){
            let item_number = item.classList[0];
            get_file_block[item_number].remove();
            get_notification_block[item_number].style.gridTemplateColumns = "1fr auto";
        }
    });
}
personal_order();