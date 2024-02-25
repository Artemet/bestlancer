import { clearLocalStorage } from "./order_values/value_save.js";
//value_check
function value_order_check() {
  let logic_temp = 0;
  let addition_list = [];
  const get_container = document.querySelector(".make_order_container");
  const get_buy_container = document.querySelector(".order_double_container");
  const get_inputs = document.querySelectorAll(
    ".make_order_container .check_value"
  );
  //warning_give
  function check_position() {
    const get_inputs = document.querySelectorAll(
      ".make_order_container .warning_checkable"
    );
    const get_button = document.querySelector(".make_order_container button");
    get_inputs.forEach((item) => {
      if (item.value.length !== 0) {
        item.classList.add("can_check");
        get_button.classList.remove("none_active");
      } else {
        item.classList.remove("can_check");
        get_button.classList.add("none_active");
      }
    });
    const get_checkable_inputs = document.querySelectorAll(
      ".make_order_container .can_check"
    );
    if (get_inputs.length === get_checkable_inputs.length) {
      document
        .querySelector(".make_order_container button")
        .classList.remove("none_active");
    } else {
      document
        .querySelector(".make_order_container button")
        .classList.add("none_active");
    }
  }
  window.addEventListener("load", function () {
    check_position();
  });
  get_inputs.forEach((item) => {
    item.addEventListener("input", function () {
      check_position();
    });
  });
  document
    .querySelector(".button_wrapper")
    .addEventListener("click", function () {
      warning_give();
    });
  function warning_give() {
    const get_inputs = document.querySelectorAll(
      ".make_order_container .check_value"
    );
    const get_warnings = document.querySelectorAll(
      ".make_order_container u.warning"
    );
    get_inputs.forEach((item) => {
      //global_check
      const get_warning = item.closest(".form_part").querySelector("u.warning");
      if (item.name === "order_information" && item.value.length <= 49) {
        get_warning.innerHTML = "Минимальная длина описания: 50";
      } else if (
        item.name === "order_price" &&
        item.value.length === 0 &&
        item.closest(".checkbox_sub").className.includes("checkbox_sub_open")
      ) {
        get_warning.innerHTML = "Предложите цену";
      } else if (
        item.name === "order_price" &&
        parseInt(item.value, 10) <= 299 &&
        item.closest(".checkbox_sub").className.includes("checkbox_sub_open")
      ) {
        get_warning.innerHTML = "Минимальная цена: 300₽";
      } else if (
        item.name === "main_order_category" &&
        item.value.length === 0
      ) {
        get_warning.innerHTML = "Выбирите оснавную категорию";
      } else if (
        item.name === "medium_order_category" &&
        item.value.length === 0
      ) {
        get_warning.innerHTML = "Выбирите среднию категорию";
      } else if (
        item.name === "final_order_category" &&
        item.value.length === 0
      ) {
        get_warning.innerHTML = "Выбирите финальную категорию";
      } else {
        get_warning.innerHTML = "";
      }
    });
    //warning_check
    function warning_find() {
      let find_temp = -1;
      while (find_temp !== get_warnings.length - 1) {
        find_temp++;
        if (get_warnings[find_temp].innerHTML.length !== 0) {
          return true;
        }
      }
      return false;
    }
    if (warning_find() === false) {
      const formData = new FormData();

      //more_modal
      get_container.classList.add("make_order_container_none");
      setTimeout(() => {
        get_container.style.display = "none";
        get_buy_container.classList.add("order_double_container_active");
        setTimeout(() => {
          get_buy_container.style.opacity = 1;
        }, 100);
      }, 500);

      //back_link
      const back_block = () => {
        const get_link = document.querySelector(
          ".order_double_container .back_link"
        );
        get_link.addEventListener("click", function () {
          get_buy_container.style.opacity = 0;
          setTimeout(() => {
            get_buy_container.classList.remove("order_double_container_active");
            get_container.style.display = "block";
            setTimeout(() => {
              get_container.classList.remove("make_order_container_none");
            }, 100);
          }, 500);
        });
      };
      back_block();

      //buy_logic
      const buy_logic = () => {
        let sum = 0;
        logic_temp++;
        const get_checkboxes = document.querySelectorAll(
          ".order_double_container .checkbox"
        );
        const get_options = document.querySelectorAll(
          ".order_double_container .text"
        );
        const get_sum = document.querySelector(
          ".order_double_container p.pay_sum"
        );
        const final_sum = parseInt(get_sum.innerHTML.match(/\d/g).join(""));
        if (final_sum !== 0) {
          sum = final_sum;
        }

        const get_button = document.querySelector(
          ".order_double_container button"
        );
        get_options.forEach((item) => {
          item.addEventListener("click", function () {
            const option_index = parseInt(item.id, 10);
            const parent_checkbox =
              this.closest(".option").querySelector("input");
            const active = parent_checkbox.checked;
            //sum_add
            const get_price = parseInt(item.querySelector(".price").id, 10);
            if (!active) {
              parent_checkbox.checked = true;
              addition_list.push(option_index);
              sum += get_price;
            } else {
              parent_checkbox.checked = false;
              const indexToRemove = addition_list.indexOf(option_index);
              if (indexToRemove !== -1) {
                addition_list.splice(indexToRemove, 1);
              }
              sum -= get_price;
            }
            console.log(final_sum);
            get_sum.innerHTML = sum + "₽";
          });
        });

        get_checkboxes.forEach((item) => {
          item.addEventListener("click", function () {
            const checkbox_index = parseInt(item.id, 10);
            get_options[checkbox_index].click();
          });
        });

        let confirm_temp = 0;
        get_button.addEventListener("click", function () {
          const file_input = document.querySelector("input.file_choice");
          //order_appends
          formData.append("file_send", file_input.files[0]);
          formData.append("order_name", get_inputs[0].value.trim());
          formData.append("order_information", get_inputs[1].value.trim());
          formData.append("order_price", get_inputs[2].value.trim());

          if (get_inputs[3].value.trim() == "Заказ") {
            formData.append("order_type", 0);
          } else if (get_inputs[3].value.trim() == "Вакансия") {
            formData.append("order_type", 1);
          } else {
            window.location.reload();
            return;
          }

          formData.append("main_order_category", get_inputs[4].value.trim());
          formData.append("medium_order_category", get_inputs[5].value.trim());
          formData.append("final_order_category", get_inputs[6].value.trim());

          if (addition_list.length !== 0) {
            formData.append("addition_list", addition_list);
          } else {
            formData.append("addition_list", false);
          }
          $.ajax({
            method: "POST",
            url: "../bd_send/order/send_order.php",
            contentType: false,
            processData: false,
            data: formData,
          }).done(function (response) {
            console.log(response);
            const get_pay_warning = document.querySelector(
              ".payment_do u.warning"
            );
            if (response.includes("Warning:")) {
              const agree = confirm(response);
              if (agree) {
                window.location.reload();
              }
            } else if (response === "vacancy_pay_need") {
              document
                .querySelector(".order_double_container .back_link")
                .click();
              get_pay_warning.innerHTML =
                "Недостаточно средств, размещение вакансии стоит 250 рублей, пополните кошелек.";
              setTimeout(() => {
                confirm_temp++;
                if (confirm_temp === 1) {
                  const pay_ask = confirm("Пополним кошелек?");
                  if (pay_ask) {
                    window.open("balance.php", "_blank");
                  }
                }
              }, 1000);
            } else if (response === "addition_pay_need") {
              const pay_ask = confirm(
                "Недостаточно средств на кошельке, пополним кошелёк?"
              );
              if (pay_ask) {
                window.open("balance.php", "_blank");
              }
            } else {
              clearLocalStorage();
              const get_overlay = document.querySelector(
                ".order_double_container .overlay"
              );
              const get_final_wrapper = document.querySelector(
                ".order_double_container .header"
              );
              get_overlay.classList.add("overlay_active");
              get_final_wrapper.classList.add("header_load");
              setTimeout(() => {
                window.location.href = "../pages/my_orders.php";
              }, 800);
            }
          });
        });
      };
      if (logic_temp == 0) {
        buy_logic();
      }
    }
  }
}
value_order_check();
