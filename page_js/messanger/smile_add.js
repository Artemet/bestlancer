function smile_add(){
    //smile_open
    const get_icon = document.querySelector(".user_chat .smile");
    get_icon.addEventListener("click", function (){
        const get_form_child = document.querySelector(".user_chat .form_children_wrapper");
        const get_smile_container = document.querySelector(".user_chat .smile_choice");
        this.querySelector("svg").classList.toggle("smile_active");
        get_form_child.classList.toggle("form_children_wrapper_smile");
        get_smile_container.classList.toggle("active_choice");
        if (get_smile_container.className.includes("active_choice")){
            get_smile_container.style.display = "block";
            setTimeout( () => {
                get_smile_container.style.opacity = 1;
            }, 500);
        } else{
            get_smile_container.style.opacity = 0;
            get_smile_container.style.display = "none";
        }
    });
    //smile_choice
    const get_smiles = document.querySelectorAll(".user_chat .smiles div");
    get_smiles.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_value_tag = document.querySelector(".user_chat textarea");
            get_value_tag.value = get_value_tag.value + this.innerHTML;
        });
    });
}
smile_add();