export function smile_add(){
    const get_smiles = document.querySelectorAll(".user_chat .smiles div");
    //smile_open
    const get_icon = document.querySelector(".user_chat .smile");
    get_icon.addEventListener("click", function (){
        const get_form_child = document.querySelector(".user_chat .form_children_wrapper");
        const get_smile_container = document.querySelector(".user_chat .smile_choice");
        this.querySelector("svg").classList.toggle("smile_active");
        get_form_child.classList.toggle("form_children_wrapper_smile");
        get_smile_container.classList.toggle("active_choice");
    });
    //smile_choice
    get_smiles.forEach( (item) => {
        item.addEventListener("click", function (){
            const get_value_tag = document.querySelector(".user_chat input.message_right");
            get_value_tag.value = get_value_tag.value + this.innerHTML;
        });
    });
    //smile_resolt_check
    function smile_find(){
        let smile_array = [];
        for (let i = 0; i < get_smiles.length; i++){
            smile_array.push(get_smiles[i].innerHTML.trim());
        }
        const get_message_value = document.querySelectorAll(".chat_row .message p.message_value");
        get_message_value.forEach( (item) => {
            let array_temp = -1;
            let smile_check = false;
            const item_value = item.innerHTML.trim();
            while (true){
                array_temp++;
                if (item_value === smile_array[array_temp]){
                    smile_check = true;
                    break;
                }
                if (array_temp + 1 === smile_array.length){
                    break;
                }
            }
            if (smile_check === true){
                item.classList.add("only_smile");
            }
        });
    }
    smile_find();
}