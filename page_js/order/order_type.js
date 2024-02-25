//order_type
function order_type() {
  function order_choice() {
    let click_temp = 0;
    const get_icon = document.querySelector(
      ".tasks_container .icon_options .order_filter svg"
    );
    get_icon.addEventListener("click", function () {
      click_temp++;
      this.classList.toggle("active");
      const get_menu = this.closest(".order_filter").querySelector(".type_sub");
      if (click_temp === 1) {
        get_menu.style.display = "block";
        setTimeout(() => {
          get_menu.classList.add("type_sub_active");
        }, 100);
      } else {
        get_menu.classList.remove("type_sub_active");
        setTimeout(() => {
          get_menu.style.display = "none";
        }, 500);
        click_temp = 0;
      }
    });
  }
  order_choice();
  const get_type_option = document.querySelector(
    ".tasks_container p.type_option"
  );
  const get_order_types = document.querySelectorAll(
    ".tasks_container .orders p.type"
  );
  get_order_types.forEach((item) => {
    if (item.innerHTML.trim() !== get_type_option.innerHTML.trim()) {
      item.closest(".order").remove();
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    let active_temp = 0;
    const get_content = document.querySelector(".content");
    const get_links = document.querySelectorAll(".links_wrapper a");
    const get_subs = document.querySelectorAll(".link_sub");
    const get_loading = document.querySelector(".overlay");
    let sub_heights = [];
    for (
      let i = 0;
      i < document.querySelectorAll(".main_category").length;
      i++
    ) {
      document.querySelectorAll(".main_category")[i].id = i;
    }
    get_subs.forEach((item) => {
      sub_heights.push(item.offsetHeight + "px");
      item.classList.remove("sub_active");
    });

    window.addEventListener("load", function () {
      get_subs.forEach((item) => {
        item.style.transition = "0.5s";
        if (item.offsetHeight >= 1) {
          item.classList.add("sub_active");
        }
      });
    });

    const load_page = (url) => {
      fetch(url)
        .then((response) => response.text())
        .then((html) => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");
          const new_content = doc.querySelector(".content").innerHTML;
          get_content.innerHTML = new_content;
          setTimeout(() => {
            history.pushState({}, "", url);
            get_content.style.visibility = "unset";
            get_loading.classList.remove("overlay_active");
          }, 200);
        });
    };

    get_links.forEach((item) => {
      item.addEventListener("click", (e) => {
        if (!item.parentNode.className.includes("none_use")) {
          const get_link_name = document.querySelectorAll(
            ".tasks_container .make_order .link_part p"
          );
          if (item.parentNode.parentNode.className.includes("link_part")) {
            const get_filter_none_link = document.querySelector(
              ".tasks_container .tasks a.filter_none"
            );
            get_filter_none_link.style.visibility = "unset";
            setTimeout(() => {
              get_filter_none_link.style.opacity = 1;
            }, 500);
          }
          if (!item.closest("div").className.includes("reaload_icon")) {
            get_link_name.forEach((item) => {
              item.classList.remove("active");
            });
          } else {
            const get_active_menus = document.querySelectorAll(
              ".tasks_container .make_order .link_part p"
            );
            get_active_menus.forEach((item) => {
              if (item.className.includes("active")) {
                setTimeout(() => {
                  item
                    .closest("div")
                    .querySelector(".link_sub")
                    .classList.add("sub_active");
                }, 1);
              }
            });
          }
          if (item.querySelectorAll("p").length !== 0) {
            item.querySelector("p").classList.add("active");
          }
          get_content.style.visibility = "hidden";
          setTimeout(() => {
            get_loading.classList.add("overlay_active");
          }, 50);
          e.preventDefault();
          const url = e.currentTarget.getAttribute("href");
          load_page(url);
          //menu_open
          if (item.className.includes("main_category")) {
            get_subs.forEach((item) => {
              item.classList.remove("sub_active");
            });
          }
          if (
            !item.className.includes("filter_none") &&
            !item.closest("div").className.includes("reaload_icon")
          ) {
            try {
              get_subs[item.id].classList.add("sub_active");
            } catch (e) {
              const get_final_subs = document.querySelectorAll(
                ".tasks_container .final_filter_sub"
              );
              get_final_subs.forEach((item) => {
                item.classList.remove("sub_active");
              });
              try {
                item.parentNode
                  .querySelector(".final_filter_sub")
                  .classList.add("sub_active");
              } catch (e) {
                item.parentNode.classList.add("sub_active");
              }
            }
          } else if (item.className.includes("filter_none")) {
            const get_active_subs = document.querySelectorAll(
              ".tasks_container .make_order .sub_active"
            );
            item.removeAttribute("style");
            get_active_subs.forEach((item) => {
              item.classList.remove("sub_active");
            });
          }
          console.log(item);
          //category_reaload
          const get_reload_icon = document.querySelector(".reaload_icon a");
          get_reload_icon.href = url;

          const get_active_menu = document.querySelectorAll(
            ".tasks_container .make_order .link_part p"
          );
          get_active_menu.forEach((item) => {
            if (item.hasAttribute("style")) {
              active_temp++;
              if (active_temp >= 1) {
                item.removeAttribute("style");
              }
            }
          });
        }
      });
    });
  });
}
order_type();
