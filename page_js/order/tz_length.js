//tz_length
const max_tz_length = 230;
let tz_text = [];
let foreach_temp = 0;
let show_temp = 0;
const get_tz = document.querySelectorAll(".orders .order p.user_order_tz");
get_tz.forEach( (item) => {
  foreach_temp++;
  if (item.querySelectorAll("a.more_tz_link") <= 1){
    tz_text.push(item.innerHTML);
    console.log(tz_text);
  }
  let show_back_click = false;
  function tz_length() {
    if (item.innerHTML.length > max_tz_length) {
      show_more_element();
    }
  }
  
  tz_length();
  function show_more_element() {
    const shortenedText = item.innerHTML.substring(0, max_tz_length) + '...';
    item.innerHTML = shortenedText;
    const tz_link = item.closest(".order_part").querySelector("a.order_page_link").href;
    const create_link = document.createElement("a");
    create_link.classList = "more_tz_link";
    create_link.href = tz_link;
    create_link.innerHTML = "Показать";
    item.appendChild(create_link);
    function hide_more_element() {
      if (show_back_click === true){
        const get_back_link = document.querySelector(".orders .order a.more_tz_link");
        get_back_link.addEventListener("click", function (){
          show_more_element();
        });
      }
    }
  }
});
const links = document.querySelectorAll(".more_tz_link");
const links_length = links.length;
for (let i = 0; i < links_length; i++){
  links[i].id = i;
}