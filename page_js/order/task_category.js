function task_category() {
  let href_temp = 0;
  const get_filter_link = document.querySelectorAll(".tasks_container .tasks a.filter_none");
  const get_link_sub = document.querySelectorAll(".tasks_container .make_order .link_sub");
  get_link_sub.forEach( (item) => {
    const get_links = item.querySelectorAll("a.medium_category");
    get_links.forEach( (item) => {
      if (item.innerHTML.length === 0){
        item.closest("div").remove();
      } else{
        if (item.closest(".final_filter_sub") === null){
          href_temp++;
          //item.href = "?medium_category=" + href_temp;
        }
      }
    });
  });
  if (get_filter_link.length >= 1){
    const get_tasks_category = document.querySelectorAll(".tasks_container .category b");
    const get_category_options = document.querySelectorAll(".tasks_container .make_order .link_part p");
    if (get_tasks_category.length >= 1){
      get_category_options.forEach( (item) => {
        if (item.innerHTML.trim() === get_tasks_category[0].innerHTML.trim()){
          const parent = item.closest("div");
          const get_sub = parent.querySelector(".link_sub");
          item.style.color = "rgb(79, 130, 3)";
          item.style.fontWeight = 700;
          get_sub.style.display = "grid";
        }
      });
    }
  }
  //medium_category
  const get_medium_category_number = document.querySelector(".tasks_container .medium_category_number");
  const resolt_number = get_medium_category_number.textContent.replace(/\s+/g, '');
  if (!/^\s*$/.test(resolt_number)){
    const get_order = document.querySelectorAll(".tasks_container .category b");
    const get_category_name = document.querySelectorAll(".tasks_container .make_order .link_part p");
    const get_medium_number = document.querySelector("p.medium_number").innerHTML;
    const medium_number_convert = parseInt(get_medium_number, 10);
    if (get_order.length >= 1){
      get_category_name.forEach( (item) => {
        if (item.innerHTML.includes(get_order[0].innerHTML.trim())){
          const parent = item.closest("div");
          const get_sub = parent.querySelector(".link_sub");
          const get_medium_sub = document.querySelectorAll(".tasks_container .final_filter_sub")
          item.style.color = "rgb(79, 130, 3)";
          item.style.fontWeight = 700;
          get_sub.style.display = "grid";
          get_medium_sub[medium_number_convert].style.display = "grid";
        }
      });
    }
  }
  //final_category
  const get_final_category_number = document.querySelector(".tasks_container .final_number");
  if (get_final_category_number !== null){
    const final_number = parseInt(get_final_category_number.innerHTML, 10) - 1;
    const get_final_link = document.querySelectorAll(".tasks_container .link_sub .final_filter_sub a")[final_number];
    get_final_link.closest(".link_sub").style.display = "grid";
    get_final_link.closest(".final_filter_sub").style.display = "grid";
    get_final_link.classList.add("active");
  }
  function save_category() {
    const get_save_icon = document.querySelector(".tasks_container .icon_options .icon");
    let save_temp = localStorage.getItem("save_temp") || 0;
    let isSaved = localStorage.getItem("isSaved") === "true" || false;
  
    function updateUI() {
      if (isSaved) {
        get_save_icon.classList.add("save");
        const get_input = get_save_icon.querySelector("input.filter_save");
        get_input.value = window.location.href;
        get_save_icon.querySelector(".icon_svg").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"/></svg>`;
      }
    }
    updateUI();
    get_save_icon.addEventListener("click", function () {
      if (!isSaved) {
        save_temp++;
        if (save_temp === 1) {
          setTimeout(() => { alert("Фильтр сохранён"); }, 500);
        }
        isSaved = true;
        localStorage.setItem("isSaved", "true");
        localStorage.setItem("save_temp", save_temp);
      } else {
        isSaved = false;
        localStorage.setItem("isSaved", "false");
        localStorage.removeItem("save_temp");
      }
      updateUI();
    });
  }
  //save_category();  
}
window.addEventListener("DOMContentLoaded", function (){
  task_category();
});