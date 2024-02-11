//project_ajax
function add_project(){
    const formData = new FormData();
    const fileInput = document.getElementById('icon_choice');
    const get_inputs = document.querySelectorAll(".project_add_container .right_in");  

    const get_button = document.querySelector(".project_add_container button");
    const value_check = (checking) => {
        let catch_warning = false;
        get_inputs.forEach( (item) => {
            const warning = item.parentNode.querySelector("u.warning");
            if (!item.className.includes("checkable")){
                return;
            }
            if (item.value === ""){
                warning.innerHTML = "Введите поле";
                catch_warning = true;
                return;
            } else{
                warning.innerHTML = "";
            }
        });
        if (checking === 0){
            return catch_warning;
        }
    }
    get_button.addEventListener("click", function (){
        //value_check
        value_check(1);
        if (value_check(0) == true){
            return;
        }
        //value_post
        formData.append('file_name', fileInput.files[0]);
        formData.append('project_name', get_inputs[0].value.trim());
        formData.append('project_link', get_inputs[1].value.trim());
        formData.append('project_youtube', get_inputs[2].value.trim());
        formData.append('project_context', get_inputs[3].value.trim());
        $.ajax({
            method: "POST",
            url: "../bd_send/user/project_add.php",
            contentType: false,
            processData: false,
            data: formData,
        })
            .done(function (){
                const get_form_wrapper = document.querySelector(".project_add_container .form_wrapper");
                const get_overlay = document.querySelector(".project_add_container .overlay");
                get_form_wrapper.classList.add("form_wrapper_load");
                get_overlay.classList.add("overlay_active");
                setTimeout( () => {
                    const ask = confirm("Проект был успешно добавлен на вашу страницу.");
                    if (ask){
                        window.location.href = "../pages/user.php";
                    } else{
                        window.location.reload();
                    }
                }, 800);
            });
    });

}
add_project();