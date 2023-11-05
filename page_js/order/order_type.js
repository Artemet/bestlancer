//order_type
function order_type(){
    function order_choice(){
      let click_temp = 0;
      const get_icon = document.querySelector(".tasks_container .icon_options .order_filter svg");
      get_icon.addEventListener("click", function (){
        click_temp++;
        this.classList.toggle("active");
        const get_menu = this.closest(".order_filter").querySelector(".type_sub");
        if (click_temp === 1){
          get_menu.style.display = "block";
          setTimeout( () => {get_menu.classList.add("type_sub_active");}, 100);
        } else{
          get_menu.classList.remove("type_sub_active");
          setTimeout( () => {get_menu.style.display = "none";}, 500);
          click_temp = 0;
        }
      });
    }
    order_choice();
    const get_type_option = document.querySelector(".tasks_container p.type_option");
    const get_order_types = document.querySelectorAll(".tasks_container .orders p.type");
    get_order_types.forEach( (item) => {
        if (item.innerHTML.trim() !== get_type_option.innerHTML.trim()){
            item.closest(".order").remove();
        }
    });
}
order_type();