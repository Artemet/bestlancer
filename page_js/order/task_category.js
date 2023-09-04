function task_category() {
  let clickedCategoryNumber = -1;
  const get_warning = document.querySelector(".tasks_container p.no_orders");
  const get_categorys = document.querySelectorAll(".tasks_container .make_order .link_part p");
  const get_orders_block = document.querySelector(".tasks_container .orders");
  const get_orders = document.querySelectorAll(".orders .order");
  const savedClickedCategory = localStorage.getItem('clicked_category');
  if (savedClickedCategory !== null) {
    clickedCategoryNumber = parseInt(savedClickedCategory);
  }

  function displayTasksFromTop() {
    const ordersContainer = document.querySelector('.orders');
    const tempContainer = document.createElement('div');
    let allOrdersHidden = true;
    for (let i = get_orders.length - 1; i >= 0; i--) {
      if (get_orders[i].style.display !== 'none') {
        allOrdersHidden = false;
      }
      tempContainer.appendChild(get_orders[i]);
    }
    ordersContainer.innerHTML = '';
    ordersContainer.appendChild(tempContainer);
    ordersContainer.style.flexDirection = 'column';

    if (allOrdersHidden) {
      get_warning.style.display = 'block';
    } else {
      get_warning.style.display = 'none';
    }
  }

  displayTasksFromTop();

  for (let i = 0; i < get_categorys.length; i++) {
    get_categorys[i].classList.add(i);
    get_categorys[i].addEventListener("click", function () {
      if (clickedCategoryNumber >= 0) {
        get_categorys[clickedCategoryNumber].classList.remove("click");
      }
      this.classList.add("click");
      clickedCategoryNumber = i;

      const category_text = this.innerHTML;
      get_orders.forEach(item => {
        if (!item.innerHTML.includes(category_text)) {
          item.style.display = "none";
        } else {
          item.style.display = "grid";
        }
      });
      localStorage.setItem('clicked_category', clickedCategoryNumber);
      displayTasksFromTop();
    });

    if (i === clickedCategoryNumber) {
      get_categorys[i].classList.add("click");
      const category_text = get_categorys[i].innerHTML;
      get_orders.forEach(item => {
        if (!item.innerHTML.includes(category_text)) {
          item.style.display = "none";
        } else {
          item.style.display = "grid";
        }
      });
    }
  }

  get_categorys[get_categorys.length - 1].addEventListener("click", function () {
    get_orders.forEach(item => {
      item.style.display = "grid";
    });
    displayTasksFromTop();
  });

  if (clickedCategoryNumber === -1) {
    get_categorys[get_categorys.length - 1].click();
    displayTasksFromTop();
  }

  const get_order_links = document.querySelectorAll(".tasks_container .category b");
  get_order_links.forEach((item) => {
    item.addEventListener("click", function () {
      let order_text = item.innerHTML;
      const get_categorys = document.querySelectorAll(".tasks_container .make_order .link_part p");
      get_categorys.forEach((item) => {
        if (item.innerHTML === order_text) {
          item.click();
        }
      });
    });
  });
  const get_thirst_click = document.querySelector(".tasks_container .make_order .link_part p.click");
  get_thirst_click.click();
}

task_category();
