//redactor_menu
let change_information_temp = 0;
let edit_menu_temp = 0;
function sub_choice() {
  edit_menu_temp++;
  const get_button = document.querySelectorAll(
    ".user_account .account_redactor button"
  );
  const get_arrow = document.querySelectorAll(
    ".user_account .account_redactor .arrow"
  );
  const get_sub_menu = document.querySelectorAll(
    ".user_account .account_redactor .sub_menu"
  );
  get_button.forEach((item) => {
    item.classList.toggle("animation");
  });
  get_arrow.forEach((item) => {
    item.classList.toggle("arrow_rotate");
  });
  if (edit_menu_temp === 1) {
    get_sub_menu.forEach((item) => {
      item.classList.add("sub_menu_block");
    });
    setTimeout(() => {
      get_sub_menu.forEach((item) => {
        item.classList.add("sub_menu_open");
      });
    }, 100);
  } else if (edit_menu_temp === 2) {
    get_sub_menu.forEach((item) => {
      item.classList.remove("sub_menu_open");
    });
    setTimeout(() => {
      get_sub_menu.forEach((item) => {
        item.classList.remove("sub_menu_block");
      });
    }, 500);
    edit_menu_temp = 0;
  }
}
function change_information(item) {
  change_information_temp++;
  const get_modals = document.querySelectorAll(".change_profile_container");
  const get_close_icon = document.querySelectorAll(
    ".change_profile .close svg"
  );
  //open_modals
  if (change_information_temp === 1) {
    item.classList.add("animation_color");
    get_modals[0].style.display = "block";
    setTimeout(() => {
      get_modals[0].classList.add("change_profile_container_animation");
    }, 100);
  }
  //close_modals
  get_close_icon.forEach((item) => {
    item.addEventListener("click", function () {
      item_click();
      get_modals[0].classList.remove("change_profile_container_animation");
      setTimeout(() => {
        get_modals[0].style.display = "none";
      }, 500);
      change_information_temp = 0;
    });
  });
  function item_click() {
    item.classList.remove("animation_color");
  }
}
//knowledge_add
function knowledge_add() {
  let input_temp = -1;
  let knowledge_arr = [];
  const get_plus = document.querySelector(
    ".change_profile .my_knowledge svg"
  ).parentNode;
  const get_wrapper = document.querySelector(
    ".change_profile .knowledges_wrapper"
  );
  const get_final_value = document.querySelector(
    ".change_profile .my_knowledge input.final_value"
  );

  const create_knowledge = () => {
    input_temp++;
    const create_input = document.createElement("input");
    create_input.type = "text";
    create_input.id = input_temp;
    create_input.title =
      "Нажмите на ввод второй раз, для подтверждения написанного навыка";
    create_input.classList = "knowledge_input right_in";
    create_input.placeholder = "Мой навык";
    get_wrapper.appendChild(create_input);
  };
  get_plus.addEventListener("click", function () {
    create_knowledge();
    input_system();
  });
  const value_check = (value_id) => {
    let catch_temp = -1;
    const get_inputs = document.querySelectorAll(
      ".change_profile .my_knowledge input.right_in"
    );
    const value = get_inputs[value_id].value.trim();
    while (catch_temp <= get_inputs.length - 1) {
      catch_temp++;
      const list_value = knowledge_arr[catch_temp];
      if (list_value === value) {
        return true;
      }
    }
    return false;
  };
  const input_system = () => {
    const get_inputs = document.querySelectorAll(
      ".change_profile .my_knowledge input.right_in"
    );
    get_inputs.forEach((item) => {
      item.addEventListener("click", function () {
        const item_index = parseInt(item.id, 10);
        const value_length = item.value.length;
        if (value_length !== 0 && !value_check(item_index)) {
          knowledge_arr.push(item.value.trim());
          item.classList.add("saved");
          item.removeAttribute("title");
        }
        get_final_value.value = knowledge_arr;
      });
    });
  };
}
knowledge_add();
