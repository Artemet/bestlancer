//retes_menu
function retes_menu() {
  const get_options = document.querySelectorAll(".rates_container .option");
  const get_subs = document.querySelectorAll(".rates_container .option_sub");
  for (let i = 0; i < get_subs.length; i++) {
    get_subs[i].id = i;
  }
  let sub_heights = [];
  get_options.forEach((item) => {
    sub_heights.push(
      item.closest(".option_wrapper").querySelector(".option_sub")
        .clientHeight + "px"
    );
    item
      .closest(".option_wrapper")
      .querySelector(".option_sub").style.height = 0;
    item.addEventListener("click", function () {
      item.closest(".option_wrapper").classList.toggle("sub_animation");
      document.querySelectorAll(".option_wrapper").forEach((item) => {
        if (item.className.includes("sub_animation")) {
          const item_id = parseInt(item.querySelector(".option_sub").id, 10);
          item.querySelector(".option_sub").style.height = sub_heights[item_id];
          document
            .querySelectorAll(".rates_container .option svg")
            [item_id].classList.add("animation");
        } else {
          item.querySelector(".option_sub").style.height = 0;
          item
            .closest(".option_wrapper")
            .querySelector("svg")
            .classList.remove("animation");
        }
      });
    });
  });
}
retes_menu();
//retes_price
function retes_price() {
  const get_checkbox_wrapper = document.querySelectorAll(
    ".rates_container .option_sub div"
  );
  const get_final_price = document.querySelector(
    ".rates_container .price b.price"
  );
  const get_final_applications = document.querySelector(
    ".rates_container .price b.applications"
  );
  get_checkbox_wrapper.forEach((item) => {
    item.addEventListener("click", function () {
      item.classList.toggle("active_block");
      const get_active_blocks = document.querySelectorAll(
        ".rates_container .option_sub .active_block"
      );
      const get_button = document.querySelector(".rates_container button");
      if (get_active_blocks.length >= 1) {
        get_button.classList.add("active");
      } else {
        get_button.classList.remove("active");
      }
      let resolt_formula = 300 * get_active_blocks.length;
      get_final_price.innerHTML = resolt_formula;
      get_final_applications.innerHTML = 8 * get_active_blocks.length;
      if (!item.className.includes("active_block")) {
        item.querySelector("input").checked = false;
        item
          .closest(".option_sub")
          .querySelectorAll("div")
          .forEach((item) => {
            item.classList.remove("none_click");
          });
        console.log(item);
        if (item.className.includes("special_choice")) {
          item
            .closest(".option_sub")
            .querySelectorAll("input")
            .forEach((item) => {
              item.checked = false;
            });
        }
      } else {
        if (item.className.includes("special_choice")) {
          item.querySelector("input").checked = true;
          item
            .closest(".option_sub")
            .querySelectorAll("input")
            .forEach((item) => {
              if (!item.closest("div").className.includes("special_choice")) {
                item.checked = true;
                //ДОДЕЛАТЬ!!!
                item
                  .closest(".option_sub")
                  .querySelectorAll("div")
                  .forEach((item) => {
                    if (!item.className.includes("special_choice")) {
                      item.classList.add("none_click");
                    }
                  });
              }
            });
        } else {
          item.querySelector("input").checked = true;
        }
      }
    });
  });
}
retes_price();
