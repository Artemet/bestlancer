//application_value
function application_value() {
  const get_inputs = document.querySelectorAll(
    ".application_page .application_information input"
  );
  const get_max_price = document.querySelector(
    ".application_page p.max_price b.price"
  );
  const get_order_id = document.querySelector(
    ".application_page noscript.order_id_number"
  );
  try {
    if (get_max_price.innerHTML === "0") {
      const get_max_price_tag = document.querySelector(
        ".application_page p.max_price"
      );
      get_max_price_tag.remove();
      get_inputs[0].max = "";
    }
  } catch (e) {
    console.log("Цена договорная");
  }
  //input_check
  let value_include = [];
  const get_post_button = document.querySelector(
    ".application_page .wrapper button"
  );
  const get_checkable_tags = document.querySelectorAll(
    ".application_page .checkable"
  );
  get_checkable_tags.forEach((item) => {
    value_include.push(item.value.length >= 1);
    item.addEventListener("input", function () {
      value_include.splice(0, get_checkable_tags.length);
      get_checkable_tags.forEach((item) => {
        value_include.push(item.value.length >= 1);
      });
      if (!value_include.includes(false)) {
        get_post_button.classList.remove("none_ready");
      } else {
        get_post_button.classList.add("none_ready");
      }
    });
  });
  //post_button
  get_post_button.addEventListener("click", function () {
    const order_id = parseInt(get_order_id.innerHTML, 10);
    const get_checkable_tags = document.querySelectorAll(
      ".application_page .checkable"
    );
    const get_values = document.querySelectorAll(".application_page .right_in");
    const value_check = (tag_index) => {
      let warning_find = false;
      const input = get_checkable_tags[tag_index];
      const input_warning = input.parentNode.querySelector("u.warning");
      const value = parseInt(input.value);
      input.value = value;
      if (tag_index === 0) {
        //price_check
        let max_price = null;
        const get_max_price = document.querySelector(
          ".application_page b.price"
        );
        try {
          max_price = parseInt(get_max_price.innerHTML.trim(), 10);
        } catch (e) {
          console.log("Цена договорная.");
        }

        if (value <= 299) {
          input_warning.innerHTML = "Минимальная ставка 300 ₽";
          warning_find = true;
        } else if (max_price !== null && value > max_price) {
          input_warning.innerHTML = "Соблюдайте бюджет";
          warning_find = true;
        } else {
          input_warning.innerHTML = "";
          warning_find = false;
        }
      } else if (tag_index === 1) {
        //day_check
        if (value <= 0) {
          input_warning.innerHTML = "Минимальный срок 1 день";
          warning_find = true;
        } else {
          input_warning.innerHTML = "";
          warning_find = false;
        }
      }
      return warning_find;
    };
    for (let i = 0; i < get_checkable_tags.length; i++) {
      if (value_check(i) === true) {
        return;
      }
    }
    //application_post
    const order_type = document.querySelector("noscript.order_type").innerHTML;
    const type_convert = parseInt(order_type, 10);

    const formData = new FormData();
    formData.append("price", get_values[0].value);
    if (type_convert == 1) {
      formData.append("user_message", get_values[1].value.trim());
    } else {
      formData.append("time", get_values[1].value);
      formData.append("user_message", get_values[2].value.trim());
    }

    $.ajax({
      method: "POST",
      url: "../bd_send/order/send_application.php?order_id=" + order_id,
      contentType: false,
      processData: false,
      data: formData,
    }).done(function (response) {
      console.log(response);
      const get_wrapper = document.querySelector(".application_page .wrapper");
      const get_overlay = document.querySelector(".application_page .overlay");
      if (response !== "no_method") {
        get_wrapper.classList.add("wrapper_loading");
        get_overlay.classList.add("overlay_active");
        setTimeout(() => {
          window.location.href = "order_page.php?order_id=" + order_id;
        }, 800);
      } else {
        const method_ask = confirm(
          "Перед отправкой заявки надо обязательно указать реквезиты для оплаты в настройках. Чтоб заказчик был в курсе куда переводить средства."
        );
        if (method_ask) {
          window.open("../pages/settings.php");
        }
      }
    });
  });
}
application_value();
//value_save
function value_save() {
  const get_inputs = document.querySelectorAll(".application_page .right_in");
  const get_order_id = document.querySelector(".order_id_number");
  const id_convert = parseInt(get_order_id.innerHTML.trim(), 10);
  if (id_convert === id_convert) {
    if (localStorage.getItem("order_text")) {
      get_inputs[2].value = localStorage.getItem("order_text");
    }
    try {
      get_inputs[2].addEventListener("input", function () {
        localStorage.setItem("order_text", get_inputs[2].value);
      });
    } catch (e) {
      console.log("Вакансия");
    }
  }
}
value_save();
