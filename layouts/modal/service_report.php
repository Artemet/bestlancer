<div class="user_container make_report_container">
    <div class="make_report">
        <div>
            <h3>Жалоба на услугу №<?=$service_id?></h3>
            <div class="cross_icon"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></div>
            <!-- ../bd_send/services/service_report.php?service_id=<?=$service_id?> -->
            <!-- <form action="" method="post"> -->
                <div class="option_choice">
                    <input type="text" class="report_option right_in" name="report_option" readonly>
                    <div class="sub_input">
                        <div><p>Оскарбление</p></div>
                        <div><p>Мошенничество</p></div>
                        <div><p>Обман</p></div>
                        <div><p>Угрозы</p></div>
                        <div><p>Другое</p></div>
                    </div>
                </div>
                <div>
                    <textarea name="report_description" class="report_description right_in" id="" cols="30" rows="10" placeholder="Напишите вашу жалобу"></textarea>
                </div>
                <button class="send_report">Отправить</button>
            <!-- </form> -->
       </div>
    </div>
    <script>
        $('button.send_report').on('click', function (){
            const report_option_val = $('input.report_option').val();
            const report_description_val = $('.report_description').val();

            $.ajax({
                method: "POST",
                url: "../bd_send/services/service_report.php?service_id=<?=$service_id?>",
                data: { report_option: report_option_val, report_description: report_description_val }
            })
                .done(function () {
                    $('.make_report_container')[0].style.opacity = 0;
                    $('.service_page .icon_choice .report_icon')[0].classList.add("spam_active");
                    setTimeout(() => {
                        $('.make_report_container')[0].style.display = "none";
                        $('.make_report_container textarea')[0].value = "";
                        alert("Жалоба на услугу №<?=$service_id?> успешно подана. Вскоре мы её рассмотрим и проверим, благадорим за заявку!");
                    }, 500);
                });
        });
    </script>
</div>