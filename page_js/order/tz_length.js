//tz_length
const max_tz_length = 270;
const get_tz = document.querySelector(".orders .order p.user_order_tz");
function tz_length() {
  if (get_tz.innerHTML.length > max_tz_length) {
    show_more_element();
  }
}

tz_length();
function show_more_element() {
  const shortenedText = get_tz.innerHTML.substring(0, max_tz_length) + '...';
  get_tz.innerHTML = shortenedText;

  const create_link = document.createElement("a");
  create_link.href = "#";
  create_link.classList = "more_tz_link";
  create_link.innerHTML = "Показать";
  get_tz.appendChild(create_link);
}