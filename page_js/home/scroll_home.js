//scroll_script
const animation_class = "animation";
function scroll_zero(){
    let number_temp = -1;
    const get_number = document.querySelectorAll(".freelance_container .movement_number .movement span");
    setTimeout( () => {
        setInterval( () => {
            number_temp++;
            get_number[number_temp].classList.add(animation_class);
            if (number_temp === 2){
                number_temp--;
            }
        }, 650);
    }, 100);
}
scroll_zero();
//reputation_numbers
function repitation_scroll(){
    setTimeout( () => {
        let number_temp = 0;
        const get_reoetition_number_block = document.querySelectorAll(".repitation_container .main_reoitation .number");
        const get_reoetition_number = document.querySelectorAll(".repitation_container .main_reoitation span");
        const get_reoetition_number_b = document.querySelectorAll(".repitation_container .main_reoitation b");
        get_reoetition_number_b.forEach(element => {
            element.textContent = element.textContent.replace(/\s/g, '');
        });
        let resolt_numbers = [get_reoetition_number_b[0].innerHTML, get_reoetition_number_b[1].innerHTML, get_reoetition_number_b[2].innerHTML];
        // setTimeout( () => {
        //     get_reoetition_number_b.forEach( (item) => {
        //         if (item.innerHTML === "0"){
        //             get_reoetition_number.forEach( (item) => {
        //                 item.remove();
        //             });
        //             item.style.display = "block"; 
        //         }
        //     });
        // }, 1500);
        setInterval( () => {
            number_temp++;
            for(let i = 0; i < 3; i++){
                get_reoetition_number[i].innerHTML = number_temp;
                if(get_reoetition_number[i].innerHTML == resolt_numbers[i]){
                    get_reoetition_number[i].style.display = "none";
                    get_reoetition_number_b[i].style.display = "block";
                    setTimeout( () => {
                        get_reoetition_number_block[i].innerHTML = "<b style='display: block;'>" + resolt_numbers[i] + "</b>";
                    }, 5000);
                }
            }
        }, 1);
    }, 1500);
}
repitation_scroll();
//scroll_down
window.addEventListener('scroll', function (){
    const display_height = window.innerHeight;
    function question_scroll(){
        let anser_temp = -1;
        const get_question_block = document.querySelector(".about_us .why_question");
        const get_anser = document.querySelectorAll(".about_us .anser");
        if(pageYOffset > get_question_block.offsetTop-display_height){
            setInterval( () => {
                anser_temp++;
                get_anser[anser_temp].style.opacity = 1;
                if(anser_temp === get_anser.length-1){
                    anser_temp--;
                }
            }, 300);
        }
    }
    question_scroll();
});