//user_answer
export function user_answer(){
    const get_option = document.querySelectorAll(".chat_row .message_menu p.answer");
    const get_answer_line = document.querySelector(".user_chat .answer_line");
    const get_cross = document.querySelector(".user_chat .answer_line svg").parentNode;
    get_option.forEach( (item) => {
        item.addEventListener("click", function (){
            let truncatedMessage = null;
            let resolt_message = null;
            item.closest(".chat_row").querySelector(".arrow").click();
            const get_value_tag = item.closest(".chat_row").querySelector("p.main_value");
            if (get_value_tag.querySelectorAll("a").length >= 1){
                resolt_message = get_value_tag.title.trim();
                get_value_tag.removeAttribute("title");
            } else{
                resolt_message = get_value_tag.textContent.trim();
            }

            try {
                if (resolt_message.length !== 0){
                    if (resolt_message.length >= 50) {
                        truncatedMessage = resolt_message.substring(0, 50) + '...';
                    } else{
                        truncatedMessage = resolt_message;
                    }
                } else{
                    throw item.closest(".chat_row");
                }
            } catch (parent){
                console.log(parent);
                const get_value = parent.querySelector(".file_information b").innerHTML.trim();
                truncatedMessage = get_value;
            }
            get_answer_line.querySelector("p").innerHTML = truncatedMessage ;
            //open_script
            get_answer_line.id = item.closest(".chat_row").id;
            get_answer_line.classList.add("answer_line_active");
        });
    });
    //close_script
    get_cross.addEventListener("click", function (){
        get_answer_line.removeAttribute("id");
        get_answer_line.classList.remove("answer_line_active");
    });
    //answer_scroll
    const anchors = document.querySelectorAll('.user_chat a.scroll_control');
    for (let anchor of anchors) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            console.log(0);
            const blockID = anchor.getAttribute('href').substr(1);
            console.log(blockID);
            try{
                document.getElementById(blockID).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            } catch (e){
                alert("Сообщение недоступно!");
            }
        });
    }
}