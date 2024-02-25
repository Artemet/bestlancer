//change_response
function change_response() {
  const get_response_id = document.querySelectorAll("span.response_id");
  const get_change_button = document.querySelectorAll(
    ".my_responses .change_order_button button"
  );
  const get_response_sub = document.querySelectorAll(
    ".my_responses .response_sub"
  );
  const get_order_information = document.querySelectorAll(
    ".my_responses .response_sub"
  );
  for (let i = 0; i < get_response_sub.length; i++) {
    get_change_button[i].classList = i;
  }
  let click_temp = 0;
  let button_number = null;
  get_change_button.forEach((item) => {
    const icon_svg = item.innerHTML;
    item.addEventListener("click", function () {
      click_temp++;
      button_number = item.classList[0];
      const get_comment =
        get_order_information[button_number].querySelector("p.comment");
      const get_price =
        get_order_information[button_number].querySelector("span");
      const get_time =
        get_order_information[button_number].querySelector(
          "p.main_information"
        );
      const get_comment_blocks = get_order_information[
        button_number
      ].querySelectorAll(".my_responses .response_sub div");
      if (click_temp === 1) {
        item.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>`;
        get_change_button.forEach((item) => {
          if (item.innerHTML === icon_svg) {
            item.classList.add("none_click");
          }
        });
        get_comment.style.display = "none";
        get_comment_blocks[1].classList.add("display");
        const create_form = document.createElement("div");
        //create_form.action = "../bd_send/order/change_order.php?application_id=" + response_id;
        create_form.classList = "form_wrapper";
        const create_button = document.createElement("button");
        create_button.classList = "change_information";
        create_button.innerHTML = "Сохранить";
        get_comment_blocks[0].appendChild(create_form);
        const input_types = ["text", "number", "number"];
        const input_placeholders = [
          "Введите ваше сообщение",
          "Введите вашу цену в долларах",
          "Введите сроки в сутках",
        ];
        const input_names = ["message", "price", "time"];
        const input_icons = [
          `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M96 32C78.3 32 64 46.3 64 64V256H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H64v32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H64v32c0 17.7 14.3 32 32 32s32-14.3 32-32V416H288c17.7 0 32-14.3 32-32s-14.3-32-32-32H128V320H240c79.5 0 144-64.5 144-144s-64.5-144-144-144H96zM240 256H128V96H240c44.2 0 80 35.8 80 80s-35.8 80-80 80z"/></svg>`,
          `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>`,
        ];
        const input_values = [
          get_comment.innerHTML,
          get_price.innerHTML.replace(/\D/g, ""),
          get_time.innerHTML.replace(/\D/g, ""),
        ];
        for (let i = 0; i < input_types.length; i++) {
          const create_input_wrapper = document.createElement("div");
          create_input_wrapper.classList = "input_wrapper";
          const create_warning = document.createElement("u");
          create_warning.classList = "warning";
          const create_input = document.createElement("input");
          create_input.type = input_types[i];
          create_input.id = i;
          create_input.placeholder = input_placeholders[i];
          create_input.name = input_names[i];
          create_input.value = input_values[i];
          create_input.classList = "right_in";
          create_form.appendChild(create_input_wrapper);
          if (i !== 0) {
            create_input.classList.add("checkable_input");
            create_input_wrapper.appendChild(create_warning);
          }
          create_input_wrapper.appendChild(create_input);
          if (i >= 1) {
            const create_icon = document.createElement("div");
            create_icon.classList = "icon";
            create_icon.id = "icon_" + i;
            if (i === 1) {
              create_icon.innerHTML = input_icons[0];
            } else if (i === 2) {
              create_icon.innerHTML = input_icons[1];
            }
            create_input_wrapper.appendChild(create_icon);
          }
        }
        create_form.appendChild(create_button);
        server_send();
        const get_message_input = get_order_information[
          button_number
        ].querySelectorAll(".my_responses .response_sub input")[0];
        if (get_message_input.value === "Нет сообщения") {
          get_message_input.value = "";
        }
      } else if (click_temp === 2) {
        item.innerHTML = icon_svg;
        get_change_button.forEach((item) => {
          item.classList.remove("none_click");
        });
        const get_form = document.querySelectorAll(
          ".my_responses .response_sub .form_wrapper"
        );
        const get_main_information_block = document.querySelector(
          ".my_responses .response_sub .display"
        );
        get_form.forEach((item) => {
          item.remove();
        });
        get_main_information_block.classList.remove("display");
        get_comment.style.display = "block";
        click_temp = 0;
      }
    });
  });
  //server_send
  const server_send = () => {
    let value_arr = [];
    const get_button = document.querySelector(
      ".my_responses button.change_information"
    );
    const response_parent = get_button.closest(".form_wrapper");
    const value_post = () => {
      let response_id = parseInt(get_response_id[button_number].innerHTML);
      $.ajax({
        url: "../bd_send/order/change_order.php?application_id=" + response_id,
      }).done(function (response) {
        console.log(response);
      });
    };
    get_button.addEventListener("click", function () {
      const get_inputs = response_parent.querySelectorAll(".right_in");
      get_inputs.forEach((item) => {
        const number_try = parseInt(item.value, 10);
        if (isNaN(number_try)) {
          value_arr.push(item.value);
        } else {
          value_arr.push(number_try);
        }
      });
      value_post();
    });
  };
}
change_response();
