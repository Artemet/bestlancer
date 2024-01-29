//category_choice
function category_choice(){
    const get_links = document.querySelectorAll("a.filter_link");
    const get_content = document.querySelector(".content");
    const get_overlay = document.querySelector(".overlay");
    const load_page = (url) => {
        fetch(url)
          .then(response => response.text())
          .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const new_content = doc.querySelector(".content").innerHTML;
            get_content.innerHTML = new_content;
            setTimeout( () => {
                history.pushState({}, '', url);
                get_content.classList.remove("service_container_none");
                get_overlay.classList.remove("overlay_active");
            }, 200);
        })
    };
    get_links.forEach( (item) => {
        item.addEventListener("click", (e) => {
            get_content.classList.add("service_container_none");
            get_overlay.classList.add("overlay_active");
            e.preventDefault();
            const url = e.currentTarget.getAttribute('href');
            load_page(url);
        });
    });
}
category_choice();