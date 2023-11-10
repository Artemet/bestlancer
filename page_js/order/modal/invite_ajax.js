$(document).ready(function () {
    $('button.invite_send').on('click', function () {
        let acquaintance_nik = $('input.acquaintance_nik').val();
        function element_create(){
            const get_block_parent = document.querySelectorAll(".invite_modal .row_wrapper");
            const create_send_text = document.createElement("div");
            create_send_text.classList = "invited_text";
            const create_main_text = document.createElement("p");
            create_main_text.innerHTML = "Приглашён";
            get_block_parent.forEach( (item) => {
                const item_text = item.querySelector("p").innerHTML.trim();
                if (item_text === acquaintance_nik){
                    item.querySelector(".user_row").classList.add("none_user");
                    item.appendChild(create_send_text);
                    create_send_text.appendChild(create_main_text);
                }
            });
        }
        $.ajax({
            method: "POST",
            url: "../bd_send/user/user_notification/invite_user.php?order_id=" + $("p.order_id")[0].innerHTML.trim(),
            data: { user_nik: acquaintance_nik }
        })
            .done(function () {
                $(document).ready(function () {
                    $(".invite_modal")[0].style.opacity = 0;
                    setTimeout(() => { $(".invite_modal")[0].style.display = "none"; }, 500);
                });
                setTimeout( () => {alert("Приглашение пользователю " + acquaintance_nik + ", успешно отправленно!");}, 500);
                element_create();
            });
    });
});