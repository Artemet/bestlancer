//icon_choice
function icon_choice() {
  //delite_notification_script
  let active_bin_choice = false;
  const get_bin_icon = document.querySelector(".delite_icon svg");
  get_bin_icon.addEventListener("click", function () {
    const get_checkbox = document.querySelectorAll(
      ".notification_container .notification input.checkbox"
    );
    const get_wrapper = document.querySelectorAll(".notification_wrapper");
    document
      .querySelector(".notification_container .delite_number")
      .classList.toggle("delite_number_active");
    this.classList.toggle("active");
    if (this.className.animVal.includes("active")) {
      active_bin_choice = true;
    } else {
      active_bin_choice = false;
      document
        .querySelectorAll(".notification_container .notification")
        .forEach((item) => {
          item.classList.remove("notification_active");
        });
    }
    get_checkbox.forEach((item) => {
      item.classList.toggle("checkbox_active");
    });
    get_wrapper.forEach((item) => {
      item.parentNode.classList.toggle("notification_choice");
      item.classList.toggle("notification_wrapper_block");
    });
    checkbox_check();
  });
  //checkbox_choice
  let deleting_arr = [];
  const get_notififcations = document.querySelectorAll(
    ".notification_container .notification"
  );
  get_notififcations.forEach((item) => {
    item.addEventListener("click", function () {
      if (item.className.includes("notification_choice")) {
        item.classList.toggle("choice_notification");
      }
      if (active_bin_choice === true) {
        const get_checkbox = item.querySelector("input.checkbox");
        const get_choice_number = document.querySelector(
          ".notification_container .delite_number b"
        );
        get_checkbox.classList.toggle("checked");
        if (!get_checkbox.className.includes("checked")) {
          let array_index = -1;
          const notification_id = parseInt(item.id, 10);
          while (true) {
            array_index++;
            if (notification_id === deleting_arr[array_index]) {
              break;
            }
            if (array_index >= deleting_arr.length) {
              break;
            }
          }
          deleting_arr.splice(array_index, 1);
          get_checkbox.checked = false;
        } else {
          deleting_arr.push(parseInt(item.id, 10));
          get_checkbox.checked = true;
        }
        get_choice_number.innerHTML =
          document.querySelectorAll("input.checked").length;
      }
      checkbox_check();
    });
  });
  const get_delete_button = document.querySelector(
    ".notification_container .delite_number button"
  );
  get_delete_button.addEventListener("click", function () {
    const get_choice_number = document.querySelector(
      ".notification_container .delite_number b"
    );
    get_choice_number.innerHTML = 0;
    this.classList.remove("active");
    get_notififcations.forEach((item) => {
      const ckeckbox_choice = item.querySelector("input");
      if (ckeckbox_choice.checked === true) {
        if (
          item.className.includes("execution") &&
          item.className.includes("choice_notification")
        ) {
          alert("Выбирите действие для заказа!");
          throw new Error("Выбирите действие для заказа!");
        }
      }
    });
    $.ajax({
      method: "POST",
      url: "../bd_send/notification/notification_delete.php",
      data: { notification_arr: deleting_arr },
    }).done(function () {
      for (let i = 0; i < get_notififcations.length; i++) {
        const notification_id = parseInt(get_notififcations[i].id, 10);
        if (deleting_arr.includes(notification_id)) {
          get_notififcations[i].remove();
        }
      }
      const notifications_length = document.querySelectorAll(
        ".notifications_wrapper .notification"
      ).length;
      if (notifications_length === 0) {
        document.querySelector(".content").innerHTML =
          '<div class="notifications_wrapper"><p>Нет увидомлений</p></div>';
      }
    });
  });
  //checkbox_check
  function checkbox_check() {
    let checkbox_include = false;
    const get_checkbox = document.querySelectorAll(
      ".notification_container .notification input.checkbox"
    );
    const get_button = document.querySelector(
      ".notification_container .delite_number button"
    );
    for (let i = 0; i < get_checkbox.length; i++) {
      const checkbox_status = get_checkbox[i].checked;
      if (checkbox_status === true) {
        checkbox_include = true;
      }
    }
    if (checkbox_include === true) {
      get_button.classList.add("active");
    } else {
      get_button.classList.remove("active");
    }
  }
}
icon_choice();

function page_choice() {
  const get_content = document.querySelector(".content");
  const get_links = document.querySelectorAll(
    ".notification_container .pagination a"
  );

  for (let i = 0; i < get_links.length; i++) {
    get_links[i].id = i;
  }

  const load_page = (url) => {
    fetch(url)
      .then((response) => response.text())
      .then((html) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, "text/html");
        const new_content = doc.querySelector(".content");
        if (new_content) {
          get_content.innerHTML = new_content.innerHTML;
          history.pushState({}, "", url);
        } else {
          console.error("Content not found in the loaded page.");
        }
      })
      .catch((error) => {
        console.error("Error loading page:", error);
      });
  };

  const setupEventListeners = () => {
    const updated_links = document.querySelectorAll(
      ".notification_container .pagination a"
    );
    updated_links.forEach((item) => {
      item.addEventListener("click", (e) => {
        e.preventDefault();
        const url = e.currentTarget.getAttribute("href");
        load_page(url);
      });
    });
  };

  setupEventListeners();

  get_links.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const item_id = parseInt(item.id, 10);
      const get_active_page = document.querySelectorAll(
        ".notification_container .pagination b"
      )[0];
      const get_links = document.querySelectorAll(
        ".notification_container .pagination a"
      );
      let get_page = parseInt(document.querySelector("p.page").innerHTML, 10);
      const page_convery = parseInt(get_active_page.innerHTML, 10);
      const url = e.currentTarget.getAttribute("href");
      load_page(url);
      if (item_id === 1) {
        get_active_page.innerHTML = page_convery + 1;
        get_links[0].href = "?page=" + get_page;
        get_page += 2;
        get_links[1].href = "?page=" + get_page;
      } else if (item_id === 0) {
        get_active_page.innerHTML = page_convery - 1;
        get_links[1].href = "?page=" + get_page;
        get_page -= 2;
        get_links[0].href = "?page=" + get_page;
      }
      if (get_page + 1 === 1) {
        get_links[0].classList.add("none_active");
        get_links[1].classList.remove("none_active");
      } else if (
        get_page - 1 ===
        parseInt(
          document
            .querySelector(".notification_container .pagination b.end_page")
            .innerHTML.trim(),
          10
        )
      ) {
        get_links[0].classList.remove("none_active");
        get_links[1].classList.add("none_active");
      } else {
        get_links.forEach((item) => {
          item.classList.remove("none_active");
        });
      }
    });
  });
}

window.addEventListener("DOMContentLoaded", function () {
  page_choice();
});
